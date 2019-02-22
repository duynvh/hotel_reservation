<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/7/18
 * Time: 00:15
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BannerService;
use App\Http\Requests\BannerRequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class BannerController extends Controller
{
    private $bannerService;
    private $_limit = 15;

    public function __construct(BannerService $bannerService) {
        $this->bannerService = $bannerService;
        $this->_limit = env('LIMIT_SHOW_LIST', $this->_limit);
    }

    public function index(Request $request) {
        $params_default = array('q' => '', 'status' => 'all', 'type' => 'all');
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
            'type' => !empty($params['type']) ? $params['type'] : '',
            'offset' => $offSet,
            'limit' => intval($this->_limit)
        );
        $variables = $this->bannerService->index($paramsModel);

        // Pagination
        $paginator = new LengthAwarePaginator(array(), count($variables['dataAll']), $this->_limit, $page);
        $params_url = array(
            'q' => ($params['q'] != '') ? (string)$params['q'] : '',
            'status' => ($params['status'] != '') ? (string)$params['status'] : '',
        );
        foreach ($params_url as $k => $v) {
            if ($v == '') unset($params_url[$k]);
        }
        $paginator->setPath('/admin/banner?' . http_build_query($params_url));
        return view('admin.pages.banner.index', [
            'banners'  => $variables['data'],
            'dataHidden' => $variables['dataAllHidden'],
            'paginator' => $paginator
        ]);
    }

    public function indexConfirm(Request $request) {
        $params_default = array('q' => '', 'confirm_action' => 'all', 'type' => 'all');
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
            'type' => !empty($params['type']) ? $params['type'] : '',
            'offset' => $offSet,
            'limit' => intval($this->_limit)
        );
        $variables = $this->bannerService->indexConfirm($paramsModel);

        // Pagination
        $paginator = new LengthAwarePaginator(array(), count($variables['dataAll']), $this->_limit, $page);
        $params_url = array(
            'q' => ($params['q'] != '') ? (string)$params['q'] : '',
            'confirm_action' => ($params['confirm_action'] != '') ? (string)$params['confirm_action'] : '',
        );
        foreach ($params_url as $k => $v) {
            if ($v == '') unset($params_url[$k]);
        }
        $paginator->setPath('/admin/banner?' . http_build_query($params_url));
        return view('admin.pages.banner.index_confirm', [
            'banners'  => $variables['data'],
            'paginator' => $paginator
        ]);
    }

    public function viewConfirm($id)
    {
        $this->authorize('admin');
        $variables = $this->bannerService->editConfirm($id);
        return view('admin.pages.banner.viewConfirm', [
            'infoBasic' => $variables['infoBasic'],
            'data' => $variables['data'],
            'dataNew' => $variables['dataNew'],
        ]);
    }


    public function updateConfirmCancel(Request $request, $id)
    {
        $this->authorize('admin');
        return $this->bannerService->updateConfirmCancel($request, $id);
    }

    public function updateConfirmApply(Request $request, $id)
    {
        $this->authorize('admin');
        return $this->bannerService->updateConfirmApply($request, $id);
    }

    public function create() {
        $this->authorize('add');
        return view('admin.pages.banner.create');
    }

    public function store(BannerRequest $request) {
        return $this->bannerService->store($request);
    }

    public function edit($id) {
        $variables = $this->bannerService->edit($id);
        return view('admin.pages.banner.edit', [
            'infoBasic'     => $variables['infoBasic'],
            'data'      => $variables['data'],
        ]);
    }

    public function update(BannerRequest $request, $id) {
        $this->authorize('edit');
        return $this->bannerService->update($request, $id);
    }

    public function delete(Request $request) {
        $this->authorize('delete');
        return $this->bannerService->delete($request);
    }

    public function changeStatus(Request $request) {
        $this->authorize('edit');
        return $this->bannerService->changeStatus($request);
    }
}