@extends('layouts.admin')
@section('title', 'إضافة إجراء تسوية')
@section('main_title_content', 'إضافة إجراء جديد للتسوية')
@section('title_content', 'إضافة')
@section('link_content')
    <a href="{{ route('settlement.index') }}">التسويات</a>
@endsection
@section('content')
    <div class="col-12">
        @livewire('settlement-action-create', ['settlement_id' => $settlement_id])
    </div>
@endsection 