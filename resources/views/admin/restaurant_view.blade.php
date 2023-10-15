@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Restaurant View')

@section('content')

<main class="event-wrapper col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position">
	@include('notification.notify')
	<caption>
		<h2 class="table-cap pb-2 mb-3 text-capitalize">{{$restaurant->name}}</h2>
		<a href="#" class="ps-2 ps-sm-4 text-capitalize fst-italic">
			@if($restaurant->status==1)
				Publish
			@else
				Draft
			@endif
		</a>
		<a href="{{route('admin.deleteRestaurantView',$restaurant->id)}}" class="event-delete-btn float-end">Delete</a>
	</caption>
	<!-- First row -->
	<div class="row mb-4">
		@foreach($restaurant->images as $image)
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
					<div class="detail-img-holder">
						<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remove-item" data-id="{{$image->id}}" data-url="{{route('admin.deleteimage',[$image->id])}}" class="deleteitem cross-img" tabindex="0">X</a>
						<img src="{{$image->path}}" alt="Event Pic" class="event-pics">
					</div>
				</div>
		@endforeach
	</div>
	<!-- scnd row -->
	<div class="d-flex">
		<div class="col-9">
			@if($restaurant->news_feed==1)
			<a href="{{route('admin.unsetRestaurantNewsfeed',$restaurant->id)}}" class="add-to-feed-btn float-end" ><i class="fa fa-check"></i> Added to Newsfeed</a>
			@else
			<a href="{{route('admin.setRestaurantNewsfeed',$restaurant->id)}}" class="add-to-feed-btn float-end" ><i class="fa fa-plus"></i> Add to Newsfeed</a>
			@endif
		</div>
		<div class="col-3">
			<div class="col-12">
				@if($restaurant->is_privilege==1)
				<a href="{{route('admin.unsetRestaurantPrivilege',$restaurant->id)}}" class="add-to-privilege-btn float-end" ><i class="fa fa-check"></i> Added to Privilege</a>
				@else
				<a href="{{route('admin.setRestaurantPrivilege',$restaurant->id)}}" class="add-to-privilege-btn float-end" ><i class="fa fa-plus"></i> Add to Privilege</a>
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
					{{$restaurant->description}}
				</p>
			</article>
		</div>
		<div class="col-xxl-4 col-xl-4 col-lg-4 col-12">
			<div class="location-wrapper">
				<h3 class="text-uppercase">location</h3>
				<div class="location-map">
					<iframe  src="https://www.google.com/maps/embed/v1/place?key={{env('google_map_key')}}&q={{$restaurant->latitude}},{{$restaurant->longitude}}" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
			</div>
		</div>
		<div class="col-xxl-4 col-xl-4 col-lg-4 col-12">
			<div class="profile-tenant-form events-radio-wrapper">
				<h2>Property</h2>
				<div class="property-input-wrapper">
					@if(!empty($restaurant->property))
					
					@foreach($restaurant->getpropertyname() as $value)
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
				@if(!empty($restaurant->tenant_type))
				<?php 
				$type=explode(',',$restaurant->tenant_type);
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
		<div class="col-xxl-4 col-xl-4 col-lg-4">
			<!-- <div class=" table-responsive   simple-table">
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
						<tr>
							<td>User 1</td>
							<td>2</td>
							<td>1:00</td>
							<td>2/20/2021</td>
						</tr> 
						<tr>
							<td>User 2</td>
							<td>3</td>
							<td>1:00</td>
							<td>2/20/2021</td>
						</tr> 

						<tr>
							<td>User 3</td>
							<td>4</td>
							<td>Cancelled</td>
							<td>2/20/2021</td>
						</tr>   

						<tr>
							<td>User 4</td>
							<td>5</td>
							<td>1:00</td>
							<td>2/20/2021</td>
						</tr>        
					</tbody>
				</table>
			</div> -->

			<div class="row">          
				<caption>
					<h2 class="table-cap pb-2 mb-3 text-capitalize">Menu Images</h2>
				</caption>

				<div class="col-6 col-lg-6 col-sm-4 ps-md-0">
					<div class="img-wrapper menu-item">
						@if(!empty($restaurant->menu1)) 
							<a href="javascript:void(0)" 
						   data-bs-toggle="modal" 
						   data-bs-target="#remove-item" 
						   data-id="{{$restaurant->id}}" 
						   data-url="{{route('admin.deletemenu',[$restaurant->id,'menu1'])}}" 
						   class="deleteitem cross-img">X</a>
							<a target="_blank" href="{{$restaurant->menu1}}">
								@php $ext = pathinfo($restaurant->menu1, PATHINFO_EXTENSION); @endphp
								@if($ext=='pdf')
									<img src="https://cdn-icons-png.flaticon.com/512/80/80942.png" alt="menu">
								@else
									<img src="{{$restaurant->menu1}}" alt="menu">
								@endif
							</a>
						
						@else
							<!-- <img src="{{asset('alfardan/assets/menu-img-1.jpg')}}" alt="menu"> -->
						@endif
					</div> 
					<div class="text-white">{{str_replace("uploads/",'',strstr($restaurant->menu1, 'uploads'))}}</div>
				</div>
				<div class="col-6 col-lg-6 col-sm-4 pe-md-0">
					<div class="img-wrapper menu-item">
						@if(!empty($restaurant->menu2))
						<a href="javascript:void(0)" 
						   data-bs-toggle="modal" 
						   data-bs-target="#remove-item" 
						   data-id="{{$restaurant->id}}" 
						   data-url="{{route('admin.deletemenu',[$restaurant->id,'menu2'])}}" 
						   class="deleteitem cross-img">X</a>
						
							<a target="_blank" href="{{$restaurant->menu2}}">
								@php $ext = pathinfo($restaurant->menu2, PATHINFO_EXTENSION); @endphp
								@if($ext=='pdf')
									<img src="https://cdn-icons-png.flaticon.com/512/80/80942.png" alt="menu">
								@else
									<img src="{{$restaurant->menu2}}" alt="menu">
								@endif
							</a>
						@else
							<!-- <img src="{{asset('alfardan/assets/menu-img-2.jpg')}}" alt="menu"/> -->
						@endif
					</div>
					<div class="text-white">{{str_replace("uploads/",'',strstr($restaurant->menu2, 'uploads'))}}</div>
				</div>
			</div>
			<div class="row row mt-5">          
				<div class="col-6 col-lg-6 col-sm-4 ps-md-0">
					<div class="img-wrapper menu-item">
						@if(!empty($restaurant->menu3))
						<a href="javascript:void(0)" 
						   data-bs-toggle="modal" 
						   data-bs-target="#remove-item" 
						   data-id="{{$restaurant->id}}" 
						   data-url="{{route('admin.deletemenu',[$restaurant->id,'menu3'])}}" 
						   class="deleteitem cross-img">X</a>
						
							<a target="_blank" href="{{$restaurant->menu3}}">
								@php $ext = pathinfo($restaurant->menu3, PATHINFO_EXTENSION); @endphp
								@if($ext=='pdf')
									<img src="https://cdn-icons-png.flaticon.com/512/80/80942.png" alt="menu"/>
								@else
									<img src="{{$restaurant->menu3}}" alt="menu"/>
								@endif
							</a>
						@else
							<!-- <img src="{{asset('alfardan/assets/menu-img-1.jpg')}}" alt="menu"> -->
						@endif
					</div>
					<div class="text-white">{{str_replace("uploads/",'',strstr($restaurant->menu3, 'uploads'))}}</div>
				</div>
				<div class="col-6 col-lg-6 col-sm-4 pe-md-0">
					<div class="img-wrapper menu-item">
						@if(!empty($restaurant->menu4))
					 <a href="javascript:void(0)" 
						   data-bs-toggle="modal" 
						   data-bs-target="#remove-item" 
						   data-id="{{$restaurant->id}}" 
						   data-url="{{route('admin.deletemenu',[$restaurant->id,'menu4'])}}" 
						   class="deleteitem cross-img">X</a>
						
							<a target="_blank" href="{{$restaurant->menu4}}">
								@php $ext = pathinfo($restaurant->menu4, PATHINFO_EXTENSION); @endphp
								@if($ext=='pdf')
									<img src="https://cdn-icons-png.flaticon.com/512/80/80942.png" alt="menu">
								@else
									<img src="{{$restaurant->menu4}}" alt="menu">
								@endif
							</a>
						@else
							<!-- <img src="{{asset('alfardan/assets/menu-img-2.jpg')}}" alt="menu"> -->
						@endif						
					</div>
					<div class="text-white">{{str_replace("uploads/",'',strstr($restaurant->menu4, 'uploads'))}}</div>
				</div>
			</div>
			<div class="row row mt-5">          
				<div class="col-6 col-lg-6 col-sm-4 ps-md-0">
					<div class="img-wrapper menu-item">
						
						@if(!empty($restaurant->menu5))
						<a href="javascript:void(0)" 
						   data-bs-toggle="modal" 
						   data-bs-target="#remove-item" 
						   data-id="{{$restaurant->id}}" 
						   data-url="{{route('admin.deletemenu',[$restaurant->id,'menu5'])}}" 
						   class="deleteitem cross-img">X</a>
						
							<a target="_blank" href="{{$restaurant->menu5}}">
								@php $ext = pathinfo($restaurant->menu5, PATHINFO_EXTENSION); @endphp
								@if($ext=='pdf')
									<img src="https://cdn-icons-png.flaticon.com/512/80/80942.png" alt="menu">
								@else
									<img src="{{$restaurant->menu5}}" alt="menu">
								@endif
							</a> 
						 @else
							<!-- <img src="{{asset('alfardan/assets/menu-img-2.jpg')}}" alt="menu"> -->
						@endif
					</div>
				</div>
				<div class="text-white">{{str_replace("uploads/",'',strstr($restaurant->menu5, 'uploads'))}}</div>
				<div class="col-6 col-lg-6 col-sm-4 pe-md-0">
					<div class="img-wrapper"> 
					<!--	<img src="{{$restaurant->menu4}}" alt="menu"> -->
					</div>

				</div>
			</div>

		</div>
		<div class="col-xxl-4 col-xl-4 col-lg-4">
			<h2 class="table-cap pb-2 mb-3 text-capitalize">Reviews</h2>

			<div class="row">
				<div class="col-xxl-3 col-xl-4 col-lg-4 col-md-3 col-sm-2 col-4 pe-0">
					<div class="rating-counter-wrapper">
						<h3>{{intval($restaurant->avgreviews())}}.0</h3>
						<div class="rating-counter">
							<?php $ave=intval($restaurant->avgreviews());?>
							@for($i=0;$i<$ave;$i++)
							<i class="fa fa-star"></i> 
							@endfor
						</div>
						<span>{{$restaurant->totalreviews()}} reviews</span>
					</div>
				</div>
				<div class="col-xxl-9 col-xl-8 col-lg-8 col-md-9 col-sm-10 col-8">
					<div class="progress-wrapper">
						<div class="progress-item">
							<span>5</span>
							<div class="progress">
								<div class="progress-bar" role="progressbar" style="width: {{count($restaurant->fiveviews())}}%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
							</div>  
						</div>

						<div class="progress-item">
							<span>4</span>
							<div class="progress">
								<div class="progress-bar" role="progressbar" style="width: {{count($restaurant->fourviews())}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>

						<div class="progress-item">
							<span>3</span>
							<div class="progress">
								<div class="progress-bar" role="progressbar" style="width: {{count($restaurant->threeviews())}}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>

						<div class="progress-item">
							<span>2</span>
							<div class="progress">
								<div class="progress-bar" role="progressbar" style="width: {{count($restaurant->twoviews())}}%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>

						<div class="progress-item">
							<span>1</span>
							<div class="progress">
								<div class="progress-bar" role="progressbar" style="width: {{count($restaurant->oneview())}}%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
					</div>
				</div>
			</div>




			<form>
				<input class="form-control search-review-input" type="text" name="search" placeholder="Search Review">  
			</form>
			@foreach($restaurant->reviews as $review)
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
						<a href="#">{{$restaurant->view_link}}</a>
					</div>
					<div class="col-xxl-6">
						<h2 class="table-cap pb-2 mb-3 text-capitalize">Phone Number</h2>
						<p>{{$restaurant->phone}}</p>
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
	.menu-item>a.deleteitem.cross-img,
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
