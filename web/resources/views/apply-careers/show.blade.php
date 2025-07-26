@extends('layouts.app1')
@section('content')
    <div class="min-h-screen flex items-center justify-center bg-[#011627] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-lg">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-[#D4AF37]">
                    {{ app()->getLocale() == 'ar' ? 'تفاصيل طلب التوظيف' : 'Career Application Details' }}
                </h2>
            </div>
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        {{ app()->getLocale() == 'ar' ? 'الاسم الكامل' : 'Full Name' }}
                    </label>
                    <p class="mt-1 text-sm text-gray-900">{{ $applyCareer->full_name }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        {{ app()->getLocale() == 'ar' ? 'تاريخ الميلاد' : 'Birth Date' }}
                    </label>
                    <p class="mt-1 text-sm text-gray-900">{{ $applyCareer->brith_date }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        {{ app()->getLocale() == 'ar' ? 'الوظيفة' : 'Career' }}
                    </label>
                    <p class="mt-1 text-sm text-gray-900">
                        {{ app()->getLocale() == 'ar' ? $applyCareer->career->name_ar : $applyCareer->career->name_en }}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        {{ app()->getLocale() == 'ar' ? 'رقم الهاتف' : 'Phone Number' }}
                    </label>
                    <p class="mt-1 text-sm text-gray-900">{{ $applyCareer->phone }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        {{ app()->getLocale() == 'ar' ? 'السيرة الذاتية' : 'CV File' }}
                    </label>
                    @if($applyCareer->cv_file)
                        <div class="mt-1">
                            <a href="{{ Storage::url('cv_files/' . $applyCareer->cv_file) }}" 
                               target="_blank" 
                               class="text-[#D4AF37] hover:text-[#011627] font-medium">
                                {{ app()->getLocale() == 'ar' ? 'عرض الملف' : 'View File' }}
                            </a>
                        </div>
                    @else
                        <p class="mt-1 text-sm text-gray-500">
                            {{ app()->getLocale() == 'ar' ? 'لا يوجد ملف' : 'No file uploaded' }}
                        </p>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        {{ app()->getLocale() == 'ar' ? 'تاريخ التقديم' : 'Application Date' }}
                    </label>
                    <p class="mt-1 text-sm text-gray-900">{{ $applyCareer->created_at->format('Y-m-d H:i:s') }}</p>
                </div>
            </div>

            <div class="flex space-x-4">
                <a href="{{ route('apply-careers.edit', $applyCareer->id) }}"
                   class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium text-center">
                    {{ app()->getLocale() == 'ar' ? 'تعديل' : 'Edit' }}
                </a>
                <a href="{{ route('apply-careers.index') }}"
                   class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium text-center">
                    {{ app()->getLocale() == 'ar' ? 'العودة' : 'Back' }}
                </a>
            </div>
        </div>
    </div>
@endsection 