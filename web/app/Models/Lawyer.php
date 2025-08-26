<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Lawyer extends Model
{
    use SoftDeletes, Notifiable;
    protected $dates = ['deleted_at'];

    protected $guarded = [];

    public function addedby()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
    public function updateby()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function firstLawyers()
    {
        return $this->hasMany(Missions::class, 'first_lawyer');
    }

    public function secondLawyers()
    {
        return $this->hasMany(Missions::class, 'second_lawyer');
    }


    public function firstLawyerSubmits()
    {
        return $this->hasMany(SubmitfinishedMission::class, 'first_lawyer_id');
    }

    public function secondLawyerSubmits()
    {
        return $this->hasMany(SubmitfinishedMission::class, 'second_lawyer_id');
    }

    public function courseSessions()
    {
        return $this->hasMany(court_session_date::class);
    }
}
