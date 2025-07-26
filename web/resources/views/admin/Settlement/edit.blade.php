@extends('layouts.admin')
@section('title', 'تعديل تسوية')
@section('main_title_content', 'تعديل تسوية')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="{{ route('settlement.index') }}">التسويات</a>
@endsection
@section('content')
    <div class="col-12">
        @livewire('settlement-edit', ['id' => $data->id])
    </div>
@endsection
