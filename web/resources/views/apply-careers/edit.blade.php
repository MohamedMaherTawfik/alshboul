@extends('layouts.app1')
@section('content')
    <div class="min-h-screen flex items-center justify-center bg-[#011627] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-lg">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-[#D4AF37]">
                    {{ app()->getLocale() == 'ar' ? 'تعديل طلب التوظيف' : 'Edit Career Application' }}
                </h2>
            </div>
            <form class="mt-8 space-y-6" action="{{ route('apply-careers.update', $applyCareer->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700">
                            {{ app()->getLocale() == 'ar' ? 'الاسم الكامل' : 'Full Name' }}
                        </label>
                        <input id="full_name" name="full_name" type="text" required
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#D4AF37] focus:border-[#D4AF37] focus:z-10 sm:text-sm"
                            placeholder="{{ app()->getLocale() == 'ar' ? 'أدخل الاسم الكامل' : 'Enter full name' }}"
                            value="{{ old('full_name', $applyCareer->full_name) }}">
                        @error('full_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="brith_date" class="block text-sm font-medium text-gray-700">
                            {{ app()->getLocale() == 'ar' ? 'تاريخ الميلاد' : 'Birth Date' }}
                        </label>
                        <input id="brith_date" name="brith_date" type="date" required
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#D4AF37] focus:border-[#D4AF37] focus:z-10 sm:text-sm"
                            value="{{ old('brith_date', $applyCareer->brith_date) }}">
                        @error('brith_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="career_id" class="block text-sm font-medium text-gray-700">
                            {{ app()->getLocale() == 'ar' ? 'الوظيفة' : 'Career' }}
                        </label>
                        <select id="career_id" name="career_id" required
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#D4AF37] focus:border-[#D4AF37] focus:z-10 sm:text-sm">
                            <option value="">{{ app()->getLocale() == 'ar' ? 'اختر الوظيفة' : 'Select Career' }}</option>
                            @foreach($careers as $career)
                                <option value="{{ $career->id }}" {{ (old('career_id', $applyCareer->career_id) == $career->id) ? 'selected' : '' }}>
                                    {{ app()->getLocale() == 'ar' ? $career->name_ar : $career->name_en }}
                                </option>
                            @endforeach
                        </select>
                        @error('career_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">
                            {{ app()->getLocale() == 'ar' ? 'رقم الهاتف' : 'Phone Number' }}
                        </label>
                        <input id="phone" name="phone" type="text" required
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#D4AF37] focus:border-[#D4AF37] focus:z-10 sm:text-sm"
                            placeholder="{{ app()->getLocale() == 'ar' ? 'أدخل رقم الهاتف' : 'Enter phone number' }}"
                            value="{{ old('phone', $applyCareer->phone) }}">
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="cv_file" class="block text-sm font-medium text-gray-700">
                            {{ app()->getLocale() == 'ar' ? 'السيرة الذاتية' : 'CV File' }}
                        </label>
                        @if($applyCareer->cv_file)
                            <div class="mb-2">
                                <p class="text-sm text-gray-600">
                                    {{ app()->getLocale() == 'ar' ? 'الملف الحالي:' : 'Current file:' }}
                                    <a href="{{ Storage::url('cv_files/' . $applyCareer->cv_file) }}" 
                                       target="_blank" 
                                       class="text-[#D4AF37] hover:text-[#011627]">
                                        {{ $applyCareer->cv_file }}
                                    </a>
                                </p>
                            </div>
                        @endif
                        <input id="cv_file" name="cv_file" type="file"
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#D4AF37] focus:border-[#D4AF37] focus:z-10 sm:text-sm"
                            accept=".pdf,.doc,.docx">
                        <p class="text-xs text-gray-500 mt-1">
                            {{ app()->getLocale() == 'ar' ? 'الملفات المسموحة: PDF, DOC, DOCX (الحد الأقصى: 2MB) - اتركه فارغاً للاحتفاظ بالملف الحالي' : 'Allowed files: PDF, DOC, DOCX (Max: 2MB) - Leave empty to keep current file' }}
                        </p>
                        @error('cv_file')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#D4AF37] hover:bg-[#011627] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#D4AF37]">
                        {{ app()->getLocale() == 'ar' ? 'تحديث الطلب' : 'Update Application' }}
                    </button>
                </div>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('apply-careers.index') }}" 
                   class="font-medium text-[#D4AF37] hover:text-[#011627]">
                    {{ app()->getLocale() == 'ar' ? 'العودة إلى القائمة' : 'Back to List' }}
                </a>
            </div>
        </div>
    </div>
@endsection 