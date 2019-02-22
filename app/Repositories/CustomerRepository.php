<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/7/18
 * Time: 16:06
 */

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\InterfaceRepository\CustomerRepositoryInterface;

class CustomerRepository extends EloquentRepository implements CustomerRepositoryInterface
{
    public function getModel()
    {
        return Customer::class;
    }

    public function getCustomer($params)
    {
        $model = $this->_model->where('id', '>', 0);

        if ($params['q'] != '') {
            if (filter_var($params['q'], FILTER_VALIDATE_EMAIL)) {
                $model->where('email', 'like', $params['q'] . '%');
            } else {
                $model->where('name', 'like', '%' . $params['q'] . '%');
            }
        }


        if ($params['status'] !== 'all') {
            $model->where('status', $params['status']);
        }

        return $model->skip($params['offset'])
            ->take($params['limit'])
            ->get();
    }


    public function getInfoBasic()
    {
        return $this->_model->getInfo();
    }
}