<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cases extends Model
{
    protected $table = 'cases';
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function suggestedCases()
    {
        return $this->belongsTo(CaseType::class, 'suggested_case_id');
    }

    public function requestedCases()
    {
        return $this->belongsTo(CaseType::class, 'requested_case_id');
    }

    public function added_by()
    {
        return $this->belongsTo(User::class);
    }

    public function courtSession()
    {
        return $this->hasMany(court_session_date::class);
    }
}