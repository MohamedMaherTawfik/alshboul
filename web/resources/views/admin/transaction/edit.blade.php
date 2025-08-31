@extends('layouts.admin')

@section('title', 'المعاملات')
@section('main_title_content', 'تعديل معاملة')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="{{ route('transactions.all', $transaction) }}">المعاملات</a>
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">
                    تعديل معاملة - ({{ $transaction->name ?? '-' }})
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ route('transactions.update', [$transaction]) }}" method="post">
                    @csrf

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="subscriber_id">المشترك</label>
                            <input type="text" name="client_name" id="client_id" class="form-control"
                                value="{{ old('client_name', $transaction->client?->name) }}" readonly>
                            <input type="hidden" name="client_id" id="subscriber_id"
                                value="{{ old('subscriber_id', $transaction->client_id) }}">
                            @error('subscriber_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- رقم الملف -->
                        <div class="form-group col-md-6">
                            <label for="file_number">رقم الملف</label>
                            <input type="text" name="file_number" id="file_number"
                                value="{{ old('file_number', $transaction->file_number) }}" class="form-control" readonly>
                            @error('file_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- الموكل -->
                        <div class="form-group col-md-6">
                            <label for="client_id">الموكل</label>
                            <input type="text" class="form-control" name="client_name" id="client_name"
                                value="{{ old('client_name', $transaction->client_name) }}" readonly>
                            @error('client_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- المنطقة -->
                        <div class="form-group col-md-6">
                            <label for="area_name">اسم الدائره المختصه</label>
                            <input type="text" name="area_name" id="area_name"
                                value="{{ old('area_name', $transaction->area_name) }}" class="form-control">
                            @error('area_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- الوصف -->
                        <div class="form-group col-md-6">
                            <label for="description">الوصف</label>
                            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $transaction->description) }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- ملاحظات -->
                        <div class="form-group col-md-6">
                            <label for="notes">الملاحظات</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes', $transaction->notes) }}</textarea>
                            @error('notes')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- الحالة -->
                        <div class="form-group col-md-6">
                            <label for="is_active">الحالة</label>
                            <select name="is_active" id="is_active" class="form-control">
                                <option value="1"
                                    {{ old('is_active', $transaction->is_active) == 1 ? 'selected' : '' }}>نشط</option>
                                <option value="0"
                                    {{ old('is_active', $transaction->is_active) == 0 ? 'selected' : '' }}>غير نشط
                                </option>
                            </select>
                            @error('is_active')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-success">تعديل</button>
                        <a href="{{ route('transactions.all', $transaction) }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
