<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplyCareer extends Model
{
    protected $table = 'apply_careers';
    protected $fillable = ['full_name', 'brith_date', 'career_id','phone','cv_file' ];

    public function career()
    {
        return $this->belongsTo(Career::class);
    }
}
