<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/7/18
 * Time: 00:20
 */

namespace App\Repositories;

use App\Models\Group;
use App\Repositories\InterfaceRepository\GroupRepositoryInterface;

class GroupRepository extends EloquentRepository implements GroupRepositoryInterface
{
    public function getModel()
    {
        return Group::class;
    }

    public function getGroup($params) {
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

    public function lists() {
        return $this->_model->where('status', '<>', 'delete')->pluck('name', 'id')->all();
    }


    public function getInfoBasic()
    {
        return $this->_model->getInfo();
    }
}