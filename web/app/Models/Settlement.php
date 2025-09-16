<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Settlement extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    // العلاقات
    public function settlementType()
    {
        return $this->belongsTo(SettlementType::class);
    }

    public function actions()
    {
        return $this->hasMany(SettlementAction::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cases()
    {
        return $this->belongsTo(Cases::class);
    }

    public function excutiveCases()
    {
        return $this->belongsTo(ExecutiveCase::class, 'executive_case_id');
    }

    public function settlementMain()
    {
        return $this->belongsTo(SettlementMain::class);
    }

    public function proceduralRedords()
    {
        return $this->hasMany(ProceduralRecord::class, 'settlement_id');
    }

    public function trahsedDays()
    {
        return $this->hasMany(trahsedDays::class);
    }
}