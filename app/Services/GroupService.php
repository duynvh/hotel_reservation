<?php
namespace App\Services;
use App\Repositories\InterfaceRepository\GroupRepositoryInterface;
use Illuminate\Support\Facades\Config;

class GroupService
{
    private $groupRepository;
    private $infoBasic;

    public function __construct(GroupRepositoryInterface $groupRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->infoBasic = $this->groupRepository->getInfoBasic();
    }

    public function index($params)
    {
        $data = $this->groupRepository->getGroup($params);
        $dataAll = $this->groupRepository->getAll();
        return [
            'data'      => $data,
            'dataAll'   => $dataAll,
            'infoBasic' => $this->infoBasic,
        ];
    }

    public function store($request)
    {
        $data = [
            'name'     => $request->name,
            'status'   => $request->status
        ];

        $this->groupRepository->store($data);
        return redirect()
            ->route($this->infoBasic['route'] . '.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.ADD')]);
    }
//
    public function edit($id)
    {
        $data = $this->groupRepository->find($id);
        return [
            'infoBasic' => $this->infoBasic,
            'data'      => $data,
        ];
    }

    public function update($request, $id)
    {
        $data = [
            'name'     => $request->name,
            'status'   => $request->status
        ];

        $this->groupRepository->update($data, $id);
        return redirect()
            ->route($this->infoBasic['route'] . '.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);
    }

    public function destroy($id)
    {
        $data = [
            'status'   => 'deleted'
        ];

        $this->groupRepository->update($data, $id);
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
            $this->groupRepository->changeStatus($ids, $status);
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
            $this->groupRepository->delete($ids);
            echo json_encode(array('status' => 1, 'data' => $ids, 'msg' => Config::get('constants.SUCCESSFUL_MESSAGE.DELETE')));
            die();
        }
    }
}