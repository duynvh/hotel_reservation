<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/7/18
 * Time: 20:04
 */

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller
{
    private $userService;
    private $_limit = 15;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->_limit = env('LIMIT_SHOW_LIST', $this->_limit);
    }

    public function index(Request $request)
    {

        $params_default = array('q' => '', 'status' => 'all', 'group_id' => 0);
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
            'group_id' => (int)$params['group_id'],
            'offset' => $offSet,
            'limit' => intval($this->_limit)
        );
        $variables = $this->userService->index($paramsModel);

        // Pagination
        $paginator = new LengthAwarePaginator(array(), count($variables['dataAll']), $this->_limit, $page);
        $params_url = array(
            'q' => $params['q'],
            'status' => $params['status'],
            'group_id' => (int)$params['group_id']
        );
        foreach ($params_url as $k => $v) {
            if ($v == '') unset($params_url[$k]);
        }
        $paginator->setPath('/admin/user?' . http_build_query($params_url));
        return view('admin.pages.user.index', [
            'users' => $variables['data'],
            'dataHidden' => $variables['dataAllHidden'],
            'paginator' => $paginator,
            'groups' => ['Chọn nhóm'] + $variables['groups']
        ]);
    }

    public function indexConfirm(Request $request)
    {
        $params_default = array('q' => '', 'confirm_action' => 'all', 'group_id' => 0);
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
            'group_id' => (int)$params['group_id'],
            'offset' => $offSet,
            'limit' => intval($this->_limit)
        );
        $variables = $this->userService->indexConfirm($paramsModel);

        // Pagination
        $paginator = new LengthAwarePaginator(array(), count($variables['dataAll']), $this->_limit, $page);
        $params_url = array(
            'q' => $params['q'],
            'confirm_action' => $params['confirm_action'],
            'group_id' => (int)$params['group_id']
        );
        foreach ($params_url as $k => $v) {
            if ($v == '') unset($params_url[$k]);
        }
        $paginator->setPath('/admin/user?' . http_build_query($params_url));
        return view('admin.pages.user.index_confirm', [
            'users' => $variables['data'],
            'paginator' => $paginator,
            'groups' => ['Chọn nhóm'] + $variables['groups']
        ]);
    }

    public function create()
    {
        $this->authorize('add');

        $variables = $this->userService->create();
        return view('admin.pages.user.create', [
            'groups' => $variables['groups'],
        ]);
    }

    public function store(UserRequest $request)
    {
        return $this->userService->store($request);
    }

    public function edit($id)
    {
        $variables = $this->userService->edit($id);
        return view('admin.pages.user.edit', [
            'infoBasic' => $variables['infoBasic'],
            'data' => $variables['data'],
            'groups' => $variables['groups']
        ]);
    }


    public function update(Request $request, $id)
    {
        $this->authorize('edit');
        return $this->userService->update($request, $id);
    }

    public function viewConfirm($id)
    {
        $this->authorize('admin');
        $variables = $this->userService->editConfirm($id);
        return view('admin.pages.user.viewConfirm', [
            'infoBasic' => $variables['infoBasic'],
            'data' => $variables['data'],
            'dataNew' => $variables['dataNew'],
            'groups' => $variables['groups']
        ]);
    }


    public function updateConfirmCancel(Request $request, $id)
    {
        $this->authorize('admin');
        return $this->userService->updateConfirmCancel($request, $id);
    }

    public function updateConfirmApply(Request $request, $id)
    {
        $this->authorize('admin');
        return $this->userService->updateConfirmApply($request, $id);
    }

    public function delete(Request $request)
    {
        $this->authorize('delete');
        return $this->userService->delete($request);
    }

    public function changeStatus(Request $request)
    {
        $this->authorize('edit');
        return $this->userService->changeStatus($request);
    }

    public function changePass()
    {
        $this->authorize('edit');
        $variables = $this->userService->changePass();
        return view('admin.pages.user.editPass', [
            'infoBasic' => $variables['infoBasic'],
            'data' => $variables['data'],
        ]);
    }

    public function updatePass(UserRequest $request, $id)
    {
        return $this->userService->updatePass($request, $id);
    }

    public function changeInfo()
    {
        $this->authorize('edit');
        $variables = $this->userService->changeInfo();
        return view('admin.pages.user.editInfo', [
            'infoBasic' => $variables['infoBasic'],
            'data' => $variables['data'],
        ]);
    }

    public function updateInfo(Request $request, $id)
    {
        return $this->userService->updateInfo($request, $id);
    }


}