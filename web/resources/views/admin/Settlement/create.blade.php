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
                    <div class="form-group position-relative">
                        <label for="clientName">اسم الموكل *</label>
                        <input type="text" id="clientName" class="form-control" placeholder="اكتب اسم الموكل"
                            autocomplete="off" required>
                        <input type="hidden" name="client_name" id="clientNameHidden">
                        <div id="clientSuggestions" class="list-group position-absolute w-100"
                            style="z-index: 1000; max-height: 200px; overflow-y: auto; display: none;"></div>
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
                            <option value="">-- اختر --</option>
                            <option value="شهري">شهري</option>
                            <option value="أسبوعي">أسبوعي</option>
                        </select>
                    </div>
                </div>

                <!-- الحقول الإضافية -->
                <div class="form-row" style="margin-top:15px;">
                    <!-- خانة الشهر -->
                    <div class="form-group monthly-field" style="display:none;">
                        <label for="day">رقم اليوم</label>
                        <input type="number" id="day" name="day" class="form-control"
                            placeholder="رقم اليوم">
                    </div>

                    <!-- خانات الأسابيع -->
                    <div class="form-group weekly-field" style="display:none;">
                        <label>الأسبوع 1</label>
                        <input type="number" name="week_1" class="form-control" placeholder="الأسبوع 1">
                    </div>
                    <div class="form-group weekly-field" style="display:none;">
                        <label>الأسبوع 2</label>
                        <input type="number" name="week_2" class="form-control" placeholder="الأسبوع 2">
                    </div>
                    <div class="form-group weekly-field" style="display:none;">
                        <label>الأسبوع 3</label>
                        <input type="number" name="week_3" class="form-control" placeholder="الأسبوع 3">
                    </div>
                    <div class="form-group weekly-field" style="display:none;">
                        <label>الأسبوع 4</label>
                        <input type="number" name="week_4" class="form-control" placeholder="الأسبوع 4">
                    </div>
                </div>
            </div>

            <script>
                const paymentFrequency = document.getElementById("paymentFrequency");
                const monthlyFields = document.querySelectorAll(".monthly-field");
                const weeklyFields = document.querySelectorAll(".weekly-field");

                paymentFrequency.addEventListener("change", function() {
                    if (this.value === "شهري") {
                        monthlyFields.forEach(f => f.style.display = "block");
                        weeklyFields.forEach(f => f.style.display = "none");
                    } else if (this.value === "أسبوعي") {
                        monthlyFields.forEach(f => f.style.display = "none");
                        weeklyFields.forEach(f => f.style.display = "block");
                    } else {
                        monthlyFields.forEach(f => f.style.display = "none");
                        weeklyFields.forEach(f => f.style.display = "none");
                    }
                });
            </script>



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
        const clients = @json($clients);

        const clientInput = document.getElementById('clientName');
        const clientHidden = document.getElementById('clientNameHidden');
        const suggestionsBox = document.getElementById('clientSuggestions');

        const nationalIdInput = document.getElementById('clientNationalId');
        const addressInput = document.getElementById('clientAddress');
        const roleInput = document.getElementById('clientRole');

        clientInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            suggestionsBox.innerHTML = '';
            clientHidden.value = '';

            if (query.length < 1) {
                suggestionsBox.style.display = 'none';
                return;
            }

            let filtered = clients.filter(client => client.name.toLowerCase().includes(query));

            if (filtered.length === 0) {
                suggestionsBox.style.display = 'none';
                return;
            }

            filtered.forEach(client => {
                let item = document.createElement('button');
                item.type = 'button';
                item.className = 'list-group-item list-group-item-action';
                item.textContent = client.name;
                item.onclick = function() {
                    clientInput.value = client.name;
                    clientHidden.value = client.name;
                    nationalIdInput.value = client.national_id || '';
                    addressInput.value = client.address || '';
                    roleInput.value = client.role || '';
                    suggestionsBox.style.display = 'none';
                };
                suggestionsBox.appendChild(item);
            });

            suggestionsBox.style.display = 'block';
        });

        document.addEventListener('click', function(e) {
            if (!clientInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                suggestionsBox.style.display = 'none';
            }
        });
    </script>
@endsection
