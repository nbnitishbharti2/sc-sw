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
							<a href="{!! route('view.fee') !!}" class="btn btn-success"><i class="fa fa-arrow-left"></i> &nbsp; {{trans('button.back')}}</a>
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
												<input type="text" class="form-control" value="{{ ($fee_name) ? $fee_name : old('fee_name') }}" id="fee_name" name="fee_name" placeholder="{{ trans('placeholder.fee_name') }}">
												
												@if($errors->has('fee_name'))
												<span class="//alert-notice" role="//alert">
					                                <strong>{{ $errors->first('fee_name') }}</strong>
					                            </span>
					                        	@endif
											</div>

											<div class="col-sm-6">
												<label for="fee_short_name">{{ trans('label.fee_short_name') }}</label>
												<input type="text" class="form-control" id="fee_short_name" placeholder="{{ trans('placeholder.fee_short_name') }}" name="fee_short_name" value="{{ ($fee_short_name) ? $fee_short_name : old('fee_short_name') }}">

												@if($errors->has('fee_short_name'))
													<span class="//alert-notice" role="//alert">
						                                <strong>{{ $errors->first('fee_short_name') }}</strong>
						                            </span>
						                        @endif
											</div>

										</div>

				                        <div class="form-group row">

				                        	<div class="col-sm-4">
												<label for="fee_head_id">{{trans('label.fee_head_id')}}</label>
												<select name="fee_head_id" class="form-control" id="fee_head_id"> 
													<option value="">Choose Fee Head</option> 
													@foreach($fee_head_list as $fee_head)
														<option value="{!! $fee_head->id !!}" {{ old("fee_head_id",$fee_head_id) == $fee_head->id ? 'selected' : '' }} >{!! $fee_head->name !!}</option>
													@endforeach 
												</select>

												@if($errors->has('fee_head_id'))
												<span class="//alert-notice" role="//alert">
					                                <strong>{{ $errors->first('fee_head_id') }}</strong>
					                            </span>
						                        @endif
											</div>
										
					                        <div class="col-sm-4">
												<label for="fee_type_id">{{trans('label.fee_type_id')}}</label>
												<select name="fee_type_id" class="form-control" id="fee_type_id"> 
													<option value="">Choose Fee Type</option> 
													@foreach($fee_type_list as $fee_type)
														<option value="{!! $fee_type->id !!}" {{ old("fee_type_id",$fee_type_id) == $fee_type->id ? 'selected' : '' }} >{!! $fee_type->name !!}</option>
													@endforeach 
												</select>

												@if($errors->has('fee_type_id'))
												<span class="//alert-notice" role="//alert">
					                                <strong>{{ $errors->first('fee_type_id') }}</strong>
					                            </span>
						                        @endif
											</div>


				                        	<div class="col-sm-4" id="frequency">
												<label for="frequency_id">{{trans('label.frequency_id')}}</label>
												<select name="frequency_id" id="frequency_id" class="form-control">
													<option value="">Choose Frequency</option>
												</select>

												@if($errors->has('frequency_id'))
												<span class="//alert-notice" role="//alert">
					                                <strong>{{ $errors->first('frequency_id') }}</strong>
					                            </span>
						                        @endif
						                    </div>

						                    <input type="hidden" name="frequency_value" id="frequency_value">
										
										</div>

				                       


										
										

				                        <div class="form-group applied_in_month">
											<label for="applied_in_month">{{trans('label.applied_in_month')}}</label>
										</div>
										<div class="row form-group applied_in_month">
											@foreach($month_list as $month_id => $value)
											<div class="icheck-primary col-sm-3">
												<input type="checkbox" value="{{$month_id}}" name="month_ids[]" class="month_ids" id="month_id{{$month_id}}" {{ (in_array($month_id,$month_ids))?'checked':'' }} @php if(in_array($month_id,old('month_ids',array()))){ echo "checked";}@endphp>
												<label for="month_id{{$month_id}}">{{$value}}</label>
											</div>
											@endforeach

											@if($errors->has('month_ids'))
											<span class="//alert-notice" role="//alert">
												<strong>{{ $errors->first('month_ids') }}</strong>
											</span>
											@endif

											<span class="//alert-notice">
												<strong id="month_error">
												</strong>
											</span>

										</div>
										
										<div class="card-footer">
						                  	<button type="submit" class="btn btn-primary">{{trans('button.submit')}}</button>
						                  	<button type="reset" class="btn btn-danger">{{trans('button.reset')}}</button>
						                  	<a href="{{ route('view.fee') }}" class="btn btn-success">{{trans('button.back')}}</a>
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
//Hide and show script for frequency id and applied in month based on fee type id
$(window).on('load',function() {
    if($('#fee_type_id').val()) 
    {
    	var fee_type_id = $('#fee_type_id').val();
    	feeTypeBasedHideAndShow(fee_type_id);
    }
});

$(document).ready(function(){
	$('#fee_type_id').on('change',function(){
		var fee_type_id = $(this).val();
		feeTypeBasedHideAndShow(fee_type_id);
	});
});

function feeTypeBasedHideAndShow(fee_type_id)
{
	var fee_type_id = fee_type_id;
	if(fee_type_id == 3 || fee_type_id == ''){
		$('#frequency').show();
		$('.applied_in_month').show();
	}else{
		$('#frequency').hide();
		$('.applied_in_month').hide();
	}
}
</script>

<script>
//Ajax for frequency id based on fee head id
$(window).on('load',function() {

    if($('#fee_head_id').val())
    {
    	var fee_head_id = $('#fee_head_id').val();
    	var ajaxOn = 'load';
        var old_frequency_id='{{ $frequency_id }}';
    	if(old_frequency_id == 0) {
        	$('#frequency_id').html('<option>Choose Frequency</option>');
        } else {
	        ajaxForFrequencyId(fee_head_id,ajaxOn,old_frequency_id);
        }
        
    }
});


$(document).ready(function(){
	$('#fee_head_id').on('change', function(){
		var fee_head_id = $(this).val();
		var ajaxOn = 'ready';
		var old_frequency_id = '{{ old('frequency_id') }}';

		ajaxForFrequencyId(fee_head_id,ajaxOn,old_frequency_id);
	});
});


function ajaxForFrequencyId(fee_head_id,ajaxOn,old_frequency_id)
{
	var fee_head_id = fee_head_id;
	var ajaxOn = ajaxOn;

	var form_data = new FormData();
    form_data.append('fee_head_id',fee_head_id);
    form_data.append('_token', '{{csrf_token()}}');

    $.ajax({
        url: "{{route('get-fee-head-frequency-from-fee-setting')}}",
        data: form_data,
        type: 'POST',
        dataType: "json",
        contentType: false,
        processData: false,
        success:function(data) { 

            $.each(data, function(key, value) {

                var new_form_data = new FormData();
	            new_form_data.append('fee_setting_id',value);
	            new_form_data.append('_token', '{{csrf_token()}}');

	            $.ajax({
	                url: "{{route('get-fee-frequency-from-fee-frequency')}}",
	                data: new_form_data,
	                type: 'POST',
	                dataType: "json",
	                contentType: false,
	                processData: false,
	                success:function(data) { 
	                	console.log(data);
	                	if(ajaxOn == 'ready'){
		                	$('#frequency_id option').remove();
		                	$('select[name="frequency_id"]').append('<option value="" >Choose Frequency</option>');
		                }
		                
		                $.each(data, function(key, value) {
		                	if(ajaxOn == 'load'){
		                		var select='';
		                		if(old_frequency_id==key){
		                			select='selected';
		                		}
		                	}
		                	var selectOnLoad=(ajaxOn=='load')?"select":" ";
		                    $('select[name="frequency_id"]').append('<option value="'+ key +'" "'+selectOnLoad+'" >'+ value +'</option>');
	                    });
	                    if(ajaxOn == 'load'){
	                    	$("#frequency_id").val(old_frequency_id);
	                    }
		            }
		        });

            });
        }
    });
}
</script>

<script>
//Script for Applied in month checkboxes
$(document).on('load', function(){
	if($('#frequency_id').val()) {
		var frequency_id = $('#frequency_id').val();
		var ajaxOn = 'load';
		ajaxForFrequencyValue(frequency_id,ajaxOn);
	}
});
$(document).ready(function(){
	$('#frequency_id').on('change', function(){
		var frequency_id = $(this).val();
		var ajaxOn = 'ready';
		ajaxForFrequencyValue(frequency_id,ajaxOn);
		
	});
});

function ajaxForFrequencyValue(frequency_id,ajaxOn)
{
	var frequency_id = frequency_id;
	var ajaxOn = ajaxOn;
	
	var form_data = new FormData();
    form_data.append('frequency_id',frequency_id);
    form_data.append('_token', '{{csrf_token()}}');

    $.ajax({
        url: "{{route('get-frequency-value-from-fee-frequency')}}",
        data: form_data,
        type: 'POST',
        dataType: "json",
        contentType: false,
        processData: false,
        success:function(data) { 
        	console.log(data);
            var frequency_value = data;
            
            $('#frequency_value').val(frequency_value);   
        }
    });

    var lastChecked;
	var $checks = $('input:checkbox').click(function(e) {
	    var numChecked = $checks.filter(':checked').length;
	    var frequency_value = $('#frequency_value').val();
	    if(numChecked > frequency_value) {
	        $('#month_error').text('Please check only '+frequency_value+' months.');
	        lastChecked.checked = false;
	    } else {
	    	$('#month_error').text('');
	    }
	    lastChecked = this;
	});


}




</script>
@endsection