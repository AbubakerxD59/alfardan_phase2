@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Automated Guest Access')

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
		<h2 class="table-cap pb-2 float-start text-capitalize">Automated Guest Access</h2>
		<div class="d-flex justify-content-between w-100 pb-3">
			<div>
				<form method="POST" action="{{route('admin.automated_guest_access_term')}}" enctype="multipart/form-data">
					@csrf
					<div class="input-field-group upload-pdf">
						<span class="input-group-btn" style="cursor: pointer;">
						  <div class="btn btn-default browse-button2">
							<span class="browse-button-text2 text-white" style="cursor: pointer;">
							@if (empty(@$terms->automated_guest_access_term))
							<i class="fa fa-upload"></i> 
							TERMS & CONDITIONS
							@else
							<i class="fa fa-refresh"></i>
							Change
							@endif
							</span>
							<input type="file" accept=".pdf" name="automated_guest_access_term">
						  </div>
						  <button type="button" class="btn btn-default clear-button" style="{{empty(@$terms->automated_guest_access_term) ? 'display:none;' : '' }}color: #fff;">
							<span class="fa fa-trash"></span> 
							Delete
						  </button>
						  
						  <button type="submit" class="btn btn-default upload-button" style="{{empty(@$terms->automated_guest_access_term) ? 'display:none;' : '' }}color: #fff;">
							@if (empty(@$terms->automated_guest_access_term))  
							  <span class="fa fa-save"></span> 
								Save
							@endif
							</button>
						</span>
						<input type="text" class="form-control filename2 add-btn" style="{{empty(@$terms->automated_guest_access_term) ? 'display:none;' : '' }}" id="edit_terms" disabled="disabled" value="{{@$terms->automated_guest_access_term}}">
						<span class="input-group-btn"></span>
					  </div>
				</form>
			</div>
			<div>
				<a class="add-btn my-3 float-end" href="#" type="button"  data-bs-toggle="modal" data-bs-target="#add-automated-guest">Add new</a>
			</div>
		</div>
	</div>
	<div class=" table-responsive tenant-table clear-both ">
		<table class="table  table-bordered " id="myTable">
			<thead>
				<tr>
					<th >Form ID</th>
					<th >User Name</th>
					<th >Contact Number</th>
					<th >Authorized Person Number</th>
					<th >Authorized Person Name</th>
					<th >Submission Date</th>
					<th >Access Date</th>
					<th >Apartment</th>
					<th >Property</th>
					<th >Status</th>
					<th >Form Status</th>

					<th style="background: transparent;"></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($guests as $guest)
				<tr>
					<td><a href="{{route('admin.automated_guest_view',$guest->id)}}">{{$guest->form_id}}</a></td>
					<td>{{@$guest->user->full_name}} </td>
					<td>{{@$guest->user->mobile}}</td>
					<td>{{$guest->number}}</td>
					<td>{{$guest->name}}</td>
					<td>{{$guest->created_at->todatestring()}}</td>
					<td>{{$guest->date}}</td>
					<td>{{@$guest->user->apt_number}}</td>
					<td>{{@$guest->user->property}}</td>
					<td>{{@$guest->status}}</td>

					<td>
						@if($guest->form_status==1)
							Publish
						
						@else
							Draft
						
						@endif</td>
					<td  class="fw-bold cursor-pointer table-edit" id="{{$guest->id}}" data-bs-toggle="modal" data-bs-target="#edit-automated-guest">Edit</td>
					<td class="btn-bg2"><a  type="button" data-bs-toggle="modal" data-bs-target="#remove-item"  data-automatedid="{{$guest->id}}" class="table-delete fw-bold">Remove</a></td>
				</tr>
				@endforeach
			
			</tbody>
		</table>
	</div>

</main>
<!--Add pet request model start -->
<div class="modal fade" id="add-automated-guest"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog ">

		<div class="modal-content border-0 bg-transparent">
			<div class="modal-body service-select">
				<div class="container-fluid px-0">
					<div class="scnd-type-modal-form-wrapper extra-width">
						<form method="post" action="{{route('admin.addAutomatedGuest')}}" enctype="multipart/form-data">
                 			{{csrf_field()}}
							<button type="button" class="btn-close-modal float-sm-end mt-0  me-4 me-sm-0 float-start " data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
							<h2 class="form-caption">Add Automated Guest Access</h2>

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
												<input type="date" name="submission" required>
											</div>
										</div>
									</div>

									<!-- scnd row -->
									<div class="row">
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label for="username">Authorized Person Number</label>
												<input type="text" name="number" required>
											</div>
										</div>
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label for="username">Access Date</label>
												<input type="date" name="date" required>
											</div>
										</div>
									</div>

									
									<!-- thrd row -->
									<div class="row">
										<div class="col-sm-6 col-12 service-select">
											<div class="custom-drop">
												<label>Apartment</label>
												<select name="apartment_id" class="custom-select2 "style="background-color: #2B2B2B;width: 247px;">
													@foreach($apartments as $apartment)
													<option value="{{$apartment->id}}">{{$apartment->name}}</option>
													@endforeach

												</select>
											</div>
										</div>
										<div class="col-sm-6 col-12 service-select">
											<div class="custom-drop">
												<label>Property</label>
												<select name="property_id" class="custom-select2 "style="background-color: #2B2B2B;width: 247px;">
													@foreach($properties as $property)
													<option value="{{$property->id}}">{{$property->name}}</option>
													@endforeach

												</select>
											</div>
										</div>
									</div>

									<!-- frth row -->
									<div class="row">
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label for="username">Phone Number</label>
												<input type="text" name="phone" required>
											</div>
										</div>
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label for="username">Status</label>
												<!-- <input type="text" name="status" readonly> -->
												<select class="custom-select2" id="add-maintenance-form-status" name="status" style="background-color: #2B2B2B;width: 247px;">
												<option value="pending">Pending</option>
												<option value="approved">Approved</option>
												<option value="rejected">Rejected</option>	
												<option value="cancelled">Cancelled</option>				
														
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label for="username">Authorized Person Name</label>
												<input type="text" name="name" required>
											</div>
										</div>
										
									</div>
									<!-- fifth row -->
									<div class="row">
										<div class="col-sm-6 col-12">
											<div class="input-field-group pt-sm-5">
												<input class="form-check-input" type="radio" value="1" name="term" id="condition"> <span for="condition" class="input-radio-checked">Terms & Conditions</span>
											</div>
										</div>
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label >Status Reason</label>
												<textarea class="description" name="reason" required></textarea>
											</div>
										</div>
									</div>

								</div>
								<div class="col-12  col-sm-6 col-md-6 col-lg-4 col-xl-4">
									<div class="profile-img-holder mb-3">
										<figcaption>Authorized Person ID Photo</figcaption>
										<div id="add-automated-guest-image-preview" class="image-preview">
											<label for="add-automated-guest-image-upload" id="add-automated-guest-image-label">Choose File</label>
											<div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
											<input type="file" name="image" id="add-automated-guest-image-upload" />
										</div> 
									</div>
								</div>
							</div>

							<!-- sixth row-->
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
<!--Add pet request model end -->  
<!--edit pet request model start -->
<div class="modal fade" id="edit-automated-guest"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog ">
		
		<div class="modal-content border-0 bg-transparent" >
			<div class="modal-body service-select">
				<div class="container-fluid px-0">
					<div class="scnd-type-modal-form-wrapper extra-width">
						<form method="post" action="{{route('admin.addAutomatedGuest')}}" enctype="multipart/form-data" id="editform">
                 			{{csrf_field()}}
                 			<input type="hidden" name="automate_id" id="automate_id">

							<button type="button" class="btn-close-modal float-sm-end mt-0  me-4 me-sm-0 float-start " data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
							<h2 class="form-caption">Edit Automated Guest Access</h2>
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
											<div class="input-field-group">
												<label for="username">Authorized Person Number</label>
												<input type="text" name="number" id="number" required>
											</div>
										</div>
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label for="username">Access Date</label>
												<input type="date" name="date" id="date" required>
											</div>
										</div>
									</div>


									<!-- thrd row -->
									<div class="row">
										<div class="col-sm-6 col-12 service-select">
											<div class="custom-drop">
												<label>Apartment</label>
												<select name="apartment_id" id="apartment_id" class="custom-select2 "style="background-color: #2B2B2B;width: 247px;">
													@foreach($apartments as $apartment)
													<option value="{{$apartment->id}}">{{$apartment->name}}</option>
													@endforeach

												</select>
											</div>
										</div>
										<div class="col-sm-6 col-12 service-select">
											<div class="custom-drop">
												<label>Property</label>
												<select name="property_id" id="property_id" class="custom-select2 "style="background-color: #2B2B2B;width: 247px;">
													@foreach($properties as $property)
													<option value="{{$property->id}}">{{$property->name}}</option>
													@endforeach

												</select>
											</div>
										</div>
									</div>

									<!-- frth row -->
									<div class="row">
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label for="username">Phone Number</label>
												<input type="text" name="phone" id="phone" required>
											</div>
										</div>
										<div class="col-sm-6 col-12">
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
									<div class="row">
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label for="username">Authorized Person Name</label>
												<input type="text" name="name" id="name" required>
											</div>
										</div>
										
									</div>
									<!-- fifth row -->
									<div class="row">
										<div class="col-sm-6 col-12">
											<div class="input-field-group pt-sm-5">
												<input class="form-check-input" type="radio" value="1" name="term" id="term"> <span for="condition" class="input-radio-checked">Terms & Conditions</span>
											</div>
										</div>
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label >Status Reason</label>
												<textarea class="description" name="reason" id="reason" required></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="col-12  col-sm-6 col-md-6 col-lg-4 col-xl-4">
									<div class="profile-img-holder mb-3">
										<figcaption>Authorized Person ID Photo</figcaption>
										<div id="edit-automated-guest-image-preview" class="image-preview">
											<label for="edit-automated-guest-image-upload" id="edit-automated-guest-image-label">Choose File</label>
											<div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
											<input type="file" name="image" id="edit-automated-guest-image-upload" />
										</div> 
									</div>
								</div>
							</div>
							
							<!-- sixth row-->
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
<!--Edit pet request model start --> 
<!-- delete modal start -->
<div class="modal remove-item" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-transparent border-0">
      <form method="POST" action="{{ route('admin.deleteAutomatedGuest','user') }}">
      {{method_field('delete')}}
      {{csrf_field()}}
      <div class="modal-body">
        <div class="remove-content-wrapper">
          <p>Are you sure you want to delete?</p>
          <input type="hidden" name="automatedid" id="automatedid" value="">

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
          $("#edit-automated-guest-image-preview").css("background-image", "unset");
            var id=$(this).attr('id');
		  $("#edit-automated-guest-image-upload").prev().removeClass('d-flex justify-content-end');
		  $("#edit-automated-guest-image-upload").prev().addClass('d-none');

            $.ajax({
                url  : "{{route('admin.getAutomatedGuest')}}",
                type : 'Post',
                data :{'id':id,_token:'{{ csrf_token() }}'},
                dataType: 'json', 
                beforeSend: function(){
				    // Show image container
				    $("#loader").show();
				},   
                success : function(response) {
                        // console.log(response.images[0].path);
        			$('#automate_id').val(response.id);            
        			$('#formid').val(response.form_id);
        			$('#submission').val(response.created_at);
        			$('#number').val(response.number);
        			$('#edit_userid').val(response.user_id);
        			$('#date').val(response.date);
        			$('#name').val(response.name);

        			$('#reason').val(response.reason);
        			// $('#status').val(response.status);
        			if(response.user!=null){
        			$('#phone').val(response.user.mobile);

        			$('#property_id').val(response.user.userpropertyrelation.property_id).attr("selected", "selected");
        			$('#apartment_id').val(response.user.userpropertyrelation.apartment_id).attr("selected", "selected");
	        		}else{
	        			$('#property_id').val('');
        			     $('#apartment_id').val('');
	        		}
	        		$('#status').val(response.status).attr("selected", "selected");
        			$('#userid1').val(response.user_id).attr("selected", "selected");
        			if(response.term == '1')
        			{
        				$('#term').prop('checked', true);
        			}
        			else{
        				$('#term').prop('checked', false);
        			}  

        			if(response.photo!='' && response.photo != null){

	        			$("#edit-automated-guest-image-preview").css("background-image", "url(" + response.photo + ")");
						$("#edit-automated-guest-image-upload").prev().removeClass('d-none');
                        $("#edit-automated-guest-image-upload").prev().addClass('d-flex justify-content-end');
        			}
        			else{

        				$("#edit-automated-guest-image-preview").css("background-image", "unset");
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

	    var automatedid = button.data('automatedid') 
	    var modal = $(this)

	    modal.find('.modal-body #automatedid').val(automatedid);
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
			input_field: "#add-automated-guest-image-upload",
			preview_box: "#add-automated-guest-image-preview",
			label_field: "#add-automated-guest-image-label"
		});

		$.uploadPreview({
			input_field: "#edit-automated-guest-image-upload",
			preview_box: "#edit-automated-guest-image-preview",
			label_field: "#edit-automated-guest-image-label"
		});
		$('#add-automated-guest-image-upload').on('change', function(){
    	    $delete_image = $(this).prev();
    	    $delete_image.removeClass('d-none');
    	    $delete_image.addClass('d-flex justify-content-end');
        });
        $('#edit-automated-guest-image-upload').on('change', function(){
            $delete_image = $(this).prev();
            $delete_image.removeClass('d-none');
            $delete_image.addClass('d-flex justify-content-end');
        });
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
			data :{type : 'automated_guest_access',_token:'{{ csrf_token() }}'},
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