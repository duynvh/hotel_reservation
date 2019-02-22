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

class Room extends Model
{
    use SoftDeletes;

    protected        $table     = "rooms";
    protected        $title     = "Phòng";
    protected        $route     = "room";
    protected        $view      = "admin.pages.room.";
    protected static $key_cache = "rooms";
    protected        $fillable  = [
        'id',
        'room_number',
        'name',
        'price',
        'room_type_id',
        'status',
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

    public function roomType() {
        return $this->belongsTo("App\Models\RoomType",'room_type_id', 'id');
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