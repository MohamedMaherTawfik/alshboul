@extends('layouts.admin')

@section('title', 'تعديل موكل')
@section('main_title_content', 'تعديل بيانات الموكل')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="{{ route('client.index') }}">الموكلين</a>
@endsection

@section('content')
    {{-- Success Message --}}
    @if (session('success'))
        <div class="p-4 mb-4 text-green-800 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- Failure / General Error Message --}}
    @if (session('error'))
        <div class="p-4 mb-4 text-red-800 bg-red-100 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="p-4 mb-4 text-red-800 bg-red-100 rounded-lg">
            <ul class="list-disc ps-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-white text-center">
                <h4>تعديل بيانات الموكل</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('client.update', $client) }}" method="POST">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="name">اسم الموكل</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $client->name) }}"
                            class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="address">العنوان</label>
                        <input type="text" name="address" id="address" value="{{ old('address', $client->address) }}"
                            class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="phone">الهاتف</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $client->phone) }}"
                            class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="active">الحالة</label>
                        <select name="active" id="active" class="form-control">
                            <option value="1"
                                {{ old('active', optional($client->user)->active) == 1 ? 'selected' : '' }}>
                                مفعل
                            </option>
                            <option value="0"
                                {{ old('active', optional($client->user)->active) == 0 ? 'selected' : '' }}>
                                معطل
                            </option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('client.index') }}" class="btn btn-secondary">رجوع</a>
                        <button type="submit" class="btn btn-warning">تحديث</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
