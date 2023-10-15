@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Offers & Updates')

@section('content')

<main class="user-info-wrapper col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position">

	<h2 class="table-cap pb-2 mb-3 text-capitalize">Offer Name</h2>

	<!-- First row -->
	<div class="row">
		<div class="col-xxl-3 col-xl-3">
			<figure class="user-profile-pic">
				@if(!empty($offer->photo))
				
				<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remove-item" data-id="{{$offer->id}}" data-url="{{route('admin.deleteofferphoto',[$offer->id])}}" class="deleteitem cross-img" tabindex="0">X</a>
				
				<img src="{{$offer->photo}}" alt="User Info Profile Pic">

				@else
				<img src="{{asset('alfardan/assets/placeholder.png')}}" alt="User Info Profile Pic">
				@endif
			</figure>
		</div>
		<div class="col-xxl-9 col-xl-9">
			<div class="table-responsive tenant-table offer-main-table">

				<table class="table  table-bordered ">
					<thead>
						<tr>
							<th scope="col"><span>Offer Title</span></th>
							<th scope="col"><span>Offer Type</span></th>
							<th scope="col"><span>Property</span></th>
							<th scope="col"><span>Link to</span></th>
							<th scope="col"><span>Submission Date</span></th>
							<th scope="col"><span>Tenant Type</span></th>
							<th scope="col"><Span>Status</Span></th>

						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{$offer->title}}</td>
							<td>{{$offer->type}}</td>
							<td>{{@$offer->property->name}}</td>
							<td>{{$offer->link}}</td>                     
							<td>{{$offer->submission}}</td>
							<td>{{$offer->tenant_type}}</td>
							<td>@if($offer->status==1)
								Publish
							
							@else
								Draft
							
							@endif</td>

						</tr>       
					</tbody>
				</table>
			</div>


			<!-- small table start -->
			<!-- <div class="table-responsive tenant-table small-status-table offer-table">

				<table class="table  table-bordered">
					<thead>
						<tr>
							<th class="px-2 px-4"><span>Status</span></th>

						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Rejected</td>


						</tr>       
					</tbody>
				</table>
			</div> -->
			<!-- small table end -->
		</div>
	</div>
</main>
 
<div class="modal remove-item" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
 	<div class="modal-dialog modal-dialog-centered">
 		<div class="modal-content bg-transparent border-0">
 			<form method="POST" action="{{ route('admin.deleteArt','art') }}">
 				{{method_field('delete')}}
 				{{csrf_field()}}
 				<div class="modal-body">
 					<div class="remove-content-wrapper">
 						<p>Are you sure you want to delete?</p>
 						<input type="hidden" name="artid" id="artid" value="">

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
@endsection
@push('script')
<script>
 
    $(function() {
    	 
    // delete popup modal
	$('#remove-item').on('show.bs.modal', function (event) {

	    var button = $(event.relatedTarget) 
		var modal = $(this);
		if(button.hasClass("deleteitem")){
			modal.find('form').attr("action",button.data("url"));
		   }else{
			var addartid = button.data('addartid') 
			modal.find('.modal-body #artid').val(addartid);
		  }
	});
	});
</script>
<style>
 
	.user-profile-pic>a.deleteitem.cross-img {
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