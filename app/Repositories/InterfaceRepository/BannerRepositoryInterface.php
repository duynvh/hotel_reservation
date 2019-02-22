<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/22/18
 * Time: 21:13
 */

namespace App\Repositories\InterfaceRepository;


interface BannerRepositoryInterface
{
    /**
     * Get Banner
     * @return mixed
     */
    public function getBanner($params);

    public function getBannerNeedConfirm($params);

    public function getBannerConfirm($id);

    public function getAllBannerConfirm();

    public function getBannerOnSite();

    public function getSliderOnSite();
}