<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NegligenceDays extends Model
{
    protected $table = 'negligence_days';
    protected $guarded = [];

    public function caseTypes()
    {
        return $this->belongsTo(CaseType::class, 'case_type_id');
    }

    public function executiveCases()
    {
        return $this->belongsTo(excutiveCasesMain::class, 'excutive_cases_main_id');
    }

    public function settlements()
    {
        return $this->belongsTo(SettlementMain::class, 'settlement_main_id');
    }

    public function transactions()
    {
        return $this->belongsTo(TransactionsMain::class, 'transactions_main_id');
    }

    public function subNav()
    {
        return $this->belongsTo(subNav::class);
    }
}