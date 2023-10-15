@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Maintenance View')

@section('content')

<main class="user-info-wrapper col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position">

	<h2 class="table-cap pb-2 mb-3 text-capitalize">{{$maintenances->name}}</h2>
	<!-- First row end -->
	<div class="row">
		<div class="col-xxl-12 col-xl-12">
			<div class="table-responsive tenant-table maintenance-table">

				<table class="table  table-bordered">
					<thead>
						<tr>
							<th >Tenant Name</th>
							<th >Phone Number</th>
							<th >Maintenance Type</th>
							<th >Submisson Date/Time</th>
							<th >Availability Date/Time</th>
							<th >Location</th>
							<th >Ticket ID</th>
							<th >Status</th>


						</tr>
					</thead>
					<tbody>
				

						<tr>
							<td><a href="#">{{@$maintenances->users->full_name}}</a></td>
							<td>{{@$maintenances->users->mobile}}</td>
							<td>{{$maintenances->type}}</td>
							<td>{{$maintenances->created_at}}</td>
							<td>{{$maintenances->date}} {{$maintenances->time}}</td>                     
							<td>{{@$maintenances->users->property}}</td>                     
							<td>{{$maintenances->ticket_id}}</td>                    
							<td>{{$maintenances->status}}</td>
							
						</tr>  
					
					</tbody>
				</table>
			</div>

		</div>
	</div>
	<!-- First row end -->
	<!-- second row start -->
	<div class="row">
		<div class="col-xxl-5 col-xl-5">
			<figure class="user-profile-pic-2">
				@if(!empty($maintenances->images[0]['path']))
					<img src="{{$maintenances->images[0]['path']}}" alt="User Info Profile Pic">
				@else
					<img src="{{asset('alfardan/assets/maintenance1.jpg')}}" alt="User Info Profile Pic">
				@endif
			</figure>
		</div>
		<div class="col-xxl-7 col-xl-7 mt-auto">

			<!-- small table start -->
			<div class="table-responsive tenant-table small-status-table-1">

				<table class="table  table-bordered">
					<thead>
						<tr>
							<th scope="col"><span>Maintenance Employee</span></th>

						</tr>
					</thead>
					<tbody>
						<tr>
							<td><a href="#">{{$maintenances->emp_name}}</a></td>


						</tr>       
					</tbody>
				</table>
			</div>
			<!-- small table end -->
		</div>
	</div>
	<!-- second row end --> 
	<section class="mt-5">
    <h2 class="review-heading">Review History</h2>
    @foreach($maintenances->reviews as $review)
    
    <article class="article-wrapper">
      <span class="event-title">{{@$review->user->full_name}} </span>
      <div class="rating-icon">
      @for($i=0;$i<$review->stars;$i++)
      <i class="fa fa-star"></i> 
      @endfor 
      </div>
      <p class="description">
        {{$review->description}} 
      </p>
      <time><span class="fst-italic">Added on</span> {{$review->created_at}}</time>
    </article>
    @endforeach
   
  </section>
</main>

@endsection
