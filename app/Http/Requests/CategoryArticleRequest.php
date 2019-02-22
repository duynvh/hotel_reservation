<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/17/18
 * Time: 13:51
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class CategoryArticleRequest extends FormRequest
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
                    'name'        => 'required|unique:categories_article,name,NULL,id,deleted_at,NULL',
                ];
                break;
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'name'  => 'required|unique:categories_article,name,' . $this->route('category_article') . ',id,deleted_at,NULL',
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