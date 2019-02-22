<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class ReplyMailboxRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return [
                    'subject'                    => 'required|max:255|regex:/\D/',
                    'content'                    => 'required',
                ];
                break;
            }
            case 'PUT':
            case 'PATCH': {
                return [
                ];
                break;
            }
            default:
                break;
        }
    }

    public function messages() {
        return [
            'subject.required'                  => Config::get('constants.VALIDATE_MESSAGE.SUBJECT_REQUIRED'),
            'subject.max'                       => Config::get('constants.VALIDATE_MESSAGE.SUBJECT_MAX'),
            'subject.regex'                     => Config::get('constants.VALIDATE_MESSAGE.SUBJECT_REGEX'),
            'content.required'                  => Config::get('constants.VALIDATE_MESSAGE.MESSAGE_REQUIRED'),
        ];
    }

}
