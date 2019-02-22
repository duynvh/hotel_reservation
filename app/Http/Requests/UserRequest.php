<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/7/18
 * Time: 20:05
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
                {
                    return [];
                }
            case 'POST':
                {
                return [
                    'name'        => 'required|unique:users,name,NULL,id,deleted_at,NULL',
                    'email'                 => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
                    'password'              => 'required|min:6|max:25',
                ];
                break;
                }
            case 'PUT':
            case 'PATCH':
                {
                return [
//                    'name'                  => 'required|unique:users,name,' . $this->route('user'),
//                    'email'                 => 'required|email|unique:users,email,' . $this->route('user'),
//                    'phone'                 => 'required|numeric',
                    'password'              => 'required|min:6|max:25',
                    're_password'              => 'required|min:6|max:25|same:password',
                ];
                break;
            }
            default:
                break;
        }
    }

    public function messages()
    {
        return [
            'name.required' => Config::get('constants.VALIDATE_MESSAGE.NAME_REQUIRED'),
            'name.unique'   => Config::get('constants.VALIDATE_MESSAGE.NAME_UNIQUE'),
            'email.required' => Config::get('constants.VALIDATE_MESSAGE.EMAIL_REQUIRED'),
            'email.unique'   => Config::get('constants.VALIDATE_MESSAGE.EMAIL_UNIQUE'),
            'email.email'   => Config::get('constants.VALIDATE_MESSAGE.EMAIL_INVALID'),
            'password.required'  => Config::get('constants.VALIDATE_MESSAGE.PASSWORD_REQUIRED'),
            'password.min'       => Config::get('constants.VALIDATE_MESSAGE.PASSWORD_MIN'),
            'password.max'       => Config::get('constants.VALIDATE_MESSAGE.PASSWORD_MAX'),
            're_password.required'  => Config::get('constants.VALIDATE_MESSAGE.RE_PASSWORD_REQUIRED'),
            're_password.min'       => Config::get('constants.VALIDATE_MESSAGE.RE_PASSWORD_MIN'),
            're_password.max'       => Config::get('constants.VALIDATE_MESSAGE.RE_PASSWORD_MAX'),
            're_password.same'       => Config::get('constants.VALIDATE_MESSAGE.RE_PASSWORD_SAME'),
//            'phone.required'     => Config::get('constants.VALIDATE_MESSAGE.PHONE_REQUIRED'),
//            'phone.numeric'      => Config::get('constants.VALIDATE_MESSAGE.PHONE_NUMERIC'),
        ];
    }
}