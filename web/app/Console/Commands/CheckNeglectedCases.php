<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cases;
use App\Models\CaseType;
use App\Models\NegligenceDays;
use App\Models\trahsedDays;
use Illuminate\Support\Carbon;

class CheckNeglectedCases extends Command
{
    /**
     * اسم الكوماند اللي ممكن نشغله يدويًا
     */
    protected $signature = 'cases:check-neglected';

    /**
     * وصف الكوماند
     */
    protected $description = 'Check for neglected cases and update trahsedDays table accordingly';

    public function handle()
    {
        $caseTypes = CaseType::all();

        foreach ($caseTypes as $casetype) {
            $cases = Cases::with('caseOpponents')
                ->where('suggested_case_id', $casetype->id)
                ->where('active', 1)
                ->get()
                ->sortBy('case_number');

            $neglectConfig = NegligenceDays::where('case_type_id', $casetype->id)->first();

            if ($neglectConfig && $neglectConfig->days > 0) {

                foreach ($cases as $case) {
                    $totalEvents = $case->courtSession()->count()
                        + $case->legalPeriods()->count()
                        + $case->caseNotes()->count()
                        + $case->proceduralRedords()->count();

                    $trashed = trahsedDays::where('cases_id', $case->id)->first();

                    if (!$trashed) {
                        trahsedDays::create([
                            'cases_id' => $case->id,
                            'counts' => $totalEvents,
                            'days_passed' => 0,
                            'is_seen' => 0,
                            'day' => now()->format('Y-m-d'),
                            'updated_at' => now()->format('Y-m-d')
                        ]);
                    } elseif ($totalEvents > $trashed->counts) {
                        $trashed->update([
                            'counts' => $totalEvents,
                            'days_passed' => 0,
                            'is_seen' => 0,
                            'day' => now()->format('Y-m-d'),
                            'updated_at' => now()->format('Y-m-d')
                        ]);
                    } elseif ($totalEvents == $trashed->counts) {
                        if ($trashed->day && $trashed->updated_at) {
                            $day = Carbon::parse($trashed->day);
                            $updated = Carbon::parse($trashed->updated_at);
                            $diffInDays = abs(ceil($updated->diffInDays($day)));

                            if ($diffInDays == $neglectConfig->days) {
                                $trashed->update([
                                    'is_seen' => 1
                                ]);
                            }
                        }
                    }
                }
            }
        }

        $this->info('Neglected cases checked successfully!');
    }
}