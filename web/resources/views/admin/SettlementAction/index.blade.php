@extends('layouts.admin')
@section('title', 'إجراءات التسوية')
@section('main_title_content', 'إجراءات التسوية')
@section('title_content', 'قائمة الإجراءات')
@section('link_content')
    <a href="{{ route('settlement.index') }}">التسويات</a>
@endsection
@section('content')
    <div class="col-12">
        @livewire('settlement-action-list', ['settlement_id' => $settlement_id])
    </div>
@endsection 