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

class ContactConfigService
{
    private $settingRepository;

    public function __construct(SettingRepositoryInterface $settingRepository) {
        $this->settingRepository              = $settingRepository;
    }

    public function index() {
        $data = $this->settingRepository->getSettingByOptionName('setting_contact');
        if(empty($data)) {
            $data = array(
                'email'                     => '',
                'phone'                     => '',
                'address'                   => '',
                'map'                       => '',
            );
        }
        else {
            $data = json_decode($data->option_value);
            $data = array(
                'email'                     => $data->email,
                'address'                   => $data->address,
                'phone'                     => $data->phone,
                'map'                        => $data->map
            );
        }

        return [
            'data'      => $data,
        ];
    }

    public function save($request) {
        $this->validateRequest($request);

        $data = $this->settingRepository->getSettingByOptionName('setting_contact');
        $option_value = array(
            'email'                 => $request->email,
            'phone'                 => $request->phone,
            'address'               => $request->address,
            'map'                   => $request->map
        );
        // Create
        if(empty($data)) {
            $data = array(
                'option_name'           => 'setting_contact',
                'option_value'          => json_encode($option_value)
            );
            $this->settingRepository->store($data);
        }
        // Updated
        else {
            $this->settingRepository->updated(json_encode($option_value), 'setting_contact');
        }
        echo json_encode(array('status' => 1, 'msg' => Config::get('constants.SUCCESSFUL_MESSAGE.SAVE')));
        die();
    }

    private function validateRequest($request) {
        if (empty($request->email)) {
            echo json_encode(array('status' => 0, 'msg' => Config::get('constants.VALIDATE_MESSAGE.EMAIL_REQUIRED')));
            die();
        }
        else {
            if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(array('status' => 0, 'msg' => Config::get('constants.VALIDATE_MESSAGE.EMAIL_INVALID')));
                die();
            }
        }

        if (empty($request->phone)) {
            echo json_encode(array('status' => 0, 'msg' => Config::get('constants.VALIDATE_MESSAGE.PHONE_REQUIRED')));
            die();
        }
        else {
            if(!filter_var($request->phone, FILTER_SANITIZE_NUMBER_INT)) {
                echo json_encode(array('status' => 0, 'msg' => Config::get('constants.VALIDATE_MESSAGE.PHONE_INVALID')));
                die();
            }
            else if(strlen($request->phone) < 10) {
                echo json_encode(array('status' => 0, 'msg' => Config::get('constants.VALIDATE_MESSAGE.PHONE_INVALID')));
                die();
            }
        }

        if (empty($request->address)) {
            echo json_encode(array('status' => 0, 'msg' => Config::get('constants.VALIDATE_MESSAGE.ADDRESS_REQUIRED')));
            die();
        }
        if (empty($request->map)) {
            echo json_encode(array('status' => 0, 'msg' => Config::get('constants.VALIDATE_MESSAGE.MAP_REQUIRED')));
            die();
        }
    }
}