<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/7/18
 * Time: 16:06
 */

namespace App\Services\Site;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use App\Repositories\InterfaceRepository\UserRepositoryInterface;
use App\Repositories\InterfaceRepository\GroupRepositoryInterface;

class UserService
{
    private $userRepository;
    private $groupRepository;
    private $infoBasic;

    public function __construct(UserRepositoryInterface $userRepository, GroupRepositoryInterface $groupRepository)
    {
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
        $this->infoBasic = $this->userRepository->getInfoBasic();
    }

    public function index($params)
    {
        $data = $this->userRepository->getUser($params);
        $dataAll = $this->userRepository->getAll();
        $groups = $this->groupRepository->lists();
        return [
            'data'      => $data,
            'dataAll'   => $dataAll,
            'infoBasic' => $this->infoBasic,
            'groups'    => $groups,
        ];
    }

    public function create()
    {
        $data = $this->userRepository->getInfoBasic();
        $groups = $this->groupRepository->lists();
        return [
            'infoBasic'            => $this->infoBasic,
            'data'                 => $data,
            'groups'               => $groups,
        ];
    }

    public function store($request)
    {
        $data = [
            'name'     => $request->name,
            'email'     => $request->email,
            'password'     => Hash::make($request->password),
            'phone'     => $request->phone,
            'address'     => $request->address,
            'group_id'  => $request->group_id,
            'status'   => $request->status
        ];

        $this->userRepository->store($data);
        return redirect()
            ->route($this->infoBasic['route'] . '.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.ADD')]);
    }

    public function edit($id)
    {
        $data = $this->userRepository->find($id);
        $groups = $this->groupRepository->lists();
        return [
            'infoBasic' => $this->infoBasic,
            'data'      => $data,
            'groups'    => $groups,
        ];
    }

    public function update($request, $id)
    {
        $data = [
            'name'     => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'address'     => $request->address,
            'group_id'  => $request->group_id,
            'status'   => $request->status
        ];

        if (!empty($request->get('password'))) {
            $data['password'] = Hash::make($request->get('password'));
        }

        $this->userRepository->update($data, $id);
        return redirect()
            ->route($this->infoBasic['route'] . '.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);
    }

    public function destroy($id)
    {
        $data = [
            'status'   => 'deleted'
        ];

        $this->userRepository->update($data, $id);
        return redirect()
            ->route($this->infoBasic['route'] . '.index');
    }

    public function changeStatus($request) {
        $ids = $request->ids;
        $to_status = $request->type;
        if (!in_array($to_status, array('to-active', 'to-inactive')) || empty($ids)) {
            echo json_encode(array('status' => 0, 'msg' => Config::get('constants.ERROR_MESSAGE.ERROR')));
            die();
        } else {
            if (!is_array($ids)) {
                $ids = array($ids);
            }
            $status = ($to_status == 'to-active') ? 'active' : 'inactive';
            $this->userRepository->changeStatus($ids, $status);
            echo json_encode(array('status' => 1, 'data' => $ids, 'msg' => Config::get('constants.SUCCESSFUL_MESSAGE.CHANGE_STATUS')));
            die();
        }
    }

    public function delete($request) {
        $ids = $request->get('ids');
        if (empty($ids)) {
            echo json_encode(array('status' => 0, 'msg' => Config::get('constants.ERROR_MESSAGE.ERROR')));
            die();
        } else {
            if (!is_array($ids)) {
                $ids = array($ids);
            }
            $status = 'delete';
            $this->userRepository->changeStatus($ids, $status);
            echo json_encode(array('status' => 1, 'data' => $ids, 'msg' => Config::get('constants.SUCCESSFUL_MESSAGE.DELETE')));
            die();
        }
    }
}