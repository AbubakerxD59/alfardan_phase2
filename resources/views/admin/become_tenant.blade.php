@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Become Tenant')

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

	<h2 class="table-cap  mb-2">Become A Tenant</h2>
	<div class=" table-responsive tenant-table">
		<table class="table  table-bordered" id="myTable">
			<thead>
				<tr>
					<th>Name</th>
					<th scope="col"><span>Email</span></th>
					<th scope="col"><span>Phone</span></th>
					<th scope="col"><span>No. Of Bedrooms</span></th>
					<th scope="col"><span>Message</span></th>
				
					<th style="background-color: transparent;"></th>
          <th></th>
     


					<!-- <th scope="col"><span>No. Of Members</span></th> -->
					<!-- <th colspan="2"></th> -->
				</tr>
			</thead>
			<tbody>
        @foreach ($tenants as $key => $tenant)
        <tr>
		      <td><a href="" >{{$tenant->fullname}}</a></td>
          <td>{{$tenant->email}}</td>
          <td>{{$tenant->phone}}</td>
          <td>{{$tenant->bedrooms}}</td>
          <td>{{$tenant->message}}</td>
          <td class="btn-bg1 table-edit" id="{{$tenant->id}}"  data-bs-toggle="modal" data-bs-target="#editUser" style="cursor: pointer;" >EDIT </td>
            
          <td>
              
            <button class="fw-bold" data-bs-toggle="modal" data-bs-target="#remove-item"  title='REMOVE' data-tenantid="{{$tenant->id}}" style="background: none;border: none;color: #fff;">REMOVE</button>
             
          </td>

        </tr>
        @endforeach
			</tbody>
		</table>
	</div>
</main>
</div>
</div>
<!-- edit Modal model start -->
<div class="modal fade" id="editUser"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog " style="width: 500px !important;">
    
    <div class="modal-content  bg-transparent border-0">
      <div class="modal-body">
        <div class="container-fluid px-0">
          <div class="scnd-type-modal-form-wrapper more-extra-width">
            <form method="post" enctype="multipart/form-data" action="{{route('admin.updateBecomeTenant')}}" id="editform">
              
              {{csrf_field()}}
              <input type="hidden" name="userid" id="userid" value="">

              <h2 class="form-caption">Edit User</h2>
               <button type="button" class="btn-close-modal float-end mt-0 me-0" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
              <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                  <!-- frst row -->
                  <div class="row">
                    <div class="input-field-group ">
                      <label for="username">Name</label>
                      <input class="w-100" type="text" name="full_name" id="full_name" >
                    </div>

                    <div class="input-field-group">
                      <label for="username">Email</label>
                      <input class="w-100" type="email" name="email" id="email" required>
                    </div>

                    <div class="input-field-group">
                      <label for="username">Phone Number</label>
                      <input class="w-100" type="text" name="phone" id="phone" required>
                    </div>

                    <div class="input-field-group">
                      <label for="username">No. Of Bedrooms</label>
                      <input class="w-100" type="text" name="bedrooms" id="bedrooms">
                    </div>

                    <div class="input-field-group">
                      <label for="username">Message</label>
                      <!-- <input class="w-100" type="text" name="message" id="message" > -->message
                      <textarea class="description" name="message" id="message" required></textarea>
                    </div>

                  </div>

                </div>
                <!-- <div class=" col-xl-8 col-lg-8 ps-xl-0 ps-lg-5 col-md-7">
                  <div class="row">
                    <div class="col-xl-5 col-lg-6">
                      <div class="profile-img-holder mb-3">
                          <figcaption>Images</figcaption>
                          <div id="add-tenant-img-preview" class="image-preview" >
                            <label for="add-tenant-img-upload" id="add-tenant-img-label">EDIT IMAGE</label>
                            <input type="file" name="image" id="add-tenant-img-upload" />
                            <input type="hidden" name="image_1" id="image1" />

                          </div> 
                      </div>
                    </div>
                  </div>
                 
              

                  <div class="radio-input-group mb-lg-3 mb-md-0">
                    <h2>Tenant</h2>
                    <div class="form-check form-check-inline profile-tenant-form">
                      <input class="form-check-input tenantcheck" name="tenant_type[]" type="checkbox" id="tenant_type1" value="Elite" >
                      <label class="form-check-label" for="vip">Elite</label>
                    </div>

                     <div class="form-check form-check-inline profile-tenant-form">
                      <input class="form-check-input tenantcheck" name="tenant_type[]" type="checkbox" id="tenant_type2" value="Regular">
                      <label class="form-check-label" for="regular">Regular</label>
                    </div>

                     <div class="form-check form-check-inline profile-tenant-form">
                        <input class="form-check-input tenantcheck" name="tenant_type[]" type="checkbox" id="tenant_type3" value="Privilege">
                        <label class="form-check-label" for="nontenent">Privilege</label>
                    </div>

                 
                   
                  </div>

                  <div class="row">
                    <div class="col-xl-5">
                      <div class="input-field-group ">
                        <label for="username">N0. of Users</label>
                        <input type="text" name="nom" id="nom">
                      </div>
                    </div>

                   
                  </div>

               </div> -->

              </div>
              
              <!-- sixth row-->
              
              <div class="col-xl-12 mt-auto">
                <div class="btn-holder">
                  <button class="form-btn" type="submit" id="submit">Publish</button>
                  <a href="#">Draft</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    
  </div>
</div>
<!-- edit Modal model end -->
<!-- delete modal start -->
<div class="modal remove-item" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-transparent border-0">
      <form method="POST" action="{{route('admin.deleteBecomeTenant','tenant')}}">
      {{method_field('delete')}}
      {{csrf_field()}}
      <div class="modal-body">
        <div class="remove-content-wrapper">
          <p>Are you sure you want to delete?</p>
          <input type="hidden" name="tenant_id" id="tenant_id" value="">

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
          url  : "{{route('admin.getBecomeTenant')}}",
          type : 'Post',
          data :{'id':id,_token:'{{ csrf_token() }}'},
          dataType: 'json', 
        beforeSend: function(){
          // Show image container
            $("#loader").show();
        },   
        success : function(response) {
          
          $('#userid').val(response.id);    
          $('#full_name').val(response.fullname);
          $('#email').val(response.email);
          $('#phone').val(response.phone);
          $('#bedrooms').val(response.bedrooms);
          $('#message').val(response.message);       
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

      var tenantid = button.data('tenantid') 
     
      var modal = $(this)

      modal.find('.modal-body #tenant_id').val(tenantid);
  })
</script>
@endpush