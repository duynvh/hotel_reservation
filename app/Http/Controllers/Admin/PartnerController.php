<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/7/18
 * Time: 00:15
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerRequest;
use App\Services\PartnerService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PartnerController extends Controller
{
    private $partnerService;
    private $_limit = 15;

    public function __construct(PartnerService $partnerService) {
        $this->partnerService = $partnerService;
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
        $variables = $this->partnerService->index($paramsModel);

        // Pagination
        $paginator = new LengthAwarePaginator(array(), count($variables['dataAll']), $this->_limit, $page);
        $params_url = array(
            'q' => ($params['q'] != '') ? (string)$params['q'] : '',
            'status' => ($params['status'] != '') ? (string)$params['status'] : '',
        );
        foreach ($params_url as $k => $v) {
            if ($v == '') unset($params_url[$k]);
        }
        $paginator->setPath('/admin/partner?' . http_build_query($params_url));
        return view('admin.pages.partner.index', [
            'partners'  => $variables['data'],
            'dataHidden' => $variables['dataAllHidden'],
            'paginator' => $paginator
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
        $variables = $this->partnerService->indexConfirm($paramsModel);

        // Pagination
        $paginator = new LengthAwarePaginator(array(), count($variables['dataAll']), $this->_limit, $page);
        $params_url = array(
            'q' => ($params['q'] != '') ? (string)$params['q'] : '',
            'confirm_action' => ($params['confirm_action'] != '') ? (string)$params['confirm_action'] : '',
        );
        foreach ($params_url as $k => $v) {
            if ($v == '') unset($params_url[$k]);
        }
        $paginator->setPath('/admin/partner?' . http_build_query($params_url));
        return view('admin.pages.partner.index_confirm', [
            'partners'  => $variables['data'],
            'paginator' => $paginator
        ]);
    }

    public function viewConfirm($id)
    {
        $this->authorize('admin');
        $variables = $this->partnerService->editConfirm($id);
        return view('admin.pages.partner.viewConfirm', [
            'infoBasic' => $variables['infoBasic'],
            'data' => $variables['data'],
            'dataNew' => $variables['dataNew'],
        ]);
    }


    public function updateConfirmCancel(Request $request, $id)
    {
        $this->authorize('admin');
        return $this->partnerService->updateConfirmCancel($request, $id);
    }

    public function updateConfirmApply(Request $request, $id)
    {
        $this->authorize('admin');
        return $this->partnerService->updateConfirmApply($request, $id);
    }

    public function create() {
        $this->authorize('add');
        return view('admin.pages.partner.create');
    }

    public function store(PartnerRequest $request) {
        return $this->partnerService->store($request);
    }

    public function edit($id) {
        $variables = $this->partnerService->edit($id);
        return view('admin.pages.partner.edit', [
            'infoBasic'     => $variables['infoBasic'],
            'data'      => $variables['data'],
        ]);
    }

    public function update(PartnerRequest $request, $id) {
        $this->authorize('edit');
        return $this->partnerService->update($request, $id);
    }

    public function delete(Request $request) {
        $this->authorize('delete');
        return $this->partnerService->delete($request);
    }

    public function changeStatus(Request $request) {
        $this->authorize('edit');
        return $this->partnerService->changeStatus($request);
    }
}