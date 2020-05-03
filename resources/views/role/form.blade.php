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
							<a href="{!! route('view.roles') !!}" class="btn btn-success"><i class="fa fa-arrow-left"></i> &nbsp; {{ trans('button.back') }}</a>
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
									<input type="hidden" name="roles_id" value="{{ $roles_id }}">
									<div class="card-body">
										<div class="form-group">
											<label for="roles_name">{{ trans('label.roles_name') }}</label>
											<input type="text" class="form-control" value="{{ ($name) ? $name : old('name') }}" id="roles_name" name="name" placeholder="{{ trans('placeholder.roles_name') }}">
											@if($errors->has('name'))
												<span class="alert-notice" role="alert">
													<strong>{{ $errors->first('name') }}</strong>
												</span>
											@endif
										</div>
										<div class="card-footer">
						                  	<button type="submit" class="btn btn-primary">{{ trans('button.submit') }}</button>
						                  	<button type="reset" class="btn btn-danger">{{ trans('button.reset') }}</button>
						                  	<a href="{{ route('view.roles') }}" class="btn btn-success">{{ trans('button.back') }}</a>
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