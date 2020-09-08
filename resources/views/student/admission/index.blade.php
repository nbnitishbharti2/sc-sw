@php
use App\Models\Classes;
use App\Models\Session;

$classes=Classes::getAllClassForListing();
$sessions = Session::getAllSessionList();
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
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<h1>{{trans('title.view_admission')}}</h1>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 right-align">
							<a href="{!! url('/') !!}" class="btn btn-success"><i class="fa fa-arrow-left"></i> &nbsp; {{trans('button.back')}}</a>
							{{-- @if(Helper::checkPermission('add-class')) --}}
				                <!-- <a href="" class="btn btn-primary"><i class="fa fa-plus"></i>  &nbsp; {{trans('button.add')}}</a> -->
				            {{-- @endif --}}
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

										<form action="{{ route('view.student.admission') }}" method="get" id="studentAdmissionForm">

											<div class="row">

												<div class="short_by new-filter col-sm-2"> 
													<label>Class</label>
													<select id="class" name="class" class="form-control">
														<option value="">Choose Class</option>
														@if($classes->count())
															@foreach($classes as $class)
																<option value="{{$class->id}}" {{ (request()->get('class')== $class->id)?'selected':'' }}>{{ $class->class_short }}</option>
															@endforeach
														@endif 
													</select>
												</div>		

												<div class="short_by new-filter col-sm-2"> 
													<label>Session</label>
													<select id="session" name="session" class="form-control">
														<option value="">Choose Session</option>
														@if($sessions->count())
															@foreach($sessions as $key=>$value)
															{{-- dd($key) --}}
																<option value="{{$key}}" {{ (request()->get('session')== $key)?'selected':'' }}>{{ $value }}</option>
															
															@endforeach
														@endif 
													</select>
												</div>	

												<div class="short_by new-filter col-sm-3"> 
													<label>From</label>
													<input type="date" name="date1" value="{{ (request()->get('date1')) ? request()->get('date1') : ''}}" class="form-control">
												</div>

												<div class="short_by new-filter col-sm-3"> 
													<label>To</label>
													<input type="date" name="date2" value="{{ (request()->get('date2')) ? request()->get('date2') : '' }}" class="form-control">
												</div>
												
												<div class="short_by new-filter col-sm-3"> 
													<label>Search</label>
													<input class="form-control" name="search" value="{{ (request()->get('search')) ? request()->get('search') : '' }}" type="text" placeholder="Search...">
												</div>

												<div class="short_by new-filter col-sm-2"> 
													<input type="submit" name="submit" value="Submit"class="form-control btn btn-success" style="margin-top:32px;">
												</div>

											</div>

										</form>

										

										<table id="table" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>{{trans('title.serial_no')}}</th>
													<th>{{trans('title.name')}}</th>
													<th>{{trans('title.father_name')}}</th>
													<th>{{trans('title.mother_name')}}</th>
													<th>{{trans('title.primary_mobile_no')}}</th>
													<th>{{trans('title.address')}}</th>
													<th>{{trans('title.dob')}}</th>
													<!-- <th>{{trans('title.cast')}}</th> -->
													<th>{{trans('title.aadhar_no')}}</th>
													
													<th>{{trans('title.created')}}</th>
													<th>{{trans('title.action')}}</th>
												</tr>
											</thead>
											<tbody>
												@php $i = 0; @endphp
												@foreach($student_admission as $item)
												    {{--dd($item)--}}
													<tr>
														<td>{!! ++$i !!}</td>
														<td>{!! $item->name !!}</td>
														<td>{!! $item->father_name !!}</td>
														<td>{!! $item->mother_name !!}</td>
														<td>{!! $item->primary_mobile_no !!}</td>
														<td>{!! $item->address !!}</td>
														<td>{{ date('d-M-Y', strtotime($item->dob)) }}</td>
														<!-- <td>{!! $item->cast !!}</td> -->
														<td>{!! $item->aadhar_no !!}</td>
														
														<td>{!! Carbon\Carbon::parse($item->created_at)->format(config('app.date_time_format')) !!}</td>
														<td>
															@if(empty($item->deleted_at))

																<a href=""  title="View" class="btn-sm btn btn-info"><i class="fa fa-eye"></i></a>

																{{-- @if(Helper::checkPermission('edit-class')) --}}
																<a href="{!! route('add.student.admission', ['id'=>$item->id, 'session_map_id'=>$item->student_session_detail->id]) !!}"  title="Edit" class="btn-sm btn btn-primary"><i class="fa fa-edit"></i>  </a>
																{{-- @endif --}}

																{{-- @if(Helper::checkPermission('delete-class')) --}}
																<button class="btn-sm btn btn-danger" title="Delete" onclick="student_admission_confirm_delete({{ $item->id }})"><i class="fa fa-trash"></i></button>
																{{-- @endif --}}
																
															@else
															
																{{-- @if(Helper::checkPermission('delete-class')) --}}
																<button class="btn-sm btn btn-success" title="Restore" onclick="student_admission_confirm_restore({{ $item->id }})"><i class="fa fa-undo"></i></button>
																{{-- @endif --}}

															@endif
														</td>
													</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
								<!-- /.card-body -->
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
	<!-- /.delete confirmation modal -->
	<div class="modal fade" id="modal-student_admission-delete">
	    <div class="modal-dialog">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title">{{Lang::get('title.delete_student_admission')}}</h4>
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            <span aria-hidden="true">&times;</span>
	          </button>
	        </div>
	        <div class="modal-body">
	          <p>{{Lang::get('message.delete_student_admission')}}</p>
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('button.close') }}</button>
	          <a href="{{ url('/delete-student-admission/11') }}" id="delete-student_admission" class="btn btn-primary">{{ trans('button.delete') }}</a>
	        </div>
	      </div>
	      <!-- /.modal-content -->
	    </div>
	    <!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
    <!-- /.delete confirmation modal -->
	<div class="modal fade" id="modal-student_admission-restore">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{Lang::get('title.restore_student_admission')}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>{{Lang::get('message.restore_student_admission')}}</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('button.close') }}</button>
              <a href="{{ url('/restore-student-admission/11') }}" id="restore-student_admission" class="btn btn-primary">{{ trans('button.restore') }}</a>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

</body>


@endsection
@section('script') 
@endsection

