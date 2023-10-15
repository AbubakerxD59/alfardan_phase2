@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Maintenance In Absentia')

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
	<div class="table-cap-space-between">
		<h2 class="table-cap pb-2 float-start text-capitalize">Maintenance in Absentia</h2>
		<div class="d-flex justify-content-between w-100 pb-3">
			<div>
				<form method="POST" action="{{route('admin.maintenance_in_absentia_term')}}" enctype="multipart/form-data">
					@csrf
					<div class="input-field-group upload-pdf">
						<span class="input-group-btn" style="cursor: pointer;">
						  <div class="btn btn-default browse-button2">
							<span class="browse-button-text2 text-white" style="cursor: pointer;">
							@if (empty(@$terms->maintenance_in_absentia_term))
							<i class="fa fa-upload"></i> 
							TERMS & CONDITIONS
							@else
							<i class="fa fa-refresh"></i>
							Change
							@endif
							</span>
							<input type="file" accept=".pdf" name="maintenance_in_absentia_term">
						  </div>
						  <button type="button" class="btn btn-default clear-button" style="{{empty(@$terms->maintenance_in_absentia_term) ? 'display:none;' : '' }}color: #fff;">
							<span class="fa fa-trash"></span> 
							Delete
						  </button>
						  
						  <button type="submit" class="btn btn-default upload-button" style="{{empty(@$terms->maintenance_in_absentia_term) ? 'display:none;' : '' }}color: #fff;">
							@if (empty(@$terms->maintenance_in_absentia_term))  
							  <span class="fa fa-save"></span> 
								Save
							@endif
							</button>
						</span>
						<input type="text" class="form-control filename2 add-btn" style="{{empty(@$terms->maintenance_in_absentia_term) ? 'display:none;' : '' }}" id="edit_terms" disabled="disabled" value="{{@$terms->maintenance_in_absentia_term}}">
						<span class="input-group-btn"></span>
					</div>
				</form>
			</div>
			<div>
				<a class="add-btn my-3 float-end" href="#" type="button"  data-bs-toggle="modal" data-bs-target="#add-maintenance-abtentia">Add new</a>
			</div>
		</div>
	</div>
	<div class=" table-responsive tenant-table clear-both ">
		<table class="table  table-bordered " id="myTable">
			<thead>
				<tr>
					<th class="px-0">Form ID</a></th>
					<th class="px-0">User Name</a></th>
					<th class="px-0">Contact Number</a></th>
					<th class="px-0">Submission Date</a></th>
					<th class="px-0">Availability Date</a></th>
					<th class="px-0">Apartment</a></th>
					<th class="px-0">Property</a></th>
					<th class="px-0">Status</a></th>
					<th class="px-0">Form Status</a></th>

					<th style="background: transparent;"></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($maintenances as $maintenance)
				<tr>
					<td><a href="{{route('admin.maintenance_in_absentia_view',$maintenance->id)}}">{{$maintenance->form_id}}</a></td>
					<td>{{@$maintenance->user->full_name}}</td>
					<td>{{@$maintenance->user->mobile}}</td>
					<td>{{$maintenance->created_at->todatestring()}}</td>
					<td>{{$maintenance->date}}</td>
					<td>{{@$maintenance->user->apt_number}}</td>
					<td>{{@$maintenance->user->property}}</td>
					<td>{{@$maintenance->status}}</td>

					<td>
						@if($maintenance->form_status==1)
							Publish
						
						@else
							Draft
						
						@endif</td>
					<td  class="fw-bold cursor-pointer table-edit" id="{{$maintenance->id}}" data-bs-toggle="modal" data-bs-target="#edit-maintenance-abtentia">Edit</td>
					<td class="btn-bg2"><a  type="button" data-bs-toggle="modal" data-bs-target="#remove-item"  data-maintenanceid="{{$maintenance->id}}" class="table-delete fw-bold">Remove</a></td>
				</tr>
				@endforeach
				
			</tbody>
		</table>
	</div>

</main>
<!--Add pet request model start -->
<div class="modal fade" id="add-maintenance-abtentia"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog ">

		<div class="modal-content border-0 bg-transparent">
			<div class="modal-body service-select">
				<div class="container-fluid px-0">
					<div class="scnd-type-modal-form-wrapper">
						<form method="post" action="{{route('admin.addMaintenanceAbsentia')}}" enctype="multipart/form-data">
                 			{{csrf_field()}}
							
							<h2 class="form-caption">Add Maintenance in absentia</h2>
							<button type="button" class="btn-close-modal float-sm-end float-start mt-0 me-sm-0 me-4" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle" aria-hidden="true"></i></button>
							<!-- frst row -->
							<div class="row">
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">User Name</label>
										<!-- <input type="text" name="username" id="username"> -->
										<select class="custom-select2 userid"  name="userid" style="background-color: #2B2B2B;width: 247px;">
											@foreach($users as $user)
										  	<option value="{{$user->id}}">{{$user->full_name}} </option>
										 	 @endforeach
										</select>
									</div>
								</div>
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">User ID</label>
										<input type="text" name="user_id" id="userid">
									</div>
								</div>
							</div>

							<!-- scnd row -->
							<div class="row">
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">Form ID</label>
										<input type="text" name="formid" required>
									</div>
								</div>
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">Submission Date</label>
										<input type="date" name="submission" required>
									</div>
								</div>
							</div>

							<!-- thrd row -->
							<div class="row">
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">Availability Date</label>
										<input type="date" name="date" required>
									</div>
								</div>
								<div class="col-sm-6 col-12">
									
									<label class="text-white" for="location">Property</label>
									<select name="property_id" class="custom-select2 "style="background-color: #2B2B2B;width: 247px;">
											@foreach($properties as $property)
											<option value="{{$property->id}}">{{$property->name}}</option>
											@endforeach

									</select>
								</div>
							</div>

							<!-- frth row -->
							<div class="row">
								<div class="col-sm-6 col-12">
									<label class="text-white" for="location">Apartment</label>
									<select name="apartment_id" class="custom-select2 "style="background-color: #2B2B2B;width: 247px;">
											@foreach($apartments as $apartment)
											<option value="{{$apartment->id}}">{{$apartment->name}}</option>
											@endforeach

									</select>
								</div>
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">Phone Number</label>
										<input type="text" name="phone" required>
									</div>
								</div>
							</div>

							<!-- fifth row -->
							<div class="row">
								<div class="col-sm-6 col-12">
									<div class="input-field-group pb-4">
										<label for="username">Status</label>
										<!-- //<input type="text" name="status" readonly> -->
										<select class="custom-select2" id="add-maintenance-form-status" name="status" style="background-color: #2B2B2B;width: 247px;">
											<option value="pending">Pending</option>
											<option value="approved">Approved</option>
											<option value="rejected">Rejected</option>	
											<option value="cancelled">Cancelled</option>				
														
										</select>
									</div>

									<div class="input-field-group">
										<input class="form-check-input" type="radio" name="term" value="1"> <span for="condition" class="input-radio-checked">Terms & Conditions</span>
									</div>
								</div>
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label >Status Reason</label>
										<textarea class="description" name="reason" required></textarea>
									</div>
								</div>
							</div>

							<!-- sixth row -->
							<!-- svnth row -->


							<div class="row">
								<div class="col-12">
									<div class="btn-holder">
										<!-- <button class="form-btn" type="submit">Publish</button>
										<a href="#">Draft</a> -->
										<input class="form-btn publish" name="publish" type="submit" value="Publish" ></>
										<input type="submit" name="draft" value="Draft" class="draft"></>
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
<!--Add pet request model end -->   
<!--edit pet request model start -->
<div class="modal fade" id="edit-maintenance-abtentia"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog ">

		<div class="modal-content border-0 bg-transparent">              
			<div class="modal-body service-select">
				<div class="container-fluid px-0">
					<div class="scnd-type-modal-form-wrapper">
						<form method="post" action="{{route('admin.addMaintenanceAbsentia')}}" enctype="multipart/form-data" id="editform">
                 			{{csrf_field()}}
                 			<input type="hidden" name="maintenance_id" id="maintenance_id">
							
							<h2 class="form-caption">Edit Maintenance in absentia</h2>
							<button type="button" class="btn-close-modal float-sm-end float-start mt-0 me-sm-0 me-4" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle" aria-hidden="true"></i></button>
							<!-- frst row -->
							<div class="row">
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">User Name</label>
										<!-- <input type="text" name="username" id="username"> -->
										<select class="custom-select2 edit_userid" id="userid1" name="userid" style="background-color: #2B2B2B;width: 247px;">
											@foreach($users as $user)
										  	<option value="{{$user->id}}">{{$user->full_name}}</option>
										 	 @endforeach
										</select>
									</div>
								</div>
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">User ID</label>
										<input type="text" name="userid" id="edit_userid">
									</div>
								</div>
							</div>

							<!-- scnd row -->
							<div class="row">
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">Form ID</label>
										<input type="text" name="formid" id="formid" required>
									</div>
								</div>
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">Submission Date</label>
										<input type="date" name="submission" id="submission" required>
									</div>
								</div>
							</div>

							<!-- thrd row -->
							<div class="row">
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">Availability Date</label>
										<input type="date" name="date" id="date" required>
									</div>
								</div>
								<div class="col-sm-6 col-12">
								    <label class="text-white" for="location">Property</label>
									<select name="property_id" id="property_id" class="custom-select2 "style="background-color: #2B2B2B;width: 247px;">
											@foreach($properties as $property)
											<option value="{{$property->id}}">{{$property->name}}</option>
											@endforeach

									</select>
								</div>
							</div>

							<!-- frth row -->
							<div class="row">
								<div class="col-sm-6 col-12">
								<label class="text-white" for="location">Apartment</label>
									<select name="apartment_id" id="apartment_id" class="custom-select2 "style="background-color: #2B2B2B;width: 247px;">
											@foreach($apartments as $apartment)
											<option value="{{$apartment->id}}">{{$apartment->name}}</option>
											@endforeach

									</select>
								</div>
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">Phone Number</label>
										<input type="text" name="phone" id="phone" required>
									</div>
								</div>
							</div>

							<!-- fifth row -->
							<div class="row">
								<div class="col-sm-6 col-12">
									<div class="input-field-group pb-4">
										<label for="username">Status</label>
										<!-- <input type="text" name="status" id="status" readonly> -->
										<select class="custom-select2" id="status" name="status" style="background-color: #2B2B2B;width: 247px;">
											<option value="pending">Pending</option>
											<option value="approved">Approved</option>
											<option value="rejected">Rejected</option>	
											<option value="cancelled">Cancelled</option>				
														
										</select>
									</div>

									<div class="input-field-group">
										<input class="form-check-input" type="radio" name="term" value="1" id="term"> <span for="condition" class="input-radio-checked">Terms & Conditions</span>
									</div>
								</div>
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label >Status Reason</label>
										<textarea class="description" name="reason" id="reason" required></textarea>
									</div>
								</div>
							</div>

							<!-- sixth row -->
							<!-- svnth row -->


							<div class="row">
								<div class="col-12">
									<div class="btn-holder">
										<!-- <button class="form-btn" type="submit">Publish</button>
										<a href="#">Draft</a> -->
										<input class="form-btn publish" name="publish" type="submit" value="Publish" ></>
										<input type="submit" name="draft" value="Draft" class="draft"></>
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
<!--Edit pet request model start -->     
<!-- delete modal start -->
<div class="modal remove-item" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-transparent border-0">
      <form method="POST" action="{{ route('admin.deleteMaintenanceAbsentia','user') }}">
      {{method_field('delete')}}
      {{csrf_field()}}
      <div class="modal-body">
        <div class="remove-content-wrapper">
          <p>Are you sure you want to delete?</p>
          <input type="hidden" name="maintenanceid" id="maintenanceid" value="">

          <div class="delete-btn-wrapper">
            <a href="#" type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close">cancel</a>
            <!-- <a href="#">delete</a> -->
            <button type="Submit" 
            style="color: #fff;
            font-size: 18px;
            max-width: 133px;
            height: 37px;
            padding: 5px 32px;
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
        
        // $('.table-edit').click(function(e) {
        $("#myTable").on("click", ".table-edit", function(e){	
            e.preventDefault(); // prevent form from reloading page
            $('#editform').trigger("reset");
            var id=$(this).attr('id');

            $.ajax({
                url  : "{{route('admin.getMaintenanceAbsentia')}}",
                type : 'Post',
                data :{'id':id,_token:'{{ csrf_token() }}'},
                dataType: 'json',
                beforeSend: function(){
				    // Show image container
				    $("#loader").show();
				},    
                success : function(response) {
                        // console.log(response.images[0].path);
        			$('#maintenance_id').val(response.id);            
        			$('#formid').val(response.form_id);
        			$('#submission').val(response.created_at);
        			$('#date').val(response.date);
        			$('#edit_userid').val(response.user_id);
        			$('#reason').val(response.reason);
        			// $('#status').val(response.status);
        			
        			if(response.user!=null){
        			$('#phone').val(response.user.mobile);

        			$('#property_id').val(response.user.userpropertyrelation.property_id).attr("selected", "selected");
        			$('#apartment_id').val(response.user.userpropertyrelation.apartment_id).attr("selected", "selected");
	        		}else{
	        			$('#property_id').val('');
        			     $('#apartment_id').val('');
	        		}
        			$('#userid1').val(response.user_id).attr("selected", "selected");
        			$('#status').val(response.status).attr("selected", "selected");
        			if(response.term == '1')
        			{
        				$('#term').prop('checked', true);
        			}
        			else{
        				$('#term').prop('checked', false);
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

	    var maintenanceid = button.data('maintenanceid') 
	    var modal = $(this)

	    modal.find('.modal-body #maintenanceid').val(maintenanceid);
	})

	$('.userid').change(function(){
		var id=$(this).val();
		$('#userid').val(id);
	});

	$('.edit_userid').change(function(){
		var id=$(this).val();
		$('#edit_userid').val(id);
	});
	

    
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
        data :{type : 'maintenance_in_absentia',_token:'{{ csrf_token() }}'},
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