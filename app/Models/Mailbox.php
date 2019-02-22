<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mailbox extends Model
{
    use SoftDeletes;
    protected        $table     = "mailboxes";
    protected        $title     = "Mailbox";
    protected        $route     = "mailbox";
    protected        $view      = "admin.pages.mailbox.";
    protected static $key_cache = "mailboxes";
    protected        $fillable  = [
        'id',
        'subject',
        'email',
        'full_name',
        'message',
        'phone',
        'address',
        'status',
        'trash',
    ];
    protected           $dates      = ['deleted_at'];

    public static function noticeMailbox() {
        return static::where([
            'status'    => 0,
            'trash'     => 0
        ])->orderBy('created_at', 'desc')->get();
    }

    public static function countNoticeMailbox() {
        return count(static::noticeMailbox());
    }

    public function getInfo() {
        return [
            'route' => $this->route,
            'view'  => $this->view,
            'title' => $this->title
        ];
    }
}