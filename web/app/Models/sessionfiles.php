<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sessionfiles extends Model
{
    protected $table = 'sessionfiles';

    protected $guarded = [];

    public function session()
    {
        return $this->belongsTo(court_session_date::class);
    }
}
