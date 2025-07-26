@extends('layouts.admin')
@section('title', 'تعديل إجراء تسوية')
@section('main_title_content', 'تعديل إجراء التسوية')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="{{ route('settlement.index') }}">التسويات</a>
@endsection
@section('content')
    <div class="col-12">
        @livewire('settlement-action-edit', ['id' => $id])
    </div>
@endsection 