<div>
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ session('message') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">إضافة قضية تنفيذية جديدة</h3>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="row">
                    <!-- المشترك -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="subscriber_name">رقم المشترك</label>
                            <input type="text" wire:model="user_id"
                                class="form-control @error('user_id') is-invalid @enderror" placeholder="رقم المشترك"
                                readonly>
                            @error('subscriber_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="user_id">المشترك</label>
                            <select wire:model.live="user_id"
                                class="form-control @error('user_id') is-invalid @enderror">
                                <option value="" selected>اختر المشترك</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <!-- الموكل -->
                    @if ($clients->count() > 0)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="client_id">الموكل</label>
                                <select wire:model.live="client_id"
                                    class="form-control @error('client_id') is-invalid @enderror">
                                    <option value="" selected>اختر الموكل</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @else
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="client_name">الموكل</label>
                                <input wire:model="client_name"
                                    class="form-control @error('client_name') is-invalid @enderror"
                                    placeholder=" اسم للموكل">
                                @error('client_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    @endif

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="client_national_id">الرقم الوطني للموكل</label>
                            <input type="text" wire:model="client_national_id"
                                class="form-control @error('client_national_id') is-invalid @enderror"
                                placeholder="الرقم الوطني للموكل" readonly>
                            @error('client_national_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="client_national_id1">الرقم الوطني للموكل</label>
                            <input type="text" wire:model="client_national_id1"
                                class="form-control @error('client_national_id1') is-invalid @enderror"
                                placeholder="الرقم الوطني للموكل">
                            @error('client_national_id1')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- الخصم -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="opponent_name">اسم الخصم</label>
                            <input type="text" wire:model="opponent_name"
                                class="form-control @error('opponent_name') is-invalid @enderror"
                                placeholder="اسم الخصم">
                            @error('opponent_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="opponent_national_id">الرقم الوطني للخصم</label>
                            <input type="text" wire:model="opponent_national_id"
                                class="form-control @error('opponent_national_id') is-invalid @enderror"
                                placeholder="الرقم الوطني للخصم">
                            @error('opponent_national_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- أرقام الملفات -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="office_file_number">رقم الملف المكتبي</label>
                            <input type="number" wire:model.live="office_file_number"
                                class="form-control @error('office_file_number') is-invalid @enderror"
                                placeholder="رقم الملف المكتبي">
                            @error('office_file_number')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="lawsuit_number">رقم الدعوى</label>
                            <input type="text" wire:model="lawsuit_number"
                                class="form-control @error('lawsuit_number') is-invalid @enderror"
                                placeholder="رقم الدعوى">
                            @error('lawsuit_number')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="suggested_file_number">رقم الملف المقترح</label>
                            <input type="number" wire:model="suggested_file_number" disabled
                                class="form-control @error('suggested_file_number') is-invalid @enderror"
                                placeholder="رقم الملف المقترح">
                            @error('suggested_file_number')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- حالة القضية -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="case_status">حالة القضية</label>
                            <select wire:model="case_status"
                                class="form-control @error('case_status') is-invalid @enderror">
                                <option value="">اختر حالة القضية</option>
                                <option value="تنفيذية">تنفيذية</option>
                                <option value="منتهية">منتهية</option>
                                <option value="موقوفة">موقوفة</option>
                                <option value="قضية تنفيذية بإنابة">قضية تنفيذية بإنابة</option>
                            </select>
                            @error('case_status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="claim_value">قيمة الدعوى</label>
                            <input type="number" step="0.01" wire:model="claim_value"
                                class="form-control @error('claim_value') is-invalid @enderror"
                                placeholder="قيمة الدعوى">
                            @error('claim_value')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- معلومات التنفيذ -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="execution_department">الدائرة التنفيذية</label>
                            <input type="text" wire:model="execution_department"
                                class="form-control @error('execution_department') is-invalid @enderror"
                                placeholder="الدائرة التنفيذية">
                            @error('execution_department')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="document_type">نوع السند التنفيذي</label>
                            <input type="text" wire:model="document_type"
                                class="form-control @error('document_type') is-invalid @enderror"
                                placeholder="نوع السند التنفيذي">
                            @error('document_type')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- المحكوم له -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="judged_for">المحكوم له</label>
                            <input type="text" wire:model="judged_for"
                                class="form-control @error('judged_for') is-invalid @enderror"
                                placeholder="المحكوم له">
                            @error('judged_for')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="judged_for_role">صفة المحكوم له</label>
                            <input type="text" wire:model="judged_for_role"
                                class="form-control @error('judged_for_role') is-invalid @enderror"
                                placeholder="صفة المحكوم له">
                            @error('judged_for_role')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- المحكوم عليه -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="judged_against">المحكوم عليه</label>
                            <input type="text" wire:model="judged_against"
                                class="form-control @error('judged_against') is-invalid @enderror"
                                placeholder="المحكوم عليه">
                            @error('judged_against')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="judged_against_role">صفة المحكوم عليه</label>
                            <input type="text" wire:model="judged_against_role"
                                class="form-control @error('judged_against_role') is-invalid @enderror"
                                placeholder="صفة المحكوم عليه">
                            @error('judged_against_role')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- التواريخ والأرقام -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="registration_date">تاريخ التسجيل</label>
                            <input type="date" wire:model="registration_date"
                                class="form-control @error('registration_date') is-invalid @enderror">
                            @error('registration_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="document_number">رقم السند التنفيذي</label>
                            <input type="text" wire:model="document_number"
                                class="form-control @error('document_number') is-invalid @enderror"
                                placeholder="رقم السند التنفيذي">
                            @error('document_number')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="session_date">تاريخ الجلسة الاجرائية </label>
                            <input type="date" wire:model="session_date"
                                class="form-control @error('session_date') is-invalid @enderror"
                                placeholder="تاريخ الجلسة الاجرائية">
                            @error('session_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-center form-group">
                    <button type="submit" class="btn btn-primary">حفظ القضية</button>
                </div>
            </form>
        </div>
    </div>
</div>
