@php
use App\Models\Classes;
use App\Models\Fee;
use App\Models\FeeHead;
use App\Models\FeeType;
use App\Models\FeeFrequency;
@endphp

@extends('layouts.app')
@section('content')

<form action="{{ route('view.fee-for-classes') }}" method="get" id="feeForClassForm">

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
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<h1>{{trans('title.view_fee_for_class')}}</h1>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 right-align">
							<a href="{!! url('/') !!}" class="btn btn-success"><i class="fa fa-arrow-left"></i> &nbsp; {{trans('button.back')}}</a>
						</div>
					</div>
				</div><!-- /.container-fluid -->
			</section>
			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<!-- left column -->
						<div class="col-12">
							<!-- general form elements -->
							<div class="card">
								<!-- /.card-header -->
								<div class="card-body">
									<div class="table-responsive">
										<div class="row">

											<div class="short_by new-filter col-sm-2"> 
												<label>Class</label>
												<select id="class" name="class form-control">
													<option value="">Choose Class</option>
													@php $classes=Classes::getAllClassForListing(); @endphp
													@if($classes->count())
														@foreach($classes as $class)
															<option value="{{$class->id}}" {{ (request()->get('class')== $class->id)?'selected':'' }}>{{ $class->class_short }}</option>
														@endforeach
													@endif 
												</select>
											</div>

											<div class="short_by new-filter col-sm-2"> 
												<label>Fee</label>
												<select id="fee" name="fee">
													<option value="">Choose Fee</option>
													@php $fees=Fee::getAllFeeForListing(); @endphp
													@if($fees->count())
														@foreach($fees as $fee)
															<option value="{{$fee->id}}" {{ (request()->get('fee')== $fee->id)?'selected':'' }}>{{ $fee->fee_name }}</option>
														@endforeach
													@endif  
												</select>
											</div>

											<div class="short_by new-filter col-sm-2"> 
												<label>Fee Head</label>
												<select id="fee_head" name="fee_head">
													<option value="">Choose Fee Head</option>
													@php $fee_heads=FeeHead::getAllFeeHeadForListing(); @endphp
													@if($fee_heads->count())
														@foreach($fee_heads as $fee_head)
															<option value="{{$fee_head->id}}" {{ (request()->get('fee_head')== $fee_head->id)?'selected':'' }}>{{ $fee_head->name }}</option>
														@endforeach
													@endif 
												</select>
											</div>

											<div class="short_by new-filter col-sm-2"> 
												<label>Fee Type</label>
												<select id="fee_type" name="fee_type">
													<option value="">Choose Fee Type</option>
													@php $fee_types=FeeType::getAllFeeTypeForListing(); @endphp
													@if($fee_types->count())
														@foreach($fee_types as $fee_type)
															<option value="{{$fee_type->id}}" {{ (request()->get('fee_type')== $fee_type->id)?'selected':'' }}>{{ $fee_type->name }}</option>
														@endforeach
													@endif 
												</select>
											</div>

											<div class="short_by new-filter col-sm-2"> 
												<label>Fee Frequency</label>
												<select id="fee_frequency" name="fee_frequency">
													<option value="">Choose Fee Frequency</option>
													@php $fee_frequencies=FeeFrequency::getAllFeeFrequencyForListing(); @endphp
													@if($fee_frequencies->count())
														@foreach($fee_frequencies as $fee_frequency)
															<option value="{{$fee_frequency->id}}" {{ (request()->get('fee_frequency')== $fee_frequency->id)?'selected':'' }}>{{ $fee_frequency->name }}</option>
														@endforeach
													@endif 
												</select>
											</div>
										</div>

										<table id="table" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>{{trans('title.serial_no')}}</th>
													<th>{{trans('title.fee_name')}}</th>
													<th>{{trans('title.class_name')}}</th>
													<th>{{trans('title.charge')}}</th>
													<th>{{trans('title.created')}}</th>
													<th>{{trans('title.action')}}</th>
												</tr>
											</thead>
											<tbody>
												@php $i = 0; @endphp
												@foreach($fee_for_class as $item)
													<tr>
														<td>{!! ++$i !!}</td>
														<td>{!! $item->fee->fee_name !!}</td>
														<td>{!! $item->class->class_name !!}</td>
														<td>{!! $item->charge !!}</td>
														<td>{!! Carbon\Carbon::parse($item->created_at)->format(config('app.date_time_format')) !!}</td>
														<td>
															@if(Helper::checkPermission('edit-fee-for-classes'))
															<a href="{!! route('edit.fee-for-classes', $item->id) !!}"  title="Edit" class="btn-sm btn btn-primary"><i class="fa fa-edit"></i>  </a>
															@endif	
														</td>
													</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
								<!-- /.card-body -->

								{{--$fee_for_class->paginate()->links()--}}
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<!-- /.content-wrapper -->
		@include('layouts.footer')

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->
	</div>

</form>


	
@endsection
@section('script') 
@endsection

