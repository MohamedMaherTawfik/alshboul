<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MoveBar;
use Illuminate\Http\Request;

class MoveBarController extends Controller
{
    public function index()
    {
        $moveBars = MoveBar::all();
        return view('admin.move-bars.index', compact('moveBars'));
    }

    public function create()
    {
        return view('admin.move-bars.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:255',
            'active' => 'required|boolean'
        ]);

        MoveBar::create($request->all());

        return redirect()->route('move-bars.index')
            ->with('success', 'Move bar created successfully.');
    }

    public function edit($id)
    {
        $moveBar = MoveBar::findOrFail($id);
        return view('admin.move-bars.edit', compact('moveBar'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'text' => 'required|string|max:255',
            'active' => 'required|boolean'
        ]);

        $moveBar = MoveBar::findOrFail($id);
        $moveBar->update($request->except(['_token']));

        return redirect()->route('move-bars.index')
            ->with('success', 'Move bar updated successfully.');
    }

    public function destroy($id)
    {
        $moveBar = MoveBar::findOrFail($id);
        $moveBar->delete();

        return redirect()->route('move-bars.index')
            ->with('success', 'Move bar deleted successfully.');
    }
}
