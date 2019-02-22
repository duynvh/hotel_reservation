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

class AttributeConfigService
{
    private $settingRepository;

    public function __construct(SettingRepositoryInterface $settingRepository) {
        $this->settingRepository          = $settingRepository;
    }

    public function index() {
        $data = $this->settingRepository->getSettingByOptionName('setting_attribute');

        if(empty($data)) {
            $data = array(
                'color'                 => '',
                'size'                  => '',
            );
        }
        else {
            $data = json_decode($data->option_value);
            $data = array(
                'color'                 => $data->color,
                'size'                  => $data->size,
            );
        }

        return [
            'data'      => $data,
        ];
    }

    public function save($request) {
        $this->validateRequest($request);
        $data = $this->settingRepository->getSettingByOptionName('setting_attribute');
        $option_value = array(
            'color'                 => !empty($request->color) ? $request->color :'',
            'size'                  => !empty($request->size) ? $request->size :'',
        );
        // Create
        if(empty($data)) {
            $data = array(
                'option_name'           => 'setting_attribute',
                'option_value'          => json_encode($option_value)
            );
            $this->settingRepository->store($data);
        }
        // Updated
        else {
            $this->settingRepository->updated(json_encode($option_value), 'setting_attribute');
        }
        echo json_encode(array('status' => 1, 'msg' => Config::get('constants.SUCCESSFUL_MESSAGE.SAVE')));
        die();
    }

    private function validateRequest($request) {
        if(empty($request->size)) {
            echo json_encode(array('status' => 0, 'msg' => Config::get('constants.VALIDATE_MESSAGE.SIZE_REQUIRED')));
            die();
        }

        if(empty($request->color)) {
            echo json_encode(array('status' => 0, 'msg' => Config::get('constants.VALIDATE_MESSAGE.COLOR_REQUIRED')));
            die();
        }
    }
}