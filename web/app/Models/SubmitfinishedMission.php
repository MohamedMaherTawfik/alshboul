<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmitfinishedMission extends Model
{
    protected $table = 'submitfinished_missions';
    protected $guarded = [];

    public function firstLawyer()
    {
        return $this->belongsTo(User::class, 'first_lawyer_id_user');
    }

    public function secondLawyer()
    {
        return $this->belongsTo(User::class, 'second_lawyer_id_user');
    }

    public function mission()
    {
        return $this->belongsTo(Missions::class, 'mission_id');
    }
}
