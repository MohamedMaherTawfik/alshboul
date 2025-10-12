@extends('layouts.admin')

@section('title', 'الاجراءات التابعة ل ' . $nav->name)
@section('main_title_content', 'الاجراءات التابعة ل' . $nav->name)
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('subNav.index', $nav) }}">{{ $nav->name }}</a>
@endsection

@section('content')
    <div class="col-12 mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">الإجراءات التابعة لـ {{ $nav->name }}</h3>
                <a href="{{ route('subNav.create', $nav) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> إضافة إجراء
                </a>
            </div>

            <div class="card-body">
                @if ($nav->proceduralRecords->isEmpty())
                    <p class="text-center text-muted">لا توجد إجراءات مضافة بعد.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>اسم المدخل</th>
                                    <th>الإجراء</th>
                                    <th>الملاحظات</th>
                                    <th>الإجراء القادم</th>
                                    <th>تاريخ الإجراء القادم</th>
                                    <th>المحامي</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($nav->proceduralRecords as $index => $record)
                                    <tr>
                                        <td>{{ $record->user->name }}</td>
                                        <td>{{ $record->action }}</td>
                                        <td>{{ $record->note ?? '-' }}</td>
                                        <td>{{ $record->next_action ?? '-' }}</td>
                                        <td>
                                            {{ $record->next_action_date ? $record->next_action_date : '-' }}
                                        </td>
                                        <td>{{ $record->userLawyer?->name ?? 'غير محدد' }}</td>
                                        <td class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('subNav.edit', $record->id) }}"
                                                class="btn btn-sm btn-warning ml-2">
                                                <i class="fas fa-edit"></i> تعديل
                                            </a>

                                            <form action="{{ route('subNav.delete', $record->id) }}" method="POST"
                                                onsubmit="return confirm('هل أنت متأكد من حذف هذا الإجراء؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash-alt"></i> حذف
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
