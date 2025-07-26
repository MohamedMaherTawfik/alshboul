<div class="overflow-auto card-body">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fa fa-eye"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">إجمالي زيارات الموكلين </span>
                    <span class="info-box-number">
                        {{ $count_visit }}
                        <small></small>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </div>
    <input wire:model.live="search" type="text" placeholder="ابحث عن اسم الموكل..."
        class="w-full p-2 mb-4 border rounded" />

    @if (@isset($data) and !@empty($data) and count($data) > 0)
        <table id="example2" class="table table-bordered table-hover">
            <thead class="custom_thead">

                <th> رقم الموكل</th>
                <th>اسم الموكل</th>
                <th>عدد الزيارات</th>

            </thead>
            <tbody>

                @foreach ($data as $info)
                    <tr>
                        <td>{{ $info->id }}</td>
                        <td>{{ $info->name }}</td>
                        <td>{{ $info->recent_visits_count }}</td>

                    </tr>
                @endforeach

            </tbody>
        </table>
    @else
        <div class="col-md-12">
            <div class="text-center alert alert-info">
                لا توجد بيانات لعرضها.
            </div>
        </div>
    @endif
</div>
