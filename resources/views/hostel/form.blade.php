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
							<a href="{!! route('view.hostel') !!}" class="btn btn-success"><i class="fa fa-arrow-left"></i> &nbsp; {{trans('button.back')}}</a>
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
									<input type="hidden" name="hostel_id" value="{{ $hostel_id }}">
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
												<label for="address">{{trans('label.address')}}</label>
												<textarea type="text" class="form-control" id="name" name="address" placeholder="{{trans('placeholder.address')}}">{{ ($address) ? $address : old('address') }}</textarea>

												@if($errors->has('address'))
												<span class="alert-notice" role="alert">
													<strong>{{ $errors->first('address') }}</strong>
												</span>
												@endif
											</div>
											
										</div>
										

										<div class="form-group">
											<label for="facilities_ids">{{trans('label.facilities_ids')}}</label>
										</div>
										<div class="row form-group">
											@foreach($facilities_list as $facility => $value)
											<div  class="icheck-primary col-sm-6">
												<input type="checkbox" value="{{$facility}}" name="facilities_ids[]" id="facility{{$facility}}" {{ (in_array($facility,$facilities_ids))?'checked':'' }} @php if(in_array($facility,old('facilities_ids',array()))){ echo "checked";}@endphp>
												<label for="facility{{$facility}}">{{$value}}</label>
											</div>
											@endforeach

											@if($errors->has('facilities_ids'))
											<span class="alert-notice" role="alert">
												<strong>{{ $errors->first('facilities_ids') }}</strong>
											</span>
											@endif

										</div>
										


										<div class="form-group row">

											<div class="col-sm-6 form-group">
												<label for="no_of_rooms">{{trans('label.no_of_rooms')}}</label>
												<input type="text" class="form-control" value="{{ ($no_of_rooms) ? $no_of_rooms : old('no_of_rooms') }}" id="no_of_rooms" name="no_of_rooms" placeholder="{{trans('placeholder.no_of_rooms')}}">

												@if($errors->has('no_of_rooms'))
												<span class="alert-notice" role="alert">
													<strong>{{ $errors->first('no_of_rooms') }}</strong>
												</span>
												@endif
											</div>
											

											<div class="col-sm-6 form-group">
												<label for="warden_name">{{trans('label.warden_name')}}</label>
												<input type="text" class="form-control" value="{{ ($warden_name) ? $warden_name : old('warden_name') }}" id="warden_name" name="warden_name" placeholder="{{trans('placeholder.warden_name')}}">

												@if($errors->has('warden_name'))
												<span class="alert-notice" role="alert">
													<strong>{{ $errors->first('warden_name') }}</strong>
												</span>
												@endif
											</div>
								
										</div>
											
										<div class="card-footer">
											<button type="submit" class="btn btn-primary">{{trans('button.submit')}}</button>
											<button type="reset" class="btn btn-danger">{{trans('button.reset')}}</button>
											<a href="{{ route('view.vehicle_type') }}" class="btn btn-success">{{trans('button.back')}}</a>
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