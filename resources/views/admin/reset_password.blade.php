@extends('admin.layouts.layout')

@section('title','Forgot Password')

@section('content')
 
@include('admin.layouts.header')

@include('admin.layouts.sidebar')
		<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position">
			<div class="row">
				<div class="col-12">
					<div class="forget-password-wrapper">
						<form action="{{route('admin.updatepassword')}}" method="post" accept-charset="utf-8">
		

									{{ csrf_field() }}

							<div class="row ">
								<div class="col-12">
									<h1 style="color: #fff;">Update Password?</h1>
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
									<input type="password" name="oldpassword" placeholder="Old Password">
								</div>
								<div class="col-12">
									<input type="password" name="password" placeholder="New Password">
								</div>
								<div class="col-12">
									<input type="password" name="password_confirmation" placeholder="confirm Password">
								</div>
							</div>



							<div class="row">
								<div class="col-12 text-center">
									<div class="">
										<button type="submit" class="login-btn text-uppercase h-auto" 
												style="line-height: normal;max-width: -webkit-fill-available;">Update Password</button>
										
									</div>
								</div>
							</div>

						</form>
					</div>
				</div>
			</div>
		</main>
 

@endsection
