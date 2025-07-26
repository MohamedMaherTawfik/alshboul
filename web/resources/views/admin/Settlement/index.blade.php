@extends('layouts.admin')
@section('title', 'التسويات')
@section('main_title_content', 'قائمة التسويات')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('settlement.index') }}">التسويات</a>
@endsection
@section('content')
    <div class="col-12">
        @livewire('settlement-list', ['type_id' => request('type')])
    </div>
@endsection
