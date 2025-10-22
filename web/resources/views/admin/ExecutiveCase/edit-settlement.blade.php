@extends('layouts.admin')

@section('title', 'تعديل التسوية')
@section('main_title_content', 'تعديل التسوية')
@section('title_content', 'تعديل')

@section('content')
    <div class="settlement-form-container">
        <form action="{{ route('executive-case.settlement.update', $settlement) }}" method="POST">
            @csrf

            <!-- نوع التسوية والالتزام -->
            <div class="form-section">
                <h2 class="section-title">إعدادات التسوية</h2>
                <div class="form-row">

                    <div class="form-group">
                        <label for="obligation">الالتزام</label>
                        <select id="obligation" name="obligation" required>
                            <option value="">-- اختر الالتزام --</option>
                            <option value="ملتزم" {{ $settlement->obligation == 'ملتزم' ? 'selected' : '' }}>ملتزم</option>
                            <option value="غير ملتزم" {{ $settlement->obligation == 'غير ملتزم' ? 'selected' : '' }}>غير
                                ملتزم</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- بيانات التسوية -->
            <div class="form-section">
                <h2 class="section-title">بيانات التسوية</h2>
                <div class="form-row">
                    <div class="form-group">
                        <label for="opponent_phone">هاتف الخصم</label>
                        <input type="text" id="opponent_phone" name="opponent_phone"
                            value="{{ $settlement->opponent_phone }}">
                    </div>
                    <div class="form-group">
                        <label for="client_status">صفة الموكل</label>
                        <input type="text" id="client_status" name="client_status"
                            value="{{ $settlement->client_status }}">
                    </div>
                    <div class="form-group">
                        <label for="opponent_status">صفة الخصم</label>
                        <input type="text" id="opponent_status" name="opponent_status"
                            value="{{ $settlement->opponent_status }}">
                    </div>
                    <div class="form-group">
                        <label for="opponent_name">اسم الخصم</label>
                        <input type="text" id="opponent_name" name="opponent_name"
                            value="{{ $settlement->opponent_name }}">
                    </div>
                    <div class="form-group">
                        <label for="client_name">اسم الموكل</label>
                        <input type="text" id="client_name" name="client_name" value="{{ $settlement->client_name }}">
                    </div>
                </div>
            </div>

            <!-- المعلومات المالية -->
            <div class="form-section">
                <h2 class="section-title">المعلومات المالية</h2>
                <div class="form-row">
                    <div class="form-group">
                        <label for="amount">المبلغ</label>
                        <input type="number" step="0.01" id="amount" name="amount"
                            value="{{ $settlement->amount }}">
                    </div>
                    <div class="form-group">
                        <label for="payment_value">قيمة الدفعات</label>
                        <input type="number" step="0.01" id="payment_value" name="payment_value"
                            value="{{ $settlement->payment_value }}">
                    </div>
                    <div class="form-group">
                        <label for="payment_terms">شروط السداد</label>
                        <select id="payment_terms" name="payment_terms" required>
                            <option value="{{ $settlement->payment_terms }}">{{ $settlement->payment_terms }}</option>
                            <option value="شهري" {{ $settlement->payment_terms == 'شهري' ? 'selected' : '' }}>شهري
                            </option>
                            <option value="أسبوعي" {{ $settlement->payment_terms == 'أسبوعي' ? 'selected' : '' }}>أسبوعي
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- ملاحظات -->
            <div class="form-section">
                <h2 class="section-title">ملاحظات</h2>
                <div class="form-row">
                    <div class="form-group" style="flex: 1 0 100%;">
                        <textarea id="notes" name="notes">{{ $settlement->notes }}</textarea>
                    </div>
                </div>
            </div>

            <!-- زر التحديث -->
            <div class="form-row">
                <button type="submit" class="btn-submit">تحديث</button>
            </div>
        </form>
    </div>

    {{-- نفس CSS & JS بتاع الفورم الأول --}}
    <style>
        .settlement-form-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .form-section {
            margin-bottom: 30px;
            padding: 25px;
            background: #f9f9f9;
            border-radius: 8px;
            border-right: 4px solid #3498db;
            transition: all 0.3s ease;
        }

        .form-section:hover {
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
        }

        .section-title {
            color: #2980b9;
            margin-top: 0;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
            font-size: 1.4rem;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px 20px;
            gap: 15px;
        }

        .form-group {
            flex: 1 0 calc(50% - 20px);
            min-width: 250px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #444;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .btn-submit {
            background: #3498db;
            color: white;
            border: none;
            padding: 14px 40px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 20px auto;
            display: block;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-submit:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 768px) {
            .form-group {
                flex: 1 0 100%;
            }

            .settlement-form-container {
                padding: 20px;
            }

            .form-section {
                padding: 20px;
            }
        }
    </style>
@endsection
