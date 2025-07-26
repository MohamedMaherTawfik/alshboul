@extends('layouts.admin')
@section('title', 'الاتفاقيات')
@section('main_title_content', 'قائمة الاتفاقيات')
@section('title_content', 'عرض الاتفاقية')
@section('link_content')
    <a href="{{ route('agreement.index') }}">
        اتفاقيات</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">تفاصيل الاتفاقية</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-4"><strong>رقم الاتفاقية:</strong> {{ $data->agreement_number }}</div>
                    <div class="form-group col-md-4"><strong>الطرف الأول:</strong> {{ $data->firstParty->name }}</div>
                    <div class="form-group col-md-4"><strong>الطرف الثاني:</strong> {{ $data->second_party }}</div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4"><strong>تاريخ الاتفاقية:</strong> {{ $data->agreement_date }}</div>
                    <div class="form-group col-md-4"><strong>نوع الاتفاقية:</strong>
                        @if ($data->agreement_type == 'public')
                            عامة
                        @elseif($data->agreement_type == 'private')
                            خاصة
                        @else
                            غير محدد
                        @endif
                    </div>
                    <div class="form-group col-md-4"><strong>المبلغ:</strong>
                        {{ $data->amount ? number_format($data->amount, 2) . ' دينار' : 'غير محدد' }}</div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6"><strong>الموضوع:</strong> {{ $data->subject ?? 'غير محدد' }}</div>
                    <div class="form-group col-md-6"><strong>تمثيل بواسطة:</strong>
                        {{ $data->representor->username ?? 'غير محدد' }}</div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4"><strong>عدد الأقساط:</strong> {{ $data->installments_count }}</div>
                    <div class="form-group col-md-4"><strong>الفترة بين الأقساط:</strong>
                        {{ $data->installment_interval_months }} شهر</div>
                    <div class="form-group col-md-4"><strong>تاريخ أول قسط:</strong> {{ $data->first_installment_date }}
                    </div>
                </div>
                <hr>
                <h5>الأقساط</h5>
                @if ($data->installments && count($data->installments) > 0)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>المبلغ</th>
                                <th>تاريخ الاستحقاق</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->installments as $inst)
                                <tr>
                                    <td>{{ number_format($inst->amount, 2) }} دينار</td>
                                    <td>{{ $inst->due_date }}</td>
                                    <td>{{ $inst->is_paid ? 'مدفوع' : 'غير مدفوع' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info">لا توجد أقساط مسجلة.</div>
                @endif
            </div>
        </div>
    </div>
@endsection
