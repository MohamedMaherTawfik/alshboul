<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agreement extends Model
{
    //
    use SoftDeletes;
    protected $table = 'agreements';
    protected $fillable = [
        'agreement_number',
        'first_party',
        'second_party',
        'agreement_date',
        'subject',
        'amount',
        'created_by',
        'represented_by',
        'updated_by',
        'delete_reason',
        'agreement_type',
        'installments_count',
        'installment_interval_months',
        'first_installment_date'
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }
    public function firstParty()
    {
        return $this->belongsTo(Client::class, 'first_party');
    }
    public function representor()
    {
        return $this->belongsTo(User::class, 'represented_by');
    }
}
