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

                            <input type="text" id="searchDetail" class="form-control mr-2"
                                placeholder="بحث تفاصيل الإجراء"
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
                                        <th class="text-center">وقائع الإجراء</th>
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
                                    @forelse($client->clientProcedurals->sortByDesc('id') as $procedural)
                                        <tr>
                                            <td class="text-center">{{ $procedural->user->name ?? 'غير محدد' }}</td>
                                            <td class="text-center">
                                                {{ $procedural->created_at->format('Y-m-d') ?: 'غير محدد' }}</td>
                                            <td class="text-center procedural-col">
                                                {{ $procedural->procedural ?? 'غير محدد' }}</td>
                                            <td class="text-center">
                                                {{ $procedural->lawyer->name ?? 'غير محدد' }}</td>
                                            <td class="text-center">{{ $procedural->side }}</td>
                                            <td class="facts-col">
                                                {{ $procedural->procedural_facts }}
                                            </td>

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
                                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editProceduralModal{{ $procedural->id }}">
                                                        تعديل الاجراء
                                                    </button>
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

                                        <!-- مودال التعديل -->
                                        <div class="modal fade" id="editProceduralModal{{ $procedural->id }}"
                                            tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">تعديل الإجراء</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('client.procedural.update', $procedural) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">نوع الإجراء</label>
                                                                <input type="text" class="form-control" value="اجراء"
                                                                    readonly>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">تاريخ ادخل الإجراء </label>
                                                                <input type="date" class="form-control"
                                                                    name="created_at"
                                                                    value="{{ now()->format('Y-m-d') }}">
                                                            </div>


                                                            <div class="mb-3">
                                                                <label class="form-label">تاريخ الإجراء اللاحق</label>
                                                                <input type="date" class="form-control"
                                                                    name="next_action_date">
                                                            </div>


                                                            <div class="mb-3">
                                                                <label class="form-label">الاجراء الرئيسي</label>
                                                                <input type="text" class="form-control"
                                                                    name="procedural"
                                                                    value="{{ $procedural->procedural }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">الجهة</label>
                                                                <input type="text" class="form-control" name="side"
                                                                    value="{{ $procedural->side }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">وقائع الإجراء</label>
                                                                <textarea class="form-control" name="procedural_facts" rows="3">{{ $procedural->procedural_facts }}</textarea>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">اختر المحامي</label>
                                                                <select name="lawyer_id" class="form-select">
                                                                    @foreach ($lawyers as $item)
                                                                        <option value="{{ $item->id }}"
                                                                            {{ $procedural->lawyer_id == $item->id ? 'selected' : '' }}>
                                                                            {{ $item->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">الحالة</label>
                                                                <select class="form-select" name="status">
                                                                    <option value="0"
                                                                        {{ $procedural->status == 0 ? 'selected' : '' }}>
                                                                        غير مكتمل
                                                                    </option>
                                                                    <option value="1"
                                                                        {{ $procedural->status == 1 ? 'selected' : '' }}>
                                                                        مكتمل
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">إلغاء</button>
                                                            <button type="submit" class="btn btn-primary">حفظ
                                                                التعديل</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- نهاية المودال -->
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
    </style>

    <style>
        .facts-col {
            max-width: 400px;

            text-align: justify;
            /* يوزع الكلام زي المقال */
            direction: rtl;
            /* عشان عربي يبدأ من اليمين */
        }
    </style>

@endsection
