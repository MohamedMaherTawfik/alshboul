<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettlementType extends Model
{
    protected $table = 'settlement_types';
    protected $guarded = [];

    public function settlements()
    {
        return $this->hasMany(Settlement::class);
    }
}