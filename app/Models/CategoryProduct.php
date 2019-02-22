<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/6/18
 * Time: 13:00
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryProduct extends Model
{
    use SoftDeletes;
    protected        $table     = "categories_product";
    protected        $title     = "Category Product";
    protected        $route     = "category-product";
    protected        $view      = "admin.pages.category-product.";
    protected static $key_cache = "categories_product";
    protected        $fillable  = [
        'id',
        'name',
        'slug',
        'status',
        'description',
        'show_frontend',
        'level',
        'left',
        'right',
        'parent',
        'confirm_action',
        'data_update'
    ];
    protected           $dates      = ['deleted_at'];

    public function product() {
        return $this->hasMany("App\Models\Product");
    }

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