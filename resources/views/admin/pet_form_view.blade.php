@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Pet View')

@section('content')

<main class="user-info-wrapper col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position">
	<h2 class="table-cap pb-2 mb-3 text-capitalize">{{$pet->name}}</h2>
	<a href="{{route('admin.pdfPetView',$pet->id)}}" class="contract-btn float-end mb-2">Generate PDF</a>
	<!-- First row end -->
	<div class="row">
		<div class="col-xxl-3 col-xl-3 col-lg-4">
			<figure class="user-profile-pic">
				@if(!empty($pet->user->profile))
				<img src="{{@$pet->user->profile}}" alt="User Info Profile Pic">
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
							<th>User ID</th>
							<th>Pet Name</th>
							<th>Pet Family</th>
							<th>Species</th>
							<th>Size</th>
							<th>Weight</th>
							<th>Submission Date</th>
							<th>Location</th>
							<th>Poine Number</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{$pet->id}}</td>
							<td>{{$pet->user_id}}</td>
							<td>{{$pet->name}}</td>
							<td>{{$pet->family}}</td>
							<td>{{$pet->species}}</td>
							<td>{{$pet->size}}</td>
							<td>{{$pet->weight}}</td>
							<td>{{$pet->created_at->todatestring()}}</td>
							<td>{{@$pet->user->property}}</td>
							<td>{{$pet->id}}</td>
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
							<td>{{$pet->status}}
							</td>
							<td><p class="ps-2"></p></td>

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
