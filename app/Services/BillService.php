<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/22/18
 * Time: 20:43
 */

namespace App\Services;

use App\Repositories\InterfaceRepository\BillDetailRepositoryInterface;
use App\Repositories\InterfaceRepository\BillRepositoryInterface;
use Illuminate\Support\Facades\Config;

class BillService
{
    private $billRepository;
    private $billDetailRepository;
    private $infoBasic;

    public function __construct(BillRepositoryInterface $billRepository, BillDetailRepositoryInterface $billDetailRepository)
    {
        $this->billRepository = $billRepository;
        $this->billDetailRepository = $billDetailRepository;
        $this->infoBasic = $this->billRepository->getInfoBasic();
    }

    public function index($params)
    {
        $data = $this->billRepository->getBill($params);
        $dataAll = $this->billRepository->getAllBill();
        return [
            'data' => $data,
            'dataAll' => $dataAll,
            'infoBasic' => $this->infoBasic,
        ];
    }

    public function store($request)
    {

    }

    public function edit($id)
    {
        $data = $this->billRepository->find($id);
        $dataDetail = $this->billDetailRepository->getBillDetailByBillId($id);
        return [
            'infoBasic' => $this->infoBasic,
            'data' => $data,
            'dataDetail' => $dataDetail,
        ];
    }

    public function update($request, $id)
    {
        $data = [
            'status' => $request->status
        ];
        $this->billRepository->update($data, $id);
        return redirect()
            ->route($this->infoBasic['route'] . '.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);
    }

    public function destroy($id)
    {

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
            $this->couponRepository->changeStatus($ids, $status);
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
            $status = 'delete';
            $this->couponRepository->changeStatus($ids, $status);
            echo json_encode(array('status' => 1, 'data' => $ids, 'msg' => Config::get('constants.SUCCESSFUL_MESSAGE.DELETE')));
            die();
        }
    }

    public function getBillToday() {
        $data = $this->billRepository->getBillToday();
        return $data;
    }

    public function getBillSuccess() {
        $data = $this->billRepository->getBillSuccess();
        return $data;
    }

    public function chartBillSuccess() {
        $data = $this->billRepository->chartBillSuccess();
        return $data;
    }
}