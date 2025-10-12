<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseOpponents extends Model
{
    protected $table = 'case_opponents';
    protected $guarded = [];

    public function case()
    {
        return $this->belongsTo(cases::class, 'cases_id');
    }

    public function executiveCase()
    {
        return $this->belongsTo(ExecutiveCase::class, 'executive_case_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}