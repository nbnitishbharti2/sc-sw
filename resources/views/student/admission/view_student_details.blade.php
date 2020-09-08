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
                    <li class="nav-item" @if($id!=0) onclick="location.href='{{ route('view.student-registration.personal_details',['id' => $id]) }}';" @endif><a class="nav-link {{ ($tab=='student_details')?'active':'' }}" href="#personal_details" data-toggle="tab">{{ trans('label.personal_details') }}</a></li>

                    <li class="nav-item" @if($id!=0) onclick="location.href='{{ route('view.student-registration.address',['id' => $id,'map_id' => $map_id]) }}';" @endif><a class="nav-link {{ ($tab=='student_address')?'active':'' }}"  >{{ trans('label.residential_address') }}</a></li>

                    <li class="nav-item" @if($id!=0) onclick="location.href='{{ route('view.student-registration.parent',['id' => $id,'map_id' => $map_id]) }}';" @endif><a class="nav-link {{ ($tab=='student_parent')?'active':'' }}" >{{ trans('label.guardians_details') }}</a></li> 

                    <li class="nav-item" @if($id!=0) onclick="location.href='{{ route('view.student-registration.multiple_upload',['id' => $id,'map_id' => $map_id]) }}';" @endif><a class="nav-link {{ ($tab=='multiple_document_upload')?'active':'' }}"  >{{ trans('label.multiple_document') }}</a></li>

                    <li class="nav-item" @if($id!=0) onclick="location.href='{{ route('view.student-registration.charge',['id' => $id,'map_id' => $map_id]) }}';" @endif><a class="nav-link {{ ($tab=='student_charge')?'active':'' }}"  >{{ trans('label.charge') }}</a></li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <div class="{{ ($tab=='student_details')?'active':'' }} tab-pane" id="personal_details">
                      @if($tab=='student_details')
                      <form class="form-horizontal">
                        @csrf
                        <div class="form-group row"> 
                          <div class="col-sm-6">
                            <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.registration_no') }}</label>
                            <input type="hidden" name="student_registration_id" value="{{ $id }}">
                            <input type="text" class="form-control" value="{{ $student->registration_no }}" id="inputName" name="registration_no" readonly> 
                          </div>
                          <div class="col-sm-6">
                            <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.session') }}</label>
                            <input type="text" class="form-control" value="{{ $student_reg_map->session->academic_year }}" id="inputName" name="session" readonly> 
                          </div> 
                          <div class="col-sm-6">
                            <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.name') }}</label>
                            <input type="text" class="form-control" value="{{ $student->name }}" id="inputName" name="name" readonly> 
                          </div>
                          <div class="col-sm-6">
                           <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.aadhar_no') }}</label>
                           <input type="text" class="form-control" value="{{ $student->aadhar_no }}" id="inputName" name="aadhar_no" readonly>
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.class') }}</label> 
                          <input type="text" class="form-control" value="{{ $student_reg_map->class->class_name }}" id="inputName" name="class" readonly> 
                        </div>
                        <!-- section is removed -->
                        {{-- $student_reg_map->section->section_name --}}
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.gender') }}</label> 
                          <input type="text" class="form-control" value="{{ $student->gender->name }}" id="inputName" name="gender" readonly> 
                        </div>
                        <div class="col-sm-6">
                         <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.blood_group') }}</label> 
                          <input type="text" class="form-control" value="{{ $student->blood_group->name }}" id="inputName" name="blood_group" readonly> 
                        </div> 
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.category') }}</label> 
                          <input type="text" class="form-control" value="{{ $student->category->name }}" id="inputName" name="category" readonly>
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.dob') }}</label>
                          <input type="date" class="form-control" value="{{ $student->dob }}" id="inputName" name="dob" readonly>
                        </div> 
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.mobile_no') }}</label>
                          <input type="text" class="form-control" value="{{ $student->mobile_no }}" id="inputName" name="mobile_no" readonly>
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.email') }}</label>
                          <input type="text" class="form-control" value="{{ $student->email }}" id="inputName" name="email" readonly>
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.cast') }}</label>
                          <input type="text" class="form-control" value="{{ $student->cast }}" id="inputName" name="cast" readonly>
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="offset-sm-8 col-sm-10">
                           
                        </div>
                        <div class="offset-sm-8 col-sm-10">
                          @if($id!=0)
                             <a href="{{ route('view.student-registration.address',['id' => $id,'map_id' => $map_id]) }}"> <button type="button" class="btn btn-primary">{{ trans('button.next') }}</button></a>
                             @endif
                          <!-- <button type="submit" class="btn btn-danger">{{ trans('button.submit') }}</button> -->
                        </div>
                      </div>
                    </form>
                    @endif
                  </div>


              <!-- /.tab-pane -->
              <div class="{{ ($tab=='student_address')?'active':'' }} tab-pane" id="residential_details">
                @if($tab=='student_address')
                <form class="form-horizontal">
                 <div class="form-group row"> 
                  <div class="col-sm-6">
                    <input type="hidden" name="student_registration_id" value="{{ $id }}">
                    <input type="hidden" name="map_id" value="{{ $map_id }}">
                    <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.country') }}</label>
                    <input type="text" value="{{ $student->country }}" class="form-control" id="inputName" name="country" readonly>
                  </div>
                  <div class="col-sm-6">
                     <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.state') }}</label>
                    <input type="text" value="{{ $student->state }}" class="form-control" id="inputName" name="state" readonly>
                  </div>
                  <div class="col-sm-6">
                    <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.district') }}</label>
                    <input type="text" value="{{ $student->district }}" class="form-control" id="inputName" name="district" readonly> 
                  </div>
                  <div class="col-sm-6">
                     <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.city') }}</label>
                    <input type="text" value="{{ $student->city }}" class="form-control" id="inputName" name="city" readonly> 
                  </div>
                  <div class="col-sm-6">
                    <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.address') }}</label>
                    <textarea name="address" class="form-control"  name="address" readonly>{{ $student->address }}</textarea>
                  </div>
                   <div class="col-sm-6">
                     <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.pin_code') }}</label>
                    <input type="text" value="{{ $student->pin_code }}" class="form-control" id="inputName" name="pin_code" readonly>
                  </div>


                </div>

                <div class="form-group row">
                 <div class="offset-sm-8 col-sm-10"> 
                    </div>
                    <div class="offset-sm-8 col-sm-10">
                      @if($id!=0)
                         <a href="{{ route('view.student-registration.parent',['id' => $id,'map_id' => $map_id]) }}"> <button type="button" class="btn btn-primary">{{ trans('button.next') }}</button></a>
                         @endif
                      <!-- <button type="submit" class="btn btn-danger">{{ trans('button.submit') }}</button> -->
                    </div>
                </div>
              </form>
              @endif
            </div>


            <!-- /.tab-pane -->
            <div class="tab-pane {{ ($tab=='student_parent')?'active':'' }}" id="guardians_details">
               @if($tab=='student_parent')
             <form class="form-horizontal" >
                        @csrf
               <div class="form-group row"> 
                <div class="col-sm-6">
                   <input type="hidden" name="student_registration_id" value="{{ $id }}">
                    <input type="hidden" name="map_id" value="{{ $map_id }}">
                    <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.father_name') }}</label>
                    <input type="text" value="{{ $student->father_name }}" class="form-control" id="inputName" name="father_name" readonly>
                </div>
                <div class="col-sm-6">
                  <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.father_mobile_no') }}</label>
                    <input type="text" value="{{  $student->father_mobile_no }}" class="form-control" id="inputName" name="father_mobile_no" readonly> 
                </div>
                <div class="col-sm-6">
                  <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.father_occupation') }}</label> 
                      <input type="text" value="{{  $student->father_occupation->name }}" class="form-control" id="inputName" name="father_occupation" readonly>
                </div>
                <div class="col-sm-6">
                  <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.father_education') }}</label> 
                      <input type="text" value="{{  $student->father_education->name }}" class="form-control" id="inputName" name="father_education" readonly>
                </div>
                <div class="col-sm-6">
                  <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.mother_name') }}</label>
                    <input type="text" value="{{ $student->mother_name }}" class="form-control" id="inputName" name="mother_name" readonly>
                </div>
                <div class="col-sm-6">
                  <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.mother_mobile_no') }}</label>
                    <input type="text" value="{{  $student->mother_mobile_no }}" class="form-control" id="inputName" name="mother_mobile_no" readonly> 
                </div>
                <div class="col-sm-6">
                  <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.mother_occupation') }}</label> 
                      <input type="text" value="{{  $student->mother_occupation->name }}" class="form-control" id="inputName" name="mother_occupation" readonly>
                </div>
                <div class="col-sm-6">
                  <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.mother_education') }}</label> 
                      <input type="text" value="{{  $student->mother_education->name }}" class="form-control" id="inputName" name="mother_education" readonly>
                </div>

              </div>

              <div class="form-group row">
                <div class="offset-sm-8 col-sm-10">  </div>
                    <div class="offset-sm-8 col-sm-10">
                      @if($id!=0)  
                         <a href="{{ route('view.student-registration.multiple_upload',['id' => $id,'map_id' => $map_id]) }}"> <button type="button" class="btn btn-primary">{{ trans('button.next') }}</button></a>
                         @endif
                    </div>
              </div>
            </form>
            @endif
          </div> 


          <!-- /.tab-pane -->
            <div class="{{ ($tab=='multiple_document_upload')?'active':'' }} tab-pane" id="multiple_document">
              @if($tab=='multiple_document_upload')
              <form class="form-horizontal"  >
                @csrf
                <div class="form-group row multipleUpload"> 
                  <!-- <div class="col-sm-12 multipleUpload"> -->
                    <input type="hidden" name="student_registration_id" value="{{ $id }}">
                    <input type="hidden" name="map_id" value="{{ $map_id }}">

                    {{-- dd($student_multiple_uploads) --}}
                    
                    @foreach($student_multiple_uploads as $multiple_upload)
                    <div class="row col-sm-12">
                      <div class="form-group col-sm-6">
                        <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.file_name') }}</label> 
                            <input type="text" value="{{  $multiple_upload->file_name }}" class="form-control" id="inputName" name="file_name" readonly>
                      </div>

                      <div class="form-group col-sm-6">
                        <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.file') }}</label> 
                            <input type="text" value="{{  $multiple_upload->file }}" class="form-control" id="inputName" name="file" readonly>

                            <a href="http://docs.google.com/gview?url={{ URL::to('public/student_files/'.$multiple_upload->file) }}" target="_blank">{{ $multiple_upload->file_name }}</a>

                            @php
                            //$file = explode('.',$multiple_upload->file);
                            //dd($file[0]);

                            $ext =File::extension($multiple_upload->file);  //$file
                            //dd($ext);
              
                            if($ext=='pdf'){
                              $content_types='application/pdf';
                            }elseif ($ext=='doc') {
                              $content_types='application/msword';  
                            }elseif ($ext=='docx') {
                              $content_types='application/vnd.openxmlformats-officedocument.wordprocessingml.document';  
                            }elseif ($ext=='xls') {
                              $content_types='application/vnd.ms-excel';  
                            }elseif ($ext=='xlsx') {
                              $content_types='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';  
                            }elseif ($ext=='txt') {
                              $content_types='application/octet-stream';  
                            }
                            @endphp

                            {{-- dd($content_types) --}}
                            
                          

                            <!-- <embed src="{{ asset('public/student_files/'.$multiple_upload->file) }}" type="application/pdf" width="400px" height="300px"> -->

                            <embed src="{{ asset('public/student_files/'.$multiple_upload->file) }}" type="{{$content_types}}" width="400px" height="300px">
                      </div>
                    </div>
                    @endforeach

                    
                </div>

              <div class="form-group row">
               <div class="offset-sm-8 col-sm-10"> 
                  </div>
                  <div class="offset-sm-8 col-sm-10">
                    @if($id!=0)
                       <a href="{{ route('view.student-registration.charge',['id' => $id,'map_id' => $map_id]) }}"> <button type="button" class="btn btn-primary">{{ trans('button.next') }}</button></a>
                    @endif
                  </div>
              </div>
            </form>
            @endif
          </div>
          

          <!-- /.tab-pane -->
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
                <input type="text" class="form-control" id="inputName" placeholder="Name" readonly value="{{ $total }}">
              </div>
              <div class="col-sm-6">
                <label for="inputName" class="col-sm-12 col-form-label">Remarks:</label>
                <input type="text" class="form-control" id="inputName" readonly  >
              </div>
              <div class="col-sm-6">
                <label for="inputName" class="col-sm-12 col-form-label">Transaction No:</label>
                <input type="text" class="form-control" id="inputName" readonly>
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

            <!-- <div class="form-group row">
              <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-danger">Submit</button>
              </div>
            </div> -->

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
          $('select[name="class"]').append('<option value="" >Choose Class</option>');
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
          $('select[name="section"]').append('<option value="" >Choose Section</option>');
          $.each(data, function(key, value) {
            $('select[name="section"]').append('<option value="'+ key +'">'+ value +'</option>');
          });
        }
      });
    });

    //---------------------------- custom field -------------------------------
    var max = 5; //Maximum allowed input fields 
    var multipleUploadWrapper    = $(".multipleUploadWrapper"); //Input fields wrapper
    var add_btn = $(".add_more"); //Add button class or ID
    var count = 1; //Initial input field is set to 1
 
    //When user click on add input button
    $(add_btn).click(function(e){
        e.preventDefault();
        //Check maximum allowed input fields
        if(count < max){ 
            count++; //input field increment
            //add input field
            $(multipleUploadWrapper).append('<div><div class="form-group col-sm-6"><label>'+'{{ trans("label.document_name") }}'+'</label><input type="text" class="form-control col-sm-12" name="file_name[]"  placeholder="'+'{{ trans("placeholder.document_name") }}'+'"></div><div class="form-group col-sm-6"><label>'+'{{ trans("label.document") }}'+'</label><input type="file" class="form-control col-sm-12" name="file[]" ></div><img src="http://localhost/gws/school/sc-sw/public/image/wrong.png" class="remove" width="30" height="30"></div>');

            // <div><div class="form-group col-sm-6"><label>'
            // +'{{ trans('label.document_name') }}'+'</label><input type="text" class="form-control col-sm-12" name="file_name[]"  placeholder="'+'{{ trans('placeholder.document_name') }}'+'"></div><div class="form-group col-sm-6"><label>'+'{{ trans('label.document') }}'+'</label><input type="file" class="form-control col-sm-12" name="file[]" ></div><img src="http://localhost/gws/school/sc-sw/public/image/wrong.png" class="remove" width="30" height="30"></div>
        }
    });
     
    //when user click on remove button
    $(multipleUploadWrapper).on("click",".remove", function(e){ 
        e.preventDefault();
        $(this).parent('div').remove(); //remove inout field
        count--; //inout field decrement
    })

  });
</script>
@endsection