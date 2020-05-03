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
							<a href="{!! route('view.stopage') !!}" class="btn btn-success"><i class="fa fa-arrow-left"></i> &nbsp; {{Lang::get('button.back')}}</a>
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
									<input type="hidden" name="stopage_id" value="{{ $stopage_id }}">
									<div class="card-body">

										<div class="form-group">
											<label for="stopage_name">{{Lang::get('label.stopage_name')}}</label>
											<input type="text" class="form-control" value="{{ ($stopage_name) ? $stopage_name : old('stopage_name') }}" id="stopage_name" name="stopage_name" placeholder="{{Lang::get('placeholder.stopage_name')}}">
										</div>
										@if($errors->has('stopage_name'))
										<span class="alert-notice" role="alert">
			                                <strong>{{ $errors->first('stopage_name') }}</strong>
			                            </span>
				                        @endif
										
				                        <div class="form-group">
											<label for="vehicle_type_id">{{Lang::get('label.root_id')}}</label>
											<select name="root_id" id="root_id" class="form-control">
												@foreach($root_list as $root)
													<option value="{!! $root->id !!}" {{ ( $root->id == $root_id ) ? 'selected' : '' }}>{!! $root->name !!}</option>
												@endforeach
											</select>
										</div>
										@if($errors->has('root_id'))
										<span class="alert-notice" role="alert">
			                                <strong>{{ $errors->first('root_id') }}</strong>
			                            </span>
				                        @endif

				                        <div class="form-group">
											<label for="vehicle_type_id">{{Lang::get('label.vehicle_type_id')}}</label>
											<select name="vehicle_type_id" id="vehicle_type_id" class="form-control">
												
											</select>
										</div>
										@if($errors->has('vehicle_type_id'))
										<span class="alert-notice" role="alert">
			                                <strong>{{ $errors->first('vehicle_type_id') }}</strong>
			                            </span>
				                        @endif

				                        <div class="form-group">
											<label for="vehicle_id">{{Lang::get('label.vehicle_id')}}</label>
											<select name="vehicle_id" id="vehicle_id" class="form-control">
											</select>
										</div>
										@if($errors->has('vehicle_id'))
										<span class="alert-notice" role="alert">
			                                <strong>{{ $errors->first('vehicle_id') }}</strong>
			                            </span>
				                        @endif

				                        <div class="form-group">
											<label for="charge">{{Lang::get('label.charge')}}</label>
											<input type="text" class="form-control" value="{{ ($charge) ? $charge : old('charge') }}" id="charge" name="charge" placeholder="{{Lang::get('placeholder.charge')}}">
										</div>
										@if($errors->has('charge'))
										<span class="alert-notice" role="alert">
			                                <strong>{{ $errors->first('charge') }}</strong>
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
	<script>
		$(window).on('load',function() {

			if($('#root_id').val())
	        {
		        var root_id = $('#root_id').val();
		       
		        var form_data = new FormData();
		        form_data.append('root_id',root_id);
		        form_data.append('_token', '{{csrf_token()}}');
		       
		        var old_vehicle_type_id='{{ $vehicle_type_id }}';
		        if(old_vehicle_type_id == 0) {
		        	$('#vehicle_type_id').html('<option>Choose Vehicle Type</option>');
		        }
		        else {
			        $.ajax({
			            url: "{{route('get-vehicle-type-from-vehicle-root-map')}}",
			            data: form_data,
			            type: 'POST',
			            dataType: "json",
			            contentType: false,
			            processData: false,
			            success:function(data) { 
			            $.each(data, function(key, value) {
			                var select='';
			                if(old_vehicle_type_id==key){select='selected';}
			                $('select[name="vehicle_type_id"]').append('<option value="'+ key +'" "'+select+'" >'+ value +'</option>');
			            });
			            $("#vehicle_type_id").val(old_vehicle_type_id);
			            }
			        });
		        }
		    }
	        if($('#vehicle_type_id').val() || old_vehicle_type_id)
	        {
		        var vehicle_type_id = ($('#vehicle_type_id').val())?$('#vehicle_type_id').val():old_vehicle_type_id;
		        var root_id =$('#root_id').val();
		      
		        var form_data = new FormData();
		        form_data.append('root_id',root_id);
		        form_data.append('vehicle_type_id',vehicle_type_id);
		        form_data.append('_token', '{{csrf_token()}}');
		       
		        var old_vehicle_id='{{ $vehicle_id }}';
		        if(old_vehicle_id == 0) {
		        	$('#vehicle_id').html('<option>Choose Vehicle</option>');
		        }
		        else {
			        $.ajax({
			            url: "{{route('get-vehicle-no-from-vehicle-root-map')}}",
			            data: form_data,
			            type: 'POST',
			            dataType: "json",
			            contentType: false,
			            processData: false,
			            success:function(data) { 
			            $.each(data, function(key, value) {
			                var select='';
			                if(old_vehicle_id==key){select='selected';}
			                $('select[name="vehicle_id"]').append('<option value="'+ key +'" "'+select+'" >'+ value +'</option>');
			            });
			            $("#vehicle_id").val(old_vehicle_id);
			            }
			        });
		        }
		    }
		});
		        
	      
	 
 
		$(document).ready(function(){
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
	                $.each(data, function(key, value) {
	                    $('select[name="vehicle_type_id"]').append('<option value="'+ key +'" selected >'+ value +'</option>');
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
	                $.each(data, function(key, value) {
	                    $('select[name="vehicle_id"]').append('<option value="'+ key +'" selected >'+ value +'</option>');
	                    });
	                }
	            });
			});
		});
	</script>
@endsection