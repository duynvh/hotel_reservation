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

class SocialConfigService
{
    private $settingRepository;

    public function __construct(SettingRepositoryInterface $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function index()
    {
        $data = $this->settingRepository->getSettingByOptionName('setting_social');

        if (empty($data)) {
            $data = array(
                'facebook_url' => '',
                'lazada_url' => '',
                'shopee_url' => '',
                'zalo_url' => '',
            );
        } else {
            $data = json_decode($data->option_value);
            $data = array(
                'facebook_url' => $data->facebook_url,
                'lazada_url' => $data->lazada_url,
                'shopee_url' => $data->shopee_url,
                'zalo_url' => $data->zalo_url
            );
        }

        return [
            'data' => $data,
        ];
    }

    public function save($request)
    {
        $this->validateRequest($request);
        $data = $this->settingRepository->getSettingByOptionName('setting_social');
        $option_value = array(
            'facebook_url' => !empty($request->facebook_url) ? $request->facebook_url : '',
            'lazada_url' => !empty($request->lazada_url) ? $request->lazada_url : '',
            'shopee_url' => !empty($request->shopee_url) ? $request->shopee_url : '',
            'zalo_url' => !empty($request->zalo_url) ? $request->zalo_url : '',
        );
        // Create
        if (empty($data)) {
            $data = array(
                'option_name' => 'setting_social',
                'option_value' => json_encode($option_value)
            );
            $this->settingRepository->store($data);
        } // Updated
        else {
            $this->settingRepository->updated(json_encode($option_value), 'setting_social');
        }
        echo json_encode(array('status' => 1, 'msg' => Config::get('constants.SUCCESSFUL_MESSAGE.SAVE')));
        die();
    }

    private function validateRequest($request)
    {
        if (!empty($request->facebook_url)) {
            if (!filter_var($request->facebook_url, FILTER_VALIDATE_URL)) {
                echo json_encode(array('status' => 0, 'msg' => Config::get('constants.VALIDATE_MESSAGE.FACEBOOK_URL_INVALID')));
                die();
            }
        }

        if (!empty($request->youtube_url)) {
            if (!filter_var($request->youtube_url, FILTER_VALIDATE_URL)) {
                echo json_encode(array('status' => 0, 'msg' => Config::get('constants.VALIDATE_MESSAGE.YOUTUBE_URL_INVALID')));
                die();
            }
        }

        if (!empty($request->google_url)) {
            if (!filter_var($request->google_url, FILTER_VALIDATE_URL)) {
                echo json_encode(array('status' => 0, 'msg' => Config::get('constants.VALIDATE_MESSAGE.GOOGLE_URL_INVALID')));
                die();
            }
        }

        if (!empty($request->twitter_url)) {
            if (!filter_var($request->twitter_url, FILTER_VALIDATE_URL)) {
                echo json_encode(array('status' => 0, 'msg' => Config::get('constants.VALIDATE_MESSAGE.TWITTER_URL_INVALID')));
                die();
            }
        }
    }
}