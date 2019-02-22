<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/22/18
 * Time: 21:13
 */

namespace App\Repositories\InterfaceRepository;

interface RoomRepositoryInterface
{
    /**
     * Get coupon
     * @return mixed
     */
    public function getRoom($params);

    public function getRoomNeedConfirm($params);

    public function getRoomConfirm($id);

    public function getAllRoomConfirm();
}