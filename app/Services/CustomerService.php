<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/7/18
 * Time: 16:06
 */

namespace App\Services;

use App\Repositories\InterfaceRepository\CustomerRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerService
{
    private $customerRepository;
    private $infoBasic;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->infoBasic = $this->customerRepository->getInfoBasic();
    }

    public function index($params)
    {
        $data = $this->customerRepository->getCustomer($params);
        $dataAll = $this->customerRepository->getAll();
        return [
            'data' => $data,
            'dataAll' => $dataAll,
            'infoBasic' => $this->infoBasic,
        ];
    }


//    public function create()
//    {
//
//
//    }

//    public function store($request)
//    {
//
//    }

//    public function registerUser($request)
//    {
//        $data = [
//            'name' => $request->name,
//            'email' => $request->email,
//            'password' => Hash::make($request->password),
//            'phone' => $request->phone,
//            'address' => $request->address,
//            'group_id' => 2,
//            'status' => 'active'
//        ];
//
//        $this->userRepository->store($data);
//        return redirect()
//            ->route('taikhoan.register')
//            ->with(['noticeMassage' => 'Đăng ký thành công']);
//    }

//    public function edit($id)
//    {
//        $data = $this->userRepository->find($id);
//        $groups = $this->groupRepository->lists();
//        return [
//            'infoBasic' => $this->infoBasic,
//            'data' => $data,
//            'groups' => $groups,
//        ];
//    }
//
//    public function editConfirm($id)
//    {
//        $data = $this->userRepository->getUserConfirm($id);
//        $dataNew = json_decode($data->data_update, true);
//        $groups = $this->groupRepository->lists();
//        return [
//            'infoBasic' => $this->infoBasic,
//            'data' => $data,
//            'dataNew' => $dataNew,
//            'groups' => $groups,
//        ];
//    }


//    public function changePass()
//    {
//        $data = $this->userRepository->find(Auth::user()->id);
//        return [
//            'infoBasic' => $this->infoBasic,
//            'data' => $data,
//        ];
//    }
//
//    public function updatePass($request, $id)
//    {
//        $data['password'] = Hash::make($request->get('password'));
//
//        $this->userRepository->update($data, $id);
//        return redirect()
//            ->route('dashboard')
//            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);
//
//    }

//    public function changeInfo()
//    {
//        $data = $this->userRepository->find(Auth::user()->id);
//        return [
//            'infoBasic' => $this->infoBasic,
//            'data' => $data,
//        ];
//    }

//    public function updateInfo($request, $id)
//    {
//        if ($request->image != null) {
//            $rules = [
//                'name' => 'required',
//                'image' => 'mimes:jpeg,bmp,png',
//            ];
//            $messages = [
//                'name.required' => Config::get('constants.VALIDATE_MESSAGE.NAME_REQUIRED'),
//                'image.mimes' => Config::get('constants.VALIDATE_MESSAGE.IMAGE_MIMES'),
//            ];
//        } else {
//            $rules = [
//                'name' => 'required',
//            ];
//            $messages = [
//                'name.required' => Config::get('constants.VALIDATE_MESSAGE.NAME_REQUIRED'),
//            ];
//        }
//
//        $validator = Validator::make($request->all(), $rules, $messages);
//        if ($validator->fails()) {
//            return redirect()
//                ->back()
//                ->with('errors', $validator->errors());
//        } else {
//            $user = $this->userRepository->find($id);
//            $imageName = $user->image;
//
//            if ($request->image != null) {
//                if (!is_dir('upload/images/' . $this->infoBasic['route'])) {
//                    mkdir('upload/images/' . $this->infoBasic['route']);
//                }
//                $image_file = $request->file('image');
//                $prefixName = time() . "_" . rand(0, 9999999) . "_" . md5(rand(0, 9999999));
//                $image_full_name = $prefixName . '.' . $image_file->getClientOriginalExtension();
//                $image_file->move('upload/images/' . $this->infoBasic['route'], $image_full_name);
//                $image_old = 'upload/images/' . $this->infoBasic['route'] . '/' . $imageName;
//
//                if (File::exists($image_old)) {
//                    File::delete($image_old);
//                }
//            } else {
//                $image_full_name = $imageName;
//            }
//            $data = [
//                'name' => $request->name,
//                'image' => $image_full_name,
//            ];
//        }
//
//        $this->userRepository->update($data, $id);
//        return redirect()
//            ->route('dashboard')
//            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);
//    }

//    public function update($request, $id)
//    {
//        $dataNew = [
//            'group_id' => $request->group_id,
//            'email' => $request->email,
//            'name' => $request->name,
//            'status' => $request->status,
//        ];
//
//        if (Gate::allows('editor', Auth::user())) {
//            $confirm = 'update';
//            $json_data = json_encode($dataNew);
//            $data['data_update'] = $json_data;
//        } else if (Gate::allows('admin', Auth::user())) {
//            $data = $dataNew;
//            $confirm = NULL;
//        }
//        $data['confirm_action'] = $confirm;
//
//        $this->userRepository->update($data, $id);
//        return redirect()
//            ->route($this->infoBasic['route'] . '.index')
//            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);
//    }


}