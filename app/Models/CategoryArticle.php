<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/17/18
 * Time: 13:28
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryArticle extends Model
{
    use SoftDeletes;
    protected        $table     = "categories_article";
    protected        $title     = "Category Article";
    protected        $route     = "category-article";
    protected        $view      = "admin.pages.category-article.";
    protected static $key_cache = "categories_article";
    protected        $fillable = [
        'name',
        'slug',
        'status',
        'description',
        'parent',
        'level',
        'left',
        'right',
        'show_frontend',
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

    public function article() {
        return $this->hasMany("App\Models\Article");
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