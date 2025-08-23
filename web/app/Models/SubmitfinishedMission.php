<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmitfinishedMission extends Model
{
    protected $table = 'submitfinished_missions';
    protected $guarded = [];

    public function firstLawyer()
    {
        return $this->belongsTo(Lawyer::class, 'first_lawyer_id');
    }

    public function secondLawyer()
    {
        return $this->belongsTo(Lawyer::class, 'second_lawyer_id');
    }

    public function mission()
    {
        return $this->belongsTo(Missions::class, 'mission_id');
    }
}
