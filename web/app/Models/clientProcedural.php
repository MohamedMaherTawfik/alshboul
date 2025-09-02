<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class clientProcedural extends Model
{
    protected $table = 'client_procedurals';
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
