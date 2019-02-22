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

class RoomRequest extends FormRequest
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
                    'room_number'    => 'required|unique:rooms,room_number,NULL,id,deleted_at,NULL',
                    'name'    => 'required|unique:rooms,name,NULL,id,deleted_at,NULL',
                    'price'   => 'required',
                    'room_type_id'   => 'required',
                ];
                break;
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'room_number'  => 'required|unique:rooms,room_number,' . $this->route('room') . ',id,deleted_at,NULL',
                    'name'  => 'required|unique:rooms,name,' . $this->route('room') . ',id,deleted_at,NULL',
                    'price'   => 'required',
                    'room_type_id'   => 'required',
                ];
                break;
            }
            default:
                break;
        }
    }

    public function messages() {
        return [
            'room_number.required' => Config::get('constants.VALIDATE_MESSAGE.ROOM_NUMBER_REQUIRED'),
            'room_number.unique'   => Config::get('constants.VALIDATE_MESSAGE.ROOM_NUMBER_UNIQUE'),
            'name.required' => Config::get('constants.VALIDATE_MESSAGE.NAME_REQUIRED'),
            'name.unique'   => Config::get('constants.VALIDATE_MESSAGE.NAME_UNIQUE'),
            'price.required'  => Config::get('constants.VALIDATE_MESSAGE.PRICE_REQUIRED'),
            'room_type_id.required'  => Config::get('constants.VALIDATE_MESSAGE.ROOM_TYPE_REQUIRED'),
        ];
    }
}