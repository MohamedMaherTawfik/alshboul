<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TransactionsMain;
use App\Models\NegligenceDays;
use App\Models\trahsedDays;
use Illuminate\Support\Carbon;

class CheckTransactionsNegligence extends Command
{
    /**
     * اسم الكوماند اللي ممكن تشغله يدويًا
     */
    protected $signature = 'transactions:check-neglected';

    /**
     * وصف الكوماند
     */
    protected $description = 'Check for neglected transactions and update trahsedDays table accordingly';

    public function handle()
    {
        $transactionsMains = TransactionsMain::with('transactions')->get();

        foreach ($transactionsMains as $main) {
            $neglectConfig = NegligenceDays::where('transactions_main_id', $main->id)->first();

            if ($neglectConfig && $neglectConfig->days > 0) {

                foreach ($main->transactions as $transaction) {
                    $totalEvents = $transaction->procedural()->count();

                    $trashed = trahsedDays::where('trans_actions_id', $transaction->id)->first();

                    if (!$trashed) {
                        trahsedDays::create([
                            'trans_actions_id' => $transaction->id,
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

        $this->info('Neglected transactions checked successfully!');
    }
}