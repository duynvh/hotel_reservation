<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/7/18
 * Time: 00:15
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BillRequest;
use App\Services\BillService;
use App\Services\CouponService;
use App\Http\Requests\CouponRequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class BillController extends Controller
{
    private $billService;
    private $_limit = 15;

    public function __construct(BillService $billService) {
        $this->billService = $billService;
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
            'amount_type' => !empty($params['amount_type']) ? $params['amount_type'] : '',
            'offset' => $offSet,
            'limit' => intval($this->_limit)
        );
        $variables = $this->billService->index($paramsModel);

        // Pagination
        $paginator = new LengthAwarePaginator(array(), count($variables['dataAll']), $this->_limit, $page);
        $params_url = array(
            'q' => ($params['q'] != '') ? (string)$params['q'] : '',
            'status' => ($params['status'] != '') ? (string)$params['status'] : '',
        );
        foreach ($params_url as $k => $v) {
            if ($v == '') unset($params_url[$k]);
        }
        $paginator->setPath('/admin/bill?' . http_build_query($params_url));
        return view('admin.pages.bill.index', [
            'bills'  => $variables['data'],
            'paginator' => $paginator
        ]);
    }

    public function create() {

    }

    public function store(CouponRequest $request) {

    }

    public function edit($id) {
        $variables = $this->billService->edit($id);
        return view('admin.pages.bill.edit', [
            'infoBasic'     => $variables['infoBasic'],
            'data'      => $variables['data'],
            'dataDetail'      => $variables['dataDetail'],
        ]);
    }

    public function update(BillRequest $request, $id) {
        $this->authorize('admin');
        return $this->billService->update($request, $id);
    }

    public function delete(Request $request) {
        $this->authorize('edit');
        return $this->billService->delete($request);
    }

    public function changeStatus(Request $request) {
        $this->authorize('edit');
        return $this->billService->changeStatus($request);
    }
}