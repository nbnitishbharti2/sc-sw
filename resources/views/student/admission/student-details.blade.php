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

                    <li class="nav-item" @if($student_admission_id!=0) onclick="location.href='{{ route('add.student.admission',['id' => $student_admission_id]) }}';" @endif><a class="nav-link {{ ($tab=='student_details')?'active':'' }}" href="#personal_details" data-toggle="tab">{{ trans('label.personal_details') }}</a></li>

                    <li class="nav-item" @if($student_admission_id!=0) onclick="location.href='{{ route('edit.student.admission.address',['id' => $student_admission_id,'map_id' => $student_session_detail_id]) }}';" @endif><a class="nav-link {{ ($tab=='student_address')?'active':'' }}">{{ trans('label.residential_address') }}</a></li>

                    <li class="nav-item" @if($student_admission_id!=0) onclick="location.href='{{ route('edit.student.admission.parent',['id' => $student_admission_id,'map_id' => $student_session_detail_id]) }}';" @endif><a class="nav-link {{ ($tab=='student_parent')?'active':'' }}" >{{ trans('label.guardians_details') }}</a></li> 

                    <li class="nav-item" @if($student_admission_id!=0) onclick="location.href='{{ route('edit.student.admission.multiple_upload',['id' => $student_admission_id,'map_id' => $student_session_detail_id]) }}';" @endif><a class="nav-link {{ ($tab=='multiple_document_upload')?'active':'' }}"  >{{ trans('label.multiple_document') }}</a></li>

                    <li class="nav-item" @if($student_admission_id!=0) onclick="location.href='{{ route('edit.student.admission.transport',['id' => $student_admission_id,'map_id' => $student_session_detail_id]) }}';" @endif><a class="nav-link {{ ($tab=='transport')?'active':'' }}"  >{{ trans('label.transport') }}</a></li>

                    <li class="nav-item" @if($student_admission_id!=0) onclick="location.href='{{ route('edit.student.admission.hostel',['id' => $student_admission_id,'map_id' => $student_session_detail_id]) }}';" @endif><a class="nav-link {{ ($tab=='hostel')?'active':'' }}"  >{{ trans('label.hostel') }}</a></li>

                    <li class="nav-item" @if($student_admission_id!=0) onclick="location.href='{{ route('edit.student.admission.charge',['id' => $student_admission_id,'map_id' => $student_session_detail_id]) }}';" @endif><a class="nav-link {{ ($tab=='student_charge')?'active':'' }}"  >{{ trans('label.charge') }}</a></li>
                    
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <!-- tab content starts here -->
                  <div class="tab-content">
                    <div class="{{ ($tab=='student_details')?'active':'' }} tab-pane" id="personal_details">
                      @if($tab=='student_details')
                      <form class="form-horizontal" action="{{ $action }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row"> 
                          <div class="col-sm-6"> 
                            <input type="hidden" name="student_id" value="{{ $student_id }}">
                            <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.admission_no') }}</label>
                            <input type="hidden" name="student_admission_id" value="{{ $student_admission_id }}">
                             <input type="hidden" name="type" value="{{ $type }}">
                              <input type="hidden" name="student_session_detail_id" value="{{ $student_session_detail_id }}">
                            <input type="text" class="form-control" value="{{ ($admission_no) ? $admission_no : old('admission_no') }}" id="inputName" name="admission_no"  placeholder="{{ trans('placeholder.admission_no') }}" > 
                            @if($errors->has('admission_no'))
                            <span class="alert-notice" role="alert">
                              <strong>{{ $errors->first('admission_no') }}</strong>
                            </span>
                            @endif
                          </div>
                          <div class="col-sm-6">
                            <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.roll_no') }}</label>
                            <input type="text" class="form-control" value="{{ ($roll_no) ? $roll_no : old('roll_no') }}" id="inputName" name="roll_no"  placeholder="{{ trans('placeholder.roll_no') }}" > 
                            @if($errors->has('roll_no'))
                            <span class="alert-notice" role="alert">
                              <strong>{{ $errors->first('roll_no') }}</strong>
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
                            <input type="text" class="form-control" value="{{ ($name) ? $name : old('name') }}" id="inputName" name="name" placeholder="{{ trans('placeholder.name') }}" autocomplete="off"> 
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
                              <option value="">Choose Class</option>
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
                              <option value="">Choose Section</option>
                              @foreach($section_list as $key=>$value)
                              <option value="{!! $key !!}" {{ ( $key == $section_id ) ? 'selected' : '' }}>{!! $value !!}</option>
                              @endforeach 
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
                              <option value="">Choose Gender</option>
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
                              <option value="">Choose Blood Group</option>
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
                              <option value="">Choose Category</option>
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
                            <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.siblings') }}</label>
                            <input type="text" class="form-control" value="{{ ($siblings) ? $siblings : old('siblings') }}" id="inputName" name="siblings"  placeholder="{{ trans('placeholder.siblings') }}" > 
                            @if($errors->has('siblings'))
                            <span class="alert-notice" role="alert">
                              <strong>{{ $errors->first('siblings') }}</strong>
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
                          <div class="col-sm-6">
                            <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.image') }}</label>
                            <input type="file" class="form-control" id="image" name="image" >
                            @if($errors->has('image'))
                            <span class="alert-notice" role="alert">
                              <strong>{{ $errors->first('image') }}</strong>
                            </span>
                            @endif
                          </div>
                          {{-- dd($image) --}}
                          @if($image)
                          <div class="col-sm-6">
                            <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.image') }}</label>
                            <img src="{{ asset('public/student_image/'.$image) }}" width="100" height="100" />
                          </div>
                          @endif
                        </div>

                        <div class="form-group row">
                          <div class="offset-sm-8 col-sm-10">
                             
                          </div>
                          <div class="offset-sm-8 col-sm-10">
                             @if($student_admission_id!=0)
                               <a href="{{ route('edit.student.admission.address',['id' => $student_admission_id,'map_id' => $student_session_detail_id]) }}"> <button type="button" class="btn btn-primary">{{ trans('button.skip') }}</button></a>
                               @endif 
                            <button type="submit" class="btn btn-danger">{{ trans('button.submit') }}</button>
                          </div>
                        </div>
                      </form>
                      @endif
                    </div>

                  </div>
                  <!-- tab content ends here -->

                  <!-- tab content starts here -->
                  <div class="{{ ($tab=='student_address')?'active':'' }} tab-pane" id="residential_details">
                  @if($tab=='student_address')
                  <form class="form-horizontal"  action="{{ $action }}" method="POST">
                  @csrf
                    <div class="form-group row"> 
                      <div class="col-sm-6">
                        <input type="hidden" name="id" value="{{ $student_admission_id }}">
                        <input type="hidden" name="map_id" value="{{ $student_session_detail_id }}">
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
                        @if($student_admission_id!=0)
                           <a href="{{ route('edit.student.admission.parent',['id' => $student_admission_id,'map_id' => $student_session_detail_id]) }}"> <button type="button" class="btn btn-primary">{{ trans('button.skip') }}</button></a>
                        @endif
                        <button type="submit" class="btn btn-danger">{{ trans('button.submit') }}</button>
                      </div>
                    </div>
                  </form>
                  @endif
                  </div>
                  <!-- tab content ends here -->


                  <!-- tab content starts here -->
                  <div class="{{ ($tab=='student_parent')?'active':'' }} tab-pane" id="guardians_details">
                  @if($tab=='student_parent')
                  <form class="form-horizontal"  action="{{ $action }}" method="POST">
                  @csrf
                    <div class="form-group row"> 
                      <div class="col-sm-6">
                        <input type="hidden" name="id" value="{{ $student_admission_id }}">
                        <input type="hidden" name="map_id" value="{{ $student_session_detail_id }}">
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
                          <option value="">Choose Father Occupation</option>
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
                          <option value="">Choose Father Education</option>
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
                          <option value="">Choose Mother Occupation</option>
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
                          <option value="">Choose Mother Education</option>
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
                      <div class="offset-sm-8 col-sm-10"> 
                      </div>
                      <div class="offset-sm-8 col-sm-10">
                        @if($student_admission_id!=0)
                          <a href="{{ route('edit.student.admission.multiple_upload',['id' => $student_admission_id,'map_id' => $student_session_detail_id]) }}"> <button type="button" class="btn btn-primary">{{ trans('button.skip') }}</button></a>
                        @endif
                        <button type="submit" class="btn btn-danger">{{ trans('button.submit') }}</button>
                      </div>
                    </div>
                  </form>
                  @endif
                  </div>
                  <!-- tab content ends here -->

                  <!-- tab content starts here -->
                  <div class="{{ ($tab=='multiple_document_upload')?'active':'' }} tab-pane" id="multiple_document">
                      @if($tab=='multiple_document_upload')
                      <form class="form-horizontal"  action="{{ $action }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row multipleUpload"> 
                          <!-- <div class="col-sm-12 multipleUpload"> -->
                            <input type="hidden" name="id" value="{{ $student_admission_id }}">
                            <input type="hidden" name="map_id" value="{{ $student_session_detail_id }}">

                            <div class="col-sm-12 multipleUploadWrapper">
                              <div>
                                <div class="form-group col-sm-6">
                                    <label>{{ trans('label.file_name') }}</label>
                                    <input type="text" class="form-control" name="file_name[]"  placeholder="{{ trans('placeholder.file_name') }}"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>{{ trans('label.file') }}</label>
                                    <input type="file" class="form-control" name="file[]" >  
                                </div>
                              </div>
                              @if($errors->has('file_name'))
                              <span class="alert-notice" role="alert">
                                <strong>{{ $errors->first('file_name') }}</strong>
                              </span>
                              @endif
                              @if($errors->has('file'))
                              <span class="alert-notice" role="alert">
                                <strong>{{ $errors->first('file') }}</strong>
                              </span>
                              @endif
                            </div>
                            <div class="col-sm-6">
                              <button class="add_more">Add More Fields</button>
                            </div>
                          <!-- </div> -->
                        </div>

                      <div class="form-group row">
                       <div class="offset-sm-8 col-sm-10"> 
                          </div>
                          <div class="offset-sm-8 col-sm-10">
                            @if($student_admission_id!=0)
                              <a href="{{ route('edit.student.admission.transport',['id' => $student_admission_id,'map_id' => $student_session_detail_id]) }}"> <button type="button" class="btn btn-primary">{{ trans('button.skip') }}</button></a>
                               @endif
                            <button type="submit" class="btn btn-danger">{{ trans('button.submit') }}</button>
                          </div>
                      </div>
                    </form>
                    @endif
                  </div>
                  <!-- tab content ends here -->



                  <!-- tab content starts here -->
                  <div class="{{ ($tab=='transport')?'active':'' }} tab-pane" id="transport">
                      @if($tab=='transport')
                      <form class="form-horizontal"  action="{{ $action }}" method="POST">
                        @csrf
                        <div class="form-group row">
                          <div class="col-sm-6">
                            <input type="hidden" name="id" value="{{ $student_admission_id }}">
                            <input type="hidden" name="map_id" value="{{ $student_session_detail_id }}">
                            <label for="root_id">{{trans('label.root_id')}}</label>
                            <select name="root_id" id="root_id" class="form-control">
                              <option value="">Choose Root</option>
                              @foreach($root_list as $root)
                                <option value="{!! $root->id !!}" {{ ( $root->id == $root_id ) ? 'selected' : '' }}>{!! $root->name !!}</option>
                              @endforeach
                            </select>
                            @if($errors->has('root_id'))
                            <span class="alert-notice" role="alert">
                              <strong>{{ $errors->first('root_id') }}</strong>
                            </span>
                            @endif
                          </div>

                        <div class="col-sm-6">
                          <label for="vehicle_type_id">{{trans('label.vehicle_type_id')}}</label>
                          <select name="vehicle_type_id" id="vehicle_type_id" class="form-control">
                            <option value="">Choose Vehicle Type</option>
                            @foreach($vehicle_type_list as $key=>$value)
                            <option value="{{$key}}" {{ old('vehicle_type_id',$vehicle_type_id) == $key ? 'selected' : '' }}>{{$value}}</option>
                            @endforeach
                          </select>
                          @if($errors->has('vehicle_type_id'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('vehicle_type_id') }}</strong>
                          </span>
                          @endif
                        </div>

                        <div class="col-sm-6">
                          <label for="vehicle_id">{{trans('label.vehicle_id')}}</label>
                          <select name="vehicle_id" id="vehicle_id" class="form-control">
                            <option value="">Choose Vehicle</option>
                            @foreach($vehicle_list as $key=>$value)
                            <option value="{{$key}}" {{ old('vehicle_id',$vehicle_id) == $key ? 'selected' : '' }}>{{$value}}</option>
                            @endforeach
                          </select>
                          @if($errors->has('vehicle_id'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('vehicle_id') }}</strong>
                          </span>
                          @endif  
                        </div>

                        <div class="col-sm-6">
                          <label for="stopage_id">{{trans('label.stopage_id')}}</label>
                          <select name="stopage_id" id="stopage_id" class="form-control">
                            <option value="">Choose Stopage</option>
                            @foreach($stopage_list as $key=>$value)
                            <option value="{{$key}}" {{ old('stopage_id',$stopage_id) == $key ? 'selected' : '' }}>{{$value}}</option>
                            @endforeach
                          </select>
                          @if($errors->has('stopage_id'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('stopage_id') }}</strong>
                          </span>
                          @endif  
                        </div>

                        <div class="col-sm-6">
                          <label for="amount">{{trans('label.amount')}}</label>
                          <input type="text" id="amount" class="form-control" name="amount" value="{{ ($amount) ? $amount : '' }}" placeholder="{{ trans('placeholder.amount') }}" readonly />
                          @if($errors->has('amount'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('amount') }}</strong>
                          </span>
                          @endif  
                        </div>

                        <input type="hidden" name="fee_head_id" value="2" />
                        <input type="hidden" name="fee_type_id" value="3" />
                    
                        
                      </div>

                      <div class="form-group row">
                        <div class="offset-sm-8 col-sm-10"> 
                        </div>
                        <div class="offset-sm-8 col-sm-10">
                          @if($student_admission_id!=0)
                            <a href="{{ route('edit.student.admission.hostel',['id' => $student_admission_id,'map_id' => $student_session_detail_id]) }}"> <button type="button" class="btn btn-primary">{{ trans('button.skip') }}</button></a>
                          @endif
                          <button type="submit" class="btn btn-danger">{{ trans('button.submit') }}</button>
                        </div>
                      </div>
                    </form>
                    @endif
                  </div>
                  <!-- tab content ends here -->



                  <!-- tab content starts here -->
                  <div class="{{ ($tab=='hostel')?'active':'' }} tab-pane" id="hostel">
                      @if($tab=='hostel')
                      <form class="form-horizontal"  action="{{ $action }}" method="POST">
                        @csrf
                        <div class="form-group row">
                          <div class="col-sm-6">
                            <input type="hidden" name="id" value="{{ $student_admission_id }}">
                            <input type="hidden" name="map_id" value="{{ $student_session_detail_id }}">
                            <input type="hidden" name="session_id" value="{{ $session_id }}" id="session_id">

                            <label for="hostel_id">{{trans('label.hostel_id')}}</label>
                            <select name="hostel_id" id="hostel_id" class="form-control">
                              <option value="">Choose Hostel</option>
                              @foreach($hostel_list as $hostel)
                                <option value="{!! $hostel->id !!}" {{ ( old('hostel_id',$hostel_id) == $hostel->id) ? 'selected' : '' }}>{!! $hostel->name !!}</option>
                              @endforeach
                            </select>
                            @if($errors->has('hostel_id'))
                            <span class="alert-notice" role="alert">
                              <strong>{{ $errors->first('hostel_id') }}</strong>
                            </span>
                            @endif
                          </div>

                          <div class="col-sm-6">
                            <label for="room_id">{{trans('label.room_id')}}</label>
                            <select name="room_id" id="room_id" class="form-control">
                              <option value="">Choose Room</option>
                              @foreach($room_list as $key=>$value)
                                <option value="{!! $key !!}" {{ ( old('room_id',$room_id) == $key) ? 'selected' : '' }}>{!! $value !!}</option>
                              @endforeach
                            </select>
                            @if($errors->has('room_id'))
                            <span class="alert-notice" role="alert">
                              <strong>{{ $errors->first('room_id') }}</strong>
                            </span>
                            @endif
                          </div>

                          <div class="col-sm-6">
                            <label for="bed_no">{{trans('label.bed_no')}}</label>
                            <select name="bed_no" class="form-control" id="bed_no">
                              <option value="">Choose Bed No</option>
                              @foreach($bed_no_list as $key=>$value)
                                <option value="{!! $value !!}" {{ ( old('bed_no',$bed_no) == $value) ? 'selected' : '' }}>{!! $value !!}</option>
                              @endforeach
                            </select>
                            @if($errors->has('bed_no'))
                            <span class="alert-notice" role="alert">
                              <strong>{{ $errors->first('bed_no') }}</strong>
                            </span>
                            @endif
                          </div>

                          <div class="col-sm-6">
                            <label for="amount">{{trans('label.amount')}}</label>
                            <input type="text" id="amount" class="form-control" name="amount" value="{{ ($amount) ? $amount : '' }}" placeholder="{{ trans('placeholder.amount') }}" readonly />
                            @if($errors->has('amount'))
                            <span class="alert-notice" role="alert">
                              <strong>{{ $errors->first('amount') }}</strong>
                            </span>
                            @endif  
                          </div>

                        </div>

                        <div class="form-group">
                          <label for="hostel_fee_ids">{{trans('label.hostel_fee_ids')}}</label>
                        </div>
                        <div class="row form-group">
                          {{-- dd($hostel_fee_list) --}}
                          @foreach($hostel_fee_list as $hostel_fee)
                          {{-- dd($hostel_fee) --}}
                          <div  class="icheck-primary col-sm-3">
                            <input type="checkbox" value="{{$hostel_fee->id}}" name="hostel_fee_ids[]" id="hostel_fee{{$hostel_fee->id}}" {{ (in_array($hostel_fee->id,$hostel_fee_ids))?'checked':'' }} @php if(in_array($hostel_fee->id,old('hostel_fee_ids',array()))){ echo "checked";}@endphp>
                            <!-- value has ids instead of amount -->
                            <label for="hostel_fee{{$hostel_fee->id}}">{{$hostel_fee->fee_name}}</label>
                          </div>
                          @endforeach

                          @if($errors->has('hostel_fee_ids'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('hostel_fee_ids') }}</strong>
                          </span>
                          @endif

                        </div>
                    

                        <div class="form-group row">
                          <div class="offset-sm-8 col-sm-10"> 
                          </div>
                          <div class="offset-sm-8 col-sm-10">
                            @if($student_admission_id!=0)
                              <a href="{{ route('edit.student.admission.charge',['id' => $student_admission_id,'map_id'=>$student_session_detail_id]) }}"> <button type="button" class="btn btn-primary">{{ trans('button.skip') }}</button></a>
                            @endif
                            <button type="submit" class="btn btn-danger">{{ trans('button.submit') }}</button>
                          </div>
                        </div>
                    </form>
                    @endif
                  </div>
                  <!-- tab content ends here -->



                  <!-- tab content starts here -->
                  <div class="{{ ($tab=='student_charge')?'active':'' }} tab-pane" id="hostel">
                      @if($tab=='student_charge')
                      <form class="form-horizontal"  action="{{ $action }}" method="POST">
                        @csrf
                        <div class="form-group row">
                          <div class="col-sm-6">
                            <input type="hidden" name="id" value="{{ $student_admission_id }}">
                            <input type="hidden" name="map_id" value="{{ $student_session_detail_id }}">
                            <input type="hidden" name="session_id" value="{{ $session_id }}" id="session_id">



                            @php $total=0 @endphp
                            @foreach($fee['fees'] as $key =>$value)
                              @php $total=$total+$value->charge @endphp
                              <div class="col-sm-6"> 
                                <label for="inputName" class="col-sm-12 col-form-label">{{ $value->fee->fee_name }}</label>
                                <input type="email" class="form-control" id="inputName" placeholder="Charge" readonly="" value="{{ $value->charge }}">
                              </div>
                            @endforeach
                            
                          </div>
                        </div>

                          

                        <div class="form-group">
                          <label for="hostel_fee_ids">{{trans('label.hostel_fee_ids')}}</label>
                        </div>
                        <div class="row form-group">
                          @foreach($hostel_fee_list as $hostel_fee)
                          {{-- dd($hostel_fee) --}}
                          <div  class="icheck-primary col-sm-3">
                            <input type="checkbox" value="{{$hostel_fee->id}}" name="hostel_fee_ids[]" id="hostel_fee{{$hostel_fee->id}}" {{ (in_array($hostel_fee->amount,$hostel_fee_ids))?'checked':'' }} @php if(in_array($hostel_fee->amount,old('hostel_fee_ids',array()))){ echo "checked";}@endphp>
                            <!-- value has ids instead of amount -->
                            <label for="hostel_fee{{$hostel_fee->id}}">{{$hostel_fee->fee_name}}</label>
                          </div>
                          @endforeach

                          @if($errors->has('hostel_fee_ids'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('hostel_fee_ids') }}</strong>
                          </span>
                          @endif

                        </div>
                    

                        <div class="form-group row">
                          <div class="offset-sm-8 col-sm-10"> 
                          </div>
                          <div class="offset-sm-8 col-sm-10">
                            @if($student_admission_id!=0)
                              <a href=""> <button type="button" class="btn btn-primary">{{ trans('button.skip') }}</button></a>
                            @endif
                            <button type="submit" class="btn btn-danger">{{ trans('button.submit') }}</button>
                          </div>
                        </div>
                    </form>
                    @endif
                  </div>
                  <!-- tab content ends here -->



                </div>

              </div>
            </div>

          </div>
        </div>
      </section>

    </div><!-- /.card-body -->
  </div>
  <!-- /.nav-tabs-custom -->
</body>

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
    //--------------------------Class Ajax Starts Here----------------------------
    if($('#session').val())
    {
      var session_id = $('#session').val();

      var form_data = new FormData();
      form_data.append('session_id',session_id);
      form_data.append('_token', '{{csrf_token()}}');

      var old_class_id='{{ (isset($class_id)) ? $class_id : '' }}';
      if(old_class_id == 0) {
        $('#class').html('<option>Choose Class</option>');
      }
      else {
        $.ajax({
          url: "{{route('get-class-list-with-session')}}",
          data: form_data,
          type: 'POST',
          dataType: "json",
          contentType: false,
          processData: false,
          success:function(data) { 
            $('#class option').remove();
            $('select[name="class"]').append('<option>Choose Class</option>');
            $.each(data, function(key, value) {
                var select='';
                if(old_class_id==key){select='selected';}
                $('select[name="class"]').append('<option value="'+ key +'" "'+select+'" >'+ value +'</option>');
            });
            $("#class").val(old_class_id);
          }  
        });
      }
    }
    if(old_class_id)  
    {
      var class_id = old_class_id; 
      var session =$('#session').val(); 

      var form_data = new FormData();
      form_data.append('class_id',class_id);
      form_data.append('session_id',session_id);
      form_data.append('_token', '{{csrf_token()}}');

      var old_section_id='{{ (isset($section_id)) ? $section_id : '' }}'; 
      if(old_section_id == 0) {
        $('#section').html('<option value="">Choose Section</option>');
      }
      else {
        $.ajax({
          url: "{{route('get-section-list-of-current-session-class')}}",
          data: form_data,
          type: 'POST',
          dataType: "json",
          contentType: false,
          processData: false,
          success:function(data) { 
            $('#section option').remove();
            $('select[name="section"]').append('<option value="">Choose Section</option>');
            $.each(data, function(key, value) {
              var select='';
              if(old_section_id==key){select='selected';}
              $('select[name="section"]').append('<option value="'+ key +'" "'+select+'" >'+ value +'</option>');
            });
            $("#section").val(old_section_id);
          }
        });
      }
    }
    //--------------------------Class Ajax Ends Here---------------------------------

    //--------------------------Transport Ajax Starts Here----------------------------
    
    //vehicletype and vehicle ajax is removed from here

    //stopage ajax is removed
    
    if($('#stopage_id').val())
    {
      old_stopage_id = ($stopage_id) ? $stopage_id : '';
      var stopage_id = ($('#stopage_id').val()) ? $('#stopage_id').val() : old_stopage_id;
    
      var form_data = new FormData();
      form_data.append('stopage_id',stopage_id);
      form_data.append('_token', '{{csrf_token()}}');
     
      var old_amount=($amount) ? $amount : '';
      if(old_amount == 0) {
        $('#amount').val('');
      }
      else {
        $.ajax({
          url: "{{route('get-amount-from-stopage-id')}}",
          data: form_data,
          type: 'POST',
          dataType: "json",
          contentType: false,
          processData: false,
          success:function(data) { 
            $("#amount").val(data);
          }
        });
      }
    }

    
    //----------------------------Transport Ajax Ends Here--------------------------
  });


  $(document).ready(function(){
    //--------------------------Class Ajax Starts Here----------------------------
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
          $('select[name="class"]').append('<option value="">Choose Class</option>');
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
        url: "{{route('get-section-list-of-current-session-class')}}",
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

    //--------------------------Class Ajax Ends Here----------------------------------

    //--------------------------Transport Ajax Starts Here----------------------------
    $('#root_id').on('change', function(){
      
      var root_id = $(this).val();

      var form_data = new FormData();
      form_data.append('root_id',root_id);
      form_data.append('_token', '{{csrf_token()}}');

      $.ajax({
        url: "{{route('get-vehicle-type-from-vehicle-root-map')}}",
        data: form_data,
        type: 'POST',
        dataType: "json",
        contentType: false,
        processData: false,
        success:function(data) { 
          $('#vehicle_type_id option').remove();
          $('select[name="vehicle_type_id"]').append('<option value="">Choose Vehicle Type</option>');
          $.each(data, function(key, value) {
            $('select[name="vehicle_type_id"]').append('<option value="'+ key +'">'+ value +'</option>');
          });
        }
      });
    });

    $('#vehicle_type_id').on('change', function(){

      var vehicle_type_id = $(this).val();
      var root_id =$('#root_id').val();
        
      var form_data = new FormData();
      form_data.append('root_id',root_id);
      form_data.append('vehicle_type_id',vehicle_type_id);
      form_data.append('_token', '{{csrf_token()}}');

      $.ajax({
        url: "{{route('get-vehicle-no-from-vehicle-root-map')}}",
        data: form_data,
        type: 'POST',
        dataType: "json",
        contentType: false,
        processData: false,
        success:function(data) { 
          $('#vehicle_id option').remove();
          $('select[name="vehicle_id"]').append('<option value="" >Choose Vehicle</option>');
          $.each(data, function(key, value) {
            $('select[name="vehicle_id"]').append('<option value="'+ key +'">'+ value +'</option>');
          });
        }
      });
    });

    $('#vehicle_id').on('change', function(){

      var vehicle_id = $(this).val();
      var root_id =$('#root_id').val();
      var vehicle_type_id =$('#vehicle_type_id').val();
        
      var form_data = new FormData();
      form_data.append('vehicle_id',vehicle_id);
      form_data.append('root_id',root_id);
      form_data.append('vehicle_type_id',vehicle_type_id);
      form_data.append('_token', '{{csrf_token()}}');

      $.ajax({
        url: "{{route('get-stopage-list-from-vehicle-id')}}",
        data: form_data,
        type: 'POST',
        dataType: "json",
        contentType: false,
        processData: false,
        success:function(data) { 
          $('#stopage_id option').remove();
          $('select[name="stopage_id"]').append('<option value="" >Choose Stopage</option>');
          $.each(data, function(key, value) {
            $('select[name="stopage_id"]').append('<option value="'+ key +'">'+ value +'</option>');
          });
        }
      });
    });

    $('#stopage_id').on('change', function(){
      var stopage_id = $(this).val();
        
      var form_data = new FormData();
      form_data.append('stopage_id',stopage_id);
      form_data.append('_token', '{{csrf_token()}}');

      $.ajax({
        url: "{{route('get-amount-from-stopage-id')}}",
        data: form_data,
        type: 'POST',
        dataType: "json",
        contentType: false,
        processData: false,
        success:function(data) { 
          $('#amount').val(data);
          
        }
      });
    });

    //----------------------------Transport Ajax Ends Here--------------------------

    //---------------------------Hostel Ajax Starts Here----------------------------
    $('#hostel_id').on('change', function(){
      
      var hostel_id = $(this).val();
      var session_id = $('#session_id').val();

      var form_data = new FormData();
      form_data.append('hostel_id',hostel_id);
      form_data.append('session_id',session_id);
      form_data.append('_token', '{{csrf_token()}}');

      $.ajax({
        url: "{{route('get-room-list-from-hostel-id')}}",
        data: form_data,
        type: 'POST',
        dataType: "json",
        contentType: false,
        processData: false,
        success:function(data) { 
          console.log(data);
          $('#room_id option').remove();
          $('select[name="room_id"]').append('<option value="">Choose Room</option>');
          $.each(data, function(key, value) {
            $('select[name="room_id"]').append('<option value="'+ key +'">'+ value +'</option>');
          });
        }
      });
    });

    $('#room_id').on('change', function(){
      
      var room_id = $(this).val();
      var session_id = $('#session_id').val();

      var form_data = new FormData();
      form_data.append('room_id',room_id);
      form_data.append('session_id',session_id);
      form_data.append('_token', '{{csrf_token()}}');

      $.ajax({
        url: "{{route('get-charge-from-room-id')}}",
        data: form_data,
        type: 'POST',
        dataType: "json",
        contentType: false,
        processData: false,
        success:function(data) { 
          console.log(data);
          console.log(data.charge);
          console.log(data.bed_no_list);

          $('#amount').val(data.charge);

          $('#bed_no option').remove();
          $('select[name="bed_no"]').append('<option value="">Choose Bed No</option>');
          $.each(data.bed_no_list, function(key, value) {
            $('select[name="bed_no"]').append('<option value="'+ value +'">'+ value +'</option>');
          });
          
        }
      });
    });
    //---------------------------Hostel Ajax Ends Here------------------------------


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
    });

  });
</script>
@endsection