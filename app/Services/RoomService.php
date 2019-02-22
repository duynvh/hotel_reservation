<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/22/18
 * Time: 20:43
 */

namespace App\Services;

use App\Repositories\InterfaceRepository\RoomTypeRepositoryInterface;
use App\Repositories\InterfaceRepository\RoomRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class RoomService
{
    private $roomRepository;
    private $roomTypeRepository;
    private $infoBasic;

    public function __construct(RoomRepositoryInterface $roomRepository, RoomTypeRepositoryInterface $roomTypeRepository)
    {
        $this->roomRepository = $roomRepository;
        $this->roomTypeRepository = $roomTypeRepository;
        $this->infoBasic = $this->roomRepository->getInfoBasic();
    }

    public function index($params)
    {
        $data = $this->roomRepository->getRoom($params);
        $dataAll = $this->roomRepository->getAll();
        $dataAllHidden = $this->roomRepository->getAllRoomConfirm();
        return [
            'data' => $data,
            'dataAll' => $dataAll,
            'dataAllHidden' => $dataAllHidden,
            'infoBasic' => $this->infoBasic,
        ];
    }

    public function indexConfirm($params)
    {
        $data = $this->roomRepository->getRoomNeedConfirm($params);
        $dataAll = $this->roomRepository->getAll();
        return [
            'data' => $data,
            'dataAll' => $dataAll,
            'infoBasic' => $this->infoBasic,
        ];
    }

    public function updateConfirmCancel($request, $id)
    {
        $room = $this->roomRepository->getRoomConfirm($id);
        if ($room->confirm_action === 'add') {
            $this->roomRepository->destroyHidden($id);
        } elseif ($room->confirm_action === 'update') {
            $data['data_update'] = NULL;
            $data['confirm_action'] = NULL;
            $this->roomRepository->updateHidden($data, $id);
        } elseif ($room->confirm_action === 'delete') {
            $data['confirm_action'] = NULL;
            $this->roomRepository->updateHidden($data, $id);
        }
        return redirect()
            ->route($this->infoBasic['route'] . '.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);
    }

    public function updateConfirmApply($request, $id)
    {
        $room = $this->roomRepository->getRoomConfirm($id);
        if ($room->confirm_action === 'add') {
            $data['confirm_action'] = NULL;

            $this->roomRepository->updateHidden($data, $id);
        } elseif ($room->confirm_action === 'update') {
            $data = json_decode($room->data_update, true);
            $data['confirm_action'] = NULL;
            $data['data_update'] = NULL;
            $this->roomRepository->updateHidden($data, $id);
        } elseif ($room->confirm_action === 'delete') {
            $data['confirm_action'] = NULL;
            $this->roomRepository->updateHidden($data, $id);
            $this->roomRepository->destroyHidden($id);
        }
        return redirect()
            ->route($this->infoBasic['route'] . '.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);
    }

    public function create()
    {
        $listRoomType = $this->roomTypeRepository->getAll();
        $roomTypes[''] = 'Chọn danh mục';
        if (!empty($listRoomType)) {
            foreach ($listRoomType as $cate) {
                $roomTypes[$cate->id] = $cate->name;
            }
        }
        return [
            'roomTypes' => $roomTypes,
        ];
    }

    public function store($request)
    {
        if (Gate::allows('editor', Auth::user())) {
            $confirm = 'add';
        } else if (Gate::allows('admin', Auth::user())) {
            $confirm = NULL;
        }

        $data = [
            'room_number' => $request->room_number,
            'name' => $request->name,
            'price' => $request->price,
            'status' => $request->status,
            'room_type_id' => $request->room_type_id,
            'confirm_action' => $confirm,
        ];

        $this->roomRepository->store($data);
        return redirect()
            ->route($this->infoBasic['route'] . '.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.ADD')]);
    }

//
    public function editConfirm($id)
    {
        $listRoomType = $this->roomTypeRepository->getAll();
        $roomTypes[''] = 'Chọn danh mục';
        if (!empty($listRoomType)) {
            foreach ($listRoomType as $cate) {
                $roomTypes[$cate->id] = $cate->name;
            }
        }
        $data = $this->roomRepository->getRoomConfirm($id);
        $dataNew = json_decode($data->data_update, true);

        return [
            'infoBasic' => $this->infoBasic,
            'data' => $data,
            'dataNew' => $dataNew,
            'roomTypes' => $roomTypes,
        ];
    }

    public function edit($id)
    {
        $listRoomType = $this->roomTypeRepository->getAll();
        $roomTypes[''] = 'Chọn danh mục';
        if (!empty($listRoomType)) {
            foreach ($listRoomType as $cate) {
                $roomTypes[$cate->id] = $cate->name;
            }
        }
        $data = $this->roomRepository->find($id);
        return [
            'infoBasic' => $this->infoBasic,
            'data' => $data,
            'roomTypes' => $roomTypes,
        ];
    }

    public function update($request, $id)
    {
        $dataNew = [
            'room_number' => $request->room_number,
            'name' => $request->name,
            'price' => $request->price,
            'status' => $request->status,
            'room_type_id' => $request->room_type_id,
        ];

        if (Gate::allows('editor', Auth::user())) {
            $confirm = 'update';
            $json_data = json_encode($dataNew);

            $data['data_update'] = $json_data;
        } else if (Gate::allows('admin', Auth::user())) {
            $data = $dataNew;
            $confirm = NULL;
        }
        $data['confirm_action'] = $confirm;
        $this->roomRepository->update($data, $id);
        return redirect()
            ->route($this->infoBasic['route'] . '.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);
    }

    public function destroy($id)
    {
        $data = [
            'status' => 'deleted'
        ];

        $this->roomRepository->update($data, $id);
        return redirect()
            ->route($this->infoBasic['route'] . '.index');
    }

    public function changeStatus($request)
    {
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
            $this->roomRepository->changeStatus($ids, $status);
            echo json_encode(array('status' => 1, 'data' => $ids, 'msg' => Config::get('constants.SUCCESSFUL_MESSAGE.CHANGE_STATUS')));
            die();
        }
    }

    public function delete($request)
    {
        $ids = $request->get('ids');
        if (empty($ids)) {
            echo json_encode(array('status' => 0, 'msg' => Config::get('constants.ERROR_MESSAGE.ERROR')));
            die();
        } else {
            if (!is_array($ids)) {
                $ids = array($ids);
            }
            if (Gate::allows('editor', Auth::user())) {
                $data = [
                    'confirm_action' => 'delete'
                ];
                $this->roomRepository->update($data, $ids);
            } else {
                $this->roomRepository->delete($ids);
            }
            echo json_encode(array('status' => 1, 'data' => $ids, 'msg' => Config::get('constants.SUCCESSFUL_MESSAGE.DELETE')));
            die();
        }
    }
}