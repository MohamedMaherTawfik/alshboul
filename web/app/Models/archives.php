<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class archives extends Model
{
    protected $table = 'archives';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function archivesSubMenues()
    {
        return $this->belongsTo(archivesSubMenues::class, 'sub_menu_id');
    }
}
