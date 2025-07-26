<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShiftTypeRequest;
use App\Models\ShiftType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShiftTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $com_code = auth()->user()->com_code;
        $data = ShiftType::select("*")->where('com_code', $com_code)->orderby('id', 'DESC')->paginate(10);
        return view('admin.ShiftsTypes.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.ShiftsTypes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            DB::beginTransaction();
            ShiftType::create($data);
            DB::commit();
            return redirect()->route('shiftstypes.index')->with(['success' => 'تم اضافة الشفت بنجاح']);
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with(["error" => 'عفواً حدث خطأ' . $th->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function ajsxserach(Request $request)
    {
        if ($request->ajax()) {
            $type_search = $request->type_search;
            $hour_from_range = $request->hour_from_range;
            $hour_to_range = $request->hour_to_range; 
            $pc=1;

            if ($type_search == 'all') {
                //هنا نعمل شرط دائم التحقق
                $field1 = "id";
                $operator1 = ">";
                $value1 = 0;
            } else {
                $field1 = "type";
                $operator1 = "=";
                $value1 = $type_search;
            }
            if ($hour_from_range == '') {
                //هنا نعمل شرط دائم التحقق
                $field2 = "id";
                $operator2 = ">";
                $value2 = 0;
            } else {
                $field2 = "total_hours";
                $operator2 = ">=";
                $value2 = $hour_from_range;
            }
            if ($hour_to_range == '') {
                //هنا نعمل شرط دائم التحقق
                $field3 = "id";
                $operator3 = ">";
                $value3 = 0;
            } else {
                $field3 = "total_hours";
                $operator3 = "<=";
                $value3 = $hour_to_range;
            }
            if($type_search=='all' and $hour_from_range == '' and $hour_to_range == ''){
                $pc=10;
            }
            $data = ShiftType::select("*")->where($field1, $operator1, $value1)->where($field2, $operator2, $value2)->where($field3, $operator3, $value3)->orderby('id', 'DESC')->paginate($pc);
            return view('admin.ShiftsTypes.serachajsx', ['data' => $data]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = ShiftType::select("*")->where('id', $id)->first();
        return view('admin.ShiftsTypes.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShiftTypeRequest $request, $id)
    {
        try {
            $data = get_cols_where_row(new ShiftType(), array("*"), array("id" => $id, 'com_code' => $request->com_code));
            if (empty($data)) {
                return redirect()->route('branches.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة']);
            }

            DB::beginTransaction();
            $updateData['type'] = $request->type;
            $updateData['from_time'] = $request->from_time;
            $updateData['to_time'] = $request->to_time;
            $updateData['total_hours'] = $request->total_hours;
            $updateData['updated_by'] = $request->updated_by;
            $updateData['updated_at'] = $request->updated_at;
            $updateData['active'] = $request->active;

            ShiftType::where('id', $id)->update($updateData);
            DB::commit();
            return redirect()->route('shiftstypes.index')->with(["success" => 'تم تعديل البيانات بنجاح']);
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'عفواً حدث خطأ' . $th->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = ShiftType::select("*")->where(['id' => $id, 'com_code' => $com_code])->first();
            if (empty($data)) {
                return redirect()->back()->with(['error' => 'عفوا حدث خطأ']);
            }
            if (ShiftType::where('id', $id)->delete()) {
                return redirect()->back()->with(['success' => 'تم حذف البيانات بنجاح']);
            }
        } catch (\Exception $th) {
            return redirect()->back()->with(['error' => 'عفواً حدث خطأ' . $th->getMessage()])->withInput();
        }
    }
}
