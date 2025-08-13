<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class archivesMainMenues extends Model
{
    protected $table = 'archives_main_menues';

    protected $guarded = [];

    public function archivesSubMenues()
    {
        return $this->hasMany(archivesSubMenues::class, 'main_menu_id');
    }

    public function added_by()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}