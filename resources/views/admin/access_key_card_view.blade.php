@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Automated Guest View')

@section('content')

<main class="user-info-wrapper col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position">

	<h2 class="table-cap pb-2 mb-3 text-capitalize">Access Key Card View</h2>
	<a href="{{route('admin.accessKey',$access->id)}}" class="contract-btn float-end mb-2">Generate PDF</a>
	<!-- First row -->
	<div class="row">
		<div class="col-xxl-3 col-xl-3">
			<figure class="user-profile-pic">
				@if(!empty(@$access->user->profile))
				<img src="{{@$access->user->profile}}" alt="User Info Profile Pic">
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
							<th scope="col"><span>User ID</span></th>
							<th scope="col"><span>Contact Number</span></th>
							<th scope="col"><span>Submission Date</span></th>
							<!-- <th scope="col"><span>Availability Date</span></th>  -->
							<th scope="col"><span>Apartment</span></th>
							<th scope="col"><Span>Property</Span></th>
							<th scope="col"><span>Form Status</span></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{$access->form_id}}</td>
							<td>{{$access->user_id}}</td>
							<td>{{@$access->user->mobile}}</td>
							<td>{{$access->created_at->todatestring()}}</td>
							<!-- <td></td>                      -->
							<td>{{@$access->user->apt_number}}</td>
							<td>{{@$access->user->property}}</td>
							<td>
								@if($access->form_status==1)
								Publish
							
							@else
								Draft
							
							@endif
							</td>
						</tr>       
					</tbody>
				</table>
			</div>
			<!-- small table start -->
			<div class="table-responsive tenant-table small-status-table">

				<table class="table  table-bordered">
					<thead>
						<tr>
							<th class="px-2 px-4"><span>Status</span></th>
							<th class="text-start ps-3"><span>Reason</span></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{$access->status}}
							</td>
							<td><p class="ps-2 ps-sm-2">{{@$access->description}}</p></td>

						</tr>       
					</tbody>
				</table>
			</div>
			<!-- small table end -->
		</div>
	</div>
	<!-- scnd row -->
	<div class="row">
		<div class="col-xxl-6 col-xl-12">
			<div class="table-responsive tenant-table unique-table">
				<caption>
					<h2 class="table-cap pb-2 mb-3 text-capitalize float-start clear-both">Access Details</h2>
				</caption>
				<table class="table  table-bordered">
					<thead>
						<tr>
							<th><span>User’s Name</span></th>
							<th><span>Access</span></th>
							<th><span>Expiery Date</span></th>
							<th><span>Quantiy</span></th>
							<th><span>Charge</span></th>
							<th><span>Remark</span></th>
							<th><span>Status</span></th>
							<th colspan="2"></th>
						</tr>
					</thead>
					<tbody>
						
						<tr>
							<td>{{@$access->user->full_name}} </td>
							<td>{{$access->access_type}}</td>
							<td>{{$access->expiry_date}}</td>
							<td>{{$access->quantity}}</td>
							<td>{{$access->charge}}</td>
							<td>{{$access->description}}</td>
							<td>{{$access->status}}
							</td>
							<td class="fw-bold" data-bs-toggle="modal" data-bs-target="#edit-access-key-detail">Edit</td>
							<td><a href="#">remove</a></td>
						</tr>  
						    
					</tbody>
				</table>
			</div>
		</div>

	</div>

</main>

@endsection
