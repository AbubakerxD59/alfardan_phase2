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

	<h2 class="table-cap  mb-2">Tenant</h2>
	<div class=" table-responsive tenant-table">
		<table class="table  table-bordered" id="myTable">
			<thead>
				<tr>
					<th>User Name</th>
          <!-- <th>Last Name</th> -->
					<th scope="col"><span>Email</span></th>
					<!-- <th scope="col"><span>Password</span></th> -->
					<th scope="col"><span>Start Date</span></th>
					<th scope="col"><span>Date of Birth</span></th>
					<th scope="col"><span>Phone Number</span></th>
					<!-- <th scope="col"><span>Tel. Number</span></th> -->
					<th scope="col"><span>Leasing Type</span></th>
					<th scope="col"><span>Registered AS</span></th>
					<th scope="col"><Span>Tenant Type</Span></th>
					<th scope="col"><span>Property</span></th>
					<th scope="col"><span>Apartment</span></th>
          <th scope="col"><span>No. Of Memebers</span></th>
					<th style="background-color: transparent;"></th>
          <th></th>
     


					<!-- <th scope="col"><span>No. Of Members</span></th> -->
					<!-- <th colspan="2"></th> -->
				</tr>
			</thead>
			<tbody>
				@foreach ($users as $key => $user)
					
					<tr>
						<td><a href="{{ route('admin.user_info',$user->id)}}" >{{$user->full_name}} </a></td>
						<td>{{$user->email}}</td>
						<!-- <td>{{$user->password}}</td> -->
						<td>{{$user->start_date}}</td>
						<td>{{$user->dob}}</td>
						<td>{{$user->mobile}}</td>
						
						<td>{{$user->type}}</td>
						<td>{{$user->registered_as}}</td>
						<td>{{$user->tenant_type}}</td>
						 <td>{{@$user->userpropertyrelation->apartment->property->name}}</td>
             			 <td>{{@$user->userpropertyrelation->apartment->name}}</td>
						<td>{{$user->familycount()}}</td>
						<td class="btn-bg1 table-edit" id="{{$user->id}}"  data-bs-toggle="modal" data-bs-target="#editUser" style="cursor: pointer;" >EDIT </td>
						<!-- <td  class=" fw-bold" data-bs-toggle="modal" data-bs-target="#remove-item">REMOVE</a></td> -->
            <!-- <td>
              <button class="btn-bg1"  class="table-edit fw-bold" data-bs-toggle="modal" data-bs-target="#editUser" data-firstname="{{$user->first_name}}" data-lastname="{{$user->last_name}}" data-email="{{$user->email}}" data-phone="{{$user->mobile}}" data-apt="{{$user->apt_number}}" data-userid="{{$user->id}}" data-userimage="{{asset('placeholder.png')}}" style="background: none;border: none;color: #fff;">EDIT</button>
            </td> -->
            <td>
              <!-- <form method="POST" action="{{ route('admin.delete_user', $user->id) }}"> -->
                <!-- @csrf -->
                <!-- <input name="_method" type="hidden" value="DELETE"> -->
                <button class="fw-bold" data-bs-toggle="modal" data-bs-target="#remove-item"  title='REMOVE' data-userid="{{$user->id}}" style="background: none;border: none;color: #fff;">REMOVE</button>
              <!-- </form> -->
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
  <div class="modal-dialog ">
    
    <div class="modal-content  bg-transparent border-0">
      <div class="modal-body">
        <div class="container-fluid px-0">
          <div class="scnd-type-modal-form-wrapper more-extra-width">
            <form method="post" enctype="multipart/form-data" action="{{route('admin.updateUser')}}" id="editform">
              
              {{csrf_field()}}
              <input type="hidden" name="userid" id="userid" value="">

              <h2 class="form-caption">Edit User</h2>
               <button type="button" class="btn-close-modal float-end mt-0 me-0" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
              <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-5">
                  <!-- frst row -->
                  <div class="row">
                    <div class="input-field-group ">
                      <label for="username">Full Name</label>
                      <input class="w-100" type="text" name="full_name" id="full_name" >
                    </div>

                    <!-- <div class="input-field-group ">
                      <label for="username">Last Name</label>
                      <input class="w-100" type="text" name="last_name" id="last_name" >
                    </div> -->

                    <div class="input-field-group">
                      <label for="username">Email</label>
                      <input class="w-100" type="email" name="email" id="email" required>
                    </div>

                    <div class="input-field-group">
                      <label for="username">Phone Number</label>
                      <input class="w-100" type="text" name="mobile" id="mobile" required>
                    </div>

                    <div class="input-field-group">
                      <label for="username">Start Date</label>
                      <input class="w-100" type="date" name="start_date" id="start_date">
                    </div>

                    <div class="input-field-group">
                      <label for="username">Leasing Type</label>
                      <input class="w-100" type="text" name="leasing_type" id="leasing_type">
                    </div>

                    <div class="input-field-group">
                      {{-- <label for="username">Apartment</label>
                                                <input class="w-100" type="text" name="apt_number" id="apt_number"> --}}
                                                <label class="text-white" for="location">Apartments</label>
                                                <select name="apt_number" class="w-100 p-2 text-white"
                                                    id="apt_number"style="background-color: #2B2B2B;width: 247px;">
                                                    @foreach ($apartments as $apartment)
                                                        <option value="{{ $apartment->id }}">{{ $apartment->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                    </div>

                  </div>

                </div>
                <div class=" col-xl-8 col-lg-8 ps-xl-0 ps-lg-5 col-md-7">
                  <div class="row">
                    <div class="col-xl-5 col-lg-6">
                      <div class="profile-img-holder mb-3">
                          <figcaption>Images</figcaption>
                          <div id="add-tenant-img-preview" class="image-preview" >
                            <label for="add-tenant-img-upload" id="add-tenant-img-label">EDIT IMAGE</label>
							  <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
                            <input type="file" name="image" id="add-tenant-img-upload" />
                            <input type="hidden" name="image_1" id="image1" />

                          </div> 
                      </div>
                    </div>
                  </div>
                 
                 <!-- 2nd row -->

                  <div class="radio-input-group mb-lg-3 mb-md-0">
                    <h2>Tenant</h2>
                    <div class="form-check form-check-inline profile-tenant-form">
                      <input class="form-check-input tenantcheck" name="tenant_type" type="radio" id="tenant_type1" value="Elite" >
                      <label class="form-check-label" for="vip">Elite</label>
                    </div>

                     <div class="form-check form-check-inline profile-tenant-form">
                      <input class="form-check-input tenantcheck" name="tenant_type" type="radio" id="tenant_type2" value="Regular">
                      <label class="form-check-label" for="regular">Regular</label>
                    </div>

                     <!--<div class="form-check form-check-inline profile-tenant-form">
                        <input class="form-check-input tenantcheck" name="tenant_type" type="radio" id="tenant_type3" value="Privilege">
                        <label class="form-check-label" for="nontenent">Privilege</label>
                    </div>-->

                    <h2>Property</h2>
                    <?php $i=1?>
                    <div class="editc">
                                                @foreach ($properties as $property)
                                                    <div class="form-check form-check-inline property profile-tenant-form">
                                                        <input class="form-check-input property_radio" name="property"
                                                            type="radio" id="property{{ $property->id }}"
                                                            value="{{ $property->id }}">
                                                        <label class="form-check-label"
                                                            for="property{{ $property->id }}">{{ $property->name }}</label>
                                                    </div>
                                                    <?php $i++; ?>
                                                @endforeach
                                            </div>
                    <!-- <div class="form-check form-check-inline">
                      <input class="form-check-input" name="property" type="radio" id="Property2" value="option2">
                      <label class="form-check-label" for="Property2">Property2</label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" name="property" type="radio" id="Property3" value="option2">
                      <label class="form-check-label" for="Property3">Property3</label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" name="property" type="radio" id="Property4" value="option2">
                      <label class="form-check-label" for="Property4">Property4</label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" name="property" type="radio" id="Property5" value="option2">
                      <label class="form-check-label" for="Property5">Property5</label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" name="property" type="radio" id="Property6" value="option2">
                      <label class="form-check-label" for="Property6">Property6</label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" name="property" type="radio" id="Property7" value="option2">
                      <label class="form-check-label" for="Property7">Property7</label>
                    </div> -->
                  </div>

                  <div class="row">
                    <div class="col-xl-5">
                      <div class="input-field-group ">
                        <label for="username">N0. of Users</label>
                        <input type="text" name="nom" id="nom">
                      </div>
                    </div>

                   
                  </div>

                </div>

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
      <form method="POST" action="{{ route('admin.delete_user','user') }}">
      {{method_field('delete')}}
      {{csrf_field()}}
      <div class="modal-body">
        <div class="remove-content-wrapper">
          <p>Are you sure you want to delete?</p>
          <input type="hidden" name="user_id" id="user_id" value="">

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
	  $('.editc input').click(function(e) {
                var allprids = [];
                $('.editc input:checked').each(function(i, obj) {
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
                        var aps = $("#apt_number").attr("data-apartment_id");
                        // console.log(aps);
                        
                        $("#apt_number").html("");
                        $("#apt_number").val(aps);
                        $.each(response, function(index, value) {
                            var option = {
                                value: value.id,
                                text: value.name
                            };
                            console.log(value.id, aps);
                            if (value.id==parseInt(aps)) {
                                option.selected = "selected";
                            }
                            $("#apt_number").append($('<option>', option));
                        });
                    },
                    complete: function(data) {
                        // Hide image container
                        $("#loader").hide();
                    }
                });
            });
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
              
            $('#userid').val(response.id);    
            $('#full_name').val(response.full_name);
            $('#email').val(response.email);
            $('#mobile').val(response.mobile);
            

            //$('#apt_number').val(response.apt_number);
            
            $('#start_date').val(response.start_date);
            $('#nom').val(response.families.length);
            $('#leasing_type').val(response.type);
            
            

            if(response.tenant_type!=null){
              // var tenant_type=response.tenant_type.split(',');
              // for(var i=0; i<= 3; i++){
              //   var id=i+1;
              //   if(i<tenant_type.length){

                  $('input.tenantcheck[value="'+response.tenant_type+'"]').prop('checked', true);
              //     // $("#tenant_type"+id +"").prop('checked', true);
              //   }

              // }
            }
            // $('input.property_radio[value="'+response.userpropertyrelation.property_id+'"]').prop('checked', true);
            // if(response.property!=null){
            //   var property=response.property.split(',');
            //   for(var i=0; i< property.length; i++){
            //     var id=i+1;
            //     if(i<id){
            //       $('input.property_radio[value="'+property[i]+'"]').prop('checked', true);
                  
            //     }

            //   }
            // }

            var appid = response.userpropertyrelation.apartment_id;
                        // console.log(appid);
                        $("#apt_number option[value='" + appid + "']").attr("selected", "selected");
                        $("#apt_number").data('val',appid);
                        $("#apt_number").attr('data-apartment_id',appid);
                        var allprids = [response.userpropertyrelation.property_id];
                        $.each(allprids, function(i, e) {
                            // console.log('prid = '+ response.userpropertyrelation.property_id);
                            $(".editc #property" + e).attr("checked", "checked");
                            $(".editc #property" + e).trigger('click');
                        });

            if(response.profile!=null){
              $("#add-tenant-img-preview").css("background-image", "url(" + response.profile + ")");
				$("#add-tenant-img-upload").prev().removeClass('d-none');
                            $("#add-tenant-img-upload").prev().addClass('d-flex justify-content-end');
              // $("#image1").val(response.images.id);
            }
            else{
              $("#add-tenant-img-preview").css("background-image", "unset");
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
  
</script>
<script>
            $('#add-tenant-img-upload').on('change', function(){
                $delete_image = $(this).prev();
                $delete_image.removeClass('d-none');
                $delete_image.addClass('d-flex justify-content-end');
            });
            $('.delete-image').on('click', function(){
                $(this).next().val('' );
                $(this).siblings('.menu-hidden').val('');
                $(this).parent().css("background-image",'none');
                $(this).addClass('d-none');
            });
    </script>
@endpush