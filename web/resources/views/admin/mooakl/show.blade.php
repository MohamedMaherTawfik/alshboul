@extends('layouts.admin')
@section('title', 'الموكلين')
@section('main_title_content', 'قائمة الموكلين')
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
                        <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal"
                            data-bs-target="#addProceduralModal">
                            <i class="fas fa-plus me-1"></i> إضافة إجراء
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>نوع الإجراء</th>
                                        <th>الإجراء</th>
                                        <th>الجهة</th>
                                        <th>وقائع الإجراء</th>
                                        <th>الحالة</th>
                                        <th>المستخدم</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($client->clientProcedurals as $procedural)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $procedural->procedural_type }}</td>
                                            <td>{{ $procedural->procedural }}</td>
                                            <td>{{ $procedural->side }}</td>
                                            <td style="white-space: pre-wrap; word-wrap: break-word; max-width: 400px;">
                                                {{ $procedural->procedural_facts }}
                                            </td>

                                            <td>
                                                <span
                                                    class="badge p-2 {{ $procedural->status ? 'bg-success' : 'bg-warning' }}">
                                                    {{ $procedural->status ? 'مكتمل' : 'غير مكتمل' }}
                                                </span>
                                            </td>
                                            <td>{{ $procedural->user->name ?? 'غير محدد' }}</td>
                                            <td>
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
                                        </tr>

                                        <!-- Modal للتعديل -->
                                        <div class="modal fade" id="editProceduralModal{{ $procedural->id }}"
                                            tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">تعديل الإجراء</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('client.procedural.update', $procedural->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">نوع الإجراء</label>
                                                                <input type="text" class="form-control"
                                                                    name="procedural_type"
                                                                    value="{{ $procedural->procedural_type }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">الإجراء</label>
                                                                <input type="text" class="form-control" name="procedural"
                                                                    value="{{ $procedural->procedural }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">الجهة</label>
                                                                <input type="text" class="form-control" name="side"
                                                                    value="{{ $procedural->side }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">وقائع الإجراء</label>
                                                                <textarea class="form-control" name="procedural_facts" rows="3">{{ $procedural->procedural_facts }}</textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">الحالة</label>
                                                                <select class="form-select" name="status">
                                                                    <option value="0"
                                                                        {{ !$procedural->status ? 'selected' : '' }}>غير
                                                                        مكتمل
                                                                    </option>
                                                                    <option value="1"
                                                                        {{ $procedural->status ? 'selected' : '' }}>مكتمل
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">إلغاء</button>
                                                            <button type="submit" class="btn btn-primary">حفظ
                                                                التعديلات</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
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

    <!-- Modal للإضافة -->
    <div class="modal fade" id="addProceduralModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">إضافة إجراء جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('client.procedural.store', $client) }}" method="POST">
                    @csrf
                    <input type="hidden" name="client_id" value="{{ $client->id }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">نوع الإجراء</label>
                            <input type="text" class="form-control" name="procedural_type" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الإجراء</label>
                            <input type="text" class="form-control" name="procedural" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الجهة</label>
                            <input type="text" class="form-control" name="side" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">وقائع الإجراء</label>
                            <textarea class="form-control" name="procedural_facts" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الحالة</label>
                            <select class="form-select" name="status">
                                <option value="0">غير مكتمل</option>
                                <option value="1">مكتمل</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">إضافة الإجراء</button>
                    </div>
                </form>
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
@endsection
