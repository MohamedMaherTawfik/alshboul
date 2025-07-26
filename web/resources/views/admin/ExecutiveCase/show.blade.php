@extends('layouts.admin')
@section('title', 'القضايا التنفيذية')
@section('main_title_content', 'قائمة القضايا التنفيذية')
@section('title_content', 'عرض القضية التنفيذية')
@section('link_content')
    <a href="{{ route('executive-case.index') }}">
        قضايا تنفيذية</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">تفاصيل القضية التنفيذية</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-4"><strong>رقم القضية:</strong> {{ $data->case_number }}</div>
                    <div class="form-group col-md-4"><strong>الرقم الوطني:</strong> {{ $data->national_id }}</div>
                    <div class="form-group col-md-4"><strong>رقم الملف:</strong> {{ $data->file_number ?? 'غير محدد' }}</div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6"><strong>اسم المدعي:</strong> {{ $data->plaintiff->name }}</div>
                    <div class="form-group col-md-6"><strong>اسم المدعى عليه:</strong> {{ $data->defendant_name }}</div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4"><strong>موقع التنفيذ:</strong>
                        {{ $data->execution_location ?? 'غير محدد' }}</div>
                    <div class="form-group col-md-4"><strong>نوع التنفيذ:</strong> {{ $data->execution_type ?? 'غير محدد' }}
                    </div>
                    <div class="form-group col-md-4"><strong>المحامي/الموظف :</strong>
                        {{ $data->executioner->username ?? 'غير محدد' }}</div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4"><strong>تاريخ التنفيذ:</strong>
                        {{ $data->execution_date ?? 'غير محدد' }}</div>
                    <div class="form-group col-md-4"><strong>طريقة التنفيذ:</strong>
                        {{ $data->execution_method ?? 'غير محدد' }}</div>
                    <div class="form-group col-md-4"><strong>حالة التنفيذ:</strong>
                        {{ $data->execution_status ?? 'غير محدد' }}</div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4"><strong>مصدر التنفيذ:</strong>
                        {{ $data->execution_source ?? 'غير محدد' }}</div>
                    <div class="form-group col-md-4"><strong>رقم المرجع:</strong>
                        {{ $data->reference_number ?? 'غير محدد' }}</div>
                    <div class="form-group col-md-4"><strong>تاريخ المرجع:</strong>
                        {{ $data->reference_date ?? 'غير محدد' }}</div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6"><strong>رقم المحكمة أو الحكم:</strong>
                        {{ $data->court_or_ruling_number ?? 'غير محدد' }}</div>
                    <div class="form-group col-md-6"><strong>اسم المحكمة أو الحكم:</strong>
                        {{ $data->court_or_ruling_name ?? 'غير محدد' }}</div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6"><strong>نسخة ملف التنفيذ:</strong>
                        @if ($data->execution_file_copy)
                            <a href="{{ asset('storage/' . $data->execution_file_copy) }}" target="_blank">عرض الملف</a>
                        @else
                            <span>لا توجد نسخة ملف</span>
                        @endif
                    </div>
                    <div class="form-group col-md-6"><strong>الحالة:</strong> {{ $data->status ?? 'غير محدد' }}</div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12"><strong>ملاحظات:</strong> {{ $data->notes ?? 'لا توجد ملاحظات' }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="form-group col-md-4"><strong>إضافة بواسطة:</strong>
                        {{ $data->creator->username ?? 'غير محدد' }}</div>
                    <div class="form-group col-md-4"><strong>تعديل بواسطة:</strong>
                        {{ $data->updater->username ?? 'لم يتم التعديل' }}</div>
                    <div class="form-group col-md-4"><strong>تاريخ الإنشاء:</strong>
                        {{ $data->created_at->format('Y-m-d') }}</div>
                </div>
                @if ($data->updated_at != $data->created_at)
                    <div class="row">
                        <div class="form-group col-md-4"><strong>تاريخ آخر تعديل:</strong>
                            {{ $data->updated_at->format('Y-m-d') }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
