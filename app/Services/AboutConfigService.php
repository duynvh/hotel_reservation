<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/15/18
 * Time: 16:22
 */

namespace App\Services;

use App\Repositories\InterfaceRepository\ProductRepositoryInterface;
use Illuminate\Support\Facades\Config;
use App\Repositories\InterfaceRepository\SettingRepositoryInterface;

class AboutConfigService
{
    private $settingRepository;
    private $productRepository;

    public function __construct(SettingRepositoryInterface $settingRepository, ProductRepositoryInterface $productRepository) {
        $this->settingRepository              = $settingRepository;
        $this->productRepository              = $productRepository;
    }

    public function index() {
        $data = $this->settingRepository->getSettingByOptionName('setting_about');
        if(empty($data)) {
            $data = array(
                'content'                     => ''
            );
        }
        else {
            $data = array(
                'content'                     => $data->option_value,
            );
        }

        $productBestSeller = $this->productRepository->getBestSellerProduct();
        $productShortestPrice = $this->productRepository->getShortestPriceProductOnSite();
        $productRandom = $this->productRepository->getRandomProductOnSite();

        return [
            'data'      => $data,
            'productBestSeller' => $productBestSeller,
            'productShortestPrice' => $productShortestPrice,
            'productRandom' => $productRandom,
        ];
    }

    public function save($request) {
        $this->validateRequest($request);

        $data = $this->settingRepository->getSettingByOptionName('setting_about');
        // Create
        if(empty($data)) {
            $data = array(
                'option_name'           => 'setting_about',
                'option_value'          => $request->content
            );
            $this->settingRepository->store($data);
        }
        // Updated
        else {
            $this->settingRepository->updated($request->content, 'setting_about');
        }
        echo json_encode(array('status' => 1, 'msg' => Config::get('constants.SUCCESSFUL_MESSAGE.SAVE')));
        die();
    }

    private function validateRequest($request) {
        if (empty($request->content)) {
            echo json_encode(array('status' => 0, 'msg' => Config::get('constants.VALIDATE_MESSAGE.CONTENT_REQUIRED')));
            die();
        }
    }
}