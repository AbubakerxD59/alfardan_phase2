@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Vehicle View')

@section('content')

<main class="user-info-wrapper col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position">

	<h2 class="table-cap pb-2 mb-3 text-capitalize">{{$vehicle->name}}</h2>
	<a href="{{route('admin.vehicle',$vehicle->id)}}" class="contract-btn float-end mb-2">Generate PDF</a>
	<!-- First row end -->
	<div class="row">
		<div class="col-xxl-12 col-xl-12">
			<div class="table-responsive tenant-table">

				<table class="table  table-bordered">
					<thead>
						<tr>
							<th>Form ID</th>
							<th>User Name</th>
							<th>Contact Number</th>
							<th>Submission Date</th>
							<th>Vehicle Name</th>
							<th>Vehicle Model</th>
							<th>Vehicle Color</th>
							<th>Registration Number</th>
							<th>Parking Space Number</th> 
							<th>Apartment</th>
							<th>Property</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{$vehicle->form_id}}</td>
							<td>{{@$vehicle->user->full_name}}</td>
							<td>{{$vehicle->phone}}</td>
							<td>{{$vehicle->created_at->todatestring()}}</td>
							<td>{{$vehicle->name}}</td>                     
							<td>{{$vehicle->model}}</td>                     
							<td>{{$vehicle->color}}</td>                     
							<td>{{$vehicle->registration}}</td> 
							<td>{{$vehicle->parking_space}}</td>                    
							<td>{{@$vehicle->user->apt_number}}</td>
							<td>{{@$vehicle->user->property}}</td>
							<td>{{$vehicle->status}}
							</td>
						</tr>       
					</tbody>
				</table>
			</div>

		</div>
	</div>
	<!-- First row end -->
	<!-- second row start -->
	<div class="row">
		<div class="col-xxl-3 col-xl-3">
			<figure class="user-profile-pic">
				@if(!empty($vehicle->user->profile))
				<img src="{{$vehicle->user->profile}}" alt="User Info Profile Pic">
				@else
				<img src="{{asset('alfardan/assets/profile-pic.jpg')}}" alt="User Info Profile Pic">
				@endif
			</figure>
		</div>
		<div class="col-xxl-9 col-xl-9">

			<!-- small table start -->
			<div class="table-responsive tenant-table small-status-table">

				<table class="table  table-bordered">
					<thead>
						<tr>
							<th class="px-3">Status</th>
							<th class="text-start ps-3">Reason</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{$vehicle->status}}
							</td>
							<td><p class="ps-2">{{$vehicle->reason}}</p></td>

						</tr>       
					</tbody>
				</table>
			</div>
			<!-- small table end -->
		</div>
	</div>
	<!-- second row end -->



</main>

@endsection
