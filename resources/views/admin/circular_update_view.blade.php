@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Circular Update View')

@section('content')

<main class="user-info-wrapper col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position">

	<h2 class="table-cap pb-2 mb-3 text-capitalize">Circular Update View</h2>
	<!-- First row end -->
	<div class="row">
		<div class="col-xxl-9 col-xl-9">
			<div class="table-responsive tenant-table maintenance-table">

				<table class="table  table-bordered">
					<thead>
						<tr>
							<th scope="col"><span>Circular ID</span></th>
							<th scope="col"><span>Submission Date / Time</span></th>
							<!-- <th scope="col"><span>Submission Time</span></th> -->
							<th scope="col"><span>Apartment</span></th>
							<th scope="col"><span>Property</span></th>
							<th scope="col"><span>Status</span></th>


						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{$update->circular_id}}</td>
							<td>{{$update->created_at}}</td>
							<!-- <td></td> -->
							<td>{!!@$update->apartment()->implode('name',',<br/>')!!}</td>
							<td>{!!@$update->property()->implode('name',',<br/>')!!}</td>                                        
							<td>@if($update->status==1)
								Publish
							
							@else
								Draft
							
							@endif</td>                    
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
				@if(!empty($update->cover))
				<img src="{{$update->cover}}" alt="User Info Profile Pic">
				@else
				<img src="{{asset('alfardan/assets/shutterstock1.jpg')}}" alt="User Info Profile Pic">
				@endif
			</figure>
		</div>
		<div class="col-xxl-9 col-xl-9">

			<!-- small table start -->
			<div class="table-responsive tenant-table small-chat-table">
				<table class="table  table-bordered">
					<thead>
						<tr>
							<th class="text-start ps-3">Description</th>
							<!-- <th>Photo</th> -->
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><p class="ps-2 text-start">{{$update->description}}</p></td>
							<!-- <td class="p-0"><div>
								@if(!empty($update->image))
								<img src="{{$update->image}}" style="height: 60px;" alt="complaint-img">
								@else
								<img src="{{asset('alfardan/assets/complaint.jpg')}}" alt="complaint-img">
								@endif
							</div></td> -->

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
