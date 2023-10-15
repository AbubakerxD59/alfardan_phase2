@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Employee')

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
	<h2 class="table-cap pb-1">Employees</h2>
	<a class="add-btn my-3" href="#" type="button" data-bs-toggle="modal" data-bs-target="#add-employee">ADD NEW EMPLOYEE</a>
	<div class=" table-responsive tenant-table">
		<table class="table  table-bordered" id="myTable">
			<thead>
				<tr>
					<th scope="col"><span>User Name</span></th>
						<th scope="col"><span>Email</span></th>
						<!-- <th scope="col"><span>Password</span></th> -->
						<th scope="col"><span>Phone Number</span></th>
						<th scope="col"><span>Job Role</span></th>
						<th scope="col"><span>Access Type</span></th>
						<th scope="col"><span>Property</span></th>
						<!-- <th scope="col"><span>Tenant ID</span></th> -->
						<th style="background: transparent;"></th>
						<th></th>

					</tr>
				</thead>
				<tbody>
					@foreach($employees as $employee)
					<tr>
						<td><a href="{{route('admin.employee_view',$employee->id)}}">{{$employee->name}}</a></td>
						<td>{{$employee->email}}</td>
						<!-- <td>******</td> -->
						<td>{{$employee->phone}}</td>
						<td>{{$employee->job_role}}</td>
						<td>{{\App\Models\Employee::$roles[$employee->type]}}</td>
						<td>
							@if(!empty($employee->property_id))
							{{implode(', ', $employee->propertylisit()->pluck('name')->toArray())}}
							@endif
						</td>
						<!-- <td>{{$employee->name}}</td> -->
						<td  class="cursor-pointer table-edit fw-bold" id="{{$employee->id}}" data-bs-toggle="modal" data-bs-target="#edit-employee">Edit</td>
						@if($employee->id!=1)
                  			<td class="cursor-pointer table-edit fw-bold" data-employeeid="{{$employee->id}}" data-bs-toggle="modal" data-bs-target="#remove-item">Remove</td>
						@else
							<td></td>
						@endif
					</tr>
					@endforeach
					
				</tbody>
			</table>
		</div>

</main>
<!-- delete modal start -->
<div class="modal" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-transparent border-0">
    	<form method="POST" action="{{ route('admin.deleteEmployee','employee') }}">
	      {{method_field('delete')}}
	      {{csrf_field()}}
	      <div class="modal-body">
	        <div class="remove-content-wrapper">
	          <p>Are you sure you want to delete?</p>
          	   <input type="hidden" name="employeeid" id="employeeid" value="">

	          <div class="delete-btn-wrapper">
	            <a href="#" type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close">cancel</a>
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
<!--Add employee  model start -->
<div class="modal fade" id="add-employee"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog ">

		<div class="modal-content border-0 bg-transparent">
			<div class="modal-body">
				<div class="container-fluid px-0">
					<div class="scnd-type-modal-form-wrapper extra-width">
						<form method="post" action="{{route('admin.addEmployee')}}" enctype="multipart/form-data">
                 			{{csrf_field()}}
							  <button type="button" class="btn-close-modal float-sm-end mt-0  me-4 me-sm-0 float-start " data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
							<h2 class="form-caption">Add Employee</h2>

							<div class="row">
								<div class="col-12  col-lg-12 col-xl-8">
									<!-- frst row -->
									<div class="row">
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label for="epmid">Employee ID</label>
												<input type="text" name="emp_id" required>
											</div>
										</div>
										<div class="col-sm-6 col-12">

											<div class="input-field-group">
												<label for="username">Name</label>
												<input type="text" name="name" required>
											</div>
										</div>
									</div>
									<!-- thrd row -->
									<div class="row">
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label for="Email">Email</label>
												<input type="email" name="email" required>
											</div>
										</div>
										<div class="col-sm-6 col-12">
											<div class="custom-drop">
												<div class="input-field-group">
													<label for="Password">Password</label>
													<input type="password" name="password" required>
												</div>
											</div>
										</div>
									</div>

									<!-- scnd row -->
									<div class="row">
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label for="Job-Role">Job Role</label>
												<input type="text" name="job_role" required>
											</div>
										</div>
										<div class="col-sm-6 col-12 service-select">

											<div class="input-field-group">
												<label for="AccessType">Access Type</label>												
												<select name="access_type" class="custom-select2" style="background-color: #2B2B2B;width: 247px;" required>
													
													@foreach(\App\Models\Employee::$roles as $key=>$role)
														<option value="{{$key}}">{{$role}}</option>
													@endforeach
														 
													</select>
												
												
											</div>
										</div>
									</div>

									<!-- scnd row -->
									<div class="row">
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label for="BirthDate">Birth Date</label>
												<input type="date" name="dob" required>
											</div>
										</div>
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label for="PhoneNumber">Phone Number</label>
												<input type="text" name="phone" required>
											</div>
										</div>
									</div>




									<!-- frth row -->

									<div class="row">
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label for="username">Office Number</label>
												<input type="text" name="office_number" required>
											</div>
										</div>
										<div class="col-sm-12 col-12 service-select profile-tenant-form">
											<label for="Property">Property</label>
											<div class="property-input-wrapper input-group">
												
												@foreach($properties as $property)
													<div class="property-input-wrapper p-0" style="width: fit-content;">
														<div class="form-check form-check-inline">
														<input class="form-check-input property_radio" name="property[]" type="checkbox" id="property{{$property->id}}" value="{{$property->id}}">	
									                      <label class="form-check-label" for="property{{$property->id}}">{{$property->name}}</label>
									                    </div>
									                </div>
												@endforeach
												<!-- <input type="text" name="Property" id="Property"> -->
												<!-- <div class="custom-select2 form-rounded my-2"> -->

												<!-- </div> -->
											</div>
										</div>
									</div>

									<!-- fifth row 
									<div class="row">
										<div class="col-sm-6 col-12 service-select">
											<div class="input-field-group">
												<div class="input-field-group">
													<label for="Apartment">Apartment</label>
													<!-- <input type="text" name="Apartment" id="Apartment"> - - >
													<!-- <div class="custom-select2 form-rounded my-2"> - - >
														<select class="custom-select2" name="apartment" id="add_apartment" style="background-color: #2B2B2B;width: 247px;">
															
														
														<option value="0">--select--</option>
														
														</select>
													<!-- </div> - - >
												</div>
											</div>
										</div>
									</div>-->
								</div>
								<div class="col-12  col-sm-6 col-md-6 col-lg-4 col-xl-4">
									<div class="profile-img-holder mb-3">
										<figcaption>Profile Image</figcaption>
										<div id="add-automated-guest-image-preview" class="image-preview">
											<label for="add-automated-guest-image-upload" id="add-automated-guest-image-label">ADD IMAGE</label>
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
										<button class="form-btn" type="submit" name="status" value="1">Publish</button>
										<button class="form-btn" type="submit" name="status" value="0">Draft</button>
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
<!--Add employee  model end -->
<!--Add employee  model start -->
<div class="modal fade" id="edit-employee"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog ">

		<div class="modal-content border-0 bg-transparent">
			<div class="modal-body">
				<div class="container-fluid px-0">
					<div class="scnd-type-modal-form-wrapper extra-width">
						<form method="post" action="{{route('admin.addEmployee')}}" enctype="multipart/form-data" id="editform">
                 			{{csrf_field()}}
                 			<input type="hidden" name="employeeid" id="employee_id">
							  <button type="button" class="btn-close-modal float-sm-end mt-0  me-4 me-sm-0 float-start " data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
							<h2 class="form-caption">Edit Employee</h2>

							<div class="row">
								<div class="col-12  col-lg-12 col-xl-8">
									<!-- frst row -->
									<div class="row">
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label for="epmid">Employee ID</label>
												<input type="text" name="emp_id" id="emp_id">
											</div>
										</div>
										<div class="col-sm-6 col-12">

											<div class="input-field-group">
												<label for="username">Name</label>
												<input type="text" name="name" id="name">
											</div>
										</div>
									</div>
									<!-- thrd row -->
									<div class="row">
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label for="Email">Email</label>
												<input type="email" name="email" id="email">
											</div>
										</div>
										<div class="col-sm-6 col-12">
											<div class="custom-drop">
												<div class="input-field-group">
													<label for="Password">Password</label>
													<input type="password" name="password" id="password">
												</div>
											</div>
										</div>
									</div>

									<!-- scnd row -->
									<div class="row">
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label for="Job-Role">Job Role</label>
												<input type="text" name="job_role" id="job_role">
											</div>
										</div>
										<div class="col-sm-6 col-12 service-select">

											<div class="input-field-group">
												<label for="AccessType">Access Type</label>
																<select id="access_type" name="access_type" class="custom-select2" style="background-color: #2B2B2B;width: 247px;" required>
														
													@foreach(\App\Models\Employee::$roles as $key=>$role)
														<option value="{{$key}}">{{$role}}</option>
													@endforeach
														 
													</select>
											</div>
										</div>
									</div>

									<!-- scnd row -->
									<div class="row">
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label for="BirthDate">Birth Date</label>
												<input type="text" name="dob" id="dob">
											</div>
										</div>
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label for="PhoneNumber">Phone Number</label>
												<input type="text" name="phone" id="phone">
											</div>
										</div>
									</div>




									<!-- frth row -->

									<div class="row">
										<div class="col-sm-6 col-12">
											<div class="input-field-group">
												<label for="username">Office Number</label>
												<input type="text" name="office_number" id="office_number">
											</div>
										</div>
										
										<div class="col-sm-12 col-12 service-select profile-tenant-form">
											<label for="Property">Property</label>
											<div class="property-input-wrapper input-group">
												
												@foreach($properties as $property)
													<div class="property-input-wrapper p-0" style="width: fit-content;">
														<div class="form-check form-check-inline">
														<input class="form-check-input property_radio" name="property[]" type="checkbox" id="edit_property{{$property->id}}" value="{{$property->id}}">	
									                      <label class="form-check-label" for="edit_property{{$property->id}}">{{$property->name}}</label>
									                    </div>
									                </div>
												@endforeach
												<!-- <input type="text" name="Property" id="Property"> -->
												<!-- <div class="custom-select2 form-rounded my-2"> -->

												<!-- </div> -->
											</div>
										</div>
									</div>

									<!-- fifth row - - >
									<div class="row">
										<div class="col-sm-6 col-12 service-select">
											<div class="input-field-group">
												<div class="input-field-group">
													<label for="Apartment">Apartment</label>
													<!-- <input type="text" name="Apartment" id="Apartment"> - - >
													<!-- <div class="custom-select2 form-rounded my-2"> - - >

														<select  name="apartment" id="edit_apartment" class="custom-select2" style="background-color: #2B2B2B;width: 247px;">
															@foreach($apartments as $apartment)
															<option value="{{$apartment->id}}">{{$apartment->name}}</option>
															@endforeach
														</select>
													<!-- </div> - - >
												</div>
											</div>
										</div>
									</div> -->
								</div>
								<div class="col-12  col-sm-6 col-md-6 col-lg-4 col-xl-4">
									<div class="profile-img-holder mb-3">
										<figcaption>Profile Image</figcaption>
										<div id="edit-automated-guest-image-preview" class="image-preview" style="background-size: cover;">
											<label for="add-automated-guest-image-upload" id="edit-automated-guest-image-label">ADD IMAGE</label>
											<div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
											<input type="file" name="image" id="edit-automated-guest-image-upload" />
											<input type="hidden" name="image_1" id="image1">

										</div> 
									</div>
								</div>

							</div>

							<!-- sixth row-->
							<div class="row">
								<div class="col-12">
									<div class="btn-holder">
										<button class="form-btn" type="submit" name="status" value="1">Publish</button>
										<button class="form-btn" type="submit" name="status" value="0">Draft</button>
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
<!--Add employee  model end -->
@endsection
@push('script')
<script type="text/javascript">
    // document.ready function
    $(function() {
        $("#myTable").on("click", ".table-edit", function(e){
        // $('.table-edit').click(function(e) {
            e.preventDefault(); // prevent form from reloading page
          	$('#editform').trigger("reset");
            var id=$(this).attr('id');
			$('#edit-automated-guest-image-upload').prev().removeClass('d-flex justify-content-end');
		  	$("#edit-automated-guest-image-upload").prev().addClass('d-none');
			
            $.ajax({
                url  : "{{route('admin.getEmpolyee')}}",
                type : 'Post',
                data :{'id':id,_token:'{{ csrf_token() }}'},
                dataType: 'json',  
                beforeSend: function(){
				    // Show image container
				    $("#loader").show();
				},  
                success : function(response) {
                    var properties=JSON.parse(response.property_id);
					console.log(properties);
        			$('#employee_id').val(response.id);    
        			$('#emp_id').val(response.emp_id);
        			$('#name').val(response.name);
        			$('#email').val(response.email);
        			$('#job_role').val(response.job_role);
        			$('#access_type').val(response.type);
        			$('#dob').val(response.dob);
        			$('#phone').val(response.phone);
        			$('#office_number').val(response.office_number);
					
					$( ".property-input-wrapper.input-group input" ).each(function( index ) {
					  	$(this).prop("checked", false);
					});
					
					properties.forEach(function(item) {
						// do something with `item`
						$('#edit_property'+item).prop("checked", true);
					});
        			$('#edit_property').val(response.property_id);//.attr("selected", "selected");
        			//$('#edit_apartment').val(response.apartment).attr("selected", "selected");


        			if(response.profile!=null && response.profile!=""){
						$("#edit-automated-guest-image-preview").css("background-image", "url(" + response.profile + ")");
						$("#edit-automated-guest-image-upload").prev().removeClass('d-none');
                        $("#edit-automated-guest-image-upload").prev().addClass('d-flex justify-content-end');
	        			//$("#image1").val(response.images[0].id);
        			}
        			else{
        				$("#edit-automated-guest-image-preview").css("background-image", "unset");
	        			//$("#image1").val(0);
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

        var employeeid = button.data('employeeid') 
        var modal = $(this)

        modal.find('.modal-body #employeeid').val(employeeid);
    })
</script>
<script type="text/javascript">
	 $(document).ready(function(){

      $.uploadPreview({
          input_field: "#add-automated-guest-image-upload",
          preview_box: "#add-automated-guest-image-preview",
          label_field: "#add-automated-guest-image-upload"
        });

        $.uploadPreview({
          input_field: "#edit-automated-guest-image-upload",
          preview_box: "#edit-automated-guest-image-preview",
          label_field: "#edit-automated-guest-image-upload"
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
<script type="text/javascript">
	$(document).ready(function(){
		$('#add_property').change(function(){
			// alert("here");
			var id=$(this).val();
			// alert(id);
			$('#add_apartment').find('option').remove();

			$.ajax({
				url  : "{{route('admin.ajaxGetProperty')}}",
		        type : "get",
		        data :{'id':id,_token:'{{ csrf_token() }}'},
				dataType: "json",
				success:function(response){

					var len=0;

					if(response['data']!=null){

						len=response['data'].length;
					}
					if(len>0){

						for(var i=0;i<len;i++){

							var id=response['data'][i].id;

							var name=response['data'][i].name;
							
							var option="<option value='"+id+"'>"+name+"</option>";

							$('#add_apartment').append(option);
						}
					}
				}
			})
		})
	});	
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#edit_property').change(function(){
			// alert("here");
			var id=$(this).val();
			// alert(id);
			$('#edit_apartment').find('option').remove();

			$.ajax({
				url  : "{{route('admin.ajaxGetProperty')}}",
		        type : "get",
		        data :{'id':id,_token:'{{ csrf_token() }}'},
				dataType: "json",
				success:function(response){

					var len=0;

					if(response['data']!=null){

						len=response['data'].length;
					}
					if(len>0){

						for(var i=0;i<len;i++){

							var id=response['data'][i].id;

							var name=response['data'][i].name;
							
							var option="<option value='"+id+"'>"+name+"</option>";

							$('#edit_apartment').append(option);
						}
					}
				}
			})
		})
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