@extends('layouts.admin')
@section('title', 'القضايا التنفيذية المحذوفة')
@section('main_title_content', 'قائمة القضايا التنفيذية المحذوفة')
@section('title_content', 'عرض المحذوفة')
@section('link_content')
    <a href="{{ route('executive-case.index', 1) }}">قضايا تنفيذية</a>
@endsection
@section('content')
    <div class="col-12">
        @livewire('executive-case-deleted-list')
    </div>
@endsection
