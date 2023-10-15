@extends('admin.layouts.layout')

@section('title','Forgot Password')

@section('content')

<div class="container-fluid">
	<div class="row">

		<main>
			<div class="row">
				<div class="col-12">
					<div class="forget-password-wrapper">
						<form action="{{route('admin.send_forgot_password_link')}}" method="post" accept-charset="utf-8">
							<div class="row">
								<div class="col-12 text-center mb-5">
									<a class="navbar-brand" href="index.html">
										<img src="{{asset('alfardan/assets/logo.png')}}">
									</a>
								</div>
							</div>


							<div class="row ">
								<div class="col-12">
									<h2>Forgot Password?</h2>
									<p>Please provide your  email address. You will receive an email with a link to update your password</p>
								</div>
							</div>

							<div class="row">
								@include('notification.notify')
								@if($errors->any())
								  @foreach($errors->all() as $error)
									<div class="alert alert-danger">
									  {{$error}}
									</div>
									@endforeach
								 @endif
								<div class="col-12">
									{{ csrf_field() }}

									<input type="email" name="email" placeholder="Email">
								</div>
							</div>



							<div class="row">
								<div class="col-12 text-center">
									<div class="">
										<button type="submit" class="login-btn text-uppercase h-auto" 
												style="line-height: normal;max-width: -webkit-fill-available;">Reset Password</button>
										
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
