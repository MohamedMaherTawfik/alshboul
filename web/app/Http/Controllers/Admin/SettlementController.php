<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\NegligenceDays;
use App\Models\Settlement;
use App\Models\SettlementMain;
use App\Models\trahsedDays;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SettlementController extends Controller
{
    public function index(SettlementMain $settlements)
    {
        $settlements->load('settlements');
        $settlementsList = $settlements->settlements;

        $neglectConfig = NegligenceDays::where('settlement_main_id', $settlements->id)->first();

        if ($neglectConfig && $neglectConfig->days != 0) {
            foreach ($settlementsList as $settlement) {
                $totalEvents = $settlement->actions()->count()
                    + $settlement->proceduralRedords()->count();

                $trashed = trahsedDays::firstOrCreate(
                    ['settlement_id' => $settlement->id],
                    [
                        'counts' => $totalEvents,
                        'days_passed' => 0,
                        'is_seen' => 0,
                    ]
                );

                // تحديث سجل الإهمال
                $daysDiff = now()->diffInDays($trashed->updated_at);

                if ($totalEvents == $trashed->counts) {
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
            }
        }

        return view('admin.Settlement.index', compact('settlements', 'settlementsList'));
    }


    public function all()
    {
        $settlements = Settlement::whereNotNull('cases_id')
            ->orWhereNotNull('executive_case_id')
            ->get();

        return view('admin.Settlement.all', compact('settlements'));
    }

    public function create(SettlementMain $settlements)
    {

        $clients = Client::with('user')->where('seen', 1)->where('active', 1)->orderBy('id', 'desc')->get();

        $settlementsForMain = Settlement::where('settlement_main_id', $settlements->id)
            ->orderBy('file_number')
            ->pluck('file_number')
            ->toArray();

        if (empty($settlementsForMain)) {
            $nextFileNumber = 1;
        } else {
            $nextFileNumber = null;


            $max = max($settlementsForMain);
            for ($i = 1; $i <= $max; $i++) {
                if (!in_array($i, $settlementsForMain)) {
                    $nextFileNumber = $i;
                    break;
                }
            }

            if (is_null($nextFileNumber)) {
                $nextFileNumber = $max + 1;
            }
        }

        return view('admin.Settlement.create', compact('clients', 'settlements', 'nextFileNumber'));
    }
    public function store(Request $request, SettlementMain $settlements)
    {
        $data = $request->except('_token', 'client_address', 'type');
        $data['user_id'] = Auth::id();
        $data['settlement_main_id'] = $settlements->id;
        try {
            DB::beginTransaction();
            Settlement::create($data);
            DB::commit();
            return redirect()->route('settlement.index', $settlements)->with('success', 'تم إضافة التسوية بنجاح');
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'حدث خطأ أثناء الإضافة: ' . $th->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $data = Settlement::with(['creator', 'updater'])->findOrFail($id);
        return view('admin.Settlement.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Settlement::with(['creator', 'updater'])->findOrFail($id);

        $clients = Client::with('user')->where('seen', 1)->where('active', 1)->orderBy('id', 'desc')->get();
        $partners = User::whereIn('role', ['superadmin', 'admin', 'Lawyer'])->get();
        return view('admin.Settlement.edit', compact('data', 'clients', 'partners'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'settlement_type' => 'required|string|max:255',
            'partner_id' => 'required|exists:users,id',
            'client_id' => 'required|exists:clients,id',
            'client_national_id' => 'required|string|max:255',
            'opponent_name' => 'required|string|max:255',
            'opponent_national_id' => 'nullable|string|max:255',
            'opponent_status' => 'nullable|string|max:255',
            'obligation' => 'nullable|string|max:255',
            'file_number' => 'nullable|string|max:255',
            'opponent_address' => 'nullable|string|max:255',
            'opponent_phone' => 'nullable|string|max:255',
            'amount' => 'nullable|numeric',
            'payment_terms' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,archived,canceled',
        ]);

        try {
            DB::beginTransaction();
            $settlement = Settlement::findOrFail($id);
            $data = $request->except('_token');
            $data['updated_by'] = Auth::id();
            $settlement->update($data);
            DB::commit();
            return redirect()->route('settlement.index')->with('success', 'تم تعديل التسوية بنجاح');
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'حدث خطأ أثناء التعديل: ' . $th->getMessage())->withInput();
        }
    }

    public function destroy(Request $request)
    {
        $settlement = Settlement::findOrFail($request->id);
        if (!$settlement) {
            return redirect()->back()->with('error', 'عفواً لا توجد بيانات');
        }
        $request->validate([
            'reason' => 'required|string',
        ]);
        $settlement->updated_by = Auth::id();
        $settlement->delete_reason = $request->reason;
        $settlement->save();
        $settlement->delete();
        return redirect()->route('settlement.index')->with('success', 'تم حذف التسوية بنجاح');
    }

    public function indexDelete()
    {
        $data = Settlement::onlyTrashed()->with(['creator', 'updater'])->get();
        return view('admin.Settlement.index-delete', compact('data'));
    }

    public function restore($id)
    {
        $settlement = Settlement::withTrashed()->find($id);
        if (!$settlement) {
            return redirect()->route('settlement.indexDelete')->with('error', 'عفواً لا توجد بيانات');
        }
        $settlement->updated_by = Auth::id();
        $settlement->delete_reason = "";
        $settlement->save();
        $settlement->restore();
        return redirect()->route('settlement.indexDelete')->with('success', 'تم استرجاع التسوية بنجاح');
    }
}
