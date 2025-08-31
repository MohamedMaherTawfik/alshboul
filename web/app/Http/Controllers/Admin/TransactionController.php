<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\TransActions;
use App\Models\TransactionsMain;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(TransactionsMain $transaction)
    {
        $transaction->load('transactions');
        return view('admin.transaction.index', compact('transaction'));
    }

    public function create(TransactionsMain $transaction)
    {
        $clients = Client::where('seen', 1)->get();

        $numbers = $transaction->transactions()
            ->pluck('file_number')
            ->map(function ($num) {
                return (int) $num;
            })
            ->sort()
            ->toArray();

        $missing = 1;
        foreach ($numbers as $num) {
            if ($num == $missing) {
                $missing++;
            } elseif ($num > $missing) {
                break;
            }
        }

        return view('admin.transaction.create', compact('transaction', 'clients', 'missing'));
    }


    public function store(Request $request, TransactionsMain $transaction)
    {
        $data = $request->except('_token');
        TransActions::create([
            'transactions_main_id' => $transaction->id,
            'file_number' => $data['file_number'],
            'client_name' => $data['client_name'],
            'client_id' => $data['subscriber_id'],
            'notes' => $data['notes'],
            'area_name' => $data['area_name'],
            'description' => $data['description'],
            'user_id' => auth()->user()->id,
            'is_active' => $data['is_active'],

        ]);
        return redirect()->route('transactions.all', $transaction)->with('success', 'تم اضافة المعاملة بنجاح');
    }

    public function edit(TransActions $transaction)
    {
        return view('admin.transaction.edit', compact('transaction'));
    }

    public function update(Request $request, TransActions $transaction)
    {


        $data = $request->except('_token');
        $transaction->update($data);
        return redirect()->route('transactions.all', $transaction->transactionsMain)->with('success', 'Transaction updated successfully');
    }

    public function destroy(TransActions $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.all', $transaction->transactionsMain)->with('success', 'Transaction deleted successfully');
    }

}
