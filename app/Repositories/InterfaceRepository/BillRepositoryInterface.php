<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/22/18
 * Time: 21:13
 */

namespace App\Repositories\InterfaceRepository;


interface BillRepositoryInterface
{
    /**
     * Get coupon
     * @return mixed
     */
    public function getBill($params);
    public function getInfoBasic();
    public function getAllBill();
    public function getBillToday();
    public function chartBillSuccess();
}