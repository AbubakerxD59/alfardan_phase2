<div class="scnd-type-modal-form-wrapper more-extra-width service-select" >

	<form method="post" enctype="multipart/form-data" action="{{route('admin.users.update',[$user->id])}}" id="editform">
		{{csrf_field()}}
		{{ method_field('PATCH') }}
		<h2 class="form-caption">Edit User</h2>
		<button type="button" class="btn-close-modal float-end mt-0 me-0" data-bs-dismiss="modal" aria-label="Close">
			<i class="far fa-times-circle"></i>
		</button>
		<div class="row">
			<div class="col-xl-4 col-lg-4 col-md-5">
				<div class="row">
					<div class="input-field-group ">
						<label for="username">Full Name</label>
						<input class="w-100" type="text" name="full_name" id="full_name" value="{{$user->full_name}}">
					</div>
					<div class="input-field-group">
						<label for="username">Email</label>
						<input class="w-100" type="email" name="email" id="email"  value="{{$user->email}}" required>
				   </div>

					<div class="input-field-group">
						<label for="username">Phone Number</label>
						<input class="w-100" type="text" name="mobile" id="mobile"  value="{{$user->mobile}}" required>
					</div>

					<div class="input-field-group">
						<label for="dob">Date of Birth</label>
						<input class="w-100" type="date" name="dob" id="dob" value="{{$user->dob}}">
					</div>

					<div class="input-field-group">
						<label for="username">Start Date</label>
						<input class="w-100" type="date" name="start_date" id="start_date"  value="{{$user->start_date}}">
					</div>

					<div class="input-field-group">
						<label for="username">End Date</label>
						<input class="w-100" type="date" name="end_date" id="end_date"  value="{{$user->end_date}}">
					</div>


					<div class="input-field-group">
						<label class="text-white" for="registered_as">Registered As</label>
						<select class="custom-select2 w-100 registered_as" id="registered_as" name="registered_as" style="background-color: #2B2B2B;">
							<option value="FAMILY MEMBER" 
									{{strtolower($user->registered_as)==strtolower('FAMILY MEMBER')?'selected':''}}>Family Member</option>
							<option value="CORPORATE" 
									{{strtolower($user->registered_as)==strtolower('CORPORATE')?'selected':''}}>Corporate</option>
							<option value="INDIVIDUAL" 
									{{strtolower($user->registered_as)==strtolower('INDIVIDUAL')?'selected':''}}>Individual</option>
						</select>
					</div>
					
					<div class="input-field-group">
						<label class="text-white" for="leasing_type">Leasing Type</label>
						<select class="custom-select2 leasing_type w-100" id="leasing_type" name="type" style="background-color: #2B2B2B;">

							<option value="">Select Leasing Type</option>

							  <option value="CORPORATE" {{strtolower($user->type)==strtolower('CORPORATE')?'selected':''}}>Corporate</option>
							  <option value="INDIVIDUAL" {{strtolower($user->type)==strtolower('INDIVIDUAL')?'selected':''}}>Individual</option>
						</select>
					</div>
		 
			
				<div class="input-field-group">
					<label class="text-white" for="Apartment">Apartment</label>
					<select  name="apartment" id="edit_apartment" class="custom-select2 w-100 apartment" style="background-color: #2B2B2B;" required>
						<?php
							if($user->userpropertyrelation){
								$apartments=$apartments->where('property_id',$user->userpropertyrelation->property_id);
							}
						?>
						@foreach($apartments as $apartment)
						<option value="{{$apartment->id}}"
								{{@$user->userpropertyrelation->apartment_id==$apartment->id?'selected':''}}>{{$apartment->name}}</option>
						@endforeach
					</select>
				</div>
				
					
					<div class="input-field-group">
						<label >N0. of Users</label>
						<input class="w-100" type="text"  value="{{$user->families->count()}}">
					</div>
			  </div>
		</div>
		<div class=" col-xl-8 col-lg-8 ps-xl-0 ps-lg-5 col-md-7">
			<div class="row">
				<div class="col-xl-5 col-lg-6">
					<div class="profile-img-holder mb-3">
						<figcaption>Images</figcaption>
							<div id="profile-img-preview" for="edit-profile-upload-modal" class="image-preview " 
						 @if($user->profile)
						 	style="background: url({{$user->profile}});background-size: cover;"
						 @endif
						 >
						<label class="text-uppercase" for="edit-profile-upload-modal">ADD IMAGE</label>
						<div class="delete-image {{$user->profile?'':'d-none'}}" style="cursor: pointer;"><span>x</span></div>
						<input type="file" name="image" id="edit-profile-upload-modal" />
					</div>
					</div>
				</div>
			</div>
			<div class="radio-input-group mb-lg-3 mb-md-0">
				<h2>Tenant</h2>
				<div class="form-check form-check-inline profile-tenant-form">
					<input class="form-check-input tenantcheck" name="tenant_type" type="radio" id="elite" value="Elite" 
						   {{strtolower($user->tenant_type)==strtolower('Elite')?'checked':''}}>
					<label class="form-check-label" for="elite">Elite</label>
				</div>

				<div class="form-check form-check-inline profile-tenant-form">
					<input class="form-check-input tenantcheck" name="tenant_type" type="radio" id="regular" value="Regular"
						   {{strtolower($user->tenant_type)==strtolower('Regular')?'checked':''}}>
					<label class="form-check-label" for="regular">Regular</label>
				</div>


				<h2>Property</h2>
				<?php $i=1?>
				<div class="editc">
					@foreach ($properties as $property)
					<div class="form-check form-check-inline property profile-tenant-form">
						<input class="form-check-input property_radio" name="property"
							   type="radio" id="property{{ $property->id }}"
							   {{@$user->userpropertyrelation->property_id==$property->id?'checked':''}}
							   value="{{ $property->id }}">
						<label class="form-check-label"
							   for="property{{ $property->id }}">{{ $property->name }}</label>
					</div>
					<?php $i++; ?>
					@endforeach
				</div>
			</div>
	 
		</div>
	</div>

		<div class="col-xl-12 mt-auto">
			<div class="btn-holder">
				<button class="form-btn" type="submit" id="submit">Publish</button>
				<a href="#">Draft</a>
			</div>
		</div>
	</form>
</div>