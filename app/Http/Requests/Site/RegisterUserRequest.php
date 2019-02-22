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

class RegisterUserRequest extends FormRequest
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
            case 'POST': {
                return [
                    'name'                  => 'required|unique:customers,name',
                    'email'                 => 'required|email|unique:customers,email',
                    'password'              => 'required|min:6|max:25',
                    'phone'                 => 'required|numeric|unique:customers,phone',
                    'address'               => 'required',
                ];
                break;
            }
            default:
                break;
        }
    }

    public function messages() {
        return [
            'name.required' => Config::get('constants.VALIDATE_MESSAGE.NAME_REQUIRED'),
            'name.unique'   => Config::get('constants.VALIDATE_MESSAGE.NAME_UNIQUE'),
            'email.required' => Config::get('constants.VALIDATE_MESSAGE.EMAIL_REQUIRED'),
            'email.unique'   => Config::get('constants.VALIDATE_MESSAGE.EMAIL_UNIQUE'),
            'email.email'   => Config::get('constants.VALIDATE_MESSAGE.EMAIL_INVALID'),
            'password.required'  => Config::get('constants.VALIDATE_MESSAGE.PASSWORD_REQUIRED'),
            'password.min'       => Config::get('constants.VALIDATE_MESSAGE.PASSWORD_MIN'),
            'password.max'       => Config::get('constants.VALIDATE_MESSAGE.PASSWORD_MAX'),
            'phone.required'     => Config::get('constants.VALIDATE_MESSAGE.PHONE_REQUIRED'),
            'phone.numeric'      => Config::get('constants.VALIDATE_MESSAGE.PHONE_NUMERIC'),
            'phone.unique'       => Config::get('constants.VALIDATE_MESSAGE.NAME_UNIQUE'),
            'address.required'      => Config::get('constants.VALIDATE_MESSAGE.ADDRESS_REQUIRED'),
        ];
    }
}