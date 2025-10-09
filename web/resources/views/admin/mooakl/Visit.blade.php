@extends('layouts.admin')
@section('title', 'زيارات الموكلين')
@section('main_title_content', 'بيانات زيارات الموكلين آخر شهر')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('client.visit') }}">موكلين</a>
@endsection

@section('content')
    <div class="bg-gray-50 min-h-screen p-6">
        <div class="bg-white rounded-2xl shadow-lg p-8 max-w-6xl mx-auto border border-gray-200">
            <!-- العنوان -->
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-2xl font-extrabold text-[#1e293b]">بيانات زيارات الموكلين آخر شهر</h3>
                <div class="bg-[#0d6efd]/10 text-[#0d6efd] px-4 py-2 rounded-full text-sm font-semibold">
                    {{ $data->count() }} موكل
                </div>
            </div>

            <!-- صف البحث -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div>
                    <label for="searchId" class="block text-sm font-medium text-gray-600 mb-1">رقم الموكل</label>
                    <input type="text" id="searchId"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#0d6efd]"
                        placeholder="اكتب رقم الموكل...">
                </div>
                <div>
                    <label for="searchName" class="block text-sm font-medium text-gray-600 mb-1">اسم الموكل</label>
                    <input type="text" id="searchName"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#0d6efd]"
                        placeholder="اكتب اسم الموكل...">
                </div>
            </div>

            <!-- كارت إجمالي الزيارات -->
            <div class="flex justify-center mb-8">
                <div
                    class="bg-gradient-to-r from-[#0d6efd] to-[#2563eb] text-white rounded-xl p-6 w-full md:w-1/3 text-center shadow-md">
                    <div class="flex flex-col items-center">
                        <div class="text-sm opacity-80 mb-1">إجمالي زيارات الموكلين</div>
                        <div class="flex items-center justify-center gap-2">
                            <div class="text-4xl font-bold">{{ $data->sum('visit_count') ?? 0 }}</div>
                            <div class="bg-white/20 rounded-full p-2">
                                <i class="fas fa-eye text-white text-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- الجدول -->
            <div class="overflow-x-auto rounded-lg shadow-sm border border-gray-200">
                <table class="min-w-full text-right text-gray-700">
                    <thead class="bg-[#0d6efd]/10 text-[#0d6efd] font-semibold text-sm uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3 border-b">رقم الموكل</th>
                            <th class="px-6 py-3 border-b">اسم الموكل</th>
                            <th class="px-6 py-3 border-b">عدد الزيارات</th>
                        </tr>
                    </thead>
                    <tbody id="clientsTable" class="divide-y divide-gray-100">
                        @forelse ($data as $client)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-3">{{ $client->id }}</td>
                                <td class="px-6 py-3 font-medium text-gray-800">{{ $client->name }}</td>
                                <td class="px-6 py-3 text-center">{{ $client->visit_count ?? 0 }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-gray-500 py-4">لا توجد بيانات</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const searchId = document.getElementById('searchId');
        const searchName = document.getElementById('searchName');
        const rows = document.querySelectorAll('#clientsTable tr');

        function filterTable() {
            const idQuery = searchId.value.trim().toLowerCase();
            const nameQuery = searchName.value.trim().toLowerCase();

            rows.forEach(row => {
                const id = row.cells[0]?.textContent.trim().toLowerCase() || '';
                const name = row.cells[1]?.textContent.trim().toLowerCase() || '';

                if ((id.includes(idQuery) || idQuery === '') &&
                    (name.includes(nameQuery) || nameQuery === '')) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        searchId.addEventListener('keyup', filterTable);
        searchName.addEventListener('keyup', filterTable);
    </script>
@endsection
