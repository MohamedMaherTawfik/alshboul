<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseType extends Model
{
    protected $table = 'case_types';
    protected $fillable = ['name', 'description', 'image'];

    public function suggestedCases()
    {
        return $this->hasMany(cases::class, 'suggested_case_id');
    }

    public function requestedCases()
    {
        return $this->hasMany(cases::class);
    }

    public function NegligenceDays()
    {
        return $this->hasMany(NegligenceDays::class, 'case_type_id');
    }

}