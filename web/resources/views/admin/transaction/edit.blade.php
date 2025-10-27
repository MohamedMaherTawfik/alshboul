@extends('layouts.admin')

@section('title', 'تعديل المعاملة')
@section('main_title_content', 'تعديل المعاملة')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="{{ route('transactions.all', $transaction->transactionsMain) }}">المعاملات</a>
@endsection

@section('content')
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white text-center py-3">
                <h4 class="mb-0">تعديل المعاملة - ({{ $transaction->transactionsMain->name ?? '-' }})</h4>
            </div>

            <div class="card-body bg-light">
                <form action="{{ route('transactions.update', $transaction) }}" method="POST" class="p-3">
                    @csrf

                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                    <div class="row g-4">

                        <!-- 🟢 المشترك -->
                        <div class="col-md-6 position-relative">
                            <label class="fw-bold mb-2">المشترك</label>
                            <input type="text" id="subscriber_name" class="form-control form-control-lg border-2"
                                value="{{ $transaction->subscriber?->name }}" placeholder="اكتب اسم المشترك"
                                autocomplete="off" required>
                            <input type="hidden" name="subscriber_id" id="subscriber_id"
                                value="{{ $transaction->subscriber_id }}">
                            <div id="subscriber_suggestions"
                                class="list-group position-absolute w-100 mt-1 shadow-sm rounded"
                                style="z-index:1000; max-height:200px; overflow-y:auto; display:none;"></div>
                        </div>

                        <!-- 🔢 رقم الملف -->
                        <div class="col-md-6">
                            <label class="fw-bold mb-2">رقم الملف</label>
                            <input type="text" name="file_number" id="file_number"
                                class="form-control form-control-lg border-2 bg-white"
                                value="{{ $transaction->file_number }}" readonly>
                        </div>

                        <!-- 🟡 الموكل -->
                        <div class="col-md-6">
                            <label class="fw-bold mt-8">الموكل</label>
                            <select name="client_name" id="client_id" class="form-select form-select-lg border-2 bg-white"
                                required>
                                <option value="">-- اختر الموكل --</option>
                                @if ($transaction->subscriber && $transaction->subscriber->client)
                                    @foreach ($transaction->subscriber->client as $client)
                                        <option value="{{ $client->name }}"
                                            {{ $transaction->client_name == $client->name ? 'selected' : '' }}>
                                            {{ $client->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- 🏛️ المنطقة -->
                        <div class="col-md-6">
                            <label class="fw-bold mb-2">اسم الدائرة المختصة</label>
                            <input type="text" name="area_name" class="form-control form-control-lg border-2 bg-white"
                                value="{{ $transaction->area_name }}">
                        </div>

                        <!-- 📄 الوصف -->
                        <div class="col-md-6">
                            <label class="fw-bold mb-2">الوصف</label>
                            <textarea name="description" class="form-control form-control-lg border-2" rows="3">{{ $transaction->description }}</textarea>
                        </div>

                        <!-- 🗒️ الملاحظات -->
                        <div class="col-md-6">
                            <label class="fw-bold mb-2">الملاحظات</label>
                            <textarea name="notes" class="form-control form-control-lg border-2" rows="3">{{ $transaction->notes }}</textarea>
                        </div>

                        <!-- ⚙️ الحالة -->
                        <div class="col-md-6">
                            <label class="fw-bold mb-2">الحالة</label>
                            <select name="is_active" class="form-select form-select-lg border-2 bg-white">
                                <option value="1" {{ $transaction->is_active ? 'selected' : '' }}>نشط</option>
                                <option value="0" {{ !$transaction->is_active ? 'selected' : '' }}>غير نشط</option>
                            </select>
                        </div>

                        <!-- 🧾 الملف الرئيسي -->
                        <div class="col-md-6">
                            <label class="fw-bold mb-2">الملف الرئيسي</label>
                            <select name="transactions_main_id" id="transactions_main_id"
                                class="form-select form-select-lg border-2 bg-white" required>
                                <option value="">-- اختر الملف الرئيسي --</option>
                                @foreach ($transzctionsmains as $main)
                                    <option value="{{ $main->id }}"
                                        {{ $transaction->transactions_main_id == $main->id ? 'selected' : '' }}>
                                        {{ $main->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success btn-lg px-5">💾 تحديث</button>
                        <a href="{{ route('transactions.all', $transaction->transactionsMain) }}"
                            class="btn btn-secondary btn-lg px-5 ms-2">إلغاء</a>
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
            const subscriberHidden = document.getElementById("subscriber_id");
            const suggestionsBox = document.getElementById("subscriber_suggestions");
            const clientSelect = document.getElementById("client_id");
            const users = @json($users);

            // 🟢 اختيار المشترك (Autocomplete)
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
                    item.className = "list-group-item list-group-item-action py-2";
                    item.textContent = user.name;

                    item.onclick = () => {
                        subscriberInput.value = user.name;
                        subscriberHidden.value = user.id;
                        suggestionsBox.style.display = "none";

                        clientSelect.innerHTML = '<option value="">-- اختر الموكل --</option>';
                        clientSelect.disabled = true;

                        if (user.client?.length) {
                            user.client.forEach(client => {
                                const opt = document.createElement("option");
                                opt.value = client.name;
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

            document.addEventListener('click', function(e) {
                if (!subscriberInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                    suggestionsBox.style.display = "none";
                }
            });

            // 🔻 إخفاء قائمة الاقتراحات عند الضغط خارجها
            document.addEventListener("click", function(e) {
                if (!subscriberInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                    suggestionsBox.style.display = "none";
                }
            });
        });
    </script>
@endsection
