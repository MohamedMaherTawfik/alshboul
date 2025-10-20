<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class expenses extends Model
{
    protected $table = 'expenses';
    protected $guarded = [];
    public function case()
    {
        return $this->belongsTo(cases::class);
    }
}
