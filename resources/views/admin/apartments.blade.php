@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Apartments')

@section('content')

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position">
@include('notification.notify')
@if($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">
      {{$error}}
    </div>
  	@endforeach
 @endif
	<h2 class="table-cap pb-1">Apartments</h2>
	<a class="add-btn my-3" href="#" type="button"  data-bs-toggle="modal" data-bs-target="#add-apartment">ADD NEW Apartments</a>
	<div class=" table-responsive tenant-table">
		<table class="table  table-bordered" id="myTable">
			<thead>
				<tr>
					<th>Apartment Name</th>
					<th>Property Name</th>
					<th>Location</th>
					<th>No. Of Bedrooms</th>
					<th>No. Of Bathrooms</th>
					<th>Availability</th>
					<th>Area</th>
					<th>Status</th>
					<th style="background: transparent;"></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($apartments as $apartment)

				<tr>
					<td><a href="{{route('admin.apartment_view',$apartment->id)}}">{{$apartment->name}}</a></td>
					<td>{{@$apartment->property->name}}</td>
					<td>{{$apartment->location}}</td>
					<td>{{$apartment->bedrooms}}</td>
					<td>{{$apartment->bathrooms}}</td>
					<td>{{$apartment->availability}}</td>
					<td>{{$apartment->area}}</td>
					<td>@if($apartment->status==1)
						Publish
					
					@else
						Draft
					
					@endif</td>
					<td class="cursor-pointer fw-bold table-edit" id="{{$apartment->id}}" data-bs-toggle="modal" data-bs-target="#edit-apartment">Edit</td>
					<td class="btn-bg2"><a  type="button" class="table-delete fw-bold" data-bs-toggle="modal" data-bs-target="#remove-item"  data-apartmentid="{{$apartment->id}}">Remove</a></td>
				</tr>
				@endforeach

			</tbody>
		</table>
	</div>

</main>
<!--Add apartment  model start -->

<!--Add apartment  model start -->
<div class="modal fade" id="add-apartment"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">

		<div class="modal-content border-0 bg-transparent">             
			<div class="modal-body profile-model">
				<div class="container-fluid">
					<div class="scnd-type-modal-form-wrapper more-extra-width">
						<form method="post" action="{{route('admin.addApartment')}}" enctype="multipart/form-data">
                 			{{csrf_field()}}
                 			<input type="hidden" name="latitude" class="latitude" >
              				<input type="hidden" name="longitude" class="longitude">
							<h2 class="form-caption">Add apartment</h2>
							<button type="button" class="btn-close-modal float-sm-end float-start mt-0 me-sm-0 me-4" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle" aria-hidden="true"></i></button>
							<div class="row">
								<div class="col-xl-4 col-lg-4 col-md-12 apartment-select">
									<!-- frst row -->
									<div class="row">
					                    <div class="input-field-group">
					                      <label for="Apartment">Apartment Name</label>
					                      <input type="text" name="apt_name" required>
					                  </div>


					                  <div class="input-field-group">
						                  	<label for="Add-Bedrooms">No. of Bedrooms</label>
						                  	<input type="text" name="bedrooms" required>
					                  </div>

					                  <div class="input-field-group">
						                  	<label for="Add-Bathrooms">No. of Bathrooms</label>
						                  	<input type="text" name="bathroom" required>
					                  </div>

					                  <div class="input-field-group">
						                  	<label for="Add-Area">Area</label>
						                  	<input type="text" name="area" required>
					                  </div>
						                <label class="text-white" for="location">Property</label>
										<!-- <div class="custom-select2 form-rounded my-2"> -->
											<select  name="property_id" class="custom-select2" style="background-color: #2B2B2B;">
											@foreach($properties as $property)	
											<option value="{{$property->id}}">{{$property->name}}</option>
											@endforeach
											</select>
										<!-- </div> -->

					                  <div class="input-field-group location">
					                  	<label for="Add-Location">Location</label>
					                  	<input class=" pe-4 location"  type="text" name="location" required>
					                  	<i class="fa fa-map-marker-alt"></i>
					                  </div>

					                  <div class="input-field-group">
					                  	<label for="Add-Link">3D View  Link</label>
					                  	<input type="text" name="link" >
					                  </div>

					             	</div>

          						</div>
					          	<div class=" col-xl-8 col-lg-8 ps-xl-0 ps-lg-5 col-md-12">

						          	<div class="profile-img-holder add-event-img-holder  mb-3">
						          		<figcaption>Images</figcaption>
						          		<div id="add-class-img-preview-modal1" class="image-preview image-preview-2">
						          			<label class="text-uppercase" for="add-class-img-upload-modal1" id="add-class-img-label-modal1">ADD IMAGE</label>
						          			<input type="file" name="image1" id="add-class-img-upload-modal1" />
						          		</div>
						          		<div id="add-class-image-preview-modal2" class="image-preview image-preview-2">
						          			<label class="text-uppercase" for="add-class-img-upload-modal2" id="add-class-image-label-modal2">ADD IMAGE</label>
						          			<input type="file" name="image2" id="add-class-image-upload-modal2" />
						          		</div>
						          		<div id="add-class-image-preview-modal3" class="image-preview image-preview-2">
						          			<label class="text-uppercase" for="add-class-img-upload-modal3" id="add-class-image-label-modal3">ADD IMAGE</label>
						          			<input type="file" name="image3" id="add-class-image-upload-modal3" />
						          		</div>
						          	</div>

						          	<!-- 2nd row -->
						          	<div class="row">
						          		<div class="col-xl-5 col-lg-6">

						          			<div class="input-field-group">
						          				<label for="Add-Availability">Availability</label>
						          				<input type="text" name="availability" required>
						          			</div>

						          			<div class="input-field-group">
						          				<label for="Add-Call-number">Call Number</label>
						          				<input type="text" name="phone" required>
						          			</div>

						          			<div class="input-field-group">
						          				<label for="Add-Email">Email</label>
						          				<input type="email" name="email" required>
						          			</div>
						          		</div>
						          		<div class="col-xl-5 col-lg-6 ">
						          			<div class="input-field-group">
						          				<label for="Add-Short-Description">Short Description</label>
						          				<textarea class="description mb-1" name="short_description" required></textarea>
						          			</div>
						          		</div>
						          	</div>

					          	</div>


					          	<div class="btn-holder">
						          	<!-- <button class="form-btn" type="submit" style="background-color: #C89328;">Publish</button>
						          	<a href="#">Draft</a> -->
						          	<input class="form-btn publish" name="publish" type="submit" value="Publish" ></>
									<input type="submit" name="draft" value="Draft" class="draft"></>
					          	</div>
					      </div>
					  </form>
					</div>

				</div>
			</div>
		</div>

	</div>
</div>

<!--add apartmnet model end -->
<!--edit apartment model start -->
<div class="modal fade" id="edit-apartment"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">

		<div class="modal-content border-0 bg-transparent">             
			<div class="modal-body profile-model">
				<div class="container-fluid">
					<div class="scnd-type-modal-form-wrapper more-extra-width">
						<form method="post" action="{{route('admin.addApartment')}}" enctype="multipart/form-data" id="editform">
                 			{{csrf_field()}}
              				<input type="hidden" name="apartmentid" id="apartmentid">
              				<input type="hidden" name="latitude" class="latitude"  id="latitude">
              				<input type="hidden" name="longitude" class="longitude" id="longitude">
							<h2 class="form-caption">Edit apartment</h2>
							<button type="button" class="btn-close-modal float-sm-end float-start mt-0 me-sm-0 me-4" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle" aria-hidden="true"></i></button>
							<div class="row">
								<div class="col-xl-4 col-lg-4 col-md-12 apartment-select">
									<!-- frst row -->
									<div class="row">
					                    <div class="input-field-group">
					                      <label for="Apartment">Apartment Name</label>
					                      <input type="text" name="apt_name" id="apt_name" required>
					                  </div>


					                  <div class="input-field-group">
						                  	<label for="Add-Bedrooms">No. of Bedrooms</label>
						                  	<input type="text" name="bedrooms" id="bedrooms" required>
					                  </div>

					                  <div class="input-field-group">
						                  	<label for="Add-Bathrooms">No. of Bathrooms</label>
						                  	<input type="text" name="bathroom" id="bathroom" required>
					                  </div>

					                  <div class="input-field-group">
						                  	<label for="Add-Area">Area</label>
						                  	<input type="text" name="area" id="area" required>
					                  </div>
						                <label class="text-white" for="location">Property</label>
										<!-- <div class="custom-select2 form-rounded my-2"> -->
											<select id="property_select" name="property_id" class="custom-select2"  style="background-color: #2B2B2B;">
											@foreach($properties as $property)	
											<option value="{{$property->id}}">{{$property->name}}</option>
											@endforeach
											</select>
										<!-- </div> -->

					                  <div class="input-field-group location">
					                  	<label for="Add-Location">Location</label>
					                  	<input class=" pe-4 location"  type="text" name="location" id="location" required>
					                  	<i class="fa fa-map-marker-alt"></i>
					                  </div>

					                  <div class="input-field-group">
					                  	<label for="Add-Link">3D View  Link</label>
					                  	<input type="text" name="link" id="link" >
					                  </div>

					             	</div>

          						</div>
					          	<div class=" col-xl-8 col-lg-8 ps-xl-0 ps-lg-5 col-md-12">

						          	<div class="profile-img-holder add-event-img-holder  mb-3">
						          		<figcaption>Images</figcaption>
						          		<div id="edit-class-img-preview-modal1" class="image-preview image-preview-2">
						          			<label class="text-uppercase" for="edit-class-img-upload-modal1" id="edit-class-img-label-modal1">ADD IMAGE</label>
						          			<input type="file" name="image1" id="edit-class-img-upload-modal1" />
                  							<input type="hidden" name="image_1" id="image1">

						          		</div>
						          		<div id="edit-class-img-preview-modal2" class="image-preview image-preview-2">
						          			<label class="text-uppercase" for="edit-class-img-upload-modal2" id="edit-class-img-label-modal2">ADD IMAGE</label>
						          			<input type="file" name="image2" id="edit-class-img-upload-modal2" />
                  							<input type="hidden" name="image_2" id="image2">

						          		</div>
						          		<div id="edit-class-img-preview-modal3" class="image-preview image-preview-2">
						          			<label class="text-uppercase" for="edit-class-img-upload-modal3" id="edit-class-img-label-modal3">ADD IMAGE</label>
						          			<input type="file" name="image3" id="edit-class-img-upload-modal3" />
                  							<input type="hidden" name="image_3" id="image3">

						          		</div>
						          	</div>

						          	<!-- 2nd row -->
						          	<div class="row">
						          		<div class="col-xl-5 col-lg-6">

						          			<div class="input-field-group">
						          				<label for="Add-Availability">Availability</label>
						          				<input type="text" name="availability" id="availability" required>
						          			</div>

						          			<div class="input-field-group">
						          				<label for="Add-Call-number">Call Number</label>
						          				<input type="text" name="phone" id="phone" required>
						          			</div>

						          			<div class="input-field-group">
						          				<label for="Add-Email">Email</label>
						          				<input type="email" name="email" id="email" required>
						          			</div>
						          		</div>
						          		<div class="col-xl-5 col-lg-6 ">
						          			<div class="input-field-group">
						          				<label for="Add-Short-Description">Short Description</label>
						          				<textarea class="description mb-1" name="short_description" id="short_description" required></textarea>
						          			</div>
						          		</div>
						          	</div>

					          	</div>


					          	<div class="btn-holder">
						          	<!-- <button class="form-btn" type="submit" style="background-color: #C89328;">Publish</button>
						          	<a href="#">Draft</a> -->
						          	<input class="form-btn publish" name="publish" type="submit" value="Publish" ></>
									<input type="submit" name="draft" value="Draft" class="draft"></>
					          	</div>
					        </div>

						</form>
					</div>

					<!-- sixth row-->
				</div>
			</div>
		</div>

	</div>
</div>

<!--edit apartment model end -->
 
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
<!-- delete modal end -->
<!-- Image loader -->
<!-- <div id="loader" style="display: none;top: 200px;left: 0;position: fixed;z-index: 100000;text-align: center;">
  <img src="{{asset('loader.gif')}}" width="100px" height="100px">
</div> -->
<!-- Image loader -->    
@endsection
@push('script')
<script type="text/javascript">
    // document.ready function
    $(function() {
        $("#myTable").on("click", ".table-edit", function(e){
        // $('.table-edit').click(function(e) {
            e.preventDefault(); // prevent form from reloading page
          	$('#editform').trigger("reset");
	        $("#edit-class-img-preview-modal1").css("background-image", "unset");
	        $("#edit-class-img-preview-modal2").css("background-image", "unset");
	        $("#edit-class-img-preview-modal3").css("background-image", "unset");
            var id=$(this).attr('id');

            $.ajax({
                url  : "{{route('admin.getApartment')}}",
                type : 'Post',
                data :{'id':id,_token:'{{ csrf_token() }}'},
                dataType: 'json', 
                beforeSend: function(){
				    // Show image container
				    $("#loader").show();
				},   
                success : function(response) {
                        // console.log(response.images[0].path);
        			$('#apartmentid').val(response.id);                        
        			$('#apt_name').val(response.name);
        			$('#bedrooms').val(response.bedrooms);
        			$('#bathroom').val(response.bathrooms);
        			$('#area').val(response.area);
        			$('#location').val(response.location);
        			$('#link').val(response.view_link);
        			$('#short_description').val(response.short_description);
        			$('#phone').val(response.phone);
        			$('#email').val(response.email);
        			$('#description').val(response.description);
        			$('#availability').val(response.availability);
        			// $('#status').val(response.status);
        			$('#latitude').val(response.latitude);
        			$('#longitude').val(response.longitude);
        			$('#property_select').val(response.property_id).attr("selected", "selected");

        			for(var i=0; i<=3; i++){
        				
        				if(i<response.images.length){
        					// console.log(response.images[i]);
        					var img=i+1;
        					$("#edit-class-img-preview-modal"+img+"").css("background-image", "url(" + response.images[i].path + ")");
	        				$("#image"+img).val(response.images[i].id);
        				}else{
        					var img=i+1;
        					$("#edit-class-img-preview-modal"+img+"").css("background-image", "unset");
	        				$("#image"+img).val(0);
        				}
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

        var apartmentid = button.data('apartmentid') 
        var modal = $(this)

        modal.find('.modal-body #apartmentid').val(apartmentid);
    })
</script>
<script type="text/javascript">
	$(document).ready(function(){

     // add class modal images      
     $.uploadPreview({
     	input_field: "#add-class-img-upload-modal1",
     	preview_box: "#add-class-img-preview-modal1",
     	label_field: "#add-class-img-label-modal1"
     });

     $.uploadPreview({
     	input_field: "#add-class-image-upload-modal2",
     	preview_box: "#add-class-image-preview-modal2",
     	label_field: "#add-class-image-label-modal2"
     });

     $.uploadPreview({
     	input_field: "#add-class-image-upload-modal3",
     	preview_box: "#add-class-image-preview-modal3",
     	label_field: "#add-class-image-label-modal3"
     });

	  // edit class modal images
	  $.uploadPreview({
	  	input_field: "#edit-class-img-upload-modal1",
	  	preview_box: "#edit-class-img-preview-modal1",
	  	label_field: "#edit-class-img-label-modal1"
	  });

	  $.uploadPreview({
	  	input_field: "#edit-class-img-upload-modal2",
	  	preview_box: "#edit-class-img-preview-modal2",
	  	label_field: "#edit-class-img-label-modal2"
	  });

	  $.uploadPreview({
	  	input_field: "#edit-class-img-upload-modal3",
	  	preview_box: "#edit-class-img-preview-modal3",
	  	label_field: "#edit-class-img-label-modal3"
	  }); 
	});
</script>
@endpush