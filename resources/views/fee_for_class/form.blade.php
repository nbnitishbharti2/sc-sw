@php
use App\Models\FeeFrequency;
@endphp

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
							@if(Route::currentRouteName() == 'add.fee-for-classes')
								<a href="{!! route('view.fee') !!}" class="btn btn-success"><i class="fa fa-arrow-left"></i> &nbsp; {{trans('button.back')}}</a>
							@elseif(Route::currentRouteName() == 'edit.fee-for-classes')
								<a href="{!! route('view.fee-for-classes') !!}" class="btn btn-success"><i class="fa fa-arrow-left"></i> &nbsp; {{trans('button.back')}}</a>
							@endif
						</div>
					</div>
				</div><!-- /.container-fluid -->
			</section>
			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-1"></div>
						<!-- left column -->
						<div class="col-md-10">
							<!-- general form elements -->
							<div class="card card-primary">
								<div class="card-header">
									<h3 class="card-title">{!! $title !!}</h3>
								</div>
								<!-- /.card-header -->
								<!-- form start -->
								<form class="form-horizontal" role="form" action="{{ $action }}" method="POST">
									@csrf
									<input type="hidden" name="fee_id" value="{{ $fee_id }}">
									<div class="card-body">

										<div class="form-group row">

											<div class="col-sm-6">
												<label for="fee_name">{{ trans('label.fee_name') }}</label>
												<input type="text" class="form-control" value="{{ ($fee_name) }}" id="fee_name" name="fee_name" placeholder="{{ trans('placeholder.fee_name') }}" readonly disabled>
											</div>

											<div class="col-sm-6">
												<label for="fee_short_name">{{ trans('label.fee_short_name') }}</label>
												<input type="text" class="form-control" id="fee_short_name" placeholder="{{ trans('placeholder.fee_short_name') }}" name="fee_short_name" value="{{ ($fee_short_name) }}" readonly disabled>
											</div>

										</div>

									    <div class="form-group row">
											@foreach($class_list as $class)
											<div class="col-sm-3">
										    	<label for="class_id">{{ $class->class_short }}</label>
												<input type="text" name="class_id[{{$class->id}}]" class="form-control" id="class_id" placeholder="{{ trans('placeholder.charge') }}" value="{{ old('class_id',(array_key_exists($class->id, $class_id)) ? $class_id[$class->id] : '') }}"> 

												@if($errors->has('class_id'))
												<span class="alert-notice" role="alert">
					                                <strong>{{ $errors->first('class_id') }}</strong>
					                            </span>
						                        @endif
											</div>
											@endforeach
										</div>
					                        
										
										<div class="card-footer">
						                  	<button type="submit" class="btn btn-primary">{{trans('button.submit')}}</button>
						                  	<button type="reset" class="btn btn-danger">{{trans('button.reset')}}</button>
						                  	

						                  	@if(Route::currentRouteName() == 'add.fee-for-classes')
												<a href="{{ route('view.fee') }}" class="btn btn-success">{{trans('button.back')}}</a>
											@elseif(Route::currentRouteName() == 'edit.fee-for-classes')
												<a href="{{ route('view.fee-for-classes') }}" class="btn btn-success">{{trans('button.back')}}</a>
											@endif
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