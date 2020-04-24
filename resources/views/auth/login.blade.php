@extends('layouts.app')
@section('content')
<body class="hold-transition login-page">

    <div class="login-box">
        <div class="login-logo auth-messge"> 
            <label>{{ $data->school_name }}</label>
            @if(session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fas fa-check"></i>{{ session('success') }}
            </div>  
            @endif
            @if(session('error'))
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fas fa-exclamation-triangle"></i>{{ session('error') }}
            </div>  
            @endif
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">{{ trans('title.login_title') }}</p>
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        @php $currntSession=CommanHelper::getCurrentSession() @endphp {{-- getSession --}}
                        <input type="text" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus placeholder="{{ \Lang::get('placeholder.email') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" required name="password" placeholder="{{ \Lang::get('placeholder.password') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <select name="session" class="form-control">
                            @foreach(CommanHelper::getSession() as $key => $value)
                            <option value="{{ $value->id }}" {{ ($value->academic_year==$currntSession)?'selected':'' }}>{{ $value->academic_year }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    {{ \Lang::get('label.remember_me') }}
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">{{ \Lang::get('button.login') }}</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mb-1">
                    <a href="{{ route('password.request') }}">{{ \Lang::get('label.forgot') }}</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    @endsection