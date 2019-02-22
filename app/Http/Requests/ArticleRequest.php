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

class ArticleRequest extends FormRequest
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
                    'name'        => 'required|unique:articles,name,NULL,id,deleted_at,NULL',
                    'description' => 'required',
                    'content'     => 'required',
                    'image'       => 'required|mimes:jpeg,bmp,png',
                    'category_article_id'   => 'required'
                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'name'          => 'required|unique:articles,name,' . $this->route('article') . ',id,deleted_at,NULL',
                    'description'   => 'required',
                    'content'       => 'required',
                    'image'         => 'mimes:jpeg,bmp,png',
                    'category_article_id'   => 'required'
                ];
                break;
            }
            default:
                break;
        }
    }

    public function messages() {
        return [
            'category_article_id.required'  => Config::get('constants.VALIDATE_MESSAGE.CATEGORY_REQUIRED'),
            'name.required' => Config::get('constants.VALIDATE_MESSAGE.NAME_REQUIRED'),
            'name.unique'   => Config::get('constants.VALIDATE_MESSAGE.NAME_UNIQUE'),
            'image.required'=> Config::get('constants.VALIDATE_MESSAGE.IMAGE_REQUIRED'),
            'image.mimes'   => Config::get('constants.VALIDATE_MESSAGE.IMAGE_MIMES'),
            'description.required'  => Config::get('constants.VALIDATE_MESSAGE.DESCRIPTION_REQUIRED'),
            'content.required'  => Config::get('constants.VALIDATE_MESSAGE.CONTENT_REQUIRED'),
        ];
    }
}