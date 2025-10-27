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

    public function subscriber()
    {
        return $this->belongsTo(user::class, 'subscriber_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function procedural()
    {
        return $this->hasMany(ProceduralRecord::class, 'trans_actions_id');
    }

    public function trahsedDays()
    {
        return $this->hasMany(trahsedDays::class, 'trans_actions_id');
    }
}
