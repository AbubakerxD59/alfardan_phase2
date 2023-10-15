@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Apartment View')

@section('content')

<main class="user-info-wrapper col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position">

	<h2 class="table-cap pb-2 mb-3 text-capitalize">{{$apartment->name}}</h2>

	<!-- First row -->
	<div class="row">
		<div class="col-xxl-4 col-xl-4 col-lg-4 col-sm-5 col-12">

            <div class="profile-slider">
              	@foreach($apartment->images as $image)
              <div> <figure class="property-profile">
            <img src="{{$image['path']}}" alt="property Info Profile Pic">
          	</figure></div>
          	@endforeach
             
            </div>
        </div>
		<!-- <div class="col-xxl-3 col-xl-3">
			<figure class="property-profile">
				@if(!empty($apartment->images[0]['path']))
					<img src="{{$apartment->images[0]['path']}}" alt="property Info Profile Pic">
				@else
					<img src="{{asset('alfardan/assets/shutterstock.jpg')}}" alt="property Info Profile Pic">
				@endif
			</figure>
		</div> -->
		<div class="col-xxl-8 col-xl-8 mt-2">
			<div class="table-responsive tenant-table">

				<table class="table  table-bordered">
					<thead>
						<tr>
							<th scope="col"><span>No. Of Bedrooms</span></th>
							<th scope="col"><span>No. Of Bathrooms</span></th>
							<th scope="col"><span>Area</span></th>
							<th scope="col"><span>Property Name</span></th>
							<th scope="col"><span>Location</span></th> 
							<th scope="col"><span>3D View Link</span></th>
							<th scope="col"><Span>Call Number</Span></th>
							<th scope="col"><span>Email</span></th>
							<th scope="col"><span>Availability</span></th>
							<th scope="col"><span>Status</span></th>
						</tr>
					</thead>
					<tbody>
						
						<tr>
							<td>{{$apartment->bedrooms}}</td>
							<td>{{$apartment->bathrooms}}</td>
							<td>{{$apartment->area}}</td>
							<td>{{@$apartment->property->name}}</td>
							<td>{{$apartment->location}}</td>                     
							<td>{{$apartment->view_link}}</td>
							<td>{{$apartment->phone}}</td>
							<td>{{$apartment->email}}</td>
							<td>{{$apartment->availability}}</td>
							<td>@if($apartment->status==1)
							Publish
						
							@else
								Draft
							
							@endif</td>

						</tr>
						   
					</tbody>
				</table>
			</div>
			<div class="row">
				<div class="col-xxl-4 col-xl-4 col-lg-4">
					<!-- small table start -->
					<div class="table-responsive tenant-table small-status-table">

						<table class="table  table-bordered">
							<thead>
								<tr>
									<th class="ps-4 text-start"><span>Description </span></th>

								</tr>
							</thead>
							<tbody>
								<tr>
									<td><p class="ps-3 mw-100">{{$apartment->short_description}}</p></td>

								</tr>       
							</tbody>
						</table>
					</div>
					<!-- small table end -->
				</div>
				<div class="col-xxl-8 col-xl-8 col-lg-8">
					<!-- small table start -->
					<!-- <div class="table-responsive tenant-table small-description-table">

						<table class="table  table-bordered">
							<thead>
								<tr>
									<th class="ps-3"><span>Short Description </span></th>

								</tr>
							</thead>
							<tbody>
								<tr>
									<td><p class="ps-2 text-start">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum d</p></td>

								</tr>       
							</tbody>
						</table>
					</div> -->
					<!-- small table end -->
				</div>
			</div>
		</div>
	</div>
</main>

@endsection
