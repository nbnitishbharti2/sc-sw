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
							<a href="{!! route('home') !!}" class="btn btn-success"><i class="fa fa-arrow-left"></i> &nbsp; {{ trans('button.back') }}</a>
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
									<input type="hidden" name="permission_id" value="{{ $permission_id }}">
									<div class="card-body">
										<div class="form-group">
											<label for="module">{{ trans('label.module') }}</label>
											<select name="module_id" class="form-control">
												@foreach ($modules as $module)
													<option value="{{ $module->id }}">{{ $module->name }}</option>
												@endforeach
											</select>
											@if($errors->has('module_id'))
												<span class="alert-notice" role="alert">
													<strong>{{ $errors->first('module_id') }}</strong>
												</span>
											@endif
										</div>
										<div class="form-group">
											<label for="permission_name">{{ trans('label.permission_name') }}</label>
											<input type="text" class="form-control" value="{{ ($name) ? $name : old('name') }}" id="permission_name" name="name" placeholder="{{ trans('placeholder.permission_name') }}">
											@if($errors->has('name'))
												<span class="alert-notice" role="alert">
													<strong>{{ $errors->first('name') }}</strong>
												</span>
											@endif
										</div>
										<div class="form-group">
											<label for="permission_description">{{ trans('label.permission_description') }}</label>
											<input type="text" class="form-control" value="{{ ($description) ? $name : old('description') }}" id="permission_description" name="description" placeholder="{{ trans('placeholder.permission_description') }}">
											@if($errors->has('name'))
												<span class="alert-notice" role="alert">
													<strong>{{ $errors->first('name') }}</strong>
												</span>
											@endif
										</div>
										<div class="card-footer">
						                  	<button type="submit" class="btn btn-primary">{{ trans('button.submit') }}</button>
						                  	<button type="reset" class="btn btn-danger">{{ trans('button.reset') }}</button>
						                  	<a href="{{ route('home') }}" class="btn btn-success">{{ trans('button.back') }}</a>
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