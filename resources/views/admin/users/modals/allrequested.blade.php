<div class="scnd-type-modal-form-wrapper service-select" >

	<form method="post" enctype="multipart/form-data" action="{{route('admin.users.update',[$user->id])}}" id="editform">
		{{csrf_field()}}
		{{ method_field('PATCH') }}
                    
              <button type="button" class="btn-close-modal float-end mt-0 me-0" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
            <h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">Edit Tenant Request</h2>
              <!-- frst row -->
              <div class="row">
                <div class="col-sm-6 col-12">
                  <div class="input-field-group">
                    <label for="username">User Name</label>
                    <input type="text" name="full_name" id="full_name" value="{{$user->full_name}}" required>
                  </div>
					
                  <div class="input-field-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{$user->email}}" required>
                  </div>
					
				  <div class="input-field-group">
                    <label for="startDate">Start Date</label>
                    <input type="date" name="start_date" id="start_date"  value="{{$user->start_date}}" required>
                  </div>
					
					<label class="text-white" for="TenantType">Registered As</label>
                  <!-- <div class="custom-select2 form-rounded my-2"> -->
                    <select class="custom-select2 registered_as" id="registered_as" name="registered_as" style="background-color: #2B2B2B;width: 247px;" required>
                     <option value="FAMILY MEMBER" 
									{{strtolower($user->registered_as)==strtolower('FAMILY MEMBER')?'selected':''}}>Family Member</option>
							<option value="CORPORATE" 
									{{strtolower($user->registered_as)==strtolower('CORPORATE')?'selected':''}}>Corporate</option>
							<option value="INDIVIDUAL" 
									{{strtolower($user->registered_as)==strtolower('INDIVIDUAL')?'selected':''}}>Individual</option>
               		</select>
					
                  <label class="text-white" for="Property">Property</label>
                  	<div class="editc">
						<select id="edit_property" name="property" class="custom-select2 property " style="background-color: #2B2B2B;width: 247px;" required>
						@foreach($properties as $property)
						<option value="{{$property->id}}"
							  {{@$user->userpropertyrelation->property_id==@$property->id?'selected':''}}>{{@$property->name}}</option>
						@endforeach
						</select>
					</div>
					
					<label class="text-white" for="TenantType">Tenant Type</label>
                 <!--  <div class="custom-select2 form-rounded my-2"> -->
                    <select class="custom-select2" id="tenant_type" name="tenant_type" style="background-color: #2B2B2B;width: 247px;" required>
                      <option value="">select Tenant Type</option>  
						<option value="Elite" 
							  {{strtolower($user->tenant_type)==strtolower('Elite')?'selected':''}}>Elite</option>
                      <option value="Regular"
							  {{strtolower($user->tenant_type)==strtolower('Regular')?'selected':''}}>Regular</option>
                    </select>
                  <!-- </div> -->
					
                  
                  <div class="input-field-group">
                    <label for="Dob">Date of Birth</label>
                    <input type="date" name="dob" id="dob" 
						   @if(!empty($user->dob) && $user->dob!='1999')
						   		value="{{date_format(date_create_from_format('m-d-Y',$user->dob), 'Y-m-d')}}"  
						 	@endif
						   required>
                  </div>

                   <div class="input-field-group">
                    <label for="Dob">Date Submitted</label>
                    <input type="text" name="submit_date" id="created_at"  value="{{$user->created_at}}"  readonly>
                  </div>
					
					
                  <div class="input-field-group upload-pdf">
                    <label for="Contract">Contract</label>
                    <!-- <input type="text" name="contract" id="Contract"> -->
                    <span class="input-group-btn">
                      <div class="btn btn-default browse-button2">
                       <!-- <label class="px-2 text-white">Contract</label> -->
                       <span class="browse-button-text2 text-white">
                        <i class="fa fa-folder-open"></i> Browse</span>
                        <input type="file" accept=".pdf" id="file" name="contract"/ >
                      </div>
                      <button type="button" class="btn btn-default clear-button" style="display:none;color: #fff;">
                        <span class="fa fa-times"></span> Clear
                      </button>
                    </span>
                    <input type="text" class="form-control filename2 add-btn" value="{{$user->contract}}" id="contract" 
						   disabled="disabled" style="{{$user->contract?'text-transform: lowercase;':'display:  none;'}} "  >
                    <span class="input-group-btn"></span>
                  </div>
                </div>
                <div class="col-sm-6 col-12">
                          <!-- </div> -->
					
					@if(strtolower($user->registered_as)==strtolower('FAMILY MEMBER'))
						<label class="text-white" for="original_tenant_name">Tenant Name</label>
					 <!--  <div class="custom-select2 form-rounded my-2"> -->
						<select class="custom-select2" id="linkfamily" name="linkfamily" style="background-color: #2B2B2B;width: 247px;" required disabled>
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
					<div class="input-field-group">
						<label class="text-white" for="TenantName">Tenant Name</label>
						<input type="text" name="original_tenant_name" id="original_tenant_name"  value="{{$user->original_tenant_name??$user->full_name}}" required>
                </div>
					
					@endif
					
					
                
					
					
					
                   <div class="input-field-group">
                    <label for="Password">Password</label>
                    <input type="password" name="password" id="password">
                  </div>
                  <div class="input-field-group">
                    <label for="startDate">End Date</label>
                    <input type="date" name="end_date" id="end_date"  value="{{$user->end_date}}" required>
                  </div>
      
					 
					<label class="text-white" for="type">Leasing Type</label>
                  <!-- <div class="custom-select2 form-rounded my-2"> -->
                    <select class="custom-select2 leasing_type" id="leasing_type" name="type" style="background-color: #2B2B2B;width: 247px;" required>
                      <option value="">Select Leasing Type</option>
                      <option value="CORPORATE" {{strtolower($user->type)==strtolower('CORPORATE')?'selected':''}}>Corporate</option>
					  <option value="INDIVIDUAL" {{strtolower($user->type)==strtolower('INDIVIDUAL')?'selected':''}}>Individual</option>
               		</select>
				<label class="text-white" for="Apartment">Apartment</label>
                  <select  name="apartment" id="edit_apartment" class="custom-select2 apartment" style="background-color: #2B2B2B;width: 247px;" required>
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
                
      
				<div class="input-field-group">
					<label class="text-white" for="TenantName">Company Name</label>
                  	<input type="text" name="company_name" id="company_name" value="{{$user->company_name}}"  >
            	</div>
                   <div class="input-field-group">
                    <label for="phonenumber">Phone Number</label>
                    <input type="text" name="mobile" id="mobile"  value="{{$user->mobile}}"  required>
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