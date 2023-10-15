@extends('admin.layouts.layout')

@section('title','Login')

@section('content')

<div class="container-fluid">
  <div class="row">
    <main>
      <div class="row">
        <div class="col-12">
          <div class="login-wrapper">
             <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <form method="POST" action="{{ route('admin.verifycode') }}">
            {{-- <form method="POST" action="{{ route('admin.adminlogin') }}"> --}}
                 @csrf
                <div class="row">
                <div class="col-12 text-center mb-3">
                  <a class="navbar-brand" href="index.html">
                    <img src="{{asset('alfardan/assets/logo.png')}}">
                  </a>
                </div>
              </div>
              @include('notification.notify')
              <div class="row">
                <div class="col-12">
                  <input type="email" name="email" placeholder="Email">
                  <input type="password" name="password" placeholder="Password">
                </div>
              </div>

              <div class="row">
                <div class="col-12">
                  <div class="form-group form-check my-1 pb-4 pb-sm-5">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Remember me</label>
                    <a href="{{route('admin.forgot_password')}}" class="forgot-password">Forgot password?</a>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-12 text-center">
                  <div class="">
                    <button type="submit" class="login-btn text-uppercase" style="max-width: 265px;height: 52px;">Log in</button>
                    <!-- <a href="#" class="login-btn text-uppercase">Log in</a> -->
                  </div>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </main>

  </div>
</div>
@endsection
