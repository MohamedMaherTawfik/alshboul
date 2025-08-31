@extends('layouts.admin')
@section('title', 'المهام الغير المنجزه')
@section('main_title_content', 'قائمة المهام الغير المنجزه')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('mission.finished') }}">المهام المنجزه</a>
@endsection

@section('content')
    <div class="card mb-4">
        <div class="bg-red-100 border border-red-400
        card-header bg-dark text-red-700 px-4 py-3 rounded-lg mb-4">
            <i class="fas fa-table me-1"></i>
            عدد المهام غير المنجزه: <span class="font-bold">{{ $missions->count() }}</span>
        </div>

        {{-- خانات البحث --}}
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <input type="text" id="searchClient" class="form-control" placeholder="بحث باسم الموكل">
            </div>
            <div class="col-md-4">
                <input type="text" id="searchFirstLawyer" class="form-control" placeholder="بحث باسم المحامي الأول">
            </div>
            <div class="col-md-4">
                <input type="text" id="searchSecondLawyer" class="form-control" placeholder="بحث باسم المحامي الثاني">
            </div>
        </div>


        <div class="card-body">
            @if ($missions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>مضاف بواسطه</th>
                                <th>الموكل</th>
                                <th>المحامي الأول</th>
                                <th>المحامي الثاني</th>
                                <th>الموعد النهائي</th>
                                <th>الوصف</th>
                                <th>الملف</th>
                                <th>المنجز الأول</th>
                                <th>المنجز الثاني</th>
                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                    <th colspan="2">الإجراءات</th>
                                @endif

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($missions as $mission)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $mission->added_by?->name }}</td>
                                    <td>{{ $mission->client->name ?? 'غير محدد' }}</td>
                                    <td>{{ $mission->first_lawyer->name ?? 'غير محدد' }}</td>
                                    <td>{{ $mission->second_lawyer->name ?? 'غير محدد' }}</td>
                                    @php
                                        $deadline = strtotime($mission->deadline);
                                        $diffInHours = ($deadline - time()) / 3600;
                                    @endphp

                                    <td
                                        @if ($diffInHours <= 48 && $diffInHours >= 0) style="background-color: #DB0113FF; color: #D6CACBFF; font-weight: bold;" @endif>
                                        {{ $mission->deadline ? date('Y-m-d', $deadline) : 'غير محدد' }}
                                    </td>


                                    <td>{{ $mission->description ?? 'غير محدد' }}</td>
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
                                    <td>{{ $mission->submitFinishedMissions->first()?->firstLawyer?->name ?? 'غير محدد' }}
                                    </td>

                                    <td>{{ $mission->submitFinishedMissions->first()?->secondLawyer?->name ?? 'غير محدد' }}
                                    </td>
                                    <td colspan="2">
                                        <div class="btn-group" role="group">
                                            <form action="{{ route('mission.unfinished.finished', $mission) }}"
                                                method="POST" class="d-inline">
                                                @csrf

                                                <button type="submit" class="btn btn-sm btn-success">
                                                    مهمه مكتمله
                                                </button>
                                            </form>

                                            @if (Auth::user()->role == 'superadmin')
                                                <form action="{{ route('mission.delete', $mission) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger mr-5"
                                                        onclick="return confirm('هل أنت متأكد أنك تريد حذف هذه المهمة؟');">
                                                        حذف المهمه
                                                    </button>
                                                </form>
                                            @endif

                                        </div>

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
                                                                <p><strong>الحالة:</strong> <span
                                                                        class="badge bg-warning">غير مكتملة</span></p>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchClient = document.getElementById('searchClient');
        const searchFirstLawyer = document.getElementById('searchFirstLawyer');
        const searchSecondLawyer = document.getElementById('searchSecondLawyer');
        const tableRows = document.querySelectorAll('table tbody tr');

        function filterTable() {
            const clientVal = searchClient.value.toLowerCase();
            const firstVal = searchFirstLawyer.value.toLowerCase();
            const secondVal = searchSecondLawyer.value.toLowerCase();

            tableRows.forEach(row => {
                const clientCell = row.cells[2]?.innerText.toLowerCase() || '';
                const firstCell = row.cells[3]?.innerText.toLowerCase() || '';
                const secondCell = row.cells[4]?.innerText.toLowerCase() || '';

                const matchesClient = clientCell.includes(clientVal);
                const matchesFirst = firstCell.includes(firstVal);
                const matchesSecond = secondCell.includes(secondVal);

                if (matchesClient && matchesFirst && matchesSecond) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        [searchClient, searchFirstLawyer, searchSecondLawyer].forEach(input => {
            input.addEventListener('input', filterTable);
        });
    });
</script>
