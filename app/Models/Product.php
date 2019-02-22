<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/6/18
 * Time: 13:03
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected        $table     = "products";
    protected        $title     = "Product";
    protected        $route     = "product";
    protected        $view      = "admin.pages.product.";
    protected static $key_cache = "products";
    protected        $fillable  = [
        'id',
        'name',
        'slug',
        'image',
        'new',
        'check_item',
        'image_detail',
        'content',
        'status',
        'description',
        'price',
        'price_old',
        'category_product_id',
        'confirm_action',
        'data_update'
    ];
    protected           $dates      = ['deleted_at'];

    public function categoryProduct() {
        return $this->belongsTo("App\Models\CategoryProduct",'category_product_id', 'id');
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