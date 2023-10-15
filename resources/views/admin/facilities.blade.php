@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Facilities')

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
	<h2 class="table-cap pb-1">Facilities</h2>
	<div>
		<a class="add-btn my-3 modal-click" href="#" type="button"  data-bs-toggle="modal" data-bs-target="#addfacility">ADD NEW FACILITY</a>
	</div>
	<div class=" table-responsive tenant-table">
		<table class="table  table-bordered" id="myTable">
			<thead>
				<tr>
					<th scope="col"><span>Facility Name</span></th>
					<th scope="col"><span>Location</span></th>
					<th scope="col"><span>Number Of
					Attendees</span></th>
					<th scope="col"><span>Status</span></th>
					<th style="background: transparent;"></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($facilities as $facility)
				<tr>
					<td><a href="{{route('admin.facility_view',$facility->id)}}">{{$facility->name}}</a></td>
					<td>{{$facility->location}}</td>

					<td>{{$facility->reservations()}}</td>
					<td>@if($facility->status==1)
						Publish
					
					@else
						Draft
					
					@endif</td>
					<td class="btn-bg1"><a type="button" id="{{$facility->id}}" class="table-edit fw-bold modal-click" data-bs-toggle="modal" data-bs-target="#editfacility">Edit</a> </td>
					<td class="btn-bg2"><a  type="button" class="table-delete fw-bold" data-bs-toggle="modal" data-bs-target="#remove-item"  data-facilityid="{{$facility->id}}">Delete</a></td>
				</tr>
				@endforeach
				
				
			</tbody>
		</table>
	</div>

</main>
<!-- Add Facility model start -->
<div class="modal fade" id="addfacility"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">

		<div class="modal-content">              
			<div class="modal-body profile-model">
				<div class="container-fluid px-0">
					<div class="row">
						<div class="col-12">
							<div class="body-wrapper">
								<h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">Add facility</h2>
								<button type="button" class="btn-close-modal float-end" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
								<form method="post" enctype="multipart/form-data" action="{{route('admin.addFacility')}}">
              					 {{csrf_field()}}
              					 	<input type="hidden" name="latitude" class="latitude" >
	              					<input type="hidden" name="longitude" class="longitude">
									<div class="row">
										<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4  ">
											<div class="add-family-form-wrapper ps-2 pe-3">
												<label>Facility Name</label>
												<input  type="text" name="facilityname" required="required">
												<label>Location detail</label>
												<input  type="text" name="locationdetail" required="required">
												<div class="location-indicator">
													<label>Location</label>
													<input  type="text" class="pe-4 location" name="location" required="required">
													<i class="fa fa-map-marker-alt"></i>
												</div>
												<label>Description</label>
												<textarea class="description-text" name="description" required="required"></textarea>
												
												<label>Start Time</label>
												<input  type="time" name="time" required="required">
												<label>End time</label>
												<input  type="time" name="endtime" required="required">
												<input  type="hidden" name="date" value="2022-03-15">
											</div>
										</div>
										<div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 ps-4 ">
											<div class="profile-img-holder add-event-img-holder  mb-3">
												<figcaption>Images</figcaption>
												<div id="add-facility-img-preview-modal1"  class="image-preview">
													<label class="text-uppercase" for="add-facility-img-upload-modal1" id="add-facility-img-label-modal1">add image</label>
													<div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
													<input type="file" class="facility-image" name="image1" id="add-facility-img-upload-modal1" />
												</div>
												<div id="add-facility-img-preview-modal2"  class="image-preview">
													<label class="text-uppercase" for="add-facility-img-upload-modal2" id="add-facility-img-label-modal2">add image</label>
													<div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
													<input type="file" class="facility-image" name="image2" id="add-facility-img-upload-modal2" />
												</div>
												<div id="add-facility-img-preview-modal3"  class="image-preview">
													<label class="text-uppercase" for="add-facility-img-upload-modal3" id="add-facility-img-label-modal3">add image</label>
													<div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
													<input type="file" class="facility-image" name="image3" id="add-facility-img-upload-modal3" />
												</div>
											</div>
											<h2>Tenant</h2>
											<div class="profile-tenant-form">
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="tenant_type[]" value="Elite" >
													<label class="form-check-label" for="inlineCheckbox1">Elite</label>
												</div>

												<div class="form-check form-check-inline">
													<input class="form-check-input" name="tenant_type[]" type="checkbox" id="inlineCheckbox2" value="Regular">
													<label class="form-check-label" for="inlineCheckbox2">Regular</label>
												</div>

												<!--<div class="form-check form-check-inline mb-2">
													<input class="form-check-input" name="tenant_type[]" type="checkbox" id="inlineCheckbox3" value="Privilege">
													<label class="form-check-label" for="inlineCheckbox3">Privilege</label>
												</div>-->

												<h2>Property</h2>
												<div class="property-input-wrapper">
													@foreach($properties as $property)
													<div class="form-check form-check-inline">
														<input class="form-check-input propertyids" name="property[]" type="checkbox" id="property" value="{{$property->id}}">
														<label class="form-check-label" for="property">{{$property->name}}</label>
													</div>
													@endforeach
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
												<h2>Available days</h2>
												<div class="avlb_days-input-wrapper">
													
													<?php 
													$days = [
														'Sunday',
														'Monday',
														'Tuesday',
														'Wednesday',
														'Thursday',
														'Friday',
														'Saturday'
													];
													?>
													
													@foreach($days as $day)
													<div class="form-check form-check-inline">
														<input class="form-check-input " name="avlb_days[]" type="checkbox" id="avlb_days" value="{{$day}}">
														<label class="form-check-label" for="avlb_days">{{$day}}</label>
													</div>
													@endforeach
												 
												</div>
												<div class="input-field-group upload-pdf">
													<span class="input-group-btn" style="cursor: pointer;">
														<div class="btn btn-default browse-button2">
															<span  class="browse-button-text2 text-white"  style="cursor: pointer;">
															<i class="fa fa-upload"></i> 
															TERMS & CONDITIONS
															</span>
															<input type="file" accept=".pdf" name="terms" class="w-100">
														</div>
													  	<button type="button" class="btn btn-default clear-button" style="display:none;color: #fff;">
															<span class="fa fa-trash"></span> 
															Delete
													  	</button>
													</span>
													<input type="text" class="form-control filename2 add-btn" style="display: none;" id="terms" disabled="disabled" value="">
													<span class="input-group-btn"></span>
												</div>
												
											</div>
										</div>
									</div>
									<div class="form-btn-holder mb-3 text-end  me-xxl-0">
										<!-- <button class="form-btn btnsubmit" type="submit">Publish</button>
										<button class="form-btn">Draft</button> -->
										<input class="form-btn publish" name="publish" type="submit" value="Publish" >
										<input type="submit" name="draft" value="Draft" class="draft" />
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
<!--Edit Facility model start -->
<div class="modal fade" id="editfacility"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">

		<div class="modal-content">

			<div class="modal-body profile-model">
				<div class="container-fluid px-0">
					<div class="row">
						<div class="col-12">
							<div class="body-wrapper">
								<h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">Edit facility</h2>
								<button type="button" class="btn-close-modal float-end" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
								<form method="post" enctype="multipart/form-data" action="{{route('admin.addFacility')}}" id="editform">
              					 {{csrf_field()}}
              					 <input type="hidden" name="facilityid" id="facilityid">
              					 <input type="hidden" name="latitude" class="latitude"  id="latitude">
              					 <input type="hidden" name="longitude" class="longitude" id="longitude">
									<div class="row">
										<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4  ">
											<div class="add-family-form-wrapper ps-2 pe-3">
												<label>Facility Name</label>
												<input  type="text" name="facilityname" id="facilityname" required>
												<label>Location detail</label>
												<input  type="text" name="locationdetail" id="locationdetail" required="required">
												<div class="location-indicator">
													<label>Location</label>
													<input  type="text" class="pe-4 location" name="location" id="location" required>
													<i class="fa fa-map-marker-alt"></i>
												</div>
												<label>Description</label>
												<textarea class="description-text" name="description" id="description" required></textarea>
												<label>Start Time</label>
												<input  type="time" name="time" id="time" required="required">
												<label>End Time</label>
												<input  type="time" name="endtime" id="endtime" required="required">
												<input  type="hidden" name="date" id="date" required="required">
												
											</div>
										</div>
										<div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 ps-4 ">
											<div class="profile-img-holder add-event-img-holder  mb-3">
												<figcaption>Images</figcaption>
												<div id="edit-facility-img-preview-modal1"  class="image-preview">
													<label class="text-uppercase" for="edit-facility-img-upload-modal1" id="edit-facility-img-label-modal1">CHANGE IMAGE</label>
													<div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
													<input type="file" class="edit-facility-image" name="image1" id="edit-facility-img-upload-modal1" />
													<input type="hidden" name="image_1" id="image1">

												</div>
												<div id="edit-facility-img-preview-modal2"  class="image-preview">
													<label class="text-uppercase" for="edit-facility-img-upload-modal2" id="edit-facility-img-label-modal2">CHANGE IMAGE</label>
													<div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
													<input type="file" class="edit-facility-image" name="image2" id="edit-facility-img-upload-modal2" />
													<input type="hidden" name="image_2" id="image2">

												</div>
												<div id="edit-facility-img-preview-modal3"  class="image-preview">
													<label class="text-uppercase" for="edit-facility-img-upload-modal3" id="edit-facility-img-label-modal3">CHANGE IMAGE</label>
													<div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
													<input type="file" class="edit-facility-image" name="image3" id="edit-facility-img-upload-modal3" />
													<input type="hidden" name="image_3" id="image3">

												</div>
											</div>
											<h2>Tenant</h2>
											<div class="profile-tenant-form">
												<div class="form-check form-check-inline">
													<input class="form-check-input tenantcheck" type="checkbox" id="tenant_type1" name="tenant_type[]" value="Elite" >
													<label class="form-check-label" for="inlineCheckbox1">Elite</label>
												</div>

												<div class="form-check form-check-inline">
													<input class="form-check-input tenantcheck" name="tenant_type[]" type="checkbox" id="tenant_type2" value="Regular">
													<label class="form-check-label" for="inlineCheckbox2">Regular</label>
												</div>

												<!--<div class="form-check form-check-inline mb-2">
													<input class="form-check-input tenantcheck" name="tenant_type[]" type="checkbox" id="tenant_type3" value="Privilege">
													<label class="form-check-label" for="inlineCheckbox3">Privilege</label>
												</div>-->

												<h2>Property</h2>
												<div class="property-input-wrapper">
													<?php $i=1?>
													@foreach($properties as $property)
													<div class="form-check form-check-inline">
														<input class="form-check-input property_radio" name="property[]" type="checkbox" id="property{{$i}}" value="{{$property->id}}">
														<label class="form-check-label" for="property">{{$property->name}}</label>
													</div>
													<?php $i++; ?>
													@endforeach
													 
												</div>
												<h2>Available days</h2>
												<div class="avlb_days-input-wrapper">
													
													<?php 
														$days = [
															'Sunday',
															'Monday',
															'Tuesday',
															'Wednesday',
															'Thursday',
															'Friday',
															'Saturday'
														];
													?>
													
													@foreach($days as $day)
													<div class="form-check form-check-inline">
														<input class="form-check-input " name="avlb_days[]" type="checkbox" id="avlb_day_{{$day}}" value="{{$day}}">
														<label class="form-check-label" for="avlb_day_{{$day}}">{{$day}}</label>
													</div>
													@endforeach
												 
												</div>
												<div class="input-field-group upload-pdf">
													<span class="input-group-btn" style="cursor: pointer;">
													  	<div class="btn btn-default browse-button2">
															<span class="browse-button-text2 text-white" style="cursor: pointer;">
															<i class="fa fa-upload"></i> 
															TERMS & CONDITIONS
															</span>
														<input type="file" accept=".pdf" name="terms" class="w-100">
													  	</div>
													  	<button type="button" class="btn btn-default clear-button" id="edit_clear" style="display:none;color: #fff;">
															<span class="fa fa-trash"></span> 
															Delete
													  	</button>
													</span>
													<input type="text" class="form-control filename2 add-btn" style="display: none;" id="edit_terms" disabled="disabled" value="">
													<span class="input-group-btn"></span>
												</div>
												
											</div>
										</div>
									</div>
									<div class="form-btn-holder mb-3 text-end  me-xxl-0">
										<!-- <button class="form-btn btnsubmit">Apply</button>
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
<!--Edit Facility model end -->
<!-- delete modal start -->
<div class="modal remove-item" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-transparent border-0">
      <form method="POST" action="{{ route('admin.deleteFacility','facility') }}">
      {{method_field('delete')}}
      {{csrf_field()}}
      <div class="modal-body">
        <div class="remove-content-wrapper">
          <p>Are you sure you want to delete?</p>
          <input type="hidden" name="facilityid" id="facilityid" value="">

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
<script type="text/javascript">
    // document.ready function
    $(function() {
        $("#myTable").on("click", ".table-edit", function(e){
        // $('.table-edit').click(function(e) {
            e.preventDefault(); // prevent form from reloading page
            $('#editform').trigger("reset");
          	$("#edit-facility-img-preview-modal1").css("background-image", "unset");
          	$("#edit-facility-img-preview-modal2").css("background-image", "unset");
          	$("#edit-facility-img-preview-modal3").css("background-image", "unset");
			$('.edit-facility-image').prev().removeClass('d-flex justify-content-end');
			$('.edit-facility-image').prev().addClass('d-none');

            var id=$(this).attr('id');

            $.ajax({
                url  : "{{route('admin.getFacility')}}",
                type : 'Post',
                data :{'id':id,_token:'{{ csrf_token() }}'},
                dataType: 'json',
                beforeSend: function(){
				    // Show image container
				    $("#loader").show();
				},    
                success : function(response) {
                        // console.log(response.images[0].path);
        			$('#facilityid').val(response.id);            
        			$('#facilityname').val(response.name);      
        			$('#locationdetail').val(response.locationdetail);
					
        			$('#location').val(response.location);
        			$('#description').val(response.description);
        			$('#time').val(response.time);
        			$('#endtime').val(response.endtime);
        			$('#date').val(response.date);
        			$('#latitude').val(response.latitude);
        			$('#longitude').val(response.longitude);
					$('#edit_clear').attr("data-facilityIds", response.id);
					if(response.term_cond != null){
						$('#edit_terms').val(response.term_cond.replace(/.*uploads\//, ''));
						$(".filename2").show();
						$(".clear-button").show();
						$(".browse-button-text2").html('<i class="fa fa-refresh"></i> Change');
					}
					
						$.each(response.avlb_days, function( index, value ) {
						 	$('#avlb_day_'+value).prop('checked', true);
						});
					
		            if(response.tenant_type!=null){
		            	var tenant_type=response.tenant_type.split(',');
			            for(var i=0; i<= 3; i++){
			              var id=i+1;
			              if(i<response.tenant_type.length){

			              	$('input.tenantcheck[value="'+tenant_type[i]+'"]').prop('checked', true);
			                // $("#tenant_type"+id +"").prop('checked', true);
			              }

			            }
			        }
			        if(response.property!=null){
			        	var property=response.property;
			            for(var i=0; i< response.property.length; i++){
			              var id=i+1;
			              if(i<id){
			              	$('input.property_radio[value="'+property[i]+'"]').prop('checked', true);
			                // $("#property"+id +"").prop('checked', true);
			              }

			            }
			        }
        			
        			
        			for(var i=0; i<=3; i++){
        				
        				if(i<response.images.length){
        					// console.log(response.images[i]);
        					var img=i+1;
        					$("#edit-facility-img-preview-modal"+img+"").css("background-image", "url(" + response.images[i].path + ")");
	        				$("#image"+img).val(response.images[i].id);
							$("#edit-facility-img-upload-modal"+img+"").prev().removeClass('d-none');
                            $("#edit-facility-img-upload-modal"+img+"").prev().addClass('d-flex justify-content-end');
        				}else{
        					var img=i+1;
        					$("#edit-facility-img-preview-modal"+img+"").css("background-image", "unset");
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

	    var facilityid = button.data('facilityid') 
	    var modal = $(this)

	    modal.find('.modal-body #facilityid').val(facilityid);
	})

</script>
<script type="text/javascript">
    $(document).ready(function() {
      // add facilities
    $.uploadPreview({
      input_field: "#add-facility-img-upload-modal1",
      preview_box: "#add-facility-img-preview-modal1",
      label_field: "#add-facility-img-label-modal1"
    });

    $.uploadPreview({
      input_field: "#add-facility-img-upload-modal2",
      preview_box: "#add-facility-img-preview-modal2",
      label_field: "#add-facility-img-label-modal2"
    });

    $.uploadPreview({
      input_field: "#add-facility-img-upload-modal3",
      preview_box: "#add-facility-img-preview-modal3",
      label_field: "#add-facility-img-label-modal3"
    });
	$('.facility-image').on('change', function(){
    	$delete_image = $(this).prev();
    	$delete_image.removeClass('d-none');
    	$delete_image.addClass('d-flex justify-content-end');
    });
		
    // Edit Modal start
    $.uploadPreview({
      input_field: "#edit-facility-img-upload-modal1",
      preview_box: "#edit-facility-img-preview-modal1",
      label_field: "#edit-facility-img-label-modal1"
    });

    $.uploadPreview({
      input_field: "#edit-facility-img-upload-modal2",
      preview_box: "#edit-facility-img-preview-modal2",
      label_field: "#edit-facility-img-label-modal2"
    });

    $.uploadPreview({
      input_field: "#edit-facility-img-upload-modal3",
      preview_box: "#edit-facility-img-preview-modal3",
      label_field: "#edit-facility-img-label-modal3"
    });
	$('.edit-facility-image').on('change', function(){
    	$delete_image = $(this).prev();
    	$delete_image.removeClass('d-none');
    	$delete_image.addClass('d-flex justify-content-end');
    });
    });
	
	
			$( "#addfacility form" ).submit(function( event ) {
			
			var form=0;
 			
			if($(this).find("#inlineCheckbox1").is(':checked') || $(this).find("#inlineCheckbox2").is(':checked')){
				form++;
			}else{
				alert("Please Select Tenant type");
			}
			
			if($(this).find('input:checked.propertyids').length){
				form++;
			}else{
				alert("Please Select Property");
			}
			 
				
			if($(this).find('#add-facility-img-upload-modal1').val() ||$(this).find('#add-facility-img-upload-modal2').val() ||$(this).find('#add-facility-img-upload-modal3').val()){
				form++;
			}else{
				alert("Please Select one image");
			}
			 
			 //console.log($(this).find('.property-input-wrapper .profile-img-holder input:hasValue').serialize());
			return form>2?true:event.preventDefault();
		  
		});
		
</script>
<script>
	$('.delete-image').on('click', function(){
		$(this).next().val('' );
		$(this).siblings('.menu-hidden').val('');
		$(this).parent().css("background-image",'none');
		$(this).addClass('d-none');
	});

	$('.modal-click').on('click', function(){
		$(".clear-button").hide();
		$(".filename2").hide();
		$('.browse-button2 input:file').val("");
		$(".browse-button-text2").html('<i class="fa fa-upload"></i> TERMS & CONDITIONS'); 
	});
</script>
<script>
	// Show filename, show clear button and change browse 
	//button text when a valid extension file is selected
	$(".browse-button2 input:file").change(function (){
		console.log('changed');
		// $("input[name='terms']").each(function() {
		var fileName = $(this).val().split('/').pop().split('\\').pop();
		console.log(fileName);
		$(".filename2").val(fileName);
		$(".browse-button-text2").html('<i class="fa fa-refresh"></i> Change');
		$(".clear-button").show();
		$(".filename2").show();
		// });
	});
	//actions happening when the button is clicked
	$('.clear-button').click(function(){
		
		$('.filename2').val("");
		$('.clear-button').hide();
		$(".filename2").hide();
		$('.browse-button2 input:file').val("");
		$(".browse-button-text2").html('<i class="fa fa-upload"></i> TERMS & CONDITIONS'); 
	});
	$('#edit_clear').click(function(){
		var facility_id = $(this).attr("data-facilityIds");
		$.ajax({
			url  : "{{route('admin.delete_term')}}",
			type : "post",
			data :{type : 'facility',id : facility_id, _token:'{{ csrf_token() }}'},
			dataType: "json",
			success:function(response){
			if(response){
				$('.filename2').val("");
				$('.clear-button').hide();
				$(".filename2").hide();
				$('.browse-button2 input:file').val("");
				$(".browse-button-text2").html('<i class="fa fa-upload"></i> TERMS & CONDITIONS');
			}
			} 
    	});	 
	});
</script>
@endpush