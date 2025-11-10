@extends('layouts.admin')
@section('title', 'التسويات')
@section('main_title_content', 'قائمة التسويات')
@section('title_content', 'عرض')
{{-- @section('link_content')
    <a href="{{ route('settlement.index', $settlements) }}">التسويات</a>
@endsection --}}
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center fs-2 fw-bold" style="font-size: 30px;font-weight: bold;">
                جميع التسويات :
                {{ count($settlements) }}
                <br>
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
                            <th>اسم المشترك</th>
                            <th>رقم الوطني للموكل</th>
                            <th>اسم الخصم</th>
                            <th>رقم الوطني للخصم</th>
                            <th>رقم الملف</th>
                            <th>تفاصيل التسوية</th>
                            <th>قيمة الدين</th>
                            <th>قيمة القسط</th>
                            <th>نوع القسط</th>
                            <th>الاجراءات</th>
                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                <th>التحكم</th>
                            @endif

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($settlements->sortBy('file_number') as $settlemen)
                            <tr>
                                <td>{{ $settlemen->user->name ?? 'غير متوفر' }}</td>
                                <td>{{ $settlemen->client_name ?? 'غير متوفر' }}</td>
                                <td>{{ $settlemen->client_national_id ?? 'غير متوفر' }}</td>
                                <td>{{ $settlemen->opponent_name ?? 'غير مرتبط بقضيه' }}</td>
                                <td>{{ $settlemen->opponent_national_id ?? 'غير مرتبط بقضيه' }}</td>
                                <td>{{ $settlemen->file_number ?? 'غير مرتبط بقضيه' }}</td>
                                <td>{{ $settlemen->partner_name ?? 'لا توجد ملاحظات' }}</td>
                                <td>{{ $settlemen->amount ?? 'غير متوفر' }}</td>
                                <td>{{ $settlemen->payment_value ?? 'غير متوفر' }}
                                <td>{{ $settlemen->payment_terms ?? 'غير متوفر' }}
                                    @if ($settlemen->payment_terms == 'شهري')
                                        - يوم {{ $settlemen->day }}
                                    @else
                                        - {{ $settlemen->week_1 }} -{{ $settlemen->week_2 }} -
                                        {{ $settlemen->week_3 }} - {{ $settlemen->week_4 }}
                                    @endif
                                </td>
                                <td>
                                    @if ($settlemen->obligation == 'غير ملتزم')
                                        <a href="{{ route('settlements.procedure', $settlemen) }}">
                                            تم اتخاذ اجراء قضائي لعدم الالتزام
                                        </a>
                                    @else
                                        <a href="{{ route('settlements.procedure', $settlemen) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="fas fa-cogs"></i> إجراء
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                        <div class="d-flex flex-wrap gap-2 mb-2">
                                            <a href="{{ route('executive-case.settlement.edit', $settlemen) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> تعديل
                                            </a>

                                            <form action="{{ route('executive-case.settlement.delete', $settlemen) }}"
                                                method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> حذف
                                                </button>
                                            </form>
                                        </div>
                                    @endif

                                    <div>
                                        <button
                                            class="btn btn-sm {{ $settlemen->obligation == 'ملتزم' ? 'btn-success' : 'btn-danger' }}">
                                            {{ $settlemen->obligation ?? 'غير محدد' }}
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
