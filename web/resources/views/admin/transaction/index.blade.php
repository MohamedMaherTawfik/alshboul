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
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title card_title_center">
                    المعاملة الرئيسية: {{ $transaction->name ?? '-' }}
                </h3>
                <a href="{{ route('transactions.create', $transaction->id) }}" class="btn btn-success btn-sm">
                    إضافة جديد
                </a>
            </div>


            <div class="card-body overflow-auto">
                @if ($transaction->transactions && $transaction->transactions->count() > 0)
                    <table class="table table-bordered table-hover text-center align-middle">
                        <thead class="custom_thead">
                            <tr>
                                <th>#</th>
                                <th>المستخدم (Created By)</th>
                                <th>العميل</th>
                                <th>رقم الملف</th>
                                <th>الحالة</th>
                                <th>الاسم</th>
                                <th>الوصف</th>
                                <th>المنطقة</th>
                                <th>ملاحظات</th>
                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                    <th>الاجراءات</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaction->transactions as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->user?->name ?? '-' }}</td>
                                    <td>{{ $item->client?->name ?? '-' }}</td>
                                    <td>{{ $item->file_number ?? '-' }}</td>
                                    <td>
                                        @if ($item->is_active)
                                            <span class="badge bg-success">نشط</span>
                                        @else
                                            <span class="badge bg-danger">غير نشط</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->client_name ?? '-' }}</td>
                                    <td>{{ $item->description ?? '-' }}</td>
                                    <td>{{ $item->area_name ?? '-' }}</td>
                                    <td>{{ $item->notes ?? '-' }}</td>
                                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                        <td class="d-flex">
                                            {{-- Edit --}}
                                            <a href="{{ route('transactions.edit', $item) }}"
                                                class="btn btn-sm btn-warning me-2">
                                                تعديل
                                            </a>

                                            {{-- Delete --}}
                                            <form action="{{ route('transactions.destroy', $item) }}" method="POST"
                                                onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    حذف
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center alert alert-info">
                        لا توجد معاملات مرتبطة بالمعاملة الرئيسية.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
