<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class archivesSubMenues extends Model
{
    protected $table = 'archives_sub_menues';

    protected $guarded = [];

    public function archivesMainMenues()
    {
        return $this->belongsTo(archivesMainMenues::class, 'main_menu_id');
    }

    public function archives()
    {
        return $this->hasMany(archives::class, 'sub_menu_id');
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
