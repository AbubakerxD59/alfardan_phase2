@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Maintenance')

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
		<h2 class="table-cap pb-2 float-start text-capitalize">Maintenance</h2>
		<a class="add-btn my-3 float-end" href="#" type="button"  data-bs-toggle="modal" data-bs-target="#add-maintenance-abtentia">Add new</a>
	</div>
	<div class=" table-responsive tenant-table clear-both ">
		<table class="table  table-bordered " id="myTable">
			<thead>
				<tr>
					<th >Tenant Name</th>
					<th >Maintenance Type</th>
					<th >Ticket ID</th>
					<th >Submisson Date/Time</th>
					<th >Availability Date/Time</th>
					<th >Property</th>
					<th >Apartment</th>
					<th >Status</th>
					<th >Form Status</th>

					<th style="background: transparent;" ></th>
					<th ></th>
				</tr>
			</thead>
			<tbody>
				@foreach($maintenances as $maintenance)
				<tr>
					<td><a href="{{route('admin.maintenance_view',$maintenance->id)}}">
						@if ($maintenance->users)
							{{$maintenance->users->full_name?$maintenance->users->full_name:$maintenance->users->first_name.' '.$maintenance->users->last_name}}
						@else
							-
						@endif 
					
					</a></td>
					<td>{{$maintenance->type}}</td>
					<td>{{$maintenance->ticket_id}}</td>
					<td>{{$maintenance->created_at}}</td>
					<td>{{$maintenance->date}} {{$maintenance->time}}</td>
					<td>{{@$maintenance->users->property}}</td>
					<td>{{@$maintenance->users->apt_number}}</td>
					<td>{{$maintenance->status}}</td>
					<td>@if($maintenance->form_status==1)
							Publish
						
						@else
							Draft
						
						@endif</td>
					<td class="fw-bold cursor-pointer table-edit" id="{{$maintenance->id}}"  data-bs-toggle="modal" data-bs-target="#edit-maintenance-abtentia">Edit</td>
					<td class="btn-bg2"><a  type="button" class="table-delete fw-bold" data-bs-toggle="modal" data-bs-target="#remove-item"  data-maintenanceid="{{$maintenance->id}}">Remove</a></td>
				</tr>
				@endforeach
				
			</tbody>
		</table>
	</div>

</main>
<!--Add maintanence form model start -->
<div class="modal fade" id="add-maintenance-abtentia"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog ">

		<div class="modal-content border-0 bg-transparent">
			<div class="modal-body">
				<div class="container-fluid px-0">
					<div class="scnd-type-modal-form-wrapper more-extra-width">
						<form method="post" enctype="multipart/form-data" action="{{route('admin.addMaintenance')}}">
              				{{csrf_field()}}
							<h2 class="form-caption">Add Maintenance</h2>
							<button type="button" class="btn-close-modal float-end mt-0 me-0" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
							<div class="row">
								<div class="col-xl-4 col-lg-4 col-md-12 service-select">
									<!-- frst row -->
									<div class="row">
										<div class="input-field-group">
											<label for="username">Tenant Name</label>
											<!-- <input type="text" name="username" id="username"> -->
											<!-- <div class="custom-select2 form-rounded my-2"> -->

												<select class="custom-select2" id="add-maintenance-form-apartment" name="user_id" style="background-color: #2B2B2B;width: 247px;">
													@foreach($users as $user)
													<option value="{{$user->id}}">{{$user->full_name}}</option>
													@endforeach
												</select>
											<!-- </div> -->
										</div>

										<div class="custom-drop">
											<label>Maintenance Type </label>
											<!-- <div class="custom-select2 form-rounded my-2"> -->

												<select class="custom-select2" id="add-maintenance-form-mainten-type" name="type" style="background-color: #2B2B2B;width: 247px;">
													<option value="Plumbing">Plumbing</option>
													<option value="Electrical">Electrical</option>
													<option value="Mechanical">Mechanical</option>
													<option value="Carpentry ">Carpentry </option>
													<option value="Elevator System">Elevator System</option>
													<option value="HEM – Electrical Appliances ">HEM – Electrical Appliances </option>
													<option value="Pest Control">Pest Control</option>
													<option value="Building maintenance">Building maintenance</option>
													
												</select>
											<!-- </div> -->
										</div>

										<div class="custom-drop">
											<label>Property</label>
											<!-- <div class="custom-select2 form-rounded my-2"> -->

												<select class="custom-select2" id="add-maintenance-form-property" name="property_id" style="background-color: #2B2B2B;width: 247px;">
													@foreach($properties as $property)
													<option value="{{$property->id}}">{{$property->name}}</option>
													@endforeach
												</select>
											<!-- </div> -->
										</div>

										<div class="custom-drop">
											<label>Apartment</label>
											<!-- <div class="custom-select2 form-rounded my-2"> -->

												<select class="custom-select2" id="add-maintenance-form-apartment" name="apartment_id" style="background-color: #2B2B2B;width: 247px;">
													@foreach($apartments as $apartment)
													<option value="{{$apartment->id}}">{{$apartment->name}}</option>
													@endforeach
												</select>
											<!-- </div> -->
										</div>

										<div class="input-field-group">
											<label for="username">Ticked ID</label>
											<input type="text" name="ticket_id" required>
										</div>

										<div class="input-field-group">
											<label for="username">Date & Time</label>
											<input type="date" name="date" required>
											<input type="time" name="time" required>

										</div>
										
										<div class="input-field-group">
											<label for="username">Complaint Close Date</label>
											<input type="date" name="complaintclosedate" >

										</div>

									</div>

								</div>
								<div class=" col-xl-8 col-lg-8 ps-xl-0 ps-lg-5 col-md-12">
									<div class="row">
										<div class="col-xl-5 col-lg-6">
											<div class="profile-img-holder mb-3">
												<figcaption>Images</figcaption>
												<div id="add-maintenance-form-image-preview" class="image-preview">
													<label for="add-maintenance-form-image-upload" id="add-maintenance-form-image-label">Choose File</label>
													<div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
													<input type="file" name="image" id="add-maintenance-form-image-upload" />
												</div> 
											</div>
										</div>
										<div class="col-xl-7 service-select">
											<div class="input-field-group">
												<label >Description</label>
												<textarea class="description mb-1" name="description" required></textarea>
											</div>

											<div class="custom-drop">
												<label>status </label>
												<!-- <div class="custom-select2 form-rounded my-2"> -->

													<select class="custom-select2" id="add-maintenance-form-status" name="status" style="background-color: #2B2B2B;width: 247px;">
														<option value="open">Open</option>
														<option value="closed">Closed</option>
														<option value="cancel">cancelled</option>				
														
													</select>
												<!-- </div> -->
											</div>
										</div>
									</div>

									<!-- 2nd row -->

									<div class="radio-input-group">
										<h2>Tenant</h2>
										<div class="form-check form-check-inline">
											<input class="form-check-input" name="tenant_type" type="radio" value="Elite">
											<label class="form-check-label" for="vip">Elite</label>
										</div>

										<div class="form-check form-check-inline">
											<input class="form-check-input" name="tenant_type" type="radio"  value="Regular">
											<label class="form-check-label" for="regular">Regular</label>
										</div>

										<div class="form-check form-check-inline">
											<input class="form-check-input" name="tenant_type" type="radio"  value="Privilege">
											<label class="form-check-label" for="nontenent">Privilege</label>
										</div>

										<!-- <h2>Property</h2>
										<div class="form-check form-check-inline">
											<input class="form-check-input" name="property" type="radio" id="Property1" value="option2">
											<label class="form-check-label" for="Property1">Property1</label>
										</div>

										<div class="form-check form-check-inline">
											<input class="form-check-input" name="property" type="radio" id="Property2" value="option2">
											<label class="form-check-label" for="Property2">Property2</label>
										</div>

										<div class="form-check form-check-inline">
											<input class="form-check-input" name="property" type="radio" id="Property3" value="option2">
											<label class="form-check-label" for="Property3">Property3</label>
										</div>

										<div class="form-check form-check-inline">
											<input class="form-check-input" name="property" type="radio" id="Property4" value="option2">
											<label class="form-check-label" for="Property4">Property4</label>
										</div>

										<div class="form-check form-check-inline">
											<input class="form-check-input" name="property" type="radio" id="Property5" value="option2">
											<label class="form-check-label" for="Property5">Property5</label>
										</div>

										<div class="form-check form-check-inline">
											<input class="form-check-input" name="property" type="radio" id="Property6" value="option2">
											<label class="form-check-label" for="Property6">Property6</label>
										</div>

										<div class="form-check form-check-inline">
											<input class="form-check-input" name="property" type="radio" id="Property7" value="option2">
											<label class="form-check-label" for="Property7">Property7</label>
										</div> -->
									</div>

									<div class="row">
										<div class="col-xl-5">
											<div class="input-field-group ">
												<label for="username">Maintenance Employee Name</label>
												<input type="text" name="emp_name" required>
											</div>
										</div>

										
									</div>

								</div>
							</div>

							<!-- sixth row-->

							<div class="col-xl-12 mt-auto">
								<div class="btn-holder">
									<!-- <button class="form-btn" type="submit">Publish</button>
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
<!--Add maintanence form model end -->
<!--edit maintanence form model start -->
<div class="modal fade" id="edit-maintenance-abtentia"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog ">
		
		<div class="modal-content border-0 bg-transparent">              
			<div class="modal-body">
				<div class="container-fluid px-0">
					<div class="scnd-type-modal-form-wrapper more-extra-width">
						<form method="post" enctype="multipart/form-data" action="{{route('admin.addMaintenance')}}" id="editform">
              				{{csrf_field()}}
              				<input type="hidden" name="maintenanceid" id="maintenanceid">

							<h2 class="form-caption">Edit Maintenance</h2>
							<button type="button" class="btn-close-modal float-end mt-0 me-0" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
							<div class="row">
								<div class="col-xl-4 col-lg-4 col-md-12 apartment-select">
									<!-- frst row -->
									<div class="row">
										<div class="input-field-group">
											<label for="username">Tenant Name</label>
											<!-- <input type="text" name="username" id="username"> -->
												<!-- <div class="custom-select2 form-rounded my-2"> -->

													<select class="custom-select2" id="tenant_name" name="user_id" style="background-color: #2B2B2B;width: 247px;">
														@foreach($users as $user)
														<option value="{{$user->id}}">{{$user->full_name}}</option>
														@endforeach
													</select>
												<!-- </div> -->
										</div>

										<div class="custom-drop">
											<label>Maintenance Type </label>
												<!-- <div class="custom-select2 form-rounded my-2"> -->

													<select class="custom-select2" id="type" name="type" style="background-color: #2B2B2B;width: 247px;">
														<option value="Plumbing">Plumbing</option>
														<option value="Electrical">Electrical</option>
														<option value="Mechanical">Mechanical</option>
														<option value="Carpentry ">Carpentry </option>
														<option value="Elevator System">Elevator System</option>
														<option value="HEM – Electrical Appliances ">HEM – Electrical Appliances </option>
														<option value="Pest Control">Pest Control</option>
														<option value="Building maintenance">Building maintenance</option>
													</select>
												<!-- </div> -->
										</div>

										<div class="custom-drop">
											<label>Property</label>
											<!-- <div class="custom-select2 form-rounded my-2"> -->

												<select id="edit_property" name="property_id" class="custom-select2"  style="background-color: #2B2B2B;width: 247px;">
													@foreach($properties as $property)
													<option value="{{$property->id}}">{{$property->name}}</option>
													@endforeach
												</select>
											<!-- </div> -->
										</div>

										<div class="custom-drop">
											<label>Apartment</label>
											<!-- <div class="custom-select2 form-rounded my-2"> -->

												<select id="edit_apartment" name="apartment_id" class="custom-select2"  style="background-color: #2B2B2B;width: 247px;">
													@foreach($apartments as $apartment)
													<option value="{{$apartment->id}}">{{$apartment->name}}</option>
													@endforeach
												</select>
											<!-- </div> -->
										</div>

										<div class="input-field-group">
											<label for="username">Ticked ID</label>
											<input type="text" name="ticket_id" id="ticket_id" required>
										</div>

										<div class="input-field-group">
											<label for="username">Date & Time</label>
											<input type="date" name="date" id="date" required>
											<input type="time" name="time" id="time" required>
										</div>

										
										<div class="input-field-group">
											<label for="username">Complaint Close Date</label>
											<input type="date" name="complaintclosedate" id="complaintclosedate" >

										</div>
									</div>

								</div>
								<div class=" col-xl-8 col-lg-8 ps-xl-0 ps-lg-5 col-md-12">
									<div class="row">
										<div class="col-xl-5 col-lg-6">
											<div class="profile-img-holder mb-3">
												<figcaption>Images</figcaption>
												<div id="edit-maintenance-form-image-preview" class="image-preview">
													<label for="edit-maintenance-form-image-upload" id="edit-maintenance-form-image-label">Choose File</label>
													<div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
													<input type="file" name="image" id="edit-maintenance-form-image-upload" />
													<input type="hidden" name="image_1" id="image1">

												</div> 
											</div>
										</div>
										<div class="col-xl-7 service-select">
											<div class="input-field-group">
												<label >Description</label>
												<textarea class="description mb-1" name="description" id="description" required></textarea>
											</div>

											<div class="custom-drop">
												<label>Status </label>
												<!-- <div class="custom-select2 form-rounded my-2"> -->

													<select id="status" name="status" class="custom-select2"  style="background-color: #2B2B2B;width: 247px;">
														<option value="open">Open</option>
														<option value="closed">Closed</option>
														<option value="cancel">cancelled</option>

														
													</select>
												<!-- </div> -->
											</div>
										</div>
									</div>
									
									<!-- 2nd row -->

									<div class="radio-input-group">
										<h2>Tenant</h2>
										<div class="form-check form-check-inline">
											<input class="form-check-input" name="tenant_type" type="radio" id="elite" value="Elite">
											<label class="form-check-label" for="vip">Elite</label>
										</div>

										<div class="form-check form-check-inline">
											<input class="form-check-input" name="tenant_type" type="radio" id="regular" value="Regular">
											<label class="form-check-label" for="regular">Regular</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" name="tenant_type" type="radio" id="privilege" value="Privilege">
											<label class="form-check-label" for="nontenent">Privilege</label>
										</div>
										<!-- <div class="form-check form-check-inline">
											<input class="form-check-input" name="tenant" type="radio" id="nontenent" value="option2">
											<label class="form-check-label" for="nontenent">Non-tenant</label>
										</div>

										<h2>Property</h2>
										<div class="form-check form-check-inline">
											<input class="form-check-input" name="property" type="radio" id="Property1" value="option2">
											<label class="form-check-label" for="Property1">Property1</label>
										</div>

										<div class="form-check form-check-inline">
											<input class="form-check-input" name="property" type="radio" id="Property2" value="option2">
											<label class="form-check-label" for="Property2">Property2</label>
										</div>

										<div class="form-check form-check-inline">
											<input class="form-check-input" name="property" type="radio" id="Property3" value="option2">
											<label class="form-check-label" for="Property3">Property3</label>
										</div>

										<div class="form-check form-check-inline">
											<input class="form-check-input" name="property" type="radio" id="Property4" value="option2">
											<label class="form-check-label" for="Property4">Property4</label>
										</div>

										<div class="form-check form-check-inline">
											<input class="form-check-input" name="property" type="radio" id="Property5" value="option2">
											<label class="form-check-label" for="Property5">Property5</label>
										</div>

										<div class="form-check form-check-inline">
											<input class="form-check-input" name="property" type="radio" id="Property6" value="option2">
											<label class="form-check-label" for="Property6">Property6</label>
										</div>

										<div class="form-check form-check-inline">
											<input class="form-check-input" name="property" type="radio" id="Property7" value="option2">
											<label class="form-check-label" for="Property7">Property7</label>
										</div> -->
									</div>

									<div class="row">
										<div class="col-xl-5">
											<div class="input-field-group ">
												<label for="username">Maintenance Employee Name</label>
												<input type="text" name="emp_name" id="emp_name" required>
											</div>
										</div>

										
									</div>

								</div>
							</div>
							
							<!-- sixth row-->
							<div class="col-xl-12 mt-auto">
								<div class="btn-holder">
									<!-- <button class="form-btn" type="submit">Publish</button>
									<a href="#">Draft</a> -->
									<input class="form-btn publish" name="publish" type="submit" value="Publish" >
									<input type="submit" name="draft" value="Draft" class="draft">
								</div>
							</div>
							
						</form>
					</div>
				</div>
			</div>
		</div>
		
		
	</div>
</div>
<!--Edit maintanence form model start -->
<!-- delete modal start -->
<div class="modal remove-item" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-transparent border-0">
      <form method="POST" action="{{ route('admin.deleteMaintenance','maintenance') }}">
      {{method_field('delete')}}
      {{csrf_field()}}
      <div class="modal-body">
        <div class="remove-content-wrapper">
          <p>Are you sure you want to delete?</p>
          <input type="hidden" name="maintenanceid" id="maintenanceid" value="">

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
@endsection
@push('script')
<script type="text/javascript">
    // document.ready function
    $(function() {
        
        // $('.table-edit').click(function(e) {
        $("#myTable").on("click", ".table-edit", function(e){	
            e.preventDefault(); // prevent form from reloading page
          $('#editform').trigger("reset");
          $("#edit-maintenance-form-image-preview").css("background-image", "unset");
            var id=$(this).attr('id');
			$("#edit-maintenance-form-image-upload").prev().removeClass('d-flex justify-content-end');
		    $("#edit-maintenance-form-image-upload").prev().addClass('d-none');

            $.ajax({
                url  : "{{route('admin.getMaintenanceRequest')}}",
                type : 'Post',
                data :{'id':id,_token:'{{ csrf_token() }}'},
                dataType: 'json', 
                beforeSend: function(){
				    // Show image container
				    $("#loader").show();
				},   
                success : function(response) {
                    // console.log(response.images[0].path);
        			$('#maintenanceid').val(response.id);    
        			$('#ticket_id').val(response.ticket_id);
        			$('#date').val(response.date);
        			$('#complaintclosedate').val(response.complaintclosedate);
					
        			$('#time').val(response.time);
        			$('#emp_name').val(response.emp_name);
        			$('#description').val(response.description);
        			if(response.user_id){
					$('#tenant_name').val(response.user_id).attr("selected", "selected");
					}
					if(response.users){
						$('#edit_property').val(response.users.userpropertyrelation.property_id).attr("selected", "selected");
						$('#edit_apartment').val(response.users.userpropertyrelation.apartment_id).attr("selected", "selected");
						if(response.tenant_type){
							var tenant_type=response.users.tenant_type.toLowerCase();
						}
					}
					if($('input[name=tenant_type]:checked','#edit-maintenance-abtentia').val()!=$('#edit-maintenance-abtentia #'+tenant_type).val()){
				$('#edit-maintenance-abtentia #'+tenant_type).click();
        			}
        		   
        			
        			$('#type').val(response.type).attr("selected", "selected");
        			$('#status').val(response.status).attr("selected", "selected");

 				$( "#status" ).trigger( "change" );

        			if(response.images[0]!=null){

	        			$("#edit-maintenance-form-image-preview").css("background-image", "url(" + response.images[0].path + ")");
	        			$("#image1").val(response.images[0].id);
						$("#edit-event-img-upload-modal1").prev().removeClass('d-none');
						$("#edit-event-img-upload-modal1").prev().addClass('d-flex justify-content-end');
        			}
        			else{

        				$("#edit-maintenance-form-image-preview").css("background-image", "unset");
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

    // delete popup modal
    $('#remove-item').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget) 

        var maintenanceid = button.data('maintenanceid') 
        var modal = $(this)

        modal.find('.modal-body #maintenanceid').val(maintenanceid);
    })
</script>
<script type="text/javascript">
     // dropdown
    $(document).ready(function(){


$( "#status" ).change(function() {
 	var status=$(this).val();
	var div=$("#complaintclosedate").parent();
	if(status=='open'){
		div.hide();
		$("#complaintclosedate").val("");
		$("#complaintclosedate").prop('required',false);

	}else{
		div.show();
		$("#complaintclosedate").prop('required',true);
	}

});
      $.uploadPreview({
          input_field: "#add-maintenance-form-image-upload",
          preview_box: "#add-maintenance-form-image-preview",
          label_field: "#add-maintenance-form-image-label"
        });

        $.uploadPreview({
          input_field: "#edit-maintenance-form-image-upload",
          preview_box: "#edit-maintenance-form-image-preview",
          label_field: "#edit-maintenance-form-image-label"
        });
		
		$('#add-maintenance-form-image-upload').on('change', function(){
    	$delete_image = $(this).prev();
    	$delete_image.removeClass('d-none');
    	$delete_image.addClass('d-flex justify-content-end');
    	});
		
		$('#edit-maintenance-form-image-upload').on('change', function(){
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
@endpush