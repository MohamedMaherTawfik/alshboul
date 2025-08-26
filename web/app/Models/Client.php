<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Client extends Model
{
    use SoftDeletes, Notifiable;

    protected $table = 'clients';
    protected $dates = ['deleted_at'];

    protected $guarded = [];

    public function addedby()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
    public function updateby()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function visits()
    {
        return $this->hasMany(VisitClient::class);
    }

    public function archives()
    {
        return $this->hasMany(archives::class);
    }

    public function missions()
    {
        return $this->hasMany(Missions::class);
    }

    public function cases()
    {
        return $this->hasMany(cases::class);
    }
}
