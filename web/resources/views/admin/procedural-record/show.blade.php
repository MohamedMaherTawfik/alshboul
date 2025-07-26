@extends('layouts.admin')
@section('title', ' تفاصيل السجل الإجرائي')
@section('main_title_content', 'قائمة القضايا التنفيذية')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('procedural-record.index', $proceduralRecord->executive_case_id) }}">السجلات الجرائية </a>
@endsection

@section('content')

    <div class="container-fluid">
        <livewire:procedural-record-show :id="$proceduralRecord->id" :case_id="$case_id" />
    </div>

@endsection
