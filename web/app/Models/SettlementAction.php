<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettlementAction extends Model
{
    protected $fillable = [
        'settlement_id',
        'action_date',
        'type',
        'action',
        'notes',
        'next_action',
        'next_action_date',
        'created_by',
        'updated_by',
    ];

    public function settlement()
    {
        return $this->belongsTo(Settlement::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function files()
    {
        return $this->hasMany(SettlementFile::class);
    }
}
