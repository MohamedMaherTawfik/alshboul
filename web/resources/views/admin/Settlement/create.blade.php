@extends('layouts.admin')
@section('title', 'إضافة تسوية')
@section('main_title_content', 'إضافة تسوية جديدة')
@section('title_content', 'إضافة')
@section('link_content')
    <a href="{{ route('settlement.index') }}">التسويات</a>
@endsection
@section('content')
    <div class="col-12">
        @livewire('settlement-create')
    </div>
@endsection
