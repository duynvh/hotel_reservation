<?php
/**
 * Created by PhpStorm.
 * User: quocb
 * Date: 12/3/2018
 * Time: 10:52 AM
 */

namespace App\Http\Controllers\Site;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use App\Http\Requests\Site\LoginUserRequest;
use App\Services\Site\CustomerService;
use App\Http\Requests\Site\RegisterUserRequest;
use App\Http\Requests\Site\ChangePasswordUserRequest;

class CustomerController extends Controller
{
    private $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function register()
    {
        return view('frontend.pages.account.register');
    }

    public function registerUser(RegisterUserRequest $request)
    {
        return $this->customerService->store($request);
    }

    public function login()
    {
        Session::flash("pre-url", url()->previous());
        return view('frontend.pages.account.login');
    }

    public function loginUser(LoginUserRequest $request)
    {
        $data = [
            'phone' => $request->phone,
            'password' => $request->password,
        ];

        if (Auth::guard('customer')->attempt($data)) {
            $pieces = explode("/", Session::get('pre-url'));
            if ($pieces[count($pieces) - 1] === 'gio-hang.html') {
                return redirect(route('cart.checkout'));
            }
            return redirect(route('trang-chu'));
        } else {
            $errors = new MessageBag(['login_fail' => 'Số điện thoại hoặc mật khẩu không đúng']);
            return redirect()->back()->with('errors', $errors);
        }
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect(route('taikhoan.login'));
    }

    public function profile()
    {
        if(!Auth::guard('customer')->check()) {
            return redirect(route('taikhoan.login'));
        }
        return view('frontend.pages.account.my_account');
    }

    public function changePassword() {
        if(!Auth::guard('customer')->check()) {
            return redirect(route('taikhoan.login'));
        }
        else {
            return view('frontend.pages.account.changePassword');
        }
    }

    public function updatePassword(ChangePasswordUserRequest $request) {
        return $this->customerService->changePassword($request);
    }
}