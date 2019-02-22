<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/10/18
 * Time: 10:42
 */

namespace App\Repositories;

use App\Models\Item;
use App\Repositories\InterfaceRepository\ItemRepositoryInterface;

class ItemRepository extends EloquentRepository implements ItemRepositoryInterface
{
    public function getModel()
    {
        return Item::class;
    }

    public function getItem($params)
    {
        $model = $this->_model->where('id', '>', 0);
        if ($params['q'] != '') {
            $model->where('name', 'like', '%' . $params['q'] . '%');
        }

        if (isset($params['status']) && $params['status'] != 'all') {
            $model->where('status', $params['status']);
        }

        return $model->skip($params['offset'])
            ->take($params['limit'])
            ->get();
    }

    public function getItemNeedConfirm($params)
    {
        $model = $this->_model->where('id', '>', 0);

        if ($params['q'] != '') {
            $model->where('name', 'like', '%' . $params['q'] . '%');
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

    public function getItemConfirm($id)
    {
        return $this->_model->withoutGlobalScope('confirm')->where('id', $id)->first();
    }

    public function getAllItemConfirm()
    {
        return $this->_model->withoutGlobalScope('confirm')->where('confirm_action', "<>", NULL)->get();
    }

    public function getInfoBasic()
    {
        return $this->_model->getInfo();
    }
}