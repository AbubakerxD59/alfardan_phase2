@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Family Member')

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
	<h2 class="table-cap pb-1">Family Members</h2>
	<a class="add-btn my-3" href="#" type="button"  data-bs-toggle="modal" data-bs-target="#addfamilymember">ADD NEW USER</a>
	<div class=" table-responsive tenant-table">
		<table class="table  table-bordered" id="myTable">
			<thead>
				<tr>
					<th scope="col"><span>User Name</span></th>
					<th scope="col"><span>Email</span></th>
					<th scope="col"><span>Account Status</span></th>
					<th scope="col"><span>Date of Birth</span></th>
					<th scope="col"><span>Phone Number</span></th>
					<!-- <th scope="col"><span>Tel. Number</span></th> -->
					<th scope="col"><span>Registered As</span></th>
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
				@foreach($families as $family)
				

				<tr>
					<td><a href="{{route('admin.family_member_view',$family->id)}}">{{$family->full_name}}  </a></td>
					<td>{{$family->email}} </td>
					<td>
						@if(@$family->status==1)
						Active
						@else
						Pending
						@endif
					</td>
					<td>{{@$family->dob}}</td>
					<td>{{@$family->mobile}}</td>
					
					<td>{{@$family->registered_as}}</td>
					<td>-</td>
					<td>{{@$family->tenant_type}}</td>
					<td>{{@$family->property}}</td>
              		<td>{{@$family->apt_number}}</td>
					<td>{{@$family->familycount()}}</td>
					<td  class="table-edit fw-bold table-edit" id="{{$family->id}}" data-bs-toggle="modal" data-bs-target="#editfamilymember">EDIT </td>
					<td class="btn-bg2"><a  type="button" class="table-delete fw-bold" data-bs-toggle="modal" data-bs-target="#remove-item"  data-familyid="{{$family->id}}">REMOVE</a></td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div> 
</main>
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
										@foreach($users as $user)
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

							

							<!-- thrd row -->
							<!--<div class="row">
							
								<div class="col-sm-6 col-12">
									<label class="text-white" for="apartment">Apartment</label>
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
									</div>
								</div>
								<div class="col-sm-6 col-12">
									
									<label class="text-white" for="property">Property</label>
									<div class="custom-select2 form-rounded my-2">
										<select id="property" name="property">
											<option value="0" selected></option>
											<option value="1">Property 1</option>
											<option value="2">Property 2</option>
											<option value="3">Property 3</option>
											<option value="4">Property 4</option>
											<option value="5">Property 5</option>
											<option value="6">Property 6</option>
											<option value="7">Property 7</option>

										</select>
									</div>
								</div>
							</div>-->

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
						<form method="post" action="{{route('admin.addFamilyMember')}}" enctype="multipart/form-data" id="editform">
                 			{{csrf_field()}}
              				<input type="hidden" name="familymemberid" id="familymemberid">
							<button type="button" class="btn-close-modal float-end mt-0 me-0" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
							<h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">Edit Family Member</h2>

							<div class="row">
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">User Name</label>
										<input type="text" name="username" id="username" required="required">
									</div>
									<div class="input-field-group">
										<label for="email">Email</label>
										<input type="email" name="email" id="email"  required="required">
									</div>
									<div class="input-field-group">
										<label for="phonenumber">Phone Number</label>
										<input type="text" name="phone" id="phone" required="required">
									</div>
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
								<div class="col-sm-6 col-12">
									<div class="add-event-img-holder add-event-img-holder  mb-3">
		                                <figcaption>Images</figcaption>
		                                <div id="edit-family-img-preview-modal" class="image-preview ">
		                                  <label class="text-uppercase" for="add-family-img-upload-modal" id="edit-family-img-label-modal">ADD IMAGE</label>
		                                  <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
										  <input type="file" name="image" id="edit-family-img-upload-modal" />
										  <input type="hidden" name="image_1" id="image1">
		                                  

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

<!-- delete modal start -->
<div class="modal remove-item" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-transparent border-0">
      <form method="POST" action="{{ route('admin.deleteFamily','family') }}">
      {{method_field('delete')}}
      {{csrf_field()}}
      <div class="modal-body">
        <div class="remove-content-wrapper">
          <p>Are you sure you want to delete?</p>
          <input type="hidden" name="familyid" id="familyid" value="">

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
			$("#edit-family-img-upload-modal").prev().removeClass('d-flex justify-content-end');
		    $("#edit-family-img-upload-modal").prev().addClass('d-none');

            $.ajax({
                url  : "{{route('admin.getFamilyMember')}}",
                type : 'Post',
                data :{'id':id,_token:'{{ csrf_token() }}'},
                dataType: 'json', 
                beforeSend: function(){
				    // Show image container
				    $("#loader").show();
				},   
                success : function(response) {
                       // console.log(response.linkfamily);
        			$('#familymemberid').val(response.id);    
        			$('#username').val(response.linkfamily.name);
        			$('#email').val(response.email);
        			$('#phone').val(response.mobile );
        			$('#tenant_name').val(response.linkfamily.user_id).attr("selected", "selected");

        			if(response.profile!=null){
	        			$("#edit-family-img-preview-modal").css("background-image", "url(" + response.profile + ")");
	        			// $("#image1").val(response.images.id);
						$("#edit-family-img-preview-modal").prev().removeClass('d-none');
                        $("#edit-family-img-preview-modal").prev().addClass('d-flex justify-content-end');
        			}
        			else{
        				$("#edit-family-img-preview-modal").css("background-image", "unset");
	        			// $("#image1").val(0);
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

        var familyid = button.data('familyid') 
        var modal = $(this)

        modal.find('.modal-body #familyid').val(familyid);
    })
</script>
<script type="text/javascript">
    $(document).ready(function() {
    $.uploadPreview({
    input_field: "#add-family-img-upload-modal",
    preview_box: "#add-family-img-preview-modal",
    label_field: "#add-family-img-label-modal"
    });
	$('#add-family-img-upload-modal').on('change', function(){
		$delete_image = $(this).prev();
		$delete_image.removeClass('d-none');
		$delete_image.addClass('d-flex justify-content-end');
    });


    $.uploadPreview({
    input_field: "#edit-family-img-upload-modal",
    preview_box: "#edit-family-img-preview-modal",
    label_field: "#edit-family-img-label-modal"
    });
	$('#edit-family-img-upload-modal').on('change', function(){
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
            // alert($(this).next().val());
            // alert($(this).siblings('.menu-hidden').val());
        });
</script>		</script>
@endpush