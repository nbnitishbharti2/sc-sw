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
							<a href="{!! route('view.section') !!}" class="btn btn-success"><i class="fa fa-arrow-left"></i> &nbsp; Back</a>
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
									<input type="hidden" name="section_id" value="{{ $section_id }}">
									<div class="card-body">
										<div class="form-group">
											<label for="class_id">Class </label>
											<select name="class_id" class="form-control">
												@foreach($class_list as $class)
													<option value="{!! $class->id !!}" {{ ( $class->id == $class_id ) ? 'selected' : '' }}>{!! $class->class_short !!}</option>
												@endforeach
											</select>
										</div>
										@if($errors->has('class_id'))
											<span class="alert-notice" role="alert">
				                                <strong>{{ $errors->first('class_id') }}</strong>
				                            </span>
				                        @endif
										<div class="form-group">
											<label for="section_name">Section Name</label>
											<input type="text" class="form-control" value="{{ ($section_name) ? $section_name : old('section_name') }}" id="section_name" name="section_name" placeholder="Enter Section Name">
										</div>
										@if($errors->has('section_name'))
											<span class="alert-notice" role="alert">
				                                <strong>{{ $errors->first('section_name') }}</strong>
				                            </span>
				                        @endif
										<div class="form-group">
											<label for="section_short">Section Short</label>
											<input type="text" class="form-control" id="section_short" placeholder="Enter Section Short" name="section_short" value="{{ ($section_short) ? $section_short : old('section_short') }}">
											@if($errors->has('section_short'))
												<span class="alert-notice" role="alert">
					                                <strong>{{ $errors->first('section_short') }}</strong>
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