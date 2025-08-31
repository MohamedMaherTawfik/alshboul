<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettlementMain extends Model
{
    protected $table = 'settlement_mains';
    protected $guarded = [];

    public function settlements()
    {
        return $this->hasMany(Settlement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function NegligenceDays()
    {
        return $this->hasMany(NegligenceDays::class, 'settlement_main_id');
    }
}