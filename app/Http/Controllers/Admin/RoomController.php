<?php
/**
 * Created by PhpStorm.
 * coupon: macos
 * Date: 10/7/18
 * Time: 00:15
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RoomService;
use App\Http\Requests\RoomRequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class RoomController extends Controller
{
    private $roomService;
    private $_limit = 15;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
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
        $variables = $this->roomService->index($paramsModel);

        // Pagination
        $paginator = new LengthAwarePaginator(array(), count($variables['dataAll']), $this->_limit, $page);
        $params_url = array(
            'q' => ($params['q'] != '') ? (string)$params['q'] : '',
            'status' => ($params['status'] != '') ? (string)$params['status'] : '',
        );
        foreach ($params_url as $k => $v) {
            if ($v == '') unset($params_url[$k]);
        }
        $paginator->setPath('/admin/room?' . http_build_query($params_url));

        return view('admin.pages.room.index', [
            'rooms' => $variables['data'],
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
        $variables = $this->roomService->indexConfirm($paramsModel);
        // Pagination
        $paginator = new LengthAwarePaginator(array(), count($variables['dataAll']), $this->_limit, $page);
        $params_url = array(
            'q' => ($params['q'] != '') ? (string)$params['q'] : '',
            'confirm_action' => ($params['confirm_action'] != '') ? (string)$params['confirm_action'] : '',
        );
        foreach ($params_url as $k => $v) {
            if ($v == '') unset($params_url[$k]);
        }
        $paginator->setPath('/admin/room?' . http_build_query($params_url));

        return view('admin.pages.room.index_confirm', [
            'rooms' => $variables['data'],
            'paginator' => $paginator
        ]);
    }

    public function viewConfirm($id)
    {
        $this->authorize('admin');
        $variables = $this->roomService->editConfirm($id);
        return view('admin.pages.room.viewConfirm', [
            'infoBasic' => $variables['infoBasic'],
            'data' => $variables['data'],
            'dataNew' => $variables['dataNew'],
        ]);
    }


    public function updateConfirmCancel(Request $request, $id)
    {
        $this->authorize('admin');
        return $this->roomService->updateConfirmCancel($request, $id);
    }

    public function updateConfirmApply(Request $request, $id)
    {
        $this->authorize('admin');
        return $this->roomService->updateConfirmApply($request, $id);
    }

    public function create()
    {
        $this->authorize('add');
        $variables = $this->roomService->create();
        return view('admin.pages.room.create', [
            'roomTypes'    => $variables['roomTypes']
        ]);
    }

    public function store(RoomRequest $request)
    {
        return $this->roomService->store($request);
    }

    public function edit($id)
    {
        $variables = $this->roomService->edit($id);
        return view('admin.pages.room.edit', [
            'infoBasic' => $variables['infoBasic'],
            'data' => $variables['data'],
            'roomTypes'    => $variables['roomTypes']
        ]);
    }

    public function update(RoomRequest $request, $id)
    {
        $this->authorize('edit');
        return $this->roomService->update($request, $id);
    }

    public function delete(Request $request)
    {
        $this->authorize('delete');
        return $this->roomService->delete($request);
    }

    public function changeStatus(Request $request)
    {
        $this->authorize('edit');
        return $this->roomService->changeStatus($request);
    }
}