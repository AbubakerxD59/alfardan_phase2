@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Automated Guest View')

@section('content')

<main class="user-info-wrapper col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position">

	<h2 class="table-cap pb-2 mb-3 text-capitalize">Automated Guest Access View</h2>
	<a href="{{route('admin.guestAccess',$guest->id)}}" class="contract-btn float-end mb-2">Generate PDF</a>
	<!-- First row -->
	<div class="row">
		<div class="col-xxl-3 col-xl-3">
			<figure class="user-profile-pic">
				@if(!empty(@$guest->photo))
				<img src="{{@$guest->photo}}" alt="User Info Profile Pic">
				@else
				<img src="{{asset('alfardan/assets/profile-pic.jpg')}}" alt="User Info Profile Pic">
				@endif
			</figure>
		</div>
		<div class="col-xxl-9 col-xl-9">
			<div class="table-responsive tenant-table">

				<table class="table  table-bordered">
					<thead>
						<tr>
							<th scope="col"><span>Form ID</span></th>
							<th scope="col"><span>User Name</span></th>
							<th scope="col"><span>Contact Number</span></th>
							<th scope="col"><span>Submission Date</span></th>
							<th scope="col"><span>Availability Date</span></th> 
							<th scope="col"><span>Apartment</span></th>
							<th scope="col"><Span>Property</Span></th>
							<th scope="col"><span>Status</span></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><a href="#">{{$guest->form_id}}</a></td>
							<td>{{@$guest->user->full_name}}</td>
							<td>{{$guest->phone}}</td>
							<td>{{$guest->created_at->todatestring()}}</td>
							<td>{{$guest->date}}</td>                     
							<td>{{@$guest->user->apt_number}}</td>
							<td>{{@$guest->user->property}}</td>
							<td>@if($guest->status==1)
							Publish
						
						@else
							Draft
						
						@endif</td>
						</tr>       
					</tbody>
				</table>
			</div>
			<!-- small table start -->
			<div class="table-responsive tenant-table small-status-table">

				<table class="table  table-bordered">
					<thead>
						<tr>
							<th scope="col"><span>Status</span></th>
							<th scope="col"><span>Reason</span></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><a href="#">{{$guest->status}}
							</a></td>
							<td><p class="ps-5">{{$guest->reason}}</p></td>

						</tr>       
					</tbody>
				</table>
			</div>
			<!-- small table end -->
		</div>
	</div>

</main>

@endsection
