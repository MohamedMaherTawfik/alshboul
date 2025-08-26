<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class searchIndex extends Model
{
    protected $table = 'search_indices';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
