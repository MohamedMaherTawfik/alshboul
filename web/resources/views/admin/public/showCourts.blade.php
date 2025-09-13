@extends('layouts.admin')

@section('title', 'البحث العام')
@section('main_title_content', 'البحث العام')
@section('title_content', 'البحث العام')

@section('content')
    <div class="container-fluid px-4 py-3">

        {{-- نموذج البحث --}}
        <div class="card shadow-sm mb-5 w-100">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0"><i class="fas fa-search me-2"></i> نموذج البحث المتقدم</h5>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('public.search.find') }}">
                    @csrf

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
                                placeholder="ادخل رقم القضية">
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
                            <i class="fas fa-search me-2"></i> بحث
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- نتائج البحث الخاصة بالموكل --}}
        @if (isset($court) && request()->routeIs('public.search.find'))
            <div class="mt-5">

            </div>
        @endif
    </div>
@endsection

@section('styles')
    <style>
        .card {
            border-radius: 12px;
        }

        .card-header h5 {
            font-size: 1.1rem;
            font-weight: bold;
        }

        .table thead th {
            vertical-align: middle;
            text-align: center;
        }

        .table td {
            text-align: center;
        }
    </style>
@endsection
