@extends('layouts.admin')

@section('title', 'جميع الملفات')
@section('main_title_content', 'جميع الملفات')
@section('title_content', 'عرض')

@section('content')
    <style>
        body {
            font-family: "Tajawal", sans-serif;
        }

        .content-wrapperr {
            max-width: 1000px;
            margin: 30px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            padding: 25px 30px;
        }

        .upload-btn {
            background-color: #28a745;
            color: #fff;
            padding: 8px 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 15px;
            margin-bottom: 20px;
            transition: background 0.3s ease;
        }

        .upload-btn:hover {
            background-color: #218838;
        }

        h4 {
            margin-bottom: 20px;
            color: #333;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            border-radius: 8px;
            overflow: hidden;
        }

        th,
        td {
            border: 1px solid #e2e2e2;
            padding: 12px 10px;
            vertical-align: middle;
            text-align: center;
        }

        th {
            background-color: #f9fafb;
            font-weight: bold;
            color: #555;
        }

        tr:hover {
            background-color: #f8f8f8;
        }

        .file-preview img {
            width: 380px;
            height: 150px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .file-preview iframe {
            width: 280px;
            height: 100px;
            border: none;
            border-radius: 6px;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 6px 12px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s ease;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        .no-files {
            background-color: #f1f1f1;
            padding: 15px;
            border-radius: 8px;
            color: #555;
            text-align: center;
            font-size: 15px;
        }
    </style>



    <div class="content-wrapperr mt-10">
        <!-- عرض الملفات -->
        <div class="file-section">
            <!-- زر رفع ملف -->
            <button class="upload-btn btn btn-sm btn-primary" data-bs-toggle="modal"
                data-bs-target="#addFileModal-{{ $proceduralrecord->id }}"
                style="font-size: 13px; padding: 4px 10px; border-radius: 6px;">
                + اضافه ملف
            </button>


            <!-- مودال رفع ملفات -->
            <div class="modal fade" id="addFileModal-{{ $proceduralrecord->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" style="font-family: Tajawal, sans-serif;">
                        <form method="POST" action="{{ route('procedural.add.file', $proceduralrecord) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div style="padding: 20px;">
                                <h3 style="margin-bottom: 15px;">رفع مستندات</h3>
                                <input type="file" name="files[]" multiple required
                                    style="width: 100%; border: 1px solid #ccc; border-radius: 6px; padding: 8px;">
                                <div style="margin-top: 15px; text-align: right;">
                                    <button type="submit"
                                        style="background-color: #007bff; color: #fff; padding: 8px 14px; border: none; border-radius: 5px; cursor: pointer;">
                                        رفع
                                    </button>
                                    <button type="button" data-bs-dismiss="modal"
                                        style="background-color: #777; color: #fff; padding: 8px 14px; border: none; border-radius: 5px; cursor: pointer;">
                                        إلغاء
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <h4>
                الملفات المرفوعة (عدد المستندات:
                <span style="color: green; font-weight: bold;">{{ count($proceduralrecord->files) }}</span>)
            </h4>

            @if (count($proceduralrecord->files) > 0)
                <table>
                    <thead>
                        <tr>
                            <th>رقم الملف</th>
                            <th>المعاينة</th>
                            <th>الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($proceduralrecord->files as $item)
                            @php
                                $extension = pathinfo($item->file_path, PATHINFO_EXTENSION);
                            @endphp
                            <tr>
                                <td> {{ $item->id }}</td>
                                <td class="file-preview">
                                    @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ asset('storage/' . $item->file_path) }}" alt="file image">
                                    @elseif (in_array(strtolower($extension), ['pdf']))
                                        <iframe src="{{ asset('storage/' . $item->file_path) }}"></iframe>
                                    @else
                                        <p style="color: #666;">لا يمكن عرض هذا النوع من الملفات.
                                            <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank">تحميل</a>
                                        </p>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('cases.procedure.file.delete', $item->id) }}" method="POST"
                                        onsubmit="return confirm('هل أنت متأكد من حذف هذا الملف؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-files">لا توجد ملفات مرفوعة حتى الآن.</div>
            @endif
        </div>
    </div>
@endsection
