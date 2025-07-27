<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ProceduralRecord extends Model
{
    protected $table = 'procedural_redords';
    protected $fillable = [
        'executive_case_id',
        'session_date',
        'type',
        'action',
        'lawyer',
        'notes',
        'next_action',
        'next_action_date',
        'created_by',
        'updated_by'
    ];

    public function case()
    {
        return $this->belongsTo(ExecutiveCase::class, 'executive_case_id');
    }

    public function files()
    {
        return $this->hasMany(ProceduralFile::class);
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