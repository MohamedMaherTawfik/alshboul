<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SettlementAction;
use Illuminate\Http\Request;

class SettlementActionController extends Controller
{
    public function index($settlement_id)
    {
        return view('admin.SettlementAction.index', compact('settlement_id'));
    }

    public function create($settlement_id)
    {
        return view('admin.SettlementAction.create', compact('settlement_id'));
    }

    public function edit($id)
    {
        return view('admin.SettlementAction.edit', compact('id'));
    }

    public function deleted($settlement_id)
    {
        return view('admin.SettlementAction.deleted', compact('settlement_id'));
    }

    public function show($id)
    {
        $settlementAction = SettlementAction::with('files')->findOrFail($id);
        return view('admin.SettlementAction.show', compact('settlementAction'));
    }
} 