<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/17/18
 * Time: 13:54
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CategoryProductService;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryProductRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryProductController extends Controller
{
    private $categoryProductService;
    private $_limit = 15;

    public function __construct(CategoryProductService $categoryProductService) {
        $this->categoryProductService = $categoryProductService;
        $this->_limit = env('LIMIT_SHOW_LIST', $this->_limit);
    }

    public function index(Request $request) {
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
        $variables = $this->categoryProductService->index($paramsModel);

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

        return view('admin.pages.category-product.index', [
            'categories'    => $variables['data'],
            'dataHidden' => $variables['dataAllHidden'],
            'paginator'     => $paginator
        ]);
    }

    public function indexConfirm(Request $request) {
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
        $variables = $this->categoryProductService->indexConfirm($paramsModel);

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

        return view('admin.pages.category-product.index_confirm', [
            'categories'    => $variables['data'],
            'paginator'     => $paginator
        ]);
    }

    public function viewConfirm($id)
    {
        $this->authorize('admin');
        $variables = $this->categoryProductService->editConfirm($id);
        return view('admin.pages.category-product.viewConfirm', [
            'infoBasic' => $variables['infoBasic'],
            'data' => $variables['data'],
            'dataNew' => $variables['dataNew'],
            'category' => $variables['category'],
        ]);
    }

    public function updateConfirmCancel(Request $request, $id)
    {
        $this->authorize('admin');
        return $this->categoryProductService->updateConfirmCancel($request, $id);
    }

    public function updateConfirmApply(Request $request, $id)
    {
        $this->authorize('admin');
        return $this->categoryProductService->updateConfirmApply($request, $id);
    }

    public function create() {
        $this->authorize('add');
        $categories = $this->categoryProductService->create();
        return view('admin.pages.category-product.create', [
            'categories'        => $categories
        ]);
    }

    public function store(CategoryProductRequest $request) {
        return $this->categoryProductService->store($request);
    }

    public function edit($id) {
        $variables = $this->categoryProductService->edit($id);
        return view('admin.pages.category-product.edit', [
            'infoBasic'     => $variables['infoBasic'],
            'data'          => $variables['data'],
            'categories'    => $variables['categories'],
        ]);
    }

    public function update(CategoryProductRequest $request, $id) {
        $this->authorize('edit');
        return $this->categoryProductService->update($request, $id);
    }

    public function delete(Request $request) {
        $this->authorize('delete');
        return $this->categoryProductService->delete($request);
    }

    public function changeStatus(Request $request) {
        $this->authorize('edit');
        return $this->categoryProductService->changeStatus($request);
    }

    public function moveNode(Request $request){
        $this->authorize('edit');
        return $this->categoryProductService->moveNode($request);
    }
}