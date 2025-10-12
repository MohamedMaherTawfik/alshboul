<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SettlementMain;
use App\Models\NegligenceDays;
use App\Models\trahsedDays;

class CheckNeglectedSettlements extends Command
{
    /**
     * اسم الكوماند اللي ممكن تشغله يدويًا
     */
    protected $signature = 'settlements:check-neglected';

    /**
     * وصف الكوماند
     */
    protected $description = 'Check for neglected settlements and update trashedDays table accordingly';

    public function handle()
    {
        $mainSettlements = SettlementMain::with('settlements')->get();

        foreach ($mainSettlements as $main) {
            $neglectConfig = NegligenceDays::where('settlement_main_id', $main->id)->first();

            if (!$neglectConfig) {
                continue;
            }
            if ($neglectConfig->days == 0) {
                continue;
            }

            $daysLimit = $neglectConfig->days;


            foreach ($main->settlements as $settlement) {
                $totalEvents = $settlement->actions()->count()
                    + $settlement->proceduralRedords()->count();

                $trashed = trahsedDays::where('settlement_id', $settlement->id)->first();

                if ($trashed) {
                    $daysDiff = now()->diffInDays($trashed->updated_at);

                    if ($totalEvents == $trashed->counts) {
                        if ($daysDiff >= 0) {
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
                        'settlement_id' => $settlement->id,
                        'counts' => $totalEvents,
                        'days_passed' => 0,
                        'is_seen' => 0,
                    ]);
                }
            }
        }

        $this->info('Neglected settlements checked successfully!');
    }
}
