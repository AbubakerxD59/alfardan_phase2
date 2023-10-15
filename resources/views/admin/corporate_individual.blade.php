@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Corporate Individal')

@section('content')

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position ">
@include('notification.notify')
@if($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">
      {{$error}}
    </div>
  @endforeach
@endif 
	<h2 class="table-cap pb-2">Corporate Individual</h2>
	<a class="add-btn my-3" href="#" type="button"  data-bs-toggle="modal" data-bs-target="#addfamilymember">ADD NEW USER</a>
	<div class=" table-responsive tenant-table">
		<table class="table  table-bordered" id="myTable">
			<thead>
				<tr>
					<th scope="col"><span>User Name</span></th>
					<th scope="col"><span>Email</span></th>
					<th scope="col"><span>Company Name</span></th>
					<th scope="col"><span>Date of Birth</span></th>
					<th scope="col"><span>Phone Number</span></th>
					<!-- <th scope="col"><span>Tel. Number</span></th> -->
					<!-- <th scope="col"><span>Registered As</span></th> -->
					<th scope="col"><span>Leasing Type</span></th>
					<th scope="col"><Span>Tenant Type</Span></th>
					<th scope="col"><span>Property</span></th>
					<th scope="col"><span>Apartment</span></th>
					<th scope="col"><span>No. Of Members</span></th>
					<th style="background: transparent;"></th>
					<th></th>

				</tr>
			</thead>
			<tbody>
				@foreach($corporates as $corporate)
				
				<tr>
					<td><a href="{{route('admin.corporate_view',$corporate->id)}}">{{$corporate->full_name}}  </a></td>
					<td>{{$corporate->email}}</td>
					<td>{{$corporate->company_name}}</td>
					<td>{{@$corporate->dob}}</td>
					<td>{{@$corporate->mobile}}</td>
					
					<!-- <td>{{$corporate->registered_as}}</td> -->
					<td>{{@$corporate->type}}</td>
					<td>{{@$corporate->tenant_type}}</td>
					<td>{{@$corporate->userpropertyrelation->apartment->property->name}}</td>
              		<td>{{@$corporate->userpropertyrelation->apartment->name}}</td>
					<td>{{$corporate->familycount()}}</td>
					<td  class="table-edit fw-bold table-edit" id="{{$corporate->id}}" data-bs-toggle="modal" data-bs-target="#editfamilymember">EDIT</td>
					<td class="btn-bg2"><a  type="button" class="table-delete fw-bold" data-bs-toggle="modal" data-bs-target="#remove-item"  data-corporateid="{{$corporate->id}}">REMOVE</a></td>

				</tr>

				@endforeach
			</tbody>
		</table>
	</div>

</main>
<!--add family member model start -->
<div class="modal fade" id="addfamilymember"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<!--<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-body profile-model">
				<div class="container-fluid px-0">
					<div class="row">
						<div class="col-12">
							<div class="body-wrapper">
								<h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">Add Corporate Individual</h2>
								<button type="button" class="btn-close-modal float-end" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
								 <form method="post" action="{{route('admin.addCorporateIndividual')}}" enctype="multipart/form-data">
                 					{{csrf_field()}}
									<div class="row">
										<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4  ">
											<div class="add-family-form-wrapper ps-2 pe-3">
												<label>User Name</label>
												<input  type="text" name="username">
												<label>Email</label>
												<input  type="email" name="email">
												<label>Phone Number</label>
												<input  type="text" name="phone">
												<label>Tenant Name</label>
												
												<select name="userid" style="width: 100%;margin-bottom: 5px;">
						                          @foreach($users as $user)
						                          <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
						                          @endforeach
						                        </select>
												<label>Property</label>
												<input  type="text" name="property">
												<label>Company Name</label>
												<input  type="text" name="company_name">

											</div>
										</div>
										<div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 ps-4 ">
											<div class="profile-img-holder add-event-img-holder  mb-3">
												<figcaption>Images</figcaption>
												<div id="add-family-img-preview-modal" class="image-preview">
													<label class="text-uppercase" for="add-family-img-upload-modal" id="add-family-img-label-modal">add image</label>
													<input type="file" name="image" id="add-family-img-upload-modal" />
												</div>
											</div>
											<h2>Tenant</h2>
											<div class="profile-tenant-form">
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="radio" id="inlineCheckbox1" name="tenantinput" value="option1">
													<label class="form-check-label" for="inlineCheckbox1">VIP</label>
												</div>

												<div class="form-check form-check-inline">
													<input class="form-check-input" name="tenantinput" type="radio" id="inlineCheckbox2" value="option2">
													<label class="form-check-label" for="inlineCheckbox2">Regular</label>
												</div>

												<div class="form-check form-check-inline mb-2">
													<input class="form-check-input" name="tenantinput" type="radio" id="inlineCheckbox3" value="option3">
													<label class="form-check-label" for="inlineCheckbox3">Non-Tenant</label>
												</div>

												<h2>Property</h2>
												<div class="property-input-wrapper">
													<div class="form-check form-check-inline">
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
													</div>
												</div>
												<div class="form-btn-holder mb-3 text-end  me-xxl-0">
													<button class="form-btn">Publish</button>
													<button class="form-btn">Draft</button>
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
	</div>-->
		<div class="modal-dialog ">

		<div class="modal-content border-0 bg-transparent">
			<div class="modal-body service-select">
				<div class="container-fluid px-0">
					<div class="scnd-type-modal-form-wrapper">
						<form method="post" action="{{route('admin.addCorporateIndividual')}}">
                 		{{csrf_field()}}
						<input type="hidden" name="registeredas" value="CORPORATE">	
						<input type="hidden" name="type" value="CORPORATE">
						<button type="button" class="btn-close-modal float-end mt-0 me-0" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>	
						<h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">Add Corporate Individual</h2>

							<!-- frst row -->
							<div class="row">
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">User Name</label>
										<input type="text" name="username" required>
									</div>
								</div>
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="email">Email</label>
										<input type="email" name="email" required>
									</div>
								</div>
							</div>

							<!-- scnd row -->
							<div class="row">
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="phonenumber">Phone Number</label>
										<input type="text" name="phone" required>
									</div>
								</div>
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
									<label class="text-white" for="TenantName">Tenant Name</label>
									<div class="custom-select2 form-rounded my-2">
										<select id="TenantName" name="userid">
										@foreach($users as $user)
									  	<option value="{{$user->id}}">{{$user->full_name}} </option>
									  @endforeach
										</select>
									</div>
									
									</div>
									
								</div>
							
							</div>

							<!-- thrd row -->
							<div class="row">
								<div class="col-sm-6 col-12">
									<!--<label class="text-white" for="apartment">Apartment</label>
									<div class="custom-select2 form-rounded my-2">
										<select id="apartment" name="apartment">
											<option value="0" selected></option>
											<option value="1">Apartment 1</option>
											<option value="2">Apartment 2</option>
											<option value="3">Apartment 3</option>
											<option value="4">Apartment 4</option>
											<option value="5">Apartment 5</option>
											<option value="6">Apartment 6</option>
											<option value="7">Apartment 7</option>

										</select>
									</div>-->
									<div class="input-field-group">
									<label>Company Name</label>
									<input  type="text" name="company_name" required>
									</div>
								</div>
								<div class="col-sm-6 col-12">
									
									<label class="text-white" for="property">Property</label>
									<div class="custom-select2 form-rounded my-2">
										<select  name="property">
											@foreach($properties as $property)

									  		<option value="{{$property->id}}">{{$property->name}}</option>

										 	@endforeach

										</select>
									</div>
								</div>
							</div>

							<!-- frth row -->
						



							<div class="row py-3">
								<div class="col-12">
									<div class="btn-holder">
										<button type="submit">Publish</button>
										<button type="button">Draft</button>
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
<!--add family member model end -->

<!--edit family member model start -->
<div class="modal fade" id="editfamilymember"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog ">

		<div class="modal-content border-0 bg-transparent">
			<div class="modal-body service-select">
				<div class="container-fluid px-0">
					<div class="scnd-type-modal-form-wrapper">
						<form method="post" action="{{route('admin.addCorporateIndividual')}}" id="editform">
                 			{{csrf_field()}}
              				<input type="hidden" name="corporateid" id="corporateid">
							<button type="button" class="btn-close-modal float-end mt-0 me-0" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
							<h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">Edit Corporate Individual</h2>

							<!-- frst row -->
							<div class="row">
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">User Name</label>
										<input type="text" name="username" id="username" required>
									</div>
								</div>
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="email">Email</label>
										<input type="email" name="email" id="email" required>
									</div>
								</div>
							</div>

							<!-- scnd row -->
							<div class="row">
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="phonenumber">Phone Number</label>
										<input type="text" name="phone" id="phone" required>
									</div>
								</div>
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
									<label class="text-white" for="TenantName">Tenant Name</label>
									<!-- <div class="custom-select2 form-rounded my-2"> -->
										<select class="custom-select2" id="tenant_name" name="userid" style="background-color: #2B2B2B;width: 247px;">
										@foreach($users as $user)
									  	<option value="{{$user->id}}">{{$user->full_name}} </option>
									  @endforeach
										</select>
									<!-- </div> -->
									
									</div>
									
								</div>
							
							</div>

							<!-- thrd row -->
							<div class="row">
								<div class="col-sm-6 col-12">
									<!--<label class="text-white" for="apartment">Apartment</label>
									<div class="custom-select2 form-rounded my-2">
										<select id="apartment" name="apartment">
											<option value="0" selected></option>
											<option value="1">Apartment 1</option>
											<option value="2">Apartment 2</option>
											<option value="3">Apartment 3</option>
											<option value="4">Apartment 4</option>
											<option value="5">Apartment 5</option>
											<option value="6">Apartment 6</option>
											<option value="7">Apartment 7</option>

										</select>
									</div>-->
									<div class="input-field-group">
										<label>Company Name</label>
										<input  type="text" name="company_name" id="company_name" required>
									</div>
								</div>
								<div class="col-sm-6 col-12">
									
									<label class="text-white" for="property">Property</label>
									<!-- <div class="custom-select2 form-rounded my-2"> -->
										<select class="custom-select2" id="property" name="property" style="background-color: #2B2B2B;width: 247px;">
											@foreach($properties as $property)

									  		<option value="{{$property->id}}">{{$property->name}}</option>

										 	@endforeach

										</select>
									<!-- </div> -->
								</div>
							</div>

							<!-- frth row -->
						



							<div class="row py-3">
								<div class="col-12">
									<div class="btn-holder">
										<button type="submit">Publish</button>
										<button type="button">Draft</button>
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
<!--add family member model end -->
<!-- delete modal start -->
<div class="modal remove-item" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-transparent border-0">
      <form method="POST" action="{{ route('admin.deleteCorporate','corporate') }}">
      {{method_field('delete')}}
      {{csrf_field()}}
      <div class="modal-body">
        <div class="remove-content-wrapper">
          <p>Are you sure you want to delete?</p>
          <input type="hidden" name="corporate_id" id="corporate_id" value="">

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
         $("#myTable").on("click", ".table-edit", function(e){
        // $('.table-edit').click(function(e) {
            e.preventDefault(); // prevent form from reloading page
          	$('#editform').trigger("reset");
            var id=$(this).attr('id');

            $.ajax({
                url  : "{{route('admin.getCorporateIndividual')}}",
                type : 'Post',
                data :{'id':id,_token:'{{ csrf_token() }}'},
                dataType: 'json', 
                beforeSend: function(){
				    // Show image container
				    $("#loader").show();
				},   
                success : function(response) {
                        // console.log(response.images[0].path);
        			$('#corporateid').val(response.id);    
        			$('#username').val(response.full_name);
        			$('#email').val(response.email);
        			$('#phone').val(response.mobile);
        			$('#company_name').val(response.company_name);
        			$('#tenant_name').val(response.id).attr("selected", "selected");
        			$('#property').val(response.userpropertyrelation.property_id);

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

        var corporate_id = button.data('corporateid') 
        var modal = $(this)

        modal.find('.modal-body #corporate_id').val(corporate_id);
    })
</script>

@endpush
