@extends('auth.layouts.aapp')

{{-- 「重置密码」 填写信息框页面 --}}
@section('content')

  <!-- Outer Row -->
  <div class="row justify-content-center">

    <div class="col-xl-10 col-lg-12 col-md-9">

      <div class="card o-hidden border-0 shadow-lg my-5">

        <div class="card-body p-0">

          <!-- Nested Row within Card Body -->
          <div class="row">

            <div class="col-lg-6 d-none d-lg-block bg-login-image" style="background-image: url('/uploads/portal/img/auth/bg-reset-image.jpg')"></div>
            <div class="col-lg-6">

              <div class="p-5">

                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">{{ __('Reset Password') }}</h1>
                </div>

                <form class="user" method="POST" action="{{ route('password.update') }}">
                  @csrf

                  {{-- token --}}
                  <input type="hidden" name="token" value="{{ $token }}">

                  {{-- 邮箱 --}}
                  <div class="form-group">
                    <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus id="exampleInputEmail" aria-describedby="emailHelp" placeholder="{{ __('Enter Email Address') }}">
                    @error('email')
                    <div class="text-center " style="color: #d9534f">{{ $message }}</div>
                    @enderror
                  </div>

                  {{-- 密码 --}}
                  <div class="form-group">
                    <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" id="exampleInputPassword" placeholder="{{ __('Password') }}">
                    @error('password')
                    <div class="text-center " style="color: #d9534f">{{ $message }}</div>
                    @enderror
                  </div>

                  {{-- 确认密码 --}}
                  <div class="form-group">
                    <input type="password" class="form-control form-control-user" name="password_confirmation" required autocomplete="new-password" id="exampleRepeatPassword" placeholder="{{ __('Confirm Password') }}">
                  </div>

                  <button type="submit" class="btn btn-primary btn-user btn-block">
                    {{ __('Reset Password') }}
                  </button>

                </form>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

@endsection
