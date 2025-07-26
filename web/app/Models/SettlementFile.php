<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettlementFile extends Model
{
    protected $fillable = [
        'settlement_action_id',
        'file_path',
        'created_by',
        'updated_by',
    ];

    public function settlementAction()
    {
        return $this->belongsTo(SettlementAction::class);
    }

    public function proceduralRecord()
    {
        return $this->belongsTo(ProceduralRecord::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
