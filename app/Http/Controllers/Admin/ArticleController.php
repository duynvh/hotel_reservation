<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/19/18
 * Time: 13:54
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    private $articleService;
    private $_limit = 15;

    public function __construct(ArticleService $articleService) {
        $this->articleService = $articleService;
        $this->_limit = env('LIMIT_SHOW_LIST', $this->_limit);
    }

    public function index(Request $request) {
        $params_default = array('q' => '', 'status' => 'all', 'category_article_id' => 0);
        $params = array_merge($params_default, $request->all());

        // Set page
        $page = intval($request->get('page', 1));
        $page = ($page > 0) ? $page : 1;
        $offSet = ($page - 1) * $this->_limit;
        $offSet = ($offSet > 0) ? $offSet : 0;

        // Load Data
        $paramsModel = array(
            'q' => $params['q'],
            'status' => $params['status'],
            'category_article_id' => (int)$params['category_article_id'],
            'offset' => $offSet,
            'limit' => intval($this->_limit)
        );
        $variables = $this->articleService->index($paramsModel);

        // Pagination
        $paginator = new LengthAwarePaginator(array(), count($variables['dataAll']), $this->_limit, $page);
        $params_url = array(
            'q' => $params['q'],
            'status' => $params['status'],
            'category_article_id' => (int)$params['category_article_id']
        );
        foreach ($params_url as $k => $v) {
            if ($v == '') unset($params_url[$k]);
        }
        $paginator->setPath('/admin/article?' . http_build_query($params_url));
        return view('admin.pages.article.index', [
            'articles'  => $variables['data'],
            'dataHidden' => $variables['dataAllHidden'],
            'paginator' => $paginator,
            'categories'    => $variables['categories']
        ]);
    }

    public function indexConfirm(Request $request) {
        $params_default = array('q' => '', 'confirm_action' => 'all', 'category_article_id' => 0);
        $params = array_merge($params_default, $request->all());

        // Set page
        $page = intval($request->get('page', 1));
        $page = ($page > 0) ? $page : 1;
        $offSet = ($page - 1) * $this->_limit;
        $offSet = ($offSet > 0) ? $offSet : 0;

        // Load Data
        $paramsModel = array(
            'q' => $params['q'],
            'confirm_action' => $params['confirm_action'],
            'category_article_id' => (int)$params['category_article_id'],
            'offset' => $offSet,
            'limit' => intval($this->_limit)
        );
        $variables = $this->articleService->indexConfirm($paramsModel);

        // Pagination
        $paginator = new LengthAwarePaginator(array(), count($variables['dataAll']), $this->_limit, $page);
        $params_url = array(
            'q' => $params['q'],
            'confirm_action' => $params['confirm_action'],
            'category_article_id' => (int)$params['category_article_id']
        );
        foreach ($params_url as $k => $v) {
            if ($v == '') unset($params_url[$k]);
        }
        $paginator->setPath('/admin/article?' . http_build_query($params_url));
        return view('admin.pages.article.index_confirm', [
            'articles'  => $variables['data'],
            'paginator' => $paginator,
            'categories'    => $variables['categories']
        ]);
    }

    public function viewConfirm($id)
    {
        $this->authorize('admin');
        $variables = $this->articleService->editConfirm($id);

        return view('admin.pages.article.viewConfirm', [
            'infoBasic' => $variables['infoBasic'],
            'data' => $variables['data'],
            'dataNew' => $variables['dataNew'],
            'categories' => $variables['categories'],
        ]);
    }

    public function updateConfirmCancel(Request $request, $id)
    {
        $this->authorize('admin');
        return $this->articleService->updateConfirmCancel($request, $id);
    }

    public function updateConfirmApply(Request $request, $id)
    {
        $this->authorize('admin');
        return $this->articleService->updateConfirmApply($request, $id);
    }

    public function create() {
        $this->authorize('add');
        $variables = $this->articleService->create();
        return view('admin.pages.article.create', [
            'categories'    => $variables['categories']
        ]);
    }

    public function store(ArticleRequest $request) {
        return $this->articleService->store($request);
    }

    public function edit($id) {
        $variables = $this->articleService->edit($id);
        return view('admin.pages.article.edit', [
            'infoBasic'     => $variables['infoBasic'],
            'data'      => $variables['data'],
            'categories'    => $variables['categories']
        ]);
    }

    public function update(ArticleRequest $request, $id) {
        $this->authorize('edit');
        return $this->articleService->update($request, $id);
    }

    public function delete(Request $request) {
        $this->authorize('delete');
        return $this->articleService->delete($request);
    }

    public function changeStatus(Request $request) {
        $this->authorize('edit');
        return $this->articleService->changeStatus($request);
    }
}