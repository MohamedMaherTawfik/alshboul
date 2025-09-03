@extends('layouts.admin')
@section('title', 'الموكلين ')
@section('main_title_content', ' قائمة الموكلين ')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('client.index') }}"> موكلين</a>
@endsection
@section('content')
    {{-- Success Message --}}
    @if (session('success'))
        <div class="p-4 mb-4 text-green-800 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- Failure / General Error Message --}}
    @if (session('error'))
        <div class="p-4 mb-4 text-red-800 bg-red-100 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    {{-- Validation Errors (multiple) --}}
    @if ($errors->any())
        <div class="p-4 mb-4 text-red-800 bg-red-100 rounded-lg">
            <ul class="list-disc ps-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">بيانات الموكلين
                    <a href="{{ route('client.create') }}" class="btn btn-success">إضافة جديد</a>
                </h3>
            </div>
            <div class="overflow-auto card-body">
                @if (@isset($data) and !@empty($data) and count($data) > 0)
                    <table id="example2" class="table table-bordered table-hover">
                        <thead class="custom_thead">

                            <th> رقم الموكل</th>
                            <th>اسم الموكل</th>
                            <th> العنوان </th>
                            <th>هاتف </th>
                            <th>الحالة</th>
                            <th>اضافة بواسطة</th>
                            <th>تعديل بواسطة</th>
                            <th>تاريخ التسجيل</th>
                            <th>التحكم</th>

                        </thead>
                        <tbody>

                            @foreach ($data as $info)
                                <tr>
                                    <td>{{ $info->id }}</td>
                                    <td>{{ $info->name }}</td>
                                    <td>{{ $info->address }}</td>
                                    <td>{{ $info->phone }}</td>
                                    <td>

                                        @if (optional($info->user)->active == 1)
                                            مفعل
                                        @else
                                            معطل
                                        @endif

                                    </td>
                                    <td>{{ $info->addedby->username }}</td>
                                    <td>
                                        @if (@isset($info->updateby->username))
                                            {{ $info->updateby->username }}
                                        @else
                                            لم يتم التعديل
                                        @endif
                                    </td>

                                    <td>
                                        {{ optional($info->user)->created_at ? optional($info->user)->created_at : 'غير محدد' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('client.edit', $info) }}" class="btn btn-warning">تعديل</a>
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
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.open-delete-modal').on('click', function() {
                let id = $(this).data('id');
                $('#delete_id').val(id);
            });
        });
    </script>
@endsection
