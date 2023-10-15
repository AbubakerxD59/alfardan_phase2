@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Featured')

@section('content')
 	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" type="text/css" media="screen" />
 
<style>
.fancybox-navigation .fancybox-button{
	top: calc(45vh - 45%);
}	
.fancybox-button--zoom,
.fancybox-infobar,
.fancybox-button--thumbs
, .fancybox-button--play{
display:none
}
</style>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position buy-sel-wrapper">
	@include('notification.notify')
	<h2 class="table-cap pb-1 mb-3">Featured</h2>
	<a class="add-btn my-3" href="#" type="button"  data-bs-toggle="modal" data-bs-target="#addnewfeatured">ADD NEW</a>
	@foreach($products as $product)
	<div  id="product_{{$product->id}}" class="buy-sel-holder gallery mb-3"  
		 @if($product->status==3)
		 	style=" opacity: 0.2; background: gray;"
		 @endif
		>
		<div class="row">
			<div class="col-12 col-sm-2" >
				<div class="profile-slider">
				@if($product->images()->count()>0)
					
				  @foreach($product->images as $key=>$image)
					  <div> 
						<figure class="property-profile ">
							<a href="{{$image->path}}">
								<img src="{{$image->path}}" alt="Image {{$key+1}}" class="cursor-pointer"/>
							</a>
						</figure>
					  </div>
					@endforeach  
				@else
					
					<div> 
						<figure class="property-profile">
							<a href="{{$product->cover}}">
								<img src="{{$product->cover}}" alt="Cover" class="cursor-pointer" style="height: auto;"/>
							</a>
						</figure>
					</div>
				@endif
				</div>
			</div>
			
			<div class="col-12 col-sm-10">
				<div class="row">
					<div class="col-12">
						<div class="product-detail-holder">
							<div class="float-start">
								<h2 class="cursor-pointer name-table-edit" 
									data-bs-toggle="modal" 
									id="{{$product->id}}" 
									data-bs-target="#addsellrequest">{{@$product->name}}</h2>
								<span>{{@$product->price}}QAR</span>
								<h2>
									@if ($product->status == '1')
										Published
									@else
										Drafted
									@endif
								</h2>
							</div>
							<div class="float-end">
								<p>{{@$product->seller->property}}</p>
								<p class="float-end">{{@$product->seller->AptNumber}}</p>
								{{-- <p style="text-align:right;">
								@if(@$product->status=="0")
								DENIED
								@elseif(@$product->status=="1")
								APPROVED
								@elseif(@$product->status=="2")
								PENDING
								@else
								SOLD
								@endif
								</p> --}}
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="product-date-holder ">
							<h2 class="float-start mt-auto">{{$product->created_at}}</h2>
							<a class="float-end table-edit" 
							   id="{{$product->id}}" 
							   data-bs-toggle="modal" 
							   data-bs-target="#editfeatured"  
							   style="cursor: pointer;" >Edit</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endforeach
	
	{{$products->links()}}
</main>
<!-- Add Facility model start -->
<div class="modal fade" id="addsellrequest"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">

		<div class="modal-content">            
			<div class="modal-body profile-model">
				<div class="container-fluid px-0">
					<div class="row">
						<div class="col-12">
							<div class="body-wrapper">
								<h2 class="table-cap pb-1 text-capitalize mb-3 ">Featured</h2>
								<button type="button" class="btn-close-modal pt-0 mt-1 me-0 float-end" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
								<form action="{{route('admin.updateSellRequest')}}" method="post">
									{{csrf_field()}}
									<input type="hidden" name="productid" id="productid" value="0">
									<div class="row">
									<div class="gallery-1">
										<div class="col-12">
											{{-- <div class="upload-detail-holder">
												<h2>Upload by</h2>
												<div class="profile-pic">
													<img id="profile" src="{{asset('alfardan/assets/class-view-1.3.jpg')}}">
												</div>
												<span id="user">John K.</span>
											</div> --}}
											<div class="product-detail-holder">
												<h2>Product Photo</h2>
												<div class="product-image-holder " >
													<img id="cover" src="{{asset('alfardan/assets/class-view-1.3.jpg')}}">

												</div>
												<span class="float-start" id="price">500 QAR</span><small class="float-end" id="date">Date Added</small>
											</div>

											<div class="phone-number-holder">
												<h2 class="title" >Phone Number</h2>
												<p id="phone">1245146134575</p>
											</div>

											<div class="category-holder ">
												<h2 class="title" > Category </h2>
												<p id="cat_name">Electronics</p>
											</div>

											<div class="product-description">
												<h2 class="title">Description</h2>
												<p id="description">
													Event description…Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, q
												</p>                          
											</div>

											{{-- <div class="location-holder">
												<h2 class="title">Location</h2>
												<div class="location-contaner">
													<iframe  src="https://maps.google.com/maps?q='+YOUR_LAT+','+YOUR_LON+'&hl=es&z=14&amp;output=embed" width="400" height="300" id="viewmap" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
												</div>
											</div> --}}

											<div class="btn-holder">
												<!-- @if(@$product->status==1)
												<button class="form-btn" type="button"  style="background-color: #C89328;">APPROVED</button>
												@else
												<button class="form-btn" type="submit" style="background-color: #C89328;">APPROVE</button>
												@endif
												<button class="form-btn" type="button" style="background-color: #A0A0A0;border: none;">DENY</button> -->
												{{-- <input class="form-btn publish" name="publish" type="submit" value="APPROVE" id="approved" > --}}
												{{-- <input type="submit" name="draft" value="DENY" class="draft" style="background-color: #A0A0A0;border: none;"> --}}
												<input type="submit" name="delete" value="DELETE" class="form-btn delete_btn">
												<!-- <a href="#">deny</a> -->
											</div>
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


	</div>
</div>
<!--Add Facility model end -->

<!--Add Featured model start -->
<div class="modal fade" id="addnewfeatured"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">

		<div class="modal-content">             
			<div class="modal-body profile-model">
				<div class="container-fluid px-0">
					<div class="row">
						<div class="col-12">
							<div class="body-wrapper">
								<h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">Add Featured</h2>
								<button type="button" class="btn-close-modal float-sm-end float-start mt-0 me-sm-0 me-4" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle" aria-hidden="true"></i></button>
								<form method="post" action="{{route('admin.addFeatured')}}" enctype="multipart/form-data">
                 					{{csrf_field()}}
									<div class="row">
										<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4  ">
											<div class="add-family-form-wrapper ps-2 pe-3">
												<label>Product Name</label>
												<input  type="text" name="name" required="required">
												<label>Phone Number</label>
												<input  type="number" name="phone">
												<label>Email Address</label>
												<input  type="email" name="email">
												<label>Starting Price</label>
												<input  type="number" name="price">
												<label>Item Description</label>
												<textarea class="description-text-small" name="description" required="required"></textarea>
											</div>
										</div>
										<div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 ps-4 label-size">
											<div class="profile-img-holder add-event-img-holder  mb-3">
												<figcaption>Add Image</figcaption>
												<div id="add-hotel-img-preview-modal1"  class="image-preview">
													<label class="text-uppercase" for="add-hotel-img-upload-modal1" id="add-hotel-img-label-modal1">add image</label>
													<div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
													<input type="file" class="hotel-image"  name="image1" id="add-hotel-img-upload-modal1" />
												</div>
											</div>
											<h2>Category</h2>
											<div class="profile-tenant-form">
												@foreach ($categories as $category)
												<div class="form-check form-check-inline profile-tenant-form">
													<input class="form-check-input tenantcheck" name="category_id" type="radio" id="{{"inlineCheckbox".$category->id}}" value="{{$category->id}}">
													<label class="form-check-label mt-1" for="{{"inlineCheckbox".$category->id}}">{{$category->name}}</label>
												</div>
												@endforeach
												<h2>Condition</h2>
												<div class="form-check form-check-inline profile-tenant-form">
													<input class="form-check-input tenantcheck" type="radio" id="inlineCheckboxCondition1" name="condition" value="New" checked>
													<label class="form-check-label mt-1" for="inlineCheckboxCondition1">New</label>
												</div>
												<div class="form-check form-check-inline profile-tenant-form">
													<input class="form-check-input tenantcheck" name="condition" type="radio" id="inlineCheckboxCondition2" value="Used">
													<label class="form-check-label mt-1" for="inlineCheckboxCondition2">Used</label>
												</div>

												<div class="form-check form-check-inline profile-tenant-form">
													<input class="form-check-input tenantcheck" name="condition" type="radio" id="inlineCheckboxCondition3" value="Great">
													<label class="form-check-label mt-1" for="inlineCheckboxCondition3">Great</label>
												</div>
												<div class="form-check form-check-inline profile-tenant-form">
													<input class="form-check-input tenantcheck" name="condition" type="radio" id="inlineCheckboxCondition4" value="Excellent">
													<label class="form-check-label mt-1" for="inlineCheckboxCondition4">Excellent</label>
												</div>
												<div class="form-check form-check-inline profile-tenant-form">
													<input class="form-check-input tenantcheck" name="condition" type="radio" id="inlineCheckboxCondition5" value="Old">
													<label class="form-check-label mt-1" for="inlineCheckboxCondition5">Old</label>
												</div>
											</div>
										</div>
									</div>
									<div class="form-btn-holder mb-3 text-end  me-xxl-0">
										<!-- <button class="form-btn btnsubmit">Publish</button>
										<button class="form-btn">Draft</button> -->
										<input class="form-btn publish" name="publish" type="submit" value="Publish" >
										<input type="submit" name="draft" value="Draft" class="draft">
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


	</div>
</div>
<!--Add Featured model end -->
<!--Edit Featured model start -->
<div class="modal fade" id="editfeatured"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">

		<div class="modal-content">             
			<div class="modal-body profile-model">
				<div class="container-fluid px-0">
					<div class="row">
						<div class="col-12">
							<div class="body-wrapper">
								<h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">Edit Featured</h2>
								<button type="button" class="btn-close-modal float-sm-end float-start mt-0 me-sm-0 me-4" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle" aria-hidden="true"></i></button>
								<form method="post" action="{{route('admin.addFeatured')}}" enctype="multipart/form-data" id="editform">
                 					{{csrf_field()}}
									<div class="row">
										<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4">
											<div class="add-family-form-wrapper ps-2 pe-3">
												<label>Product Name</label>
												<input  type="text" name="name" id="name">
												<label>Phone Number</label>
												<input  type="number" name="phone" id="edit_phone">
												<label>Email Address</label>
												<input  type="email" name="email" id="edit_email">
												<label>Starting Price</label>
												<input  type="number" name="price" id="edit_price">
												<label>Item Description</label>
												<textarea class="description-text-small" name="description" id="edit_description" required="required"></textarea>
											</div>
										</div>
										<div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 ps-4 label-size">
											<div class="profile-img-holder add-event-img-holder  mb-3">
												<figcaption>Add Image</figcaption>
												<div id="edit-hotel-img-preview-modal1"  class="image-preview">
													<label class="text-uppercase" for="edit-hotel-img-upload-modal1" id="edit-hotel-img-label-modal1">CHANGE IMAGE</label>
													<div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
												   <input type="file" name="image1" id="edit-hotel-img-upload-modal1" />
												   <input type="hidden" class="edit-hotel-image" name="image_1" id="image1">

												</div>
											</div>
											<h2>Category</h2>
											<div class="profile-tenant-form">
												@foreach ($categories as $category)
												<div class="form-check form-check-inline profile-tenant-form">
													<input class="form-check-input tenantcheck" name="category_id" type="radio" id="{{"edit_inlineCheckbox".$category->id}}" value="{{$category->id}}">
													<label class="form-check-label mt-1" for="{{"edit_inlineCheckbox".$category->id}}">{{$category->name}}</label>
												</div>
												@endforeach
												<h2>Condition</h2>
												<div class="form-check form-check-inline profile-tenant-form">
													<input class="form-check-input tenantcheck" type="radio" id="edit_inlineCheckboxCondition1" name="condition" value="New">
													<label class="form-check-label mt-1" for="edit_inlineCheckboxCondition1">New</label>
												</div>
												<div class="form-check form-check-inline profile-tenant-form">
													<input class="form-check-input tenantcheck" name="condition" type="radio" id="edit_inlineCheckboxCondition2" value="Used">
													<label class="form-check-label mt-1" for="edit_inlineCheckboxCondition2">Used</label>
												</div>

												<div class="form-check form-check-inline profile-tenant-form">
													<input class="form-check-input tenantcheck" name="condition" type="radio" id="edit_inlineCheckboxCondition3" value="Great">
													<label class="form-check-label mt-1" for="edit_inlineCheckboxCondition3">Great</label>
												</div>
												<div class="form-check form-check-inline profile-tenant-form">
													<input class="form-check-input tenantcheck" name="condition" type="radio" id="edit_inlineCheckboxCondition4" value="Excellent">
													<label class="form-check-label mt-1" for="edit_inlineCheckboxCondition4">Excellent</label>
												</div>
												<div class="form-check form-check-inline profile-tenant-form">
													<input class="form-check-input tenantcheck" name="condition" type="radio" id="edit_inlineCheckboxCondition5" value="Old">
													<label class="form-check-label mt-1" for="edit_inlineCheckboxCondition5">Old</label>
												</div>
											</div>
										</div>
									</div>
									<div class="form-btn-holder mb-3 text-end  me-xxl-0">
										<!-- <button class="form-btn btnsubmit">Publish</button>
										<button class="form-btn">Draft</button> -->
										<input type="hidden" name="featured_id" id="featured_id" value="0">
										<input class="form-btn publish" name="publish" type="submit" value="Publish" >
										<input type="submit" name="draft" value="Draft" class="draft">
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


	</div>
</div>
<!--Edit Featured model end -->

<!-- delete modal start -->
<div class="modal remove-item" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-transparent border-0">
      <form method="POST" action="{{ route('admin.deleteSellRequest','sell') }}">
      {{method_field('delete')}}
      {{csrf_field()}}
      <div class="modal-body">
        <div class="remove-content-wrapper">
          <p>Are you sure you want to delete?</p>
          <input type="hidden" name="proid" id="proid" value="">

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    // document.ready function
	
		    // document.ready function
		$(document).ready(function() {
			
		// add facilities
		$.uploadPreview({
			input_field: "#add-hotel-img-upload-modal1",
			preview_box: "#add-hotel-img-preview-modal1",
			label_field: "#add-hotel-img-label-modal1"
		});

		$.uploadPreview({
			input_field: "#edit-hotel-img-upload-modal1",
			preview_box: "#edit-hotel-img-preview-modal1",
			label_field: "#edit-hotel-img-label-modal1"
    	});
			
			
		  // add all to same gallery
		  $(".gallery .property-profile a").attr("data-fancybox","mygallery");
		  // assign captions and title from alt-attributes of images:
		  $(".gallery").each(function(){
			  $(this).find(".property-profile>a").each(function(){
				$(this).attr("data-caption", $(this).find("img").attr("alt"));
				$(this).attr("title", $(this).find("img").attr("alt"));
			  });
			  
			  $(this).find(".property-profile>a").fancybox();
			  
		  });
		  // start fancybox:
			
		});

	$(function() {    
        $('.name-table-edit').click(function(e) {
            e.preventDefault(); // prevent form from reloading page
          $('#editform').trigger("reset");
            var id=$(this).attr('id');
           
            $.ajax({
                url  : "{{route('admin.getSellRequest')}}",
                type : 'Post',
                data :{'id':id,_token:'{{ csrf_token() }}'},
                dataType: 'json',
                beforeSend: function(){
				    // Show image container
				    $("#loader").show();
				},     
                success : function(response) {
                        // console.log(response);
        			$('#productid').val(response.id); 
        			if(response.cover!=null){

        			$('#cover').attr('src',response.cover);
        			}
        			// if(response.seller.profile!=null){

        			// 	$('#profile').attr('src',response.seller.profile);
        			// }
        			$('#price').text(response.price+' '+ 'QAR');
        			$('#date').text(response.created_at);
        			$('#phone').text(response.phone);
        			$('#description').text(response.description);
        			// $('#viewmap').attr("src", "https://maps.google.com/maps?q="+response.seller.userpropertyrelation.property.latitude+","+response.seller.userpropertyrelation.property.longitude+"&hl=es&z=24&amp;output=embed");
        			if(response.category.name!=null){

        			$('#cat_name').text(response.category.name);
        			}
        			// if(response.seller.first_name!=null){
					// 	$('#user').text(response.seller.first_name +' '+response.seller.last_name);
					// }else if(response.seller.full_name!=null){
					// 	$('#user').text(response.seller.full_name);
					// }else{
					// 	$('#user').text('');
					// }

        			if(response.status==1){
        				$('#approved').val('APPROVED');
        				$( "#approved" ).prop( "disabled", true );
        			}
        			else{
        				$('#approved').val('APPROVE');
        				$( "#approved" ).prop( "disabled", false );
        			}
        			
                },
                complete:function(data){
				    // Hide image container
				    $("#loader").hide();
				}
            });
        });
    });

    $(function() {
        
        $('.table-edit').click(function(e) {
            e.preventDefault(); // prevent form from reloading page
          $('#editform').trigger("reset");
		  $("#edit-hotel-img-preview-modal1").css("background-image", "unset");
            var id=$(this).attr('id');
			console.log(id);
           
            $.ajax({
                url  : "{{route('admin.getFeatured')}}",
                type : 'Post',
                data :{'id':id,_token:'{{ csrf_token() }}'},
                dataType: 'json',
                beforeSend: function(){
				    // Show image container
				    $("#loader").show();
				},     
                success : function(response) {
                    console.log(response.category_id);
					console.log("inlineCheckbox"+response.category_id);
        			$('#featured_id').val(response.id);
        			$('#name').val(response.name);
        			$('#edit_phone').val(response.phone);
        			$('#edit_email').val(response.email);
        			$('#edit_price').val(response.price);
        			$('#edit_description').text(response.description);
					$("#edit_inlineCheckbox"+response.category_id).prop("checked", true);
					var i = 1;
					while(i<=5){
						if( $("#edit_inlineCheckboxCondition"+i).val() == response.condition ){
							console.log(response.condition);
							$("#edit_inlineCheckboxCondition"+i).prop('checked', true);
						}
						i++;
					}
					if(response.cover){
						$("#edit-hotel-img-preview-modal1").css("background-image", "url(" + response.cover + ")");
						$("#image1").val(response.cover);
						$("#edit-hotel-img-upload-modal1").prev().removeClass('d-none');
						$("#edit-hotel-img-upload-modal1").prev().addClass('d-flex justify-content-end');
					}
                },
                complete:function(data){
				    // Hide image container
				    $("#loader").hide();
				}
            });
        });
    });
    // delete popup modal
    $('#remove-item').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget) 

        var proid = button.data('proid') 
        var modal = $(this)

        modal.find('.modal-body #proid').val(proid);
    });
</script>

@endpush