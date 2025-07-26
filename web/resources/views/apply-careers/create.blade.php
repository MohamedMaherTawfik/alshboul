@extends('layouts.app1')
@section('content')
    <div class="min-h-screen flex items-center justify-center bg-[#011627] py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md p-8 space-y-8 bg-white rounded-lg shadow-lg">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-[#D4AF37]">
                    {{ app()->getLocale() == 'ar' ? 'تقديم طلب توظيف' : 'Submit Career Application' }}
                </h2>
            </div>
            <form class="mt-8 space-y-6" action="{{ route('apply-careers.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700">
                            {{ app()->getLocale() == 'ar' ? 'الاسم الكامل' : 'Full Name' }}
                        </label>
                        <input id="full_name" name="full_name" type="text" required
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#D4AF37] focus:border-[#D4AF37] focus:z-10 sm:text-sm"
                            placeholder="{{ app()->getLocale() == 'ar' ? 'أدخل الاسم الكامل' : 'Enter full name' }}"
                            value="{{ old('full_name') }}">
                        @error('full_name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="brith_date" class="block text-sm font-medium text-gray-700">
                            {{ app()->getLocale() == 'ar' ? 'تاريخ الميلاد' : 'Birth Date' }}
                        </label>
                        <input id="brith_date" name="brith_date" type="date" required
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#D4AF37] focus:border-[#D4AF37] focus:z-10 sm:text-sm"
                            value="{{ old('brith_date') }}">
                        @error('brith_date')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="career_id" class="block text-sm font-medium text-gray-700">
                            {{ app()->getLocale() == 'ar' ? 'الوظيفة' : 'Career' }}
                        </label>
                        <select id="career_id" name="career_id" required
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#D4AF37] focus:border-[#D4AF37] focus:z-10 sm:text-sm">
                            <option value="">{{ app()->getLocale() == 'ar' ? 'اختر الوظيفة' : 'Select Career' }}
                            </option>
                            @foreach ($careers as $career)
                                <option value="{{ $career->id }}"
                                    {{ old('career_id') == $career->id ? 'selected' : '' }}>
                                    {{ app()->getLocale() == 'ar' ? $career->name_ar : $career->name_en }}
                                </option>
                            @endforeach
                        </select>
                        @error('career_id')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">
                            {{ app()->getLocale() == 'ar' ? 'رقم الهاتف' : 'Phone Number' }}
                        </label>
                        <input id="phone" name="phone" type="text" required
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#D4AF37] focus:border-[#D4AF37] focus:z-10 sm:text-sm"
                            placeholder="{{ app()->getLocale() == 'ar' ? 'أدخل رقم الهاتف' : 'Enter phone number' }}"
                            value="{{ old('phone') }}">
                        @error('phone')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="cv_file" class="block text-sm font-medium text-gray-700">
                            {{ app()->getLocale() == 'ar' ? 'السيرة الذاتية' : 'CV File' }}
                        </label>
                        <input id="cv_file" name="cv_file" type="file" required
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#D4AF37] focus:border-[#D4AF37] focus:z-10 sm:text-sm"
                            accept=".pdf,.doc,.docx">
                        <p class="mt-1 text-xs text-gray-500">
                            {{ app()->getLocale() == 'ar' ? 'الملفات المسموحة: PDF, DOC, DOCX (الحد الأقصى: 2MB)' : 'Allowed files: PDF, DOC, DOCX (Max: 2MB)' }}
                        </p>
                        @error('cv_file')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#D4AF37] hover:bg-[#011627] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#D4AF37]">
                        {{ app()->getLocale() == 'ar' ? 'إرسال الطلب' : 'Submit Application' }}
                    </button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <a href="{{ route('home') }}" class="font-medium text-[#D4AF37] hover:text-[#011627]">
                    {{ app()->getLocale() == 'ar' ? 'العودة إلى القائمة' : 'Back to List' }}
                </a>
            </div>
        </div>
    </div>
@endsection
