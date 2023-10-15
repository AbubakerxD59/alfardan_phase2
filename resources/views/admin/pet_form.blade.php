@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Pet Form')

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
		<h2 class="table-cap pb-2 float-start text-capitalize">Pet form</h2>
		<div class="d-flex justify-content-between pb-3 w-100">
			<div>
				<form method="POST" action="{{route('admin.pet_form_term')}}" enctype="multipart/form-data">
					@csrf
					<div class="input-field-group upload-pdf">
						<span class="input-group-btn" style="cursor: pointer;">
						  <div class="btn btn-default browse-button2">
							<span class="browse-button-text2 text-white" style="cursor: pointer;">
							@if (empty(@$terms->pet_form_term))
							<i class="fa fa-upload"></i> 
							TERMS & CONDITIONS
							@else
							<i class="fa fa-refresh"></i>
							Change
							@endif
							</span>
							<input type="file" accept=".pdf" name="pet_form_term">
						  </div>
						  <button type="button" class="btn btn-default clear-button" style="{{empty(@$terms->pet_form_term) ? 'display:none;' : '' }}color: #fff;">
							<span class="fa fa-trash"></span> 
							Delete
						  </button>
						  
						  <button type="submit" class="btn btn-default upload-button" style="{{empty(@$terms->pet_form_term) ? 'display:none;' : '' }}color: #fff;">
							@if (empty(@$terms->pet_form_term))  
							  <span class="fa fa-save"></span> 
								Save
							@endif
							</button>
						</span>
						<input type="text" class="form-control filename2 add-btn" style="{{empty(@$terms->pet_form_term) ? 'display:none;' : '' }}" id="edit_terms" disabled="disabled" value="{{@$terms->pet_form_term}}">
						<span class="input-group-btn"></span>
					</div>
				</form>
			</div>
			<div>
				<a class="add-btn my-3 float-end" href="#" type="button"  data-bs-toggle="modal" data-bs-target="#add-pet-request">Add new</a>
			</div>
		</div>
	</div>
	<div class=" table-responsive tenant-table clear-both ">
		<table class="table  table-bordered " id="myTable">
			<thead>
				<tr>
					<th >Form ID</a></th>
					<th >User Name</a></th>
					<th >Pet Name</a></th>
					<th >Contact Number</a></th>
					<th >Submission Date</a></th>
					<th >Apartment</a></th>
					<th >Property</a></th>
					<th >Status</a></th>
					<th >Form Status</a></th>

					<!-- <th colspan="2"></th> -->
					<th style="background: transparent;"></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($pets as $pet)
				<tr>
					<td><a href="{{route('admin.pet_form_view',$pet->id)}}">{{$pet->id}}</a></td>
					<td>{{@$pet->user->full_name}}</td>
					<td>{{$pet->name}}</td>
					<td>{{@$pet->user->mobile}}</td>
					<td>{{$pet->created_at->todatestring()}}</td>
					<td>{{@$pet->user->apt_number}}</td>
					<td>{{@$pet->user->property}}</td>
					<td>{{@$pet->status}}</td>

					<td>
						@if($pet->form_status==1)
							Publish
						
						@else
							Draft
						
						@endif</td>
					<td class="fw-bold cursor-pointer table-edit" id="{{$pet->id}}" data-bs-toggle="modal" data-bs-target="#edit-pet-request">Edit</td>
					<td class="btn-bg2"><a  type="button"  data-bs-toggle="modal" data-bs-target="#remove-item"  data-petid="{{$pet->id}}" class="table-delete fw-bold">Remove</a></td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>

</main>
<!--Add pet request model start -->
<div class="modal fade" id="add-pet-request"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog ">

		<div class="modal-content border-0 bg-transparent" >
			<div class="modal-body service-select">
				<div class="container-fluid px-0">
					<div class="scnd-type-modal-form-wrapper">
						<form method="post" action="{{route('admin.addPet')}}" enctype="multipart/form-data">
                 			{{csrf_field()}}
						
							<h2 class="form-caption">add pet request</h2>
							<button type="button" class="btn-close-modal float-sm-end float-start mt-0 me-sm-0 me-4" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle" aria-hidden="true"></i></button>
							<!-- frst row -->
							<div class="row">
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">User Name</label>
										<!-- <input type="text" name="username" id="username"> -->
										<select class="custom-select2 userid"  name="userid" style="background-color: #2B2B2B;width: 247px;">
										@foreach($users as $user)
									  	<option value="{{$user->id}}">{{$user->full_name}}</option>
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
										<label for="username">Pet Name</label>
										<input type="text" name="name" required>
									</div>
								</div>
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">Pet Family</label>
										<input type="text" name="family" required>
									</div>
								</div>
							</div>

							<!-- thrd row -->
							<div class="row">
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">Species</label>
										<input type="text" name="species" required>
									</div>
								</div>
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">Size</label>
										<input type="text" name="size" required>
									</div>
								</div>
							</div>

							<!-- frth row -->
							<div class="row">
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">Weight</label>
										<input type="text" name="weight" required>
									</div>
								</div>
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">Submission Date</label>
										<input type="date" name="date" required>
									</div>
								</div>
							</div>

							<!-- fifth row -->
							<div class="row">
								<div class="col-sm-6 col-12">
									<label class="text-white" for="location">Property</label>
									<select name="property_id" class="custom-select2 "style="background-color: #2B2B2B;width: 247px;">
											@foreach($properties as $property)
											<option value="{{$property->id}}">{{$property->name}}</option>
											@endforeach

									</select>
									
								</div>
								<div class="col-sm-6 col-12">
								
									<label class="text-white" for="location">Apartment</label>
									<select name="apartment_id" class="custom-select2 "style="background-color: #2B2B2B;width: 247px;">
											@foreach($apartments as $apartment)
											<option value="{{$apartment->id}}">{{$apartment->name}}</option>
											@endforeach

									</select>
								</div>
							</div>

							<!-- sixth row -->
							<div class="row">
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">Phone Number</label>
										<input type="text" name="mobile" required>
									</div>
								</div>
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">Status</label>
										<!-- <input type="text" name="status" readonly> -->
										<select class="custom-select2" id="add-maintenance-form-status" name="status" style="background-color: #2B2B2B;width: 247px;">
											<option value="pending">Pending</option>
											<option value="approved">Approved</option>
											<option value="rejected">Rejected</option>	
											<option value="cancelled">Cancelled</option>				
														
										</select>
									</div>
								</div>
							</div>

							<!-- svnth row -->
							<div class="row">
								<div class="input-field-group col-sm-6 col-12">
									<input class="form-check-input" type="radio" value="1" name="term" required> <span for="condition" class="input-radio-checked">Terms & Conditions</span>
								</div>
							</div>

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
<div class="modal fade" id="edit-pet-request"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog ">
		
		<div class="modal-content border-0 bg-transparent" >
			<div class="modal-body service-select">
				<div class="container-fluid px-0">
					<div class="scnd-type-modal-form-wrapper">
						<form method="post" action="{{route('admin.addPet')}}" enctype="multipart/form-data" id="editform">
                 			{{csrf_field()}}
                 			<input type="hidden" name="pet_id" id="pet_id">
						
							<h2 class="form-caption">Edit pet request</h2>
							<button type="button" class="btn-close-modal float-sm-end float-start mt-0 me-sm-0 me-4" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle" aria-hidden="true"></i></button>
							<!-- frst row -->
							<div class="row">
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">User Name</label>
										<!-- <input type="text" name="username" id="username"> -->
										<select class="custom-select2 edit_userid" id="tuserid" name="userid" style="background-color: #2B2B2B;width: 247px;">
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
										<label for="username">Pet Name</label>
										<input type="text" name="name" id="name" required>
									</div>
								</div>
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">Pet Family</label>
										<input type="text" name="family" id="family" required>
									</div>
								</div>
							</div>

							<!-- thrd row -->
							<div class="row">
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">Species</label>
										<input type="text" name="species" id="species" required>
									</div>
								</div>
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">Size</label>
										<input type="text" name="size" id="size" required>
									</div>
								</div>
							</div>

							<!-- frth row -->
							<div class="row">
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">Weight</label>
										<input type="text" name="weight" id="weight" required>
									</div>
								</div>
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">Submission Date</label>
										<input type="date" name="date" id="date" required>
									</div>
								</div>
							</div>

							<!-- fifth row -->
							<div class="row">
								<div class="col-sm-6 col-12">
								<label class="text-white" for="location">Property</label>
									<select name="property_id" id="property_id" class="custom-select2 "style="background-color: #2B2B2B;width: 247px;">
											@foreach($properties as $property)
											<option value="{{$property->id}}">{{$property->name}}</option>
											@endforeach

									</select>
								</div>
								<div class="col-sm-6 col-12">
										<label class="text-white" for="location">Apartment</label>
									<select name="apartment_id" id="apartment_id" class="custom-select2 "style="background-color: #2B2B2B;width: 247px;">
											@foreach($apartments as $apartment)
											<option value="{{$apartment->id}}">{{$apartment->name}}</option>
											@endforeach

									</select>
								</div>
							</div>

							<!-- sixth row -->
							<div class="row">
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">Phone Number</label>
										<input type="text" name="mobile" id="mobile" required>
									</div>
								</div>
								<div class="col-sm-6 col-12">
									<div class="input-field-group">
										<label for="username">Status</label>
										<!-- <input type="text" name="status" id="status" readonly> -->
										<select class="custom-select2" id="status" name="status" style="background-color: #2B2B2B;width: 247px;">
											<option value="pending">Pending</option>
											<option value="approved">Approved</option>
											<option value="rejected">Rejected</option>	
											<option value="cancelled">Cancelled</option>				
														
										</select>
									</div>
								</div>
							</div>

							<!-- svnth row -->
							<div class="row">
								<div class="input-field-group col-sm-6 col-12">
									<input class="form-check-input" type="radio" value="1" name="term" id="term" required> <span for="condition" class="input-radio-checked">Terms & Conditions</span>
								</div>
							</div>

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
      <form method="POST" action="{{ route('admin.deletePet','pet') }}">
      {{method_field('delete')}}
      {{csrf_field()}}
      <div class="modal-body">
        <div class="remove-content-wrapper">
          <p>Are you sure you want to delete?</p>
          <input type="hidden" name="petid" id="petid" value="">

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
                url  : "{{route('admin.getPet')}}",
                type : 'Post',
                data :{'id':id,_token:'{{ csrf_token() }}'},
                dataType: 'json', 
                beforeSend: function(){
				    // Show image container
				    $("#loader").show();
				},   
                success : function(response) {
                        // console.log(response.images[0].path);
        			$('#pet_id').val(response.id);            
        			$('#name').val(response.name);
        			$('#family').val(response.family);
        			$('#date').val(response.created_at);
        			$('#edit_userid').val(response.user_id);
        			$('#species').val(response.species);
        			$('#size').val(response.size);
        			$('#weight').val(response.weight);
        			// $('#status').val(response.status);
        			
        			if(response.user!=null){
        			$('#mobile').val(response.user.mobile);

        			$('#property_id').val(response.user.userpropertyrelation.property_id).attr("selected", "selected");
        			$('#apartment_id').val(response.user.userpropertyrelation.apartment_id).attr("selected", "selected");
	        		}else{
	        			$('#property_id').val('');
        			     $('#apartment_id').val('');
	        		}
        			$('#tuserid').val(response.user_id).attr("selected", "selected");
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

	    var petid = button.data('petid') 
	    var modal = $(this)

	    modal.find('.modal-body #petid').val(petid);
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
        data :{type : 'pets',_token:'{{ csrf_token() }}'},
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