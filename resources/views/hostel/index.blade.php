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
							<h1>{{trans('title.view_hostel')}}</h1>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 right-align">
							<a href="{!! url('/') !!}" class="btn btn-success"><i class="fa fa-arrow-left"></i> &nbsp; {{trans('button.back')}}</a>
							<a href="{!! route('add.hostel') !!}" class="btn btn-primary"><i class="fa fa-plus"></i>  &nbsp; {{trans('button.add')}}</a>
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
										<table id="table" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>{{trans('title.serial_no')}}</th>
													<th>{{trans('title.name')}}</th>
													<th>{{trans('title.address')}}</th>
													<th>{{trans('title.facilities')}}</th>
													<th>{{trans('title.no_of_rooms')}}</th>
													<th>{{trans('title.warden_name')}}</th>
													<th>{{trans('title.created')}}</th>
													<th>{{trans('title.action')}}</th>
												</tr>
											</thead>
											<tbody>
												@php $i = 0; @endphp
												@foreach($hostel['hostels'] as $item)
													<tr>
														<td>{!! ++$i !!}</td>
														<td>{!! $item->name !!}</td>
														<td>{!! $item->address !!}</td>
														<td>
															@php
															$facilities_ids=explode(',',$item->facilities_ids);
															$i=0;
															@endphp

															@foreach($hostel['facilities_list'] as $facility => $value)

																@if(in_array($facility,$facilities_ids))
																	@if($i>0)
																	,
																	@endif
																	@php 
																		$i++;
																	@endphp
																	<span>{{$value}}</span>
																@endif
																
															@endforeach
														</td>
														<td>{!! $item->no_of_rooms !!}</td>
														<td>{!! $item->warden_name !!}</td>
														<td>{!! Carbon\Carbon::parse($item->created_at)->format(config('app.date_time_format')) !!}</td>
														<td>
															@if(empty($item->deleted_at))
																<a href="{!! route('edit.hostel', $item->id) !!}"  title="Edit" class="btn-sm btn btn-primary"><i class="fa fa-edit"></i>  </a>
																<button class="btn-sm btn btn-danger" title="Delete" onclick="hostel_confirm_delete({{ $item->id }})"><i class="fa fa-trash"></i></button>
															@else
																<button class="btn-sm btn btn-success" title="Restore" onclick="hostel_confirm_restore({{ $item->id }})"><i class="fa fa-undo"></i></button>
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
		<!-- footer -->
		@include('layouts.footer')

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->
	</div>
	<!-- /.delete confirmation modal -->
	<div class="modal fade" id="modal-hostel-delete">
	    <div class="modal-dialog">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title">{{trans('title.delete_hostel')}}</h4>
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            <span aria-hidden="true">&times;</span>
	          </button>
	        </div>
	        <div class="modal-body">
	          <p> {{trans('message.delete_hostel')}}</p>
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-danger" data-dismiss="modal">{{trans('button.close')}}</button>
	          <a href="{{ url('/delete-hostel/11') }}" id="delete-hostel" class="btn btn-primary">{{trans('button.delete')}}</a>
	        </div>
	      </div>
	      <!-- /.modal-content -->
	    </div>
	    <!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
    <!-- /.delete confirmation modal -->
	<div class="modal fade" id="modal-hostel-restore">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{trans('title.retore_hostel')}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p> {{trans('message.restore_hostel')}}</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">{{trans('button.close')}}</button>
              <a href="{{ url('/restore-hostel/11') }}" id="restore-hostel" class="btn btn-primary">{{trans('button.restore')}}</a>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection
@section('script') 
@endsection

