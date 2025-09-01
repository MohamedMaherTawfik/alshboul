@extends('layouts.admin')
@section('title', 'التسويات')
@section('main_title_content', 'قائمة التسويات')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('settlement.index', ['type' => request('type')]) }}">التسويات</a>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center">قائمة التسويات
                <br>
                <a href="{{ route('settlement.create', ['type' => request('type')]) }}" class="btn btn-success">إضافة جديد</a>
            </h3>
        </div>
        <div class="card-body">
            <div class="mb-3 row">

                <div class="col-md-3">
                    <input type="text" name="office_file_number" class="form-control" placeholder="رقم الملف">
                </div>
                <div class="col-md-3">
                    <input type="text" name="subscriber_name" class="form-control" placeholder="بحث اسم المشترك">
                </div>
                <div class="col-md-3">
                    <input type="text" name="client_id" class="form-control" placeholder="بحث اسم الموكل">
                </div>
                <div class="col-md-3">
                    <input type="text" name="opponent_name" class="form-control" placeholder="بحث اسم الخصم">
                </div>

            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>اسم المدخل</th>
                            <th>اسم الموكل</th>
                            <th>اسم الخصم</th>
                            <th>رقم الوطني للموكل</th>
                            <th>رقم الوطني للخصم</th>
                            <th>رقم هاتف الخصم</th>
                            <th>العنوان</th>
                            <th>صفة الموكل</th>
                            <th>صفة الخصم</th>
                            <th>رقم الملف</th>
                            <th>رقم الدعوى</th>
                            <th>قيمة الدين</th>
                            <th>نوع القسط</th>
                            <th>قيمة القسط</th>
                            <th>تفاصيل التسوية</th>
                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                <th>الاجراءات</th>
                            @endif

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($settlements as $settlement)
                            <tr>
                                <td>{{ $settlement->user->name ?? 'غير متوفر' }}</td>
                                <td>{{ $settlement->client_name ?? 'غير متوفر' }}</td>
                                <td>{{ $settlement->opponent_name ?? 'غير متوفر' }}</td>
                                <td>{{ $settlement->excutiveCases?->client_national_id ?? 'غير مرتبط بقضيه' }}</td>
                                <td>{{ $settlement->excutiveCases?->opponent_national_id ?? 'غير مرتبط بقضيه' }}</td>
                                <td>{{ $settlement->opponent_phone ?? 'غير متوفر' }}</td>
                                <td>{{ $settlement->opponent_address ?? 'غير متوفر' }}</td>
                                <td>{{ $settlement->client_status ?? 'غير متوفر' }}</td>
                                <td>{{ $settlement->opponent_status ?? 'غير متوفر' }}</td>
                                <td>{{ $settlement->excutiveCases?->file_number ?? 'غير مرتبط بقضيه' }}</td>
                                <td>{{ $settlement->excutiveCases?->case_number ?? 'غير مرتبط بقضيه' }}</td>
                                <td>{{ $settlement->amount }}</td>
                                <td>{{ $settlement->payment_terms ?? 'غير متوفر' }}</td>
                                <td>{{ $settlement->payment_value ? number_format($settlement->payment_value, 2) : 'غير متوفر' }}
                                </td>
                                <td>{{ $settlement->notes ?? 'لا توجد ملاحظات' }}</td>

                                <td>
                                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                        <div class="d-flex flex-wrap gap-2 mb-2">
                                            <a href="{{ route('executive-case.settlement.edit', $settlement) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> تعديل
                                            </a>

                                            <form action="{{ route('executive-case.settlement.delete', $settlement) }}"
                                                method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> حذف
                                                </button>
                                            </form>

                                            <a href="{{ route('settlements.procedure', $settlement) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-cogs"></i> إجراء
                                            </a>
                                        </div>
                                    @endif

                                    <div>
                                        <button
                                            class="btn btn-sm {{ $settlement->obligation === 'ملتزم' ? 'btn-success' : 'btn-danger' }}">
                                            {{ $settlement->obligation ?? 'غير محدد' }}
                                        </button>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="18" class="text-center">لا توجد تسويات لعرضها.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection
