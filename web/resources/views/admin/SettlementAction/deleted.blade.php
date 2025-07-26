@extends('layouts.admin')
@section('title', 'الإجراءات المحذوفة للتسوية')
@section('main_title_content', 'الإجراءات المحذوفة')
@section('title_content', 'محذوفة')
@section('link_content')
    <a href="{{ route('settlement.index') }}">التسويات</a>
@endsection
@section('content')
    <div class="col-12">
        @livewire('settlement-action-deleted-list', ['settlement_id' => $settlement_id])
    </div>
@endsection 