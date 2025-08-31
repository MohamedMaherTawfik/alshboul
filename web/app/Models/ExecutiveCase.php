<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExecutiveCase extends Model
{
    use SoftDeletes;

    protected $table = 'executive_cases';
    protected $guarded = [];

    public function mainExecutiveCases()
    {
        return $this->belongsTo(excutiveCasesMain::class, 'excutive_cases_main_id');
    }
    public function proceduralRecords()
    {
        return $this->hasMany(ProceduralRecord::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function excecutiveCasesMain()
    {
        return $this->belongsTo(excutiveCasesMain::class, 'excutive_cases_main_id');
    }

    public function settlements()
    {
        return $this->hasMany(Settlement::class);
    }
}