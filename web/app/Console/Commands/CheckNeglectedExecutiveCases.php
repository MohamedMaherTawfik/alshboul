<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ExecutiveCase;
use App\Models\excutiveCasesMain;
use App\Models\NegligenceDays;
use App\Models\trahsedDays;
use Illuminate\Support\Carbon;

class CheckNeglectedExecutiveCases extends Command
{
    /**
     * اسم الكوماند اللي ممكن نشغله يدويًا
     */
    protected $signature = 'executive-cases:check-neglected';

    /**
     * وصف الكوماند
     */
    protected $description = 'Check for neglected executive cases and update trahsedDays table accordingly';

    public function handle()
    {
        $mainCases = excutiveCasesMain::all();

        foreach ($mainCases as $mainCase) {
            $executiveCases = ExecutiveCase::where('excutive_cases_main_id', $mainCase->id)
                ->where('active', 1)
                ->get()
                ->sortBy('case_number');

            $neglectConfig = NegligenceDays::where('excutive_cases_main_id', $mainCase->id)->first();

            if ($neglectConfig && $neglectConfig->days > 0) {

                foreach ($executiveCases as $case) {
                    $totalEvents = $case->proceduralRecords()->count()
                        + $case->settlements()->count();

                    $trashed = trahsedDays::where('executive_case_id', $case->id)->first();

                    if (!$trashed) {
                        trahsedDays::create([
                            'executive_case_id' => $case->id,
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

        $this->info('Neglected executive cases checked successfully!');
    }
}