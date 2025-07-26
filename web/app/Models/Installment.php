<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $table = 'installments';
    protected $fillable = ['agreement_id', 'amount', 'due_date', 'is_paid'];

    public function agreement()
    {
        return $this->belongsTo(Agreement::class);
    }
}
