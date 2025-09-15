@extends('layouts.admin')

@section('title', 'المعاملات')
@section('main_title_content', 'قائمة المعاملات')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('transactions.all', $transaction) }}">المعاملات</a>
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="text-center text-2xl font-bold" style="font-weight: bold; font-size: 30px;">
                معامله رقم {{ $transaction->file_number }}
            </div>

            <div class="card-body overflow-auto">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="custom_thead">
                        <tr>
                            <th>المستخدم (Created By)</th>
                            <th>العميل</th>
                            <th>رقم الملف</th>
                            <th>الحالة</th>
                            <th>الاسم</th>
                            <th>الوصف</th>
                            <th>المنطقة</th>
                            <th>ملاحظات</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>{{ $transaction->user?->name ?? '-' }}</td>
                            <td>{{ $transaction->client?->name ?? '-' }}</td>
                            <td>{{ $transaction->file_number ?? '-' }}</td>
                            <td>
                                @if ($transaction->is_active)
                                    <span class="badge bg-success">نشط</span>
                                @else
                                    <span class="badge bg-danger">غير نشط</span>
                                @endif
                            </td>
                            <td>{{ $transaction->client_name ?? '-' }}</td>
                            <td>{{ $transaction->description ?? '-' }}</td>
                            <td>{{ $transaction->area_name ?? '-' }}</td>
                            <td>{{ $transaction->notes ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">الإجراءات</h5>
                <!-- زرار يفتح المودال -->
                <a href="{{ route('transactions.procedural.create.new', $transaction) }}"
                    class="btn btn-success btn-sm">اضافة اجراء</a>
            </div>

            <div class="card-body overflow-auto">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="custom_thead">
                        <tr>
                            <th>اسم المدخل</th>
                            <th>الإجراء</th>
                            <th>الملاحظات</th>
                            <th>المستندات</th>
                            <th>المحامي المسئول</th>
                            <th>تاريخ الإدخال</th>
                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                <th>التحكم</th>
                            @endif

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaction->procedural->sortByDesc('id') as $procedural)
                            <tr>
                                <td>{{ $procedural->user?->name ?? '-' }}</td>
                                <td>{{ $procedural->action ?? '-' }}</td>
                                <td>{{ $procedural->note ?? '-' }}</td>
                                <td>
                                    @foreach ($procedural->files as $item)
                                        <a href="{{ asset('storage/' . $item->file_path) }}" class="mr-2"
                                            target="_blank">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    @endforeach
                                    <!-- زر فتح المودال -->
                                    <button type="button"
                                        class="btn btn-dark btn-sm rounded-circle d-inline-flex align-items-center justify-content-center"
                                        data-bs-toggle="modal" data-bs-target="#uploadFileModal{{ $procedural->id }}">
                                        <i class="fa fa-plus"></i>
                                    </button>

                                    <!-- مودال رفع الملفات -->
                                    <div class="modal fade" id="uploadFileModal{{ $procedural->id }}" tabindex="-1"
                                        aria-labelledby="uploadFileModalLabel{{ $procedural->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('transactions.procedural.create.file', $procedural) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="uploadFileModalLabel{{ $procedural->id }}">رفع ملفات جديدة
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="إغلاق"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">الملفات</label>
                                                            <input type="file" name="files[]" class="form-control"
                                                                multiple required>
                                                            <small class="text-muted">يمكنك اختيار أكثر من ملف</small>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">إلغاء</button>
                                                        <button type="submit" class="btn btn-success">رفع</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </td>
                                <td>{{ $procedural->userLawyer?->name ?? '-' }}</td>
                                <td>{{ $procedural->created_at->format('Y-m-d') }}</td>
                                <td>
                                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                        <a href="{{ route('transactions.procedural.edit', $procedural->id) }}"
                                            class="btn btn-warning">
                                            تعديل</a>
                                        <form action="{{ route('transactions.procedural.destroy', $procedural->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                                حذف
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted">لا يوجد إجراءات بعد</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>



@endsection
