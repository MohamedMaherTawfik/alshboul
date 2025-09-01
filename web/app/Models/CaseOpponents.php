<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseOpponents extends Model
{
    protected $table = 'case_opponents';
    protected $guarded = [];

    public function case()
    {
        return $this->belongsTo(Cases::class);
    }

    public function executiveCase()
    {
        return $this->belongsTo(ExecutiveCase::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
