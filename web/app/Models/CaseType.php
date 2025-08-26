<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseType extends Model
{
    protected $table = 'case_types';
    protected $fillable = ['name', 'description', 'image'];

    public function suggestedCases()
    {
        return $this->hasMany(cases::class);
    }

    public function requestedCases()
    {
        return $this->hasMany(cases::class);
    }
}
