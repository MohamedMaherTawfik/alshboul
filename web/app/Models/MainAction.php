<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainAction extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function subActions()
    {
        return $this->hasMany(SubAction::class);
    }

    public function addedby()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
    public function updateby()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
