@extends('auth.layouts.aapp')

{{-- 「忘记密码」 发送重置密码链接页面  --}}
@section('content')

  <!-- Outer Row -->
  <div class="row justify-content-center">

    <div class="col-xl-10 col-lg-12 col-md-9">

      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>

            <div class="col-lg-6">

              <div class="p-5">

                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-2">{{ __('Forgot Your Password?') }}</h1>
                  <p class="mb-4">{{ __("Just enter your email address below and we'll send you a link to reset your password!") }}</p>
                </div>

                @if (session('status'))
                <div class="card bg-success text-white shadow" style="margin-bottom: 10px;">
                  <div class="card-body">
                    <div class="text-white small">
                      {{ session('status') }}
                    </div>
                  </div>
                </div>
                @endif

                <form class="user" method="POST" action="{{ route('password.email') }}">
                  @csrf
                  <div class="form-group">
                    <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="{{ __('Enter Email Address') }}" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <div class="text-center " style="color: #d9534f">{{ $message }}</div>
                    @enderror
                  </div>
                  <button type="submit" class="btn btn-primary btn-user btn-block">
                    {{ __('Reset Password') }}
                  </button>
                </form>

                <hr>

                <div class="text-center">
                  <a class="small" href="{{ route('register') }}">{{ __('Create an Account!') }}</a>
                </div>

                <div class="text-center">
                  <a class="small" href="{{ route('login') }}">{{ __('Already have an account? Please Login!') }}</a>
                </div>

              </div>

            </div>

          </div>
        </div>
      </div>

    </div>

  </div>

@endsection
