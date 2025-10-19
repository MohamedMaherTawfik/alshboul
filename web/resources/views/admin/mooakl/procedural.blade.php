@extends('layouts.admin')
@section('title', 'الاجرائات')
@section('main_title_content', 'قائمة الاجرائات')
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
                                        <th class="text-center">تاريخ الادخال</th>
                                        <th class="text-center">الإجراء الرئيسي</th>
                                        <th class="text-center">الجهة</th>
                                        <th class="text-center">وقائع الإجراء</th>
                                        <th class="text-center">الحالة</th>
                                        <th class="text-center">الموكل</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">{{ $client->user->name }}</td>
                                        <td class="text-center">{{ $client->created_at->format('Y-m-d') }}</td>
                                        <td class="text-center procedural-col">{{ $client->procedural }}</td>
                                        <td class="text-center">{{ $client->side }}</td>
                                        <td class="facts-col"
                                            style="white-space: pre-wrap; word-wrap: break-word; max-width: 400px;">
                                            {{ $client->procedural_facts }}
                                        </td>
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
                        <h5 class="mt-4 mb-3"><i class="fas fa-code-branch me-2"></i> الإجراءات الفرعية</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">المدخل</th>
                                        <th class="text-center">الإجراء</th>
                                        <th class="text-center">ملاحظات</th>
                                        <th class="text-center">المستندات</th>
                                        <th class="text-center">تاريخ الإدخال</th>
                                        <th class="text-center">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($client->subProcedurals as $sub)
                                        <tr>
                                            <td class="text-center">{{ $sub->user->name }}</td>
                                            <td class="text-center">{{ $sub->action }}</td>
                                            <td class="text-center"
                                                style="white-space: pre-wrap; word-wrap: break-word; max-width: 400px;">
                                                {{ $sub->note }}
                                            </td>
                                            <td class="text-center">
                                                @foreach ($sub->files as $item)
                                                    <a href="{{ asset('storage/' . $item->file) }}"
                                                        class="btn btn-sm btn-outline-primary" target="_blank">
                                                        <i class="fas fa-file"></i>
                                                    </a>
                                                @endforeach
                                                <!-- زرار فتح المودال -->
                                                <button type="button" class="btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#addFileModal{{ $sub->id }}">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                                <!-- المودال -->
                                                <div class="modal fade" id="addFileModal{{ $sub->id }}" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-md">
                                                        <div class="modal-content">
                                                            <form method="POST"
                                                                action="{{ route('Client.procedural.add.file', $sub) }}"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="modal-header bg-primary text-white">
                                                                    <h5 class="modal-title">رفع مستندات</h5>
                                                                    <button type="button" class="btn-close btn-close-white"
                                                                        data-bs-dismiss="modal" aria-label="إغلاق"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12 mb-3">
                                                                            <label for="file_path"
                                                                                class="form-label">المستندات</label>
                                                                            <input type="file" name="file_path[]"
                                                                                id="file_path" class="form-control" multiple
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">إلغاء</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">رفع</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">{{ $sub->created_at->format('Y-m-d H:i') }}</td>
                                            <td class="text-center">
                                                <!-- زر التعديل -->
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#editSubProceduralModal{{ $sub->id }}">
                                                    تعديل
                                                </button>

                                                <!-- زر الحذف -->
                                                <form action="{{ route('subprocedural.delete', $sub->id) }}" method="POST"
                                                    style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                                                </form>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="editSubProceduralModal{{ $sub->id }}"
                                            tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <!-- خليتها lg عشان تاخد مساحة للمستندات -->
                                                <div class="modal-content">
                                                    <!-- تعديل الإجراء -->
                                                    <form action="{{ route('subprocedural.update', $sub->id) }}"
                                                        method="POST">
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
                                                                <label class="form-label">الإجراء</label>
                                                                <input type="text" class="form-control" name="action"
                                                                    value="{{ $sub->action }}" required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">ملاحظات</label>
                                                                <textarea class="form-control" name="note" rows="3">{{ $sub->note }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer d-flex justify-content-between">
                                                            <!-- حفظ التعديلات -->
                                                            <div>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">إلغاء</button>
                                                                <button type="submit" class="btn btn-primary">حفظ
                                                                    التعديلات</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <!-- المستندات -->
                                                    <hr>
                                                    <h6 class="mb-2 mr-2">المستندات</h6>
                                                    <div class="mb-3 mr-2">
                                                        @foreach ($sub->files as $item)
                                                            <div class="d-flex align-items-center mb-2">
                                                                <a href="{{ asset('storage/' . $item->file) }}"
                                                                    class="btn btn-sm btn-outline-primary me-2"
                                                                    target="_blank">
                                                                    <i class="fas fa-file"></i>
                                                                </a>
                                                                <!-- زر الحذف للمستند -->
                                                                <form
                                                                    action="{{ route('Client.procedural.delete.file', $item->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('هل أنت متأكد من حذف هذا المستند؟')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-danger mr-2">حذف</button>
                                                                </form>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-3">
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

    <!-- Modal: إضافة إجراء فرعي -->
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
                        <!-- hidden procedural_record_id -->
                        <input type="hidden" name="client_procedural_id" value="{{ $client->id }}">

                        <div class="mb-3">
                            <label class="form-label">تاريخ الادخال</label>
                            <input type="date" class="form-control" name="created_at"
                                value="{{ now()->format('Y-m-d') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">الإجراء</label>
                            <input type="text" class="form-control" name="action" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">المحامي</label>
                            <select name="lawyer_id" id="">
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
