<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Settlement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'subscriber_name',
        'client_national_id',
        'client_id',
        'opponent_name',
        'opponent_national_id',
        'settlement_type_id',
        'judged_for_role',
        'judged_against_role',
        'commitment_status',
        'opponent_phone',
        'office_file_number',
        'lawsuit_number',
        'address',
        'debt_value',
        'payment_value',
        'installment_type',
        'settlement_details',
        'created_by',
        'updated_by',
        'delete_reason',
    ];

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
