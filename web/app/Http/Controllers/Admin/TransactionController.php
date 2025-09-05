<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ProceduralFile;
use App\Models\ProceduralRecord;
use App\Models\TransActions;
use App\Models\TransactionsMain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        ]);
        $procedural = ProceduralRecord::create([
            'trans_actions_id' => $transaction->id ?? null,
            'user_lawyer_id' => $data['user_lawyer_id'] ?? null,
            'action' => $data['action'] ?? null,
            'note' => $data['note'] ?? null,
            'type' => $data['type'] ?? null,
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
