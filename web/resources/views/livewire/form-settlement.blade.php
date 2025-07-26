 <div class="card-body">
     <form action="{{ route('settlement.store') }}" method="post">
         @csrf
         <input type="hidden" name="created_by" value="{{ Auth::user()->id }}">

         <div class="row">
             <div class="form-group col-md-4">
                 <label for="">نوع التسوية</label>
                 <input type="text" name="settlement_type" value="{{ old('settlement_type') }}" class="form-control"
                     placeholder="أدخل نوع التسوية">
                 @error('settlement_type')
                     <small class="text-muted text-danger">{{ $message }}</small>
                 @enderror
             </div>
             <div class="form-group col-md-4">
                 <label for="">اسم المحامي</label>
                 <select name="partner_id" class="form-control">
                     <option value="">-- اختر موظف --</option>
                     @foreach ($partners as $partner)
                         <option value="{{ $partner->id }}">{{ $partner->username }}</option>
                     @endforeach
                 </select>
                 @error('partner_id')
                     <small class="text-danger">{{ $message }}</small>
                 @enderror
             </div>
             <div class="form-group col-md-4">
                 <label for="">اسم الموكل</label>
                 <select wire:model.live="selectedClientId" name="client_id" class="form-control">
                     <option value="">-- اختر الموكل --</option>
                     @foreach ($clients as $client)
                         <option value="{{ $client->id }}">{{ $client->name }}</option>
                     @endforeach
                 </select>
                 @error('selectedClientId')
                     <small class="text-danger">{{ $message }}</small>
                 @enderror
             </div>
         </div>

         <div class="row">
             <div class="form-group col-md-4">
                 <label for="">الرقم الوطني للموكل</label>
                 <input type="text" class="form-control" name="client_national_id" value="{{ $nationalId }}"
                     readonly>
             </div>
             <div class="form-group col-md-4">
                 <label for="">اسم الخصم</label>
                 <input type="text" name="opponent_name" value="{{ old('opponent_name') }}" class="form-control"
                     placeholder="أدخل اسم الخصم">
                 @error('opponent_name')
                     <small class="text-muted text-danger">{{ $message }}</small>
                 @enderror
             </div>
             <div class="form-group col-md-4">
                 <label for="">الرقم الوطني للخصم</label>
                 <input type="text" name="opponent_national_id" value="{{ old('opponent_national_id') }}"
                     class="form-control" placeholder="أدخل الرقم الوطني للخصم">
                 @error('opponent_national_id')
                     <small class="text-muted text-danger">{{ $message }}</small>
                 @enderror
             </div>
         </div>

         <div class="row">
             <div class="form-group col-md-4">
                 <label for="">صفة الخصم</label>
                 <input type="text" name="opponent_status" value="{{ old('opponent_status') }}" class="form-control"
                     placeholder="أدخل صفة الخصم">
                 @error('opponent_status')
                     <small class="text-muted text-danger">{{ $message }}</small>
                 @enderror
             </div>
             <div class="form-group col-md-4">
                 <label for="">الالتزام</label>
                 <input type="text" name="obligation" value="{{ old('obligation') }}" class="form-control"
                     placeholder="أدخل الالتزام">
                 @error('obligation')
                     <small class="text-muted text-danger">{{ $message }}</small>
                 @enderror
             </div>
             <div class="form-group col-md-4">
                 <label for="">رقم الملف</label>
                 <input type="text" name="file_number" value="{{ old('file_number') }}" class="form-control"
                     placeholder="أدخل رقم الملف">
                 @error('file_number')
                     <small class="text-muted text-danger">{{ $message }}</small>
                 @enderror
             </div>
         </div>

         <div class="row">
             <div class="form-group col-md-4">
                 <label for="">عنوان الخصم</label>
                 <input type="text" name="opponent_address" value="{{ old('opponent_address') }}"
                     class="form-control" placeholder="أدخل عنوان الخصم">
                 @error('opponent_address')
                     <small class="text-muted text-danger">{{ $message }}</small>
                 @enderror
             </div>
             <div class="form-group col-md-4">
                 <label for="">هاتف الخصم</label>
                 <input type="text" name="opponent_phone" value="{{ old('opponent_phone') }}" class="form-control"
                     placeholder="أدخل هاتف الخصم">
                 @error('opponent_phone')
                     <small class="text-muted text-danger">{{ $message }}</small>
                 @enderror
             </div>
             <div class="form-group col-md-4">
                 <label for="">قيمة التسوية</label>
                 <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" class="form-control"
                     placeholder="أدخل قيمة التسوية">
                 @error('amount')
                     <small class="text-muted text-danger">{{ $message }}</small>
                 @enderror
             </div>
         </div>

         <div class="row">
             <div class="form-group col-md-6">
                 <label for="">دفعات السداد</label>
                 <input type="text" name="payment_terms" value="{{ old('payment_terms') }}" class="form-control"
                     placeholder="أدخل دفعات السداد">
                 @error('payment_terms')
                     <small class="text-muted text-danger">{{ $message }}</small>
                 @enderror
             </div>
             <div class="form-group col-md-6">
                 <label for="">الحالة</label>
                 <select name="status" class="form-control">
                     <option value="">اختر الحالة</option>
                     <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>نشط
                     </option>
                     <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>مؤرشف
                     </option>
                     <option value="canceled" {{ old('status') == 'canceled' ? 'selected' : '' }}>ملغي</option>
                 </select>
                 @error('status')
                     <small class="text-muted text-danger">{{ $message }}</small>
                 @enderror
             </div>
         </div>

         <div class="row">
             <div class="form-group col-md-12">
                 <label for="">ملاحظات</label>
                 <textarea name="notes" class="form-control" rows="3" placeholder="أدخل الملاحظات">{{ old('notes') }}</textarea>
                 @error('notes')
                     <small class="text-muted text-danger">{{ $message }}</small>
                 @enderror
             </div>
         </div>

         <div class="text-center col-md-12">
             <button type="submit" class="btn btn-success">إضافة</button>
         </div>
     </form>
 </div>
