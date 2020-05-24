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
                  <li class="nav-item"><a class="nav-link active" href="#personal_details" data-toggle="tab">Personal Details</a></li>
                  <li class="nav-item"><a class="nav-link" href="#residential_details" data-toggle="tab">Residential Details</a></li>
                  <li class="nav-item"><a class="nav-link" href="#guardians_details" data-toggle="tab">Guardians Details</a></li>
                   <li class="nav-item"><a class="nav-link" href="#transport_details" data-toggle="tab">Transport Details</a></li>
                    <li class="nav-item"><a class="nav-link" href="#hostel_details" data-toggle="tab">Hostel Details</a></li>
                    <li class="nav-item"><a class="nav-link" href="#fee_details" data-toggle="tab">Fee Details</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="personal_details">
                     <form class="form-horizontal">
                      <div class="form-group row"> 
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Admission No</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Name</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Class</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Section</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Roll Number:</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Gender</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Date of Admission:</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Date of Birth</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Blood Group:</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">No. of Siblings:</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Category:</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Aadhaar No:</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Caste</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Session:</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Mobile No</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Email Id:</label>
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
                  <div class="tab-pane" id="residential_details">
                    <form class="form-horizontal">
                       <div class="form-group row"> 
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Address:</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">City:</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">District:</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">State:</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Zip Code/Pin Code:</label>
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

                  <div class="tab-pane" id="guardians_details">
                    <form class="form-horizontal">
                       <div class="form-group row"> 
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Father's Name:</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Father Mobile No</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                         <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Father's Occupation</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Father education:</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                           <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Mother's  Name:</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Mother's Mobile No</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                         <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Mother's  Occupation</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Mother's  education:</label>
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
                  <div class="tab-pane" id="transport_details">
                    <form class="form-horizontal">
                       <div class="form-group row"> 
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Yes No </label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Root</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                         <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Stopage</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                         <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Vehicle Type</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Vehicle Number</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Charge</label>
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
                  <div class="tab-pane" id="hostel_details">
                    <form class="form-horizontal">
                       <div class="form-group row"> 
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Yes/No </label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Hostel</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Room</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                         <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Bade No</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Charge</label>
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
                  <div class="tab-pane" id="fee_details">
                    <form class="form-horizontal">
                       <div class="form-group row"> 
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Admission Fee:</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Miscellaneous Charge:</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                         <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">Registration:</label>
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>

                         <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">I Card:</label>
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