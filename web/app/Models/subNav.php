<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class subNav extends Model
{
    protected $table = 'sub_navs';
    protected $guarded = [];

    public function mainNav()
    {
        return $this->belongsTo(MainNav::class);
    }

    public function neglienceDays()
    {
        return $this->hasMany(NegligenceDays::class);
    }

    public function proceduralRecords()
    {
        return $this->hasMany(ProceduralRecord::class, 'sub_nav_id');
    }
}