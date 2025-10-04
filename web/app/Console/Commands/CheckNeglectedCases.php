<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\cases;
use App\Models\CaseType;
use App\Models\NegligenceDays;
use App\Models\trahsedDays;

class CheckNeglectedCases extends Command
{
    /**
     * اسم الكوماند اللي ممكن نشغله يدويًا
     */
    protected $signature = 'cases:check-neglected';

    /**
     * وصف الكوماند
     */
    protected $description = 'Check for neglected cases and update trashedDays table accordingly';

    public function handle()
    {
        $caseTypes = CaseType::all();

        foreach ($caseTypes as $casetype) {
            $cases = cases::with('caseOpponents')
                ->where('suggested_case_id', $casetype->id)
                ->where('active', 1)
                ->get()
                ->sortBy('case_number');

            $neglectConfig = NegligenceDays::where('case_type_id', $casetype->id)->first();

            if (!$neglectConfig) {
                continue;
            }

            // لو الأيام = 0 نخليها 1
            $daysLimit = max(1, $neglectConfig->days);

            foreach ($cases as $case) {
                $totalEvents = $case->courtSession()->count()
                    + $case->legalPeriods()->count()
                    + $case->caseNotes()->count()
                    + $case->proceduralRedords()->count();

                $trashed = trahsedDays::where('cases_id', $case->id)->first();

                if ($trashed) {
                    $daysDiff = now()->diffInDays($trashed->created_at);

                    if ($totalEvents == $trashed->counts) {
                        if ($daysDiff >= 1) {
                            $trashed->increment('days_passed', 1);
                        }

                        if ($trashed->days_passed >= $daysLimit) {
                            $trashed->update(['is_seen' => 1]);
                        }
                    } elseif ($totalEvents > $trashed->counts) {
                        $trashed->update([
                            'counts' => $totalEvents,
                            'days_passed' => 0,
                            'is_seen' => 0,
                        ]);
                    }
                } else {
                    trahsedDays::create([
                        'cases_id' => $case->id,
                        'counts' => $totalEvents,
                        'days_passed' => 0,
                        'is_seen' => 0,
                    ]);
                }
            }
        }

        $this->info('Neglected cases checked successfully!');
    }
}