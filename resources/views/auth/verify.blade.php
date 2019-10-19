@extends('auth.layouts.aapp')

{{-- 发送 「验证 E-mail」 页面  --}}
@section('content')

  <!-- Outer Row -->
  <div class="row justify-content-center">

    <div class="col-xl-10 col-lg-12 col-md-9">

      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg-6 d-none d-lg-block bg-password-image" style="background-image: url('/uploads/portal/img/auth/bg-verify-image.jpg')"></div>

            <div class="col-lg-6">

              <div class="p-5">

                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-2">{{ __('Verify Your Email Address') }}</h1>
                </div>

                @if (session('resent'))
                  <div class="card bg-success text-white shadow" style="margin-bottom: 10px;">
                    <div class="card-body">
                      <div class="text-white small">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                      </div>
                    </div>
                  </div>
                @endif

                <form class="user" method="POST" action="{{ route('verification.resend') }}">
                  @csrf
                  <p class="mb-4">{{ __('Before proceeding, please check your email for a verification link.') }} {{ __('If you did not receive the email') }}</p>

                  <button type="submit" class="btn btn-primary btn-user btn-block">
                    {{ __('click here to request another') }}
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
