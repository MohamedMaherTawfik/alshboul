@extends('layouts.admin')
@section('title', 'القضايا التنفيذية')
@section('main_title_content', ' القضايا التنفيذية')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('executive-case.index', $id) }}">قضايا تنفيذية</a>
@endsection
@section('content')
    <div class="col-12">
        @livewire('executive-case-list', ['case_id' => $id])
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.open-delete-modal').on('click', function() {
                let id = $(this).data('id');
                $('#delete_id').val(id);
            });
        });
    </script>
@endsection
