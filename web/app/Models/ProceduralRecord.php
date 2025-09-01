<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ProceduralRecord extends Model
{
    protected $table = 'procedural_redords';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id');
    }
    public function case()
    {
        return $this->belongsTo(ExecutiveCase::class, 'executive_case_id');
    }

    public function files()
    {
        return $this->hasMany(ProceduralFile::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function cases()
    {
        return $this->belongsTo(cases::class, 'cases_id');
    }

    public function subProcedurals()
    {
        return $this->hasMany(subrocedural::class);
    }

    public function userLawyer()
    {
        return $this->belongsTo(User::class, 'user_lawyer_id');
    }
}
