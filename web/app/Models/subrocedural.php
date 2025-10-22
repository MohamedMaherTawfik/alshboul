<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class subrocedural extends Model
{
    protected $table = 'subrocedurals';

    protected $guarded = [];
    public function procedural()
    {
        return $this->belongsTo(ProceduralRecord::class);
    }

    public function clientProcedural()
    {
        return $this->belongsTo(clientProcedural::class);
    }

    public function subProcedurals()
    {
        return $this->hasMany(subrocedural::class);
    }

    public function files()
    {
        return $this->hasMany(clientProceduralFiles::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id');
    }
}