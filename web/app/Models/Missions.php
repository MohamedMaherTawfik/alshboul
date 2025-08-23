<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Missions extends Model
{
    protected $table = 'missions';
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function first_lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }

    public function second_lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }

    public function submitFinishedMissions()
    {
        return $this->hasMany(SubmitfinishedMission::class, 'mission_id');
    }

    public function added_by()
    {
        return $this->belongsTo(User::class, 'added_by_id', 'id');
    }
}