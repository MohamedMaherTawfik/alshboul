@extends('layouts.admin')
@section('title', 'المتقدمي للوظائف ')
@section('main_title_content', ' قائمة متقدمي للوظائف ')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('apply-careers.all') }}"> المتقدمي للوظائف</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center"> المتقدمي للوظائف

                </h3>
            </div>

            @livewire('apply-list')
        </div>
    </div>

@endsection
@section('script') @endsection
