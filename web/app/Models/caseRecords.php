<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class caseRecords extends Model
{
    protected $table = 'case_records';
    protected $guarded = [];

    public function case()
    {
        return $this->belongsTo(cases::class, 'cases_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
