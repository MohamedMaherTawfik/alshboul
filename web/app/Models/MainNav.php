<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainNav extends Model
{
    protected $table = 'main_navs';

    protected $guarded = [];

    public function subNav()
    {
        return $this->hasMany(subNav::class);
    }
}
