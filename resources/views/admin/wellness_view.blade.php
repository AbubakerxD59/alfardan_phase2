@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Wellness View')

@section('content')

<main class="event-wrapper col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position">
	@include('notification.notify')

	<caption>
		<h2 class="table-cap pb-2 mb-3 text-capitalize">{{$resort->name}}</h2>
		<a href="#" class="ps-2 ps-sm-4 text-capitalize fst-italic">
			@if($resort->status==1)
				Publish
			
			@else
				Draft
			
			@endif
		</a>
		<a href="{{route('admin.deleteResortView',$resort->id)}}" class="event-delete-btn float-end">Delete</a>
	</caption>
	<!-- First row -->
	<div class="row mb-4">
		
			@foreach($resort->images as $image)
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
					<div class="detail-img-holder">
						<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remove-item" data-id="{{$image->id}}" data-url="{{route('admin.deleteimage',[$image->id])}}" class="deleteitem cross-img" tabindex="0">X</a>
						<img src="{{$image->path}}" alt="Event Pic" class="event-pics">
					</div>
				</div>
		@endforeach
		{{--
		@if(!empty($resort->images[0]['path']))
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
				<div class="detail-img-holder">
					<img src="{{$resort->images[0]['path']}}" alt="Event Pic" class="event-pics">
				</div>
			</div>
		@else
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
				<div class="detail-img-holder">
					<img src="{{asset('alfardan/assets/class-view-4.2.jpg')}}" alt="Event Pic" class="event-pics">
				</div>
			</div>
		@endif
		@if(!empty($resort->images[1]['path']))
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
				<div class="detail-img-holder">
					<img src="{{$resort->images[1]['path']}}" alt="Event Pic" class="event-pics">
				</div>
			</div>
		@else
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
				<div class="detail-img-holder">
					<img src="{{asset('alfardan/assets/class-view-4.2.jpg')}}" alt="Event Pic" class="event-pics">
				</div>
			</div>
		@endif
		@if(!empty($resort->images[2]['path']))
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
				<div class="detail-img-holder">
					<img src="{{$resort->images[2]['path']}}" alt="Event Pic" class="event-pics">
				</div>
			</div>
		@else
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
				<div class="detail-img-holder">
					<img src="{{asset('alfardan/assets/class-view-4.2.jpg')}}" alt="Event Pic" class="event-pics">
				</div>
			</div>
		@endif
		--}}
	</div>
	<!-- scnd row -->
	<div class="d-flex">
		<div class="col-9">
			@if($resort->news_feed==1)
			<a href="{{route('admin.unsetResortNewsfeed',$resort->id)}}" class="add-to-feed-btn float-end" ><i class="fa fa-check"></i> Added to Newsfeed</a>
			@else
			<a href="{{route('admin.setResortNewsfeed',$resort->id)}}" class="add-to-feed-btn float-end" ><i class="fa fa-plus"></i> Add to Newsfeed</a>
			@endif
		</div>
		<div class="col-3">
			<div class="col-12">
				@if($resort->is_privilege==1)
				<a href="{{route('admin.unsetResortPrivilege',$resort->id)}}" class="add-to-privilege-btn float-end" ><i class="fa fa-check"></i> Added to Privilege</a>
				@else
				<a href="{{route('admin.setResortPrivilege',$resort->id)}}" class="add-to-privilege-btn float-end" ><i class="fa fa-plus"></i> Add to Privilege</a>
				@endif
			</div>
		</div>
	</div>
	<!-- thrd row -->
	<div class="row">
		<div class="col-xxl-4 col-xl-4 col-lg-4  col-12">
			<article class="event-description-wrapper">
				<h3>Description</h3>
				<p>
					{{$resort->description}}
				</p>
			</article>
		</div>
		<div class="col-xxl-4 col-xl-4 col-lg-4 col-12">
			<div class="location-wrapper">
				<h3 class="text-uppercase">location</h3>
				<div class="location-map">
					<iframe  src="https://www.google.com/maps/embed/v1/place?key={{env('google_map_key')}}&q={{$resort->latitude}},{{$resort->longitude}}" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
			</div>
		</div>
		<div class="col-xxl-4 col-xl-4 col-lg-4 col-12">
			<div class="profile-tenant-form events-radio-wrapper">
				<h2>Property</h2>
				<div class="property-input-wrapper">
					@if(!empty($resort->property))
					
					@foreach($resort->getpropertyname() as $value)
						<div class="form-check form-check-inline mb-2">
							<input class="form-check-input" name="property" type="checkbox" value="{{$value->name}}" checked="checked">
							<label class="form-check-label" for="inlineCheckbox3">{{$value->name}}</label>
						</div>
					@endforeach		
					@else
					<h2>Property not selected</h2>
					@endif
					<!-- <div class="form-check form-check-inline">
						<input class="form-check-input" name="property" type="radio" id="Property1" value="option1">
						<label class="form-check-label" for="Property1">Property 1</label>
					</div>

					<div class="form-check form-check-inline">
						<input class="form-check-input" name="property" type="radio" id="Property2" value="option2">
						<label class="form-check-label" for="Property2">Property 2</label>
					</div>

					<div class="form-check form-check-inline mb-2">
						<input class="form-check-input" name="property" type="radio" id="Property3" value="option3">
						<label class="form-check-label" for="Property3">Property 3</label>
					</div>

					<div class="form-check form-check-inline">
						<input class="form-check-input" name="property" type="radio" id="Property4" value="option4">
						<label class="form-check-label" for="Property4">Property 4</label>
					</div>

					<div class="form-check form-check-inline">
						<input class="form-check-input" name="property" type="radio" id="Property5" value="option4">
						<label class="form-check-label" for="Property5">Property 5</label>
					</div>

					<div class="form-check form-check-inline mb-2">
						<input class="form-check-input" name="property" type="radio" id="Property6" value="option6">
						<label class="form-check-label" for="Property6">Property 6</label>
					</div>

					<div class="form-check form-check-inline mb-2">
						<input class="form-check-input" name="property" type="radio" id="Property7" value="option7">
						<label class="form-check-label" for="Property7">Property 7</label>
					</div> -->
				</div>
				<h2>Tenant</h2>
				@if(!empty($resort->tenant_type))
				<?php 
				$type=explode(',',$resort->tenant_type);
				?>
				@foreach($type as $value)
					<div class="form-check form-check-inline mb-2">
						<input class="form-check-input" name="tenant_type" type="checkbox" value="{{$value}}" checked="checked">
						<label class="form-check-label" for="inlineCheckbox3">{{$value}}</label>
					</div>
				@endforeach
				@endif
				<!-- <div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" id="inlineCheckbox1" name="tenantinput" value="option1">
					<label class="form-check-label" for="inlineCheckbox1">VIP</label>
				</div>

				<div class="form-check form-check-inline">
					<input class="form-check-input" name="tenantinput" type="radio" id="inlineCheckbox2" value="option2">
					<label class="form-check-label" for="inlineCheckbox2">Regular</label>
				</div>

				<div class="form-check form-check-inline mb-2">
					<input class="form-check-input" name="tenantinput" type="radio" id="inlineCheckbox3" value="option3">
					<label class="form-check-label" for="inlineCheckbox3">Non-Tenant</label>
				</div> -->
			</div>
		</div>
	</div>          
	<!-- frth row -->
	<div class="row">
		<!-- <div class="col-xxl-4 col-xl-4 col-lg-4">
			<div class=" table-responsive   simple-table">
				<caption>
					<h2 class="table-cap pb-2 mb-3 text-capitalize">user list</h2>
					<div class="event-btn-wrapper">
						<a href="#" class="download-list-btn"><img src="{{asset('alfardan/assets/download-svg.png')}}" alt="download-icon" class="pe-2">Download List</a>
						<a href="#" class="add-new-btn">Add New</a>
					</div>
				</caption>
				<table class="table  table-bordered">
					<thead>
						<tr>
							<th scope="col"><span>User Name</span></th>
							<th scope="col"><span>Attendees</span></th>
							<th scope="col"><span>Time</span></th>
							<th scope="col"><span>Date Registered</span></th>
						</tr>
					</thead>
					<tbody>
						@foreach($resort->bookings as $booking)
						<tr>
							<td>{{@$booking->user->first_name}} {{@$booking->user->last_name}}</td>
							<td>{{@$booking->reservations}}</td>
							<td>{{@$booking->time}}</td>
							<td>{{@$booking->created_at}}</td>
						</tr> 
						@endforeach
						        
					</tbody>
				</table>
			</div>

		</div> -->
		<div class="col-xxl-4 col-xl-4 col-lg-4">
			<h2 class="table-cap pb-2 mb-3 text-capitalize">Reviews</h2>

			<div class="row">
				<div class="col-xxl-3 col-xl-4 col-lg-4 col-md-3 col-sm-2 col-4 pe-0">
					<div class="rating-counter-wrapper">
						<h3>{{intval($resort->avgreviews())}}.0</h3>
						<div class="rating-counter">
							<?php $ave=intval($resort->avgreviews());?>
							@for($i=0;$i<$ave;$i++)
							<i class="fa fa-star"></i> 
							@endfor
						</div>
						<span>{{$resort->totalreviews()}} reviews</span>
					</div>
				</div>
				<div class="col-xxl-9 col-xl-8 col-lg-8 col-md-9 col-sm-10 col-8">
					<div class="progress-wrapper">
						<div class="progress-item">
							<span>5</span>
							<div class="progress">
								<div class="progress-bar" role="progressbar" style="width: {{count($resort->fiveviews())}}%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
							</div>  
						</div>

						<div class="progress-item">
							<span>4</span>
							<div class="progress">
								<div class="progress-bar" role="progressbar" style="width: {{count($resort->fourviews())}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>

						<div class="progress-item">
							<span>3</span>
							<div class="progress">
								<div class="progress-bar" role="progressbar" style="width: {{count($resort->threeviews())}}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>

						<div class="progress-item">
							<span>2</span>
							<div class="progress">
								<div class="progress-bar" role="progressbar" style="width: {{count($resort->twoviews())}}%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>

						<div class="progress-item">
							<span>1</span>
							<div class="progress">
								<div class="progress-bar" role="progressbar" style="width: {{count($resort->oneview())}}%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
					</div>
				</div>
			</div>




			<form>
				<input class="form-control search-review-input" type="text" name="search" placeholder="Search Review">  
			</form>
			@foreach($resort->reviews as $review)
			<div class="review-wrapper">
				<div class="d-flex align-items-start">
					<div class="flex-shrink-0">
						<div class="img-wrapper">
							@if(!empty($review->user->profile))
							<img src="{{$review->user->profile}}">
							@else
							<img src="{{asset('alfardan/assets/user-info-3.jpg')}}" alt="...">
							@endif
						</div>
					</div>
					<div class="flex-grow-1 ms-3">
						<h3 class="float-start">{{@$review->user->full_name}} </h3>
						<div class="rating float-end">
							@for($i=0;$i<$review->stars;$i++)
							<i class="fa fa-star"></i> 
							@endfor
						</div>
						<p>
							{{$review->description}}   
						</p>

						<time class="post-date"><span class="fst-italic">Added on</span> {{$review->created_at}}</time>
						<a href="{{route('admin.deleteReview',$review->id)}}" class="text-uppercase delete-review-btn">Delete</a>

					</div>
				</div>
			</div>
			@endforeach
			<!-- <div class="review-wrapper">
				<div class="d-flex align-items-start">
					<div class="flex-shrink-0">
						<div class="img-wrapper">
							<img src="{{asset('alfardan/assets/user-info-3.jpg')}}" alt="...">
						</div>
					</div>
					<div class="flex-grow-1 ms-3">
						<h3 class="float-start">John K.</h3>
						<div class="rating float-end">
							<i class="fa fa-star"></i>  
							<i class="fa fa-star"></i>  
							<i class="fa fa-star"></i>  
							<i class="fa fa-star"></i>  
							<i class="fa fa-star"></i>  
						</div>
						<p>
							Event description…Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore  
						</p>

						<time class="post-date"><span class="fst-italic">Added on</span> 12/20/2021</time>
						<a href="#" class="text-uppercase delete-review-btn">Delete</a>

					</div>
				</div>
			</div>

			<div class="review-wrapper">
				<div class="d-flex align-items-start">
					<div class="flex-shrink-0">
						<div class="img-wrapper">
							<img src="{{asset('alfardan/assets/user-info-3.jpg')}}" alt="...">
						</div>
					</div>
					<div class="flex-grow-1 ms-3">
						<h3 class="float-start">John K.</h3>
						<div class="rating float-end">
							<i class="fa fa-star"></i>  
							<i class="fa fa-star"></i>  
							<i class="fa fa-star"></i>  
							<i class="fa fa-star"></i>  
							<i class="fa fa-star"></i>  
						</div>
						<p>
							Event description…Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore  
						</p>

						<time class="post-date"><span class="fst-italic">Added on</span> 12/20/2021</time>
						<a href="#" class="text-uppercase delete-review-btn">Delete</a>

					</div>
				</div>
			</div>

			<div class="review-wrapper">
				<div class="d-flex align-items-start">
					<div class="flex-shrink-0">
						<div class="img-wrapper">
							<img src="{{asset('alfardan/assets/user-info-3.jpg')}}" alt="...">
						</div>
					</div>
					<div class="flex-grow-1 ms-3">
						<h3 class="float-start">John K.</h3>
						<div class="rating float-end">
							<i class="fa fa-star"></i>  
							<i class="fa fa-star"></i>  
							<i class="fa fa-star"></i>  
							<i class="fa fa-star"></i>  
							<i class="fa fa-star"></i>  
						</div>
						<p>
							Event description…Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore  
						</p>

						<time class="post-date"><span class="fst-italic">Added on</span> 12/20/2021</time>
						<a href="#" class="text-uppercase delete-review-btn">Delete</a>

					</div>
				</div>
			</div>

			<div class="review-wrapper">
				<div class="d-flex align-items-start">
					<div class="flex-shrink-0">
						<div class="img-wrapper">
							<img src="{{asset('alfardan/assets/user-info-3.jpg')}}" alt="...">
						</div>
					</div>
					<div class="flex-grow-1 ms-3">
						<h3 class="float-start">John K.</h3>
						<div class="rating float-end">
							<i class="fa fa-star"></i>  
							<i class="fa fa-star"></i>  
							<i class="fa fa-star"></i>  
							<i class="fa fa-star"></i>  
							<i class="fa fa-star"></i>  
						</div>
						<p>
							Event description…Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore  
						</p>

						<time class="post-date"><span class="fst-italic">Added on</span> 12/20/2021</time>
						<a href="#" class="text-uppercase delete-review-btn">Delete</a>

					</div>
				</div>
			</div>

			<div class="review-wrapper">
				<div class="d-flex align-items-start">
					<div class="flex-shrink-0">
						<div class="img-wrapper">
							<img src="{{asset('alfardan/assets/user-info-3.jpg')}}" alt="...">
						</div>
					</div>
					<div class="flex-grow-1 ms-3">
						<h3 class="float-start">John K.</h3>
						<div class="rating float-end">
							<i class="fa fa-star"></i>  
							<i class="fa fa-star"></i>  
							<i class="fa fa-star"></i>  
							<i class="fa fa-star"></i>  
							<i class="fa fa-star"></i>  
						</div>
						<p>
							Event description…Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore  
						</p>

						<time class="post-date"><span class="fst-italic">Added on</span> 12/20/2021</time>
						<a href="#" class="text-uppercase delete-review-btn">Delete</a>

					</div>
				</div>
			</div> -->
		</div>

		<div class="col-xxl-4 col-xl-4 col-lg-4">
			<div class="site-info-wrapper">
				<div class="row">
					<div class="col-xxl-6">
						<h2 class="table-cap pb-2 mb-3 text-capitalize">Booking Link</h2>
						<a href="#">{{$resort->view_link}}</a>
					</div>
					<div class="col-xxl-6">
						<h2 class="table-cap pb-2 mb-3 text-capitalize">Phone Number</h2>
						<p>{{$resort->phone}}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

@endsection



@push('script')

	<!-- delete modal start -->
	<div class="modal remove-item" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
	  <div class="modal-dialog modal-dialog-centered">
		<div class="modal-content bg-transparent border-0">
		  <form method="POST" action="{{ route('admin.deleteApartment','apartment') }}">
		  {{method_field('delete')}}
		  {{csrf_field()}}
		  <div class="modal-body">
			<div class="remove-content-wrapper">
			  <p>Are you sure you want to delete?</p>
			  <input type="hidden" name="apartmentid" id="apartmentid" value="">

			  <div class="delete-btn-wrapper">
				<a href="#" type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close">cancel</a>
				<!-- <a href="#">delete</a> -->
				<button type="Submit" 
				style="color: #fff;
				font-size: 18px;
				max-width: 133px;
				height: 37px;
				padding: 7px 32px;
				border: 1px solid #C89328;
				text-transform: uppercase;
				background: #C89328;">
				delete</button>
			  </div>
			</div>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<script>

	  $('#remove-item').on('show.bs.modal', function (event) {

			var button = $(event.relatedTarget);

			if(button.hasClass("deleteitem")){

			   $("#remove-item form").attr('action',button.data('url'));

			}else{
			   $("#remove-item form").attr('action',"{{ route('admin.deleteApartment','apartment') }}");
			  var apartmentid = button.data('apartmentid') 
			  var modal = $(this)
			  modal.find('.modal-body #apartmentid').val(apartmentid);
			}
		});

	</script>

	<style>
	.detail-img-holder>a.deleteitem.cross-img {
		position: absolute;
		z-index: 99;
		right: 0;
		top: -13px;
		background: #000;
		border-radius: 100%;
		padding: 3px 6px;
	}	
	</style>
@endpush
