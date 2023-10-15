@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Offers & Updates')

@section('content')

<main class="user-info-wrapper col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position">
@include('notification.notify')
	@if($errors->any())
	  	@foreach($errors->all() as $error)
		    <div class="alert alert-danger">
		      {{$error}}
		    </div>
	  	@endforeach
  	@endif
	<h2 class="table-cap pb-2 mb-3 text-capitalize">View Art Gallery</h2>

	<!-- First row -->
	<div class="row">
		<div class="col-xxl-3 col-xl-3">
			<figure class="user-profile-pic">
				@if(!empty($art->photo))
				<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remove-item" data-id="{{$art->id}}" data-url="{{route('admin.deleteartphoto',[$art->id])}}" class="deleteitem cross-img" tabindex="0">X</a>
				
				<img src="{{$art->photo}}" alt="Image is deletted">
				@else
				<img src="{{asset('alfardan/assets/placeholder.png')}}" alt="Image is deletted">
				@endif
			</figure>
		</div>
		<div class="col-xxl-9 col-xl-9">
			<div class="table-responsive tenant-table">

				<table class="table  table-bordered">
					<thead>
						<tr>
							<th scope="col"><span>Gallery Name</span></th>
							<th scope="col"><span>Location</span></th>
							<th scope="col"><span>Phone Number</span></th>
							<th scope="col"><span>Booking</span></th>
							<th scope="col"><span>Property</span></th> 
							<th scope="col"><span>Submission Date</span></th>
							<th scope="col"><Span>Status</Span></th>

						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{$art->name}}</td>
							<td>{{$art->location}}</td>
							<td>{{$art->phone}} </td>
							<td>{{$art->view_link}}</td>
							<td>{{@$art->property->name}}</td>                     
							<td>{{$art->created_at->todatestring()}} </td>
							<td>@if($art->status==1)
							Publish
							
							@else
								Draft
							
							@endif</td>

						</tr>       
					</tbody>
				</table>
			</div>
		
        </div>
    </div>
    <!-- scnd row -->
    <div class="row mt-5">
    	<div class="col-xxl-6 col-xl-12">
    		<div class="table-responsive tenant-table unique-table">
    			<caption>
    				<h2 class="table-cap pb-2 mb-3 text-capitalize float-start clear-both">Art</h2>
    				<a class="add-btn art-gallery-btn my-3" href="#" type="button"  data-bs-toggle="modal" data-bs-target="#addart">ADD NEW</a>
    			</caption>
    			<table class="table  table-bordered">
    				<thead>
    					<tr>
    						<th><span>Art Name</span></th>
    						<th><span>Artist Name</span></th>
    						<th><span>Description</span></th>
    						<th><span>Submission Date</span></th>
    						<th><span>Status</span></th>
    						<th colspan="2"></th>
    					</tr>
    				</thead>
    				<tbody>
    					<?php
    					$art_list=$art->art->take(9);
    					?>

    					@foreach($art_list as $art_detail)
    					<tr>
    						<td>{{$art_detail->name}}</td>
    						<td>{{$art_detail->artist_name}}</td>
    						<td>{{$art_detail->description}}</td>
    						<td>{{$art_detail->submission}}</td>
    						<td>@if($art_detail->status==1)
								Publish
							
							@else
								Draft
							
							@endif</td>

    						<td  class="cursor-pointer table-edit fw-bold" id="{{$art_detail->id}}" data-bs-toggle="modal" data-bs-target="#editart">Edit</td>
							<td class="btn-bg2"><a  type="button" class="table-delete fw-bold" data-bs-toggle="modal" data-bs-target="#remove-item"  data-addartid="{{$art_detail->id}}">Remove</a></td>
    					</tr> 
    				    @endforeach
    				</tbody>
    			</table>
    			
    		</div>
    	</div>

    </div>

</main>
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
								<form method="post" enctype="multipart/form-data" action="{{route('admin.addArt')}}">
									{{csrf_field()}}
									<input type="hidden" name="art_gallery_id" value="{{$art->id}}">
									<div class="row">
										<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4  ">
											<div class="add-family-form-wrapper ps-2 pe-3">
												<label>Art Name</label>
												<input  type="text" name="name">

												<label>Artist</label>
												<input  type="text" name="artist_name">
												<label>Date Submission</label>
												<input  type="date" name="submission">
												<label>Description</label>
												<textarea class="description-text-small" name="description"></textarea>
											</div>
										</div>
										<div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 ps-4 ">
											<div class="profile-img-holder add-event-img-holder  mb-3">
												<figcaption>Images</figcaption>
												<div id="add-class-img-preview-modal1" class="image-preview">
													<label class="text-uppercase" for="add-class-img-upload-modal1" id="add-class-img-label-modal1">add image</label>
													<input type="file" name="photo" id="add-class-img-upload-modal1" onclick="addimage('add-class-img-upload-modal1','add-class-img-preview-modal1','add-class-img-upload-modal1')"/>
												</div>
												<div id="add-class-img-preview-modal2" class="image-preview">
													<label class="text-uppercase" for="add-class-img-upload-modal2" id="add-class-img-label-modal2">add image</label>
													<input type="file" name="photo1" id="add-class-img-upload-modal2" onclick="addimage('add-class-img-upload-modal2','add-class-img-preview-modal2','add-class-img-label-modal2')"/>
												</div>
												<div id="add-class-img-preview-modal3" class="image-preview">
													<label class="text-uppercase" for="add-class-img-upload-modal3" id="add-class-img-label-modal3">add image</label>
													<input type="file" name="photo2" id="add-class-img-upload-modal3" onclick="addimage('add-class-img-upload-modal3','add-class-img-preview-modal3','add-class-img-label-modal3')"/>
												</div>
												<div id="add-class-img-preview-modal4" class="image-preview">
													<label class="text-uppercase" for="add-class-img-upload-modal4" id="add-class-img-label-modal4">add image</label>
													<input type="file" name="photo3" id="add-class-img-upload-modal4" onclick="addimage('add-class-img-upload-modal4','add-class-img-preview-modal4','add-class-img-label-modal4')"/>
												</div>
												<div id="add-class-img-preview-modal5" class="image-preview">
													<label class="text-uppercase" for="add-class-img-upload-modal5" id="add-class-img-label-modal5">add image</label>
													<input type="file" name="photo4" id="add-class-img-upload-modal5" onclick="addimage('add-class-img-upload-modal5','add-class-img-preview-modal5','add-class-img-label-modal5')"/>
												</div>
											</div>


										</div>
									</div>
									<div class="form-btn-holder mb-3 text-end  me-xxl-0">
										<!-- <button class="form-btn">Publish</button>
										<button class="form-btn">Draft</button> -->
										<input class="form-btn publish" name="publish" type="submit" value="Publish" ></>
										<input type="submit" name="draft" value="Draft" class="draft"></>
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
								<form method="post" enctype="multipart/form-data" action="{{route('admin.updateArt')}}" id="editform">
									{{csrf_field()}}
									<input type="hidden" name="art_gallery_id" id="art_gallery_id">
									<input type="hidden" name="artid" id="artid">

									<div class="row">
										<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4  ">
											<div class="add-family-form-wrapper ps-2 pe-3">
												<label>Art Name</label>
												<input  type="text" name="name" id="name">

												<label>Artist</label>
												<input  type="text" name="artist_name" id="artist_name">
												<label>Date Submission</label>
												<input  type="date" name="submission" id="submission">
												<label>Description</label>
												<textarea class="description-text-small" name="description" id="description"></textarea>
											</div>
										</div>
										<div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 ps-4 ">
											<div class="profile-img-holder add-event-img-holder  mb-3">
												<figcaption>Images</figcaption>
												<div id="edit-class-img-preview-modal1" class="image-preview">
													<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remove-item" data-id="0" data-url="#" class="deleteitem cross-img" tabindex="0">X</a>
													
													<label class="text-uppercase" for="edit-class-img-upload-modal1" id="edit-class-img-label-modal1">add image</label>
													<input type="file" name="photo" id="edit-class-img-upload-modal1" onclick="addimage('edit-class-img-upload-modal1','edit-class-img-preview-modal1','edit-class-img-label-modal1')" />
												</div>
												<div id="edit-class-img-preview-modal2" class="image-preview">
													<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remove-item" data-id="0" data-url="#" class="deleteitem cross-img" tabindex="0">X</a>
													<label class="text-uppercase" for="edit-class-img-upload-modal2" id="edit-class-img-label-modal2">add image</label>
													<input type="file" name="photo1" id="edit-class-img-upload-modal2" onclick="addimage('edit-class-img-upload-modal2','edit-class-img-preview-modal2','edit-class-img-label-modal2')" />
												</div>
												<div id="edit-class-img-preview-modal3" class="image-preview">
													<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remove-item" data-id="0" data-url="#" class="deleteitem cross-img" tabindex="0">X</a>
													<label class="text-uppercase" for="edit-class-img-upload-modal3" id="edit-class-img-label-modal3">add image</label>
													<input type="file" name="photo2" id="edit-class-img-upload-modal3" onclick="addimage('edit-class-img-upload-modal3','edit-class-img-preview-modal3','edit-class-img-label-modal3')" />
												</div>
												<div id="edit-class-img-preview-modal4" class="image-preview">
													<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remove-item" data-id="0" data-url="#" class="deleteitem cross-img" tabindex="0">X</a>
													<label class="text-uppercase" for="edit-class-img-upload-modal4" id="edit-class-img-label-modal4">add image</label>
													<input type="file" name="photo3" id="edit-class-img-upload-modal4" onclick="addimage('edit-class-img-upload-modal4','edit-class-img-preview-modal4','edit-class-img-label-modal4')" />
												</div>
												<div id="edit-class-img-preview-modal5" class="image-preview">
													<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remove-item" data-id="0" data-url="#" class="deleteitem cross-img" tabindex="0">X</a>
													<label class="text-uppercase" for="edit-class-img-upload-modal5" id="edit-class-img-label-modal5">add image</label>
													<input type="file" name="photo4" id="edit-class-img-upload-modal5" onclick="addimage('edit-class-img-upload-modal5','edit-class-img-preview-modal5','edit-class-img-label-modal5')" />
												</div>
											</div>


										</div>
									</div>
									<div class="form-btn-holder mb-3 text-end  me-xxl-0">
										<!-- <button class="form-btn">Publish</button>
										<button class="form-btn">Draft</button> -->
										<input class="form-btn publish" name="publish" type="submit" value="Publish" ></>
										<input type="submit" name="draft" value="Draft" class="draft"></>
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
<script >
	function addimage(input,box,lable){

	  	$.uploadPreview({
	    input_field:"#"+input ,
	    preview_box: "#"+box ,
	    label_field: "#"+lable 
	  	});
    }
    $(function() {
    	// $("#myTable").on("click", ".table-edit", function(e){
        $('.table-edit').click(function(e) {
            e.preventDefault(); // prevent form from reloading page
            $('#editform').trigger("reset");
            $("#edit-class-img-preview-modal1").css("background-image", "unset");
            $("#edit-class-img-preview-modal2").css("background-image", "unset");
            $("#edit-class-img-preview-modal3").css("background-image", "unset");
            $("#edit-class-img-preview-modal4").css("background-image", "unset");
            $("#edit-class-img-preview-modal5").css("background-image", "unset");



            var id=$(this).attr('id');

            $.ajax({
            	url  : "{{route('admin.getArt')}}",
            	type : 'Post',
            	data :{'id':id,_token:'{{ csrf_token() }}'},
            	dataType: 'json',
            	beforeSend: function(){
				    // Show image container
				    $("#loader").show();
				},    
				success : function(response) {
                    // console.log(response.images[0].path);
                    $('#artid').val(response.id);  
                    $('#art_gallery_id').val(response.art_gallery_id);            
                    $('#name').val(response.name);
                    $('#artist_name').val(response.artist_name);
                    $('#submission').val(response.submission);
                    $('#description').val(response.description);
           
				    	if(response.photo!=null){
        					// console.log(response.images[i]);
        					
        					$("#edit-class-img-preview-modal1").css("background-image", "url(" + response.photo + ")");
							
							$("#edit-class-img-preview-modal1 a").show();
							$("#edit-class-img-preview-modal1 a").data("id", response.id);
							$("#edit-class-img-preview-modal1 a").data("url", "/public/admin/deleteartimage/"+response.id+"/photo");
        					
        				}else{
        					
        					$("#edit-class-img-preview-modal1").css("background-image", "unset");
							$("#edit-class-img-preview-modal1 a").data("id", 0);
							$("#edit-class-img-preview-modal1 a").data("url", "");
							$("#edit-class-img-preview-modal1 a").hide();
        					
        				}
        				if(response.photo1!=null){
        					// console.log(response.images[i]);
        					
        					$("#edit-class-img-preview-modal2").css("background-image", "url(" + response.photo1 + ")");
							
							$("#edit-class-img-preview-modal2 a").data("id", response.id);
							$("#edit-class-img-preview-modal2 a").data("url", "/public/admin/deleteartimage/"+response.id+"/photo1");
							$("#edit-class-img-preview-modal2 a").show();
							
        					
        				}else{
        					
        					$("#edit-class-img-preview-modal2").css("background-image", "unset");
							
							$("#edit-class-img-preview-modal2 a").hide();
							$("#edit-class-img-preview-modal2 a").data("id", 0);
							$("#edit-class-img-preview-modal2 a").data("url", "");
        					
        				}
        				if(response.photo2!=null){
        					// console.log(response.images[i]);
        					
        					$("#edit-class-img-preview-modal3").css("background-image", "url(" + response.photo2 + ")");
							
							$("#edit-class-img-preview-modal3 a").show();
							$("#edit-class-img-preview-modal3 a").data("id", response.id);
							$("#edit-class-img-preview-modal3 a").data("url", "/public/admin/deleteartimage/"+response.id+"/photo2");
        					
        				}else{
        					
        					$("#edit-class-img-preview-modal3").css("background-image", "unset");
							$("#edit-class-img-preview-modal3 a").data("id", 0);
							$("#edit-class-img-preview-modal3 a").data("url", "");
							$("#edit-class-img-preview-modal3 a").hide();
        					
        				}
        				if(response.photo3!=null){
        					// console.log(response.images[i]);
        					
        					$("#edit-class-img-preview-modal4").css("background-image", "url(" + response.photo3 + ")");
							
							
							$("#edit-class-img-preview-modal4 a").data("id", response.id);
							$("#edit-class-img-preview-modal4 a").data("url", "/public/admin/deleteartimage/"+response.id+"/photo3");
							$("#edit-class-img-preview-modal4 a").show();
        					
        				}else{
        					
        					$("#edit-class-img-preview-modal4").css("background-image", "unset");
							$("#edit-class-img-preview-modal4 a").data("id", 0);
							$("#edit-class-img-preview-modal4 a").data("url", "");
							$("#edit-class-img-preview-modal4 a").hide();
        					
        				}
        				if(response.photo4!=null){
        					// console.log(response.images[i]);
        					
        					$("#edit-class-img-preview-modal5").css("background-image", "url(" + response.photo4 + ")");
							
							
							$("#edit-class-img-preview-modal5 a").data("id", response.id);
							$("#edit-class-img-preview-modal5 a").data("url", "/public/admin/deleteartimage/"+response.id+"/photo4");
							$("#edit-class-img-preview-modal5 a").show();
        					
        				}else{
        					
        					$("#edit-class-img-preview-modal5").css("background-image", "unset");
							$("#edit-class-img-preview-modal5 a").data("id", 0);
							$("#edit-class-img-preview-modal5 a").data("url", "");
							$("#edit-class-img-preview-modal5 a").hide();
        					
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
		var modal = $(this);
		if(button.hasClass("deleteitem")){
			modal.find('form').attr("action",button.data("url"));
		   }else{
			var addartid = button.data('addartid') 
			modal.find('.modal-body #artid').val(addartid);
		  }
	})
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