@extends('layouts.admin')
@section('title', ' الصفحة الرئيسية')
@section('main_title_content', ' الصفحة الرئيسية')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('admin.dashboard') }}"> الصفحة الرئيسية</a>
@endsection
@section('content')
    <div class="col-12">
        <h5 class="mt-4 mb-2 text-center">إحصائيات</h5>
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $countUser }}</h3>

                        <p>عدد المستخدمين</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="{{ route('user.index') }}" class="small-box-footer">
                        المستخدمين <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $countLawyer }}</h3>

                        <p>إجمالي المحامين </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <a href="{{ route('lawyer.index') }}" class="small-box-footer">
                        المحامين <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $countClient }}</h3>

                        <p> عدد الموكلين</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <a href="{{ route('client.index') }}" class="small-box-footer">
                        الموكلين <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $countClientRequest }}</h3>

                        <p>عدد طلبات الموكلين</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <a href="{{ route('request.index') }}" class="small-box-footer">
                        طلبات الموكلين <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->

            <!-- ./col -->
        </div>
        <div style="background-image: url({{ asset('assets/admin/imgs/bg.jpg') }}); height:72vh ; background-size:cover">

        </div>
    </div>
@endsection
