@extends('layouts.admin')
@section('title', 'التسويات')
@section('main_title_content', 'قائمة التسويات')
@section('title_content', 'عرض')

@section('content')
    <div class="card mb-4">
        <div class="card-body">
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
                                <span class="badge {{ $settlement->obligation === 'ملتزم' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $settlement->obligation ?? 'غير محدد' }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- زرار إنشاء إجراء --}}
    <div class="d-flex justify-content-end mb-3">
        @if ($settlement->obligation == 'ملتزم')
            <a href="{{ route('settlements.procedure.create', $settlement) }}" class="btn btn-primary">
                + انشاء اجراء
            </a>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive shadow-sm rounded">
                <table class="table table-bordered table-hover align-middle table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>اسم المدخل</th>
                            <th>المحامي</th>
                            <th>تاريخ الإدخال</th>
                            <th>وقائع الاجراء</th>
                            <th>مستندات</th>
                            <th>ملاحظات</th>
                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'doctor')
                                <th>الاجراءات</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($settlement->proceduralRedords->sortByDesc('created_at') as $duration)
                            <tr>
                                <td>{{ $duration->userLawyer->name ?? '-' }}</td>
                                <td>{{ $duration->user->name ?? '-' }}</td>
                                <td>{{ $duration->created_at?->format('Y-m-d H:i') ?? '-' }}</td>
                                <td>{{ $duration->action ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('proceduralfiles.index', $duration) }}">
                                        (عدد المستندات : <span
                                            class="text-success fs-5">{{ count($duration->files) }}</span>)
                                    </a>
                                </td>
                                <td>{{ $duration->note ?? ' لا يوجد ملاحظات' }}</td>

                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'doctor')
                                    <td>
                                        <a href="{{ route('settlement.procedural.edit', $duration) }}"
                                            class="btn btn-sm btn-warning">تعديل</a>
                                        @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'doctor')
                                            <form action="{{ route('settlement.procedural.destroy', $duration) }}"
                                                method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟');"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                            </form>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="text-center">لا توجد اجرائات مسجلة</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
