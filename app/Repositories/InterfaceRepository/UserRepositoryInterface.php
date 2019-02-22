<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/22/18
 * Time: 21:13
 */

namespace App\Repositories\InterfaceRepository;


interface UserRepositoryInterface
{
    /**
     * Get coupon
     * @return mixed
     */
    public function getUser($params, $id);

    public function getUserNeedConfirm($params, $id);

    public function getUserConfirm($id);
    public function getAllUserConfirm();
}