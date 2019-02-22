<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use App\Repositories\InterfaceRepository\PartnerRepositoryInterface;
use App\Helper\ImageOption;
use Illuminate\Support\Facades\Gate;

class PartnerService
{
    private $partnerRepository;
    private $imageOption;
    private $infoBasic;

    public function __construct(PartnerRepositoryInterface $partnerRepository, ImageOption $imageOption)
    {
        $this->partnerRepository = $partnerRepository;
        $this->imageOption = $imageOption;
        $this->infoBasic = $this->partnerRepository->getInfoBasic();
    }

    public function index($params)
    {
        $data = $this->partnerRepository->getPartner($params);
        $dataAll = $this->partnerRepository->getAll();
        $dataAllHidden = $this->partnerRepository->getAllPartnerConfirm();

        return [
            'dataAll' => $dataAll,
            'data' => $data,
            'dataAllHidden' => $dataAllHidden,
            'infoBasic' => $this->infoBasic,
        ];
    }

    public function indexConfirm($params)
    {
        $data = $this->partnerRepository->getPartnerNeedConfirm($params);
        $dataAll = $this->partnerRepository->getAll();
        return [
            'dataAll' => $dataAll,
            'data' => $data,
            'infoBasic' => $this->infoBasic,
        ];
    }

    public function editConfirm($id)
    {
        $data = $this->partnerRepository->getPartnerConfirm($id);
        $dataNew = json_decode($data->data_update, true);
        return [
            'infoBasic' => $this->infoBasic,
            'data' => $data,
            'dataNew' => $dataNew,
        ];
    }

    public function updateConfirmCancel($request, $id)
    {
        $partner = $this->partnerRepository->getPartnerConfirm($id);
        if ($partner->confirm_action === 'add') {
            $image_product = 'upload/images/' . $this->infoBasic['route'] . '/' . $partner->image;
            $image_product_small = 'upload/images/' . $this->infoBasic['route'] . '/75x50/' . $partner->image;
            if (File::exists($image_product)) {
                File::delete($image_product);
            }
            if (File::exists($image_product_small)) {
                File::delete($image_product_small);
            }
            $this->partnerRepository->destroyHidden($id);
        } elseif ($partner->confirm_action === 'update') {
            $data_new = json_decode($partner->data_update, true);
            if ($data_new['image'] != $partner->image) {
                $image_new = 'upload/images/' . $this->infoBasic['route'] . '/' . $data_new['image'];
                $image_new_small = 'upload/images/' . $this->infoBasic['route'] . '/75x50/' . $data_new['image'];
                if (File::exists($image_new)) {
                    File::delete($image_new);
                }
                if (File::exists($image_new_small)) {
                    File::delete($image_new_small);
                }
            }
            $data['data_update'] = NULL;
            $data['confirm_action'] = NULL;
            $this->partnerRepository->updateHidden($data, $id);
        } elseif ($partner->confirm_action === 'delete') {
            $data['confirm_action'] = NULL;
            $this->partnerRepository->updateHidden($data, $id);
        }
        return redirect()
            ->route($this->infoBasic['route'] . '.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);
    }

    public function updateConfirmApply($request, $id)
    {
        $partner = $this->partnerRepository->getPartnerConfirm($id);
        if ($partner->confirm_action === 'add') {
            $data['confirm_action'] = NULL;

            $this->partnerRepository->updateHidden($data, $id);
        } elseif ($partner->confirm_action === 'update') {
            $data = json_decode($partner->data_update, true);
            if ($data['image'] != $partner->image) {
                $image_old = 'upload/images/' . $this->infoBasic['route'] . '/' . $partner->image;
                $image_old_small = 'upload/images/' . $this->infoBasic['route'] . '/75x50/' . $partner->image;
                if (File::exists($image_old)) {
                    File::delete($image_old);
                }
                if (File::exists($image_old_small)) {
                    File::delete($image_old_small);
                }
            }
            $data['confirm_action'] = NULL;
            $data['data_update'] = NULL;
            $this->partnerRepository->updateHidden($data, $id);
        } elseif ($partner->confirm_action === 'delete') {
            $data['confirm_action'] = NULL;
            $this->partnerRepository->updateHidden($data, $id);
            $this->partnerRepository->delete($id);
        }
        return redirect()
            ->route($this->infoBasic['route'] . '.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);
    }

    public function store($request)
    {
        if ($request->image != null) {

            if (!is_dir('upload/images/' . $this->infoBasic['route'])) {
                mkdir('upload/images/' . $this->infoBasic['route'], 0777, true);
            }

            $image_file = $request->file('image');
            $prefixName = time() . "_" . rand(0, 9999999) . "_" . md5(rand(0, 9999999));
            $image_full_name = $prefixName . '.' . $image_file->getClientOriginalExtension();
            $move = $image_file->move('upload/images/' . $this->infoBasic['route'], $image_full_name);
            if ($move) {
                if (!is_dir('upload/images/' . $this->infoBasic['route'] . '/75x50')) {
                    mkdir('upload/images/' . $this->infoBasic['route'] . '/75x50', 0777, true);
                }

                $dataImage['path'] = 'upload/images/' . $this->infoBasic['route'];
                $dataImage['pathNew'] = 'upload/images/' . $this->infoBasic['route'] . '/75x50';
                $dataImage['name'] = $image_full_name;
                $dataImage['width'] = 75;
                $dataImage['height'] = 50;
                $this->imageOption->resizeImage($dataImage);
                if (Gate::allows('editor', Auth::user())) {
                    $confirm = 'add';
                } else if (Gate::allows('admin', Auth::user())) {
                    $confirm = NULL;
                }
                $data = [
                    'name' => $request->name,
                    'status' => $request->status,
                    'image' => $image_full_name,
                    'confirm_action' => $confirm,
                ];

                $this->partnerRepository->store($data);

                return redirect()
                    ->route($this->infoBasic['route'] . '.index')
                    ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.ADD')]);
            } else {
                return redirect()
                    ->back()
                    ->with(['noticeMassage' => 'Lỗi upload hình thử lại sau']);
            }
        }
    }

//
    public function edit($id)
    {
        $data = $this->partnerRepository->find($id);

        return [
            'infoBasic' => $this->infoBasic,
            'data' => $data,
        ];
    }

    public function update($request, $id)
    {
        $partner = $this->partnerRepository->find($id);

        $imageName = $partner->image;
        $checkMoveImage = true;
        $image_full_name = "";

        if ($request->image != null) {
            if (!is_dir('upload/images/' . $this->infoBasic['route'])) {
                mkdir('upload/images/' . $this->infoBasic['route']);
            }

            $image_file = $request->file('image');
            $prefixName = time() . "_" . rand(0, 9999999) . "_" . md5(rand(0, 9999999));
            $image_full_name = $prefixName . '.' . $image_file->getClientOriginalExtension();
            $move = $image_file->move('upload/images/' . $this->infoBasic['route'], $image_full_name);
            if ($move) {
                if (!is_dir('upload/images/' . $this->infoBasic['route'] . '/75x50')) {
                    mkdir('upload/images/' . $this->infoBasic['route'] . '/75x50', 0777, true);
                }

                $dataImage['path'] = 'upload/images/' . $this->infoBasic['route'];
                $dataImage['pathNew'] = 'upload/images/' . $this->infoBasic['route'] . '/75x50';
                $dataImage['name'] = $image_full_name;
                $dataImage['width'] = 75;
                $dataImage['height'] = 50;
                $this->imageOption->resizeImage($dataImage);

                if (Gate::allows('admin', Auth::user())) {
                    $image_old = 'upload/images/' . $this->infoBasic['route'] . '/' . $imageName;
                    if (File::exists($image_old)) {
                        File::delete($image_old);
                    }
                }
            } else {
                $checkMoveImage = false;
            }
        }

        if ($checkMoveImage == false || $request->image == null) {
            if (Gate::allows('editor', Auth::user())) {
                $image_full_name = null;
            } else if (Gate::allows('admin', Auth::user())) {
                $image_full_name = $imageName;
            }
        }
        $dataNew = [
            'name' => $request->name,
            'status' => $request->status,
            'image' => $image_full_name
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

        $this->partnerRepository->update($data, $id);
        return redirect()
            ->route($this->infoBasic['route'] . '.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);
    }

    public function destroy($id)
    {
        $data = [
            'status' => 'deleted'
        ];

        $this->partnerRepository->update($data, $id);
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
            $this->partnerRepository->changeStatus($ids, $status);
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
                $this->partnerRepository->update($data, $ids);
            } else {
                $this->partnerRepository->delete($ids);
            }
            echo json_encode(array('status' => 1, 'data' => $ids, 'msg' => Config::get('constants.SUCCESSFUL_MESSAGE.DELETE')));
            die();
        }
    }

}