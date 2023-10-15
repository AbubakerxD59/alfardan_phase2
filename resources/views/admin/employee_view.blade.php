@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Employee View')

@section('content')

<main class="user-info-wrapper col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position">

	<h2 class="table-cap pb-2 mb-3 text-capitalize">{{$employee->name}}<span class="user-info-id">AF{{$employee->id}}</span></h2>

	<!-- First row -->
	<div class="row mb-4">
		<div class="col-xxl-3 col-xl-3">
			<figure class="user-profile-pic">
				@if(!empty($employee->profile))
					<img src="{{$employee->profile}}" alt="User Info Profile Pic">
				@else
					<img src="{{asset('alfardan/assets/user-info-3.jpg')}}" alt="User Info Profile Pic">
				@endif
			</figure>
		</div>
		<div class="col-xxl-9 col-xl-9 mt-auto ">
			<div class=" table-responsive tenant-table ">
				<caption>
					<h2 class="table-cap pb-1 mb-3 text-capitalize float-start clear-both">Employee Info</h2>
					<!-- <a href="#" class="contract-btn float-end">View Contract</a> -->
				</caption>
				<table class="table  table-bordered">
					<thead>
						<tr>
							<th scope="col"><span>Employee ID</span></th>
							<th scope="col"><span>Email</span></th>
							<!-- <th scope="col"><span>Password</span></th> -->
							<th scope="col"><span>Job Role</span></th>
							<th scope="col"><span>Access Type</span></th> 
							<th scope="col"><span>Birth Date</span></th>
							<th scope="col"><Span>Phone Number</Span></th>
							<th scope="col"><span>Office Number</span></th>
							<th scope="col"><span>Property</span></th>
							<th scope="col"><span>Apartment</span></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{$employee->emp_id}}</td>
							<td>{{$employee->email}}</td>
							<!-- <td>*********</td> -->
							<td>{{$employee->job_role}}</td>
							<td>{{$employee->type}}</td>                     
							<td>{{$employee->dob}}</td>
							<td>{{$employee->phone}}</td>
							<td>{{$employee->office_number}}</td>
							<td>{{implode(', ', $employee->propertylisit()->pluck('name')->toArray())}}</td>
							<td>{{@$employee->Apartment->name}}</td>
						</tr>       
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- scnd row -->
	<div class="row">
		<div class="col-xxl-3 col-xl-5">
			<div class=" table-responsive tenant-table">
				<div class="vehicle-table-caption">
					<h2 class="table-cap pb-2 mb-3 text-capitalize float-start clear-both">Pending Requests</h2>


				</div>
				<table class="table  table-bordered">
					<thead>
						<tr>
							<th scope="col"><span>Notification</span></th>
							<th scope="col"><span>Status</span></th>

						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Request #1289</td>
							<td>Pending Approval</td>

						</tr> 
						<tr>
							<td>Request #1289</td>
							<td>Pending Approval</td>


						</tr>       
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-xxl-3 col-xl-5">
			<div class=" table-responsive tenant-table">
				<caption>
					<h2 class="table-cap pb-2 mb-4 text-capitalize float-start clear-both">Closed Requests</h2>
				</caption>
				<table class="table  table-bordered">
					<thead>
						<tr>
							<th scope="col"><span>Notification</span></th>
							<th scope="col"><span>Status</span></th>


						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Request #1289</td>
							<td>Canceled</td>

						</tr> 
						<tr>
							<td>Request #1289</td>
							<td>Approved</td>

						</tr>       
					</tbody>
				</table>
			</div>
		</div>
	</div>

</main>

@endsection
