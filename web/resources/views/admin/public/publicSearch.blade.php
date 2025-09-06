@extends('layouts.admin')

@section('title', 'البحث العام')
@section('main_title_content', 'البحث العام')
@section('title_content', 'البحث العام')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0">نموذج البحث المتقدم</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('public.search') }}">
                    @csrf

                    text
                    <div class="row">
                        {{-- بحث المشترك --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">بحث المشترك</label>
                            <select name="client_id" class="form-select form-select-lg">
                                <option value="">اختر المشترك</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- بحث الخصم --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">بحث الخصم</label>
                            <select name="opponent_id" class="form-select form-select-lg">
                                <option value="">اختر الخصم</option>
                                @foreach ($opponents as $opponent)
                                    <option value="{{ $opponent->id }}">{{ $opponent->case_opponent_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        {{-- بحث القضية --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">بحث القضية</label>
                            <input type="text" name="case" class="form-control form-control-lg"
                                placeholder="ادخل رقم أو اسم القضية">
                        </div>

                        {{-- بحث المحكمة --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">بحث المحكمة</label>
                            <input type="text" name="court" class="form-control form-control-lg"
                                placeholder="ادخل اسم المحكمة">
                        </div>
                    </div>

                    {{-- زرار البحث --}}
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-search me-2"></i>بحث
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('styles')

    <style>
        .card {
            border: none;
            border-radius: 10px;
        }

        .form-select,
        .form-control {
            border-radius: 8px;
            border: 1px solid #ddd;
            transition: all 0.3s;
        }

        .form-select:focus,
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        .btn-primary {
            border-radius: 8px;
            padding: 10px 30px;
        }
    </style>
@endsection
