@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Access Key Card')

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
		<h2 class="table-cap pb-2 float-start text-capitalize">Access Key Card</h2>
		<div class="d-flex justify-content-between w-100 pb-3">
			<div>
				<form method="POST" action="{{route('admin.access_key_card_term')}}" enctype="multipart/form-data">
					@csrf
					<div class="input-field-group upload-pdf">
						<span class="input-group-btn" style="cursor: pointer;">
						  <div class="btn btn-default browse-button2">
							<span class="browse-button-text2 text-white" style="cursor: pointer;">
							@if (empty(@$terms->access_key_card_term))
							<i class="fa fa-upload"></i> 
							TERMS & CONDITIONS
							@else
							<i class="fa fa-refresh"></i>
							Change
							@endif
							</span>
							<input type="file" accept=".pdf" name="access_key_card_term">
						  </div>
						  <button type="button" class="btn btn-default clear-button" style="{{empty(@$terms->access_key_card_term) ? 'display:none;' : '' }}color: #fff;">
							<span class="fa fa-trash"></span> 
							Delete
						  </button>
						  
						  <button type="submit" class="btn btn-default upload-button" style="{{empty(@$terms->access_key_card_term) ? 'display:none;' : '' }}color: #fff;">
							@if (empty(@$terms->access_key_card_term))  
							  <span class="fa fa-save"></span> 
								Save
							@endif
							</button>
						</span>
						<input type="text" class="form-control filename2 add-btn" style="{{empty(@$terms->access_key_card_term) ? 'display:none;' : '' }}" id="edit_terms" disabled="disabled" value="{{@$terms->access_key_card_term}}">
						<span class="input-group-btn"></span>
					  </div>
				</form>
			</div>
			<div>
				<a class="add-btn my-3 float-end" href="#" type="button"  data-bs-toggle="modal" data-bs-target="#add-access-key-card">Add new</a>
			</div>
		</div>
	</div>
	<div class=" table-responsive tenant-table clear-both ">
		<table class="table  table-bordered " id="myTable">
			<thead>
				<tr>
					<th >Form ID</a></th>
					<th >User Name</a></th>
					<th >Contact Number</a></th>
					<th >Card</a></th>
					<th >Submission Date</a></th>
					<th >Apartment</a></th>
					<th >Property</a></th>
					<th >Status</a></th>
					<th >Form Status</a></th>

					<th style="background: transparent;"></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($accesskey as $access)
				<tr>
					<td><a href="{{route('admin.access_key_card_view',$access->id)}}">{{$access->form_id}}</a></td>
					<td>{{@$access->user->full_name}} </td>
					<td>{{@$access->user->mobile}}</td>
					<td>{{$access->card_type}}</td>
					<td>{{$access->created_at->todatestring()}}</td>
					<td>{{@$access->user->apt_number}}</td>
					<td>{{@$access->user->property}}</td>
					<td>{{@$access->status}}</td>

					<td>@if($access->form_status==1)
							Publish
						
						@else
							Draft
						
						@endif</td>
					<td class="fw-bold cursor-pointer table-edit" id="{{$access->id}}" data-bs-toggle="modal" data-bs-target="#edit-access-key-card">Edit</td>
					<td class="btn-bg2"><a  type="button" data-bs-toggle="modal" data-bs-target="#remove-item"  data-accessid="{{$access->id}}" class="table-delete fw-bold">Remove</a></td>
				</tr>
				@endforeach
				
			</tbody>
		</table>
	</div>

</main>
<!--Add Access key model start -->
<div class="modal fade" id="add-access-key-card"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog ">

		<div class="modal-content border-0 bg-transparent">
			<div class="modal-body service-select">
				<div class="container-fluid px-0">
					<div class="scnd-type-modal-form-wrapper extra-width">
						<form method="post" action="{{route('admin.addAccesskey')}}" enctype="multipart/form-data">
                 			{{csrf_field()}}
							<button type="button" class="btn-close-modal float-end mt-0 me-0" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
							<h2 class="form-caption">Add Access Key Card</h2>
							<div class="row">
								<div class="col-12  col-lg-12 col-xl-8">
									<!-- frst row -->
									<div class="row">
										<div class="col-sm-6 col-12 service-select">
											<div class="input-field-group">
												<label for="username">User Name</label>
												<!-- <input type="text" name="username" id="username"> -->
												<select class="custom-select2 userid"  name="userid" style="background-color: #2B2B2B;width: 247px;">
													@foreach($users as $user)
												  	<option value="{{$user->id}}">{{$user->full_name}}</option>
												 	 @endforeach
												</select>
											</div>
										</div>
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label for="username">User ID</label>
												<input type="text" name="user_id" id="userid">
											</div>
										</div>
									</div>

									<!-- scnd row -->
									<div class="row">
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label for="username">Form ID</label>
												<input type="text" name="formid" required>
											</div>
										</div>
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label for="username">Submission Date</label>
												<input type="date" name="submission" >
											</div>
										</div>
									</div>

									<!-- scnd row -->
									<div class="row">
										<div class="col-sm-6 col-12">
											<div class="radio-input-group">
												<h2>Card Request</h2>
												<div class="form-check form-check-block">
													<input class="form-check-input" name="card_request" type="radio" value="new">
													<label class="form-check-label" for="new">New</label>
												</div>

												<div class="form-check form-check-block">
													<input class="form-check-input" name="card_request" type="radio"  value="additional">
													<label class="form-check-label" for="additional">Additional</label>
												</div>

												<div class="form-check form-check-block">
													<input class="form-check-input" name="card_request" type="radio"  value="replacement">
													<label class="form-check-label" for="replacement">Replacement</label>

													<div class="form-check form-check-block">
														<input class="form-check-input" name="card_request" type="radio"  value="lost">
														<label class="form-check-label" for="lost">Lost</label>
													</div>

													<div class="form-check form-check-block">
														<input class="form-check-input" name="card_request" type="radio" value="damaged">
														<label class="form-check-label" for="damaged">Damaged</label>
													</div>
												</div>

												<h2>Access Type</h2>
												<div class="form-check form-check-block">
													<input class="form-check-input" name="access_type" type="radio"  value="apartment">
													<label class="form-check-label" for="apartment">Apartment</label>
												</div>

												<div class="form-check form-check-block">
													<input class="form-check-input" name="access_type" type="radio"  value="lift">
													<label class="form-check-label" for="lift">Lift</label>
												</div>

												<div class="form-check form-check-block">
													<input class="form-check-input" name="access_type" type="radio"  value="parking">
													<label class="form-check-label" for="parking">Parking</label>
												</div>



											</div>
										</div>
										<div class="col-sm-6 col-12">
										<label class="text-white" for="location">Property</label>
										<select name="property_id" class="custom-select2 "style="background-color: #2B2B2B;width: 247px;">
											@foreach($properties as $property)
											<option value="{{$property->id}}">{{$property->name}}</option>
											@endforeach

										</select>

										<label class="text-white" for="location">Apartment</label>
											<select name="apartment_id" class="custom-select2 "style="background-color: #2B2B2B;width: 247px;">
													@foreach($apartments as $apartment)
													<option value="{{$apartment->id}}">{{$apartment->name}}</option>
													@endforeach

											</select>

										<div class="input-field-group">
											<label for="username">Expiry Date</label>
											<input type="date" name="expiry_date" required >
										</div>

										<div class="input-field-group">
											<label for="username">Quantity</label>
											<input type="text" name="quantity" required>
										</div>

										<div class="input-field-group">
											<label for="username">Status</label>
											<!-- <input type="text" name="status" readonly > -->
											<select class="custom-select2" id="add-maintenance-form-status" name="status" style="background-color: #2B2B2B;width: 247px;">
											<option value="pending">Pending</option>
											<option value="approved">Approved</option>
											<option value="rejected">Rejected</option>	
											<option value="cancelled">Cancelled</option>				
														
										</select>
										</div>

										</div>
									</div>
								</div>
								<div class="col-12  col-sm-6 col-md-6 col-lg-4 col-xl-4">
									<div class="profile-img-holder mb-3">
										<figcaption>User Photo</figcaption>
										<div id="add-access-key-image-preview" class="image-preview">
											<label for="add-access-key-image-upload" id="add-access-key-image-label"> ADD IMAGE</label>
											<input type="file" name="image" id="add-access-key-image-upload" />
										</div> 
									</div>

									<div class="input-field-group">
										<label for="username">Charge</label>
										<input type="text" name="charge" required>
									</div>

									<div class="input-field-group">
										<label >Remarks</label>
										<textarea class="description" name="description" required></textarea>
									</div>
								</div>
							</div>

							<!-- sixth row-->
							<div class="row pt-3">
								<div class="col-12 col-sm-5">
									<div class="radio-input-group  float-start">
										<div class="form-check form-check-block">
											<input class="form-check-input" name="additionaloption" type="radio" id="additionaloption" value="option2">
											<label class="form-check-label" for="additionaloption">*Additional/replacement key card(s) are chargeable at QR. 50 per key card</label>
										</div>
									</div>
								</div>
								<div class="col-12 col-sm-6">
									<div class="btn-holder float-end">
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
<!--Add Access key model end -->    
<!--edit Access key model start -->
<div class="modal fade" id="edit-access-key-card"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog ">
		
		<div class="modal-content border-0 bg-transparent">
			<div class="modal-body service-select">
				<div class="container-fluid px-0">
					<div class="scnd-type-modal-form-wrapper extra-width">
						<form method="post" action="{{route('admin.addAccesskey')}}" enctype="multipart/form-data" id="editform">
                 			{{csrf_field()}}
                 			<input type="hidden" name="accesskey_id" id="accesskey_id">
							<button type="button" class="btn-close-modal float-end mt-0 me-0" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
							<h2 class="form-caption">Edit Access Key Card</h2>
							<div class="row">
								<div class="col-12  col-lg-12 col-xl-8">
									<!-- frst row -->
									<div class="row">
										<div class="col-sm-6 col-12 service-select">
											<div class="input-field-group">
												<label for="username">User Name</label>
												<!-- <input type="text" name="username" id="username"> -->
												<select class="custom-select2 edit_userid" id="userid1" name="userid" style="background-color: #2B2B2B;width: 247px;">
													@foreach($users as $user)
												  	<option value="{{$user->id}}">{{$user->full_name}}</option>
												 	 @endforeach
												</select>
											</div>
										</div>
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label for="username">User ID</label>
												<input type="text" name="userid" id="edit_userid">
											</div>
										</div>
									</div>

									<!-- scnd row -->
									<div class="row">
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label for="username">Form ID</label>
												<input type="text" name="formid" id="formid" required>
											</div>
										</div>
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label for="username">Submission Date</label>
												<input type="date" name="submission" id="submission" required>
											</div>
										</div>
									</div>

									<!-- scnd row -->
									<div class="row">
										<div class="col-sm-6 col-12">
											<div class="radio-input-group">
												<h2>Card Request</h2>
												<div class="form-check form-check-block">
													<input class="form-check-input" name="card_request" type="radio" id="new" value="new">
													<label class="form-check-label" for="new">New</label>
												</div>

												<div class="form-check form-check-block">
													<input class="form-check-input" name="card_request" type="radio" id="additional" value="additional">
													<label class="form-check-label" for="additional">Additional</label>
												</div>

												<div class="form-check form-check-block">
													<input class="form-check-input" name="card_request" type="radio" id="replacement" value="replacement">
													<label class="form-check-label" for="replacement">Replacement</label>

													<div class="form-check form-check-block">
														<input class="form-check-input" name="card_request" type="radio" id="lost" value="lost">
														<label class="form-check-label" for="lost">Lost</label>
													</div>

													<div class="form-check form-check-block">
														<input class="form-check-input" name="card_request" type="radio" id="damaged" value="damaged">
														<label class="form-check-label" for="damaged">Damaged</label>
													</div>
												</div>

												<h2>Access Type</h2>
												<div class="form-check form-check-block">
													<input class="form-check-input" name="access_type" type="radio" id="apartment" value="apartment">
													<label class="form-check-label" for="apartment">Apartment</label>
												</div>

												<div class="form-check form-check-block">
													<input class="form-check-input" name="access_type" type="radio" id="lift" value="lift">
													<label class="form-check-label" for="lift">Lift</label>
												</div>

												<div class="form-check form-check-block">
													<input class="form-check-input" name="access_type" type="radio" id="parking" value="parking">
													<label class="form-check-label" for="parking">Parking</label>
												</div>



											</div>
										</div>
										<div class="col-sm-6 col-12">
										<label class="text-white" for="location">Property</label>
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

										<div class="input-field-group">
											<label for="username">Expiry Date</label>
											<input type="date" name="expiry_date" id="expiry_date" required>
										</div>

										<div class="input-field-group">
											<label for="username">Quantity</label>
											<input type="text" name="quantity" id="quantity" required>
										</div>

										<div class="input-field-group">
											<label for="username">Status</label>
											<!-- <input type="text" name="status" id="status" readonly> -->
											<select class="custom-select2" id="status" name="status" style="background-color: #2B2B2B;width: 247px;">
											<option value="pending">Pending</option>
											<option value="approved">Approved</option>
											<option value="rejected">Rejected</option>	
											<option value="cancelled">Cancelled</option>				
														
										</select>
										</div>

										</div>
									</div>
								</div>
								<div class="col-12  col-sm-6 col-md-6 col-lg-4 col-xl-4">
									<div class="profile-img-holder mb-3">
										<figcaption>User Photo</figcaption>
										<div id="edit-access-key-image-preview" class="image-preview">
											<label for="edit-access-key-image-upload" id="edit-access-key-image-label">EDIT IMAGE </label>
											<input type="file" name="image" id="edit-access-key-image-upload" />
										</div> 
									</div>

									<div class="input-field-group">
										<label for="username">Charge</label>
										<input type="text" name="charge" id="charge" required>
									</div>

									<div class="input-field-group">
										<label >Remarks</label>
										<textarea class="description" name="description" id="description" required></textarea>
									</div>
								</div>
							</div>
							
							<!-- sixth row-->
							<div class="row pt-3">
								<div class="col-12 col-sm-5">
									<div class="radio-input-group  float-start">
										<div class="form-check form-check-block">
											<input class="form-check-input" name="additionaloption" type="radio" id="additionaloption" value="option2" checked="checked">
											<label class="form-check-label" for="additionaloption">*Additional/replacement key card(s) are chargeable at QR. 50 per key card</label>
										</div>
									</div>
								</div>
								<div class="col-12 col-sm-6">
									<div class="btn-holder float-end">
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
<!--Edit Access key model start --> 
<!-- delete modal start -->
<div class="modal remove-item" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-transparent border-0">
      <form method="POST" action="{{ route('admin.deleteAccesskey','user') }}">
      {{method_field('delete')}}
      {{csrf_field()}}
      <div class="modal-body">
        <div class="remove-content-wrapper">
          <p>Are you sure you want to delete?</p>
          <input type="hidden" name="accessid" id="accessid" value="">

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
          $("#edit-access-key-image-preview").css("background-image", "unset");
            var id=$(this).attr('id');

            $.ajax({
                url  : "{{route('admin.getAccesskey')}}",
                type : 'Post',
                data :{'id':id,_token:'{{ csrf_token() }}'},
                dataType: 'json',
                beforeSend: function(){
				    // Show image container
				    $("#loader").show();
				},     
                success : function(response) {
                        // console.log(response.images[0].path);
        			$('#accesskey_id').val(response.id);            
        			$('#formid').val(response.form_id);
        			$('#submission').val(response.created_at);
        			$('#expiry_date').val(response.expiry_date);
        			$('#edit_userid').val(response.user_id);
        			$('#quantity').val(response.quantity);
        			$('#charge').val(response.charge);
        			$('#description').val(response.description);
        			// $('#status').val(response.status);
        			
        			if(response.user!=null){

        			$('#property_id').val(response.user.userpropertyrelation.property_id).attr("selected", "selected");
        			$('#apartment_id').val(response.user.userpropertyrelation.apartment_id).attr("selected", "selected");
	        		}else{
	        			$('#property_id').val('');
        			     $('#apartment_id').val('');
	        		}
	        		$('#status').val(response.status).attr("selected", "selected");
        			$('#userid1').val(response.user_id).attr("selected", "selected");
        			if(response.card_type != '')
        			{	
        				$("input[name=card_request][value="+response.card_type.toLowerCase()+"]").prop("checked",true);
        				
        			}
        			else{
        				// $("input[type='radio'][name='card_request']").prop('checked', false);
        				$("input[name=card_request]").prop("checked",false);
        			} 
        			if(response.access_type != '')
        			{	
        				$("input[name=access_type][value="+response.access_type.toLowerCase()+"]").prop("checked",true);
        				
        			}
        			else{
        				$("input[name=access_type]").prop("checked",false);
        			}  

        			if(response.photo!=''){

	        			$("#edit-access-key-image-preview").css("background-image", "url(" + response.photo + ")");
        			}
        			else{

        				$("#edit-access-key-image-preview").css("background-image", "unset");
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

	    var accessid = button.data('accessid') 
	    var modal = $(this)

	    modal.find('.modal-body #accessid').val(accessid);
	})

	$('.userid').change(function(){
		var id=$(this).val();
		$('#userid').val(id);
	});

	$('.edit_userid').change(function(){
		var id=$(this).val();
		$('#edit_userid').val(id);
	});
	
	$(document).ready(function(){

    	$.uploadPreview({
          input_field: "#add-access-key-image-upload",
          preview_box: "#add-access-key-image-preview",
          label_field: "#add-access-key-image-label"
        });

        $.uploadPreview({
          input_field: "#edit-access-key-image-upload",
          preview_box: "#edit-access-key-image-preview",
          label_field: "#edit-access-key-image-label"
        });
    
    });
    
</script>
<script>
	// Show filename, show clear button and change browse 
	//button text when a valid extension file is selected
	$(".browse-button2 input:file").change(function (){
		console.log('changed');
		var fileName = $(this).val().split('/').pop().split('\\').pop();
		console.log(fileName);
		$(".filename2").val(fileName);
		$(".browse-button-text2").html('<i class="fa fa-refresh"></i> Change');
		$(".clear-button").show();
		$(".upload-button").show();
		$(".upload-button").html('<i class="fa fa-save"></i> Save');
		$(".filename2").show();
		// });
	});
	//actions happening when the button is clicked
	$('.clear-button').click(function(){
		$.ajax({
			url  : "{{route('admin.delete_term')}}",
			type : "post",
			data :{type : 'access_key_card',_token:'{{ csrf_token() }}'},
			dataType: "json",
			success:function(response){
				if(response){
					location.reload();
				}
			} 
    	});	 
	});
</script>
@endpush