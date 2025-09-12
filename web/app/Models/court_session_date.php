<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class court_session_date extends Model
{
    protected $table = 'court_session_dates';
    protected $guarded = [];
    public function cases()
    {
        return $this->belongsTo(cases::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }

    public function sessionFiles()
    {
        return $this->hasMany(sessionfiles::class);
    }

    public function lawyer_user()
    {
        return $this->belongsTo(User::class, 'lawyer_user_id');
    }

    public function excutiveCases()
    {
        return $this->belongsTo(ExecutiveCase::class);
    }
}