@extends('layouts.admin')
@section('title', 'زيارات الموكلين')
@section('main_title_content', 'بيانات زيارات الموكلين آخر شهر')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('client.visit') }}">موكلين</a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <h3 class="card-title">بيانات زيارات الموكلين آخر شهر</h3>
        </div>

        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <!-- الكرت اللي فيه إجمالي الزيارات -->
                <div class="flex justify-center">
                    <div class="bg-white border shadow-sm rounded-xl p-4 w-full md:w-1/2 text-center">
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

                <!-- خانات البحث -->
                <div class="flex justify-center items-center gap-3">
                    <input type="text" id="searchId" class="form-control w-1/2" placeholder="رقم الموكل">
                    <input type="text" id="searchName" class="form-control w-1/2" placeholder="اسم الموكل">
                </div>
            </div>

            <!-- الجدول -->
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="bg-[#001f3f] text-white">
                        <tr>
                            <th>رقم الموكل</th>
                            <th>اسم الموكل</th>
                            <th>عدد الزيارات</th>
                        </tr>
                    </thead>
                    <tbody id="clientsTable">
                        @forelse ($data as $client)
                            <tr>
                                <td>{{ $client->id }}</td>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->visit_count ?? 0 }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-gray-500">لا توجد بيانات</td>
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
        // البحث برقم الموكل أو الاسم
        const searchId = document.getElementById('searchId');
        const searchName = document.getElementById('searchName');
        const rows = document.querySelectorAll('#clientsTable tr');

        function filterTable() {
            const idQuery = searchId.value.toLowerCase();
            const nameQuery = searchName.value.toLowerCase();

            rows.forEach(row => {
                const id = row.cells[0]?.textContent.toLowerCase() || '';
                const name = row.cells[1]?.textContent.toLowerCase() || '';

                if (id.includes(idQuery) && name.includes(nameQuery)) {
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
