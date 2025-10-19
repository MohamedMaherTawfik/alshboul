@extends('layouts.admin')
@section('title', 'أنواع القضايا')
@section('main_title_content', 'قائمة أنواع القضايا')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('casetypes.index') }}">أنواع القضايا</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">بيانات أنواع الحالات
                    <a href="{{ route('casetypes.create') }}" class="btn btn-success">إضافة جديد</a>
                </h3>
            </div>
            <div class="text-center mt-4">
                <h3>قائمة انواع القضايا</h3>
            </div>
            <div class="overflow-auto card-body">
                @if (@isset($data) and !@empty($data) and count($data) > 0)
                    <table id="example2" class="table table-bordered table-hover text-center align-middle">
                        <thead class="custom_thead">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th style="width: 50%;">الاسم بالعربية</th>
                                <th style="width: 120px;">عدد ايام الاهمال</th>
                                <th style="width: 180px;">التحكم</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $info)
                                <tr>
                                    <td>{{ $info->id }}</td>
                                    <td class="text-start">{{ $info->name }}</td>
                                    <td>{{ $info->NegligenceDays->first()->days ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('casetypes.edit.new', $info->id) }}"
                                            class="btn btn-warning btn-sm">تعديل</a>
                                        {{-- <a href="{{ route('casetypes.destroy.new', $info->id) }}"
                                            class="btn btn-danger btn-sm">حذف</a> --}}
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

            <hr>
            <div class="text-center mt-4">
                <h3>قائمة انواع التسويات</h3>
            </div>
            <div class="overflow-auto card-body">
                @if (@isset($settlements) and !@empty($settlements) and count($settlements) > 0)
                    <table id="example2" class="table table-bordered table-hover text-center align-middle">
                        <thead class="custom_thead">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th style="width: 50%;">الاسم بالعربية</th>
                                <th style="width: 120px;">عدد ايام الاهمال</th>
                                <th style="width: 180px;">التحكم</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($settlements as $info)
                                <tr>
                                    <td>{{ $info->id }}</td>
                                    <td class="text-start">{{ $info->name }}</td>
                                    <td>{{ $info->NegligenceDays->first()->days ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('settlements.edit.new', $info->id) }}"
                                            class="btn btn-warning btn-sm">تعديل</a>
                                        {{-- <a href="{{ route('settlements.destroy.new', $info->id) }}"
                                            class="btn btn-danger btn-sm">حذف</a> --}}
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

            <hr>
            <div class="text-center mt-4">
                <h3>قائمة انواع المعاملات</h3>
            </div>
            <div class="overflow-auto card-body">
                @if (@isset($transactions) and !@empty($transactions) and count($transactions) > 0)
                    <table id="example2" class="table table-bordered table-hover text-center align-middle">
                        <thead class="custom_thead">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th style="width: 50%;">الاسم بالعربية</th>
                                <th style="width: 120px;">عدد ايام الاهمال</th>
                                <th style="width: 180px;">التحكم</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $info)
                                <tr>
                                    <td>{{ $info->id }}</td>
                                    <td class="text-start">{{ $info->name }}</td>
                                    <td>{{ $info->NegligenceDays->first()->days ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('transactions.edit.new', $info->id) }}"
                                            class="btn btn-warning btn-sm">تعديل</a>
                                        {{-- <a href="{{ route('transactions.destroy.new', $info->id) }}"
                                            class="btn btn-danger btn-sm">حذف</a> --}}
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

            <hr>
            <hr>
            @foreach ($mainNavs as $item)
                <div class="text-center mt-4">
                    <h3>قائمة انواع {{ $item->title }}</h3>
                </div>
                <div class="overflow-auto card-body">
                    <table id="example2" class="table table-bordered table-hover text-center align-middle">
                        <thead class="custom_thead">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th style="width: 50%;">الاسم بالعربية</th>
                                <th style="width: 120px;">عدد ايام الاهمال</th>
                                <th style="width: 180px;">التحكم</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subNavs as $info)
                                @if ($info->main_nav_id == $item->id)
                                    <tr>
                                        <td>{{ $info->id }}</td>
                                        <td class="text-start">{{ $info->name }}</td>
                                        <td>{{ $info->neglienceDays->first()->days ?? '-' }}</td>
                                        <td>
                                            {{-- <form action="{{ route('MainTypes.nav.destroy', $info) }}" method="POST"
                                                onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash-alt mr-1"></i> حذف
                                                </button>
                                            </form> --}}


                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>

                </div>

                <hr>
            @endforeach

            <div class="text-center mt-4">
                <h3>قائمة انواع القضايا التنفذية</h3>
            </div>
            <div class="overflow-auto card-body">
                @if (@isset($excutiveCases) and !@empty($excutiveCases) and count($excutiveCases) > 0)
                    <table id="example2" class="table table-bordered table-hover text-center align-middle">
                        <thead class="custom_thead">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th style="width: 50%;">الاسم بالعربية</th>
                                <th style="width: 120px;">عدد ايام الاهمال</th>
                                <th style="width: 180px;">التحكم</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($excutiveCases as $info)
                                <tr>
                                    <td>{{ $info->id }}</td>
                                    <td class="text-start">{{ $info->name }}</td>
                                    <td>{{ $info->NegligenceDays->first()->days ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('excutiveCases.edit.new', $info->id) }}"
                                            class="btn btn-warning btn-sm">تعديل</a>
                                        {{-- <a href="{{ route('excutiveCases.destroy.new', $info->id) }}"
                                            class="btn btn-danger btn-sm">حذف</a> --}}
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
    <div class="modal fade" id="delete_reason">
        <div class="modal-dialog modal-l">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-center modal-title">حذف البيانات</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="months_of_year_model_body">
                    <form action="{{ route('casetypes.destroy', '1') }}" method="post" id="delete_form">
                        @csrf
                        @method('DELETE')
                        <div class="form-group col-md-12">
                            <label for="">سبب الحذف</label>
                            <textarea name="reason" class="form-control" cols="30" rows="10">{{ old('reason') }}</textarea>
                        </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-danger">حذف</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection
