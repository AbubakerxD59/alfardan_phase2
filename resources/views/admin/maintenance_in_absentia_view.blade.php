@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Maintenance In Absentia View')

@section('content')

<main class="user-info-wrapper col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position">
	<h2 class="table-cap pb-2 mb-3 text-capitalize">View Form</h2>
	<a href="{{route('admin.maintenanceAbsentia',$maintenance->id)}}" class="contract-btn float-end mb-2">Generate PDF</a>
	<!-- First row end -->
	<div class="row">
		<div class="col-xxl-3 col-xl-3 col-lg-4">
			<figure class="user-profile-pic">
				@if(!empty($maintenance->user->profile))
				<img src="{{$maintenance->user->profile}}" alt="User Info Profile Pic">
				@else
				<img src="{{asset('alfardan/assets/profile-pic.jpg')}}" alt="User Info Profile Pic">
				@endif
			</figure>
		</div>
		<!-- First row end -->
		<!-- second row start -->
		<div class="col-xl-9 col-lg-8">

			<div class="table-responsive tenant-table maintenance-table">
				<table class="table  table-bordered">
					<thead>
						<tr>
							<th>Form ID</th>
							<th>User Name</th>
							<th>Contact Number</th>
							<th>Submissioan Date</th>
							<th>Availability Date </th>
							<th>Apartment</th>
							<th>Property</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{@$maintenance->form_id}}</td>
							<td>{{@$maintenance->user->full_name}} </td>
							<td>{{@$maintenance->phone}}</td>
							<td>{{@$maintenance->created_at->todatestring()}}</td>
							<td>{{@$maintenance->date}}</td>
							<td>{{@$maintenance->user->apt_number}}</td>
							<td>{{@$maintenance->user->property}}</td>
							<td>@if($maintenance->status==1)
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
							<th class="px-2 px-sm-5"><span>Status</span></th>
							<th class="text-start ps-3">Reason</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>@if($maintenance->status==1)
							Publish
						
							@else
								Draft
							
							@endif</td>
							<td><p class="ps-2">{{@$maintenance->reason}}</p></td>

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
