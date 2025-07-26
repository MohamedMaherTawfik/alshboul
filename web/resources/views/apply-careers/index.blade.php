@extends('layouts.app1')
@section('content')
    <div class="min-h-screen bg-[#011627] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-3xl font-extrabold text-[#D4AF37]">
                        {{ app()->getLocale() == 'ar' ? 'طلبات التوظيف' : 'Career Applications' }}
                    </h2>
                    <a href="{{ route('apply-careers.create') }}" 
                       class="bg-[#D4AF37] hover:bg-[#011627] text-white px-4 py-2 rounded-md font-medium">
                        {{ app()->getLocale() == 'ar' ? 'إضافة طلب جديد' : 'Add New Application' }}
                    </a>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ app()->getLocale() == 'ar' ? 'الاسم الكامل' : 'Full Name' }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ app()->getLocale() == 'ar' ? 'تاريخ الميلاد' : 'Birth Date' }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ app()->getLocale() == 'ar' ? 'الوظيفة' : 'Career' }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ app()->getLocale() == 'ar' ? 'الهاتف' : 'Phone' }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ app()->getLocale() == 'ar' ? 'السيرة الذاتية' : 'CV File' }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ app()->getLocale() == 'ar' ? 'الإجراءات' : 'Actions' }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($applyCareers as $applyCareer)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $applyCareer->full_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $applyCareer->brith_date }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ app()->getLocale() == 'ar' ? $applyCareer->career->name_ar : $applyCareer->career->name_en }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $applyCareer->phone }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($applyCareer->cv_file)
                                            <a href="{{ Storage::url('cv_files/' . $applyCareer->cv_file) }}" 
                                               target="_blank" 
                                               class="text-[#D4AF37] hover:text-[#011627]">
                                                {{ app()->getLocale() == 'ar' ? 'عرض الملف' : 'View File' }}
                                            </a>
                                        @else
                                            <span class="text-gray-400">{{ app()->getLocale() == 'ar' ? 'لا يوجد ملف' : 'No file' }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('apply-careers.show', $applyCareer->id) }}" 
                                           class="text-[#D4AF37] hover:text-[#011627] mr-3">
                                            {{ app()->getLocale() == 'ar' ? 'عرض' : 'View' }}
                                        </a>
                                        <a href="{{ route('apply-careers.edit', $applyCareer->id) }}" 
                                           class="text-blue-600 hover:text-blue-900 mr-3">
                                            {{ app()->getLocale() == 'ar' ? 'تعديل' : 'Edit' }}
                                        </a>
                                        <form action="{{ route('apply-careers.destroy', $applyCareer->id) }}" 
                                              method="POST" 
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('{{ app()->getLocale() == 'ar' ? 'هل أنت متأكد من الحذف؟' : 'Are you sure you want to delete?' }}')">
                                                {{ app()->getLocale() == 'ar' ? 'حذف' : 'Delete' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                        {{ app()->getLocale() == 'ar' ? 'لا توجد طلبات توظيف' : 'No career applications found' }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection 