@extends('layouts.admin')

@section('title', 'المعاملات')
@section('main_title_content', 'إضافة معاملة')
@section('title_content', 'إضافة')
@section('link_content')
    <a href="{{ route('transactions.all', $transaction) }}">المعاملات</a>
@endsection

@section('content')
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h3 class="card-title text-center">
                    إضافة معاملة جديدة - ({{ $transaction->name ?? '-' }})
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ route('transactions.store', $transaction) }}" method="POST">
                    @csrf

                    <input type="hidden" name="transactions_main_id" value="{{ $transaction->id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                    <div class="row">
                        <!-- 🟢 المشترك -->
                        <div class="form-group col-md-6 position-relative">
                            <label class="fw-bold">المشترك</label>
                            <input type="text" id="subscriber_name" class="form-control" placeholder="اكتب اسم المشترك"
                                autocomplete="off" required>
                            <input type="hidden" name="subscriber_id" id="subscriber_id">
                            <div id="subscriber_suggestions" class="list-group position-absolute w-100"
                                style="z-index:1000; max-height:200px; overflow-y:auto; display:none;"></div>
                        </div>

                        <!-- 🔢 رقم الملف -->
                        <div class="form-group col-md-6">
                            <label class="fw-bold">رقم الملف</label>
                            <input type="text" name="file_number" class="form-control" value="{{ $missing }}"
                                readonly>
                        </div>
                    </div>

                    <div class="row">
                        <!-- 🟡 الموكل -->
                        <div class="form-group col-md-6">
                            <label class="fw-bold">الموكل</label>
                            <select name="client_name" id="client_id" class="form-select" required disabled>
                                <option value="">-- اختر الموكل --</option>
                            </select>
                        </div>

                        <!-- 🏛️ المنطقة -->
                        <div class="form-group col-md-6">
                            <label class="fw-bold">اسم الدائرة المختصة</label>
                            <input type="text" name="area_name" class="form-control" value="{{ old('area_name') }}">
                        </div>
                    </div>

                    <div class="row">
                        <!-- 📄 الوصف -->
                        <div class="form-group col-md-6">
                            <label class="fw-bold">الوصف</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                        </div>

                        <!-- 🗒️ ملاحظات -->
                        <div class="form-group col-md-6">
                            <label class="fw-bold">الملاحظات</label>
                            <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <div class="row">
                        <!-- ⚙️ الحالة -->
                        <div class="form-group col-md-6">
                            <label class="fw-bold">الحالة</label>
                            <select name="is_active" class="form-select">
                                <option value="1" selected>نشط</option>
                                <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>غير نشط</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-success px-4">حفظ</button>
                        <a href="{{ route('transactions.all', $transaction) }}" class="btn btn-secondary px-4">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const subscriberInput = document.getElementById("subscriber_name");
            const subscriberHidden = document.getElementById("subscriber_id"); // 🟢 id المشترك
            const suggestionsBox = document.getElementById("subscriber_suggestions");
            const clientSelect = document.getElementById("client_id"); // 🟡 الموكل (name)
            const users = @json($users);

            // عند الكتابة في حقل المشترك
            subscriberInput.addEventListener("input", function() {
                const query = this.value.toLowerCase();
                suggestionsBox.innerHTML = "";
                subscriberHidden.value = "";
                clientSelect.innerHTML = '<option value="">-- اختر الموكل --</option>';
                clientSelect.disabled = true;

                if (query.length < 1) return suggestionsBox.style.display = "none";

                const filtered = users.filter(user => user.name.toLowerCase().includes(query));
                if (!filtered.length) return suggestionsBox.style.display = "none";

                filtered.forEach(user => {
                    const item = document.createElement("button");
                    item.type = "button";
                    item.className = "list-group-item list-group-item-action";
                    item.textContent = user.name;

                    item.onclick = () => {
                        subscriberInput.value = user.name;
                        subscriberHidden.value = user.id; // 🟢 نخزن id المشترك
                        suggestionsBox.style.display = "none";

                        // امسح الموكلين القديمة
                        clientSelect.innerHTML = '<option value="">-- اختر الموكل --</option>';
                        clientSelect.disabled = true;

                        // عرض الموكلين (clients)
                        if (user.client?.length) {
                            user.client.forEach(client => {
                                const opt = document.createElement("option");
                                opt.value = client.name; // 🟡 الموكل يبعِت الاسم فقط
                                opt.textContent = client.name;
                                clientSelect.appendChild(opt);
                            });
                            clientSelect.disabled = false;
                        }
                    };
                    suggestionsBox.appendChild(item);
                });

                suggestionsBox.style.display = "block";
            });

            // إغلاق الاقتراحات عند الضغط بالخارج
            document.addEventListener('click', function(e) {
                if (!subscriberInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                    suggestionsBox.style.display = "none";
                }
            });
        });
    </script>
@endsection
