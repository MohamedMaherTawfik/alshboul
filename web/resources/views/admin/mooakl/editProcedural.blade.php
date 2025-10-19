@extends('layouts.admin')
@section('title', 'تعديل الإجراء')
@section('main_title_content', 'تعديل بيانات الإجراء')
@section('link_content')
    <a href="{{ route('client.visit') }}">الموكلين</a>
@endsection

@section('content')
    <div class="card shadow-lg border-0">
        <div class="card-header bg-dark text-white fw-bold text-center">
            تعديل الإجراء
        </div>
        <div class="card-body">
            <form action="{{ route('client.procedural.update', $client->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- @method('PUT') لو استخدمت PUT في الراوت --}}

                <input type="hidden" name="client_id" value="{{ $client->client_id }}">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">نوع الإجراء</label>
                        <input type="text" class="form-control" name="procedural_type"
                            value="{{ old('procedural_type', $client->procedural_type) }}" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">تاريخ إدخال الإجراء</label>
                        <input type="date" class="form-control" name="created_at"
                            value="{{ old('created_at', \Carbon\Carbon::parse($client->created_at)->format('Y-m-d')) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الإجراء الرئيسي</label>
                        <input type="text" class="form-control" name="procedural"
                            value="{{ old('procedural', $client->procedural) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الجهة</label>
                        <input type="text" class="form-control" name="side" value="{{ old('side', $client->side) }}"
                            required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">اختر المحامي</label>
                        <select name="lawyer_id" class="form-select">
                            @foreach ($lawyers as $item)
                                <option value="{{ $item->id }}" {{ $item->id == $client->lawyer_id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">الحالة</label>
                    <select class="form-select" name="status">
                        <option value="0" {{ $client->status == 0 ? 'selected' : '' }}>غير مكتمل</option>
                        <option value="1" {{ $client->status == 1 ? 'selected' : '' }}>مكتمل</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('client.visit') }}" class="btn btn-secondary">إلغاء</a>
                    <button type="submit" class="btn btn-primary">تحديث الإجراء</button>
                </div>
            </form>
        </div>
    </div>
@endsection
