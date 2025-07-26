@extends('layouts.admin')
@section('title', 'الاتفاقيات')
@section('main_title_content', 'قائمة الاتفاقيات')
@section('title_content', 'إضافة')
@section('link_content')
    <a href="{{ route('agreement.index') }}">اتفاقيات</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">إضافة اتفاقية جديدة</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('agreement.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="created_by" value="{{ Auth::user()->id }}">

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="">رقم الاتفاقية</label>
                            <input type="text" name="agreement_number" value="{{ old('agreement_number') }}"
                                class="form-control" placeholder="أدخل رقم الاتفاقية">
                            @error('agreement_number')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        {{-- <div class="form-group col-md-4">
                            <label for="">الطرف الأول</label>
                            <input type="text" name="first_party" value="{{ old('first_party') }}" class="form-control"
                                placeholder="أدخل اسم الطرف الأول">
                            @error('first_party')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div> --}}

                        <div class="form-group col-md-4">
                            <label for="">الطرف الاول </label>
                            <select name="first_party" class="form-control">
                                <option value="">-- اختر الموكل --</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('client_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">الطرف الثاني</label>
                            <input type="text" name="second_party" value="{{ old('second_party') }}" class="form-control"
                                placeholder="أدخل اسم الطرف الثاني">
                            @error('second_party')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="">تاريخ الاتفاقية</label>
                            <input type="date" name="agreement_date" value="{{ old('agreement_date') }}"
                                class="form-control">
                            @error('agreement_date')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">نوع الاتفاقية</label>
                            <select name="agreement_type" class="form-control">
                                <option value="">اختر نوع الاتفاقية</option>
                                <option value="public" {{ old('agreement_type') == 'public' ? 'selected' : '' }}>عامة
                                </option>
                                <option value="private" {{ old('agreement_type') == 'private' ? 'selected' : '' }}>خاصة
                                </option>
                            </select>
                            @error('agreement_type')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">المبلغ</label>
                            <input type="number" step="0.01" name="amount" value="{{ old('amount') }}"
                                class="form-control" placeholder="أدخل المبلغ">
                            @error('amount')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">الموضوع</label>
                            <textarea name="subject" class="form-control" rows="3" placeholder="أدخل موضوع الاتفاقية">{{ old('subject') }}</textarea>
                            @error('subject')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">تمثيل بواسطة </label>
                            <select name="represented_by" class="form-control">
                                <option value="">-- اختر موظف --</option>
                                @foreach ($partners as $partner)
                                    <option value="{{ $partner->id }}">{{ $partner->username }}
                                    </option>
                                @endforeach
                            </select>
                            @error('partner_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    <hr>
                    <h5>معلومات الأقساط (اختياري)</h5>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="">عدد الأقساط</label>
                            <input type="number" name="installments_count" value="{{ old('installments_count', 1) }}"
                                class="form-control" placeholder="أدخل عدد الأقساط" min="1">
                            @error('installments_count')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">الفترة بين الأقساط (بالشهور)</label>
                            <input type="number" name="installment_interval_months"
                                value="{{ old('installment_interval_months', 1) }}" class="form-control"
                                placeholder="أدخل الفترة بالشهور" min="1">
                            @error('installment_interval_months')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">تاريخ أول قسط</label>
                            <input type="date" name="first_installment_date"
                                value="{{ old('first_installment_date') }}" class="form-control">
                            @error('first_installment_date')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="text-center col-md-12">
                        <button type="submit" class="btn btn-success">إضافة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Auto-calculate installment amount when amount or count changes
            const amountInput = document.querySelector('input[name="amount"]');
            const countInput = document.querySelector('input[name="installments_count"]');

            function updateInstallmentInfo() {
                const amount = parseFloat(amountInput.value) || 0;
                const count = parseInt(countInput.value) || 1;

                if (amount > 0 && count > 0) {
                    const installmentAmount = amount / count;
                    // You can add a display element to show the calculated amount
                    console.log(`مبلغ كل قسط: ${installmentAmount.toFixed(2)} دينار`);
                }
            }

            amountInput.addEventListener('input', updateInstallmentInfo);
            countInput.addEventListener('input', updateInstallmentInfo);
        });
    </script>
@endsection
