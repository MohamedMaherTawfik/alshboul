<div class="card">
    <div class="card-header">
        <h3 class="card-title">تعديل التسوية</h3>
    </div>
    <div class="card-body">
        <form wire:submit.prevent="save">
            <div class="row">
                <div class="form-group col-md-4">
                    <label>المستخدم</label>
                    <select wire:model.live="user_id" class="form-control">
                        <option value="">اختر المستخدم</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name ?? $user->username }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
              
                <div class="form-group col-md-4">
                    <label>الموكل</label>
                    <select wire:model.live="client_id" class="form-control">
                        <option value="">اختر الموكل</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" {{ $client_id == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}</option>
                        @endforeach
                    </select>
                    @error('client_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label>الرقم الوطني للموكل</label>
                    <input type="text" wire:model="client_national_id" class="form-control" readonly>
                    @error('client_national_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label>اسم الخصم</label>
                    <input type="text" wire:model="opponent_name" class="form-control">
                    @error('opponent_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label>الرقم الوطني للخصم</label>
                    <input type="text" wire:model="opponent_national_id" class="form-control">
                    @error('opponent_national_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label>نوع التسوية</label>
                    <select wire:model="settlement_type_id" class="form-control">
                        <option value="">اختر النوع</option>
                        @foreach ($settlementTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name_ar }}</option>
                        @endforeach
                    </select>
                    @error('settlement_type_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label>صفة  الموكل</label>
                    <input type="text" wire:model="judged_for_role" class="form-control">
                    @error('judged_for_role')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label>صفة  الخصم</label>
                    <input type="text" wire:model="judged_against_role" class="form-control">
                    @error('judged_against_role')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label>حالة الالتزام</label>
                    <input type="radio" wire:model.live="commitment_status" value="ملتزم">ملتزم
                    <input type="radio" wire:model.live="commitment_status" value="غير ملتزم">غير ملتزم
                    @error('commitment_status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label>هاتف الخصم</label>
                    <input type="text" wire:model="opponent_phone" class="form-control">
                    @error('opponent_phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label>رقم ملف المكتب</label>
                    <input type="text" wire:model="office_file_number" class="form-control" readonly>
                    @error('office_file_number')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label>رقم الدعوى</label>
                    <input type="text" wire:model="lawsuit_number" class="form-control">
                    @error('lawsuit_number')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label>العنوان</label>
                    <input type="text" wire:model="address" class="form-control">
                    @error('address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label>قيمة الدين</label>
                    <input type="number" wire:model="debt_value" class="form-control">
                    @error('debt_value')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label>قيمة السداد</label>
                    <input type="number" wire:model="payment_value" class="form-control">
                    @error('payment_value')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label>تفاصيل التسوية</label>
                    <textarea wire:model="settlement_details" class="form-control"></textarea>
                    @error('settlement_details')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label>نوع التقسيط</label>
                    <input type="radio" wire:model.live="installment_type" value="أسبوعي">أسبوعي
                    <input type="radio" wire:model.live="installment_type" value="شهري">شهري
                    @error('installment_type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="text-center col-md-12">
                <button type="submit" class="btn btn-success">تحديث</button>
            </div>
        </form>
    </div>
</div>
