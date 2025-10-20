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

    .currency {
        color: #858796;
        font-size: 0.9rem;
    }

    .btn-add-expense {
        background-color: #1cc88a;
        color: white;
    }

    .btn-add-expense:hover {
        background-color: #17a673;
        color: white;
    }

    .table th {
        background-color: #4e73df;
        color: white;
        text-align: center;
    }

    .table td {
        text-align: center;
        vertical-align: middle;
    }

    .total-box {
        background: #f8f9fc;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        font-size: 1.1rem;
        font-weight: 700;
    }

    .total-positive {
        color: #1cc88a;
    }

    .total-negative {
        color: #e74a3b;
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
                <a href="{{ route('cases.all') }}" class="btn btn-secondary"><i
                        class="bi bi-arrow-return-right me-1"></i>رجوع</a>
                <!-- زرار فتح المودال -->
                <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                    <i class="bi bi-plus-circle me-1"></i>إضافة مصاريف جديدة
                </button>
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
                        <div class="info-value">{{ $case->case_amount }}</div>
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
                        <div class="info-value">9% سنوياً</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="info-label">قيمة الفائدة:</div>
                        <div class="info-value">{{ $amount }} <span class="currency">دينار</span></div>
                    </div>
                </div>

                <hr>

                <!-- جدول العمليات -->
                <h5 class="section-title"><i class="bi bi-list-ul me-2"></i>سجل العمليات</h5>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>تاريخ العملية</th>
                                <th>نوع العملية</th>
                                <th>المبلغ</th>
                                @if (Auth::user()->role == 'superadmin')
                                    <th>العمليات</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($case->expenses as $index => $expense)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($expense->date)->format('Y-m-d') }}</td>
                                    <td>{{ $expense->type }}</td>
                                    <td>{{ number_format($expense->amount, 2) }}</td>
                                    @if (Auth::user()->role == 'superadmin')
                                        <td>
                                            {{-- form delete with are you sure --}}
                                            <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('هل تريد حذف هذه العملية؟')">حذف</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">لا توجد عمليات بعد</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @php
                    $total_in = $case->expenses->where('type', 'قبض')->sum('amount');
                    $total_out = $case->expenses->where('type', 'صرف')->sum('amount');
                    $net = $total_in - $total_out;
                @endphp

                <!-- الإجمالي -->
                <div class="total-box {{ $net >= 0 ? 'total-positive' : 'total-negative' }}">
                    <span>الإجمالي: </span>
                    {{ $net >= 0 ? '+' : '' }}{{ number_format($net, 2) }} دينار
                </div>
            </div>
        </div>
    </div>

    <!-- مودال إضافة العملية -->
    <div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('cases.storeExpenses', $case) }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addExpenseModalLabel">إضافة عملية جديدة</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="type" class="form-label">نوع العملية</label>
                        <select name="type" id="type" class="form-select" required>
                            <option value="" disabled selected>اختر نوع العملية</option>
                            <option value="صرف">صرف</option>
                            <option value="قبض">قبض</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="amount" class="form-label">مبلغ العملية</label>
                        <input type="number" name="amount" id="amount" class="form-control" min="0"
                            step="0.01" placeholder="أدخل المبلغ" required>
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label">تاريخ العملية</label>
                        <input type="date" name="date" id="date" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ العملية</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
