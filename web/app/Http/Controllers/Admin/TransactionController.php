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
        $clients = Client::where('is_seen', 1)->get();
        return view('admin.transaction.create', compact('transaction', 'clients'));
    }

    public function store(Request $request, TransactionsMain $transaction)
    {
        $data = $request->except('_token');
        TransActions::create($data);
        return redirect()->route('transactions.all', $transaction)->with('success', 'Transaction created successfully');
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
