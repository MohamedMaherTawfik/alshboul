<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TransactionsMain;
use App\Models\NegligenceDays;
use App\Models\trahsedDays;

class CheckTransactionsNegligence extends Command
{
    protected $signature = 'check:transactions';
    protected $description = 'Check negligence for transactions';

    public function handle()
    {
        $transactionsMains = TransactionsMain::with('transactions')->get();

        foreach ($transactionsMains as $transaction) {
            $transactionsList = $transaction->transactions;
            $neglectConfig = NegligenceDays::where('transactions_main_id', $transaction->id)->first();

            if ($neglectConfig) {
                foreach ($transactionsList as $tran) {
                    $totalEvents = $tran->procedural()->count();

                    $trashed = trahsedDays::where('trans_actions_id', $tran->id)->first();

                    if ($trashed) {
                        if ($totalEvents == $trashed->counts) {
                            $daysDiff = now()->diffInDays($trashed->updated_at);

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
                            'trans_actions_id' => $tran->id,
                            'counts' => $totalEvents,
                            'days_passed' => 0,
                            'is_seen' => 0,
                        ]);
                    }
                }
            }
        }

        $this->info('Transaction negligence check complete ✅');
    }
}
