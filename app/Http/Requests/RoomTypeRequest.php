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

class RoomTypeRequest extends FormRequest
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
                    'name'    => 'required|unique:rooms_type,name,NULL,id,deleted_at,NULL',
                    'image'   => 'mimes:jpeg,bmp,png',
                    'description'   => 'required',
                    'content'   => 'required',
                ];
                break;
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'name'  => 'required|unique:rooms_type,name,' . $this->route('room-type') . ',id,deleted_at,NULL',
                    'image'   => 'mimes:jpeg,bmp,png',
                    'description'   => 'required',
                    'content'   => 'required',
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
            'image.mimes'  => Config::get('constants.VALIDATE_MESSAGE.IMAGE_MIMES'),
            'description.required' => Config::get('constants.VALIDATE_MESSAGE.DESCRIPTION_REQUIRED'),
            'content.required'  => Config::get('constants.VALIDATE_MESSAGE.CONTENT_REQUIRED'),
        ];
    }
}