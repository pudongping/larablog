@extends('auth.layouts.aapp')

@section('content')

  <!-- Outer Row -->
  <div class="row justify-content-center">

    <div class="col-xl-10 col-lg-12 col-md-9">

      <div class="card o-hidden border-0 shadow-lg my-5">

        <div class="card-body p-0">

          <!-- Nested Row within Card Body -->
          <div class="row">

            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
            <div class="col-lg-6">

              <div class="p-5">

                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">{{ __('Welcome Back!') }}</h1>
                </div>

                <form class="user" method="POST" action="{{ route('login') }}">
                  @csrf

                  {{-- 邮箱 --}}
                  <div class="form-group">
                    <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus id="exampleInputEmail" aria-describedby="emailHelp" placeholder="{{ __('Enter Email Address') }}">
                    @error('email')
                    <div class="text-center " style="color: #d9534f">{{ $message }}</div>
                    @enderror
                  </div>

                  {{-- 密码 --}}
                  <div class="form-group">
                    <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" id="exampleInputPassword" placeholder="{{ __('Enter Password') }}">
                    @error('password')
                    <div class="text-center " style="color: #d9534f">{{ $message }}</div>
                    @enderror
                  </div>

                  {{-- 记住我？ --}}
                  <div class="form-group">
                    <div class="custom-control custom-checkbox small">
                      <input type="checkbox" class="custom-control-input" id="customCheck" name="remember" {{ old('remember') ? 'checked' : '' }}>
                      <label class="custom-control-label" for="customCheck">{{ __('Remember Me') }}</label>
                    </div>
                  </div>

                  <button type="submit" class="btn btn-primary btn-user btn-block">
                    {{ __('Login') }}
                  </button>

                  <hr>

                  <a href="index.html" class="btn btn-google btn-user btn-block">
                    <i class="fab fa-google fa-fw"></i> Login with Google
                  </a>

                  <a href="index.html" class="btn btn-facebook btn-user btn-block">
                    <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                  </a>

                </form>

                <hr>

                <div class="text-center">
                  @if (Route::has('password.request'))
                    <a class="small" href="{{ route('password.request') }}">{{ __('Forgot Password?') }}</a>
                  @endif
                </div>

                <div class="text-center">
                  <a class="small" href="{{ route('register') }}">{{ __('Create an Account!') }}</a>
                </div>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

@endsection
