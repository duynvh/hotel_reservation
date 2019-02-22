<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/22/18
 * Time: 21:13
 */

namespace App\Repositories\InterfaceRepository;

interface ItemRepositoryInterface
{
    /**
     * Get coupon
     * @return mixed
     */
    public function getItem($params);

    public function getItemNeedConfirm($params);

    public function getItemConfirm($id);

    public function getAllItemConfirm();
}