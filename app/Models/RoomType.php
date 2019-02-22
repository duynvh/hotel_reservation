<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/6/18
 * Time: 12:57
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomType extends Model
{
    use SoftDeletes;

    protected        $table     = "rooms_type";
    protected        $title     = "Loại phòng";
    protected        $route     = "room-type";
    protected        $view      = "admin.pages.room_type.";
    protected static $key_cache = "rooms_type";
    protected        $fillable  = [
        'id',
        'name',
        'slug',
        'description',
        'status',
        'image',
        'content',
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

    public function room() {
        return $this->hasMany("App\Models\Room");
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