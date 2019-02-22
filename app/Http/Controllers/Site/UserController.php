<?php
/**
 * Created by PhpStorm.
 * User: quocb
 * Date: 12/3/2018
 * Time: 10:52 AM
 */

namespace App\Http\Controllers\Site;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use App\Http\Requests\Site\LoginUserRequest;
use App\Services\UserService;
use App\Http\Requests\Site\RegisterUserRequest;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register() {
        return view('frontend.pages.account.register');
    }

    public function registerUser(RegisterUserRequest $request) {
        return $this->userService->registerUser($request);
    }

    public function login() {
        return view('frontend.pages.account.login');
    }

    public function loginUser(LoginUserRequest $request) {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
            'group_id' => 2,
            'status'    => 'active'
        ];

        if (Auth::attempt($data)) {
            return redirect(route('trang-chu'));
        } else {
            $errors = new MessageBag(['login_fail' => 'Email hoặc mật khẩu không đúng']);
            return redirect()->back()->with('errors', $errors);
        }
    }

    public function logout() {
        Auth::logout();
        return redirect(route('taikhoan.login'));
    }

    public function profile() {
        return view('frontend.pages.account.my_account');
    }
}