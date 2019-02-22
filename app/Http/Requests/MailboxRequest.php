<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class MailboxRequest extends FormRequest
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
                    'full_name'                  => 'required|max:255|regex:/\D/',
                    'subject'                    => 'required|max:255|regex:/\D/',
                    'email'                      => 'required',
                    'message'                    => 'required',
                    'phone'                      => 'required|numeric|min:1|max:9999999999|',
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
            'full_name.required'                  => Config::get('constants.VALIDATE_MESSAGE.FULLNAME_REQUIRED'),
            'full_name.max'                       => Config::get('constants.VALIDATE_MESSAGE.FULLNAME_MAX'),
            'full_name.regex'                       => Config::get('constants.VALIDATE_MESSAGE.FULLNAME_REGEX'),
            'subject.required'                    => Config::get('constants.VALIDATE_MESSAGE.SUBJECT_REQUIRED'),
            'subject.max'                         => Config::get('constants.VALIDATE_MESSAGE.SUBJECT_MAX'),
            'subject.regex'                      => Config::get('constants.VALIDATE_MESSAGE.SUBJECT_REGEX'),
            'email.required' => Config::get('constants.VALIDATE_MESSAGE.EMAIL_REQUIRED'),
            'email.email'   => Config::get('constants.VALIDATE_MESSAGE.EMAIL_INVALID'),
            'phone.required'     => Config::get('constants.VALIDATE_MESSAGE.PHONE_REQUIRED'),
            'phone.numeric'      => Config::get('constants.VALIDATE_MESSAGE.PHONE_NUMERIC'),
            'phone.min'          => Config::get('constants.VALIDATE_MESSAGE.PHONE_MIN'),
            'phone.max'          => Config::get('constants.VALIDATE_MESSAGE.PHONE_MAX'),
            'message.required'          => Config::get('constants.VALIDATE_MESSAGE.MESSAGE_REQUIRED'),
        ];
    }

}
