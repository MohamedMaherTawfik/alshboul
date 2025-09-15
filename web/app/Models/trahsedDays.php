<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class trahsedDays extends Model
{
    protected $table = 'trahsed_days';
    protected $guarded = [];
    public function cases()
    {
        return $this->belongsTo(cases::class);
    }

    public function excutiveCases()
    {
        return $this->belongsTo(ExecutiveCase::class);
    }

    public function settlements()
    {
        return $this->belongsTo(Settlement::class);
    }

    public function transactions()
    {
        return $this->belongsTo(TransActions::class, 'trans_actions_id');
    }
}