<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/19/18
 * Time: 13:54
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
    private $productService;
    private $_limit = 15;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
        $this->_limit = env('LIMIT_SHOW_LIST', $this->_limit);
    }

    public function index(Request $request)
    {
        $params_default = array('q' => '', 'status' => 'all', 'category_product_id' => 0);
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
            'category_product_id' => (int)$params['category_product_id'],
            'offset' => $offSet,
            'limit' => intval($this->_limit)
        );
        $variables = $this->productService->index($paramsModel);
        // Pagination
        $paginator = new LengthAwarePaginator(array(), count($variables['dataAll']), $this->_limit, $page);
        $params_url = array(
            'q' => $params['q'],
            'status' => $params['status'],
            'category_product_id' => (int)$params['category_product_id']
        );
        foreach ($params_url as $k => $v) {
            if ($v == '') unset($params_url[$k]);
        }
        $paginator->setPath('/admin/product?' . http_build_query($params_url));
        return view('admin.pages.product.index', [
            'products' => $variables['data'],
            'dataHidden' => $variables['dataAllHidden'],
            'paginator' => $paginator,
            'categories' => $variables['categories']
        ]);
    }

    public function indexConfirm(Request $request)
    {
        $params_default = array('q' => '', 'confirm_action' => 'all', 'category_product_id' => 0);
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
            'category_product_id' => (int)$params['category_product_id'],
            'offset' => $offSet,
            'limit' => intval($this->_limit)
        );
        $variables = $this->productService->indexConfirm($paramsModel);
        // Pagination
        $paginator = new LengthAwarePaginator(array(), count($variables['dataAll']), $this->_limit, $page);
        $params_url = array(
            'q' => $params['q'],
            'confirm_action' => $params['confirm_action'],
            'category_product_id' => (int)$params['category_product_id']
        );
        foreach ($params_url as $k => $v) {
            if ($v == '') unset($params_url[$k]);
        }
        $paginator->setPath('/admin/user?' . http_build_query($params_url));

        return view('admin.pages.product.index_confirm', [
            'products' => $variables['data'],
            'paginator' => $paginator,
            'categories' => $variables['categories']
        ]);
    }

    public function create()
    {
        $this->authorize('add');

        $variables = $this->productService->create();
        return view('admin.pages.product.create', [
            'categories' => $variables['categories']
        ]);
    }

    public function store(ProductRequest $request)
    {
        return $this->productService->store($request);
    }

    public function edit($id)
    {
        $variables = $this->productService->edit($id);
        return view('admin.pages.product.edit', [
            'infoBasic' => $variables['infoBasic'],
            'data' => $variables['data'],
            'image_detail' => $variables['image_detail'],
            'categories' => $variables['categories']
        ]);
    }

    public function update(ProductRequest $request, $id)
    {
        $this->authorize('edit');
        return $this->productService->update($request, $id);
    }

    public function delete(Request $request)
    {
        $this->authorize('delete');
        return $this->productService->delete($request);
    }

    public function changeStatus(Request $request)
    {
        $this->authorize('edit');
        return $this->productService->changeStatus($request);
    }

    public function setRemoveImageDetail(Request $request)
    {
        $this->authorize('edit');
        return $this->productService->setArrayImageRemove($request);
    }

    public function viewConfirm($id)
    {
        $this->authorize('admin');
        $variables = $this->productService->editConfirm($id);

        return view('admin.pages.product.viewConfirm', [
            'infoBasic' => $variables['infoBasic'],
            'data' => $variables['data'],
            'dataNew' => $variables['dataNew'],
            'categories' => $variables['categories'],
            'image_detail' => $variables['image_detail'],
            'image_detail_new' => $variables['image_detail_new'],
        ]);
    }

    public function updateConfirmCancel(Request $request, $id)
    {
        $this->authorize('admin');
        return $this->productService->updateConfirmCancel($request, $id);
    }

    public function updateConfirmApply(Request $request, $id)
    {
        $this->authorize('admin');
        return $this->productService->updateConfirmApply($request, $id);
    }
}