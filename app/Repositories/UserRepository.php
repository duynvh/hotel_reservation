<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/7/18
 * Time: 16:06
 */

namespace App\Repositories;

use App\Models\User;
use App\Repositories\InterfaceRepository\UserRepositoryInterface;

class UserRepository extends EloquentRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function getUser($params, $id)
    {
        $model = $this->_model->where('id', '>', 0);

        if ($params['q'] != '') {
            if (filter_var($params['q'], FILTER_VALIDATE_EMAIL)) {
                $model->where('email', 'like', $params['q'] . '%');
            } else {
                $model->where('name', 'like', '%' . $params['q'] . '%');
            }
        }

        if ($params['group_id'] && intval($params['group_id']) > 0) {
            $model->where('group_id', intval($params['group_id']));
        }

        if ($params['status'] !== 'all') {
            $model->where('status', $params['status']);
        }

        return $model->skip($params['offset'])
            ->where('id', '<>', $id)
            ->take($params['limit'])
            ->get();
    }

    public function getUserNeedConfirm($params, $id)
    {
        $model = $this->_model->where('id', '>', 0);

        if ($params['q'] != '') {
            if (filter_var($params['q'], FILTER_VALIDATE_EMAIL)) {
                $model->where('email', 'like', $params['q'] . '%');
            } else {
                $model->where('name', 'like', '%' . $params['q'] . '%');
            }
        }

        if ($params['group_id'] && intval($params['group_id']) > 0) {
            $model->where('group_id', intval($params['group_id']));
        }

        if ($params['confirm_action'] !== 'all') {
            $model->where('confirm_action', $params['confirm_action']);
        }

        return $model->skip($params['offset'])
            ->withoutGlobalScope('confirm')
            ->where('confirm_action', "<>", NULL)
            ->where('id', '<>', $id)
            ->take($params['limit'])
            ->get();
    }

    public function getUserConfirm($id)
    {
        return $this->_model->withoutGlobalScope('confirm')->where('id', $id)->first();
    }

    public function getAllUserConfirm()
    {
        return $this->_model->withoutGlobalScope('confirm')->where('confirm_action', "<>", NULL)->get();
    }

    public function getInfoBasic()
    {
        return $this->_model->getInfo();
    }
}