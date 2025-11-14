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
                            <th>المستخدم</th>
                            <th>المشترك</th>
                            <th>رقم الملف</th>
                            <th>الحالة</th>
                            <th>الموكل</th>
                            <th>الوصف</th>
                            <th>الدائره المختصه</th>
                            <th>ملاحظات</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>{{ $transaction->user?->name ?? '-' }}</td>
                            <td>{{ $transaction->subscriber?->name ?? '-' }}</td>
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
                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'doctor')
                                <th>التحكم</th>
                            @endif

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaction->procedural->sortByDesc('created_at') as $procedural)
                            <tr>
                                <td>{{ $procedural->user?->name ?? '-' }}</td>
                                <td>{{ $procedural->action ?? '-' }}</td>
                                <td>{{ $procedural->note ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('proceduralfiles.index', $procedural) }}">
                                        (عدد المستندات : <span
                                            class="text-success fs-5">{{ count($procedural->files) }}</span>)
                                    </a>
                                </td>
                                <td>{{ $procedural->userLawyer?->name ?? '-' }}</td>
                                <td>{{ $procedural->created_at->format('Y-m-d h:i') }}</td>
                                <td>
                                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'doctor')
                                        <a href="{{ route('transactions.procedural.edit', $procedural->id) }}"
                                            class="btn btn-warning">
                                            تعديل</a>
                                        @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'doctor')
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
