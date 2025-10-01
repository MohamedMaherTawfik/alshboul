@extends('layouts.admin')

@section('title', 'المهام')
@section('main_title_content', 'قائمة المهام')
@section('title_content', 'عرض')

@section('link_content')
    <a href="{{ route('mission.unfinished') }}">المهام</a>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- زر الرجوع -->
        <a href="{{ route('mission.unfinished') }}" class="btn btn-secondary mb-3">
            <i class="fas fa-arrow-left"></i> رجوع
        </a>

        <!-- كرت النموذج -->
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-plus-circle"></i> إضافة مهمه جديده</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('mission.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- العمود الشمال -->
                        <div class="col-md-6">
                            <!-- Client (Autocomplete) -->
                            <div class="mb-3 position-relative">
                                <label for="client_name" class="form-label">اختر اسم الموكل هنا</label>
                                <input type="text" id="client_name" class="form-control" placeholder="اكتب اسم الموكل"
                                    autocomplete="off" required>
                                <input type="hidden" name="client_id" id="client_id">
                                <!-- الاقتراحات -->
                                <div id="client_suggestions" class="list-group position-absolute w-100"
                                    style="z-index: 1000; max-height: 200px; overflow-y: auto; display: none;">
                                </div>
                            </div>

                            <!-- Lawyer 1-->
                            <div class="mb-3">
                                <label for="lawyer1" class="form-label">اختر المحامي الاول</label>
                                <select name="first_lawyer_id_user" id="lawyer1" class="form-control" required>
                                    <option value="">-- اختر المحامي --</option>
                                    @foreach ($lawyers as $lawyer)
                                        <option value="{{ $lawyer->id }}">{{ $lawyer->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Lawyer 2-->
                            <div class="mb-3">
                                <label for="lawyer2" class="form-label">اختر المحامي الثاني</label>
                                <select name="second_lawyer_id_user" id="lawyer2" class="form-control" required>
                                    <option value="">-- اختر المحامي --</option>
                                    @foreach ($lawyers as $lawyer)
                                        <option value="{{ $lawyer->id }}">{{ $lawyer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- العمود اليمين -->
                        <div class="col-md-6">
                            <!-- Deadline -->
                            <div class="mb-3">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="deadlineCheck">
                                    <label class="form-check-label" for="deadlineCheck">إضافة موعد نهائي</label>
                                </div>
                                <div id="deadlineWrapper" style="display: none;">
                                    <label for="deadline" class="form-label">اختر الموعد النهائي:</label>
                                    <input type="date" id="deadline" name="deadline" class="form-control">
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">الوصف</label>
                                <input type="text" name="description" id="description" class="form-control">
                            </div>

                            <!-- File Input -->
                            <div class="mb-3">
                                <label for="file" class="form-label">إرفاق ملف</label>
                                <input type="file" name="file" id="file" class="form-control">
                            </div>
                        </div>
                    </div>

                    <!-- زر الإرسال -->
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> حفظ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkbox = document.getElementById('deadlineCheck');
            const deadlineWrapper = document.getElementById('deadlineWrapper');
            checkbox.addEventListener('change', function() {
                deadlineWrapper.style.display = this.checked ? 'block' : 'none';
            });

            // Autocomplete للموكل
            const clientInput = document.getElementById("client_name");
            const clientHidden = document.getElementById("client_id");
            const suggestionsBox = document.getElementById("client_suggestions");

            const clients = @json($clients);

            clientInput.addEventListener("input", function() {
                const query = this.value.toLowerCase();
                suggestionsBox.innerHTML = "";
                clientHidden.value = "";

                if (query.length < 1) {
                    suggestionsBox.style.display = "none";
                    return;
                }

                let filtered = clients.filter(client => client.name.toLowerCase().includes(query));

                if (filtered.length === 0) {
                    suggestionsBox.style.display = "none";
                    return;
                }

                filtered.forEach(client => {
                    let item = document.createElement("button");
                    item.type = "button";
                    item.className = "list-group-item list-group-item-action";
                    item.textContent = client.name;
                    item.onclick = function() {
                        clientInput.value = client.name;
                        clientHidden.value = client.id;
                        suggestionsBox.style.display = "none";
                    };
                    suggestionsBox.appendChild(item);
                });

                suggestionsBox.style.display = "block";
            });

            document.addEventListener("click", function(e) {
                if (!clientInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                    suggestionsBox.style.display = "none";
                }
            });
        });
    </script>
@endsection
