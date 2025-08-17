@extends('layouts.admin')
@section('title', 'الأرشيف')
@section('main_title_content', 'قائمة الأرشيف')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('archive.index') }}">الأرشيف المحذوف </a>
@endsection
@section('content')

    <div class="container-fluid">
        <!-- الجدول -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center" id="archive-table">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>اسم المُنشئ</th>
                        <th>القائمة الرئيسية</th>
                        <th>القائمة الفرعية</th>
                        <th>الاسم</th>
                        <th>الملف</th>
                        <th>الوصف</th>
                        <th>ملاحظات</th>
                        <th>تاريخ الإنشاء</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($archives->count() > 0)
                        @foreach ($archives as $archive)
                            <tr data-sub-menu-id="{{ $archive->archivesSubMenues->id ?? '' }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $archive->user->name ?? 'غير معروف' }}</td>
                                <td>{{ $archive->archivesSubMenues->archivesMainMenues->name ?? 'لا يوجد' }}</td>
                                <td>{{ $archive->archivesSubMenues->name ?? 'لا يوجد' }}</td>
                                <td>{{ $archive->name }}</td>
                                <td>
                                    @if ($archive->file)
                                        <a href="{{ asset('storage/' . $archive->file) }}" target="_blank"
                                            class="btn btn-info btn-sm">
                                            <i class="fas fa-file"></i> عرض الملف
                                        </a>
                                    @else
                                        <span class="text-muted">لا يوجد ملف</span>
                                    @endif
                                </td>
                                <td>{{ Str::limit($archive->description ?? 'لا يوجد', 50, '...') }}</td>
                                <td>{{ Str::limit($archive->notes ?? 'لا يوجد', 50, '...') }}</td>

                                <td>{{ $archive->created_at->format('Y-m-d | H:i') }}</td>

                                <td>
                                    <form action="{{ route('archive.restore', $archive) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn bg-success text-black">
                                            استرجاع
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="10" class="text-center text-muted">لا توجد بيانات في الأرشيف.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- JavaScript للفلترة -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const tableRows = document.querySelectorAll('#archive-table tbody tr');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const subMenuId = this.getAttribute('data-sub-menu'); // فارغ = عرض الكل

                    tableRows.forEach(row => {
                        const rowSubMenuId = row.getAttribute('data-sub-menu-id');

                        if (subMenuId === '' || rowSubMenuId === subMenuId) {
                            row.style.display = ''; // اعرض
                        } else {
                            row.style.display = 'none'; // اخفِ
                        }
                    });
                });
            });
        });
    </script>
@endsection
