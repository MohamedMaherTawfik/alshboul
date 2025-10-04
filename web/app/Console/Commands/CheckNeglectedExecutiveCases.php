<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ExecutiveCase;
use App\Models\excutiveCasesMain;
use App\Models\NegligenceDays;
use App\Models\trahsedDays;

class CheckNeglectedExecutiveCases extends Command
{
    /**
     * اسم الكوماند اللي ممكن نشغله يدويًا
     */
    protected $signature = 'executive-cases:check-neglected';

    /**
     * وصف الكوماند
     */
    protected $description = 'Check for neglected executive cases and update trashedDays table accordingly';

    public function handle()
    {
        $mainCases = excutiveCasesMain::all();

        foreach ($mainCases as $mainCase) {
            $executiveCases = ExecutiveCase::where('excutive_cases_main_id', $mainCase->id)->get();

            $neglectConfig = NegligenceDays::where('excutive_cases_main_id', $mainCase->id)->first();

            if (!$neglectConfig) {
                continue;
            }

            foreach ($executiveCases as $case) {
                $totalEvents = $case->proceduralRecords()->count()
                    + $case->settlements()->count();

                $trashed = trahsedDays::where('executive_case_id', $case->id)->first();

                if ($trashed) {
                    $daysDiff = now()->diffInDays($trashed->updated_at);

                    if ($totalEvents == $trashed->counts) {
                        if ($daysDiff >= 0) {
                            $trashed->increment('days_passed', 1);
                        }

                        if ($trashed->days_passed >= $neglectConfig->days) {
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
                        'executive_case_id' => $case->id,
                        'counts' => $totalEvents,
                        'days_passed' => 0,
                        'is_seen' => 0,
                    ]);
                }
            }
        }

        $this->info('Neglected executive cases checked successfully!');
    }
}
