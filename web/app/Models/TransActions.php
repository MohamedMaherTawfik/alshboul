<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransActions extends Model
{
    protected $table = 'trans_actions';
    protected $guarded = [];

    public function transactionsMain()
    {
        return $this->belongsTo(TransactionsMain::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
