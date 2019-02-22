<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/18/18
 * Time: 22:18
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected           $table      = "settings";
    protected           $fillable  = [
        'id',
        'option_name',
        'option_value'
    ];
}