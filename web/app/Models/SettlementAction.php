<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettlementAction extends Model
{
    protected $table = 'settlement_actions';
    protected $guarded = [];
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
