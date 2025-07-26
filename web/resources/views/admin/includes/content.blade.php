<div class="container-fluid"  style="min-height: 75vh;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@yield('main_title_content')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">@yield('link_content')</li>
              <li class="breadcrumb-item active">@yield('title_content')</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          @if (Session::has('error'))
          <div class="alert alert-danger msg" role="alert">
            {{ Session::get('error') }}
          </div>
          @endif
          @if (Session::has('success'))
          <div class="alert alert-success msg" role="alert" >
            {{ Session::get('success') }}
          </div>
          @endif
          @yield('content')
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>