<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SettlementMain;
use App\Models\NegligenceDays;
use App\Models\trahsedDays;
use Illuminate\Support\Carbon;

class CheckNeglectedSettlements extends Command
{
    /**
     * اسم الكوماند اللي ممكن تشغله يدويًا
     */
    protected $signature = 'settlements:check-neglected';

    /**
     * وصف الكوماند
     */
    protected $description = 'Check for neglected settlements and update trahsedDays table accordingly';

    public function handle()
    {
        $mainSettlements = SettlementMain::with('settlements')->get();

        foreach ($mainSettlements as $main) {
            $neglectConfig = NegligenceDays::where('settlement_main_id', $main->id)->first();

            if ($neglectConfig && $neglectConfig->days > 0) {

                foreach ($main->settlements as $settlement) {
                    $totalEvents = $settlement->actions()->count()
                        + $settlement->proceduralRedords()->count();

                    $trashed = trahsedDays::where('settlement_id', $settlement->id)->first();

                    if (!$trashed) {
                        trahsedDays::create([
                            'settlement_id' => $settlement->id,
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

        $this->info('Neglected settlements checked successfully!');
    }
}
