<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/6/18
 * Time: 13:03
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected        $table     = "bills";
    protected        $title     = "Bill";
    protected        $route     = "bill";
    protected        $view      = "admin.pages.bill.";
    protected static $key_cache = "bills";
    protected        $fillable  = [
        'id',
        'price_sale',
        'amount',
        'note',
        'status',
        'email',
        'full_name',
        'phone',
        'address',
        'user_id',
    ];

    public function user() {
        return $this->hasMany('App\Models\User');
    }



    public function getInfo() {
        return [
            'route' => $this->route,
            'view'  => $this->view,
            'title' => $this->title
        ];
    }
}