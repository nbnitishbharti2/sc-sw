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
							<h1>{{Lang::get('title.view_stopage')}}</h1>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 right-align">
							<a href="{!! url('/') !!}" class="btn btn-success"><i class="fa fa-arrow-left"></i> &nbsp; {{Lang::get('button.back')}}</a>
							<a href="{!! route('add.stopage') !!}" class="btn btn-primary"><i class="fa fa-plus"></i>  &nbsp; {{Lang::get('button.add')}}</a>
							<a href="{!! route('import.stopage') !!}" class="btn btn-primary"><i class="fa fa-undo"></i>  &nbsp; {{ trans('button.import_prv_session_stopages') }}</a>
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
													<th>{{Lang::get('title.serial_no')}}</th>
													<th>{{Lang::get('title.stopage_name')}}</th>
													<th>{{Lang::get('title.root')}}</th>
													<th>{{Lang::get('title.vehicle_type')}}</th>
													<th>{{Lang::get('title.vehicle')}}</th>
													<th>{{Lang::get('title.charge')}}</th>
													<th>{{Lang::get('title.created')}}</th>
													<th>{{Lang::get('title.action')}}</th>
												</tr>
											</thead>
											<tbody>
												@php $i = 0; @endphp
												@foreach($stopage as $item)
												 
													<tr>
														<td>{!! ++$i !!}</td>
														<td>{!! $item->stopage_name !!}</td>
														<td>{!! $item->roots->name !!}</td>
														<td>{!! $item->vehicle_types->name !!}</td>
														<td>{!! $item->vehicles->vehicle_no !!}</td>
														<td>{!! $item->charge !!}</td>
														<td>{!! Carbon\Carbon::parse($item->created_at)->format(config('app.date_time_format')) !!}</td>
														<td>
															@if(empty($item->deleted_at))
																<a href="{!! route('edit.stopage', $item->id) !!}"  title="Edit" class="btn-sm btn btn-primary"><i class="fa fa-edit"></i>  </a>
																<button class="btn-sm btn btn-danger" title="Delete" onclick="stopage_confirm_delete({{ $item->id  }})"><i class="fa fa-trash"></i></button>
															@else
																<button class="btn-sm btn btn-success" title="Restore" onclick="stopage_confirm_restore({{ $item->id }})"><i class="fa fa-undo"></i></button>
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
	<div class="modal fade" id="modal-stopage-delete">
	    <div class="modal-dialog">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title">{{Lang::get('title.delete_stopage')}}</h4>
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            <span aria-hidden="true">&times;</span>
	          </button>
	        </div>
	        <div class="modal-body">
	          <p> {{Lang::get('message.delete_stopage')}}</p>
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-danger" data-dismiss="modal">{{Lang::get('button.close')}}</button>
	          <a href="{{ url('/delete-stopage/11') }}" id="delete-stopage" class="btn btn-primary">{{Lang::get('button.delete')}}</a>
	        </div>
	      </div>
	      <!-- /.modal-content -->
	    </div>
	    <!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
    <!-- /.delete confirmation modal -->
	<div class="modal fade" id="modal-stopage-restore">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{Lang::get('title.retore_stopage')}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p> {{Lang::get('message.restore_stopage')}}</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">{{Lang::get('button.close')}}</button>
              <a href="{{ url('/restore-stopage/11') }}" id="restore-stopage" class="btn btn-primary">{{Lang::get('button.restore')}}</a>
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
