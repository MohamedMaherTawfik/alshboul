<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class excutiveCasesMain extends Model
{
    protected $table = 'excutive_cases_mains';
    protected $guarded = [];
    public function excutiveCases()
    {
        return $this->hasMany(ExecutiveCase::class, 'excutive_cases_main_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function NegligenceDays()
    {
        return $this->hasMany(NegligenceDays::class, 'excutive_cases_main_id');
    }
}
