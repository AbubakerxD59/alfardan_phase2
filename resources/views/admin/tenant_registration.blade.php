@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Tenant Registration')

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

	<h2 class="table-cap mb-2">Tenant Registration</h2>
  <div class="d-flex justify-content-between">
    <div>
      <form method="POST" action="{{route('admin.tenant_registration_term')}}" enctype="multipart/form-data">
        @csrf
        <div class="input-field-group upload-pdf">
          <span class="input-group-btn" style="cursor: pointer;">
            <div class="btn btn-default browse-button2">
              <span class="browse-button-text2 text-white" style="cursor: pointer;">
              @if (empty(@$terms->tenant_reg_term))
              <i class="fa fa-upload"></i> 
              TERMS & CONDITIONS
              @else
              <i class="fa fa-refresh"></i>
              Change
              @endif
              </span>
              <input type="file" accept=".pdf" name="tenant_reg_term">
            </div>
            <button type="button" class="btn btn-default clear-button" style="{{empty(@$terms->tenant_reg_term) ? 'display:none;' : '' }}color: #fff;">
              <span class="fa fa-trash"></span> 
              Delete
            </button>
            
            <button type="submit" class="btn btn-default upload-button" style="{{empty(@$terms->tenant_reg_term) ? 'display:none;' : '' }}color: #fff;">
              @if (empty(@$terms->tenant_reg_term))  
                <span class="fa fa-save"></span> 
                  Save
              @endif
              </button>
          </span>
          <input type="text" class="form-control filename2 add-btn" style="{{empty(@$terms->tenant_reg_term) ? 'display:none;' : '' }}" id="edit_terms" disabled="disabled" value="{{@$terms->tenant_reg_term}}">
          <span class="input-group-btn"></span>
        </div>
      </form>
    </div>
    <div>
      <a class="add-btn my-3 float-end" href="#" type="button"  data-bs-toggle="modal" data-bs-target="#add-properties">Add new</a>
    </div>
  </div>
  <a href="{{route('admin.tenantExport')}}" class="download-list-btn mt-4" style="float: right;margin-right: 20px;"><img src="{{asset('alfardan/assets/download-svg.png')}}" class="pe-2">Download List</a>
	<div class=" table-responsive tenant-table clear-both">
		<table class="table  table-bordered" >
			<thead>
				<tr>
					<th>Name</th>
					<th scope="col"><span>Location</span></th>
					<th scope="col"><span>Apartment</span></th>
					<th scope="col"><span>Date Of Birth</span></th>
					<th scope="col"><span>Email</span></th>
          <th scope="col"><span>Emergency Contact</span></th>
          <th scope="col"><span>Nationality</span></th>
          <th scope="col"><span>No. Of Occupants</span></th>
          <th scope="col"><span>Occupant Names</span></th>

				
					<th style="background-color: transparent;"></th>
          <th></th>
     


					<!-- <th scope="col"><span>No. Of Members</span></th> -->
					<!-- <th colspan="2"></th> -->
				</tr>
			</thead>
			<tbody>
        @foreach($tenants as $tenant)
        <tr>
		      <td>{{$tenant->name}}</td>
          <td>{{@$tenant->property->name}}</td>
          <td>{{@$tenant->apartment->name}}</td>
          <td>{{$tenant->dob}}</td>
          <td>{{$tenant->email}}</td>
          <td>{{$tenant->emergency_contact}}</td>
          <td>{{$tenant->nationality}}</td>
          <td>{{$tenant->occupants}}</td>
          <td>{{$tenant->occupant_name}}</td>

          <td class="btn-bg1 table-edit" id="{{$tenant->id}}"  data-bs-toggle="modal" data-bs-target="#editUser" style="cursor: pointer;" >EDIT </td>
            
          <td>
              
            <button class="fw-bold" data-bs-toggle="modal" data-bs-target="#remove-item"  title='REMOVE' data-tenantid="{{$tenant->id}}" style="background: none;border: none;color: #fff;">REMOVE</button>
             
          </td>

        </tr>
        @endforeach
    
			</tbody>
		</table>
    {{$tenants->links()}}
	</div>
</main>
</div>
</div>
<!-- add model start -->
<div class="modal fade" id="add-properties"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
 <div class="modal-dialog ">

    <div class="modal-content border-0 bg-transparent">
    <div class="modal-body service-select">
      <div class="container-fluid px-0">
        <div class="scnd-type-modal-form-wrapper">
          <form method="post" action="{{route('admin.addTenantRegistration')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <h2 class="form-caption">add tenant registration</h2>
            <button type="button" class="btn-close-modal float-sm-end float-start mt-0 me-sm-0 me-4" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle" aria-hidden="true"></i></button>
            <!-- frst row -->
            <div class="row">
              <div class="col-sm-6 col-12">
                <div class="input-field-group">
                  <label for="username">Name</label>
                 <input type="text" name="name" >
                </div>
              </div>
              <div class="col-sm-6 col-12 service-select">
                <div class="input-field-group">
                  <label for="userid">Location</label>
                 <!--  <input type="text" name="user_id" > -->
                 <select id="add_property" name="property_id" class="custom-select2" style="background-color: #2B2B2B;width: 247px;" onclick="addapartment('add_property','add_apartment')">
                    @foreach($properties as $property)
                    <option value="{{$property->id}}">{{$property->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>

            <!-- scnd row -->
            <div class="row">
              <div class="col-sm-6 col-12 service-select">
                <div class="input-field-group">
                  <label for="formid">Apartment</label>
                  <!-- <input type="text" name="formid" required> -->
                  <select class="custom-select2" name="apartment_id" id="add_apartment" style="background-color: #2B2B2B;width: 247px;">
                        
                      
                     <!--  <option value="0">--select--</option> -->
                      
                  </select>
                </div>
              </div>
              <div class="col-sm-6 col-12">
                <div class="input-field-group">
                  <label for="submission">Date Of Birth</label>
                  <input type="date" name="dob" required>
                </div>
              </div>
            </div>

            <!-- thrd row -->
            <div class="row">
              <div class="col-sm-6 col-12 pt-2">
                <div class="input-field-group">
                  <label for="availability">Email</label>
                  <input type="email" name="email" required>
                </div>
              </div>
              <div class="col-sm-6 col-12">
                <div class="input-field-group">
                  <label class="text-white" for="service">Emergency Contact</label>
                  <input type="text" name="emergency_contact" required>

                </div>
              </div>
            </div>

              <!-- frth row -->
              <div class="row">
                <div class="col-sm-6 col-12">
                  <div class="input-field-group">
                  <label class="text-white" for="Property">Nationality</label>
                  <input type="text" name="nationality" required>
                  </div>
                </div>
                <div class="col-sm-6 col-12">
                  <div class="input-field-group">
                  <label class="text-white" for="Property">No. Of Occupants</label>
                  <input type="text" name="occupants" required>
                </div>
                </div>
              </div>

              <!-- fifth row -->
              <div class="row">
                <div class="col-sm-6 col-12">
                  <div class="input-field-group pb-4">
                    <label for="Attendee">Occupant Names</label>
                    <input type="text" name="occupant_name" required>
                  </div>
                </div>
               
              </div>
              <!-- sevnth row -->
              <div class="row">
                <div class="col-12">
                  <div class="btn-holder">
                    <input class="form-btn publish" name="publish" type="submit" value="Publish" ></>
                    <!-- <input type="submit" name="draft" value="Draft" class="draft"></> -->
                    <button class="form-btn">Draft</button> -->
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
<!-- end model  -->
<!-- edit Modal model start -->
<div class="modal fade" id="editUser"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog ">

    <div class="modal-content border-0 bg-transparent">
      <div class="modal-body service-select">
        <div class="container-fluid px-0">
          <div class="scnd-type-modal-form-wrapper">
            <form method="post" action="{{route('admin.updateTenantRegistration')}}" enctype="multipart/form-data">
              {{csrf_field()}}

              <input type="hidden" name="userid" id="userid" value="">
              <h2 class="form-caption">add tenant registration</h2>
              <button type="button" class="btn-close-modal float-sm-end float-start mt-0 me-sm-0 me-4" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle" aria-hidden="true"></i></button>
              <!-- frst row -->
              <div class="row">
                <div class="col-sm-6 col-12">
                  <div class="input-field-group">
                    <label for="username">Name</label>
                    <input type="text" name="name" id="name" >
                  </div>
                </div>
                <div class="col-sm-6 col-12 service-select">
                  <div class="input-field-group">
                    <label for="userid">Location</label>
                    <!--  <input type="text" name="user_id" > -->
                    <select id="edit_property" name="property_id" onclick="addapartment('edit_property','edit_apartment')" class="custom-select2" style="background-color: #2B2B2B;width: 247px;">
                      @foreach($properties as $property)
                      <option value="{{$property->id}}">{{$property->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>

              <!-- scnd row -->
              <div class="row">
                <div class="col-sm-6 col-12 service-select">
                  <div class="input-field-group">
                    <label for="formid">Apartment</label>
                    <!-- <input type="text" name="formid" required> -->
                    <select class="custom-select2" name="apartment_id" id="edit_apartment" style="background-color: #2B2B2B;width: 247px;">
                      @foreach($apartments as $apartment)
                      <option value="{{$apartment->id}}">{{$apartment->name}}</option>
                      @endforeach

                     <!--  <option value="0">--select--</option> -->

                   </select>
                 </div>
               </div>
               <div class="col-sm-6 col-12">
                <div class="input-field-group">
                  <label for="submission">Date Of Birth</label>
                  <input type="date" name="dob" id="dob" required>
                </div>
              </div>
            </div>

            <!-- thrd row -->
            <div class="row">
              <div class="col-sm-6 col-12 pt-2">
                <div class="input-field-group">
                  <label for="availability">Email</label>
                  <input type="email" name="email" id="email" required>
                </div>
              </div>
              <div class="col-sm-6 col-12">
                <div class="input-field-group">
                  <label class="text-white" for="service">Emergency Contact</label>
                  <input type="text" name="emergency_contact" id="emergency_contact" required>

                </div>
              </div>
            </div>

            <!-- frth row -->
            <div class="row">
              <div class="col-sm-6 col-12">
                <div class="input-field-group">
                  <label class="text-white" for="Property">Nationality</label>
                  <input type="text" name="nationality" id="nationality" required>
                </div>
              </div>
              <div class="col-sm-6 col-12">
                <div class="input-field-group">
                  <label class="text-white" for="Property">No. Of Occupants</label>
                  <input type="text" name="occupants" id="occupants" required>
                </div>
              </div>
            </div>

            <!-- fifth row -->
            <div class="row">
              <div class="col-sm-6 col-12">
                <div class="input-field-group pb-4">
                  <label for="Attendee">Occupant Names</label>
                  <input type="text" name="occupant_name" id="occupant_name" required>
                </div>
              </div>

            </div>
            <!-- sevnth row -->
            <div class="row">
              <div class="col-12">
                <div class="btn-holder">
                  <input class="form-btn publish" name="publish" type="submit" value="Publish" ></>
                  <button class="form-btn">Draft</button>
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
<!-- edit Modal model end -->
<!-- delete modal start -->
<div class="modal remove-item" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-transparent border-0">
      <form method="POST" action="{{route('admin.deleteTenantRegistration','delete')}}">
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
      // $("#myTable").on("click", ".table-edit", function(e){
      $('.table-edit').click(function(e) {
      e.preventDefault(); // prevent form from reloading page
      $('#editform').trigger("reset");
      var id=$(this).attr('id');

      $.ajax({
          url  : "{{route('admin.getTenantRegistration')}}",
          type : 'Post',
          data :{'id':id,_token:'{{ csrf_token() }}'},
          dataType: 'json', 
        beforeSend: function(){
          // Show image container
            $("#loader").show();
        },   
        success : function(response) {
          $('#userid').val(response.id);    
          $('#name').val(response.name);    
          $('#dob').val(response.dob);
          $('#email').val(response.email);
          $('#emergency_contact').val(response.emergency_contact);
          $('#occupants').val(response.occupants);
          $('#occupant_name').val(response.occupant_name); 
          $('#nationality').val(response.nationality); 

          if(response.property_id!=null){

            $('#edit_property').val(response.property_id).attr("selected", "selected");
            $('#edit_apartment').val(response.apartment_id).attr("selected", "selected");
          }else{
            $('#edit_property').val('');
            $('#edit_apartment').val('');
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

      var tenantid = button.data('tenantid') 
     
      var modal = $(this)

      modal.find('.modal-body #tenant_id').val(tenantid);
  })

  function addapartment(propertyid,apartmantid){
    $('#'+propertyid).change(function(){
      // alert("here");
      var id=$(this).val();
      // alert(id);
      $('#'+apartmantid).find('option').remove();

      $.ajax({
        url  : "{{route('admin.ajaxGetProperty')}}",
        type : "get",
        data :{'id':id,_token:'{{ csrf_token() }}'},
        dataType: "json",
        success:function(response){

          var len=0;

          if(response['data']!=null){

            len=response['data'].length;
          }
          if(len>0){

            for(var i=0;i<len;i++){

              var id=response['data'][i].id;

              var name=response['data'][i].name;
              
              var option="<option value='"+id+"'>"+name+"</option>";

              $('#'+apartmantid).append(option);
            }
          }
        }
      })
    })
  }
</script>
<script>
	// Show filename, show clear button and change browse 
	//button text when a valid extension file is selected
	$(".browse-button2 input:file").change(function (){
		console.log('changed');
		var fileName = $(this).val().split('/').pop().split('\\').pop();
		console.log(fileName);
		$(".filename2").val(fileName);
		$(".browse-button-text2").html('<i class="fa fa-refresh"></i> Change');
    $(".clear-button").show();
		$(".upload-button").show();
    $(".upload-button").html('<i class="fa fa-save"></i> Save');
    $(".filename2").show();
		// });
	});
	//actions happening when the button is clicked
	$('.clear-button').click(function(){
		$.ajax({
      url  : "{{route('admin.delete_term')}}",
        type : "post",
        data :{type : 'tenant_registration',_token:'{{ csrf_token() }}'},
        dataType: "json",
        success:function(response){
          if(response){
            location.reload();
          }
        } 
    });
		// $('.filename2').val("");
		// $('.clear-button').hide();
    // $(".upload-button").hide();
    // $(".filename2").hide();
		// $('.browse-button2 input:file').val("");
		// $(".browse-button-text2").html('<i class="fa fa-upload"></i> TERMS & CONDITIONS'); 
	});
</script>
@endpush