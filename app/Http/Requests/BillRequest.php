<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/22/18
 * Time: 20:46
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class BillRequest extends FormRequest
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
                    'status'    => 'required',
                ];
                break;
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'status'    => 'required',
                ];
                break;
            }
            default:
                break;
        }
    }

    public function messages() {
        return [
            'status.required'  => Config::get('constants.VALIDATE_MESSAGE.STATUS_REQUIRED'),
        ];
    }
}