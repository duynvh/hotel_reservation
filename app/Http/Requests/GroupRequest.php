<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/7/18
 * Time: 16:48
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class GroupRequest extends FormRequest
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
                    'name'        => 'required|unique:groups,name,NULL,id,deleted_at,NULL',
                ];
                break;
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'name'  => 'required|unique:groups,name,' . $this->route('group') . ',id,deleted_at,NULL',
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
        ];
    }

}