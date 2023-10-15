<div class="scnd-type-modal-form-wrapper service-select">
	<form method="post" enctype="multipart/form-data" action="{{route('admin.users.update',[$user->id])}}" id="editform">
		{{csrf_field()}}
		{{ method_field('PATCH') }}
		<button type="button" class="btn-close-modal float-end mt-0 me-0" data-bs-dismiss="modal" aria-label="Close">
			<i class="far fa-times-circle"></i>
		</button>
		<h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">Edit Family Member</h2>
		<div class="row">
			<div class="col-sm-6 col-12">
				<div class="input-field-group">
					<label for="username">User Name</label>
					<input type="text" name="full_name" id="full_name" value="{{$user->full_name}}" required="required">
				</div>
				<div class="input-field-group">
					<label for="email">Email</label>
					<input type="email" name="email" id="email" value="{{$user->email}}"  required="required">
				</div>
				<div class="input-field-group">
					<label for="phonenumber">Phone Number</label>
					<input type="text" name="mobile" id="mobile" value="{{$user->mobile}}"  required="required">
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
					<label class="text-white" for="registered_as">Registered As</label>
					<select class="custom-select2 registered_as" id="registered_as" name="registered_as" style="background-color: #2B2B2B;width: 247px;">
						 <option value="FAMILY MEMBER" 
								 {{strtolower($user->registered_as)==strtolower('FAMILY MEMBER')?'selected':''}}>Family Member</option>
						 <option value="CORPORATE" 
								 {{strtolower($user->registered_as)==strtolower('CORPORATE')?'selected':''}}>Corporate</option>
						 <option value="INDIVIDUAL" 
								 {{strtolower($user->registered_as)==strtolower('INDIVIDUAL')?'selected':''}}>Individual</option>
					
					</select>
					<!-- </div> -->
				</div>
				<div class="input-field-group">
					<label class="text-white" for="leasing_type">Leasing Type</label>
					<select class="custom-select2 leasing_type" id="leasing_type" name="type" style="background-color: #2B2B2B;width: 247px;">
						  
						<option value="">Select Leasing Type</option>
					 
						  <option value="CORPORATE" {{strtolower($user->type)==strtolower('CORPORATE')?'selected':''}}>Corporate</option>
						  <option value="INDIVIDUAL" {{strtolower($user->type)==strtolower('INDIVIDUAL')?'selected':''}}>Individual</option>
					</select>
					<!-- </div> -->
				</div>
				
				
				<div class="input-field-group">
					<label class="text-white" for="property">Property</label>
					<!-- <div class="custom-select2 form-rounded my-2"> -->
					<select class="custom-select2 property" id="property" name="property" style="background-color: #2B2B2B;width: 247px;" disabled>
						@foreach($properties as $property)
							<option value="{{$property->id}}" {{@$user->userpropertyrelation->property_id==$property->id?'selected':''}} >{{$property->name}}</option>
						@endforeach
					</select>
				<!-- </div> -->
			</div>
			
			<div class="input-field-group">
				<label class="text-white" for="Apartment">Apartment</label>
				<select  name="apartment" id="edit_apartment" class="custom-select2 apartment" style="background-color: #2B2B2B;width: 247px;" required disabled>
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
					<label class="text-white" for="TenantName">Tenant Name</label>
					@if($user->status) 
				 		<select class="custom-select2" id="linkfamily" name="linkfamily" style="background-color: #2B2B2B;width: 247px;" disabled>
						  <option value="">Select Tenant</option>  
							@foreach($userslist->where('registered_as','!=','FAMILY MEMBER') as $tuser)
								<option value="{{$tuser->id}}"
										@if($user->linkfamily)
										{{$user->linkfamily->refrence_id==$tuser->id?'selected':''}}
										@else
										{{@$user->familylink->refrence_id==$tuser->id?'selected':''}}
										@endif
										>{{$tuser->full_name}}</option>  
							@endforeach
							 
						</select>
					@else
						<input type="text" value="{{$user->original_tenant_name}}" readonly>
					@endif
					
					<!-- </div> -->
				</div>
				
			</div>
			<div class="col-sm-6 col-12">
				<div class="add-event-img-holder add-event-img-holder  mb-3">
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