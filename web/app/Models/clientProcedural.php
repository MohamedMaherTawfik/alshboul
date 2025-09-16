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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subProcedurals()
    {
        return $this->hasMany(subrocedural::class);
    }

    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id');
    }

    public function clientProceduralFiles()
    {
        return $this->hasMany(clientProceduralFiles::class);
    }
}
