@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Survey')

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
		<h2 class="table-cap pb-2 float-start text-capitalize">Survey</h2>
		<a class="add-btn my-3 float-end" href="#" type="button"  data-bs-toggle="modal" data-bs-target="#add-servay">ADD NEW SURVEY</a>
	</div>
	<div class=" table-responsive tenant-table clear-both ">
		<table class="table  table-bordered " id="myTable">
			<thead>
				<tr>
					<th>Survey ID</th>
					<th>Survey Name</th>
					<th>Survey Link</th>
					<!-- <th>Apartment</th> -->
					<th>Property</th>
					<th>Tenant Type</th>
					<th>Status</th>
					<th style="background: transparent;"></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($surveys as $survey)
				<tr>
					<td>{{$survey->survey_id}}</td>
					<td>{{$survey->name}}</td>
					<td>{{$survey->link}}</td>
					<!-- <td>{{@$survey->apartment->name}}</td> -->
					<td>{!!@$survey->property()->implode('name',',<br/>')!!}</td>
					<td>{{@$survey->tenant_type}}</td>
					<td>@if($survey->status==1)
							Publish
						
						@else
							Draft
						
						@endif</td>
					<td class="fw-bold cursor-pointer table-edit" id="{{$survey->id}}" data-bs-toggle="modal" data-bs-target="#edit-servay">Edit</td>
					<td class="btn-bg2"><a  type="button" data-bs-toggle="modal" data-bs-target="#remove-item"  data-surveyid="{{$survey->id}}" class="table-delete fw-bold">Remove</a></td>
				</tr>
				@endforeach
				
			</tbody>
		</table>
	</div>

</main>
<!--Add servay form model start -->
<div class="modal fade show" id="add-servay"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">

		<div class="modal-content">
			<div class="modal-body profile-model">
				<div class="container-fluid px-0">
					<div class="row">
						
						<div class="col-12">
							<div class="body-wrapper">
								<h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">Add Survey</h2>
										<button type="button" class="btn-close-modal float-end mt-0 me-0" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
								
								
						<form method="post" action="{{route('admin.addSurvey')}}" enctype="multipart/form-data">
                 			{{csrf_field()}}
							
							<!-- frst row -->
							<div class="row">
										
										<div class="col-xxl-3 col-xl-3 col-lg-8 col-md-8 ps-4 label-size ">
											<div class="add-family-form-wrapper ">
												<label>Survey Name</label>
												<input type="text" name="name" required="required">
											</div>
											<label style="color:white;">Property Name</label>
                      <div class="property-input-wrapper label-name addp">
						  
						 					 @foreach($properties as $property)
												<div class="form-check form-check-inline ">
													<input class="form-check-input" name="property[]" type="checkbox" id="property{{$property->id}}" value="{{$property->id}}">
													<label class="form-check-label" for="property{{$property->id}}">{{$property->name}}</label>
													</div>
						  					@endforeach					  						
											 
												</div>
										</div>
										<div class="col-xxl-4 col-xl-3 col-lg-4 col-md-4  cutom-property edita">
											<div class="add-family-form-wrapper ">
												<label>Survey ID</label>
												<input type="text" name="surveyid" required="required">
											</div>
    										<label class="text-white" for="location">Apartment</label>
											<select name="apartment_id[]" class="custom-select2  " multiple id="multiselect-drop2" 
													style="background-color: #2B2B2B;width: 247px;">
													@foreach($apartments as $apartment)
													<option value="{{$apartment->id}}">{{$apartment->name}}</option>
													@endforeach
											</select>
    										<label class="text-white" for="tenant">Tenants</label>
											<select name="tenant_id[]" class="custom-select2  " multiple id="multiselect-drop5" 
													style="background-color: #2B2B2B;width: 247px;">
													@foreach($tenants as $tenant)
													<option value="{{$tenant->id}}">{{$apartment->name}}</option>
													@endforeach
											</select>
										</div>
										 
										<div class="col-xxl-4 col-xl-3 col-lg-4 col-md-4 cutom-property">
											<div class="add-family-form-wrapper ">
												<label>Survey Link</label>
												<input type="text" name="link"  required="required">								
											</div> 
											
											
												<div class="col-sm-12 col-12 profile-tenant-form">
													<label>Tenant</label><br/>
													<div class="form-check form-check-inline">
														<input class="form-check-input" type="checkbox"  name="tenant_type[]" value="Elite" >
														<label class="form-check-label" for="inlineCheckbox1">Elite</label>
													</div>

													<div class="form-check form-check-inline">
														<input class="form-check-input" name="tenant_type[]" type="checkbox" value="Regular">
														<label class="form-check-label" for="inlineCheckbox2">Regular</label>
													</div>

													<!--<div class="form-check form-check-inline mb-2">
														<input class="form-check-input" name="tenant_type[]" type="checkbox" value="Privilege">
														<label class="form-check-label" for="inlineCheckbox3">Privilege</label>
													</div>-->
												</div>
										</div>

									</div>
							<!-- frth row -->
							<div class="row">
								<div class="col-12">
									<div class="form-btn-holder mb-3 text-end  me-xxl-0">
										<!-- <button class="form-btn" type="submit">Publish</button>
										<a href="#">Draft</a> -->
										<input class="form-btn publish" name="publish" type="submit" value="Publish" />
										<input type="submit" name="draft" value="Draft" class="draft" /> 
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


	</div>
</div>
<!--Add servay form model end -->
<!--edit servay form model start -->
<div class="modal fade show" id="edit-servay" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-modal="true" role="dialog" style="padding-right: 17px; display: none; padding-left: 0px;">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-body profile-model">
				<div class="container-fluid px-0">
					<div class="row">
						<div class="col-12">
							<div class="body-wrapper">
								<h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">Edit Survey</h2>
								<button type="button" class="btn-close-modal float-sm-end float-start mt-0 me-sm-0 me-4" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle" aria-hidden="true"></i></button>
								<form method="post" enctype="multipart/form-data" action="{{route('admin.addSurvey')}}">
              					 	{{csrf_field()}}
	              					<input type="hidden" name="survey_id" id="survey_id" value=""/>
									<div class="row">
										
										<div class="col-xxl-3 col-xl-3 col-lg-8 col-md-8 ps-4 label-size ">
											<div class="add-family-form-wrapper ">
												<label>Survey Name</label>
												<input type="text" name="name" id="name" required="required">
											</div>
											<label style="color:white;">Property Name</label>
                      <div class="property-input-wrapper label-name editc">
						  
						 					 @foreach($properties as $property)
												<div class="form-check form-check-inline ">
													<input class="form-check-input property_radio" name="property[]" type="checkbox" id="property{{$property->id}}" value="{{$property->id}}">
													<label class="form-check-label" for="property{{$property->id}}">{{$property->name}}</label>
													</div>
						  					@endforeach					  						
											 
												</div>
										</div>
										<div class="col-xxl-4 col-xl-3 col-lg-4 col-md-4  cutom-property edita">
											<div class="add-family-form-wrapper ">
												<label>Survey ID</label>
												<input type="text" name="surveyid" id="surveyid" required="required">
											</div>
    										<label class="text-white" for="location">Apartment</label>
											<select name="apartment_id[]" class="custom-select2  " multiple id="multiselect-drop1" 
													style="background-color: #2B2B2B;width: 247px;">
													@foreach($apartments as $apartment)
													<option value="{{$apartment->id}}">{{$apartment->name}}</option>
													@endforeach
											</select>
    										<label class="text-white" for="tenant">Tenants</label>
											<select name="tenant_id[]" class="custom-select2  " multiple id="multiselect-drop4" 
													style="background-color: #2B2B2B;width: 247px;">
													@foreach($tenants as $tenant)
													<option value="{{$tenant->id}}">{{$tenant->name}}</option>
													@endforeach
											</select>
										</div>
										 
										<div class="col-xxl-4 col-xl-3 col-lg-4 col-md-4 cutom-property">
											<div class="add-family-form-wrapper ">
												<label>Survey Link</label>
												<input type="text" name="link" id="link"  required="required">								
											</div> 
											
											
												<div class="col-sm-12 col-12 profile-tenant-form">
													<label>Tenant</label><br/>
													<div class="form-check form-check-inline">
														<input class="form-check-input tenantcheck" type="checkbox"  name="tenant_type[]" value="Elite" >
														<label class="form-check-label" for="inlineCheckbox1">Elite</label>
													</div>

													<div class="form-check form-check-inline">
														<input class="form-check-input tenantcheck" name="tenant_type[]" type="checkbox" value="Regular">
														<label class="form-check-label" for="inlineCheckbox2">Regular</label>
													</div>

													<!--<div class="form-check form-check-inline mb-2">
														<input class="form-check-input tenantcheck" name="tenant_type[]" type="checkbox" value="Privilege">
														<label class="form-check-label" for="inlineCheckbox3">Privilege</label>
													</div>-->
												</div>
										</div>

									</div>
									<div class="form-btn-holder mb-3 text-end  me-xxl-0">
									
										<input class="form-btn publish" name="publish" type="submit" value="Publish">
										<input type="submit" name="draft" value="Draft" class="draft">
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--Edit servay form model start -->
<!-- delete modal start -->
<div class="modal remove-item" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-transparent border-0">
      <form method="POST" action="{{ route('admin.deleteSurvey','survey') }}">
      {{method_field('delete')}}
      {{csrf_field()}}
      <div class="modal-body">
        <div class="remove-content-wrapper">
          <p>Are you sure you want to delete?</p>
          <input type="hidden" name="surveyid" id="surveyid" value="">

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
<script>
	$(function() {

        $('.addp input').click(function(e) {
						 var allprids=[];
							$('.addp input:checked').each(function(i, obj) {
							     	allprids.push($(this).val());
							});

							  $.ajax({
	              url  : "{{route('admin.apartmentslist')}}",
	              type : 'Post',
	              data :{'ids':allprids,_token:'{{ csrf_token() }}'},
	              dataType: 'json', 
	              beforeSend: function(){
				    			// Show image container
				    			$("#loader").show();
								},success : function(response) {
									
									$("#multiselect-drop2").html("");

									$.each(response, function( index, value ) {
											var option={ 
									        value: value.id,
									        text : value.name
									    };
									   	$("#multiselect-drop2").append($('<option>',option));
									});

									$("#multiselect-drop2").multiselect('reload');

	      				},complete:function(data){
								    // Hide image container
								    $("#loader").hide();
								} 
							});
						});


        // $('.editc input').click(function(e) {
		// 				 var allprids=[];
		// 				$('.editc input:checked').each(function(i, obj) {
		// 				     	allprids.push($(this).val());
		// 				});

		// 					  $.ajax({
	    //           url  : "{{route('admin.apartmentslist')}}",
	    //           type : 'Post',
	    //           data :{'ids':allprids,_token:'{{ csrf_token() }}'},
	    //           dataType: 'json', 
	    //           beforeSend: function(){
		// 		    			// Show image container
		// 		    			$("#loader").show();
		// 						},success : function(response) {
		// 							var aps=$("#multiselect-drop1").data("apartment_id").split(",");
									
		// 							$("#multiselect-drop1").html("");

		// 							$.each(response, function( index, value ) {
		// 									var option={ 
		// 							        value: value.id,
		// 							        text : value.name
		// 							    };
		// 							    if(jQuery.inArray(value.id, aps) !== -1){
		// 							    	option.selected="selected";
		// 							    }

		// 							   	$("#multiselect-drop1").append($('<option>',option));
		// 							});

		// 							$("#multiselect-drop1").val(aps);

		// 							$("#multiselect-drop1").multiselect('reload');

	    //   				},complete:function(data){
		// 						    // Hide image container
		// 						    $("#loader").hide();
		// 						} 
		// 					});
		// 				});


						$('.editc input').click(function(e) {
						 var allprids=[];
						$('.editc input:checked').each(function(i, obj) {
						     	allprids.push($(this).val());
						     	// allprids.push(37);
						});

							$.ajax({
								url  : "{{route('admin.tenantslist')}}",
								type : 'Post',
								data :{'ids':allprids,_token:'{{ csrf_token() }}'},
								dataType: 'json', 
								beforeSend: function(){
				    			// Show image container
				    			$("#loader").show();
							},success : function(response) {
								var aps=$("#multiselect-drop5").data("apartment_id").split(",");
								
								$("#multiselect-drop5").html("");

								$.each(response, function( index, value ) {
										var option={ 
										value: value.id,
										text : value.name
									};
									if(jQuery.inArray(value.id, aps) !== -1){
										option.selected="selected";
									}

									$("#multiselect-drop5").append($('<option>',option));
								});

								$("#multiselect-drop5").val(aps);

								$("#multiselect-drop5").multiselect('reload');

	      					},complete:function(data){
								    // Hide image container
								$("#loader").hide();
							} 
						});
					});

        
        // $('.table-edit').click(function(e) {
        $("#myTable").on("click", ".table-edit", function(e){	
            e.preventDefault(); // prevent form from reloading page
          $('#editform').trigger("reset");
            var id=$(this).attr('id');

            $.ajax({
                url  : "{{route('admin.getSurvey')}}",
                type : 'Post',
                data :{'id':id,_token:'{{ csrf_token() }}'},
                dataType: 'json',
                beforeSend: function(){
				    // Show image container
				    $("#loader").show();
				},    
                success : function(response) {
                        // console.log(response.images[0].path);
        			$('#survey_id').val(response.id);            
        			$('#name').val(response.name);
        			$('#link').val(response.link);
        			$('#surveyid').val(response.survey_id);
        			// $('#property_id').val(response.property_id).attr("selected", "selected");
        			//$('#apartment_id').val(response.apartment_id).attr("selected", "selected");
					var name=[];
					
						$('#multiselect-drop1 option').each(function() {
						  $(this).prop("selected", false);
						});
					
					
						$('input.property_radio').each(function() {
						  $(this).prop('checked', false);
						});
						var property=[];
			        if(response.property_id!=null){
			        	property=response.property_id.split(',');
			            for(var i=0; i< property.length; i++){			            
			              	$('input.property_radio[value="'+property[i]+'"]').prop('checked', true);
			            }
			        }

							$("#multiselect-drop1").val(response.apartment_id.split(","));
							$("#multiselect-drop1").data("apartment_id",response.apartment_id);

							  $.ajax({
	              url  : "{{route('admin.apartmentslist')}}",
	              type : 'Post',
	              data :{'ids':property,_token:'{{ csrf_token() }}'},
	              dataType: 'json', 
	              beforeSend: function(){
				    			// Show image container
				    			$("#loader").show();
								},success : function(response) {
									var aps=$("#multiselect-drop1").data("apartment_id").split(",");
									
									$("#multiselect-drop1").html("");

									$.each(response, function( index, value ) {
											var option={ 
									        value: value.id,
									        text : value.name
									    };
									    if(jQuery.inArray(value.id, aps) !== -1){
									    	option.selected="selected";
									    }

									   	$("#multiselect-drop1").append($('<option>',option));
									});

									$("#multiselect-drop1").val(aps);

									$("#multiselect-drop1").multiselect('reload');

	      				},complete:function(data){
								    // Hide image container
								    $("#loader").hide();
								} 
							});
							  $.ajax({
	              url  : "{{route('admin.tenantslist')}}",
	              type : 'Post',
	              data :{'ids':property,_token:'{{ csrf_token() }}'},
	              dataType: 'json', 
	              beforeSend: function(){
				    			// Show image container
				    			$("#loader").show();
								},success : function(response) {
									// var aps=$("#multiselect-drop4").data("apartment_id").split(",");
									console.log(response);
									$("#multiselect-drop4").html("");

									$.each(response, function( index, value ) {
											var option={ 
									        value: value.id,
									        text : value.full_name
									    };
									    // if(jQuery.inArray(value.id, aps) !== -1){
									    // 	option.selected="selected";
									    // }

									   	$("#multiselect-drop4").append($('<option>',option));
									});

									// $("#multiselect-drop4").val(aps);

									$("#multiselect-drop4").multiselect('reload');

	      				},complete:function(data){
								    // Hide image container
								    $("#loader").hide();
								} 
							});
					

					if(response.apartment_id>0){
						response.apartment_id=parseInt(response.apartment_id);
					 $("#multiselect-drop1 option[value='" + response.apartment_id + "']").prop("selected", true);
						
						var input=$('.edita>.ms-options-wrap>.ms-options>ul>li input[value="'+response.apartment_id+'"]' );
							if(input){
								//input.attr("checked", "checked");
								if(!input.prop("checked")){
								  	input.trigger( "click" );
									//input.trigger( "change" );
									name.push(input.attr('title')); 
								 }else{
									 name.push(input.attr('title')); 
								 }
							}
						
					}else if(response.apartment_id !=0 ){
						$.each(response.apartment_id.split(","), function(i,e){
						  $("#multiselect-drop1 option[value='" + e + "']").prop("selected", true);
							var input=$('.edita>.ms-options-wrap>.ms-options>ul>li input[value="'+e+'"]' );
							if(input){
								//input.attr("checked", "checked");
								if(!input.prop("checked")){
								  	input.trigger( "click" );
									//input.trigger( "change" );
									name.push(input.attr('title')); 
								 }else{
									 name.push(input.attr('title')); 
								 }
								
							}
						});
					}
					if(name.length>0){
						$('.edita>.ms-options-wrap>button').html(name.join(","));
					}else{
						$('.edita>.ms-options-wrap>button').html("Select Apartment");
					}
					
					
					
					$('input.tenantcheck').each(function() {
						  $(this).prop('checked', false);
						});
					
        			if(response.tenant_type!=null){
		            	var tenant_type=response.tenant_type.split(',');
			            for(var i=0; i<= 3; i++){
			              if(i<tenant_type.length){
			              	$('input.tenantcheck[value="'+tenant_type[i]+'"]').prop('checked', true);
			              }

			            }
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

        var surveyid = button.data('surveyid') 
        var modal = $(this)

        modal.find('.modal-body #surveyid').val(surveyid);
    })

	
</script>

<style>
.property-input-wrapper.label-name>.form-check.form-check-inline label.form-check-label {
    color: #fff;
}
</style>
@endpush