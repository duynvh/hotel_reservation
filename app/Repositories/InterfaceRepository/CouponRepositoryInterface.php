<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/22/18
 * Time: 21:13
 */

namespace App\Repositories\InterfaceRepository;


interface CouponRepositoryInterface
{
    /**
     * Get coupon
     * @return mixed
     */
    public function getCoupon($params);

    public function getCouponNeedConfirm($params);

    public function getCouponConfirm($id);

    public function getAllCouponConfirm();

    public function getCouponByCodeOnSite($coupon_code);
}