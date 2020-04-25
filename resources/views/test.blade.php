@extends('layouts.app')
@section('content')
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    {{-- Include Header --}}  
    @include('layouts.navbar')
    <!-- Content Wrapper. Contains page content -->
     <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          
          <div class="col-md-12">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#school_details" data-toggle="tab">School Details</a></li>
                  <li class="nav-item"><a class="nav-link" href="#sms_details" data-toggle="tab">SMS Details new </a></li>
                  <li class="nav-item"><a class="nav-link" href="#smtp" data-toggle="tab">SMTP</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="school_details">
                     <form class="form-horizontal">
                      <div class="form-group row"> 
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">School Name</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">School Short Name</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>

                      </div>
                    <!--   <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                        </div>
                      </div> -->
                       
                     
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="sms_details">
                    <form class="form-horizontal">
                       <div class="form-group row"> 
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Sender Name</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">URL</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>

                      </div>
                      
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="smtp">
                    <form class="form-horizontal">
                       <div class="form-group row"> 
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">User Name</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Password</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>

                      </div>
                      
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  </div>
@endsection
@section('script')
  <script src="{{ asset('public/js/common-function.js') }}"></script>
  <script src="{{ asset('public/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
  <script type="text/javascript">
    $(document).ready(function () {
        bsCustomFileInput.init();
    });
  </script>
@endsection