@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Service View')

@section('content')

<main class="user-info-wrapper col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position">

	<h2 class="table-cap pb-2 mb-3 text-capitalize">Services View</h2>
	<a href="{{route('admin.pdfServiceView',$service->id)}}" class="contract-btn float-end mb-2">Generate PDF</a>
	<!-- First row end -->
	<div class="row">
		<div class="col-12">
			<div class="table-responsive tenant-table maintenance-table">

				<table class="table  table-bordered">
					<thead>
						<tr>
							<th>Form ID</th>
							<th>User Name</th>
							<th>Contact Number</th>
							<th>Submission Date</th>
							<th>Availability Date</th>
							<th>Service Type</th>
							<th>Apartment</th>
							<th>Property</th>
							<th>Attendee Name</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{$service->form_id}}</td>
							<td>{{@$service->user->full_name}} </td>
							<td>{{@$service->user->mobile}}</td>
							<td>{{@$service->created_at->todatestring()}}</td>
							<td>{{$service->date}}</td>
							<td>{{$service->type}}</td>
							<td>{{@$service->user->apt_number}}</td>
							<td>{{@$service->user->property}}</td>                                        
							<td>{{$service->attendee}}</td>                    
						</tr>       
					</tbody>
				</table>
			</div>

		</div>
	</div>
	<!-- First row end -->
	<!-- second row start -->
	<div class="row">
		<div class="col-xxl-3 col-xl-3 col-lg-4">
			<figure class="user-profile-pic">
				@if(!empty(@$service->user->profile))
				<img src="{{@$service->user->profile}}" alt="User Info Profile Pic">
				@else
				<img src="{{asset('alfardan/assets/profile-pic.jpg')}}" alt="User Info Profile Pic">
				@endif
			</figure>
		</div>
		<div class="col-xxl-9 col-xl-9 col-lg-8">

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
							<td>{{($service->status)}}
							</td>
							<td><p class="ps-2">{{$service->reason}}</p></td>

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