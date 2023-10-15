@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Tenant Request')

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
	<h2 class="table-cap pb-1 mb-2">Become Tenant Requests</h2>
  <!-- tabs start -->
  <ul class="nav nav-tabs mb-2" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">All Requests</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Family Member Requests</button>
    </li>
   <!--  <li class="nav-item" role="presentation">
      <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Corporate Requests</button>
    </li> -->
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
     <div class=" table-responsive tenant-table tanent-request-wrapper">
        <table class="table  table-bordered" id="myTable">
          <thead>
            <tr>
              <th>User Name</th>
              <th scope="col"><span>Email</span></th>
              <!-- <th scope="col"><span>Password</span></th> -->
              <th scope="col"><span>Date of Birth</span></th>
              <th scope="col"><span>Start Date</span></th>
              <th scope="col"><span>Phone Number</span></th>
              <th scope="col"><span>Tenant Type</span></th>
              <th scope="col"><span>Leasing Type</span></th>
              <th scope="col"><span>Property</span></th>
              <th scope="col"><span>Apartment</span></th>
              <th scope="col"><span>Registered As</span></th>
              <th scope="col"><span>Date Submitted</span></th>
              <th style="background: transparent;"></th>
              <th style="background: transparent;"></th>
              <th style="background: transparent;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $key => $user)

            <tr>
              <td>{{$user->full_name}}</td>
              <td>{{$user->email}}</td>
              <td>{{$user->dob}}</td>
              <td>{{$user->start_date}}</td>
              <td>{{$user->mobile}}</td>
              <td>{{$user->tenant_type}}</td>
              <td>@if($user->type=='FAMILY MEMBER') - @else{{$user->type}} @endif</td>
              <td>{{@$user->userpropertyrelation->property->name}}</td>
              <td>{{@$user->userpropertyrelation->apartment->name}}</td>
              <td>{{$user->registered_as}}</td>
              <td>{{$user->created_at}}</td>
              <td class="tenant-request-btn text-capitalize">
                <a href="{{route('admin.accept_tenant_request', $user->id)}}" type="submit" class=" fw-bold">accept</a> 
              </td> 
              <td>
                <button class="btn-bg2 text-capitalize" data-bs-toggle="modal" data-bs-target="#reject-item"  title='Reject' data-userid="{{$user->id}}" style="background: none;border: none;color: #fff;">reject</button>
              </td>
              <td class="btn-bg2 text-capitalize table-edit" id="{{$user->id}}" data-bs-toggle="modal" data-bs-target="#EditTenantRequest"><a  type="button" class="table-delete fw-bold">edit</a></td>

            </tr>
            @endforeach

          </tbody>
        </table>
      </div>
    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
      <div class=" table-responsive tenant-table tanent-request-wrapper">
        <table class="table  table-bordered" id="familyTable">
          <thead>
            <tr>
              <th scope="col">User Name</th>
              <th scope="col">Tenant Name</th>
              <!-- <th scope="col">Tenant Leasing Type</th> -->
              <th scope="col">Registered As</th>
              <th scope="col"><span>Email</span></th>
              <th scope="col"><span>Phone Number</span></th>
              <th scope="col"><span>Date Submitted</span></th>
              <th style="background: transparent;"></th>
              <th style="background: transparent;"></th>
              <th style="background: transparent;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($families as $key => $family)

            <tr>
              <td>{{$family->name}}</td>
              <td>{{@$family->user->full_name}}</td>
              <!-- <td>{{@$family->user->type}} </td> -->
              <td>Family Member</td>
              <td>{{$family->email}}</td>
              <td>{{$family->phone_number}}</td>
              <td style="background-color: transparent;">{{$family->created_at}}</td>
              <td class="tenant-request-btn text-capitalize" style="background-color: #C89328;border: 1px solid #707070;">
                <a href="{{route('admin.accept_family_request', $family->id)}}" type="submit" class=" fw-bold">accept</a> 
              </td> 
              <td style="background-color: #A0A0A0;border: 1px solid #707070;">
                <button class="btn-bg2 text-capitalize" data-bs-toggle="modal" data-bs-target="#family-reject-item"  title='Reject' data-familyid="{{$family->id}}" style="background: none;border: none;color: #fff;">reject</button>
              </td>
              <td class="btn-bg2 text-capitalize family-edit" id="{{$family->id}}" data-bs-toggle="modal" data-bs-target="#editfamilymember"><a  type="button" class="table-delete fw-bold">edit</a></td>

            </tr>
            @endforeach

          </tbody>
        </table>
      </div>
    </div>
    <!-- <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
     
      <div class=" table-responsive tenant-table tanent-request-wrapper">
          <table class="table  table-bordered" id="corporateTable">
            <thead>
              <tr>
                <th scope="col">User Name</th>
                <th scope="col"><span>Email</span></th>
                <th scope="col"><span>Phone Number</span></th>
                <th scope="col"><span>Property</span></th>
                <th scope="col"><span>Company Name</span></th>
                <th scope="col"><span>Date Submitted</span></th>
                <th style="background: transparent;"></th>
                <th style="background: transparent;"></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($corporates as $key => $corporate)

              <tr>
                <td>{{$corporate->username}}</td>
                <td>{{$corporate->email}}</td>
                <td>{{$corporate->phone_number}}</td>
                <td>{{$corporate->property}}</td>
                <td>{{$corporate->company_name}}</td>
                <td>{{$corporate->created_at}}</td>
                <td class="tenant-request-btn text-capitalize">
                  <a href="{{route('admin.accept_corporate_request', $corporate->id)}}" type="submit" class=" fw-bold">accept</a> 
                </td> 
                <td>
                  <button class="btn-bg2 text-capitalize" data-bs-toggle="modal" data-bs-target="#corporate-reject-item"  title='Reject' data-corporateid="{{$corporate->id}}" style="background: none;border: none;color: #fff;">reject</button>
                </td>
               

              </tr>
              @endforeach

            </tbody>
          </table>
      </div>
     
    </div> -->
  </div>
  <!-- tabs end -->
	<!-- <a class="add-btn my-3" href="#" type="button"  data-bs-toggle="modal" data-bs-target="#add-btn-model">ADD NEW EMPLOYEE</a> -->
	<!-- <div class=" table-responsive tenant-table tanent-request-wrapper">
		<table class="table  table-bordered" id="myTable">
			<thead>
				<tr>
					<th>User Name</th>
					<th scope="col"><span>Email</span></th>
					<th scope="col"><span>Date of Birth</span></th>
					<th scope="col"><span>Start Date</span></th>
					<th scope="col"><span>Phone Number</span></th>
					<th scope="col"><span>Tenant Type</span></th>
					<th scope="col"><span>Leasing Type</span></th>
					<th scope="col"><span>Property</span></th>
					<th scope="col"><span>Apartment</span></th>
					<th scope="col"><span>Date Submitted</span></th>
					<th style="background: transparent;"></th>
					<th style="background: transparent;"></th>
					<th style="background: transparent;"></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($users as $key => $user)
        
				<tr>
					<td>{{$user->full_name}}</td>
					<td>{{$user->email}}</td>
					<td>{{$user->dob}}</td>
          <td>{{$user->start_date}}</td>
					<td>{{$user->mobile}}</td>
          <td>{{$user->tenant_type}}</td>
          <td>{{$user->type}}</td>
					<td>{{$user->property}}</td>
					<td>{{$user->apt_number}}</td>
					<td>{{$user->created_at}}</td>
					<td class="tenant-request-btn text-capitalize">
						<a href="{{route('admin.accept_tenant_request', $user->id)}}" type="submit" class=" fw-bold">accept</a> 
					</td>	
					<td>
						<button class="btn-bg2 text-capitalize" data-bs-toggle="modal" data-bs-target="#reject-item"  title='Reject' data-userid="{{$user->id}}" style="background: none;border: none;color: #fff;">reject</button>
					</td>
					<td class="btn-bg2 text-capitalize table-edit" id="{{$user->id}}" data-bs-toggle="modal" data-bs-target="#EditTenantRequest"><a  type="button" class="table-delete fw-bold">edit</a></td>

				</tr>
				@endforeach

			</tbody>
		</table>
	</div> -->

</main>
<!-- Corporate Rejection  modal start -->
<div class="modal" id="corporate-reject-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-body">
        <div class="reject-content-wrapper">
        <form method="post" action="{{route('admin.reject_corporate_request','corporate')}}">
            {{csrf_field()}}
            <input type="hidden" name="corporateid" id="corporateid" value="">
            <label>Reason For Rejection</label>
            <textarea name="rejection_reason" required="required"></textarea>
            <div class="reject-btn-wrapper">
              <a href="#" type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close">cancel</a>
              <!-- <a href="#">send</a> -->
              <button type="Submit" 
              style="color: #fff;
              font-size: 18px;
              max-width: 133px;
              height: 37px;
              padding: 7px 32px;
              border: 1px solid #C89328;
              text-transform: uppercase;
              background: #C89328;">
              send</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Rejection modal end -->
<!-- Family Rejection  modal start -->
<div class="modal" id="family-reject-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-body">
        <div class="reject-content-wrapper">
        <form method="post" action="{{route('admin.reject_family_request','family')}}">
            {{csrf_field()}}
            <input type="hidden" name="familyid" id="familyid" value="">
            <label>Reason For Rejection</label>
            <textarea name="rejection_reason" required="required"></textarea>
            <div class="reject-btn-wrapper">
              <a href="#" type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close">cancel</a>
              <!-- <a href="#">send</a> -->
              <button type="Submit" 
              style="color: #fff;
              font-size: 18px;
              max-width: 133px;
              height: 37px;
              padding: 7px 32px;
              border: 1px solid #C89328;
              text-transform: uppercase;
              background: #C89328;">
              send</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Rejection modal end -->
<!-- Rejection  modal start -->
<div class="modal" id="reject-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-body">
        <div class="reject-content-wrapper">
	    	<form method="post" action="{{route('admin.reject_tenant_request','user')}}">
	          {{csrf_field()}}
	          <input type="hidden" name="userid" id="userid" value="">
	          <label>Reason For Rejection</label>
	          <textarea name="rejection_reason" required="required"></textarea>
	          <div class="reject-btn-wrapper">
	            <a href="#" type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close">cancel</a>
	            <!-- <a href="#">send</a> -->
	            <button type="Submit" 
	            style="color: #fff;
	            font-size: 18px;
	            max-width: 133px;
	            height: 37px;
	            padding: 7px 32px;
	            border: 1px solid #C89328;
	            text-transform: uppercase;
	            background: #C89328;">
	            send</button>
         	  </div>
         	</form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Rejection modal end -->
<!--edit  model start -->
<div class="modal fade" id="EditTenantRequest"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog ">

    <div class="modal-content border-0 bg-transparent">
      <div class="modal-body service-select">
        <div class="container-fluid px-0">
          <div class="scnd-type-modal-form-wrapper">
            <form method="post" enctype="multipart/form-data" action="{{route('admin.update_tenant_request')}}" id="editform">
              
              {{csrf_field()}}
              <input type="hidden" name="userid" id="user_id" value="">
                    
              <button type="button" class="btn-close-modal float-end mt-0 me-0" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
            <h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">Edit Tenant Request</h2>

              <!-- frst row -->
              <div class="row">
                <div class="col-sm-6 col-12">
                  <div class="input-field-group">
                    <label for="username">User Name</label>
                    <input type="text" name="username" id="username">
                  </div>
                   <div class="input-field-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                  </div>
                   <div class="input-field-group">
                    <label for="Dob">Date of Birth</label>
                    <input type="date" name="dob" id="dob" required>
                  </div>
                   <div class="input-field-group">
                    <label for="phonenumber">Phone Number</label>
                    <input type="text" name="mobile" id="mobile" required>
                  </div>
                  <label class="text-white" for="Apartment">Apartment</label>
                  <select  name="apartment" id="edit_apartment" class="custom-select2" style="background-color: #2B2B2B;width: 247px;">
                    @foreach($apartments as $apartment)
                    <option value="{{$apartment->id}}">{{$apartment->name}}</option>
                    @endforeach
                  </select>
                 <!--  <div class="custom-select2 form-rounded my-2">
                    <select id="Apartment" name="Apartment">
                      <option value="0" selected></option>
                      <option value="1">Apartment 1</option>
                      <option value="2">Apartment 2</option>
                      <option value="3">Apartment 3</option>
                      <option value="4">Apartment 4</option>
                      <option value="5">Apartment 5</option>
                      <option value="6">Apartment 6</option>
                      <option value="7">Apartment 7</option>

                    </select>
                  </div> -->
                   <div class="input-field-group">
                    <label for="Dob">Date Submitted</label>
                    <input type="text" name="submit_date" id="created_at" >
                  </div>
                  <label class="text-white" for="TenantType">Tenant Type</label>
                 <!--  <div class="custom-select2 form-rounded my-2"> -->
                    <select class="custom-select2" id="tenant_type" name="tenant_type" style="background-color: #2B2B2B;width: 247px;">
                      <option value="Elite">Elite</option>
                      <option value="Regular">Regular</option>
                      <!--<option value="Privilege">Privilege</option>-->

                    </select>
                  <!-- </div> -->
                  <div class="input-field-group">
                    <label for="startDate">End Date</label>
                    <input type="date" name="end_date" id="end_date">
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
                    <input type="text" class="form-control filename2 add-btn" id="contract" disabled="disabled" style=" display:  none;"  >
                    <span class="input-group-btn"></span>
                  </div>
                </div>
                <div class="col-sm-6 col-12">
                  <div class="input-field-group">
                    <label for="Name">Name</label>
                    <input type="text" name="name" id="name">
                  </div>
                   <div class="input-field-group">
                    <label for="Password">Password</label>
                    <input type="password" name="password" id="password">
                  </div>
                  <div class="input-field-group">
                    <label for="startDate">Start Date</label>
                    <input type="date" name="start_date" id="start_date">
                  </div>
                  <div class="input-field-group">
                    <label for="LeasingType">Leasing Type</label>
                    <input type="text" name="leasing_type" id="leasing_type" required>
                  </div>
                  <label class="text-white" for="Property">Property</label>
                  	<div class="editc">
						<select id="edit_property" name="property" class="custom-select2" style="background-color: #2B2B2B;width: 247px;">
						@foreach($properties as $property)
						<option id="property{{$property->id}}" value="{{$property->id}}">{{$property->name}}</option>
						@endforeach
						</select>
					</div>
                 <!--  <div class="custom-select2 form-rounded my-2">
                    <select id="Property" name="TenantType">
                      <option value="0" selected></option>
                      <option value="1">Property 1</option>
                      <option value="2">Property 2</option>
                      <option value="3">Property 3</option>
                      <option value="4">Property 4</option>
                      <option value="5">Property 5</option>
                      <option value="6">Property 6</option>
                      <option value="7">Property 7</option>

                    </select>
                  </div> -->
                      <label class="text-white" for="TenantType">Registered As</label>
                  <!-- <div class="custom-select2 form-rounded my-2"> -->
                    <select class="custom-select2" id="registered_as" name="registered_as" style="background-color: #2B2B2B;width: 247px;">
                      <option value="FAMILY MEMBER">Family Member</option>
                      <option value="CORPORATE">Corporate</option>
                      <option value="INDIVIDUAL">Individual</option>
                      

                    </select>
                  <!-- </div> -->
                  <div class="input-field-group">
                  <label class="text-white" for="TenantName">Tenant Name</label>
                  <input type="text" name="tenant_name" id="tenant_name" >

                  </div>
                  <div class="input-field-group">
                  <label class="text-white" for="TenantName">Company Name</label>
                  <input type="text" name="company_name" id="company_name" >

                  </div>
                  <!-- <div class="custom-select2 form-rounded my-2"> -->
                   <!--  <select class="custom-select2" id="tenant_name" name="first_name" style="background-color: #2B2B2B;width: 247px;">
                      @foreach($users as $user)
                      <option value="{{$user->first_name}}">{{$user->first_name}}</option>
                      @endforeach

                    </select> -->
                  <!-- </div> -->
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
<!--edit family member model start -->

<div class="modal fade" id="editfamilymember"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog ">

    <div class="modal-content border-0 bg-transparent">
      <div class="modal-body service-select">
        <div class="container-fluid px-0">
        <div class="scnd-type-modal-form-wrapper">
            <form method="post" action="{{route('admin.addFamilyRequest')}}" enctype="multipart/form-data">
              {{csrf_field()}}
              <input type="hidden" name="familymemberid" id="familymemberid">

              <button type="button" class="btn-close-modal float-end mt-0 me-0" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
              <h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">Edit Family Member Request</h2>

              <div class="row">
                <div class="col-sm-6 col-12">
                  <div class="input-field-group">
                    <label for="username">User Name</label>
                    <input type="text" name="username" id="fname" required="required">
                  </div>
                  <div class="input-field-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="femail"  required="required">
                  </div>
                 <!--  <div class="input-field-group">
                    <label for="phonenumber">Phone Number</label>
                    <input type="text" name="phone" id="phone" required="required">
                  </div> -->
                   
                </div>
                <div class="col-sm-6 col-12">
                  <div class="input-field-group">
                    <label for="phonenumber">Phone Number</label>
                    <input type="text" name="phone" id="phone" required="required">
                  </div>
                 <!--  <div class="input-field-group">
                  <label class="text-white" for="TenantName">Tenant Name</label>
                  <input type="text" name="tename" id="tname" readonly>
                  
                  </div>
                   <div class="input-field-group">
                    <label for="phonenumber">Tenant Registered As</label>
                    <input type="text" name="" id="fregistered_as" readonly>
                  </div>
                   <div class="input-field-group">
                    <label for="phonenumber">Tenant Leasing Type</label>
                    <input type="text" name="" id="type" readonly>
                  </div> -->
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
@endsection
@push('script')
<script type="text/javascript">
	
	// filter apartments on property change
  $('.editc select').on('change',function(e) {
      var allprids = [];
      $('#edit_property :selected').each(function(i, obj) {
          allprids.push($(this).val());
      });
      $.ajax({
          url: "{{ route('admin.apartmentslist') }}",
          type: 'Post',
          data: {
              'ids': allprids,
              _token: '{{ csrf_token() }}'
          },
          dataType: 'json',
          beforeSend: function() {
              // Show image container
              $("#loader").show();
          },
          success: function(response) {
              // console.log(response);
              var aps = $("#edit_apartment").attr("data-apartment_id");
              // console.log(aps);
              
              $("#edit_apartment").html("");
              $("#edit_apartment").val(aps);
              $.each(response, function(index, value) {
                  var option = {
                      value: value.id,
                      text: value.name
                  };
                  console.log(value.id, aps);
                  if (value.id==parseInt(aps)) {
                      option.selected = "selected";
                  }
                  $("#edit_apartment").append($('<option>', option));
              });
          },
          complete: function(data) {
              // Hide image container
              $("#loader").hide();
          }
      });
  });
	
  // document.ready function
  $(function() {
    $("#myTable").on("click", ".table-edit", function(e){
    // $('.table-edit').click(function(e) {
      e.preventDefault(); // prevent form from reloading page
       $('#editform').trigger("reset");
      var id=$(this).attr('id');

      $.ajax({
        url  : "{{route('admin.getUser')}}",
        type : 'Post',
        data :{'id':id,_token:'{{ csrf_token() }}'},
        dataType: 'json',  
        beforeSend: function(){
            // Show image container
            $("#loader").show();
        },   
        success : function(response) {
          $('#user_id').val(response.id);    
          $('#first_name').val(response.first_name);
          $('#last_name').val(response.last_name);
          $('#email').val(response.email);
          $('#mobile').val(response.mobile);
          $('#apt_number').val(response.apt_number);
          $('#start_date').val(response.start_date);
          $('#nom').val(response.nom);
          $('#tenant_name').val(response.original_tenant_name);
          if(response.type){
			 // console.log(response.type);
			  if(response.type.toUpperCase()=='FAMILY MEMBER'){
          		 $('#leasing_type').val('-');
          }
          else{
            $('#leasing_type').val(response.type);
          }
		  }
			
          $('#end_date').val(response.end_date);

          if(response.dob!=null){
            dte = response.dob;//2014-01-06
            dteSplit = dte.split("-");
            yr = dteSplit[2]; //special yr format, take last 2 digits
            month = dteSplit[0];
            day = dteSplit[1];
            finalDate = yr+"-"+month+"-"+day;
            // console.log(dteSplit);
            $('#dob').val(finalDate);
          }
          $('#username').val(response.full_name );
          $('#name').val(response.name );
          if(response.type){
          	if(response.type.toUpperCase()=='FAMILY MEMBER'){
          		$('#tenant_name').val(response.full_name);
          	}
		   }
          $('#company_name').val(response.company_name);
          if(response.registered_as){
            $('#registered_as').val(response.registered_as.toUpperCase());
          }else{
			  if(response.type){
				  $('#registered_as').val(response.type.toUpperCase());
			  }
		  }
          // console.log(response.type.toUpperCase());
          $('#created_at').val(response.created_at);
          if(response.contract!=null){
             $(".filename2").show();
          $('#contract').val(response.contract);
          $('#file').prop('required',false);
          }

			var appid = response.userpropertyrelation.apartment_id;
          $("#edit_apartment option[value='" + appid + "']").attr("selected", "selected");
          $("#edit_apartment").data('val',appid);
          $("#edit_apartment").attr('data-apartment_id',appid);
          var allprids = [response.userpropertyrelation.property_id];
          // console.log(allprids);
            $.each(allprids, function(i, e) {
              console.log(i,e);
                // console.log('prid = '+ response.userpropertyrelation.property_id);
                $(".editc #property" + e).attr("selected", "selected");
                $(".editc #property" + e).trigger('change');
          });
			
         // $('#edit_property').val(response.userpropertyrelation.property_id).attr("selected", "selected");
         // $('#edit_apartment').val(response.userpropertyrelation.apartment_id).attr("selected", "selected");
          $('#tenant_type').val(response.tenant_type).attr("selected", "selected");
          // $('#tenant_name').val(response.id).attr("selected", "selected");

      },
      complete:function(data){
            // Hide image container
            $("#loader").hide();
      }
    });
    });
  });

  $(function() {

    // $('.family-edit').click(function(e) {
       $("#familyTable").on("click", ".family-edit", function(e){
      e.preventDefault(); // prevent form from reloading page

      var id=$(this).attr('id');

      $.ajax({
        url  : "{{route('admin.getFamilyRequest')}}",
        type : 'Post',
        data :{'id':id,_token:'{{ csrf_token() }}'},
        dataType: 'json',    
        success : function(response) {
          $('#familymemberid').val(response.id);        
          $('#fname').val(response.name);
          $('#femail').val(response.email);
          $('#phone').val(response.phone_number);
          // $('#fregistered_as').val(response.user.type);
          // $('#type').val(response.user.type);
          $('#tname').val(response.user.first_name +' '+ response.user.last_name );
          
         
      }
    });
    });
  });
  $('#family-reject-item').on('show.bs.modal', function (event) {

    var button = $(event.relatedTarget) 

    var familyid = button.data('familyid') 
    var modal = $(this)

    modal.find('.modal-body #familyid').val(familyid);
  })
  $('#corporate-reject-item').on('show.bs.modal', function (event) {

    var button = $(event.relatedTarget) 

    var corporateid = button.data('corporateid') 
    var modal = $(this)

    modal.find('.modal-body #corporateid').val(corporateid);
  })
</script>
<script>
  $(document).ready( function () {
    $('#familyTable').DataTable({
      "ordering": false
    });
  });
  $(document).ready( function () {
    $('#corporateTable').DataTable({
      "ordering": false
    });
  });
  // Show filename, show clear button and change browse 
  //button text when a valid extension file is selected
  $(".browse-button2 input:file").change(function (){
    $("input[name='contract']").each(function() {
      var fileName = $(this).val().split('/').pop().split('\\').pop();
      $(".filename2").show();
      $(".filename2").val(fileName);
      $(".browse-button-text2").html('<i class="fa fa-refresh"></i> Change');
      $(".clear-button").show();
    });
  });
  //actions happening when the button is clicked
  $('.clear-button').click(function(){
    $('.filename2').hide();
    $('.filename2').val("");
    $('.clear-button').hide();
    $('.browse-button2 input:file').val("");
    $(".browse-button-text2").html('<i class="fa fa-folder-open"></i> Browse'); 
  });
</script>
@endpush