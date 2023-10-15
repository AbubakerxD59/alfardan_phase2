@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Housekeeping Form View')

@section('content')

<main class="user-info-wrapper col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position">

	<h2 class="table-cap pb-2 mb-3 text-capitalize">{{$housekeeper->name}}</h2>
	<a href="{{route('admin.housekeeper',$housekeeper->id)}}" class="contract-btn float-end mb-2">Generate PDF</a>
	<!-- First row end -->
	<div class="row">
		<div class="col-xxl-12 col-xl-12">
			<div class="table-responsive tenant-table">

				<table class="table  table-bordered">
					<thead>
						<tr>
							<th><span>Form ID</span></th>
							<th><span>User Name</span></th>
							<th><span>Contact Number</span></th>
							<th><span>Housekeeper Name</span></th>
							<th><span>Qatar ID</span></th>
							<th><span>Submission Date</span></th>
							<th><span>Apartment</span></th>
							<th><Span>Property</Span></th>

						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{$housekeeper->form_id}}</td>
							<td>{{@$housekeeper->user->full_name}}</td>
							<td>{{$housekeeper->contact}}</td>
							<td>{{$housekeeper->name}}</td>
							<td>{{$housekeeper->qatar_id}}</td>                     
							<td>{{$housekeeper->created_at->todatestring()}}</td>                     
							<td>{{@$housekeeper->user->apt_number}}</td>                    
							<td>{{@$housekeeper->user->property}}</td>
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
				@if(!empty($housekeeper->user->profile))
				<img src="{{@$housekeeper->user->profile}}" alt="User Info Profile Pic">
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
							<th class="px-3"><span>Status</span></th>
							<th class="text-start ps-3"><span>Reason</span></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{$housekeeper->status}}
							</td>
							<td><p class="ps-2">{{$housekeeper->reason}}</p></td>

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
