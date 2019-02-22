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

class CouponRequest extends FormRequest
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
                    'coupon_code'        => 'required|unique:coupons,coupon_code,NULL,id,deleted_at,NULL',
                    'amount_type'   => 'required',
                    'amount'   => 'required',
                    'start_date'    => 'required|date|after:yesterday',
                    'end_date'      => 'required|date|after:start_date',
                ];
                break;
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'coupon_code'  => 'required|unique:coupons,coupon_code,' . $this->route('coupon') . ',id,deleted_at,NULL',
                    'amount_type'   => 'required',
                    'amount'   => 'required',
                    'start_date'    => 'required|date|after:yesterday',
                    'end_date'      => 'required|date|after:start_date',
                ];
                break;
            }
            default:
                break;
        }
    }

    public function messages() {
        return [
            'coupon_code.required' => Config::get('constants.VALIDATE_MESSAGE.COUPON_REQUIRED'),
            'coupon_code.unique'   => Config::get('constants.VALIDATE_MESSAGE.COUPON_UNIQUE'),
            'start_date.required'  => Config::get('constants.VALIDATE_MESSAGE.START_DATE_REQUIRED'),
            'start_date.date'      => Config::get('constants.VALIDATE_MESSAGE.START_DATE_IS_DATE'),
            'start_date.after'      => Config::get('constants.VALIDATE_MESSAGE.START_DATE_AFTER'),
            'end_date.required'    => Config::get('constants.VALIDATE_MESSAGE.END_DATE_REQUIRED'),
            'end_date.date'      => Config::get('constants.VALIDATE_MESSAGE.END_DATE_IS_DATE'),
            'end_date.after'      => Config::get('constants.VALIDATE_MESSAGE.END_DATE_AFTER_OR_EQUAL'),
            'amount_type.required'  => Config::get('constants.VALIDATE_MESSAGE.AMOUNT_TYPE_REQUIRED'),
            'amount.required'  => Config::get('constants.VALIDATE_MESSAGE.AMOUNT_REQUIRED'),
        ];
    }
}