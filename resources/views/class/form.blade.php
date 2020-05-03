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
						<div class="col-sm-11">
							<h1>{!! $page_title !!}</h1>
						</div>
						<div class="col-sm-1">
							<a href="{!! route('view.class') !!}" class="btn btn-success"><i class="fa fa-arrow-left"></i> &nbsp; {{ trans('button.back') }}</a>
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
									<input type="hidden" name="class_id" value="{{ $class_id }}">
									<div class="card-body">
										<div class="form-group">
											<label for="class_name">{{ trans('label.class_name') }}</label>
											<input type="text" class="form-control" value="{{ ($class_name) ? $class_name : old('class_name') }}" id="class_name" name="class_name" placeholder="{{ trans('placeholder.class_name') }}">

										</div>
										@if($errors->has('class_name'))
											<span class="alert-notice" role="alert">
				                                <strong>{{ $errors->first('class_name') }}</strong>
				                            </span>
				                        @endif
										<div class="form-group">
											<label for="class_short">{{ trans('label.class_short') }}</label>
											<input type="text" class="form-control" id="class_short" placeholder="{{ trans('placeholder.class_short') }}" name="class_short" value="{{ ($class_short) ? $class_short : old('class_short') }}">
											@if($errors->has('class_short'))
												<span class="alert-notice" role="alert">
					                                <strong>{{ $errors->first('class_short') }}</strong>
					                            </span>
					                        @endif
										</div>
										<div class="card-footer">
						                  	<button type="submit" class="btn btn-primary">Submit</button>
						                  	<button type="reset" class="btn btn-danger">Reset</button>
						                  	<a href="{{ route('view.class') }}" class="btn btn-success">Back</a>
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
		<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
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