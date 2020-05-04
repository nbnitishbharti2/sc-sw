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
                            <a href="{!! route('view.roles') !!}" class="btn btn-success"><i class="fa fa-arrow-left"></i> &nbsp; {{ trans('button.back') }}</a>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">{!! $title !!}</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <div class="card-body">
                                    <form role="form" action="{{ $action }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="roles_id" value="{{ $roles_id }}">
                                        <div class="row">
                                            <label class="col-lg-3 control-label title-role-page" >Role Title</label>
                                            <div class="col-lg-9">
                                                <input class="form-control {{ ($errors->has('title')) ? 'highlight_error' : '' }}" name="name" placeholder="{{ trans('placeholder.roles_name') }}" value="{{ $name }}" required>
                                            </div>
                                        </div>
                                        <div class="row role-header">
                                            <div class="col-4">
                                                <label class="control-label role-form-header" >{{ trans('label.screen') }}</label>
                                            </div>
                                            <div class=" col-2">
                                                <label class="control-label role-form-header" >{{ trans('label.view') }}</label>
                                            </div>
                                            <div class=" col-2">
                                                <label class="control-label role-form-header" >{{ trans('label.add') }}</label>
                                            </div>
                                            <div class=" col-2">
                                                <label class="control-label role-form-header" >{{ trans('label.edit') }}</label>
                                            </div>
                                            <div class=" col-2">
                                                <label class="control-label role-form-header" >{{ trans('label.delete') }}</label>
                                            </div>
                                        </div>
                                       
                                        @foreach($modules as $module)
                                         <hr>
                                        <div class="row role-header">
                                            <div class="col-4">
                                                <label class="control-label role-form-header" >{{ $module->name }}</label>
                                            </div>
                                            <div class="col-8">
                                                <div class="row">
                                            @php $comman=array('add','edit','view','delete') @endphp
                                            @foreach($module->Permission as $value)
                                                @php 
                                                     $option=explode('-', $value->name);
                                                @endphp
                                                @if(in_array($option[0], $comman))
                                            <div class="col-3">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" name="permission[]" id="permission_{{ $value->id }}" value="{{ $value->id }}" class="" {{ (isset($permission_role)?((in_array($value->id, $permission_role) )? 'checked="checked"' : ''):'') }} >
                                                    <label for="permission_{{ $value->id }}"> </label>
                                                </div>
                                            </div>
                                            @else   
                                                <div class="col-3  mt-2">
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" name="permission[]" id="permission_{{ $value->id }}" value="{{ $value->id }}" class="" {{ (isset($permission_role)?((in_array('5', $permission_role) )? 'checked="checked"' : ''):'') }} >
                                                        <label for="permission_{{ $value->id }}"> </label>
                                                    </div>
                                                </div>
                                                <div class="col-9  mt-2">
                                                    <label class="control-label role-form-header" >{{ $value->description }}</label>
                                                </div> 
                                            @endif
                                            @endforeach
                                           </div>
                                       </div>
                                        </div>
                                        @endforeach
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">{{ trans('button.submit') }}</button>
                                            <button type="reset" class="btn btn-danger">{{ trans('button.reset') }}</button>
                                            <a href="{{ route('view.roles') }}" class="btn btn-success">{{ trans('button.back') }}</a>
                                        </div>
                                       
                                    </form>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        {{-- End form column --}}
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