
<!-- edit Modal model start -->
<div class="modal fade" id="editUser"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content  bg-transparent border-0">
      <div class="modal-body">
        <div class="container-fluid px-0" id="editUserbody">
          
        </div>
      </div>
    </div>
  </div>
</div>
<!-- edit Modal model start -->


<!-- delete modal start -->
<div class="modal remove-item" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-transparent border-0">
      <form method="POST" action="{{ route('admin.delete_user','user') }}">
      {{method_field('delete')}}
      {{csrf_field()}}
      <div class="modal-body">
        <div class="remove-content-wrapper">
          <p>Are you sure you want to delete?</p>
          <input type="hidden" name="user_id" id="user_id" value="">
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


<!--add family member model start -->
<div class="modal fade" id="addcorporatemember"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
										@foreach($userslist as $user)
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
<!--add corporate member model end -->

<!--add family member model start -->             
   
<div class="modal fade" id="addfamilymember"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog ">

		<div class="modal-content border-0 bg-transparent">
			<div class="modal-body service-select">
				<div class="container-fluid px-0">
					<div class="scnd-type-modal-form-wrapper">
						<form method="post" action="{{route('admin.addFamilyMember')}}" enctype="multipart/form-data">
                 		{{csrf_field()}}
						<input type="hidden" name="registeredas" value="FAMILY MEMBER">	
						<input type="hidden" name="type" value="FAMILY MEMBER">	
						<button type="button" class="btn-close-modal float-end mt-0 me-0" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
						<h2 class="table-cap pb-2 text-capitalize mb-3 mt-3 ">Add Family Member</h2>

							<!-- frst row -->
							<div class="row">
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">User Name</label>
										<input type="text" name="username"  required="required">
									</div>
									<div class="input-field-group">
										<label for="email">Email</label>
										<input type="email" name="email"  required="required">
									</div>
									<div class="input-field-group">
										<label for="phonenumber">Phone Number</label>
										<input type="text" name="phone"  required="required">
									</div>
										<div class="input-field-group">
									<label class="text-white" for="TenantName">Tenant Name</label>
									<div class="custom-select2 form-rounded my-2">
										<select id="TenantName" name="userid">
										@foreach($userslist as $user)
											<option value="{{$user->id}}">{{$user->full_name}} </option>
										  @endforeach
										</select>
									</div>
									
									</div>
								</div>
								<div class="col-sm-6 col-12">
									<div class="add-event-img-holder add-event-img-holder  mb-3">
		                                <figcaption>Images</figcaption>
		                                <div id="add-family-img-preview-modal" class="image-preview ">
		                                  <label class="text-uppercase" for="add-family-img-upload-modal" id="add-family-img-label-modal">ADD IMAGE</label>
		                                  <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
										  <input type="file" name="image" id="add-family-img-upload-modal" />
		                                </div>
                            		</div>
								</div>
							</div>


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