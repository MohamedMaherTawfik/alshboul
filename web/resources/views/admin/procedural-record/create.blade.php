@extends('layouts.admin')

@section('title', 'إضافة سجل إجرائي جديد')
@section('main_title_content', 'قائمة القضايا التنفيذية')
@section('title_content', 'إضافة')
@section('link_content')
    <a href="{{ route('procedural-record.index', $case_id) }}">السجلات الجرائية </a>
@endsection
@section('content')

    <div class="container-fluid">
        <livewire:procedural-record-create :case_id="$case_id" />
    </div>
@endsection
