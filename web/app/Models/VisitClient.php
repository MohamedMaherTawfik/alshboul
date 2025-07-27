<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitClient extends Model
{

    protected $table = 'visit_clients';
    protected $guarded = [];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}