@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Corporate Individual View')

@section('content')

<main class="user-info-wrapper col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position px-xl-5">
@include('notification.notify')
	<h2 class="table-cap pb-1 mb-3 text-capitalize">{{$userinfo['full_name']}} <span class="user-info-id">AF{{$userinfo['id']}}</span></h2>

	<!-- First row -->
	<div class="row mb-4">
		<div class="col-xxl-3 col-xl-3">
			<figure class="user-profile-pic">
				@if(!empty($userinfo->profile))

                <img src="{{$userinfo->profile}}" alt="User Info Profile Pic">

                @else
                <img src="{{asset('placeholder.png')}}" alt="User Info Profile Pic" >
                @endif
			</figure>
		</div>
		<div class="col-xxl-9 col-xl-9 mt-auto pt-2 ps-0">
			<div class=" table-responsive tenant-table ">
				<caption>
					<h2 class="table-cap pb-0  text-capitalize float-start clear-both">user info</h2>
					@if(!empty($userinfo->contract))
					<a href="" type="submit" onclick="window.open('{{asset('uploads/').'/'.$userinfo->contract}}')" class="contract-btn float-end mb-2">View Contract</a>
					@endif
				</caption>
				<table class="table  table-bordered">
					<thead>
						<tr>
							<th><span>User Name</span></th>
							<th><span>Email</span></th>
							<!-- <th><span>Password</span></th> -->
							<th><span>Start Date</span></th>
							<th><span>Phone Number</span></th> 
							<th><span>Leasing Type</span></th>
							<th><Span>Tenant Type</Span></th>
							<th><span>Property</span></th>
							<th><span>Apartment</span></th>
							<th><span>No. Of Members</span></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><a href="#">{{@$userinfo->full_name}} </a></td>
							<td>{{@$userinfo->email}}</td>
							<!-- <td>******</td> -->
							<td>{{@$userinfo->start_date}}</td>
							<td>{{@$userinfo->mobile}}</td>                     
							<td>{{@$userinfo->type}}</td>
							<td>{{@$userinfo->tenant_type}}</td>
							<td>{{@$userinfo->property}}</td>
							<td>{{@$userinfo->apt_number}}</td>
							<td>{{@$userinfo->familycount()}}</td>
						</tr>       
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- scnd row -->
	<div class="row mb-4">
		<div class="col-xxl-6 col-xl-6">
			<div class=" table-responsive tenant-table unique-table">
				<caption>
					<h2 class="table-cap pb-0 mb-3 text-capitalize float-start clear-both">Family members</h2>
				</caption>
				<table class="table  table-bordered">
					<thead>
						<tr>
							<th scope="col"><span>Name</span></th>
							<th scope="col"><span>Email</span></th>
							<th scope="col"><span>Phone Number</span></th> 
							<th colspan="2"></th>
						</tr>
					</thead>
					<tbody>
						@foreach($userinfo->families as $family)
						<tr>
							<td>{{@$family->name}}</td>
		                    <td>{{@$family->email}}</td>
		                    <td>{{@$family->phone_number}}</td>
							<td class="table-edit fw-bold family-edit" id="{{$family->id}}" data-bs-toggle="modal" data-bs-target="#editfamilymember">Edit</td>
            				<td class="cursor-pointer table-edit fw-bold" data-fmid="{{$family->id}}" data-bs-toggle="modal" data-bs-target="#remove-item">Remove</td> 
						</tr> 
						@endforeach     
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-xxl-6 col-xl-6">
			<div class=" table-responsive tenant-table">
				<caption>
					<h2 class="table-cap pb-0 mb-3 text-capitalize float-start clear-both">Lifestyle activities</h2>
				</caption>
				<table class="table  table-bordered">
					<thead>
						<tr>
							<th scope="col"><span>Lifestyle Type</span></th>
							<th scope="col"><span>Date Booked</span></th>
							<th scope="col"><span>No. of Reservation</span></th>
							<th scope="col"><span>Reservation Time</span></th>
							<th scope="col"><span>Rating</span></th> 
						</tr>
					</thead>
					<tbody>
						@foreach($lifestyles as $lifestyle)
	                    <tr>
	                      <td>{{$lifestyle->type}}</td>
	                      <td>{{$lifestyle->date}}</td>
	                      <td>{{$lifestyle->reservations}}</td>
	                      <td>{{$lifestyle->time}}</td>
	                      <td></td>                     
	                    </tr> 
	                    @endforeach      
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- thrd row -->
	<div class="row mb-4">
		<!-- <div class="col-xxl-6 col-xl-6">
			<div class=" table-responsive tenant-table">
				<caption>
					<h2 class="table-cap pb-0 mb-3 text-capitalize float-start clear-both">Hospitality Activities</h2>
				</caption>
				<table class="table  table-bordered">
					<thead>
						<tr>
							<th scope="col"><span>Hospitality Type</span></th>
							<th scope="col"><span>Date Booked</span></th>
							<th scope="col"><span>No. of Reservation</span></th>
							<th scope="col"><span>Reservation Time</span></th>
							<th scope="col"><span>Rating</span></th> 
						</tr>
					</thead>
					<tbody>
						@foreach($hospitalities as $hospitality)
						<tr>
							<td>{{$hospitality->type}}</td>
							<td>{{$hospitality->date}}</td>
							<td>{{$hospitality->reservations}}</td>
							<td>{{$hospitality->time}}</td>
							<td></td>                     
						</tr> 
						@endforeach    
					</tbody>
				</table>
			</div>
		</div> -->
		<div class="col-xxl-6 col-xl-6">
			<div class=" table-responsive tenant-table">
				<caption>
					<h2 class="table-cap pb-0 mb-3 text-capitalize float-start clear-both">Maintenance Requests</h2>
				</caption>
				<table class="table  table-bordered">
					<thead>
						<tr>
							<th scope="col"><span>Maintenance Type</span></th>
			             	<th scope="col"><span>Ticket ID</span></th>
			                <th scope="col"><span>Date Created</span></th>
			                <th scope="col"><span>Status</span></th>
			                <th scope="col"><span>Rating</span></th>
						</tr>
					</thead>
					<tbody>
						@foreach($userinfo->maintenances as $maintenance)
						<tr>
							<td>{{@$maintenance->type}}</td>
				            <td>{{@$maintenance->ticket_id}}</td>
				            <td>{{@$maintenance->created_at}}</td>
				            <td>{{@$maintenance->status}}</td>
				            <td>{{@$maintenance->totalreviews()}}</td>                    
						</tr> 
						@endforeach      
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-xxl-6 col-xl-6">
			<div class=" table-responsive tenant-table">
				<caption>
					<h2 class="table-cap pb-0 mb-3 text-capitalize float-start clear-both">Concierge Requests</h2>
				</caption>
				<table class="table  table-bordered">
					<thead>
						<tr>
							<th scope="col"><span>Request</span></th>
							<th scope="col"><span>Type</span></th>
							<th scope="col"><span>Date</span></th>
							<th scope="col"><span>Status</span></th>
						</tr>
					</thead>
					<tbody>
						@foreach($concierges as $concierge)
                    
	                    <tr>
	                      <td>{{$concierge->name}}</td>
	                      <td>{{$concierge->type}}</td>
	                      <td>{{$concierge->date}}</td>
	                      <td>{{$concierge->status}}</td>
	                    </tr> 
	                    @endforeach        
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- frth row -->
	<div class="row mb-4">
		
		<div class="col-xxl-6 col-xl-6">
			<div class=" table-responsive tenant-table">
				<caption>
					<h2 class="table-cap pb-0 mb-3 text-capitalize float-start clear-both">Sell Requests</h2>
				</caption>
				<table class="table  table-bordered">
					<thead>
						<tr>
							<th scope="col"><span>Product Name</span></th>
							<th scope="col"><span>Category</span></th>
							<th scope="col"><span>Phone Number</span></th>
							<th scope="col"><span>Status</span></th>
						</tr>
					</thead>
					<tbody>
					@foreach($userinfo->products as $product)
		            <tr>
		              <td>{{@$product->name}}</td>
		              <td>{{@$product->category->name}}</td>
		              <td>{{@$product->phone}}</td>
		              <td>{{@$product->status}}</td>
		            </tr>  
		            @endforeach      
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- fifth row -->
	<section>
		<h2 class="review-heading">Review History</h2>
		@foreach($userinfo->reviews as $review)
		<article class="article-wrapper">
          <span class="event-title">{{$review->entity_type}}</span>
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
<!--edit family member model start -->

<div class="modal fade" id="editfamilymember"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog ">

    <div class="modal-content border-0 bg-transparent">
      <div class="modal-body service-select">
        <div class="container-fluid px-0">
          <div class="scnd-type-modal-form-wrapper">
            <form method="post" action="{{route('admin.addFamilyRequest')}}" enctype="multipart/form-data">
              {{csrf_field()}}
              <input type="hidden" name="familymemberid" id="familymemberid">

              <button type="button" class="btn-close-modal float-end mt-0 me-0" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
              <h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">Edit Family Member Request</h2>

              <div class="row">
                <div class="col-sm-6 col-12">
                  <div class="input-field-group">
                    <label for="username">User Name</label>
                    <input type="text" name="username" id="fname" required="required">
                  </div>
                  <div class="input-field-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="femail"  required="required">
                  </div>
                  

                </div>
                <div class="col-sm-6 col-12">
                  <div class="input-field-group">
                    <label for="phonenumber">Phone Number</label>
                    <input type="text" name="phone" id="phone" required="required">
                  </div>
                </div>
              </div>

              <div class="row py-3">
                <div class="col-12">
                  <div class="btn-holder">
                    <button type="submit">Publish</button>
                    <button type="button">Draft</button>
                  </div>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>


  </div>
</div>
<!-- delete modal start -->
<div class="modal remove-item" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-transparent border-0">
      <form method="POST" action="{{ route('admin.deleteTenantFamily','user') }}">
      {{method_field('delete')}}
      {{csrf_field()}}
      <div class="modal-body">
        <div class="remove-content-wrapper">
          <p>Are you sure you want to delete?</p>
          <input type="hidden" name="fmid" id="fmid" value="">

          <div class="delete-btn-wrapper">
            <a href="#" type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close">cancel</a>
            <!-- <a href="#">delete</a> -->
            <button type="Submit" 
            style="color: #fff;
            font-size: 18px;
            max-width: 133px;
            height: 37px;
            padding: 5px 32px;
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
<!-- delete modal end -->
@endsection
@push('script')
<script>
  $(function() {

    $('.family-edit').click(function(e) {
        e.preventDefault(); // prevent form from reloading page

        var id=$(this).attr('id');

        $.ajax({
            url  : "{{route('admin.getTenantFamily')}}",
            type : 'Post',
            data :{'id':id,_token:'{{ csrf_token() }}'},
            dataType: 'json',    
            success : function(response) {
              $('#familymemberid').val(response.id);        
              $('#fname').val(response.name);
              $('#femail').val(response.email);
              $('#phone').val(response.phone_number);
              
            }
          });
      });
  });
  // delete popup modal
  $('#remove-item').on('show.bs.modal', function (event) {

      var button = $(event.relatedTarget) 

      var fmid = button.data('fmid') 
      var modal = $(this)

      modal.find('.modal-body #fmid').val(fmid);
  })
</script>
@endpush