@extends('layouts.admin')
@section('title', 'الموكلين ')
@section('main_title_content', ' قائمة الموكلين ')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('client.index') }}"> موكلين</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">
                    عدد الموكلين : {{ count($data) }}
                    <a href="{{ route('client.create') }}" class="btn btn-success">إضافة جديد</a>
                </h3>
            </div>

            <div class="card-body">
                {{-- 🔍 صف البحث --}}
                <div class="mb-4 d-flex flex-wrap gap-2">
                    <input type="text" id="search_name" class="form-control w-auto" placeholder="اسم الموكل"
                        style="min-width: 180px;">
                    <input type="text" id="search_national" class="form-control w-auto" placeholder="الرقم الوطني"
                        style="min-width: 180px;">
                    <input type="text" id="search_nationality" class="form-control w-auto" placeholder="الجنسية"
                        style="min-width: 180px;">
                    <input type="text" id="search_username" class="form-control w-auto" placeholder="اسم الدخول"
                        style="min-width: 180px;">
                    <input type="text" id="search_address" class="form-control w-auto" placeholder="العنوان"
                        style="min-width: 180px;">
                </div>


                <div class="overflow-auto">
                    @if (@isset($data) and !@empty($data) and count($data) > 0)
                        <table id="clientsTable" class="table table-bordered table-hover text-center align-middle">
                            <thead class="custom_thead">
                                <tr>
                                    <th>رقم الموكل</th>
                                    <th>اسم الموكل</th>
                                    <th>الرقم الوطني</th>
                                    <th>الجنسية</th>
                                    <th>اسم الدخول</th>
                                    <th>الرقم السري</th>
                                    <th>البريد</th>
                                    <th>العنوان</th>
                                    <th>هاتف</th>
                                    <th>الحالة</th>
                                    <th>اضافة بواسطة</th>
                                    <th>تعديل بواسطة</th>
                                    <th>تاريخ التسجيل</th>
                                    @if (Auth::user()->role == 'doctor' || Auth::user()->role == 'superadmin')
                                        <th>التحكم</th>
                                    @endif

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $info)
                                    <tr>
                                        <td>{{ $loop->iteration ?? 'غير محدد' }}</td>
                                        <td>{{ $info->name ?? 'غير محدد' }}</td>
                                        <td>{{ $info->national_id ?? 'غير محدد' }}</td>
                                        <td>{{ $info->nationality ?? 'غير محدد' }}</td>
                                        <td>{{ $info->user->username ?? 'غير محدد' }}</td>
                                        <td>{{ $info->user->delete_reason ?? 'غير محدد' }}</td>
                                        <td>{{ $info->user->email ?? 'غير محدد' }}</td>
                                        <td>{{ $info->address ?? 'غير محدد' }}</td>
                                        <td>{{ $info->phone ?? 'غير محدد' }}</td>
                                        <td>
                                            @if (optional($info->user)->active == 1)
                                                مفعل
                                            @else
                                                معطل
                                            @endif
                                        </td>
                                        <td>{{ $info->addedby->username ?? 'غير محدد' }}</td>
                                        <td>
                                            @if (@isset($info->updateby->username))
                                                {{ $info->updateby->username }}
                                            @else
                                                لم يتم التعديل
                                            @endif
                                        </td>
                                        <td>{{ optional($info->user)->created_at ?? 'غير محدد' }}</td>
                                        @if (Auth::user()->role == 'doctor' || Auth::user()->role == 'superadmin')
                                            <td>
                                                <a href="{{ route('client.edit', $info) }}"
                                                    class="btn btn-warning">تعديل</a>
                                                <form action="{{ route('client.delete', $info) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('هل أنت متأكد من الحذف؟')">
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
                        <div class="col-md-12">
                            <div class="text-center alert alert-info">
                                لا توجد بيانات لعرضها.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // دالة البحث العامة
            function liveSearch() {
                let name = $('#search_name').val().toLowerCase();
                let national = $('#search_national').val().toLowerCase();
                let nationality = $('#search_nationality').val().toLowerCase();
                let username = $('#search_username').val().toLowerCase();
                let address = $('#search_address').val().toLowerCase();

                $('#clientsTable tbody tr').filter(function() {
                    $(this).toggle(
                        $(this).find('td:nth-child(2)').text().toLowerCase().includes(name) &&
                        $(this).find('td:nth-child(3)').text().toLowerCase().includes(national) &&
                        $(this).find('td:nth-child(4)').text().toLowerCase().includes(nationality) &&
                        $(this).find('td:nth-child(5)').text().toLowerCase().includes(username) &&
                        $(this).find('td:nth-child(7)').text().toLowerCase().includes(address)
                    );
                });
            }

            // تفعيل البحث أثناء الكتابة
            $('#search_name, #search_national, #search_nationality, #search_username, #search_address').on('keyup',
                function() {
                    liveSearch();
                });
        });
    </script>
@endsection
