<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/7/18
 * Time: 16:06
 */

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Repositories\InterfaceRepository\UserRepositoryInterface;
use App\Repositories\InterfaceRepository\GroupRepositoryInterface;
use Illuminate\Support\Facades\Validator;

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
        $data = $this->userRepository->getUser($params, Auth::user()->id);
        $dataAll = $this->userRepository->getAll();
        $dataAllHidden = $this->userRepository->getAllUserConfirm();
        $groups = $this->groupRepository->lists();
        return [
            'data' => $data,
            'dataAll' => $dataAll,
            'dataAllHidden' => $dataAllHidden,
            'infoBasic' => $this->infoBasic,
            'groups' => $groups,
        ];
    }

    public function indexConfirm($params)
    {
        $data = $this->userRepository->getUserNeedConfirm($params, Auth::user()->id);
        $groups = $this->groupRepository->lists();
        $dataAll = $this->userRepository->getAll();

        return [
            'data' => $data,
            'dataAll' => $dataAll,
            'infoBasic' => $this->infoBasic,
            'groups' => $groups,
        ];
    }


    public function create()
    {

        $data = $this->userRepository->getInfoBasic();
        $groups = $this->groupRepository->lists();
        return [
            'infoBasic' => $this->infoBasic,
            'data' => $data,
            'groups' => $groups,
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
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'group_id' => $request->group_id,
            'status' => $request->status,
            'confirm_action' => $confirm,
        ];

        $this->userRepository->store($data);
        return redirect()
            ->route($this->infoBasic['route'] . '.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.ADD')]);
    }

    public function registerUser($request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'group_id' => 2,
            'status' => 'active'
        ];

        $this->userRepository->store($data);
        return redirect()
            ->route('taikhoan.register')
            ->with(['noticeMassage' => 'Đăng ký thành công']);
    }

    public function edit($id)
    {
        $data = $this->userRepository->find($id);
        $groups = $this->groupRepository->lists();
        return [
            'infoBasic' => $this->infoBasic,
            'data' => $data,
            'groups' => $groups,
        ];
    }

    public function editConfirm($id)
    {
        $data = $this->userRepository->getUserConfirm($id);
        $dataNew = json_decode($data->data_update, true);
        $groups = $this->groupRepository->lists();
        return [
            'infoBasic' => $this->infoBasic,
            'data' => $data,
            'dataNew' => $dataNew,
            'groups' => $groups,
        ];
    }

    public function updateConfirmCancel($request, $id)
    {
        $user = $this->userRepository->getUserConfirm($id);
        if ($user->confirm_action === 'add') {
            $this->userRepository->destroyHidden($id);
            if ($user->image !== '') {
                if (is_dir('upload/images/' . $this->infoBasic['route'])) {
                    $image_path = 'upload/images/' . $this->infoBasic['route'] . '/' . $user->image;

                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
            }
        } elseif ($user->confirm_action === 'update') {
            $data['data_update'] = NULL;
            $data['confirm_action'] = NULL;
            $this->userRepository->updateHidden($data, $id);
        } elseif ($user->confirm_action === 'delete') {
            $data['confirm_action'] = NULL;
            $this->userRepository->updateHidden($data, $id);
        }
        return redirect()
            ->route($this->infoBasic['route'] . '.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);
    }

    public function updateConfirmApply($request, $id)
    {
        $user = $this->userRepository->getUserConfirm($id);
        if ($user->confirm_action === 'add') {
            $data['confirm_action'] = NULL;

            $this->userRepository->updateHidden($data, $id);
        } elseif ($user->confirm_action === 'update') {
            $data = json_decode($user->data_update, true);
            $data['confirm_action'] = NULL;
            $data['data_update'] = NULL;
            $this->userRepository->updateHidden($data, $id);
        } elseif ($user->confirm_action === 'delete') {
            $data['confirm_action'] = NULL;
            $this->userRepository->updateHidden($data, $id);
            $this->userRepository->destroyHidden($id);
        }
        return redirect()
            ->route($this->infoBasic['route'] . '.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);
    }

    public function changePass()
    {
        $data = $this->userRepository->find(Auth::user()->id);
        return [
            'infoBasic' => $this->infoBasic,
            'data' => $data,
        ];
    }

    public function updatePass($request, $id)
    {
        $data['password'] = Hash::make($request->get('password'));

        $this->userRepository->update($data, $id);
        return redirect()
            ->route('dashboard')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);

    }

    public function changeInfo()
    {
        $data = $this->userRepository->find(Auth::user()->id);
        return [
            'infoBasic' => $this->infoBasic,
            'data' => $data,
        ];
    }

    public function updateInfo($request, $id)
    {
        if ($request->image != null) {
            $rules = [
                'name' => 'required',
                'image' => 'mimes:jpeg,bmp,png',
            ];
            $messages = [
                'name.required' => Config::get('constants.VALIDATE_MESSAGE.NAME_REQUIRED'),
                'image.mimes' => Config::get('constants.VALIDATE_MESSAGE.IMAGE_MIMES'),
            ];
        } else {
            $rules = [
                'name' => 'required',
            ];
            $messages = [
                'name.required' => Config::get('constants.VALIDATE_MESSAGE.NAME_REQUIRED'),
            ];
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->with('errors', $validator->errors());
        } else {
            $user = $this->userRepository->find($id);
            $imageName = $user->image;

            if ($request->image != null) {
                if (!is_dir('upload/images/' . $this->infoBasic['route'])) {
                    mkdir('upload/images/' . $this->infoBasic['route']);
                }
                $image_file = $request->file('image');
                $prefixName = time() . "_" . rand(0, 9999999) . "_" . md5(rand(0, 9999999));
                $image_full_name = $prefixName . '.' . $image_file->getClientOriginalExtension();
                $image_file->move('upload/images/' . $this->infoBasic['route'], $image_full_name);
                $image_old = 'upload/images/' . $this->infoBasic['route'] . '/' . $imageName;

                if (File::exists($image_old)) {
                    File::delete($image_old);
                }
            } else {
                $image_full_name = $imageName;
            }
            $data = [
                'name' => $request->name,
                'image' => $image_full_name,
            ];
        }

        $this->userRepository->update($data, $id);
        return redirect()
            ->route('dashboard')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);
    }

    public function update($request, $id)
    {
        $dataNew = [
            'group_id' => $request->group_id,
            'email' => $request->email,
            'name' => $request->name,
            'status' => $request->status,
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

        $this->userRepository->update($data, $id);
        return redirect()
            ->route($this->infoBasic['route'] . '.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);
    }

    public function destroy($id)
    {
        $data = [
            'status' => 'deleted'
        ];

        $this->userRepository->update($data, $id);
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
            $this->userRepository->changeStatus($ids, $status);
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
                $this->userRepository->update($data, $ids);
            } else {
                $this->userRepository->delete($ids);
            }

            echo json_encode(array('status' => 1, 'data' => $ids, 'msg' => Config::get('constants.SUCCESSFUL_MESSAGE.DELETE')));
            die();
        }
    }
}