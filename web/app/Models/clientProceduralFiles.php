<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class clientProceduralFiles extends Model
{
    protected $table = 'client_procedural_files';
    protected $guarded = [];

    public function clientProcedural()
    {
        return $this->belongsTo(clientProcedural::class);
    }
}