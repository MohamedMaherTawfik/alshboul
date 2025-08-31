<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionsMain extends Model
{
    protected $table = 'transactions_mains';

    protected $guarded = [];

    public function transactions()
    {
        return $this->hasMany(Transactions::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function NegligenceDays()
    {
        return $this->hasMany(NegligenceDays::class, 'transactions_main_id');
    }

}
