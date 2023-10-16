@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Art Gallery')

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
	<h2 class="table-cap pb-1">Art Gallery</h2>
	<a class="add-btn art-btn my-3" href="#" type="button"  data-bs-toggle="modal" data-bs-target="#addart">ADD NEW</a>
	<div class=" table-responsive tenant-table clear-both">
		<table class="table  table-bordered">
			<thead>
				<tr>
					<th scope="col"><span>Art Name</span></th>
					<th scope="col"><span>Location</span></th>
					<th scope="col"><span>View Link</span></th>
					<th scope="col"><span>Property</span></th>
					<th scope="col"><span>Submission Date</span></th>
					<th scope="col"><span>Status</span></th>
					<th colspan="2"></th>
				</tr>
			</thead>
			<tbody>
				@foreach($arts as $art)
				<tr>
					{{-- <td><a href="{{route('admin.artGalleryview',$art->id)}}">{{$art->name}}</a></td> --}}
					<td>{{$art->name}}</td>
					<td>{{$art->location}}</td>
					<td>{{$art->view_link}}</td>
					<td>{{@$art->property->name}}</td>
					<td>{{@$art->created_at->todatestring()}}</td>
					<td>@if($art->status==1)
							Publish
						
						@else
							Draft
						
						@endif</td>
					<td  class="cursor-pointer table-edit fw-bold" id="{{$art->id}}" data-bs-toggle="modal" data-bs-target="#editart">Edit</td>
					<td class="btn-bg2"><a  type="button" class="table-delete fw-bold" data-bs-toggle="modal" data-bs-target="#remove-item"  data-artid="{{$art->id}}">Remove</a></td>
				</tr>
				@endforeach
				
			</tbody>
		</table>
		{{$arts->links()}}
	</div>

</main>
<!--add art-gallery Model model start -->
<div class="modal fade" id="addart"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-body profile-model">
				<div class="container-fluid px-0">
					<div class="row">
						<div class="col-12">
							<div class="body-wrapper">
								<h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">Add Art</h2>
								     <button type="button" class="btn-close-modal float-end" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
								<form method="post" enctype="multipart/form-data" action="{{route('admin.addArtGalleries')}}">
              					 {{csrf_field()}}
								   	<input type="hidden" name="latitude" class="latitude" >
								   	<input type="hidden" name="longitude" class="longitude">
									<div class="row">
										<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4  ">
											<div class="add-family-form-wrapper ps-2 pe-3">
												<label>Gallery Name</label>
												<input  type="text" name="name">
												<div class="location-indicator">
													<label>Location</label>
													<input  type="text" class="pe-4 location" name="location">
													<i class="fa fa-map-marker-alt"></i>
												</div>
												<label>View Link</label>
												<input  type="text" name="view_link">
												<label>Description</label>
												<textarea class="description-text-small" name="description"></textarea>
											</div>
										</div>
										<div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 ps-4 ">
											<div class="profile-img-holder add-event-img-holder  mb-3">
												<figcaption>Images</figcaption>
												<div id="add-class-img-preview-modal1" class="image-preview">
													<label class="text-uppercase" for="add-class-img-upload-modal1" id="add-class-img-label-modal1">add image</label>
													<div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
													<input type="file" name="image" id="add-class-img-upload-modal1" onclick="addimage('add-class-img-upload-modal1','add-class-img-preview-modal1','add-class-img-label-modal1')"/>
												</div>
											</div>
											<h2>Property</h2>
											<div class="profile-tenant-form">

												<div class="property-input-wrapper">
													@foreach($properties as $property)
									                    <div class="form-check form-check-inline">
									                      <input class="form-check-input property_radio" name="property_id[]" type="checkbox" id="property" value="{{$property->id}}">
									                      <label class="form-check-label" for="property">{{$property->name}}</label>
									                    </div>
									                @endforeach
													
												</div>

												<h2>Tenant</h2>

												<div class="form-check form-check-inline">
													<input class="form-check-input" type="checkbox" id="inlineCheckbox1"  name="tenant_type[]" value="Elite" >
													<label class="form-check-label" for="inlineCheckbox1">Elite</label>
												</div>

												<div class="form-check form-check-inline">
													<input class="form-check-input" name="tenant_type[]" id="inlineCheckbox2" type="checkbox" value="Regular">
													<label class="form-check-label" for="inlineCheckbox2">Regular</label>
												</div>

												<!--<div class="form-check form-check-inline mb-2">
													<input class="form-check-input" name="tenant_type[]" type="checkbox" value="Privilege">
													<label class="form-check-label" for="inlineCheckbox3">Privilege</label>
												</div>-->

												<div class="form-btn-holder mb-3 text-end  me-xxl-0">
													<!-- <button class="form-btn">Publish</button>
													<button class="form-btn">Draft</button> -->
													<input class="form-btn publish" name="publish" type="submit" value="Publish" />
													<input type="submit" name="draft" value="Draft" class="draft"/>
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
<!--Add art-gallery model end -->
<!--Edit art-gallery model start -->
<div class="modal fade" id="editart"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">

		<div class="modal-content">

			<div class="modal-body profile-model">
				<div class="container-fluid px-0">
					<div class="row">
						<div class="col-12">
							<div class="body-wrapper">
								<h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">Edit Art</h2>
								     <button type="button" class="btn-close-modal float-end" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
								<form method="post" enctype="multipart/form-data" action="{{route('admin.updateArtGalleries')}}" id="editform">
									{{csrf_field()}}
									
									<input type="hidden" name="latitude" class="latitude"  id="latitude">
              					    <input type="hidden" name="longitude" class="longitude" id="longitude">

									<input type="hidden" name="artid" id="artid">
									<div class="row">
										<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4  ">
											<div class="add-family-form-wrapper ps-2 pe-3">
												<label>Gallery Name</label>
												<input  type="text" name="name" id="name">
												<div class="location-indicator">
													<label>Location</label>
													<input  type="text" class="pe-4 location" name="location" id="location">
													<i class="fa fa-map-marker-alt"></i>
												</div>
												<label>View Link</label>
												<input  type="text" name="view_link" id="view_link">
												<label>Description</label>
												<textarea class="description-text-small" name="description" id="description"></textarea>
											</div>
										</div>
										<div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 ps-4 ">
											<div class="profile-img-holder add-event-img-holder  mb-3">
												<figcaption>Images</figcaption>
												<div id="edit-class-img-preview-modal1" class="image-preview" style="background-size: cover;">
													<label class="text-uppercase" for="edit-class-img-upload-modal1" id="edit-class-img-label-modal1">CHANGE IMAGE</label>
													<div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
													<input type="file" name="image" id="edit-class-img-upload-modal1" onclick="addimage('edit-class-img-upload-modal1','edit-class-img-preview-modal1','edit-class-img-label-modal1')"/>
												</div>


											</div>
											<h2>Property</h2>
											<div class="profile-tenant-form">

												<div class="property-input-wrapper">
													
													@foreach($properties as $property)
									                    <div class="form-check form-check-inline">
									                      <input class="form-check-input property_radio" name="property_id[]" type="checkbox" id="property" value="{{$property->id}}">
									                      <label class="form-check-label" for="property">{{$property->name}}</label>
									                    </div>
									                @endforeach
												</div>

												<h2>Tenant</h2>


												<div class="form-check form-check-inline">
													<input class="form-check-input tenantcheck" type="checkbox"  name="tenant_type[]" value="Elite" >
													<label class="form-check-label" for="inlineCheckbox1">Elite</label>
												</div>

												<div class="form-check form-check-inline">
													<input class="form-check-input tenantcheck" name="tenant_type[]" type="checkbox" value="Regular">
													<label class="form-check-label" for="inlineCheckbox2">Regular</label>
												</div>

												<!--<div class="form-check form-check-inline mb-2">
													<input class="form-check-input tenantcheck" name="tenant_type[]" type="checkbox" value="Privilege">
													<label class="form-check-label" for="inlineCheckbox3">Privilege</label>
												</div> -->

												<div class="form-btn-holder mb-3 text-end  me-xxl-0">
													<!-- <button class="form-btn">Apply</button>
													<button class="form-btn">Draft</button> -->
													<input class="form-btn publish" name="publish" type="submit" value="Publish" />
													<input type="submit" name="draft" value="Draft" class="draft"/>
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
 <!--Edit Class model end -->
<div class="modal remove-item" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
 	<div class="modal-dialog modal-dialog-centered">
 		<div class="modal-content bg-transparent border-0">
 			<form method="POST" action="{{ route('admin.deleteArtGalleries','art') }}">
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

<!-- delete modal start -->
<div class="modal" id="confirmModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
	  <div class="modal-content bg-transparent border-0">
		<form method="POST">
		{{csrf_field()}}
		<div class="modal-body">
		  <div class="remove-content-wrapper">
			<p>Save Changes</p>
			<input type="hidden" name="eventid" id="eventid" value="">
  
			<div class="delete-btn-wrapper">
				<button class="col-4 save_btn" type="Submit" 
				style="color: #fff;
				font-size: 18px;
				max-width: 133px;
				height: 37px;
				padding: 5px 32px;
				border: 1px solid #C89328;
				text-transform: uppercase;
				background: #C89328;">
				Yes</button>
			  <a href="#" type="button" class="btn-close-modal col-4" style="background-color: transparent;" data-bs-dismiss="modal" aria-label="Close">No</a>
			  <!-- <a href="#">delete</a> -->
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
	$('#add-class-img-upload-modal1').on('change', function(){
    	$delete_image = $(this).prev();
    	$delete_image.removeClass('d-none');
    	$delete_image.addClass('d-flex justify-content-end');
    });
	$('#edit-class-img-upload-modal1').on('change', function(){
		$delete_image = $(this).prev();
		$delete_image.removeClass('d-none');
		$delete_image.addClass('d-flex justify-content-end');
	});

	function addimage(input,box,lable){

	  	$.uploadPreview({
	    input_field:"#"+input ,
	    preview_box: "#"+box ,
	    label_field: "#"+lable 
	  	});
		
		$("#"+box).css("background-size", "cover");
    }
    $(function() {
    	// $("#myTable").on("click", ".table-edit", function(e){
        $('.table-edit').click(function(e) {
            e.preventDefault(); // prevent form from reloading page
            $('#editform').trigger("reset");
            $("#edit-class-img-preview-modal1").css("background-image", "unset");
			$("#edit-class-img-upload-modal1").prev().removeClass('d-flex justify-content-end');
		    $("#edit-class-img-upload-modal1").prev().addClass('d-none');


            var id=$(this).attr('id');

            $.ajax({
            	url  : "{{route('admin.getArtGalleries')}}",
            	type : 'Post',
            	data :{'id':id,_token:'{{ csrf_token() }}'},
            	dataType: 'json',
            	beforeSend: function(){
				    // Show image container
				    $("#loader").show();
				},    
				success : function(response) {
                    $('#artid').val(response.id);            
                    $('#name').val(response.name);
                    $('#location').val(response.location);
					$('#latitude').val(response.latitude);
        			$('#longitude').val(response.longitude);
                    $('#description').val(response.description);
                    $('#view_link').val(response.view_link);
                    if(response.tenant_type!=null){
                    	var tenant_type=response.tenant_type.split(',');
                    	for(var i=0; i<= 3; i++){
                    		var id=i+1;
                    		if(i<response.tenant_type.length){

                    			$('input.tenantcheck[value="'+tenant_type[i]+'"]').prop('checked', true);
		            		}

		        		}
			   		}
				    if(response.property_id!=null){
				    	var property=response.property_id.split(',');
				    	for(var i=0; i< property.length; i++){
				    		var id=i+1;
				    		if(i<id){
				    			$('input.property_radio[value="'+property[i]+'"]').prop('checked', true);
				            }

				        }
				    }
					if(response.photo!=null){        					
						$("#edit-class-img-preview-modal1").css("background-image", "url(" + response.photo + ")");
						$("#edit-class-img-preview-modal1").css("background-size", "cover");
						$("#edit-class-img-upload-modal1").prev().removeClass('d-none');
						$("#edit-class-img-upload-modal1").prev().addClass('d-flex justify-content-end');
					}else{
						
						$("#edit-class-img-preview-modal1").css("background-image", "unset");
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

	    var artid = button.data('artid') 
	    var modal = $(this)

	    modal.find('.modal-body #artid').val(artid);
	})

	$( "#addart form" ).submit(function( event ) {
			var form=0;
 			
			if($(this).find("#inlineCheckbox1").is(':checked') || $(this).find("#inlineCheckbox2").is(':checked')){
				form++;
			}else{
				alert("Please Select Tenant type");
			}
			
			if($(this).find('input:checked.property_radio').length){
				form++;
			}else{
				alert("Please Select Property");
			}
					
			if($(this).find('#add-class-img-upload-modal1').val()){
				form++;
			}else{
				// event.preventDefault()
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
</script>
<script>
	$(".submit_btn").on('click', function(){
		var value = $(this).val();
		$(".save_btn").val(value);
	});
	$('.save_btn').on('click', function(e){
		e.preventDefault();
		var value = $(this).val();
		$('#type').val(value);
		$("#add_form").submit();
	});
</script>
@endpush