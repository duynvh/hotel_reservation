<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/7/18
 * Time: 20:05
 */

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class ChangePasswordUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'PUT':
            case 'POST': {
                return [
                    'password'              => 'required|confirmed|min:6|max:25',
                ];
                break;
            }
            default:
                break;
        }
    }

    public function messages() {
        return [
            'password.required'  => Config::get('constants.VALIDATE_MESSAGE.PASSWORD_REQUIRED'),
            'password.min'       => Config::get('constants.VALIDATE_MESSAGE.PASSWORD_MIN'),
            'password.max'       => Config::get('constants.VALIDATE_MESSAGE.PASSWORD_MAX'),
            'password.confirmed' => 'Mật khẩu và xác nhận mật khẩu phải trùng nhau'
        ];
    }
}