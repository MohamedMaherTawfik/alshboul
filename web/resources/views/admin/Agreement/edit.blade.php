@extends('layouts.admin')
@section('title', 'الاتفاقيات')
@section('main_title_content', 'قائمة الاتفاقيات')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="{{ route('agreement.index') }}">اتفاقيات</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">تعديل بيانات الاتفاقية</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('agreement.update', $data->id) }}" method="post">
                    @csrf
                    <input type="hidden" name="updated_by" value="{{ Auth::user()->id }}">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="">رقم الاتفاقية</label>
                            <input type="text" name="agreement_number"
                                value="{{ old('agreement_number', $data->agreement_number) }}" class="form-control">
                            @error('agreement_number')
                                <small class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                      
                        <div class="form-group col-md-4">
                            <label for="">الطرف الاول </label>
                            <select name="first_party" class="form-control">
                                <option value="">-- اختر الموكل --</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}"
                                        {{ $data->first_party == $client->id ? 'selected' : '' }}>{{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('client_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">الطرف الثاني</label>
                            <input type="text" name="second_party"
                                value="{{ old('second_party', $data->second_party) }}" class="form-control">
                            @error('second_party')
                                <small class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="">تاريخ الاتفاقية</label>
                            <input type="date" name="agreement_date"
                                value="{{ old('agreement_date', $data->agreement_date) }}" class="form-control">
                            @error('agreement_date')
                                <small class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">نوع الاتفاقية</label>
                            <select name="agreement_type" class="form-control">
                                <option value="">اختر نوع الاتفاقية</option>
                                <option value="public"
                                    {{ old('agreement_type', $data->agreement_type) == 'public' ? 'selected' : '' }}>عامة
                                </option>
                                <option value="private"
                                    {{ old('agreement_type', $data->agreement_type) == 'private' ? 'selected' : '' }}>خاصة
                                </option>
                            </select>
                            @error('agreement_type')
                                <small class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">المبلغ</label>
                            <input type="number" step="0.01" name="amount" value="{{ old('amount', $data->amount) }}"
                                class="form-control">
                            @error('amount')
                                <small class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">الموضوع</label>
                            <textarea name="subject" class="form-control" rows="3">{{ old('subject', $data->subject) }}</textarea>
                            @error('subject')
                                <small class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="">تمثيل بواسطة </label>
                            <select name="represented_by" class="form-control">
                                <option value="">-- اختر موظف --</option>
                                @foreach ($partners as $partner)
                                    <option value="{{ $partner->id }}"
                                        {{ $data->represented_by == $partner->id ? 'selected' : '' }}>
                                        {{ $partner->username }}
                                    </option>
                                @endforeach
                            </select>
                            @error('represented_by')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <h5>معلومات الأقساط (اختياري)</h5>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="">عدد الأقساط</label>
                            <input type="number" name="installments_count"
                                value="{{ old('installments_count', $data->installments_count) }}" class="form-control"
                                min="1">
                            @error('installments_count')
                                <small class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">الفترة بين الأقساط (بالشهور)</label>
                            <input type="number" name="installment_interval_months"
                                value="{{ old('installment_interval_months', $data->installment_interval_months) }}"
                                class="form-control" min="1">
                            @error('installment_interval_months')
                                <small class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">تاريخ أول قسط</label>
                            <input type="date" name="first_installment_date"
                                value="{{ old('first_installment_date', $data->first_installment_date) }}"
                                class="form-control">
                            @error('first_installment_date')
                                <small class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="text-center col-md-12">
                        <button type="submit" class="btn btn-success">تعديل</button>
                    </div>
                </form>
                <hr>
                <h5>الأقساط الحالية</h5>
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
