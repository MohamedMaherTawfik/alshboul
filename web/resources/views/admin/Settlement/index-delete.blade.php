@extends('layouts.admin')
@section('title', 'التسويات المحذوفة')
@section('main_title_content', 'قائمة التسويات المحذوفة')
@section('title_content', 'عرض المحذوفة')
@section('link_content')
    <a href="{{ route('settlement.index') }}">التسويات</a>
@endsection
@section('content')
    <div class="col-12">
        @livewire('settlement-deleted-list')
    </div>
@endsection
