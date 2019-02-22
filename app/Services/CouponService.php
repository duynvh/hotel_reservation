<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/22/18
 * Time: 20:43
 */

namespace App\Services;

use App\Repositories\InterfaceRepository\CouponRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class CouponService
{
    private $couponRepository;
    private $infoBasic;

    public function __construct(CouponRepositoryInterface $couponRepository)
    {
        $this->couponRepository = $couponRepository;
        $this->infoBasic = $this->couponRepository->getInfoBasic();
    }

    public function index($params)
    {
        $data = $this->couponRepository->getCoupon($params);
        $dataAll = $this->couponRepository->getAll();
        $dataAllHidden = $this->couponRepository->getAllCouponConfirm();
        return [
            'data' => $data,
            'dataAll' => $dataAll,
            'dataAllHidden' => $dataAllHidden,
            'infoBasic' => $this->infoBasic,
        ];
    }

    public function indexConfirm($params)
    {
        $data = $this->couponRepository->getCouponNeedConfirm($params);
        $dataAll = $this->couponRepository->getAll();
        return [
            'data' => $data,
            'dataAll' => $dataAll,
            'infoBasic' => $this->infoBasic,
        ];
    }

    public function updateConfirmCancel($request, $id)
    {
        $coupon = $this->couponRepository->getcouponConfirm($id);
        if ($coupon->confirm_action === 'add') {
            $this->couponRepository->destroyHidden($id);
        } elseif ($coupon->confirm_action === 'update') {
            $data['data_update'] = NULL;
            $data['confirm_action'] = NULL;
            $this->couponRepository->updateHidden($data, $id);
        } elseif ($coupon->confirm_action === 'delete') {
            $data['confirm_action'] = NULL;
            $this->couponRepository->updateHidden($data, $id);
        }
        return redirect()
            ->route($this->infoBasic['route'] . '.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);
    }

    public function updateConfirmApply($request, $id)
    {
        $coupon = $this->couponRepository->getcouponConfirm($id);
        if ($coupon->confirm_action === 'add') {
            $data['confirm_action'] = NULL;

            $this->couponRepository->updateHidden($data, $id);
        } elseif ($coupon->confirm_action === 'update') {
            $data = json_decode($coupon->data_update, true);
            $data['confirm_action'] = NULL;
            $data['data_update'] = NULL;
            $this->couponRepository->updateHidden($data, $id);
        } elseif ($coupon->confirm_action === 'delete') {
            $data['confirm_action'] = NULL;
            $this->couponRepository->updateHidden($data, $id);
            $this->couponRepository->destroyHidden($id);
        }
        return redirect()
            ->route($this->infoBasic['route'] . '.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);
    }

    public function store($request)
    {
        if (Gate::allows('editor', Auth::user())) {
            $confirm = 'add';
        } else if (Gate::allows('admin', Auth::user())) {
            $confirm = NULL;
        }

        $data = [
            'coupon_code' => $request->coupon_code,
            'amount_type' => $request->amount_type,
            'amount' => $request->amount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'confirm_action' => $confirm,
        ];

        $this->couponRepository->store($data);
        return redirect()
            ->route($this->infoBasic['route'] . '.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.ADD')]);
    }

//
    public function editConfirm($id)
    {
        $data = $this->couponRepository->getCouponConfirm($id);
        $dataNew = json_decode($data->data_update, true);

        return [
            'infoBasic' => $this->infoBasic,
            'data' => $data,
            'dataNew' => $dataNew,
        ];
    }

    public function edit($id)
    {
        $data = $this->couponRepository->find($id);
        return [
            'infoBasic' => $this->infoBasic,
            'data' => $data,
        ];
    }

    public function update($request, $id)
    {
        $dataNew = [
            'coupon_code' => $request->coupon_code,
            'amount_type' => $request->amount_type,
            'amount' => $request->amount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status
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
        $this->couponRepository->update($data, $id);
        return redirect()
            ->route($this->infoBasic['route'] . '.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);
    }

    public function destroy($id)
    {
        $data = [
            'status' => 'deleted'
        ];

        $this->couponRepository->update($data, $id);
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
            if (Gate::allows('editor', Auth::user())) {
                $data = [
                    'confirm_action' => 'delete'
                ];
                $this->couponRepository->update($data, $ids);
            } else {
                $this->couponRepository->delete($ids);
            }
            echo json_encode(array('status' => 1, 'data' => $ids, 'msg' => Config::get('constants.SUCCESSFUL_MESSAGE.DELETE')));
            die();
        }
    }
}