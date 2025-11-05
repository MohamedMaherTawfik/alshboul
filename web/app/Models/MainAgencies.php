<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainAgencies extends Model
{
    protected $table = 'main_agencies';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agencies()
    {
        return $this->hasMany(Agencies::class);
    }
}
