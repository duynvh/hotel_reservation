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

class SeoConfigService
{
    private $settingRepository;

    public function __construct(SettingRepositoryInterface $settingRepository) {
        $this->settingRepository          = $settingRepository;
    }

    public function index() {
        $data = $this->settingRepository->getSettingByOptionName('setting_seo');

        if(empty($data)) {
            $data = array(
                'meta_title'                 => '',
                'meta_keywords'              => '',
                'meta_description'           => '',
            );
        }
        else {
            $data = json_decode($data->option_value);
            $data = array(
                'meta_title'                 => $data->meta_title,
                'meta_keywords'              => $data->meta_keywords,
                'meta_description'           => $data->meta_description,
            );
        }

        return [
            'data'      => $data,
        ];
    }

    public function save($request) {
        $this->validateRequest($request);
        $data = $this->settingRepository->getSettingByOptionName('setting_seo');
        $option_value = array(
            'meta_title'                 => !empty($request->meta_title) ? $request->meta_title :'',
            'meta_keywords'              => !empty($request->meta_keywords) ? $request->meta_keywords :'',
            'meta_description'           => !empty($request->meta_description) ? $request->meta_description :'',
        );
        // Create
        if(empty($data)) {
            $data = array(
                'option_name'           => 'setting_seo',
                'option_value'          => json_encode($option_value)
            );
            $this->settingRepository->store($data);
        }
        // Updated
        else {
            $this->settingRepository->updated(json_encode($option_value), 'setting_seo');
        }
        echo json_encode(array('status' => 1, 'msg' => Config::get('constants.SUCCESSFUL_MESSAGE.SAVE')));
        die();
    }

    private function validateRequest($request) {
        if(empty($request->meta_title)) {
            echo json_encode(array('status' => 0, 'msg' => Config::get('constants.VALIDATE_MESSAGE.META_TILE_REQUIRED')));
            die();
        }

        if(empty($request->meta_keywords)) {
            echo json_encode(array('status' => 0, 'msg' => Config::get('constants.VALIDATE_MESSAGE.META_KEYWORDS_REQUIRED')));
            die();
        }

        if(empty($request->meta_description)) {
            echo json_encode(array('status' => 0, 'msg' => Config::get('constants.VALIDATE_MESSAGE.META_DESCRIPTION_REQUIRED')));
            die();
        }
    }
}