<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/19/18
 * Time: 13:54
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class ProductRequest extends FormRequest
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
                        'name' => 'required|max:65|unique:products,name,NULL,id,deleted_at,NULL',
                        'description' => 'required',
                        'content' => 'required',
                        'image' => 'required|mimes:jpeg,bmp,png',
                        'category_product_id' => 'required',
                        'price' => 'required|numeric',
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'name' => 'required|max:65|unique:products,name,' . $this->route('product') . ',id,deleted_at,NULL',
                        'description' => 'required',
                        'content' => 'required',
                        'image' => 'mimes:jpeg,bmp,png',
                        'category_product_id' => 'required',
                        'price' => 'required|numeric',
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
            'category_product_id.required' => Config::get('constants.VALIDATE_MESSAGE.CATEGORY_REQUIRED'),
            'name.required' => Config::get('constants.VALIDATE_MESSAGE.NAME_REQUIRED'),
            'name.unique' => Config::get('constants.VALIDATE_MESSAGE.NAME_UNIQUE'),
            'name.max' => Config::get('constants.VALIDATE_MESSAGE.NAME_PRODUCT_MAX'),
            'image.required' => Config::get('constants.VALIDATE_MESSAGE.IMAGE_REQUIRED'),
            'image.mimes' => Config::get('constants.VALIDATE_MESSAGE.IMAGE_MIMES'),
            'description.required' => Config::get('constants.VALIDATE_MESSAGE.DESCRIPTION_REQUIRED'),
            'content.required' => Config::get('constants.VALIDATE_MESSAGE.CONTENT_REQUIRED'),
            'price.required' => Config::get('constants.VALIDATE_MESSAGE.PRICE_REQUIRED'),
            'price.numeric' => Config::get('constants.VALIDATE_MESSAGE.PRICE_NUMERIC'),
        ];
    }
}