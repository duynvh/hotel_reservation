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
use Illuminate\Validation\Rule;

class PartnerRequest extends FormRequest
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
                    'name'        => 'required|unique:banners,name,NULL,id,deleted_at,NULL',
                    'image'       => 'required|mimes:jpeg,bmp,png',
                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'name'          => 'required|unique:banners,name,' . $this->route('banner') . ',id,deleted_at,NULL',
                    'image'         => 'mimes:jpeg,bmp,png',
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
            'name.unique' => Config::get('constants.VALIDATE_MESSAGE.NAME_UNIQUE'),
            'image.required'=> Config::get('constants.VALIDATE_MESSAGE.IMAGE_REQUIRED'),
            'image.mimes'   => Config::get('constants.VALIDATE_MESSAGE.IMAGE_MIMES'),
        ];
    }

}