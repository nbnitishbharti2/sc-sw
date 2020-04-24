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
							<h1>View Section</h1>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 right-align">
							<a href="{!! url('/') !!}" class="btn btn-success"><i class="fa fa-arrow-left"></i> &nbsp; Back</a>
							<a href="{!! route('add.section') !!}" class="btn btn-primary"><i class="fa fa-plus"></i>  &nbsp; Add</a>
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
													<th>Serial No</th>
													<th>Class Name</th>
													<th>Section Name</th>
													<th>Section Short</th>
													<th>Created</th>
													<th>Action</th>
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
															<a href="{!! route('edit.section', $item->id) !!}" class="btn-sm btn btn-primary"><i class="fa fa-edit"></i>  </a>
															<button class="btn-sm btn btn-danger" onclick="confirm_section_delete({{ $item->id }})"><i class="fa fa-trash"></i></button>
														@else
															<button class="btn-sm btn btn-success" title="Restore" onclick="confirm_section_restore({{ $item->id }})"><i class="fa fa-undo"></i></button>
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
		<footer class="main-footer">
			<strong>Copyright &copy; 2019-{{ date('Y') }} <a href="http://galaxywebsolution.in">Galaxy Web Solution</a>.</strong>
			All rights reserved.
		</footer>

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
					<h4 class="modal-title">Delete Section</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p> Are you sure? You want to Delete Section.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<a href="{{ url('/delete-section/11') }}" id="delete-section" class="btn btn-primary">Delete</a>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('public/js/common-function.js') }}"></script>
@endsection

