@extends('layouts.admin')

@section('title', 'تفاصيل السجل الإجرائي')
@section('main_title_content', 'تفاصيل السجل الإجرائي')
@section('title_content', 'عرض')

@section('content')
    <div class="card shadow-lg border-0">
        <div class="card-header bg-dark text-white text-center fw-bold" style="font-size: 1.3rem;">
            بيانات القضية
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover mb-0 text-center align-middle"
                    style="font-size: 1.1rem; direction: rtl;">
                    <thead class="table-dark text-white">
                        <tr>
                            <th>اسم المشترك</th>
                            <th>اسم الموكل</th>
                            <th>الرقم الوطني</th>
                            <th>اسم الخصم</th>
                            <th>الرقم الوطني للخصم</th>
                            <th>رقم الدعوى</th>
                            <th>قيمة الدعوى</th>
                            <th>رقم الملف</th>
                            <th>المحكمة</th>
                            <th>اسم القاضي</th>
                            <th>تاريخ الجلسة القادمة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $lastSession = $case->courtSession->first();
                            $hoursLeft = null;
                            if ($lastSession && !empty($lastSession->date)) {
                                $hoursLeft = \Carbon\Carbon::now()->diffInHours(
                                    \Carbon\Carbon::parse($lastSession->date),
                                    false,
                                );
                            }
                        @endphp
                        <tr>
                            <td>{{ $case->subscriber->name ?? '-' }}</td>
                            <td>{{ $case->client->name ?? '-' }}</td>
                            <td>{{ $case->first_national_id ?? '-' }}</td>
                            <td>
                                @forelse ($case->caseOpponents as $item)
                                    {{ $item->case_opponent_name ?? '-' }} <br>
                                @empty
                                    -
                                @endforelse
                            </td>
                            <td>
                                @forelse ($case->caseOpponents as $item)
                                    {{ $item->case_opponent_national_number ?? '-' }} <br>
                                @empty
                                    -
                                @endforelse
                            </td>
                            <td>{{ $case->file_number ?? '-' }}</td>
                            <td>{{ $case->case_amount ?? '-' }}</td>
                            <td>{{ $case->case_number ?? '-' }}</td>
                            <td>{{ $case->court_name ?? '-' }}</td>
                            <td>{{ $case->jubge_name ?? '-' }}</td>
                            <td>
                                {{ $case->courtSession->last()->date ?? 'لا يوجد جلسات' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- إضافة جلسة أو إجراء + فلترة -->
    <div class="d-flex justify-content-between mb-3">
        @if (!$settlements || $settlements->obligation == 'غير ملتزم')
            <a href="{{ route('cases.add', $case) }}" class="btn btn-dark btn-sm px-3 text-white d-flex align-items-center">
                <i class="bi bi-plus-circle me-1"></i> إضافة جلسة او اجراء
            </a>
        @endif

        <!-- فلترة -->
        <div class="d-flex gap-2 mr-2">
            <select id="filterType" class="form-select form-select-sm" style="width:auto;"
                onchange="filterSessions(this.value)">
                <option value="all">عرض الكل</option>
                <option value="session">الجلسات فقط</option>
                <option value="procedure">الإجراءات فقط</option>
            </select>
        </div>
    </div>

    <!-- جدول الجلسات والإجراءات -->
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-striped text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>رقم الاجراء</th>
                        <th>اسم المدخل</th>
                        <th>المحامي</th>
                        <th>تاريخ الإدخال</th>
                        <th>الوقائع</th>
                        <th>ملاحظات</th>
                        <th>تاريخ الجلسه</th>
                        <th>تاريخ الجلسة / الإجراء القادمة</th>
                        <th>الملفات</th>
                        <th>النوع</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody id="sessionsTable">
                    @forelse ($case->proceduralRedords->sortByDesc('created_at') as $record)
                        @php
                            $type = $record->date ? 'جلسة' : 'إجراء';
                        @endphp
                        <tr data-type="{{ $type === 'جلسة' ? 'session' : 'procedure' }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $record->userLawyer->name ?? '-' }}</td>
                            <td>{{ $record->user->name ?? '-' }}</td>
                            <td>{{ $record->created_at ? $record->created_at->format('d/m/Y H:i') : '-' }}</td>
                            <td>{{ $record->action ?? '-' }}</td>
                            <td>{{ $record->note ?? '-' }}</td>
                            <td>{{ $record->date ?? '-' }}</td>
                            <td>{{ $record->next_action ?? '-' }} -- {{ $record->next_action_date }}</td>
                            <td>
                                <a href="{{ route('proceduralfiles.index', $record) }}">
                                    (عدد المستندات : <span class="text-success fs-5">{{ count($record->files) }}</span>)
                                </a>

                            </td>
                            <td>{{ $type }}</td>
                            <td>
                                @if ($record->date)
                                    <a href="{{ route('cases.procedure.edit', $record) }}"
                                        class="btn btn-sm btn-warning">تعديل
                                        الجلسة</a>
                                @else
                                    <a href="{{ route('cases.procedure.edit', $record) }}"
                                        class="btn btn-sm btn-warning">تعديل الإجراء</a>
                                @endif

                                <form
                                    action="{{ $record->type === 'جلسة' ? route('cases.procedure.delete', $record) : route('cases.procedure.delete', $record) }}"
                                    method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                                </form>
                            </td>
                        </tr>


                    @empty
                        <tr>
                            <td colspan="9" class="text-center">لا توجد بيانات</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
