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

class ItemRequest extends FormRequest
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
                    'name'    => 'required|unique:items,name,NULL,id,deleted_at,NULL',
                    'price'   => 'required',
                    'image'   => 'required|mimes:jpeg,bmp,png,jpg',
                ];
                break;
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'name'  => 'required|unique:items,name,' . $this->route('item') . ',id,deleted_at,NULL',
                    'price'   => 'required',
                    'image'   => 'mimes:jpeg,bmp,png,jpg',
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
            'price.required'  => Config::get('constants.VALIDATE_MESSAGE.PRICE_REQUIRED'),
            'image.mimes'  => Config::get('constants.VALIDATE_MESSAGE.IMAGE_MIMES'),
            'image.required'=> Config::get('constants.VALIDATE_MESSAGE.IMAGE_REQUIRED'),
        ];
    }
}