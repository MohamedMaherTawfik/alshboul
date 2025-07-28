<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\MainAction;
use App\Models\SubAction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Client::orderBy('id', 'desc')->get();
        return view('admin.Client.index', compact('data'));
    }
    public function visit()
    {

        return view('admin.Client.Visit');
    }
    public function action()
    {
        $data2 = Client::all();

        return view('admin.Client.Action', compact('data2'));
    }
    public function indexDelete()
    {
        $data = Client::onlyTrashed()->get();
        return view('admin.Client.index-delete', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.Client.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'user_id' => ['required', 'exists:users,id'],
            'national_id' => 'required|integer',
            'nationality' => 'required|string',
            'company_name' => 'nullable|string',
            'company_national_number' => 'nullable|string',
        ]);



        $client = new Client();
        $client->name = $request->name;
        $client->phone = $request->phone;
        $client->address = $request->address;
        $client->company_name = $request->company_name ?? null;
        $client->company_national_number = $request->company_national_number ?? null;
        $client->national_id = $request->national_id;
        $client->nationality = $request->nationality;
        $client->user_id = $request->user_id;
        $client->added_by = Auth::id();
        $client->save();

        return redirect()->route('client.index')->with('success', 'تم إضافة البيانات بنجاح');
    }

    public function store1(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'action_date' => 'required',
            'entity' => 'required',
            'type' => 'required',
            'status' => 'required',
        ]);
        $data = $request->all();
        $data['added_by'] = Auth::id();
        $data = MainAction::create($data);
        if (!$data) {
            return redirect()->back()->with('error', ' حدث خلل أثناء الاضافة');
        }
        return redirect()->route('client.action')->with('success', 'تم إضافة البيانات بنجاح');
    }
    public function update1(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'action_date' => 'required',
            'entity' => 'required',
            'type' => 'required',
            'status' => 'required',
        ]);
        $data = $request->except('_token');
        $data['updated_by'] = Auth::id();
        MainAction::where('id', $id)->update($data);

        return redirect()->route('client.action')->with('success', 'تم تعديل البيانات بنجاح');
    }
    public function store2(Request $request)
    {
        $request->validate([
            'details' => 'required',
            'action_date' => 'required',
        ]);
        $data = $request->all();
        $data['added_by'] = Auth::id();
        $data = SubAction::create($data);
        if (!$data) {
            return redirect()->back()->with('error', ' حدث خلل أثناء الاضافة');
        }
        return redirect()->route('client.action')->with('success', 'تم إضافة البيانات بنجاح');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Client::findOrFail($id);
        return view('admin.Client.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Client::findOrFail($id);
        return view('admin.Client.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            DB::beginTransaction();
            $request->validate([
                'name' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'national_id' => 'required|integer',
                'user_id' => ['required', 'exists:users,id'],
                'nationality' => 'required|string',
                'company_name' => 'nullable|string',
                'company_national_number' => 'nullable|string',
            ]);

            $data = $request->except(['_token']);
            $data['updated_by'] = Auth::id();
            $data['updated_at'] = now();
            Client::where(['id' => $id])->update($data);


            DB::commit();
            return redirect()->route('client.index')->with(['success' => 'تم تعديل البيانات بنجاح']);
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'عفواً حدث خطأ  ' . $th->getMessage()])->withInput();
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {


        $client = Client::findOrFail($request->id);
        if (!$client) {
            return redirect()->back()->with(['error' => 'عفواً لا توجد بيانات']);
        }
        $request->validate([
            'reason' => 'required|string',
        ]);
        $client->updated_by = Auth::id();
        $client->delete_reason = $request->reason;
        $client->save();

        $user = User::findOrFail($client->user_id);
        $user->updated_by = Auth::id();
        $user->delete_reason = $request->reason;
        $user->active = 0;
        $user->save();
        $client->delete();
        $user->delete();
        return redirect()->route('client.index')->with(['success' => 'تم حذف البيانات بنجاح']);
    }
    public function destroy1(Request $request)
    {


        $action = MainAction::findOrFail($request->id);
        if (!$action) {
            return redirect()->back()->with(['error' => 'عفواً لا توجد بيانات']);
        }
        $request->validate([
            'reason' => 'required|string',
        ]);
        $action->updated_by = Auth::id();
        $action->delete_reason = $request->reason;
        $action->save();
        $action->delete();
        return redirect()->route('client.action')->with(['success' => 'تم حذف البيانات بنجاح']);
    }
    public function restore($id)
    {
        Client::withTrashed()->find($id)->restore();

        $client = Client::findOrFail($id);
        if (!$client) {
            return redirect()->route('client.indexDelete')->with(['error' => 'عفواً لا توجد بيانات']);
        }
        $client->updated_by = Auth::id();
        $client->delete_reason = "";
        $client->save();

        User::withTrashed()->find($client->user_id)->restore();

        $user = User::findOrFail($client->user_id);
        $user->updated_by = Auth::id();
        $user->delete_reason = "";
        $user->active = 1;
        $user->save();


        return redirect()->route('client.indexDelete')->with(['success' => 'تم استرجاع البيانات بنجاح']);
    }
}