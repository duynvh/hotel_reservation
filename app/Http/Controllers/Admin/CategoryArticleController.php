<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/17/18
 * Time: 13:54
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CategoryArticleService;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryArticleRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryArticleController extends Controller
{
    private $categoryArticleService;
    private $_limit = 15;

    public function __construct(CategoryArticleService $categoryArticleService)
    {
        $this->categoryArticleService = $categoryArticleService;
        $this->_limit = env('LIMIT_SHOW_LIST', $this->_limit);
    }

    public function index(Request $request)
    {
        $params_default = array('q' => '', 'status' => 'all');
        $params = array_merge($params_default, $request->all());

        // Set page
        $page = intval($request->get('page', 1));
        $page = ($page > 0) ? $page : 1;
        $offSet = ($page - 1) * $this->_limit;
        $offSet = ($offSet > 0) ? $offSet : 0;

        // Load Data
        $paramsModel = array(
            'q' => !empty($params['q']) ? $params['q'] : '',
            'status' => !empty($params['status']) ? $params['status'] : '',
            'offset' => $offSet,
            'limit' => intval($this->_limit)
        );
        $variables = $this->categoryArticleService->index($paramsModel);

        // Pagination
        $paginator = new LengthAwarePaginator(array(), count($variables['dataAll']), $this->_limit, $page);
        $params_url = array(
            'q' => ($params['q'] != '') ? (string)$params['q'] : '',
            'status' => ($params['status'] != '') ? (string)$params['status'] : '',
        );
        foreach ($params_url as $k => $v) {
            if ($v == '') unset($params_url[$k]);
        }
        $paginator->setPath('/admin/category-article?' . http_build_query($params_url));
        return view('admin.pages.category-article.index', [
            'categories' => $variables['data'],
            'dataHidden' => $variables['dataAllHidden'],
            'paginator' => $paginator
        ]);
    }

    public function indexConfirm(Request $request)
    {
        $params_default = array('q' => '', 'confirm_action' => 'all');
        $params = array_merge($params_default, $request->all());

        // Set page
        $page = intval($request->get('page', 1));
        $page = ($page > 0) ? $page : 1;
        $offSet = ($page - 1) * $this->_limit;
        $offSet = ($offSet > 0) ? $offSet : 0;

        // Load Data
        $paramsModel = array(
            'q' => !empty($params['q']) ? $params['q'] : '',
            'confirm_action' => !empty($params['confirm_action']) ? $params['confirm_action'] : '',
            'offset' => $offSet,
            'limit' => intval($this->_limit)
        );
        $variables = $this->categoryArticleService->indexConfirm($paramsModel);

        // Pagination
        $paginator = new LengthAwarePaginator(array(), count($variables['dataAll']), $this->_limit, $page);
        $params_url = array(
            'q' => ($params['q'] != '') ? (string)$params['q'] : '',
            'confirm_action' => ($params['confirm_action'] != '') ? (string)$params['confirm_action'] : '',
        );
        foreach ($params_url as $k => $v) {
            if ($v == '') unset($params_url[$k]);
        }
        $paginator->setPath('/admin/category-article?' . http_build_query($params_url));

        return view('admin.pages.category-article.index_confirm', [
            'categories' => $variables['data'],
            'paginator' => $paginator
        ]);
    }

    public function viewConfirm($id)
    {
        $this->authorize('admin');
        $variables = $this->categoryArticleService->editConfirm($id);
        return view('admin.pages.category-article.viewConfirm', [
            'infoBasic' => $variables['infoBasic'],
            'data' => $variables['data'],
            'dataNew' => $variables['dataNew'],
            'category' => $variables['category'],
        ]);
    }

    public function updateConfirmCancel(Request $request, $id)
    {
        $this->authorize('admin');
        return $this->categoryArticleService->updateConfirmCancel($request, $id);
    }

    public function updateConfirmApply(Request $request, $id)
    {
        $this->authorize('admin');
        return $this->categoryArticleService->updateConfirmApply($request, $id);
    }

    public function create()
    {
        $this->authorize('add');
        $categories = $this->categoryArticleService->create();
        return view('admin.pages.category-article.create', [
            'categories' => $categories
        ]);
    }

    public function store(CategoryArticleRequest $request)
    {
        return $this->categoryArticleService->store($request);
    }

    public function edit($id)
    {
        $variables = $this->categoryArticleService->edit($id);
        return view('admin.pages.category-article.edit', [
            'infoBasic' => $variables['infoBasic'],
            'data' => $variables['data'],
            'categories' => $variables['categories'],
        ]);
    }

    public function update(CategoryArticleRequest $request, $id)
    {
        $this->authorize('edit');
        return $this->categoryArticleService->update($request, $id);
    }

    public function delete(Request $request)
    {
        $this->authorize('delete');
        return $this->categoryArticleService->delete($request);
    }

    public function changeStatus(Request $request)
    {
        $this->authorize('edit');
        return $this->categoryArticleService->changeStatus($request);
    }

    public function moveNode(Request $request){
        $this->authorize('edit');
        return $this->categoryArticleService->moveNode($request);
    }
}