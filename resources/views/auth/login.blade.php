@extends('layouts.full-page')

@section('content')
    <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
        <div class="row flex-grow">
            <div class="col-lg-6 d-flex align-items-center justify-content-center">
                <div class="auth-form-transparent text-left p-3">
                    <div class="brand-logo">
                        @if(setting('site_logo') != null)
                            <img src="{{ Storage::url(setting('site_logo')) }}" alt="logo">
                        @else
                            {{ setting('site_title') }}
                        @endif
                    </div>
                    <h4>Welcome back!</h4>
                    <h6 class="font-weight-light">Happy to see you again!</h6>
                    <form method="POST" action="{{ route('login') }}" class="pt-3">
                        @csrf

                        <div class="form-group @error('email') has-danger @enderror">
                            <label for="email">Email</label>
                            <input type="email"
                                   class="form-control form-control-lg @error('email') form-control-danger @enderror"
                                   id="email"
                                   name="email"
                                   placeholder="Email" required autofocus>
                            @error('email')
                            <label id="email-error" class="error mt-2 text-danger" for="email">{{ $message }}</label>
                            @enderror
                        </div>

                        <div class="form-group @error('password') has-danger @enderror">
                            <label for="password">Password</label>
                            <input type="password"
                                   class="form-control form-control-lg @error('password') form-control-danger @enderror"
                                   id="password"
                                   name="password"
                                   placeholder="Password" required>
                            @error('password')
                            <label id="email-error" class="error mt-2 text-danger" for="password">{{ $message }}</label>
                            @enderror
                        </div>

                        <div class="my-2 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <label class="form-check-label text-muted">
                                    <input type="checkbox" name="remember" id="remember"
                                           class="form-check-input" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="auth-link text-black" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                        <div class="my-3">
                            <button type="submit"
                                    class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                                LOGIN
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 login-half-bg d-flex flex-row"
                 style="background: url({{ asset('images/auth-bg.jpg') }}); background-size: cover;">
                <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright
                    &copy; {{ date('Y') }}
                    All rights reserved.</p>
            </div>
        </div>
    </div>
@endsection
