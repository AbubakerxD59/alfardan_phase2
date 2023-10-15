@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Tenant')

@section('content')


<main class="col-md-12 ms-lg-auto col-lg-10 px-md-4 pt-5 position">
@include('notification.notify')
  @if($errors->any())
      @foreach($errors->all() as $error)
        <div class="alert alert-danger">
          {{$error}}
        </div>
      @endforeach
    @endif
	<h2 class="table-cap  mb-2">Become Tenant Requests</h2>
	  <ul class="nav nav-tabs mb-2" id="myTab" role="tablist">
		  <li class="nav-item" role="presentation">
			  <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" 
					  	aria-controls="home" aria-selected="true">All Requests</button>
		  </li>
    	  <li class="nav-item" role="presentation">
      		<button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" 
					aria-controls="profile" aria-selected="false">Family Member Requests</button>
    	</li>
 
  </ul>
	
	
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
		<div class=" table-responsive tenant-table tanent-request-wrapper">

			<table class="table  table-bordered" id="users-table">
				<thead>
					<tr>
						<th>User Name</th>
						<th scope="col"><span>Email</span></th>
						<th scope="col"><span>Start Date</span></th>
						<th scope="col"><span>Date of Birth</span></th>
						<th scope="col"><span>Phone Number</span></th>
						<th scope="col"><span>Leasing Type</span></th>
						<th scope="col"><span>Registered AS</span></th>
						<th scope="col"><Span>Tenant Type</Span></th>
						<th scope="col"><span>Property</span></th>
						<th scope="col"><span>Apartment</span></th>
						<th></th>
						<th></th>
					</tr>
				</thead>

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
			</table>
		  </div>
		</div>
	</div>
</main>



@include('admin.users.modals.allmodals');

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
	            <button type="Submit" 
					style="color: #fff;font-size: 18px;
					max-width: 133px;height: 37px;
					padding: 7px 32px;border: 1px solid #C89328;
					text-transform: uppercase;background: #C89328;">
	            send</button>
         	  </div>
         	</form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Rejection modal end -->


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
                </div>
                <div class="col-sm-6 col-12">
                  <div class="input-field-group">
                    <label for="phonenumber">Phone Number</label>
                    <input type="text" name="phone" id="phone" required="required">
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
@endsection
@push('script')
<script type="text/javascript">
    
  jQuery(function() {
	  $('#users-table').DataTable({
              "paging": true,
		  	  'iDisplayLength': 25,
              "lengthChange": true,
              "searching": true,
              "ordering": true,
              "info": true,
              "autoWidth": false,
              "responsive": true,
              "processing": false,
              "serverSide": true,
			   "createdRow": function( row, data, dataIndex){
				   $(row).addClass(data.rowclass); 
				},
               ajax: { 
				    beforeSend: function() {
                        // Show image container
                        $("#loader").show();
                    },
				   url: "{{route('admin.users.listing')}}",
				   data: function ( d ) {
				   		d.requestonly=1;
				   },
				   complete:function(data){
						// Hide image container
						$("#loader").hide();
				   }
			   	},
                 columns: [
                    { data:'full_name',
					 "render": function ( data, type, row, meta) { 
						 return '<a href="{{route('admin.users.index')}}/'+row.id+'">'+data+'</a>';
					 }}, 
                    { data: 'email'},
                    { data: 'start_date' },
                    { data: 'dob'},
                    { data: 'mobile' },
                    { data: 'type' },
                    { data: 'registered_as'},
                    { data: 'tenant_type'},
                    { data: 'userpropertyrelation',
					 orderable: false, 
					 "render": function (data) {return data?data.property?data.property.name:'-':'-'; }
					},
                    { data: 'userpropertyrelation',
					 orderable: false, 
					 "render": function (data) {return data?data.apartment?data.apartment.name:'-':'-'; }
					},
					{ data: 'id',
					 orderable: false, 
					 "render": function (data) {return '<a href="/public/admin/accept_tenant_request/'+data+'" >Accept</a>'; }
					},
					{ data: 'id',
					 orderable: false, 
					 "render": function (data) {return '<span data-userid="'+data+'"  data-bs-toggle="modal" 																		data-bs-target="#reject-item" style="cursor: pointer;">Reject</span>'; }
					},
					{ data: 'id',
					 orderable: false, 
					 "render": function (data) {return '<span class="table-edit" id="'+data+'"  data-bs-toggle="modal" 																		data-bs-target="#editUser" style="cursor: pointer;">EDIT</span>'; }
					}
                 ],
            });
	  
	  
	  
	  $('#familyTable').DataTable({
              "paging": true,
		  	  'iDisplayLength': 25,
              "lengthChange": true,
              "searching": true,
              "ordering": true,
              "info": true,
              "autoWidth": false,
              "responsive": true,
              "processing": false,
              "serverSide": true,
			   "createdRow": function( row, data, dataIndex){
				   $(row).addClass(data.rowclass); 
				},
               ajax: { 
				    beforeSend: function() {
                        // Show image container
                        $("#loader").show();
                    },
				   url: "{{route('admin.users.familylisting')}}",
				   data: function ( d ) {
				   		d.requestonly=1;
				   },
				   complete:function(data){
						// Hide image container
						$("#loader").hide();
				   }
			   	},
                 columns: [
                    { data:'name'}, 
                    { data: 'user', orderable: false, 
					 "render": function (data) {return data?data.full_name:'-'; } },
                    { data: 'id', orderable: false, "render": function (data) {return 'Family Member';} },
                    { data: 'email'},
                    { data: 'phone_number' },
                    { data: 'created_at', name:'created_at', 
					 "render": function (data, type, row, meta) {return row.submitted_date; }  },
					 { data: 'id',
					  "render": function (data, type, row, meta) {
						  return '<a href="accept_family_request/'+data+'" class=" fw-bold">ACCEPT</a> ' }},
					 { data: 'id',
					  "render": function (data, type, row, meta) {
						  return '<button class="btn-bg2 text-capitalize" data-bs-toggle="modal" data-bs-target="#family-reject-item"  title="Reject" data-familyid="'+data+'" style="background: none;border: none;color: #fff;">reject</button> ' }},
					 { data: 'id',
					 orderable: false, 
					 "render": function (data) {return '<span class="text-capitalize family-edit" id="'+data+'" data-bs-toggle="modal" data-bs-target="#editfamilymember" style="cursor: pointer;">EDIT</span>'; }},
                 ],
            });
	  
	$('#reject-item').on('show.bs.modal', function (event){
		var button = $(event.relatedTarget);
		var userid = button.data('userid');
		var modal = $(this);
		modal.find('.modal-body #userid').val(userid);
	});
	  
	$('#family-reject-item').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var familyid = button.data('familyid');
    	var modal = $(this);
    	modal.find('.modal-body #familyid').val(familyid);
  	}); 
	  
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
  
</script>

@include('admin.users.modals.allmodalsscript');

<style>
	table.dataTable tbody tr.bg-danger {
		background-color: #dc3545!important;
	}
	
	table.dataTable tbody tr.bg-warning {
    	background-color: #a68216!important;
	}
</style>
@endpush