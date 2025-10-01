@extends('layouts.admin')

@section('title', 'المعاملات')
@section('main_title_content', 'إضافة معاملة')
@section('title_content', 'إضافة')
@section('link_content')
    <a href="{{ route('transactions.all', $transaction) }}">المعاملات</a>
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">
                    إضافة معاملة جديدة - ({{ $transaction->name ?? '-' }})
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ route('transactions.store', $transaction) }}" method="post">
                    @csrf

                    <input type="hidden" name="transactions_main_id" value="{{ $transaction->id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                    <div class="row">
                        <!-- المشترك -->
                        <div class="form-group col-md-6 position-relative">
                            <label for="subscriber_name">المشترك</label>
                            <input type="text" id="subscriber_name" class="form-control" placeholder="اكتب اسم المشترك"
                                autocomplete="off">
                            <input type="hidden" name="subscriber_id" id="subscriber_id_hidden">
                            <div id="subscriberSuggestions" class="list-group position-absolute w-100"
                                style="z-index: 1000; max-height: 200px; overflow-y: auto; display: none;"></div>
                            @error('subscriber_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- رقم الملف -->
                        <div class="form-group col-md-6">
                            <label for="file_number">رقم الملف</label>
                            <input type="text" name="file_number" id="file_number" value="{{ $missing }}"
                                class="form-control" readonly>
                            @error('file_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- الموكل -->
                        <div class="form-group col-md-6">
                            <label for="client_id">الموكل</label>
                            <select name="client_name" id="client_id" class="form-control" disabled>
                                <option value="">اختر الموكل</option>
                            </select>
                            @error('client_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- المنطقة -->
                        <div class="form-group col-md-6">
                            <label for="area_name">اسم الدائره المختصه</label>
                            <input type="text" name="area_name" id="area_name" value="{{ old('area_name') }}"
                                class="form-control">
                            @error('area_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- الوصف -->
                        <div class="form-group col-md-6">
                            <label for="description">الوصف</label>
                            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- ملاحظات -->
                        <div class="form-group col-md-6">
                            <label for="notes">الملاحظات</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- الحالة -->
                        <div class="form-group col-md-6">
                            <label for="is_active">الحالة</label>
                            <select name="is_active" id="is_active" class="form-control">
                                <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>نشط</option>
                                <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>غير نشط</option>
                            </select>
                            @error('is_active')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-success">حفظ</button>
                        <a href="{{ route('transactions.all', $transaction) }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const subscribers = @json($clients);

        const subscriberInput = document.getElementById("subscriber_name");
        const subscriberHidden = document.getElementById("subscriber_id_hidden");
        const suggestionsBox = document.getElementById("subscriberSuggestions");

        const clientSelect = document.getElementById("client_id");

        subscriberInput.addEventListener("input", function() {
            const query = this.value.toLowerCase();
            suggestionsBox.innerHTML = '';
            subscriberHidden.value = '';

            if (query.length < 1) {
                suggestionsBox.style.display = 'none';
                return;
            }

            let filtered = subscribers.filter(sub => sub.name.toLowerCase().includes(query));

            if (filtered.length === 0) {
                suggestionsBox.style.display = 'none';
                return;
            }

            filtered.forEach(sub => {
                let item = document.createElement('button');
                item.type = 'button';
                item.className = 'list-group-item list-group-item-action';
                item.textContent = sub.name;
                item.onclick = function() {
                    subscriberInput.value = sub.name;
                    subscriberHidden.value = sub.id;

                    // تفريغ الموكلين وإعادة ملؤهم
                    clientSelect.innerHTML = '<option value="">اختر الموكل</option>';
                    clientSelect.disabled = true;

                    if (sub.user && sub.user.client && sub.user.client.length > 0) {
                        sub.user.client.forEach(client => {
                            let option = document.createElement("option");
                            option.value = client.name;
                            option.textContent = client.name;
                            clientSelect.appendChild(option);
                        });
                        clientSelect.disabled = false;
                    }

                    suggestionsBox.style.display = 'none';
                };
                suggestionsBox.appendChild(item);
            });

            suggestionsBox.style.display = 'block';
        });

        document.addEventListener('click', function(e) {
            if (!subscriberInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                suggestionsBox.style.display = 'none';
            }
        });
    });
</script>
