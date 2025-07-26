<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResignationRequest;
use App\Models\Resignation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ResignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $com_code=auth()->user()->com_code;
        $data=Resignation::select('*')->where('com_code',$com_code)->orderby('id','DESC')->paginate(PAGINATE_COUNTER);
        return view('admin.Resignation.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.Resignation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ResignationRequest $request)
    {
        try {
            $com_code=$request->com_code;
            $data=$request->all();
            DB::beginTransaction();
            $validtor=Validator::make($request->all(),['name'=>['required',Rule::unique('resignations','name')->where(
                function ($query) use ($com_code){
                    return $query->where('com_code',$com_code);
                }
            )]]);
            if($validtor->fails()){
                return redirect()->back()->with(['error'=>'عفواً بيانات موجودة مسبقاً'])->withInput();

            }
            Resignation::create($data);
            DB::commit();
            return redirect()->route('resignations.index')->with(['success'=>'تم إضافة البيانات بنجاح']);
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with(['error'=>'عفواً حدث خطأ  '.$th->getMessage()])->withInput();

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $com_code=auth()->user()->com_code;
        $data= Resignation::select('*')->where(['id'=>$id,'com_code'=>$com_code])->first();
        if(empty($data)){
            return redirect()->route('resignations.index')->with(['error'=>'البيانات غير موجودة']);

        }else{
            return view('admin.Resignation.edit',compact('data'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ResignationRequest $request, string $id)
    {
        try {
            $com_code=$request->com_code;
            DB::beginTransaction();
            $validtor=Validator::make($request->all(),['name'=>['required',Rule::unique('qualifications','name')->where(
                function ($query) use ($com_code){
                    return $query->where('com_code',$com_code);
                }
            )->ignore($id)]]);
            if($validtor->fails()){
                return redirect()->back()->with(['error'=>'عفواً سبب ترك الوظيفة موجود مسبقاً'])->withInput();

            }
            $dataUpdate['name']=$request->name;
            $dataUpdate['active']=$request->active;
            $dataUpdate['updated_by']=$request->updated_by;
            Resignation::where(['id'=>$id,'com_code'=>$com_code])->update($dataUpdate);
            DB::commit();
            return redirect()->route('resignations.index')->with(['success'=>'تم تعديل البيانات بنجاح']);
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with(['error'=>'عفواً حدث خطأ  '.$th->getMessage()])->withInput();

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = Resignation::select('*')->where(['id' => $id, 'com_code' => $com_code])->first();
            if (empty($data)) {
                return redirect()->route('resignations.index')->with(['error' => 'عفواً البيانات غير موجودة']);
            }
            DB::beginTransaction();
            Resignation::where(['id' => $id, 'com_code' => $com_code])->delete();
            DB::commit();
            return redirect()->route('resignations.index')->with(['success' => 'تم حذف البيانات بنجاح']);
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'عفواً حدث خطأ  ' . $th->getMessage()])->withInput();
        }
    }
}
