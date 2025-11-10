@extends('layouts.admin')

@section('title', 'تعديل وكالة')
@section('main_title_content', 'تعديل وكالة')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="{{ route('agencies.index', $main->main_agencies_id) }}">قائمة الوكالات</a>
@endsection

@section('content')
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h5>تعديل الوكالة لـ {{ $main->user->name ?? '' }}</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('agencies.update', $main->id) }}" method="POST">
                @csrf

                <div class="row">
                    <!-- المستخدم مع autocomplete -->
                    <div class="col-md-6 mb-3 position-relative">
                        <label for="user_name" class="form-label">المستخدم</label>
                        <input type="text" name="user_name" id="user_name"
                            class="form-control @error('user_id') is-invalid @enderror"
                            value="{{ old('user_name', $main->user->name ?? '') }}" autocomplete="off" required>
                        <input type="hidden" name="user_id" id="user_id" value="{{ old('user_id', $main->user_id) }}">
                        <div id="userList" class="list-group position-absolute w-100"
                            style="z-index: 1000; max-height:200px; overflow-y:auto;"></div>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="lawyers" class="form-label">المحامي</label>
                        <input type="text" name="lawyers" id="lawyers"
                            class="form-control @error('lawyers') is-invalid @enderror"
                            value="{{ old('lawyers', $main->lawyers) }}" required>
                        @error('lawyers')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- موضوع الدعوى يأخذ السطر كامل -->
                    <div class="col-12 mb-3">
                        <label for="letter" class="form-label">موضوع الدعوى</label>
                        <input type="text" name="letter" id="letter"
                            class="form-control form-control-lg @error('letter') is-invalid @enderror"
                            value="{{ old('letter', $main->letter) }}" required>
                        @error('letter')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="opponents" class="form-label">اسم الخصم</label>
                        <input type="text" name="opponents" id="opponents"
                            class="form-control @error('opponents') is-invalid @enderror"
                            value="{{ old('opponents', $main->opponents) }}" required>
                        @error('opponents')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="court" class="form-label">اسم المحكمة</label>
                        <input type="text" name="court" id="court"
                            class="form-control @error('court') is-invalid @enderror"
                            value="{{ old('court', $main->court) }}" required>
                        @error('court')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="for" class="form-label">و لدي</label>
                        <input type="text" name="for" id="for"
                            class="form-control @error('for') is-invalid @enderror" value="{{ old('for', $main->for) }}"
                            required>
                        @error('for')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="created_at" class="form-label">تاريخ الإدخال</label>
                        <input type="date" name="created_at" id="created_at"
                            class="form-control @error('created_at') is-invalid @enderror"
                            value="{{ old('created_at', $main->created_at ? $main->created_at->format('Y-m-d') : now()->format('Y-m-d')) }}">
                        @error('created_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-success">تحديث الوكالة</button>
                <a href="{{ route('agencies.index', $main->main_agencies_id) }}" class="btn btn-secondary">إلغاء</a>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const userInput = document.getElementById("user_name");
            const userHidden = document.getElementById("user_id");
            const userList = document.getElementById("userList");
            const users = @json($users);

            userInput.addEventListener("input", function() {
                const query = this.value.toLowerCase();
                userList.innerHTML = "";
                userHidden.value = "";

                if (query.length < 1) return userList.style.display = "none";

                const filtered = users.filter(user => user.name.toLowerCase().includes(query));
                if (!filtered.length) return userList.style.display = "none";

                filtered.forEach(user => {
                    const item = document.createElement("button");
                    item.type = "button";
                    item.className = "list-group-item list-group-item-action";
                    item.textContent = user.name;
                    item.onclick = () => {
                        userInput.value = user.name;
                        userHidden.value = user.id;
                        userList.style.display = "none";
                    };
                    userList.appendChild(item);
                });
                userList.style.display = "block";
            });
        });
    </script>
@endsection
