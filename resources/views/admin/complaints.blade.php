@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Complaints')

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
	<div class="table-cap-space-between">
		<h2 class="table-cap pb-2 float-start text-capitalize">Complaints</h2>
		<a class="add-btn my-3 float-end" href="#" type="button"  data-bs-toggle="modal" data-bs-target="#add-complaint">Add new</a>
	</div>
	<div class=" table-responsive tenant-table clear-both ">
		<table class="table  table-bordered " id="myTable">
			<thead>
				<tr>
					<th>Complaint ID</th>
					<th>User Name</th>
					<th>Contact Number</th>
					<th>Complain Type</th>
					<th>Submission Date</th>
					<th>Apartment</th>
					<th>Property</th>
					<th>Status</th>
					<th>Form Status</th>

					<th style="background: transparent;"></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($complaints as $complaint)
				<tr>
					<td><a href="{{route('admin.complaint_view',$complaint->id)}}">{{$complaint->id}}</a></td>
					<td>{{@$complaint->user->full_name}} </td>
					<td>{{!empty($complaint->mobile)?$complaint->mobile:@$complaint->user->mobile}}</td>
					<td>{{$complaint->type}}</td>
					<td>{{$complaint->created_at}}</td>
					<td>{{@$complaint->user->property}}</td>
					<td>{{@$complaint->user->apt_number}}</td>
					<td>{{$complaint->status}}</td>
					<td>@if($complaint->form_status==1)
							Publish
						
						@else
							Draft
						
						@endif</td>

					<td  class="table-edit fw-bold cursor-pointer" id="{{$complaint->id}}" data-bs-toggle="modal" data-bs-target="#edit-complaint">Edit</td>
					<td class="btn-bg2"><a  type="button" data-complaintid="{{$complaint->id}}" data-bs-toggle="modal" data-bs-target="#remove-item"  class="table-delete fw-bold">Remove</a></td>
				</tr>
				@endforeach
				
			</tbody>
		</table>
	</div>

</main>
<!--Add complaint form model start -->
<div class="modal fade" id="add-complaint"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog ">

		<div class="modal-content" style="border: 0; background-color: transparent;">
			<div class="modal-header border-0">
				
			</div>

			<div class="modal-body service-select">
				<div class="container-fluid px-0">
					<div class="scnd-type-modal-form-wrapper">
						<form method="post" action="{{route('admin.addComplaint')}}" enctype="multipart/form-data">
                 			{{csrf_field()}}
                 			<button type="button" class="btn-close-modal float-end mt-0 me-0" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
							<h2 class="form-caption">add complaint</h2>
							<div class="row">
								<div class="col-12 col-sm-6">

									<div class="input-field-group">
										<label for="username">User Name</label>
										<select class="custom-select2 userid"  name="userid" style="background-color: #2B2B2B;width: 247px;">
										@foreach($users as $user)
									  	<option value="{{$user->id}}">{{$user->full_name}}</option>
									  @endforeach
										</select>
									</div>

									<div class="input-field-group">
										<label for="username">User ID</label>
										<input type="text" name="user_id" id="userid">
									</div>

									<div class="input-field-group">
										<label for="username">Form ID</label>
										<input type="text" name="formid" required >
									</div>

									<label class="text-white" for="location">Complaint Type</label>
									<!-- <div class="custom-select2 form-rounded my-2"> -->
										<select name="type" class="custom-select2 "style="background-color: #2B2B2B;width: 247px;">
											<option value="Ambiance">Ambiance</option>
											<option value="Staff">Staff</option>
											<option value="Security">Security</option>
											<option value="Facilities">Facilities</option>
											<option value="Services">Services</option>
											<option value="Leasing & Finance">Leasing & Finance</option>
											<option value="IT">IT</option>

										</select>
									<!-- </div> -->

									<label class="text-white" for="location">Property Name</label>
									<!-- <div class="custom-select2 form-rounded my-2"> -->
										<select name="property_id" class="custom-select2 "style="background-color: #2B2B2B;width: 247px;">
											@foreach($properties as $property)
											<option value="{{$property->id}}">{{$property->name}}</option>
											@endforeach

										</select>
									<!-- </div> -->

									<label class="text-white" for="location">Apartment</label>
									<!-- <div class="custom-select2 form-rounded my-2"> -->
										<select name="apartment_id" class="custom-select2 "style="background-color: #2B2B2B;width: 247px;">
											@foreach($apartments as $apartment)
											<option value="{{$apartment->id}}">{{$apartment->name}}</option>
											@endforeach

										</select>
									<!-- </div> -->

								<label class="text-white" for="location">Status</label>
									<!-- <div class="custom-select2 form-rounded my-2"> -->
										<select name="status" class="custom-select2 "style="background-color: #2B2B2B;width: 247px;">
											<option value="open">Open</option>
											<option value="closed">Closed</option>
											<option value="cancel">cancelled</option>


										</select>
									<!-- </div> -->

								</div>

								<div class="col-12 col-sm-6">
									<div class="input-field-group">
										<label for="username">Phone Number</label>
										<input type="text" name="mobile" required>
									</div>

									<div class="profile-img-holder mb-3">
										<figcaption>Images</figcaption>
										<div id="add-complaint-image-preview" class="image-preview">
											<label for="add-complaint-image-upload" id="add-complaint-image-label">ADD IMAGE </label>
											<div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
											<input type="file" name="image" id="add-complaint-image-upload" />
										</div> 
									</div>

									<div class="input-field-group">
										<label >Description</label>
										<textarea class="description mb-1" name="description" required></textarea>
									</div>

								</div>
							</div>

							<div class="row">
								<div class="col-12">
									<div class="btn-holder">
										<!-- <button class="form-btn" type="submit">Publish</button>
										<a href="#">Draft</a> -->
										<input class="form-btn publish" name="publish" type="submit" value="Publish" ></>
										<input type="submit" name="draft" value="Draft" class="draft"></>
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
<!--Add complaint form model end -->
<!--edit complaint form model start -->
<div class="modal fade" id="edit-complaint"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog ">

		<div class="modal-content" style="border: 0; background-color: transparent;">
			<div class="modal-header border-0">
				
			</div>

			<div class="modal-body service-select">
				<div class="container-fluid px-0">
					<div class="scnd-type-modal-form-wrapper">
						<form method="post" action="{{route('admin.addComplaint')}}" enctype="multipart/form-data" id="editform">
                 			{{csrf_field()}}
                 			<button type="button" class="btn-close-modal float-end mt-0 me-0" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
                 			<input type="hidden" name="complaintid" id="complaintid">
							<h2 class="form-caption">Edit complaint</h2>
							<div class="row">
								<div class="col-12 col-sm-6">

									<div class="input-field-group">
										<label for="username">User Name</label>
										<select class="custom-select2 edit_userid"  name="userid" id="tuserid" style="background-color: #2B2B2B;width: 247px;">
										@foreach($users as $user)
									  	<option value="{{$user->id}}">{{$user->full_name}}</option>
									  	@endforeach
										</select>
									</div>

									<div class="input-field-group">
										<label for="username">User ID</label>
										<input type="text" name="user_id" id="edit_userid">
									</div>

									<div class="input-field-group">
										<label for="username">Form ID</label>
										<input type="text" name="formid" id="formid" required>
									</div>

									
									<label class="text-white" for="location">Complaint Type</label>
									<select name="type" id="type" class="custom-select2 "style="background-color: #2B2B2B;width: 247px;">
										<option value="Ambiance">Ambiance</option>
										<option value="Staff">Staff</option>
										<option value="Security">Security</option>
										<option value="Facilities">Facilities</option>
										<option value="Services">Services</option>
										<option value="Leasing & Finance">Leasing & Finance</option>
										<option value="IT">IT</option>

									</select>

									<label class="text-white" for="location">Property Name</label>
									<select name="property_id" id="property_id" class="custom-select2 "style="background-color: #2B2B2B;width: 247px;">
										@foreach($properties as $property)
										<option value="{{$property->id}}">{{$property->name}}</option>
										@endforeach

									</select>

									<label class="text-white" for="location">Apartment</label>
									<select name="apartment_id" id="apartment_id" class="custom-select2 "style="background-color: #2B2B2B;width: 247px;">
											@foreach($apartments as $apartment)
											<option value="{{$apartment->id}}">{{$apartment->name}}</option>
											@endforeach

									</select>

									<label class="text-white" for="location">Status</label>
									<select name="status" id="status" class="custom-select2 "style="background-color: #2B2B2B;width: 247px;">
											<option value="open">Open</option>
											<option value="closed">Closed</option>
											<option value="cancel">cancelled</option>
											

										</select>
									<div class="input-field-group" id="closedatatime" style="display: none;">
										<label class="text-white" for="location">Close Date</label>
										<input type="date" name="close" id="close">
									</div>
									
									
									
									

								</div>

								<div class="col-12 col-sm-6">
									<div class="input-field-group">
										<label for="username">Phone Number</label>
										<input type="text" name="mobile" id="mobile" required>
									</div>

									<div class="profile-img-holder mb-3">
										<figcaption>Images</figcaption>
										<div id="edit-complaint-image-preview" class="image-preview">
											<label for="edit-complaint-image-upload" id="edit-complaint-image-label">EDIT IMAGE </label>
											<div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
											<input type="file" name="image" id="edit-complaint-image-upload" />
											<input type="hidden" name="image_1" id="image1">
										</div> 
									</div>

									<div class="input-field-group">
										<label >Description</label>
										<textarea class="description mb-1" name="description" id="description" required></textarea>
									</div>

								</div>
							</div>

							<div class="row">
								<div class="col-12">
									<div class="btn-holder">
										<!-- <button class="form-btn" type="submit">Publish</button>
										<a href="#">Draft</a> -->
										<input class="form-btn publish" name="publish" type="submit" value="Publish" />
										<input type="submit" name="draft" value="Draft" class="draft">
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
<!--Edit complaint form model start -->
<!-- delete modal start -->
<div class="modal remove-item" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-transparent border-0">
      <form method="POST" action="{{ route('admin.deleteComplaint','user') }}">
      {{method_field('delete')}}
      {{csrf_field()}}
      <div class="modal-body">
        <div class="remove-content-wrapper">
          <p>Are you sure you want to delete?</p>
          <input type="hidden" name="complaintid" id="complaintid" value="">

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
        
        // $('.table-edit').click(function(e) {
        $("#myTable").on("click", ".table-edit", function(e){	
            e.preventDefault(); // prevent form from reloading page
          $('#editform').trigger("reset");
          $("#edit-complaint-image-preview").css("background-image", "unset");
            var id=$(this).attr('id');
		  $("#edit-complaint-image-upload").prev().removeClass('d-flex justify-content-end');
		  $("#edit-complaint-image-upload").prev().addClass('d-none');

            $.ajax({
                url  : "{{route('admin.getComplaints')}}",
                type : 'Post',
                data :{'id':id,_token:'{{ csrf_token() }}'},
                dataType: 'json', 
                beforeSend: function(){
				    // Show image container
				    $("#loader").show();
				},   
                success : function(response) {
                        // console.log(response.images[0].path);
        			$('#complaintid').val(response.id);            
        			$('#formid').val(response.form_id);
        			$('#description').val(response.description);
        			if(response.mobile!=null){
        				$('#mobile').val(response.mobile);
        			}else{
        				$('#mobile').val(response.user.mobile);
        			}
        			$('#edit_userid').val(response.user_id);
        			$('#property_id').val(response.user.userpropertyrelation.property_id).attr("selected", "selected");
        			$('#apartment_id').val(response.user.userpropertyrelation.apartment_id).attr("selected", "selected");
        			$('#tuserid').val(response.user_id).attr("selected", "selected");
        			$('#type').val(response.type).attr("selected", "selected");
        			$('#status').val(response.status).attr("selected", "selected");
        			$('#closedatatime #close').val(response.close);
					$( '#status').change();
        			
        			if(response.images[0]!=null){

	        			$("#edit-complaint-image-preview").css("background-image", "url(" + response.images[0].path + ")");
	        			$("#image1").val(response.images[0].id);
						$("#edit-complaint-image-upload").prev().removeClass('d-none');
                        $("#edit-complaint-image-upload").prev().addClass('d-flex justify-content-end');
        			}
        			else{

        				$("#edit-complaint-image-preview").css("background-image", "unset");
	        			$("#image1").val(0);
        			}
        			
                },
                complete:function(data){
				    // Hide image container
				    $("#loader").hide();
				}
            });
        });
    });
   

	$('.userid').change(function(){
		var id=$(this).val();
		$('#userid').val(id);
	});

	$('.edit_userid').change(function(){
		var id=$(this).val();
		$('#edit_userid').val(id);
	});

	$('#status').change(function(){
		$("#closedatatime").hide();
		
		$("#close").prop('required',false);

		var status=$(this).val();
		if(status!="open"){
			$("#closedatatime").show();
		$("#close").prop('required',true);
		}
	});
	
	
	
	$(document).ready(function(){
       $.uploadPreview({
        input_field: "#add-complaint-image-upload",
        preview_box: "#add-complaint-image-preview",
        label_field: "#add-complaint-image-label"
      });

        $.uploadPreview({
        input_field: "#edit-complaint-image-upload",
        preview_box: "#edit-complaint-image-preview",
        label_field: "#edit-complaint-image-label"
      });
	  $('#add-complaint-image-upload').on('change', function(){
			$delete_image = $(this).prev();
			$delete_image.removeClass('d-none');
			$delete_image.addClass('d-flex justify-content-end');
	  });
 	  $('#edit-complaint-image-upload').on('change', function(){
			$delete_image = $(this).prev();
			$delete_image.removeClass('d-none');
			$delete_image.addClass('d-flex justify-content-end');
	  });

     
    });

    // delete popup modal
    $('#remove-item').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget) 

        var complaintid = button.data('complaintid') 
        var modal = $(this)

        modal.find('.modal-body #complaintid').val(complaintid);
    })
</script>
<script>
	$('.delete-image').on('click', function(){
		$(this).next().val('' );
		$(this).siblings('.menu-hidden').val('');
		$(this).parent().css("background-image",'none');
		$(this).addClass('d-none');
	});
</script>
@endpush