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
        return $this->belongsTo(cases::class, 'cases_id');
    }

     public function firstSubmitter()
    {
        return $this->belongsTo(User::class, 'first_submitter_id');
    }

    public function secondSubmitter()
    {
        return $this->belongsTo(User::class, 'second_submitter_id');
    }

}
