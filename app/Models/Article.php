<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/19/18
 * Time: 13:39
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected        $table     = "articles";
    protected        $title     = "Article";
    protected        $route     = "article";
    protected        $view      = "article::";
    protected static $key_cache = "admin.pages.article.";
    protected        $fillable  = [
        'id',
        'name',
        'slug',
        'image',
        'content',
        'status',
        'description',
        'category_article_id',
        'confirm_action',
        'data_update'
    ];
    protected           $dates      = ['deleted_at'];

    public function categoryArticle() {
        return $this->belongsTo("App\Models\CategoryArticle",'category_article_id', 'id');
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