@php
    use App\Models\User;
    $lawyers = User::whereIn('role', ['Lawyer', 'admin', 'superadmin'])->get();
@endphp

@extends('layouts.admin')
@section('title', 'الموكل')
@section('main_title_content', 'اجراءات الموكل')
@section('title_content', 'إضافة إجراء جديد')
@section('link_content')
    <a href="{{ route('client.visit') }}">الموكلين</a>
@endsection

@section('content')
    <div class="card shadow-lg border-0">
        <div class="card-header bg-dark text-white fw-bold text-center">
            إضافة إجراء جديد
        </div>
        <div class="card-body">
            <form action="{{ route('client.procedural.store', $client) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="client_id" value="{{ $client->id }}">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">نوع الإجراء</label>
                        <input type="text" class="form-control" name="procedural_type" readonly value="اجراء">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">تاريخ إدخال الإجراء</label>
                        <input type="date" class="form-control" name="created_at" value="{{ now()->format('Y-m-d') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الإجراء الرئيسي</label>
                        <input type="text" class="form-control" name="procedural" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الجهة</label>
                        <input type="text" class="form-control" name="side" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">وقائع الإجراء</label>
                    <textarea class="form-control" name="procedural_facts" rows="3"></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="file_path" class="form-label">المستندات</label>
                        <input type="file" name="file_path[]" id="file_path" class="form-control" multiple>
                        <small class="text-muted">يمكنك اختيار أكثر من ملف</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">اختر المحامي</label>
                        <select name="lawyer_id" class="form-select">
                            @foreach ($lawyers as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">الحالة</label>
                    <select class="form-select" name="status">
                        <option value="0">غير مكتمل</option>
                        <option value="1">مكتمل</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('client.visit') }}" class="btn btn-secondary">إلغاء</a>
                    <button type="submit" class="btn btn-primary">إضافة الإجراء</button>
                </div>
            </form>
        </div>
    </div>
@endsection
