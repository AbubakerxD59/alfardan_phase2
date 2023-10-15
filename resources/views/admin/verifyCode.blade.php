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
            <form method="POST" action="{{ route('admin.adminlogin') }}" id="login_form">
                 @csrf
                <div class="row">
                <div class="col-12 text-center mb-5">
                  <a class="navbar-brand" href="index.html">
                    <img src="{{asset('alfardan/assets/logo.png')}}">
                  </a>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <div class="col-8 text-center text-white mb-5">
                        <span>We have provided a short code in your email</span>
                    </div>
                </div>
              </div>
              <div class="row">
                <span class="alert alert-danger" id="error" style="display: none;"></span>
              </div>
              <div class="row">
                <div class="col-12">
                  <input type="number" name="code" placeholder="Code" id="code">
                </div>
              </div>


              <div class="row">
                <div class="col-12 text-center">
                  <div class="">
                    <input type="hidden" name="email" value="{{$user['email']}}" id="email">
                    <input type="hidden" name="password" value="{{$user['password']}}" id="password">
                    <button type="submit" class="login-btn text-uppercase" style="max-width: 375px;height: 52px;">GO TO HOME SCREEN</button>
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
@push('script')
<script>
    $(".login-btn").on('click', function(event){
        event.preventDefault();
        var code = $("#code").val();
        var email = $("#email").val();
        var password = Math.floor(100000 + Math.random() * 900000);
        $.ajax({
            url  : "{{route('admin.adminlogin')}}",
            type : 'Post',
            data :{'code':code , 'email':email , 'password':password , _token:'{{ csrf_token() }}'},
            dataType: 'json', 
            beforeSend: function(){
                // Show image container
                $("#loader").show();
            },   
            success : function(response) {
                $("#error").hide();
                $("#login_form").submit();
            },
            error : function(response) {
                $("#error").html('Invalid code, please try again!');
                $("#error").show();
            },
            complete:function(data){
                // Hide image container
                $("#loader").hide();
            }
        });
    });
</script>
@endpush