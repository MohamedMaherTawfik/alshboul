<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubAction extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function addedby()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
    public function updateby()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function mainAction()
    {
        return $this->belongsTo(MainAction::class);
    }

    public function executor()
    {
        return $this->belongsTo(User::class, 'executed_by');
    }
}
