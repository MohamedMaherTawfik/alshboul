<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ProceduralFile extends Model
{


    protected $guarded = [];

    public function proceduralRecord()
    {
        return $this->belongsTo(ProceduralRecord::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}