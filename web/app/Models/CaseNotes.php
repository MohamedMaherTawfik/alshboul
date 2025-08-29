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