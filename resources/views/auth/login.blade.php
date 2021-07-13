@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row h-100">
            <div class="login-left-content">
                <div style="background: #FFBA33;" class="col-sm-8 col-2 h-100  text-white py-2 d-flex align-items-center justify-content-center fixed-top"
                    id="left">

                    <h5 class=" d-none d-sm-block">
                        <h1 class="display-3 text-white mb-20">{{ config('app.name', 'Laravel') }}</h1>
                    </h5>
                </div>
            </div>

            <div class="col offset-2 offset-sm-8 py-2 login-right-content">
                <h4 class="text-center display-8 mb-10">{{ config('app.name', 'Laravel') }}</h4>
                <p class="text-center display-5">Sign up.</p>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group row">
                        {{-- <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label> --}}

                        <div class="col-md-12">
                            <div class="input-group">
                                <div class="input-group-prepend ">
                                    <span class="input-group-text ">
                                        <i class="fa fa-envelope "></i>
                                    </span>
                                </div>
                                <input type="email" class="form-control form__input @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" placeholder="Email" autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        {{-- <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label> --}}
                        <div class="col-md-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="ti-lock"></i>
                                    </span>
                                </div>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" placeholder="Password" autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 ">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-row ">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success btn-block ">
                                {{ __('Login') }}
                            </button>


                        </div>
                    </div>
                    <div class="from-group row">
                        <div class="col-md-6">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                    <p class="text-center">OR</p>
                    <div class="form-row mt-2">

                        <div class="col-sm-12 mb-70">
                            <a href="{{ url('auth/google') }}" style="margin-top: 20px;"
                                class="btn btn-lg btn-primary btn-block btn-wth-icon">
                                <i class="fa fa-google"></i>
                                <strong>Login With Google</strong>
                            </a>
                            {{-- <button class="btn btn-primary btn-block btn-wth-icon"> <span class="icon-label"><i
                                            class="fa fa-google"></i> </span><span class="btn-text">Login with
                                        Google</span></button> --}}
                        </div>
                    </div>

                    <p class="text-center">Do have an account yet? <a href="{{ route('register') }}">Sign Up</a></p>
                </form>

            </div>

        </div>
    </div>

    </div>
    <style>
        main {
            margin-top: 0;
        }

        .main-content {
            margin-left: 0;
            background: #F8FAFC;
        }

    </style>
@endsection
