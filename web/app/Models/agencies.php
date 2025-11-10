<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class agencies extends Model
{
    protected $table = 'agencies';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function main_agencies()
    {
        return $this->belongsTo(MainAgencies::class);
    }
}
