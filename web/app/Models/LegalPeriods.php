<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalPeriods extends Model
{
    protected $table = 'legal_periods';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function case()
    {
        return $this->belongsTo(Cases::class, 'cases_id');
    }
}