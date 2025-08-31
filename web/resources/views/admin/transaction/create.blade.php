@extends('layouts.admin')

@section('title', 'المعاملات')
@section('main_title_content', 'إضافة معاملة')
@section('title_content', 'إضافة')
@section('link_content')
    <a href="{{ route('transactions.all', $transaction) }}">المعاملات</a>
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">
                    إضافة معاملة جديدة - ({{ $transaction->name ?? '-' }})
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ route('transactions.store', $transaction) }}" method="post">
                    @csrf

                    <input type="hidden" name="transactions_main_id" value="{{ $transaction->id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                    <div class="row">
                        <!-- العميل -->
                        <div class="form-group col-md-6">
                            <label for="client_id">العميل</label>
                            <select name="client_id" id="client_id" class="form-control">
                                <option value="">اختر العميل</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}"
                                        {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('client_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- رقم الملف -->
                        <div class="form-group col-md-6">
                            <label for="file_number">رقم الملف</label>
                            <input type="text" name="file_number" id="file_number" value="{{ old('file_number') }}"
                                class="form-control">
                            @error('file_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- اسم العميل -->
                        <div class="form-group col-md-6">
                            <label for="client_name">اسم العميل</label>
                            <input type="text" name="client_name" id="client_name" value="{{ old('client_name') }}"
                                class="form-control">
                            @error('client_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- المنطقة -->
                        <div class="form-group col-md-6">
                            <label for="area_name">المنطقة</label>
                            <input type="text" name="area_name" id="area_name" value="{{ old('area_name') }}"
                                class="form-control">
                            @error('area_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- الوصف -->
                        <div class="form-group col-md-6">
                            <label for="description">الوصف</label>
                            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- ملاحظات -->
                        <div class="form-group col-md-6">
                            <label for="notes">الملاحظات</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
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
                                <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>نشط</option>
                                <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>غير نشط</option>
                            </select>
                            @error('is_active')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-success">حفظ</button>
                        <a href="{{ route('transactions.all', $transaction) }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
