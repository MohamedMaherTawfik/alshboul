@extends('layouts.admin')
@section('title', 'الإجراءات')
@section('main_title_content', 'قائمة الإجراءات')
@section('title_content', 'عرض')

@section('content')
    <div class="container-fluid">
        <!-- قسم الإجراءات -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow border-0">
                    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-tasks me-2"></i>الإجراءات
                        </h5>
                        <div class="d-flex gap-2">
                            <!-- زرار إضافة إجراء فرعي -->
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addSubProceduralModal">
                                <i class="fas fa-plus me-1"></i> إضافة إجراء فرعي
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- جدول الإجراءات الرئيسية -->
                        <div class="table-responsive mb-4">
                            <table class="table table-hover" id="proceduralTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">اسم المدخل</th>
                                        <th class="text-center">تاريخ الإدخال</th>
                                        <th class="text-center">الإجراء الرئيسي</th>
                                        <th class="text-center">الجهة</th>
                                        <th class="text-center">الحالة</th>
                                        <th class="text-center">الموكل</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">{{ $client->user->name }}</td>
                                        <td class="text-center">{{ $client->created_at->format('Y-m-d H:i') }}</td>
                                        <td class="text-center">{{ $client->procedural }}</td>
                                        <td class="text-center">{{ $client->side }}</td>
                                        <td class="text-center">
                                            <span class="badge p-2 {{ $client->status ? 'bg-success' : 'bg-warning' }}">
                                                {{ $client->status ? 'مكتمل' : 'غير مكتمل' }}
                                            </span>
                                        </td>
                                        <td class="text-center">{{ $client->client->name ?? 'غير محدد' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- جدول الإجراءات الفرعية -->
                        <h5 class="mt-4 mb-3"> الإجراءات الفرعية</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">الرقم</th>
                                        <th class="text-center">المدخل</th>
                                        <th class="text-center">المحامي</th>
                                        <th class="text-center">الإجراء الرئيسي</th>
                                        <th class="text-center">الإجراء القادم</th>
                                        <th class="text-center"> تاريخ الإجراء القادم</th>
                                        <th class="text-center">الجهة</th>
                                        <th class="text-center">ملاحظات</th>
                                        <th class="text-center">تاريخ الإدخال</th>
                                        <th class="text-center">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($client->subProcedurals->sortBy('created_at') as $sub)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration ?? 'غير محدد' }}</td>
                                            <td class="text-center">{{ $sub->user->name ?? 'غير محدد' }}</td>
                                            <td class="text-center">{{ $sub->lawyer->name ?? 'غير محدد' }}</td>
                                            <td class="text-center">{{ $sub->action ?? 'غير محدد' }}</td>
                                            <td class="text-center">{{ $sub->next_action ?? 'غير محدد' }}</td>
                                            <td class="text-center">{{ $sub->next_action_date ?? 'غير محدد' }}</td>
                                            <td class="text-center">{{ $client->side ?? 'غير محدد' }}</td>
                                            <td class="text-center"
                                                style="white-space: pre-wrap; word-wrap: break-word; max-width: 400px;">
                                                {{ $sub->note }}
                                            </td>
                                            <td class="text-center">{{ $sub->created_at->format('Y-m-d H:i') }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#editSubProceduralModal{{ $sub->id }}">
                                                    تعديل
                                                </button>

                                                <form action="{{ route('subprocedural.delete', $sub->id) }}" method="POST"
                                                    style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- مودال تعديل الإجراء الفرعي -->
                                        <div class="modal fade" id="editSubProceduralModal{{ $sub->id }}"
                                            tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('subprocedural.update', $sub->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title">تعديل الإجراء الفرعي</h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal" aria-label="إغلاق"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <input type="hidden" name="client_procedural_id"
                                                                value="{{ $client->id }}">

                                                            <div class="mb-3">
                                                                <label class="form-label">تاريخ الإدخال</label>
                                                                <input type="datetime-local" class="form-control"
                                                                    name="created_at"
                                                                    value="{{ $sub->created_at->format('Y-m-d\TH:i') }}">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">الإجراء الرئيسي</label>
                                                                <input type="text" class="form-control" name="action"
                                                                    value="{{ $sub->action }}" required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">الجهة</label>
                                                                <input type="text" class="form-control" name="to"
                                                                    value="{{ $sub->to }}" required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">المحامي</label>
                                                                <select name="lawyer_id" class="form-select" required>
                                                                    <option value="">اختر المحامي</option>
                                                                    @foreach ($user as $item)
                                                                        <option value="{{ $item->id }}"
                                                                            {{ $sub->lawyer_id == $item->id ? 'selected' : '' }}>
                                                                            {{ $item->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">ملاحظات</label>
                                                                <textarea class="form-control" name="note" rows="3">{{ $sub->note }}</textarea>
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
                                            <td colspan="10" class="text-center text-muted py-3">
                                                لا توجد إجراءات فرعية مسجلة
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

    <!-- مودال إضافة إجراء فرعي -->
    <div class="modal fade" id="addSubProceduralModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('subprocedural.store', $client) }}" method="POST">
                    @csrf
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">إضافة إجراء فرعي</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="client_procedural_id" value="{{ $client->id }}">

                        <div class="mb-3">
                            <label class="form-label">تاريخ الإدخال</label>
                            <input type="date" class="form-control" name="created_at"
                                value="{{ now()->format('Y-m-d') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">الإجراء الرئيسي</label>
                            <input type="text" class="form-control" name="action" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">الإجراء القادم</label>
                            <input type="text" class="form-control" name="next_action" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"> تاريخ الإجراء القادم </label>
                            <input type="date" class="form-control" name="next_action_date" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">المحامي</label>
                            <select name="lawyer_id" class="form-select" required>
                                <option value="">اختر المحامي</option>
                                @foreach ($user as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">ملاحظات</label>
                            <textarea class="form-control" name="note" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-warning">حفظ الإجراء الفرعي</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
