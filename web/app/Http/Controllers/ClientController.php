<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\clientProcedural;
use App\Models\clientProceduralFiles;
use App\Models\MainAction;
use App\Models\ProceduralRecord;
use App\Models\SubAction;
use App\Models\subrocedural;
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
        $data = Client::with('user')->where('seen', 1)->where('active', 1)->orderBy('id', 'desc')->get();
        return view('admin.mooakl.index', compact('data'));
    }
    public function visit()
    {
        $data = user::with('visitWeb')->where('active', 1)->get();
        return view('admin.visit.new', compact('data'));
    }

    public function indexDelete()
    {
        $data = Client::where('active', 0)->get();
        return view('admin.mooakl.indexDelete', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.mooakl.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'nullable',
            'username' => 'nullable',
            'email' => 'nullable|unique:users',
            'phone' => 'nullable',
            'address' => 'nullable',
            'national_id' => 'nullable|integer',
            'nationality' => 'nullable|string',
            'password' => 'nullable',

            'additional_clients' => 'nullable|array',
            'additional_clients.*.client_name' => 'nullable|string',
            'additional_clients.*.client_phone' => 'nullable|string',
            'additional_clients.*.client_nationality' => 'nullable|string',
            'additional_clients.*.client_national_id' => 'nullable|string',
            'additional_clients.*.client_address' => 'nullable|string',
        ]);
        $user = User::create([
            'email' => $data['email'] ?? '',
            'name' => $data['name'] ?? '',
            'username' => $data['username'] ?? '',
            'phone' => $data['phone'] ?? '',
            'role' => 'user' ?? '',
            'password' => bcrypt($data['password']) ?? '',
            'delete_reason' => $data['password'] ?? '',
        ]);

        Client::create([
            'user_id' => $user->id,
            'name' => $data['name'] ?? '',
            'phone' => $data['phone'] ?? '',
            'address' => $data['address'] ?? '',
            'company_name' => '',
            'company_national_number' => '',
            'nationality' => $data['nationality'] ?? '',
            'national_id' => $data['national_id'] ?? '',
            'added_by' => Auth::id(),
            'seen' => 1,
        ]);

        if (!empty($data['additional_clients'])) {
            foreach ($data['additional_clients'] as $client) {
                if (!empty($client['client_name'])) {
                    Client::create([
                        'user_id' => $user->id,
                        'name' => $client['client_name'] ?? '',
                        'phone' => $client['client_phone'] ?? '',
                        'company_name' => $data['company_name'] ?? '',
                        'address' => $client['client_address'] ?? '',
                        'company_national_number' => $data['company_national_number'] ?? '',
                        'nationality' => $client['client_nationality'] ?? '',
                        'national_id' => $client['client_national_id'] ?? '',
                        'added_by' => Auth::id(),
                        'seen' => 0,
                    ]);
                }
            }
        }

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
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        $client->load('user');

        $additionalClients = Client::where('user_id', $client->user_id)
            ->where('id', '!=', $client->id)
            ->get();

        return view('admin.mooakl.edit', compact('client', 'additionalClients'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'national_id' => 'nullable|integer',
            'nationality' => 'nullable|string',
            'company_name' => 'nullable|string',
            'company_national_number' => 'nullable|string',
            'password' => 'nullable|string',

            'additional_clients' => 'nullable|array',
            'additional_clients.*.client_name' => 'nullable|string',
            'additional_clients.*.client_phone' => 'nullable|string',
            'additional_clients.*.client_nationality' => 'nullable|string',
            'additional_clients.*.client_national_id' => 'nullable|string',
            'additional_clients.*.client_address' => 'nullable|string',
        ]);

        // ✅ تحديث user
        $client->user->update([
            'email' => $data['email'] ?? '',
            'name' => $data['name'] ?? '',
            'phone' => $data['phone'] ?? '',
        ]);

        // ✅ تحديث الباسورد لو المستخدم كتب جديد
        if (!empty($data['password'])) {
            $client->user->update([
                'password' => bcrypt($data['password']),
                'delete_reason' => $data['password'], // لو بتحتفظ بالنص مؤقتًا
            ]);
        }

        // ✅ تحديث client الأساسي
        $client->update([
            'name' => $data['name'] ?? '',
            'phone' => $data['phone'] ?? '',
            'address' => $data['address'] ?? '',
            'company_name' => $data['company_name'] ?? '',
            'company_national_number' => $data['company_national_number'] ?? '',
            'nationality' => $data['nationality'] ?? '',
            'national_id' => $data['national_id'] ?? '',
        ]);

        // ✅ امسح كل الموكلين الإضافيين القدام
        Client::where('user_id', $client->user_id)
            ->where('id', '!=', $client->id)
            ->delete();

        // ✅ أضف الموكلين الإضافيين الجدد كلهم
        if (!empty($data['additional_clients']) && is_array($data['additional_clients'])) {
            foreach ($data['additional_clients'] as $add) {
                if (!empty($add['client_name'])) {
                    Client::create([
                        'user_id' => $client->user_id,
                        'name' => $add['client_name'] ?? '',
                        'phone' => $add['client_phone'] ?? '',
                        'company_name' => $data['company_name'] ?? '',
                        'address' => $add['client_address'] ?? '',
                        'company_national_number' => $data['company_national_number'] ?? '',
                        'nationality' => $add['client_nationality'] ?? '',
                        'national_id' => $add['client_national_id'] ?? '',
                        'added_by' => Auth::id(),
                        'seen' => 0,
                    ]);
                }
            }
        }

        return redirect()->route('client.index')->with('success', 'تم تحديث البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->update(['active' => 0]);
        $user = User::find($client->user_id);
        $user->update(['active' => 0]);
        return redirect()->route('client.index')->with(['success' => 'تم حذف البيانات بنجاح']);
    }
    public function restore(Client $client)
    {
        $client->update(['active' => 1]);
        return redirect()->route('client.indexDelete')->with(['success' => 'تم استرجاع البيانات بنجاح']);
    }

    public function clientProcedural()
    {
        $data = Client::where('seen', 1)->orderBy('id', 'desc')->get();
        return view('admin.edit.action', compact('data'));
    }

    public function ClientShowProcedural(Client $client)
    {
        $client->load([
            'clientProcedurals' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }
        ]);
        return view('admin.mooakl.show', compact('client'));
    }
    public function clientstoreProcedural(Request $request, Client $client)
    {
        $request->validate([
            'procedural' => 'nullable',
            'procedural_facts' => 'nullable',
            'side' => 'nullable',
            'procedural_type' => 'nullable',
            'status' => 'nullable',
            'created_at',
            'lawyer_id' => 'nullable',
        ]);
        $data = $request->except('_token');
        $procedural = clientProcedural::create([
            'procedural' => $data['procedural'] ?? '-',
            'procedural_facts' => $data['procedural_facts'] ?? '-',
            'side' => $data['side'] ?? '-',
            'procedural_type' => $data['procedural_type'] ?? '-',
            'status' => $data['status'] ?? '-',
            'created_at' => $data['created_at'] ?? '-',
            'lawyer_id' => $data['lawyer_id'] ?? '-',
            'user_id' => Auth::id(),
            'client_id' => $client->id
        ]);
        if (!$data) {
            return redirect()->back()->with('error', ' حدث خلل أثناء الاضافة');
        }
        return redirect()->route('client.show', $client)->with('success', 'تم إضافة الاجراء بنجاح');
    }

    public function clienteditProcedural(clientProcedural $client)
    {
        $lawyers = User::whereIn('role', ['Lawyer', 'admin', 'superadmin'])->get();
        return view('admin.mooakl.editProcedural', compact('client', 'lawyers'));
    }


    public function clientUpdateProcedural(Request $request, clientProcedural $client)
    {

        $data = $request->except('_token');
        $client->update($data);
        return redirect()->route('client.show', $client->client_id)->with('success', 'تم تعديل البيانات بنجاح');
    }

    public function clientDeleteProcedural(clientProcedural $client)
    {
        $client->delete();
        return redirect()->back()->with('success', 'تم حذف البيانات بنجاح');
    }

    public function showProcedural(clientProcedural $client)
    {
        $user = User::whereIn('role', ['Lawyer', 'admin', 'superadmin'])->get();
        $client->load('subProcedurals');
        return view('admin.mooakl.procedural', compact('client', 'user'));
    }

    public function storeSub(Request $request, clientProcedural $client)
    {
        $data = $request->except('_token', 'file_path');
        $procedural = subrocedural::create([
            'client_procedural_id' => $client->id,
            'action' => $data['action'] ?? '-',
            'note' => $data['note'] ?? '-',
            'created_at' => $data['created_at'] ?? '-',
            'user_id' => auth()->id(),
            'lawyer_id' => $data['lawyer_id'] ?? '-',
            'to' => '-',
            'next_action' => $data['next_action'] ?? '-',
            'next_action_date' => $data['next_action_date'] ?? '-'
        ]);
        if ($request->hasFile('file_path')) {
            foreach ($request->file('file_path') as $uploadedFile) {
                $path = $uploadedFile->store('ProceduralFiles', 'public');
                clientProceduralFiles::create([
                    'subrocedural_id' => $procedural->id,
                    'file' => $path,
                ]);
            }
        }
        return redirect()->back()->with('success', 'تم إضافة الاجراء الفرعي بنجاح');
    }

    public function updateSub(Request $request, subrocedural $client)
    {

        $data = $request->except(['_token', '_method']);
        $client->update($data);
        return redirect()->back()->with('success', 'تم تعديل الاجراء الفرعي بنجاح');
    }

    public function deleteSub(subrocedural $client)
    {
        $client->delete();
        return redirect()->back()->with('success', 'تم حذف الاجراء الفرعي بنجاح');
    }

    public function addFile(Request $request, subrocedural $client)
    {
        if ($request->hasFile('file_path')) {
            foreach ($request->file('file_path') as $uploadedFile) {
                $path = $uploadedFile->store('ProceduralFiles', 'public');

                clientProceduralFiles::create([
                    'subrocedural_id' => $client->id,
                    'file' => $path,
                ]);
            }
        }
        return redirect()->back()->with('success', 'تم إضافة الملف بنجاح');
    }

    public function deleteFile(clientProceduralFiles $client)
    {
        $client->delete();
        return redirect()->back()->with('success', 'تم حذف الملف بنجاح');
    }
    public function clientcreateProcedural(Client $client)
    {
        return view('admin.mooakl.createProcedural', compact('client'));
    }
}