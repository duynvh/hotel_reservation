<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/10/18
 * Time: 10:42
 */

namespace App\Repositories;

use App\Models\Room;
use App\Repositories\InterfaceRepository\RoomRepositoryInterface;

class RoomRepository extends EloquentRepository implements RoomRepositoryInterface
{
    public function getModel()
    {
        return Room::class;
    }

    public function getRoom($params)
    {
        $model = $this->_model->where('id', '>', 0);

        if ($params['q'] != '') {
            $model->where('coupon_code', 'like', '%' . $params['q'] . '%');
        }

        if (isset($params['amount_type']) && $params['amount_type'] != 'all') {
            $model->where('amount_type', $params['amount_type']);
        }

        if (isset($params['status']) && $params['status'] != 'all') {
            $model->where('status', $params['status']);
        }

        return $model->skip($params['offset'])
            ->take($params['limit'])
            ->get();
    }

    public function getRoomNeedConfirm($params)
    {
        $model = $this->_model->where('id', '>', 0);

        if ($params['q'] != '') {
            $model->where('coupon_code', 'like', '%' . $params['q'] . '%');
        }

        if (isset($params['amount_type']) && $params['amount_type'] != 'all') {
            $model->where('amount_type', $params['amount_type']);
        }

        if (isset($params['confirm_action']) && $params['confirm_action'] != 'all') {
            $model->where('confirm_action', $params['confirm_action']);
        }

        return $model->skip($params['offset'])
            ->withoutGlobalScope('confirm')
            ->where('confirm_action', "<>", NULL)
            ->take($params['limit'])
            ->get();
    }

    public function getRoomConfirm($id)
    {
        return $this->_model->withoutGlobalScope('confirm')->where('id', $id)->first();
    }

    public function getAllRoomConfirm()
    {
        return $this->_model->withoutGlobalScope('confirm')->where('confirm_action', "<>", NULL)->get();
    }

    public function getInfoBasic()
    {
        return $this->_model->getInfo();
    }
}