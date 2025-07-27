<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettlementType extends Model
{
    protected $table = 'settlements';
    protected $fillable = [
        'name_ar',
        'name_en',
    ];

    public function settlements()
    {
        return $this->hasMany(Settlement::class);
    }
}