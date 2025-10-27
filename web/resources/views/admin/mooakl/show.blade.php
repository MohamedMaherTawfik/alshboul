@php
    use App\Models\User;
    $lawyers = User::whereIn('role', ['Lawyer', 'admin', 'superadmin'])->get();
@endphp

@extends('layouts.admin')
@section('title', 'الموكل')
@section('main_title_content', 'اجراءات الموكل')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('client.visit') }}"> موكلين</a>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- بطاقة بيانات الموكل -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow border-0">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user-tie me-2"></i>بيانات الموكل
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-3 bg-light">
                                    <h6 class="text-muted small">الاسم</h6>
                                    <p class="mb-0 fw-bold">{{ $client->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-3 bg-light">
                                    <h6 class="text-muted small">الرقم الوطني</h6>
                                    <p class="mb-0 fw-bold">{{ $client->national_id ?? 'غير محدد' }}</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-3 bg-light">
                                    <h6 class="text-muted small">رقم التليفون</h6>
                                    <p class="mb-0 fw-bold">{{ $client->phone ?? 'غير محدد' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- قسم الإجراءات -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow border-0">
                    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-tasks me-2"></i>الإجراءات
                        </h5>
                        <a href="{{ route('client.procedural.create', $client) }}" class="btn btn-success">اضافه اجراء</a>
                    </div>
                    <div class="card-body">

                        <div class="mb-3 d-flex gap-2">
                            <input type="text" id="searchMain" class="form-control" placeholder="بحث الإجراء الرئيسي"
                                style="width:20%; border:2px solid #00000085; font-weight:500;">
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover" id="proceduralTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">اسم المدخل</th>
                                        <th class="text-center">تاريخ الادخال</th>
                                        <th class="text-center"> الاجراء الرئيسي</th>
                                        <th class="text-center"> المحامي</th>
                                        <th class="text-center">الجهة</th>
                                        <th class="text-center">الحالة</th>
                                        <th class="text-center">الموكل</th>
                                        <th class="text-center">تاريخ الاجراء اللاحق</th>
                                        <th class="text-center">اجراء فرعي</th>
                                        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                            <th class="text-center">التحكم</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($client->clientProcedurals->sortByDesc('created_at') as $procedural)
                                        <tr>
                                            <td class="text-center">{{ $procedural->user->name ?? 'غير محدد' }}</td>
                                            <td class="text-center">
                                                {{ $procedural->created_at->format('Y-m-d') ?: 'غير محدد' }}</td>
                                            <td class="text-center procedural-col">
                                                {{ $procedural->procedural ?? 'غير محدد' }}</td>
                                            <td class="text-center">{{ $procedural->lawyer->name ?? 'غير محدد' }}</td>
                                            <td class="text-center">{{ $procedural->side }}</td>
                                            <td class="text-center">
                                                <span
                                                    class="badge p-2 {{ $procedural->status ? 'bg-success' : 'bg-warning' }}">
                                                    {{ $procedural->status ? 'مكتمل' : 'غير مكتمل' }}
                                                </span>
                                            </td>
                                            <td class="text-center">{{ $procedural->client->name ?? 'غير محدد' }}</td>
                                            <td class="text-center">{{ $procedural->next_action_date ?? 'غير محدد' }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('client.procedural.sub.index', $procedural) }}">اجراء
                                                    فرعي</a>
                                            </td>
                                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                                <td class="text-center">
                                                    <a href="{{ route('client.procedural.edit', $procedural) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        تعديل الاجراء
                                                    </a>
                                                    <form action="{{ route('client.procedural.delete', $procedural) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                                            حذف الاجراء
                                                        </button>
                                                    </form>
                                                </td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center py-4">
                                                <i class="fas fa-tasks fa-2x text-muted mb-3"></i>
                                                <h5 class="text-muted">لا توجد إجراءات مسجلة</h5>
                                                <p class="text-muted">يمكنك إضافة إجراء جديد باستخدام الزر بالأعلى</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Live search JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchMain');
            const tableRows = document.querySelectorAll('#proceduralTable tbody tr');

            searchInput.addEventListener('keyup', function() {
                const filter = this.value.toLowerCase();
                tableRows.forEach(row => {
                    const proceduralCell = row.querySelector('.procedural-col');
                    if (proceduralCell) {
                        const proceduralText = proceduralCell.textContent.toLowerCase();
                        row.style.display = proceduralText.includes(filter) ? '' : 'none';
                    }
                });
            });
        });
    </script>

    <style>
        .card {
            border-radius: 10px;
        }

        .card-header {
            border-top-left-radius: 10px !important;
            border-top-right-radius: 10px !important;
        }

        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
        }

        .badge {
            font-size: 0.85em;
        }

        .facts-col {
            max-width: 400px;
            text-align: justify;
            direction: rtl;
        }
    </style>
@endsection
