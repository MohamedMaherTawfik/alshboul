<?php

namespace App\Http\Controllers;

use App\Models\ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ClientRequest::orderBy('id', 'desc')->get();

        return view('admin.ClientRequest.index', compact('data'));
    }
    public function index1()
    {
        $data = [];
        $data = ClientRequest::where('added_by', Auth::id())->orderBy('id', 'desc')->get();
        return view('user.ClientRequest.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->role == "User") {
            return view('user.ClientRequest.create');
        } else {
            return view('admin.ClientRequest.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'note' => 'required|string',

        ]);

        ClientRequest::create($request->all());

        return redirect()->back()->with('success', 'Client request created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function replay(Request $request)
    {
        $request->validate([
            'admin_reply' => 'required|string'
        ]);
        ClientRequest::where('id', $request->id)->update(
            [
                'admin_reply' => $request->admin_reply,
                'replied_at' => now(),
                'replied_by' => Auth::id(),
                'is_replied' => 1
            ]
        );
        return redirect()->route('request.index')->with('success', 'تم الرد بنجاح ');
    }
    public function replayModify(Request $request)
    {
        $request->validate([
            'admin_reply' => 'required|string'
        ]);
        ClientRequest::where('id', $request->id)->update(
            [
                'admin_reply' => $request->admin_reply,
                'replied_at' => now(),
                'replied_by' => Auth::id(),
                'is_replied' => 1
            ]
        );
        return redirect()->route('request.index')->with('success', 'تم تعديل الرد بنجاح ');
    }
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
