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
						<div class="col-md-10">
							<h1>{!! $page_title !!}</h1>
						</div>
						<div class="col-md-2 text-right">
							<a href="{!! route('view.vehicle') !!}" class="btn btn-success"><i class="fa fa-arrow-left"></i> &nbsp; {{Lang::get('button.back')}}</a>
						</div>
					</div>
				</div><!-- /.container-fluid -->
			</section>
			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-3"></div>
						<!-- left column -->
						<div class="col-md-6">
							<!-- general form elements -->
							<div class="card card-primary">
								<div class="card-header">
									<h3 class="card-title">{!! $title !!}</h3>
								</div>
								<!-- /.card-header -->
								<!-- form start -->
								<form role="form" action="{{ $action }}" method="POST">
									@csrf
									<input type="hidden" name="vehicle_id" value="{{ $vehicle_id }}">
									<div class="card-body">
										<!-- <div class="row"> -->
										<div class="form-group">
											<label for="driver_name">{{Lang::get('label.driver_name')}}</label>
											<input type="text" class="form-control" value="{{ ($driver_name) ? $driver_name : old('driver_name') }}" id="driver_name" name="driver_name" placeholder="{{Lang::get('placeholder.driver_name')}}">
										</div>
										@if($errors->has('driver_name'))
											<span class="alert-notice" role="alert">
				                                <strong>{{ $errors->first('driver_name') }}</strong>
				                            </span>
				                        @endif

				                        <div class="form-group">
											<label for="driver_contact_no">{{Lang::get('label.driver_contact_no')}}</label>
											<input type="text" class="form-control" value="{{ ($driver_contact_no) ? $driver_contact_no : old('driver_contact_no') }}" id="driver_contact_no" name="driver_contact_no" placeholder="{{Lang::get('placeholder.driver_contact_no')}}">
										</div>
										@if($errors->has('driver_contact_no'))
											<span class="alert-notice" role="alert">
				                                <strong>{{ $errors->first('driver_contact_no') }}</strong>
				                            </span>
				                        @endif

				                        <div class="form-group">
											<label for="helper_name">{{Lang::get('label.helper_name')}}</label>
											<input type="text" class="form-control" value="{{ ($helper_name) ? $helper_name : old('helper_name') }}" id="helper_name" name="helper_name" placeholder="{{Lang::get('placeholder.helper_name')}}">
										</div>
										@if($errors->has('helper_name'))
											<span class="alert-notice" role="alert">
				                                <strong>{{ $errors->first('helper_name') }}</strong>
				                            </span>
				                        @endif

				                        <div class="form-group">
											<label for="helper_contact_no">{{Lang::get('label.helper_contact_no')}}</label>
											<input type="text" class="form-control" value="{{ ($helper_contact_no) ? $helper_contact_no : old('helper_contact_no') }}" id="helper_contact_no" name="helper_contact_no" placeholder="{{Lang::get('placeholder.helper_contact_no')}}">
										</div>
										@if($errors->has('helper_contact_no'))
											<span class="alert-notice" role="alert">
				                                <strong>{{ $errors->first('helper_contact_no') }}</strong>
				                            </span>
				                        @endif

				                        <div class="form-group">
											<label for="vehicle_type_id">{{Lang::get('label.vehicle_type_id')}}</label>
											<select name="vehicle_type_id" class="form-control">
												@foreach($vehicle_type_list as $vehicle_type)
													<option value="{!! $vehicle_type->id !!}" {{ ( $vehicle_type->id == $vehicle_type_id ) ? 'selected' : '' }}>{!! $vehicle_type->name !!}</option>
												@endforeach
											</select>
										</div>
										@if($errors->has('vehicle_type_id'))
											<span class="alert-notice" role="alert">
				                                <strong>{{ $errors->first('vehicle_type_id') }}</strong>
				                            </span>
				                        @endif

				                        <div class="form-group">
											<label for="vehicle_no">{{Lang::get('label.vehicle_no')}}</label>
											<input type="text" class="form-control" value="{{ ($vehicle_no) ? $vehicle_no : old('vehicle_no') }}" id="vehicle_no" name="vehicle_no" placeholder="{{Lang::get('placeholder.vehicle_no')}}">
										</div>
										@if($errors->has('vehicle_no'))
											<span class="alert-notice" role="alert">
				                                <strong>{{ $errors->first('vehicle_no') }}</strong>
				                            </span>
				                        @endif
										
										<div class="card-footer">
						                  	<button type="submit" class="btn btn-primary">{{Lang::get('button.submit')}}</button>
						                  	<button type="reset" class="btn btn-danger">{{Lang::get('button.reset')}}</button>
						                  	<a href="{{ route('view.vehicle_type') }}" class="btn btn-success">{{Lang::get('button.back')}}</a>
						                </div>
									</div>
									<!-- /.card-body -->
								</form>
							</div>
						</div>
						{{-- End form column --}}
						<div class="col-md-3"></div>
					</div>
				</div>
			</section>
		</div>
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