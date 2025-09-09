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
                                <th>اسم المدخل </th>
                                <th>رقم الملف</th>
                                <th> اسم الدائره المختصه</th>
                                <th>نوع المعامله</th>
                                <th>اسم المشترك</th>
                                <th>اسم الموكل</th>
                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                    <th>اجراءات</th>
                                @endif
                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                    <th>التحكم</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaction->transactions as $index => $item)
                                <tr>
                                    <td>{{ $item->user?->name ?? '-' }}</td>
                                    <td>{{ $item->file_number ?? '-' }}</td>
                                    <td>{{ $item->area_name ?? '-' }}</td>

                                    <td>{{ $transaction->name ?? '-' }}</td>
                                    <td>{{ $item->client?->name ?? '-' }}</td>
                                    <td>{{ $item->client_name ?? '-' }}</td>
                                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                        <td>
                                            <a href="{{ route('transactions.procedural.create', $item) }}"
                                                class="btn btn-info px-4 py-2 text-lg" style="min-width: 120px;">
                                                اجراءات
                                            </a>
                                        </td>
                                    @endif

                                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                        <td class="d-flex">
                                            {{-- Edit --}}
                                            <a href="{{ route('transactions.edit', $item) }}" class="btn btn-warning me-2"
                                                style="min-width: 100px; padding: 8px 16px;">
                                                تعديل
                                            </a>

                                            {{-- Delete --}}
                                            <form action="{{ route('transactions.destroy', $item) }}" method="POST"
                                                onsubmit="return confirm('هل أنت متأكد من الحذف؟');" class="mr-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    style="min-width: 100px; padding: 8px 16px;">
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
