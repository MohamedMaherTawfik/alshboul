<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseType extends Model
{
    protected $table = 'case_types';
    protected $fillable = ['name_ar', 'name_en', 'description_ar', 'description_en', 'image'];
}
