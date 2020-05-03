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
							<a href="{!! route('view.room') !!}" class="btn btn-success"><i class="fa fa-arrow-left"></i> &nbsp; {{trans('button.back')}}</a>
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
								<form class="form-horizontal" role="form" action="{{ $action }}" method="POST">
									@csrf
									<input type="hidden" name="room_id" value="{{ $room_id }}">
									<div class="card-body">
										<div class="form-group row">
											<div class="col-sm-6 form-group">
												<label for="name">{{trans('label.name')}}</label>
												<input type="text" class="form-control" value="{{ ($name) ? $name : old('name') }}" id="name" name="name" placeholder="{{trans('placeholder.name')}}">

												@if($errors->has('name'))
												 
												<span class="alert-notice" role="alert">
					                                <strong>{{ $errors->first('name') }}</strong>
					                            </span>
						                        @endif
											</div>
											
											<div class="col-sm-6 form-group">
												<label for="type_id">{{trans('label.type_id')}}</label>
												<select name="type_id" class="form-control">
													@foreach($type_list as $type)
														<option value="{!! $type->id !!}" {{ ( $type->id == $type_id ) ? 'selected' : '' }}>{!! $type->name !!}</option>
													@endforeach
												</select>

												@if($errors->has('type_id'))
												<span class="alert-notice" role="alert">
					                                <strong>{{ $errors->first('type_id') }}</strong>
					                            </span>
						                        @endif
											</div>
												
					                    </div>

					                    <div class="form-group row">
					                        
					                        <div class="col-sm-6 form-group">
												<label for="hostel_id">{{trans('label.hostel_id')}}</label>
												<select name="hostel_id" class="form-control">
													@foreach($hostel_list as $hostel)
														<option value="{!! $hostel->id !!}" {{ ( $hostel->id == $hostel_id ) ? 'selected' : '' }}>{!! $hostel->name !!}</option>
													@endforeach
												</select>

												@if($errors->has('hostel_id'))
												<span class="alert-notice" role="alert">
					                                <strong>{{ $errors->first('hostel_id') }}</strong>
					                            </span>
						                        @endif
											</div>
											
											<div class="col-sm-6 form-group">
												<label for="room_type_id">{{trans('label.room_type_id')}}</label>
												<select name="room_type_id" class="form-control">
													@foreach($room_type_list as $room_type)
														<option value="{!! $room_type->id !!}" {{ ( $room_type->id == $room_type_id ) ? 'selected' : '' }}>{!! $room_type->name !!}</option>
													@endforeach
												</select>

												@if($errors->has('room_type_id'))
												<span class="alert-notice" role="alert">
					                                <strong>{{ $errors->first('room_type_id') }}</strong>
					                            </span>
						                        @endif
											</div>
											 
					                    </div>

										<div class="form-group row">
					                        
					                        <div class="col-sm-6 form-group">
												<label for="room_capacity">{{trans('label.room_capacity')}}</label>
												<input type="text" class="form-control" value="{{ ($room_capacity) ? $room_capacity : old('room_capacity') }}" id="room_capacity" name="room_capacity" placeholder="{{trans('placeholder.room_capacity')}}">

												@if($errors->has('room_capacity'))
												<span class="alert-notice" role="alert">
					                                <strong>{{ $errors->first('room_capacity') }}</strong>
					                            </span>
						                        @endif
											</div>

					                        <div class="col-sm-6 form-group">
												<label for="charge">{{trans('label.charge')}}</label>
												<input type="text" class="form-control" value="{{ ($charge) ? $charge : old('charge') }}" id="charge" name="charge" placeholder="{{trans('placeholder.charge')}}">

												@if($errors->has('charge'))
												<span class="alert-notice" role="alert">
					                                <strong>{{ $errors->first('charge') }}</strong>
					                            </span>
						                        @endif
											</div>
					                    </div>
										
										<div class="card-footer">
						                  	<button type="submit" class="btn btn-primary">{{trans('button.submit')}}</button>
						                  	<button type="reset" class="btn btn-danger">{{trans('button.reset')}}</button>
						                  	<a href="{{ route('view.room') }}" class="btn btn-success">{{trans('button.back')}}</a>
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