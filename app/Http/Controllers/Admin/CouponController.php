<?php
/**
 * Created by PhpStorm.
 * coupon: macos
 * Date: 10/7/18
 * Time: 00:15
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CouponService;
use App\Http\Requests\CouponRequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CouponController extends Controller
{
    private $couponService;
    private $_limit = 15;

    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
        $this->_limit = env('LIMIT_SHOW_LIST', $this->_limit);
    }

    public function index(Request $request)
    {
        $params_default = array('q' => '', 'status' => 'all', 'amount_type' => 'all');
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
            'amount_type' => !empty($params['amount_type']) ? $params['amount_type'] : '',
            'offset' => $offSet,
            'limit' => intval($this->_limit)
        );
        $variables = $this->couponService->index($paramsModel);
        // Pagination
        $paginator = new LengthAwarePaginator(array(), count($variables['dataAll']), $this->_limit, $page);
        $params_url = array(
            'q' => ($params['q'] != '') ? (string)$params['q'] : '',
            'status' => ($params['status'] != '') ? (string)$params['status'] : '',
        );
        foreach ($params_url as $k => $v) {
            if ($v == '') unset($params_url[$k]);
        }
        $paginator->setPath('/admin/group?' . http_build_query($params_url));

        return view('admin.pages.coupon.index', [
            'coupons' => $variables['data'],
            'dataHidden' => $variables['dataAllHidden'],
            'paginator' => $paginator
        ]);
    }

    public function indexConfirm(Request $request)
    {
        $params_default = array('q' => '', 'confirm_action' => 'all', 'amount_type' => 'all');
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
            'amount_type' => !empty($params['amount_type']) ? $params['amount_type'] : '',
            'offset' => $offSet,
            'limit' => intval($this->_limit)
        );
        $variables = $this->couponService->indexConfirm($paramsModel);
        // Pagination
        $paginator = new LengthAwarePaginator(array(), count($variables['dataAll']), $this->_limit, $page);
        $params_url = array(
            'q' => ($params['q'] != '') ? (string)$params['q'] : '',
            'confirm_action' => ($params['confirm_action'] != '') ? (string)$params['confirm_action'] : '',
        );
        foreach ($params_url as $k => $v) {
            if ($v == '') unset($params_url[$k]);
        }
        $paginator->setPath('/admin/group?' . http_build_query($params_url));

        return view('admin.pages.coupon.index_confirm', [
            'coupons' => $variables['data'],
            'paginator' => $paginator
        ]);
    }

    public function viewConfirm($id)
    {
        $this->authorize('admin');
        $variables = $this->couponService->editConfirm($id);
        return view('admin.pages.coupon.viewConfirm', [
            'infoBasic' => $variables['infoBasic'],
            'data' => $variables['data'],
            'dataNew' => $variables['dataNew'],
        ]);
    }


    public function updateConfirmCancel(Request $request, $id)
    {
        $this->authorize('admin');
        return $this->couponService->updateConfirmCancel($request, $id);
    }

    public function updateConfirmApply(Request $request, $id)
    {
        $this->authorize('admin');
        return $this->couponService->updateConfirmApply($request, $id);
    }

    public function create()
    {
        $this->authorize('add');
        return view('admin.pages.coupon.create');
    }

    public function store(CouponRequest $request)
    {
        return $this->couponService->store($request);
    }

    public function edit($id)
    {
        $variables = $this->couponService->edit($id);
        return view('admin.pages.coupon.edit', [
            'infoBasic' => $variables['infoBasic'],
            'data' => $variables['data'],
        ]);
    }

    public function update(CouponRequest $request, $id)
    {
        $this->authorize('edit');
        return $this->couponService->update($request, $id);
    }

    public function delete(Request $request)
    {
        $this->authorize('delete');
        return $this->couponService->delete($request);
    }

    public function changeStatus(Request $request)
    {
        $this->authorize('edit');
        return $this->couponService->changeStatus($request);
    }
}