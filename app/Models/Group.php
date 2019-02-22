<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/6/18
 * Time: 12:51
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;

    protected           $table      = "groups";
    protected           $title      = "Group";
    protected           $route      = "group";
    protected           $view       = "admin.pages.group.";
    protected static    $key_cache  = "groups";
    protected           $fillable   = ['id', 'name', 'status'];
    protected           $dates      = ['deleted_at'];

    public function getInfo() {
        return [
            'route' => $this->route,
            'view'  => $this->view,
            'title' => $this->title
        ];
    }

    public function user() {
        return $this->hasMany("App\Models\User");
    }
}