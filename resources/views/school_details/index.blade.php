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
              <h1>{{ $title}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">{{ $title}}</li>
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

                    @if(Helper::checkPermission('view-school-details'))
                    <li class="nav-item" onclick="location.href='{{ route('view.school-details') }}';"><a class="nav-link {{ ($tab=='school_details')?'active':'' }}" href="{{ route('view.school-details') }}" data-toggle="tab">{{ trans('title.school_details') }}</a></li>
                    @endif

                   {{--  @if(isset($school_details['id'])) --}}
                    <li class="nav-item" onclick="location.href='{{ route('view.sms-details') }}';"><a class="nav-link {{ ($tab=='sms')?'active':'' }}" href="#sms_details" data-toggle="tab">{{ trans('title.sms_details') }}</a></li>
                  {{--   @endif --}}
                    <li class="nav-item" onclick="location.href='{{ route('view.smtp-details') }}';"><a class="nav-link {{ ($tab=='smtp')?'active':'' }}" href="#smtp" data-toggle="tab">{{ trans('title.smtp') }}</a></li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <div class="{{ ($tab=='school_details')?'active':'' }} tab-pane" id="school_details">
                      @if($tab=='school_details')
                     <form class="form-horizontal" action="{{ $action }}" method="POST">
                      @csrf
                      <div class="form-group row"> 
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.school_name') }}</label>
                          <input type="text" class="form-control" name="school_name" id="inputName" placeholder="{{ trans('placeholder.school_name') }}" value="{{ ($school_details['school_name']) ? $school_details['school_name'] : old('school_name') }}"> 
                          @if($errors->has('school_name'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('school_name') }}</strong>
                          </span>
                          @endif
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.school_short_name') }}</label>
                          <input type="text" class="form-control" name="school_short_name" id="inputName" placeholder="{{ trans('placeholder.school_short_name') }}" value="{{ ($school_details['school_short_name']) ? $school_details['school_short_name'] : old('school_short_name') }}"> 
                          @if($errors->has('school_short_name'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('school_short_name') }}</strong>
                          </span>
                          @endif
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.mobile_no') }}</label>
                          <input type="text" class="form-control" name="mobile_no" id="inputName" placeholder="{{ trans('placeholder.mobile_no') }}" value="{{ ($school_details['mobile_no']) ? $school_details['mobile_no'] : old('mobile_no') }}"> 
                          @if($errors->has('mobile_no'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('mobile_no') }}</strong>
                          </span>
                          @endif
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.mobile_no2') }}</label>
                          <input type="text" class="form-control" name="mobile_no_2" id="inputName" placeholder="{{ trans('placeholder.mobile_no2') }}" value="{{ ($school_details['mobile_no2']) ? $school_details['mobile_no2'] : old('mobile_no_2') }}"> 
                          @if($errors->has('mobile_no_2'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('mobile_no_2') }}</strong>
                          </span>
                          @endif
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.phone_no') }}</label>
                          <input type="text" class="form-control" name="phone_no" id="inputName" placeholder="{{ trans('placeholder.phone_no') }}" value="{{ ($school_details['phone_no']) ? $school_details['phone_no'] : old('phone_no') }}"> 
                          @if($errors->has('phone_no'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('phone_no') }}</strong>
                          </span>
                          @endif
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.email') }}</label>
                          <input type="text" class="form-control" name="email" id="inputName" placeholder="{{ trans('placeholder.email') }}" value="{{ ($school_details['email']) ? $school_details['email'] : old('email') }}"> 
                          @if($errors->has('email'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                          </span>
                          @endif
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.web_site') }}</label>
                          <input type="text" class="form-control" name="web_site" id="inputName" placeholder="{{ trans('placeholder.web_site') }}" value="{{ ($school_details['web_site']) ? $school_details['web_site'] : old('web_site') }}"> 
                          @if($errors->has('web_site'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('web_site') }}</strong>
                          </span>
                          @endif
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.city') }}</label>
                          <input type="text" class="form-control" name="city" id="inputName" placeholder="{{ trans('placeholder.city') }}" value="{{ ($school_details['city']) ? $school_details['city'] : old('city') }}"> 
                          @if($errors->has('city'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('city') }}</strong>
                          </span>
                          @endif
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.state') }}</label>
                          <input type="text" class="form-control" name="state" id="inputName" placeholder="{{ trans('placeholder.state') }}" value="{{ ($school_details['state']) ? $school_details['state'] : old('state') }}"> 
                          @if($errors->has('state'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('state') }}</strong>
                          </span>
                          @endif
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.country') }}</label>
                          <input type="text" class="form-control" name="country" id="inputName" placeholder="{{ trans('placeholder.country') }}" value="{{ ($school_details['country']) ? $school_details['country'] : old('country') }}"> 
                          @if($errors->has('country'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('country') }}</strong>
                          </span>
                          @endif
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.pin_code') }}</label>
                          <input type="text" class="form-control" name="pin_code" id="inputName" placeholder="{{ trans('placeholder.pin_code') }}" value="{{ ($school_details['pin_code']) ? $school_details['pin_code'] : old('pin_code') }}"> 
                          @if($errors->has('pin_code'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('pin_code') }}</strong>
                          </span>
                          @endif
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.country_code') }}</label>
                          <input type="text" class="form-control" name="country_code" id="inputName" placeholder="{{ trans('placeholder.country_code') }}" value="{{ ($school_details['country_code']) ? $school_details['country_code'] : old('country_code') }}"> 
                          @if($errors->has('country_code'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('country_code') }}</strong>
                          </span>
                          @endif
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.country_phone_code') }}</label>
                          <input type="text" class="form-control" name="country_phone_code" id="inputName" placeholder="{{ trans('placeholder.country_phone_code') }}" value="{{ ($school_details['country_phone_code']) ? $school_details['country_phone_code'] : old('country_phone_code') }}"> 
                          @if($errors->has('country_phone_code'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('country_phone_code') }}</strong>
                          </span>
                          @endif
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.currency') }}</label>
                          <input type="text" class="form-control" name="currency" id="inputName" placeholder="{{ trans('placeholder.currency') }}" value="{{ ($school_details['currency']) ? $school_details['currency'] : old('currency') }}"> 
                          @if($errors->has('currency'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('currency') }}</strong>
                          </span>
                          @endif
                        </div>
                         <div class="col-sm-12">
                          <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.address') }}</label>
                          <textarea class="form-control" name="address" id="inputName" placeholder="{{ trans('placeholder.address') }}">{{ ($school_details['address']) ? $school_details['address'] : old('address') }}</textarea>
                          @if($errors->has('address'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('address') }}</strong>
                          </span>
                          @endif
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.logo') }}</label>
                          <input type="file" class="form-control" name="logo" id="inputName" placeholder="{{ trans('placeholder.logo') }}" value="{{ ($school_details['logo']) ? $school_details['logo'] : old('logo') }}"> 
                          @if($errors->has('logo'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('logo') }}</strong>
                          </span>
                          @endif
                          <img src="{{ ($school_details['logo']) ? $school_details['logo'] : '' }}" alt="">
                        </div>
                        <div class="col-sm-6">
                          <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.water_mark') }}</label>
                          <input type="file" class="form-control" name="water_mark" id="inputName" placeholder="{{ trans('placeholder.water_mark') }}" value="{{ ($school_details['currency']) ? $school_details['currency'] : old('currency') }}"> 
                          @if($errors->has('water_mark'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('water_mark') }}</strong>
                          </span>
                          @endif
                          <img src="{{ ($school_details['water_mark']) ? $school_details['water_mark'] : '' }}" alt="">
                        </div>
                      </div>



                      <div class="form-group row">
                        <div class="offset-sm-10 col-sm-2">
                          <input type="hidden" name="id" value="{{ ($school_details['id']) ? $school_details['id'] : '' }}">
                          @if(isset($school_details['id']))
                         <a href="{{ route('view.sms-details') }}"> <button type="button" class="btn btn-primary">{{ trans('button.skip') }}</button></a>
                         @endif
                          <button type="submit" class="btn btn-success">{{ trans('button.submit') }}</button>
                        </div>
                      </div>
                    </form>
                    @endif
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane {{ ($tab=='sms')?'active':'' }}" id="sms_details">
                    @if($tab=='sms')
                    <form class="form-horizontal" action="{{ $action }}" method="POST">
                      @csrf
                     <div class="form-group row"> 
                      <div class="col-sm-6">
                        <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.user_name') }}</label>
                        <input type="text" class="form-control" id="inputName"   name="user_name" placeholder="{{ trans('placeholder.user_name') }}" value="{{ ($sms_cretedantials['user_name']) ? $sms_cretedantials['user_name'] : old('user_name') }}"> 
                          @if($errors->has('user_name'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('user_name') }}</strong>
                          </span>
                          @endif
                        </div>
                       <div class="col-sm-6">
                        <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.password') }}</label>
                        <input type="text" class="form-control" id="inputName"   name="password" placeholder="{{ trans('placeholder.password') }}" value="{{ ($sms_cretedantials['password']) ? $sms_cretedantials['password'] : old('password') }}"> 
                          @if($errors->has('password'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                          </span>
                          @endif
                        </div>
                     <div class="col-sm-6">
                        <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.api_key') }}</label>
                        <input type="text" class="form-control" id="inputName"   name="api_key" placeholder="{{ trans('placeholder.api_key') }}" value="{{ ($sms_cretedantials['api_key']) ? $sms_cretedantials['api_key'] : old('api_key') }}"> 
                          @if($errors->has('api_key'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('api_key') }}</strong>
                          </span>
                          @endif
                        </div>
                        <div class="col-sm-6">
                        <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.sender_id') }}</label>
                        <input type="text" class="form-control" id="inputName"   name="sender_id" placeholder="{{ trans('placeholder.sender_id') }}" value="{{ ($sms_cretedantials['sender_id']) ? $sms_cretedantials['sender_id'] : old('sender_id') }}"> 
                          @if($errors->has('sender_id'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('sender_id') }}</strong>
                          </span>
                          @endif
                        </div>
                        <div class="col-sm-12">
                        <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.sms_url') }}</label>
                        <input type="text" class="form-control" id="inputName"   name="sms_url" placeholder="{{ trans('placeholder.sms_url') }}" value="{{ ($sms_cretedantials['sms_gateway_url']) ? $sms_cretedantials['sms_gateway_url'] : old('sms_url') }}"> 
                          @if($errors->has('sms_url'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('sms_url') }}</strong>
                          </span>
                          @endif
                        </div>
                     

                    </div>

                   <div class="form-group row">
                        <div class="offset-sm-9 col-sm-3">
                          <input type="hidden" name="id" value="{{ ($sms_cretedantials['id']) ? $sms_cretedantials['id'] : '' }}">
                          <a href="{{ route('view.school-details') }}"><button type="button" class="btn btn-info">{{ trans('button.back') }}</button></a>
                           <a href="{{ route('view.smtp-details') }}"><button type="button" class="btn btn-primary">{{ trans('button.skip') }}</button></a>
                          <button type="submit" class="btn btn-success">{{ trans('button.submit') }}</button>
                        </div>
                      </div>
                  </form>
                  @endif
                </div>
                <!-- /.tab-pane -->

                <div class="tab-pane {{ ($tab=='smtp')?'active':'' }}" id="smtp">
                   @if($tab=='smtp')
                  <form class="form-horizontal"  action="{{ $action }}" method="POST">
                      @csrf
                   <div class="form-group row"> 
                     <div class="col-sm-6">
                        <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.email') }}</label>
                        <input type="text" class="form-control" id="inputName"   name="email" placeholder="{{ trans('placeholder.email') }}" value="{{ ($smtp_cretedantials['email']) ? $smtp_cretedantials['email'] : old('email') }}"> 
                          @if($errors->has('email'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                          </span>
                          @endif
                        </div>
                       <div class="col-sm-6">
                        <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.password') }}</label>
                        <input type="text" class="form-control" id="inputName"   name="password" placeholder="{{ trans('placeholder.password') }}" value="{{ ($smtp_cretedantials['password']) ? $smtp_cretedantials['password'] : old('password') }}"> 
                          @if($errors->has('password'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                          </span>
                          @endif
                        </div>
                         <div class="col-sm-6">
                        <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.host') }}</label>
                        <input type="text" class="form-control" id="inputName"   name="host" placeholder="{{ trans('placeholder.host') }}" value="{{ ($smtp_cretedantials['host']) ? $smtp_cretedantials['host'] : old('host') }}"> 
                          @if($errors->has('host'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('host') }}</strong>
                          </span>
                          @endif
                        </div>
                         <div class="col-sm-6">
                        <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.port') }}</label>
                        <input type="text" class="form-control" id="inputName"   name="port" placeholder="{{ trans('placeholder.port') }}" value="{{ ($smtp_cretedantials['port']) ? $smtp_cretedantials['port'] : old('port') }}"> 
                          @if($errors->has('port'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('port') }}</strong>
                          </span>
                          @endif
                        </div>
                         <div class="col-sm-6">
                        <label for="inputName" class="col-sm-12 col-form-label">{{ trans('label.smtp_type') }}</label>
                        <input type="text" class="form-control" id="inputName"   name="smtp_type" placeholder="{{ trans('placeholder.smtp_type') }}" value="{{ ($smtp_cretedantials['smtp_type']) ? $smtp_cretedantials['smtp_type'] : old('smtp_type') }}"> 
                          @if($errors->has('smtp_type'))
                          <span class="alert-notice" role="alert">
                            <strong>{{ $errors->first('smtp_type') }}</strong>
                          </span>
                          @endif
                        </div>
                  </div>

                    <div class="form-group row">
                        <div class="offset-sm-9 col-sm-3">
                          <input type="hidden" name="id" value="{{ ($smtp_cretedantials['id']) ? $smtp_cretedantials['id'] : '' }}">
                          <a href="{{ route('view.sms-details') }}"><button type="button" class="btn btn-info">{{ trans('button.back') }}</button></a> 
                          <button type="submit" class="btn btn-success">{{ trans('button.submit') }}</button>
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
@include('layouts.footer')
</div>
@endsection
@section('script') 
<script src="{{ asset('public/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function () {
    bsCustomFileInput.init();
  });
</script>
@endsection