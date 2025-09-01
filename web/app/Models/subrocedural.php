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
}