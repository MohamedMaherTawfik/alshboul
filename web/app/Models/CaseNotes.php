<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseNotes extends Model
{
    protected $table = 'case_notes';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function case()
    {
        return $this->belongsTo(Cases::class, 'cases_id');
    }
}