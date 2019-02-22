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

class CartRequest extends FormRequest
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
                    'full_name'             => 'required|max:255',
                    'phone'                 => 'required|numeric',
                    'address'               => 'required',
                    'email'                 => 'required|email',
                ];
                break;
            }
            default:
                break;
        }
    }

    public function messages() {
        return [
            'email.required' => Config::get('constants.VALIDATE_MESSAGE.EMAIL_REQUIRED'),
            'email.email'   => Config::get('constants.VALIDATE_MESSAGE.EMAIL_INVALID'),
            'full_name.required'  => Config::get('constants.VALIDATE_MESSAGE.FULLNAME_REQUIRED'),
            'full_name.max'  => Config::get('constants.VALIDATE_MESSAGE.FULLNAME_MAX'),
            'phone.required'  => Config::get('constants.VALIDATE_MESSAGE.PHONE_REQUIRED'),
            'phone.numeric'  => Config::get('constants.VALIDATE_MESSAGE.PHONE_NUMERIC'),
            'address.required'  => Config::get('constants.VALIDATE_MESSAGE.ADDRESS_REQUIRED'),
        ];
    }
}