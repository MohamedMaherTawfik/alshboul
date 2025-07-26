@extends('layouts.admin')
@section('title', 'عرض التسوية')
@section('main_title_content', 'تفاصيل التسوية')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('settlement.index') }}">التسويات</a>
@endsection
@section('content')
    <div class="col-12">
        @livewire('settlement-show', ['id' => $data->id])
    </div>
@endsection
