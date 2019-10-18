@extends('auth.layouts.aapp')

@section('content')

  <div class="card o-hidden border-0 shadow-lg my-5">

    <div class="card-body p-0">

      <!-- Nested Row within Card Body -->
      <div class="row">

        <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>

        <div class="col-lg-7">

          <div class="p-5">

            <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">{{ __('Create an Account!') }}</h1>
            </div>

            <form class="user" method="POST" action="{{ route('register') }}">
              @csrf

              {{-- 姓名 --}}
              <div class="form-group">
                  <input type="text" class="form-control form-control-user @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus id="exampleFirstName" placeholder="{{ __('Name') }}">
                  @error('name')
                  <div class="text-center " style="color: #d9534f">{{ $message }}</div>
                  @enderror
              </div>

              {{-- 邮箱地址 --}}
              <div class="form-group">
                <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" id="exampleInputEmail" placeholder="{{ __('E-Mail Address') }}">
                @error('email')
                <div class="text-center " style="color: #d9534f">{{ $message }}</div>
                @enderror
              </div>

              {{-- 密码和确认密码 --}}
              <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" id="exampleInputPassword" placeholder="{{ __('Password') }}">
                  @error('password')
                  <div class="text-center " style="color: #d9534f">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-sm-6">
                  <input type="password" class="form-control form-control-user" name="password_confirmation" required autocomplete="new-password" id="exampleRepeatPassword" placeholder="{{ __('Confirm Password') }}">
                </div>
              </div>

              {{-- 图片验证码 --}}
              <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <img src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码" style="cursor: pointer; border: 1px solid #ced4da; border-radius: 4px; padding: 3px; ">
                </div>
                <div class="col-md-6">
                  <input id="captcha" class="form-control form-control-user {{ $errors->has('captcha') ? ' is-invalid' : '' }}" name="captcha" required>
                  @if ($errors->has('captcha'))
                    <div class="text-center " style="color: #d9534f">{{ $errors->first('captcha') }}</div>
                  @endif
                </div>
              </div>

              <button type="submit" class="btn btn-primary btn-user btn-block">
                {{ __('Register Account') }}
              </button>

              <hr>

              <a href="index.html" class="btn btn-google btn-user btn-block">
                <i class="fab fa-google fa-fw"></i> Register with Google
              </a>

              {{--<a href="index.html" class="btn btn-facebook btn-user btn-block">--}}
                {{--<i class="fab fa-facebook-f fa-fw"></i> Register with Facebook--}}
              {{--</a>--}}

            </form>

            <hr>

            <div class="text-center">
              @if (Route::has('password.request'))
                <a class="small" href="{{ route('password.request') }}">{{ __('Forgot Password?') }}</a>
              @endif
            </div>

            <div class="text-center">
              <a class="small" href="{{ route('login') }}">{{ __('Already have an account? Please Login!') }}</a>
            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

@endsection
