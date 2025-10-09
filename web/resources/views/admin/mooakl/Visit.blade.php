@extends('layouts.admin')
@section('title', 'زيارات الموكلين')
@section('main_title_content', 'بيانات زيارات الموكلين آخر شهر')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('client.visit') }}">موكلين</a>
@endsection

@section('content')
    <div class="card bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-800">بيانات زيارات الموكلين آخر شهر</h3>
        </div>

        <!-- ✅ صف البحث -->
        <div class="flex items-center gap-3 mb-6">
            <input type="text" id="searchId"
                class="w-1/2 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="رقم الموكل">
            <input type="text" id="searchName"
                class="w-1/2 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="اسم الموكل">
        </div>

        <!-- ✅ الكارت اللي فيه إجمالي الزيارات -->
        <div class="flex justify-center mb-6">
            <div class="bg-white border shadow-sm rounded-xl p-4 w-full md:w-1/3 text-center">
                <div class="flex flex-col items-center">
                    <div class="text-gray-700 font-semibold mb-2">إجمالي زيارات الموكلين</div>
                    <div class="flex items-center justify-center space-x-2">
                        <div class="text-3xl font-bold text-gray-800">
                            {{ $data->sum('visit_count') ?? 0 }}
                        </div>
                        <div class="bg-[#0d6efd] text-white rounded-full p-2">
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ✅ الجدول -->
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 text-right">
                <thead class="bg-gray-100 text-gray-800 font-semibold">
                    <tr>
                        <th class="px-4 py-2 border-b">رقم الموكل</th>
                        <th class="px-4 py-2 border-b">اسم الموكل</th>
                        <th class="px-4 py-2 border-b">عدد الزيارات</th>
                    </tr>
                </thead>
                <tbody id="clientsTable" class="text-gray-700">
                    @forelse ($data as $client)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-b">{{ $client->id }}</td>
                            <td class="px-4 py-2 border-b">{{ $client->name }}</td>
                            <td class="px-4 py-2 border-b">{{ $client->visit_count ?? 0 }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-gray-500 py-3">لا توجد بيانات</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
