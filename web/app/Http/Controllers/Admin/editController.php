<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseType;
use App\Models\excutiveCasesMain;
use App\Models\SettlementMain;
use App\Models\TransactionsMain;
use Illuminate\Http\Request;

class editController extends Controller
{
    public function editCaseType(CaseType $type)
    {
        return view('admin.edit.caseType', compact('type'));
    }

    public function updateCaseType(Request $request, CaseType $type)
    {
        $type->update(['name' => $request->name]);
        $type->NegligenceDays()->update(['days' => $request->days]);
        return redirect()->route('casetypes.index')->with('success', 'تم التعديل بنجاح');
    }
    public function destroyCaseType(CaseType $type)
    {
        $type->delete();
        return redirect()->route('casetypes.index')->with('success', 'تم الحذف بنجاح');
    }

    // ======== Settlements =========
    public function editSettlement(SettlementMain $type)
    {
        return view('admin.edit.settlement', compact('type'));
    }

    public function updateSettlement(Request $request, SettlementMain $type)
    {
        $type->update(['name' => $request->name]);
        $type->NegligenceDays()->update(['days' => $request->days]);
        return redirect()->route('casetypes.index')->with('success', 'تم التعديل بنجاح');
    }

    public function destroySettlement(SettlementMain $type)
    {
        $type->delete();
        return redirect()->route('casetypes.index')->with('success', 'تم الحذف بنجاح');
    }

    // ======== Transactions =========
    public function editTransaction(TransactionsMain $type)
    {
        return view('admin.edit.transaction', compact('type'));
    }

    public function updateTransaction(Request $request, TransactionsMain $type)
    {
        $type->update(['name' => $request->name]);
        $type->NegligenceDays()->update(['days' => $request->days]);
        return redirect()->route('casetypes.index')->with('success', 'تم التعديل بنجاح');
    }

    public function destroyTransaction(TransactionsMain $type)
    {
        $type->delete();
        return redirect()->route('casetypes.index')->with('success', 'تم الحذف بنجاح');
    }

    // ======== ExecutiveCases =========
    public function editExcutiveCase(excutiveCasesMain $type)
    {
        return view('admin.edit.excutiveCase', compact('type'));
    }

    public function updateExcutiveCase(Request $request, excutiveCasesMain $type)
    {
        $type->update(['name' => $request->name]);
        $type->NegligenceDays()->update(['days' => $request->days]);
        return redirect()->route('casetypes.index')->with('success', 'تم التعديل بنجاح');
    }

    public function destroyExcutiveCase(excutiveCasesMain $type)
    {
        $type->delete();
        return redirect()->route('casetypes.index')->with('success', 'تم الحذف بنجاح');
    }
}