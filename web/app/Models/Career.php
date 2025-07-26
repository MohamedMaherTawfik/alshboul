<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $table = 'careers';
    protected $fillable = ['name_ar', 'name_en', 'active'];
}
