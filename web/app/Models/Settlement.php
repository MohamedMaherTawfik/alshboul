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
}
