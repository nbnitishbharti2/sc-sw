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
							<h1>{{trans('title.view_section')}}</h1>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 right-align">
							<a href="{!! url('/') !!}" class="btn btn-success"><i class="fa fa-arrow-left"></i> &nbsp; {{trans('button.back')}}</a>
							@if(Helper::checkPermission('add-section'))
							<a href="{!! route('add.section') !!}" class="btn btn-primary"><i class="fa fa-plus"></i>  &nbsp; {{trans('button.add')}}</a>
							@endif
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
													<th>{{trans('title.class_name')}}</th>
													<th>{{trans('title.section_name')}}</th>
													<th>{{trans('title.section_short')}}</th>
													<th>{{trans('title.created')}}</th>
													<th>{{trans('title.action')}}</th>
												</tr>
											</thead>
											<tbody>
												@php $i = 0; @endphp
												@foreach($section as $item)
												<tr>
													<td>{!! ++$i !!}</td>
													<td>{!! $item->class->class_name !!}</td>
													<td>{!! $item->section_name !!}</td>
													<td>{!! $item->section_short !!}</td>
													<td>{!! Carbon\Carbon::parse($item->created_at)->format(config('app.date_time_format')) !!}</td>
													<td>
														@if(empty($item->deleted_at))

															@if(Helper::checkPermission('edit-section'))
															<a href="{!! route('edit.section', $item->id) !!}" class="btn-sm btn btn-primary"><i class="fa fa-edit"></i>  </a>
															@endif

															@if(Helper::checkPermission('delete-section'))
															<button class="btn-sm btn btn-danger" onclick="confirm_section_delete({{ $item->id }})"><i class="fa fa-trash"></i></button>
															@endif
															
														@else

														    @if(Helper::checkPermission('delete-section'))
															<button class="btn-sm btn btn-success" title="Restore" onclick="confirm_section_restore({{ $item->id }})"><i class="fa fa-undo"></i></button>
															@endif
															
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
	<div class="modal fade" id="modal-section-delete">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">{{Lang::get('title.delete_section')}}</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>{{Lang::get('message.delete_section')}}</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('button.close') }}</button>
					<a href="{{ url('/delete-section/11') }}" id="delete-section" class="btn btn-primary">{{ trans('button.delete') }}</a>
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

