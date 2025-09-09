@extends('layouts.admin')
@section('title', 'إضافة تسوية')
@section('main_title_content', 'إضافة تسوية جديدة')
@section('title_content', 'إضافة')

@section('content')
    <div class="settlement-form-container">
        <form action="{{ route('settlement.store', $settlements) }}" method="POST">
            @csrf

            <!-- معلومات الموكل -->
            <div class="form-section">
                <h2 class="section-title">معلومات الموكل</h2>

                <div class="form-row">
                    <div class="form-group">
                        <label for="clientName">اسم الموكل *</label>
                        <select id="clientName" name="client_name" required>
                            <option value="">اختر الموكل</option>
                            <?php foreach($clients as $client): ?>
                            <option value="<?= $client->name ?>" data-nationalid="<?= $client->national_id ?>"
                                data-address="<?= $client->address ?>" data-role="<?= $client->role ?>">
                                <?= $client->name ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="clientNationalId">الرقم الوطني للموكل *</label>
                        <input type="text" id="clientNationalId" name="client_national_id" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="clientRole">صفة الموكل *</label>
                        <input type="text" id="clientRole" name="client_status" required>
                    </div>
                    <div class="form-group">
                        <label for="clientAddress">عنوان الموكل</label>
                        <input type="text" id="clientAddress" name="client_address">
                    </div>
                </div>
            </div>

            <!-- معلومات الخصم -->
            <div class="form-section">
                <h2 class="section-title">معلومات الخصم</h2>
                <div class="form-row">
                    <div class="form-group">
                        <label for="opponentName">اسم الخصم</label>
                        <input type="text" id="opponentName" name="opponent_name">
                    </div>
                    <div class="form-group">
                        <label for="opponentNationalId">الرقم الوطني للخصم</label>
                        <input type="text" id="opponentNationalId" name="opponent_national_id">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="opponentRole">صفة الخصم</label>
                        <input type="text" id="opponentRole" name="opponent_status">
                    </div>
                    <div class="form-group">
                        <label for="opponentPhone">رقم الهاتف</label>
                        <input type="text" id="opponentPhone" name="opponent_phone">
                    </div>
                </div>
            </div>

            <!-- معلومات القضية -->
            <div class="form-section">
                <h2 class="section-title">معلومات القضية</h2>
                <div class="form-row">
                    <div class="form-group">
                        <label for="lawsuitNumber">رقم الملف</label>
                        <input type="text" id="lawsuitNumber" name="file_number" readonly value="{{ $nextFileNumber }}">
                    </div>
                </div>
            </div>

            <!-- معلومات التسوية -->
            <div class="form-section">
                <h2 class="section-title">معلومات التسوية</h2>
                <div class="form-row">
                    <div class="form-group">
                        <label for="settlement">نوع التسوية</label>
                        <input type="text" id="settlement" name="type" readonly value="{{ $settlements->name }}">
                    </div>
                    <div class="form-group">
                        <label for="settlementFacts">وقائع التسوية</label>
                        <textarea id="settlementFacts" name="notes"></textarea>
                    </div>
                </div>
            </div>

            <!-- معلومات الدفع -->
            <div class="form-section">
                <h2 class="section-title">معلومات الدفع</h2>
                <div class="form-row">
                    <div class="form-group">
                        <label for="obligationStatus">حالة الالتزام</label>
                        <select name="obligation" id="obligationStatus">
                            <option value="ملتزم">ملتزم</option>
                            <option value="غير ملتزم">غير ملتزم</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="debtValue">قيمة الدين</label>
                        <input type="text" id="debtValue" name="amount">
                    </div>
                    <div class="form-group">
                        <label for="paymentValue">قيمة الدفعة</label>
                        <input type="text" id="paymentValue" name="payment_value">
                    </div>
                    <div class="form-group">
                        <label for="paymentFrequency">تكرار الدفع</label>
                        <select name="payment_terms" id="paymentFrequency">
                            <option value="شهري">شهري</option>
                            <option value="اسبوعي">اسبوعي</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <button type="submit" class="btn-submit">حفظ البيانات</button>
            </div>
        </form>
    </div>

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

    <script>
        const clientSelect = document.getElementById('clientName');
        const nationalIdInput = document.getElementById('clientNationalId');
        const addressInput = document.getElementById('clientAddress');
        const roleInput = document.getElementById('clientRole');

        clientSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            nationalIdInput.value = selectedOption.dataset.nationalid || '';
            addressInput.value = selectedOption.dataset.address || '';
            roleInput.value = selectedOption.dataset.role || '';
        });
    </script>
@endsection
