<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/7/18
 * Time: 16:12
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function __construct()
    {
        //  $this->middleware('guest:admin');
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request) {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];

        $messages = [
            'email.required' => 'Email không được bỏ trống',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Mật khẩu không được bỏ trống',
            'password.min' => 'Mật khẩu tối thiểu 6 kí tự',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->errors());
        } else {
            $data = [
                'email' => $request->email,
                'password' => $request->password,
                'status'    => 'active'
            ];

            if (Auth::attempt($data)) {
                return redirect(route('dashboard'));
            } else {
                $errors = new MessageBag(['login_fail' => 'Email hoặc mật khẩu không đúng']);
                return redirect()->back()->with('errors', $errors);
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('admin.login'));
    }
}