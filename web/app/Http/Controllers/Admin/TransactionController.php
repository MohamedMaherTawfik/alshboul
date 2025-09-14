<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\NegligenceDays;
use App\Models\ProceduralFile;
use App\Models\ProceduralRecord;
use App\Models\trahsedDays;
use App\Models\TransActions;
use App\Models\TransactionsMain;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(TransactionsMain $transaction)
    {
        $transaction->load('transactions');

        $transactionsList = $transaction->transactions;

        $neglectConfig = NegligenceDays::where('transactions_main_id', $transaction->id)->first();

        if ($neglectConfig) {
            foreach ($transactionsList as $tran) {
                $totalEvents = $tran->procedural()->count();


                $trashed = trahsedDays::where('trans_actions_id', $tran->id)->first();

                if ($trashed) {
                    if ($totalEvents == $trashed->counts) {
                        $daysDiff = now()->diffInDays($trashed->updated_at);

                        if ($daysDiff >= 1) {
                            $trashed->increment('days_passed', $daysDiff);
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

        return view('admin.transaction.index', compact('transaction', 'transactionsList'));
    }


    public function create(TransactionsMain $transaction)
    {
        $clients = Client::where('active', 1)->where('seen', 1)->get();

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
        $transzctionsmains = TransactionsMain::all();
        return view('admin.transaction.edit', compact('transaction', 'transzctionsmains'));
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

    public function allProcedural(TransActions $transaction)
    {
        $transaction->load('procedural');
        return view('admin.transaction.procedural', compact('transaction'));
    }

    public function storeProcedural(Request $request, TransActions $transaction)
    {
        $data = $request->validate([
            'type' => 'required|string|max:255',
            'action' => 'required|string',
            'note' => 'nullable|string',
            'user_lawyer_id' => 'required|exists:users,id',
            'created_at' => 'required'
        ]);
        $procedural = ProceduralRecord::create([
            'trans_actions_id' => $transaction->id ?? null,
            'user_lawyer_id' => $data['user_lawyer_id'] ?? null,
            'action' => $data['action'] ?? null,
            'note' => $data['note'] ?? null,
            'type' => $data['type'] ?? null,
            'created_at' => $data['created_at'] ?? null,
            'user_id' => Auth::user()->id
        ]);
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $uploadedFile) {
                $path = $uploadedFile->store('ProceduralFiles', 'public');

                ProceduralFile::create([
                    'procedural_record_id' => $procedural->id,
                    'created_by' => Auth::user()->id,
                    'file_path' => $path,
                    'updated_by' => Auth::user()->id,
                ]);
            }
        }

        return redirect()->back()->with('success', 'تم إضافة الإجراء بنجاح');
    }

    public function editProcedural(ProceduralRecord $transaction)
    {
        return view('admin.transaction.procedural-edit', compact('transaction'));
    }

    public function updateProcedural(Request $request, ProceduralRecord $transaction)
    {
        $data = $request->validate([
            'type' => 'required|string|max:255',
            'action' => 'required|string',
            'note' => 'nullable|string',
            'user_lawyer_id' => 'required|exists:users,id',
        ]);
        $transaction->update($data);
        return redirect()->route('transactions.procedural.create', $transaction->transactions)->with('success', 'تم تحديث الإجراء بنجاح');
    }

    public function deleteFile(ProceduralFile $transaction)
    {
        $transaction->delete();
        return redirect()->back()->with('success', 'تم حذف الملف بنجاح');
    }

    public function addFile(Request $request, ProceduralRecord $transaction)
    {
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $uploadedFile) {
                $path = $uploadedFile->store('ProceduralFiles', 'public');

                ProceduralFile::create([
                    'procedural_record_id' => $transaction->id,
                    'created_by' => Auth::user()->id,
                    'file_path' => $path,
                    'updated_by' => Auth::user()->id,
                ]);
            }
        }
        return redirect()->back()->with('success', 'تم اضافة الملفات بنجاح');
    }
}
