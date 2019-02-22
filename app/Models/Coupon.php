<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/22/18
 * Time: 20:35
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;

    protected        $table     = "coupons";
    protected        $title     = "Coupon";
    protected        $route     = "coupon";
    protected        $view      = "coupons::";
    protected static $key_cache = "admin.pages.coupon.";
    protected        $fillable  = [
        'id',
        'coupon_code',
        'amount',
        'amount_type',
        'start_date',
        'status',
        'end_date',
        'confirm_action',
        'data_update'
    ];
    protected           $dates      = ['deleted_at'];

    public function getInfo() {
        return [
            'route' => $this->route,
            'view'  => $this->view,
            'title' => $this->title
        ];
    }

    protected static function boot()
    {
        parent::boot();

        // A global scope is applied to all queries on this model
        // -> No need to specify visibility restraints on every query
        static::addGlobalScope('confirm', function (Builder $builder) {
            $builder->where('confirm_action', '=', null);
        });
    }
}