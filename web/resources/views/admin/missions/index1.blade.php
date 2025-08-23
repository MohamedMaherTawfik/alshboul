@extends('layouts.admin')
@section('title', 'المهام المنجزه')
@section('main_title_content', 'قائمة المهام المنجزه')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('mission.unfinished') }}">المهام الغير المنجزه</a>
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-table me-1"></i>
            المهام المكتملة
        </div>
        <div class="card-body">
            @if ($missions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>الموكل</th>
                                <th>المحامي الأول</th>
                                <th>المحامي الثاني</th>
                                <th>الموعد النهائي</th>
                                <th>الوصف</th>
                                <th>الملف</th>
                                @if (Auth::user()->role == 'superadmin')
                                    <th>الإجراءات</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($missions as $mission)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $mission->client->name ?? 'غير محدد' }}</td>
                                    <td>{{ $mission->first_lawyer->name ?? 'غير محدد' }}</td>
                                    <td>{{ $mission->second_lawyer->name ?? 'غير محدد' }}</td>
                                    <td>{{ $mission->deadline ?? 'غير محدد' }}</td>
                                    <td>{{ Str::limit($mission->description, 50) ?? 'لا يوجد وصف' }}</td>
                                    <td>
                                        @if ($mission->file)
                                            <a href="{{ asset('storage/' . $mission->file) }}" class="btn btn-sm btn-info"
                                                target="_blank">
                                                <i class="fas fa-download"></i> تحميل
                                            </a>
                                        @else
                                            لا يوجد ملف
                                        @endif
                                    </td>
                                    @if (Auth::user()->role == 'superadmin')
                                        <td>
                                            <div class="btn-group" role="group">
                                                <form action="{{ route('mission.delete', $mission) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger mr-5"
                                                        onclick="return confirm('هل أنت متأكد أنك تريد حذف هذه المهمة؟');">
                                                        حذف المهمه
                                                    </button>
                                                </form>

                                            </div>
                                    @endif

                                    <!-- Modal -->
                                    <div class="modal fade" id="missionModal{{ $mission->id }}" tabindex="-1"
                                        aria-labelledby="missionModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title" id="missionModalLabel">تفاصيل المهمة</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p><strong>العميل:</strong>
                                                                {{ $mission->client->name ?? 'غير محدد' }}</p>
                                                            <p><strong>المحامي الأول:</strong>
                                                                {{ $mission->firstLawyer->name ?? 'غير محدد' }}</p>
                                                            <p><strong>المحامي الثاني:</strong>
                                                                {{ $mission->secondLawyer->name ?? 'غير محدد' }}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><strong>الموعد النهائي:</strong>
                                                                {{ $mission->deadline ?? 'غير محدد' }}</p>
                                                            <p><strong>الحالة:</strong> <span class="badge bg-warning">غير
                                                                    مكتملة</span></p>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3">
                                                        <strong>الوصف:</strong>
                                                        <p class="border p-3 rounded">
                                                            {{ $mission->description ?? 'لا يوجد وصف' }}</p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">إغلاق</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i> لا توجد مهام غير مكتملة لعرضها
                </div>
            @endif
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .table thead th {
            background-color: #2c3e50;
            color: white;
        }

        .btn-group .btn {
            margin: 0 2px;
        }

        .card-header {
            font-weight: bold;
            font-size: 1.1rem;
        }
    </style>
@endsection
