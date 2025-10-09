@extends('layouts.admin')
@section('title', 'زيارات الموكلين')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('client.visit') }}">موكلين</a>
@endsection

@section('content')
    <div class="w-full min-h-screen bg-gray-50 p-6">
        <div class="bg-white shadow-lg rounded-2xl p-8 border border-gray-200 w-full">
            <!-- ✅ العنوان العلوي -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                <h3 class="text-2xl font-extrabold text-gray-800 mb-4 md:mb-0">بيانات زيارات الموكلين آخر شهر</h3>
                <div class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold shadow-sm">
                    {{ $data->count() }} موكل
                </div>
            </div>

            <!-- ✅ خانات البحث في صف واحد -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div>
                    <label for="searchId" class="block text-sm font-medium text-gray-600 mb-1">رقم الموكل</label>
                    <input type="text" id="searchId"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="اكتب رقم الموكل...">
                </div>
                <div>
                    <label for="searchName" class="block text-sm font-medium text-gray-600 mb-1">اسم الموكل</label>
                    <input type="text" id="searchName"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="اكتب اسم الموكل...">
                </div>
            </div>

            <!-- ✅ كارت إجمالي الزيارات -->
            <div class="flex justify-center mb-8">
                <div
                    class="bg-gradient-to-r from-blue-600 to-blue-400 text-white rounded-xl p-6 w-full md:w-1/2 lg:w-1/3 text-center shadow-md">
                    <div class="flex flex-col items-center">
                        <div class="text-sm opacity-90 mb-1">إجمالي زيارات الموكلين</div>
                        <div class="flex items-center justify-center gap-2">
                            <div class="text-4xl font-bold">{{ $data->sum('visit_count') ?? 0 }}</div>
                            <div class="bg-white/30 rounded-full p-2">
                                <i class="fas fa-eye text-white text-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ✅ الجدول -->
            <div class="overflow-x-auto w-full">
                <table class="min-w-full text-right border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="px-6 py-3 text-sm font-semibold border-b border-blue-500">رقم الموكل</th>
                            <th class="px-6 py-3 text-sm font-semibold border-b border-blue-500">اسم الموكل</th>
                            <th class="px-6 py-3 text-sm font-semibold border-b border-blue-500">عدد الزيارات</th>
                        </tr>
                    </thead>
                    <tbody id="clientsTable" class="bg-white divide-y divide-gray-100">
                        @forelse ($data as $client)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-3 text-gray-800">{{ $client->id }}</td>
                                <td class="px-6 py-3 font-medium text-gray-900">{{ $client->name }}</td>
                                <td class="px-6 py-3 text-center text-gray-700">{{ $client->visit_count ?? 0 }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-gray-500 py-4">لا توجد بيانات متاحة</td>
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
        // ✅ البحث التفاعلي (ID + Name)
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
