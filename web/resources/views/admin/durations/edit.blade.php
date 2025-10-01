@extends('layouts.admin')
@section('title', 'تعديل مدة قانونية')
@section('main_title_content', 'تعديل المدة القانونية')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="{{ route('cases.all') }}">جميع القضايا</a>
@endsection

<style>
    /* نفس الستايل اللي عندك */
</style>

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col">
                <h2 class="header-title">تعديل مدة قانونية</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cases.all') }}">جميع القضايا</a></li>
                        <li class="breadcrumb-item active" aria-current="page">تعديل مدة قانونية</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-calendar-range me-2"></i>نموذج تعديل مدة قانونية</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('cases.durations.update', $case->id) }}" method="POST">
                    @csrf

                    <!-- معلومات القضية (غير قابلة للتعديل) -->
                    <div class="form-section">
                        <h5 class="section-title"><i class="bi bi-folder me-2"></i>معلومات القضية</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">رقم القضية</label>
                                <input type="text" class="form-control readonly-field"
                                    value="{{ $case->case->file_number ?? '--' }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">نوع القضية</label>
                                <input type="text" class="form-control readonly-field"
                                    value="{{ $case->case->suggestedCases->name ?? '--' }}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">الموكل</label>
                                <input type="text" class="form-control readonly-field"
                                    value="{{ $case->case->client->name ?? '--' }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">الخصم</label>
                                <input type="text" class="form-control readonly-field"
                                    value="{{ $case->case->opponent_name ?? '--' }}" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- بيانات المدة القانونية -->
                    <div class="form-section">
                        <h5 class="section-title"><i class="bi bi-clock-history me-2"></i>بيانات المدة القانونية</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="period_start" class="form-label">تاريخ بداية المدة</label>
                                <input type="date" class="form-control" id="period_start" name="period_start"
                                    value="{{ $case->period_start }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="period_end" class="form-label">تاريخ نهاية المدة</label>
                                <input type="date" class="form-control" id="period_end" name="period_end"
                                    value="{{ $case->period_end }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="period_facts" class="form-label">وقائع المدة</label>
                                <textarea class="form-control" id="period_facts" name="period_facts" rows="4" required>{{ $case->period_facts }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- معلومات إضافية -->
                    <div class="form-section">
                        <h5 class="section-title"><i class="bi bi-chat-left-text me-2"></i>معلومات إضافية</h5>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="notes" class="form-label">ملاحظات</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3">{{ $case->notes }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- أزرار الحفظ -->
                    <div class="row mt-4">
                        <div class="col-12 text-start">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check2-circle me-2"></i>تحديث المدة القانونية
                            </button>
                            <a href="{{ route('cases.all') }}" class="btn btn-outline-secondary px-4 me-2">
                                <i class="bi bi-x-circle me-2"></i>إلغاء
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
