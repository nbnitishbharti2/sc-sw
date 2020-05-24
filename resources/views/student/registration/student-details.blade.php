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
              <h1>{{ $title }}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">{{ $page_title }}</li>
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
                    <li class="nav-item" @if($student_registration_id!=0) onclick="location.href='{{ route('add.student.registration',['id' => $student_registration_id]) }}';" @endif><a class="nav-link {{ ($tab=='student_details')?'active':'' }}" href="#personal_details" data-toggle="tab">{{ trans('label.personal_details') }}</a></li>
                    <li class="nav-item" @if($student_registration_id!=0) onclick="location.href='{{ route('edit.student.registration.address',['id' => $student_registration_id,'map_id' => $map_id]) }}';" @endif><a class="nav-link {{ ($tab=='student_address')?'active':'' }}"  >{{ trans('label.residential_address') }}</a></li>
                    <li class="nav-item" @if($student_registration_id!=0) onclick="location.href='{{ route('edit.student.registration.parent',['id' => $student_registration_id,'map_id' => $map_id]) }}';" @endif><a class="nav-link {{ ($tab=='student_parent')?'active':'' }}" >{{ trans('label.guardians_details') }}</a></li> 
                    <li class="nav-item" @if($student_registration_id!=0) onclick="location.href='{{ route('edit.student.registration.charge',['id' => $student_registration_id,'map_id' => $map_id]) }}';" @endif><a class="nav-link {{ ($tab=='student_charge')?'active':'' }}"  >{{ trans('label.charge') }}</a></li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <div class="{{ ($tab=='student_details')?'active':'' }} tab-pane" id="personal_details">
                      @if($tab=='student_details')
                      <form class="form-horizontal" action="{{ $action }}" method="POST">
                        @csrf
                        <div class="form-group row"> 
                          <div class="col-sm-6">
                            <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.registration_no') }}</label>
                            <input type="hidden" name="student_registration_id" value="{{ $student_registration_id }}">
                            <input type="text" class="form-control" value="{{ ($registration_no) ? $registration_no : old('registration_no') }}" id="inputName" name="registration_no"  placeholder="{{ trans('placeholder.registration_no') }}" > 
                            @if($errors->has('registration_no'))
                            <span class="alert-notice" role="alert">
                              <strong>{{ $errors->first('registration_no') }}</strong>
                            </span>
                            @endif
                          </div>
                          <div class="col-sm-6">
                            <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.session') }}</label>
                            @php $currntSession = Helper::getCurrentSessionForAdmission() @endphp
                            <select name="session" id="session" class="form-control" >
                              @foreach(Helper::getSession() as $key => $value)
                              <option value="{{ $value->id }}" {{ ($value->academic_year==$currntSession)?'selected':'' }}>{{ $value->academic_year }}</option>
                              @endforeach
                            </select>
                            @if($errors->has('session'))
                            <span class="alert-notice" role="alert">
                              <strong>{{ $errors->first('session') }}</strong>
                            </span>
                            @endif
                          </div> 
                          <div class="col-sm-6">
                            <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.name') }}</label>
                            <input type="text" class="form-control" value="{{ ($name) ? $name : old('name') }}" id="inputName" name="name" placeholder="{{ trans('placeholder.name') }}" > 
                            @if($errors->has('name'))
                            <span class="alert-notice" role="alert">
                              <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                          </div>
                          <div class="col-sm-6">
                           <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.aadhar_no') }}</label>
                           <input type="text" class="form-control" value="{{ ($aadhar_no) ? $aadhar_no : old('aadhar_no') }}" id="inputName"  placeholder="{{ trans('placeholder.aadhar_no') }}" name="aadhar_no" >
                           @if($errors->has('aadhar_no'))
                           <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('aadhar_no') }}</strong>
                          </span>
                          @endif
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.class') }}</label> 
                          <select name="class" id="class" class="form-control">
                            <option value="">Chouse Class</option>
                            @foreach($class_list as $class)
                            <option value="{!! $class->id !!}" {{ ( $class->id == $class_id ) ? 'selected' : '' }}>{!! $class->class_short !!}</option>
                            @endforeach
                          </select>
                          @if($errors->has('class'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('class') }}</strong>
                          </span>
                          @endif
                        </div>
                        <div class="col-sm-6">
                         <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.section') }}</label> 
                         <select name="section" id="section" class="form-control">
                          <option value="">Chouse Section</option> 
                        </select>
                        @if($errors->has('section'))
                        <span class="alert-notice" role="alert">
                          <strong>{{ $errors->first('section') }}</strong>
                        </span>
                        @endif
                      </div>
                      <div class="col-sm-6">
                        <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.gender') }}</label> 
                        <select name="gender" class="form-control">
                          <option value="">Chouse Gender</option>
                          @foreach($gender_list as $gender)
                          <option value="{!! $gender->id !!}" {{ ( $gender->id == $gender_id ) ? 'selected' : '' }}>{!! $gender->name !!}</option>
                          @endforeach
                        </select>
                        @if($errors->has('gender'))
                        <span class="alert-notice" role="alert">
                          <strong>{{ $errors->first('gender') }}</strong>
                        </span>
                        @endif
                      </div>
                      <div class="col-sm-6">
                       <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.blood_group') }}</label> 
                       <select name="blood_group" class="form-control">
                        <option value="">Chouse Blood Group</option>
                        @foreach($blood_group_list as $blood_group)
                        <option value="{!! $blood_group->id !!}" {{ ( $blood_group->id == $blood_group_id ) ? 'selected' : '' }}>{!! $blood_group->name !!}</option>
                        @endforeach
                      </select>
                      @if($errors->has('blood_group'))
                      <span class="alert-notice" role="alert">
                        <strong>{{ $errors->first('blood_group') }}</strong>
                      </span>
                      @endif
                    </div> 
                    <div class="col-sm-6">
                      <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.category') }}</label> 
                      <select name="category" class="form-control">
                        <option value="">Chouse Category</option>
                        @foreach($category_list as $category)
                        <option value="{!! $category->id !!}" {{ ( $category->id == $category_id ) ? 'selected' : '' }}>{!! $category->name !!}</option>
                        @endforeach
                      </select>
                      @if($errors->has('category'))
                      <span class="alert-notice" role="alert">
                        <strong>{{ $errors->first('category') }}</strong>
                      </span>
                      @endif
                    </div>
                    <div class="col-sm-6">
                      <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.dob') }}</label>
                      <input type="date" class="form-control" value="{{ ($dob) ? $dob : old('dob') }}" id="inputName" name="dob"  placeholder="{{ trans('placeholder.dob') }}" >
                      @if($errors->has('dob'))
                      <span class="alert-notice" role="alert">
                        <strong>{{ $errors->first('dob') }}</strong>
                      </span>
                      @endif
                    </div> 
                    <div class="col-sm-6">
                      <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.mobile_no') }}</label>
                      <input type="text" class="form-control" value="{{ ($mobile_no) ? $mobile_no : old('mobile_no') }}" id="inputName"  placeholder="{{ trans('placeholder.mobile_no') }}" name="mobile_no">
                      @if($errors->has('mobile_no'))
                      <span class="alert-notice" role="alert">
                        <strong>{{ $errors->first('mobile_no') }}</strong>
                      </span>
                      @endif
                    </div>
                    <div class="col-sm-6">
                      <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.email') }}</label>
                      <input type="text" class="form-control" value="{{ ($email) ? $email : old('email') }}" id="inputName"  placeholder="{{ trans('placeholder.email') }}" name="email" >
                      @if($errors->has('email'))
                      <span class="alert-notice" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                      </span>
                      @endif
                    </div>
                    <div class="col-sm-6">
                      <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.cast') }}</label>
                      <input type="text" class="form-control" value="{{ ($cast) ? $cast : old('cast') }}" id="inputName"  placeholder="{{ trans('placeholder.cast') }}" name="cast" >
                      @if($errors->has('cast'))
                      <span class="alert-notice" role="alert">
                        <strong>{{ $errors->first('cast') }}</strong>
                      </span>
                      @endif
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="offset-sm-8 col-sm-10">
                       
                    </div>
                    <div class="offset-sm-8 col-sm-10">
                      @if($student_registration_id!=0)
                         <a href="{{ route('edit.student.registration.address',['id' => $student_registration_id,'map_id' => $map_id]) }}"> <button type="button" class="btn btn-primary">{{ trans('button.skip') }}</button></a>
                         @endif
                      <button type="submit" class="btn btn-danger">{{ trans('button.submit') }}</button>
                    </div>
                  </div>
                </form>
                @endif
              </div>
              <!-- /.tab-pane -->
              <div class="{{ ($tab=='student_address')?'active':'' }} tab-pane" id="residential_details">
                @if($tab=='student_address')
                <form class="form-horizontal"  action="{{ $action }}" method="POST">
                        @csrf
                 <div class="form-group row"> 
                  <div class="col-sm-6">
                    <input type="hidden" name="student_registration_id" value="{{ $student_registration_id }}">
                    <input type="hidden" name="map_id" value="{{ $map_id }}">
                    <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.country') }}</label>
                    <input type="text" value="{{ ($country) ? $country : old('country') }}" class="form-control" id="inputName" name="country" placeholder="{{ trans('placeholder.country') }}">
                     @if($errors->has('country'))
                      <span class="alert-notice" role="alert">
                        <strong>{{ $errors->first('country') }}</strong>
                      </span>
                      @endif
                  </div>
                  <div class="col-sm-6">
                     <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.state') }}</label>
                    <input type="text" value="{{ ($state) ? $state : old('state') }}" class="form-control" id="inputName" name="state" placeholder="{{ trans('placeholder.state') }}">
                     @if($errors->has('state'))
                      <span class="alert-notice" role="alert">
                        <strong>{{ $errors->first('state') }}</strong>
                      </span>
                      @endif
                  </div>
                  <div class="col-sm-6">
                    <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.district') }}</label>
                    <input type="text" value="{{ ($district) ? $district : old('district') }}" class="form-control" id="inputName" name="district" placeholder="{{ trans('placeholder.district') }}"> 
                     @if($errors->has('district'))
                      <span class="alert-notice" role="alert">
                        <strong>{{ $errors->first('district') }}</strong>
                      </span>
                      @endif
                  </div>
                  <div class="col-sm-6">
                     <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.city') }}</label>
                    <input type="text" value="{{ ($city) ? $city : old('city') }}" class="form-control" id="inputName" name="city" placeholder="{{ trans('placeholder.city') }}"> 
                     @if($errors->has('city'))
                      <span class="alert-notice" role="alert">
                        <strong>{{ $errors->first('city') }}</strong>
                      </span>
                      @endif
                  </div>
                  <div class="col-sm-6">
                    <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.address') }}</label>
                    <textarea name="address" class="form-control" placeholder="{{ trans('placeholder.address') }}" name="address">{{ ($address) ? $address : old('address') }}</textarea>
                     @if($errors->has('address'))
                      <span class="alert-notice" role="alert">
                        <strong>{{ $errors->first('address') }}</strong>
                      </span>
                      @endif
                  </div>
                   <div class="col-sm-6">
                     <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.pin_code') }}</label>
                    <input type="text" value="{{ ($pin_code) ? $pin_code : old('pin_code') }}" class="form-control" id="inputName" name="pin_code" placeholder="{{ trans('placeholder.pin_code') }}">
                     @if($errors->has('pin_code'))
                      <span class="alert-notice" role="alert">
                        <strong>{{ $errors->first('pin_code') }}</strong>
                      </span>
                      @endif

                  </div>


                </div>

                <div class="form-group row">
                 <div class="offset-sm-8 col-sm-10"> 
                    </div>
                    <div class="offset-sm-8 col-sm-10">
                      @if($student_registration_id!=0)
                         <a href="{{ route('edit.student.registration.parent',['id' => $student_registration_id,'map_id' => $map_id]) }}"> <button type="button" class="btn btn-primary">{{ trans('button.skip') }}</button></a>
                         @endif
                      <button type="submit" class="btn btn-danger">{{ trans('button.submit') }}</button>
                    </div>
                </div>
              </form>
              @endif
            </div>
            <!-- /.tab-pane -->

            <div class="tab-pane {{ ($tab=='student_parent')?'active':'' }}" id="guardians_details">
               @if($tab=='student_parent')
             <form class="form-horizontal"  action="{{ $action }}" method="POST">
                        @csrf
               <div class="form-group row"> 
                <div class="col-sm-6">
                   <input type="hidden" name="student_registration_id" value="{{ $student_registration_id }}">
                    <input type="hidden" name="map_id" value="{{ $map_id }}">
                    <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.father_name') }}</label>
                    <input type="text" value="{{ ($father_name) ? $father_name : old('father_name') }}" class="form-control" id="inputName" name="father_name" placeholder="{{ trans('placeholder.father_name') }}">
                     @if($errors->has('father_name'))
                      <span class="alert-notice" role="alert">
                        <strong>{{ $errors->first('father_name') }}</strong>
                      </span>
                      @endif 
                </div>
                <div class="col-sm-6">
                  <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.father_mobile_no') }}</label>
                    <input type="text" value="{{ ($father_mobile_no) ? $father_mobile_no : old('father_mobile_no') }}" class="form-control" id="inputName" name="father_mobile_no" placeholder="{{ trans('placeholder.father_mobile_no') }}">
                     @if($errors->has('father_mobile_no'))
                      <span class="alert-notice" role="alert">
                        <strong>{{ $errors->first('father_mobile_no') }}</strong>
                      </span>
                      @endif 
                </div>
                <div class="col-sm-6">
                  <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.father_occupation') }}</label> 
                      <select name="father_occupation" class="form-control">
                        <option value="">Chouse Father Occupation</option>
                        @foreach($occupation_list as $occupation)
                        <option value="{!! $occupation->id !!}" {{ ( $occupation->id == $father_occupation ) ? 'selected' : '' }}>{!! $occupation->name !!}</option>
                        @endforeach
                      </select>
                      @if($errors->has('father_occupation'))
                      <span class="alert-notice" role="alert">
                        <strong>{{ $errors->first('father_occupation') }}</strong>
                      </span>
                      @endif 
                </div>
                <div class="col-sm-6">
                  <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.father_education') }}</label> 
                      <select name="father_education" class="form-control">
                        <option value="">Chouse Father Education</option>
                        @foreach($education_list as $education)
                        <option value="{!! $education->id !!}" {{ ( $education->id == $father_education ) ? 'selected' : '' }}>{!! $education->name !!}</option>
                        @endforeach
                      </select>
                      @if($errors->has('father_education'))
                      <span class="alert-notice" role="alert">
                        <strong>{{ $errors->first('father_education') }}</strong>
                      </span>
                      @endif
                </div>
                <div class="col-sm-6">
                  <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.mother_name') }}</label>
                    <input type="text" value="{{ ($mother_name) ? $mother_name : old('mother_name') }}" class="form-control" id="inputName" name="mother_name" placeholder="{{ trans('placeholder.mother_name') }}">
                     @if($errors->has('mother_name'))
                      <span class="alert-notice" role="alert">
                        <strong>{{ $errors->first('mother_name') }}</strong>
                      </span>
                      @endif 
                </div>
                <div class="col-sm-6">
                  <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.mother_mobile_no') }}</label>
                    <input type="text" value="{{ ($mother_mobile_no) ? $mother_mobile_no : old('fmother_mobile_no') }}" class="form-control" id="inputName" name="mother_mobile_no" placeholder="{{ trans('placeholder.mother_mobile_no') }}">
                     @if($errors->has('mother_mobile_no'))
                      <span class="alert-notice" role="alert">
                        <strong>{{ $errors->first('mother_mobile_no') }}</strong>
                      </span>
                      @endif 
                </div>
                <div class="col-sm-6">
                  <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.mother_occupation') }}</label> 
                      <select name="mother_occupation" class="form-control">
                        <option value="">Chouse Mother Occupation</option>
                        @foreach($occupation_list as $occupation)
                        <option value="{!! $occupation->id !!}" {{ ( $occupation->id == $mother_occupation ) ? 'selected' : '' }}>{!! $occupation->name !!}</option>
                        @endforeach
                      </select>
                      @if($errors->has('mother_occupation'))
                      <span class="alert-notice" role="alert">
                        <strong>{{ $errors->first('mother_occupation') }}</strong>
                      </span>
                      @endif 
                </div>
                <div class="col-sm-6">
                  <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.mother_education') }}</label> 
                      <select name="mother_education" class="form-control">
                        <option value="">Chouse Mother Education</option>
                        @foreach($education_list as $education)
                        <option value="{!! $education->id !!}" {{ ( $education->id == $mother_education ) ? 'selected' : '' }}>{!! $education->name !!}</option>
                        @endforeach
                      </select>
                      @if($errors->has('mother_education'))
                      <span class="alert-notice" role="alert">
                        <strong>{{ $errors->first('mother_education') }}</strong>
                      </span>
                      @endif
                </div>

              </div>

              <div class="form-group row">
                <div class="offset-sm-8 col-sm-10">  </div>
                    <div class="offset-sm-8 col-sm-10">
                      @if($student_registration_id!=0)
                         <a href="{{ route('edit.student.registration.charge',['id' => $student_registration_id,'map_id' => $map_id]) }}"> <button type="button" class="btn btn-primary">{{ trans('button.skip') }}</button></a>
                         @endif
                      <button type="submit" class="btn btn-danger">{{ trans('button.submit') }}</button>
                    </div>
              </div>
            </form>
            @endif
          </div> 
          <div class="tab-pane {{ ($tab=='student_charge')?'active':'' }}" id="fee_details">
            @if($tab=='student_charge')
            <form class="form-horizontal">
             <div class="form-group row"> 
             @php $total=0 @endphp
              @foreach($fee['fees'] as $key =>$value)
               @php $total=$total+$value->charge @endphp
              <div class="col-sm-6"> 
                <label for="inputName" class="col-sm-12 col-form-label">{{ $value->fee->fee_name }}</label>
                <input type="email" class="form-control" id="inputName" placeholder="Charge" readonly="" value="{{ $value->charge }}">
              </div>
              @endforeach
              
              

              <div class="col-sm-6">
                <label for="inputName" class="col-sm-12 col-form-label">Total:</label>
                <input type="email" class="form-control" id="inputName" placeholder="Name" readonly="" value="{{ $total }}">
              </div>
              <div class="col-sm-6">
                <label for="inputName" class="col-sm-12 col-form-label">Remarks:</label>
                <input type="email" class="form-control" id="inputName" placeholder="Remarks"  >
              </div>
              <div class="col-sm-6">
                <label for="inputName" class="col-sm-12 col-form-label">Transaction No:</label>
                <input type="email" class="form-control" id="inputName" placeholder="Transaction No" >
              </div>
              <div class="col-sm-6">
                <label for="inputName" class="col-sm-12 col-form-label">Payment Mode:</label>
                <select class="form-control">
                  <option>Cash</option>
                  <option>DD</option>
                  <option>NEFT</option>
                  <option>Other</option>
                </select>
              </div>

            </div>

            <div class="form-group row">
              <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-danger">Submit</button>
              </div>
            </div>
          </form>
          @endif
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
<script>
  $(window).on('load',function() {

    if($('#session').val())
    {
      var session = $('#session').val();

      var form_data = new FormData();
      form_data.append('session',session);
      form_data.append('_token', '{{csrf_token()}}');

      var old_class_id='{{ (isset($class_id))?$class_id:'' }}';
      if(old_class_id == 0) {
        $('#vehicle_id').html('<option>Choose Vehicle</option>');
      }
      else {
        $.ajax({
          url: "{{route('get-vehicle-no-from-vehicle')}}",
          data: form_data,
          type: 'POST',
          dataType: "json",
          contentType: false,
          processData: false,
          success:function(data) { 
            $.each(data, function(key, value) {
              var select='';
              if(old_class_id==key){select='selected';}
              $('select[name="class"]').append('<option value="'+ key +'" "'+select+'" >'+ value +'</option>');
            });
            $("#class_id").val(old_class_id);
          }
        });
      }

    }
  });


  $(document).ready(function(){
    $('#session').on('change', function(){
      var session_id = $(this).val();
      var form_data = new FormData();
      form_data.append('session_id',session_id);
      form_data.append('_token', '{{csrf_token()}}');
      $.ajax({
        url: "{{route('get-class-list-with-session')}}",
        data: form_data,
        type: 'POST',
        dataType: "json",
        contentType: false,
        processData: false,
        success:function(data) { 
          $('#class option').remove();
          $('select[name="class"]').append('<option value="" >Chouse Class</option>');
          $.each(data, function(key, value) {
            $('select[name="class"]').append('<option value="'+ key +'">'+ value +'</option>');
          });
        }
      });
    });
    $('#class').on('change', function(){
      var class_id = $(this).val();
      var session_id=$("#session").val();
      var form_data = new FormData();
      form_data.append('class_id',class_id);
      form_data.append('session_id',session_id);
      form_data.append('_token', '{{csrf_token()}}');
      $.ajax({
        url: "{{route('get-session-list')}}",
        data: form_data,
        type: 'POST',
        dataType: "json",
        contentType: false,
        processData: false,
        success:function(data) { 
          $('#section option').remove();
          $('select[name="section"]').append('<option value="" >Chouse Section</option>');
          $.each(data, function(key, value) {
            $('select[name="section"]').append('<option value="'+ key +'">'+ value +'</option>');
          });
        }
      });
    });
  });
</script>
@endsection