<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/10/18
 * Time: 10:42
 */

namespace App\Repositories;

use App\Models\BillDetail;
use App\Repositories\InterfaceRepository\BillDetailRepositoryInterface;

class BilldetailRepository extends EloquentRepository implements BillDetailRepositoryInterface
{
    public function getModel()
    {
        return BillDetail::class;
    }

    public function getBillDetail($params)
    {
        $model = $this->_model->where('id', '>', 0);

        if ($params['q'] != '') {
            $model->where('name', 'like', '%' . $params['q'] . '%');
        }

        if (isset($params['status']) && $params['status'] != 'all') {
            $model->where('status', $params['status']);
        }

        if (isset($params['type']) && $params['type'] != 'all') {
            $model->where('type', $params['type']);
        }

        return $model->skip($params['offset'])
            ->take($params['limit'])
            ->get();
    }

    public function getBillDetailByBillId($id)
    {
        return $this->_model->where('bill_id', $id)->get();
    }

    public function getBestSellProductOnSite()
    {
        return $this->_model
            ->sum('qty')
            ->groupBy('product_id')
            ->orderBy('qty', 'desc')
            ->pluck()
            ->take(3);
    }
}