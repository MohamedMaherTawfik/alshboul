@extends('layouts.admin')
@section('title', ' طلبات الموكلين ')
@section('main_title_content', ' قائمة طلبات الموكلين ')
@section('title_content', 'أضافة')
@section('link_content')
    <a href="{{ route('request.index') }}"> موكلين</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center"> اضافة طلب جديد
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ route('request.store') }}" method="post">
                    @csrf
                    {{-- <input type="hidden" name="updated_by" value="{{ auth()->user()->id }}"> --}}
                    <input type="hidden" name="added_by" value="{{ Auth::user()->id }}">

                    <div class="col-md-12">
                        <div class="form-group ">
                            <label for=""> عنوان الطلب </label>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-control"
                                placeholder="">
                            @error('title')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group ">
                            <label for="">الملاحظة </label>
                            <textarea class="form-control" name="note" id="" cols="80" rows="10">{{ old('note') }} </textarea>
                            @error('note')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="text-center col-md-12">
                        <button type="submit" class="btn btn-success">أضافة</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const companyInput = document.getElementById("company_name");
            const nationalWrapper = document.getElementById("company_national_wrapper");

            function toggleNationalField() {
                if (companyInput.value.trim() !== "") {
                    nationalWrapper.style.display = "block";
                } else {
                    nationalWrapper.style.display = "none";
                }
            }

            companyInput.addEventListener("input", toggleNationalField);

            // تشغيل الفحص أول ما يفتح الصفحة لو في قيمة مسبقة
            toggleNationalField();
        });
    </script>


@endsection
