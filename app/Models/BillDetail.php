<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/6/18
 * Time: 13:03
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    protected        $table     = "bill_details";
    protected        $title     = "Bill Detail";
    protected        $route     = "billdetail";
    protected        $view      = "admin.pages.billdetail.";
    protected static $key_cache = "bill_details";
    protected        $fillable  = [
        'id',
        'bill_id',
        'product_id',
        'price',
        'size',
        'color',
        'qty',
    ];

    public function product() {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }



    public function getInfo() {
        return [
            'route' => $this->route,
            'view'  => $this->view,
            'title' => $this->title
        ];
    }
}