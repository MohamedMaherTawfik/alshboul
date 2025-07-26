@extends('layouts.admin')
@section('title', 'القضايا التنفيذية')
@section('main_title_content', 'قائمة القضايا التنفيذية')
@section('title_content', 'إضافة')
@section('link_content')
    <a href="{{ route('executive-case.index', $id) }}">قضايا تنفيذية</a>
@endsection
@section('content')
    <div class="col-12">
        @livewire('executive-case-create')
    </div>
@endsection
