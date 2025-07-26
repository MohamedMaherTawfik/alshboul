<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class ClientRequest extends Model
{
    use SoftDeletes, Notifiable;
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    public function addedby()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function repliedby()
    {
        return $this->belongsTo(User::class, 'replied_by');
    }
}
