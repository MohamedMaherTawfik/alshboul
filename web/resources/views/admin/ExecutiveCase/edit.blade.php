@extends('layouts.admin')
@section('title', 'القضايا التنفيذية')
@section('main_title_content', 'قائمة القضايا التنفيذية')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="#">قضايا تنفيذية</a>
@endsection
@section('content')
    <div class="col-12">
        @livewire('executive-case-edit', ['id' => $data->id])
    </div>
@endsection
