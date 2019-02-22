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
use App\Repositories\InterfaceRepository\CustomerRepositoryInterface;
use Auth;

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
        $data = $this->customerRepository->getUser($params);
        $dataAll = $this->customerRepository->getAll();
        return [
            'data'      => $data,
            'dataAll'   => $dataAll,
            'infoBasic' => $this->infoBasic,
        ];
    }

    public function create()
    {
        $data = $this->customerRepository->getInfoBasic();
        return [
            'infoBasic'            => $this->infoBasic,
            'data'                 => $data,
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
            'status'   => 'active'
        ];

        $this->customerRepository->store($data);
        return redirect()
            ->route('taikhoan.register')
            ->with(['noticeMessage' => 'Đăng ký tài khoản thành công']);
    }

    public function edit($id)
    {
        $data = $this->customerRepository->find($id);
        return [
            'infoBasic' => $this->infoBasic,
            'data'      => $data,
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
            'status'   => 'active'
        ];

        if (!empty($request->get('password'))) {
            $data['password'] = Hash::make($request->get('password'));
        }

        $this->customerRepository->update($data, $id);
        return redirect()
            ->route($this->infoBasic['route'] . '.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);
    }

    public function changePassword($request) {
        $id = Auth::guard('customer')->user()->id;
        $data['password'] = Hash::make($request->get('password'));
        $this->customerRepository->update($data, $id);
        return redirect()
            ->route('taikhoan.change-password')
            ->with(['noticeMessage' => 'Đổi mật khẩu thành công']);
    }
}