<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class visitWeb extends Model
{
    protected $table = 'visit_webs';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}