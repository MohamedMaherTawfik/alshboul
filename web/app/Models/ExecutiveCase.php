<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExecutiveCase extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'subscriber_name',
        'client_id',
        'client_national_id',
        'opponent_name',
        'opponent_national_id',
        'office_file_number',
        'lawsuit_number',
        'suggested_file_number',
        'case_status',
        'claim_value',
        'execution_department',
        'document_type',
        'judged_for',
        'judged_against',
        'registration_date',
        'document_number',
        'judged_for_role',
        'judged_against_role',
        'created_by',
        'updated_by',
        'delete_reason',
        'deleted_at'
    ];

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
}
