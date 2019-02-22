<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/22/18
 * Time: 21:13
 */

namespace App\Repositories\InterfaceRepository;

interface RoomTypeRepositoryInterface
{
    /**
     * Get coupon
     * @return mixed
     */
    public function getRoomType($params);

    public function getRoomTypeNeedConfirm($params);

    public function getRoomTypeConfirm($id);

    public function getAllRoomTypeConfirm();
}