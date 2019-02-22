<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/10/18
 * Time: 10:42
 */

namespace App\Repositories;

use DB;
use App\Models\Bill;
use App\Repositories\InterfaceRepository\BillRepositoryInterface;
use Carbon\Carbon;

class BillRepository extends EloquentRepository implements BillRepositoryInterface
{
    public function getModel()
    {
        return Bill::class;
    }

    public function getBill($params)
    {
        $model = $this->_model->where('id', '>', 0);

        if ($params['q'] != '') {
            $model->where('name', 'like', '%' . $params['q'] . '%');
        }

        if (isset($params['status']) && $params['status'] != 'all') {
            $model->where('status', $params['status']);
        }

        return $model->skip($params['offset'])
            ->orderBy('created_at', 'DESC')
            ->take($params['limit'])
            ->get();
    }

    public function getInfoBasic()
    {
        return $this->_model->getInfo();
    }

    public function getAllBill()
    {
        return $this->_model->orderBy('created_at', 'DESC')->get();
    }

    public function getBillToday()
    {
        return $this->_model->whereDate('created_at', Carbon::today())->orderBy('created_at', 'DESC')->get();
    }

    public function getBillSuccess() {
        return $this->_model->where('status', 'success')->get();
    }

    public function chartBillSuccess() {
        $data = $this->_model
                ->select(DB::raw('sum(amount) as `amount`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
                ->where('status', 'success')
                ->groupby('year','month')
                ->get();
        return $data;
    }
}