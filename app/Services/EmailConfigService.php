<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/15/18
 * Time: 16:22
 */

namespace App\Services;

use Illuminate\Support\Facades\Config;
use App\Repositories\InterfaceRepository\SettingRepositoryInterface;

class EmailConfigService
{
    private $settingRepository;

    public function __construct(SettingRepositoryInterface $settingRepository) {
        $this->settingRepository          = $settingRepository;
    }

    public function index() {
        $data = $this->settingRepository->getSettingByOptionName('setting_email');

        if (empty($data)) {
            $data = array(
                'email'                 => '',
                'password'              => '',
                'email_register'        => '',
                'email_contact'         => ''
            );
        }
        else {
            $data = json_decode($data->option_value);
            $data = array(
                'email'                 => $data->email,
                'password'              => $data->password,
                'email_register'        => $data->email_register,
                'email_contact'         => $data->email_contact
            );
        }

        return [
            'data'      => $data
        ];
    }

    public function save($request) {
        $this->validateRequest($request);
        $data = $this->settingRepository->getSettingByOptionName('setting_email');
        $option_value = array(
            'email'                 => $request->email,
            'password'              => $request->password,
            'email_register'        => !empty($request->email_register) ? $request->email_register :'',
            'email_contact'         => !empty($request->email_contact) ? $request->email_contact :'',
        );
        // Create
        if(empty($data)) {
            $data = array(
                'option_name'           => 'setting_email',
                'option_value'          => json_encode($option_value)
            );
            $this->settingRepository->store($data);
        }
        // Updated
        else {
            $this->settingRepository->updated(json_encode($option_value), 'setting_email');
        }
        echo json_encode(array('status' => 1, 'msg' => Config::get('constants.SUCCESSFUL_MESSAGE.SAVE')));
        die();
    }

    private function validateRequest($request)
    {
        if (empty($request->email)) {
            echo json_encode(array('status' => 0, 'msg' => Config::get('constants.VALIDATE_MESSAGE.EMAIL_REQUIRED')));
            die();
        }

        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(array('status' => 0, 'msg' => Config::get('constants.VALIDATE_MESSAGE.EMAIL_INVALID')));
            die();
        }

        if (empty($request->password)) {
            echo json_encode(array('status' => 0, 'msg' => Config::get('constants.VALIDATE_MESSAGE.PASSWORD_REQUIRED')));
            die();
        }

        if (!empty($request->email_register)) {
            $validateEmailRegister = $this->checkInvalidEmail($request->email_register);
            if (!$validateEmailRegister) {
                echo json_encode(array('status' => 0, 'msg' => Config::get('constants.VALIDATE_MESSAGE.EMAIL_REGISTER_INVALID')));
                die();
            }
        }

        if (!empty($request->email_contact)) {
            $validateEmailContact = $this->checkInvalidEmail($request->email_contact);
            if (!$validateEmailContact) {
                echo json_encode(array('status' => 0, 'msg' => Config::get('constants.VALIDATE_MESSAGE.EMAIL_CONTACT_INVALID')));
                die();
            }
        }
    }

    private function checkInvalidEmail($listEmail) {
        $flag = true;
        $arrayEmail = explode(",", $listEmail);
        foreach($arrayEmail as $email) {
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $flag = false;
                break;
            }
        }
        return $flag;
    }

}