@extends('layouts.admin')
@section('title', 'المصاريف')
@section('main_title_content', 'قائمة المصاريف')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('cases.all') }}"> جميع القضايا</a>
@endsection
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 25px;
        border: none;
    }

    .card-header {
        background-color: #4e73df;
        color: white;
        border-radius: 10px 10px 0 0 !important;
        padding: 15px 20px;
        font-weight: 700;
    }

    .info-label {
        font-weight: 600;
        color: #5a5c69;
        margin-bottom: 5px;
    }

    .info-value {
        font-weight: 700;
        color: #2e59d9;
        font-size: 1.1rem;
    }

    .section-title {
        border-bottom: 2px solid #e3e6f0;
        padding-bottom: 10px;
        margin-bottom: 20px;
        color: #4e73df;
        font-weight: 700;
    }

    .total-box {
        background-color: #f8f9fc;
        border-left: 4px solid #4e73df;
        padding: 15px;
        border-radius: 5px;
    }

    .currency {
        color: #858796;
        font-size: 0.9rem;
    }

    .btn-print {
        background-color: #36b9cc;
        color: white;
    }

    .btn-print:hover {
        background-color: #2c9faf;
        color: white;
    }

    @media print {
        .no-print {
            display: none;
        }

        .card {
            box-shadow: none;
            border: 1px solid #ddd;
        }
    }
</style>
@section('content')

    <div class="container py-5">
        <!-- عنوان الصفحة -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h2 class="h4 text-gray-800"><i class="bi bi-cash-coin me-2"></i>تفاصيل المصاريف والفوائد</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="#">جميع القضايا</a></li>
                        <li class="breadcrumb-item active" aria-current="page">عرض المصاريف</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 text-start no-print">
                <a href="{{ route('cases.all') }}" class="btn btn-secondary"><i class="bi bi-arrow-return-right me-1"></i>
                    رجوع</a>
            </div>
        </div>

        <!-- البطاقة الرئيسية -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">تفاصيل المصاريف والفوائد للقضية رقم: {{ $case->case_number }}</h5>
            </div>
            <div class="card-body">
                <!-- معلومات القضية -->
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <div class="info-label">اسم الموكل:</div>
                        <div class="info-value">{{ $case->client->name }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-label">اسم الخصم:</div>
                        <div class="info-value">{{ $case->opponent_name }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-label">قيمة الدعوى:</div>
                        <div class="info-value">{{ $case->case_amount }} </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-label">بداية احتساب الفائدة:</div>
                        <div class="info-value">{{ $case->benefit_date }}</div>
                    </div>
                </div>

                <hr>

                <!-- تفاصيل الفوائد -->
                <h5 class="section-title"><i class="bi bi-percent me-2"></i>تفاصيل الفوائد</h5>
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="info-label">عدد أيام الاحتساب:</div>
                        <div class="info-value">{{ floor((time() - strtotime($case->benefit_date)) / (60 * 60 * 24)) }} يوم
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="info-label">نسبة الفائدة:</div>
                        <div class="info-value">9% سنويا</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="info-label">قيمة الفائدة:</div>
                        <div class="info-value">{{ $amount }}<span class="currency">ريال سعودي</span>
                        </div>
                    </div>
                </div>

                <hr>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
