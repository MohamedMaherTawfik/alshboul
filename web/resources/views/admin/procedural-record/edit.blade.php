@extends('layouts.admin')

@section('title', 'تعديل السجل الإجرائي')
@section('main_title_content', 'قائمة القضايا التنفيذية')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="{{ route('procedural-record.index', $proceduralRecord->executive_case_id) }}">السجلات الجرائية </a>
@endsection
@section('content')

    <div class="container-fluid">
        <livewire:procedural-record-edit :id="$proceduralRecord->id" />
    </div>
@endsection
