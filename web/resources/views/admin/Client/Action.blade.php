@extends('layouts.admin')
@section('title', 'الموكلين ')
@section('main_title_content', ' قائمة الموكلين ')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('client.visit') }}"> موكلين</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center"> اجراءات الموكلين
                    <button data-toggle="modal" data-target="#addAction" class="btn btn-success ">اضافة </button>

                </h3>
            </div>

            @livewire('client-list')
        </div>
    </div>

@endsection
@section('script') @endsection
