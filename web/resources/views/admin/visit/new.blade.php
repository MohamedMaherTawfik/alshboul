@extends('layouts.admin')
@section('title', 'الزيارات')
@section('main_title_content', 'قائمة الزيارات')
@section('title_content', 'عرض')

@section('content')
    <div class="fixed inset-0 bg-gray-50 flex flex-col overflow-auto z-0">
        <div class="flex-1 w-full bg-white shadow-md rounded-none p-8 border border-gray-200 flex flex-col">

            <!-- ✅ رأس الصفحة -->
            <div class="flex flex-col md:flex-row justify-between items-center border-b pb-4 mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-1">زيارات الموكلين</h2>
                    <p class="text-gray-500 text-sm">عرض بيانات زيارات الموكلين خلال الشهر الماضي</p>
                </div>
                <div class="bg-blue-100 text-blue-700 px-5 py-2 rounded-full text-sm font-semibold shadow-sm mt-4 md:mt-0">
                    {{ $data->count() }} موكل
                </div>
            </div>

            <!-- ✅ خانات البحث -->
            <div class="bg-gray-50 rounded-xl p-6 mb-8 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fas fa-search text-blue-600"></i>
                    بحث عن الموكلين
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="searchId" class="block text-sm text-gray-600 mb-1">رقم الموكل</label>
                        <input type="text" id="searchId"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            placeholder="اكتب رقم الموكل...">
                    </div>
                    <div>
                        <label for="searchName" class="block text-sm text-gray-600 mb-1">اسم الموكل</label>
                        <input type="text" id="searchName"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            placeholder="اكتب اسم الموكل...">
                    </div>
                </div>
            </div>

            <!-- ✅ كارت إجمالي الزيارات -->
            <div class="flex justify-center mb-10">
                <div
                    class="bg-gradient-to-r from-blue-700 to-blue-500 text-white rounded-xl p-6 w-full md:w-1/2 lg:w-1/3 shadow-md text-center">
                    <div class="flex flex-col items-center">
                        <div class="text-sm opacity-90 mb-1">إجمالي عدد الزيارات</div>
                        <div class="flex items-center justify-center gap-3">
                            <div class="text-4xl font-extrabold">{{ $data->sum('visit_count') ?? 0 }}</div>
                            <div class="bg-white/25 rounded-full p-2">
                                <i class="fas fa-eye text-white text-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ✅ جدول عرض الموكلين -->
            <div class="overflow-auto rounded-lg border border-gray-200 flex-1">
                <table class="min-w-full text-right text-sm text-gray-800">
                    <thead class="bg-blue-600 text-white sticky top-0">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-sm">رقم الموكل</th>
                            <th class="px-6 py-3 font-semibold text-sm">اسم الموكل</th>
                            <th class="px-6 py-3 font-semibold text-sm text-center">عدد الزيارات</th>
                        </tr>
                    </thead>
                    <tbody id="clientsTable" class="divide-y divide-gray-100 bg-white">
                        @forelse ($data as $client)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-3">{{ $client->id }}</td>
                                <td class="px-6 py-3 font-medium">{{ $client->name }}</td>
                                <td class="px-6 py-3 text-center">
                                    @if ($client->visitWeb && $client->visitWeb->isNotEmpty())
                                        {{ $client->visitWeb->first()->created_at->format('Y-m-d') }} -
                                        {{ $client->visitWeb->first()->created_at->format('H:i:s') }}
                                    @else
                                        0
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-gray-500 py-6">
                                    لا توجد بيانات متاحة حاليًا
                                </td>
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
        // ✅ البحث التفاعلي
        const searchId = document.getElementById('searchId');
        const searchName = document.getElementById('searchName');
        const rows = document.querySelectorAll('#clientsTable tr');

        function filterTable() {
            const idQuery = searchId.value.trim().toLowerCase();
            const nameQuery = searchName.value.trim().toLowerCase();

            rows.forEach(row => {
                const id = row.cells[0]?.textContent.trim().toLowerCase() || '';
                const name = row.cells[1]?.textContent.trim().toLowerCase() || '';
                const match = (id.includes(idQuery) || idQuery === '') &&
                    (name.includes(nameQuery) || nameQuery === '');
                row.style.display = match ? '' : 'none';
            });
        }

        searchId.addEventListener('input', filterTable);
        searchName.addEventListener('input', filterTable);
    </script>
@endsection
