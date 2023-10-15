@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Concierge')

@section('content')

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position buy-sel-wrapper">
	@include('notification.notify')
	@if($errors->any())
  	@foreach($errors->all() as $error)
    <div class="alert alert-danger">
      {{$error}}
    </div>
  	@endforeach
 	@endif
 	<h2 class="table-cap pb-1 mb-3">Concierge</h2>
 	
 	<form method="post" action="{{route('admin.addConciergeBanner')}}" enctype="multipart/form-data">
 	{{csrf_field()}}
 	<input type="hidden" name="id" value="{{@$concierge->id}}">
		<div class="col-6 d-flex justify-content-between">
			<div class="profile-img-holder add-event-img-holder  mb-3 concierge-img">
				<figcaption>Banner Photo</figcaption>
				<div id="add-class-img-preview-modal1" class="image-preview " style="background-image: url({{@$concierge->banner}});">
					<input type="file" name="banner" id="add-class-img-upload-modal1" onclick="addimage('add-class-img-upload-modal1','add-class-img-preview-modal1','add-class-img-label-modal1')" value="{{$concierge->banner}}">
				</div>
				<p class="dimensions">Dimensions:1000x1000 px</p>
			</div>
			{{-- <div class="profile-img-holder add-event-img-holder  mb-3 concierge-img">
				<figcaption>Safety Handbook</figcaption>
				<div id="add-class-img-preview-modal2" class="image-preview " style="background-image: url({{@$concierge->safety}});">
					<input type="file" name="safety" id="add-class-img-upload-modal2" onclick="addimage('add-class-img-upload-modal2','add-class-img-preview-modal2','add-class-img-label-modal2')">
				</div>
				<p class="dimensions">Dimensions:1000x1000 px</p>
			</div> --}}
		</div> 	
		<div class="concierge-btn"></div>
		<div class="col-6 d-flex justify-content-between">
			<button class="form-btn concierge-submit mt-4" type="submit" style="background-color: #C89328;">Update</button>
			<form method="POST" action="{{route('admin.pet_form_term')}}" enctype="multipart/form-data">
				@csrf
				<div class="input-field-group upload-pdf m-0 col-6">
					<span class="input-group-btn" style="cursor: pointer;">
					  <div class="btn btn-default browse-button2">
						<span class="browse-button-text2 text-white" style="cursor: pointer;">
						@if (empty(@$concierge->safety))
						<i class="fa fa-upload"></i> 
						Safety Handbook
						@else
						<i class="fa fa-refresh"></i>
						Change
						@endif
						</span>
						<input type="file" accept=".pdf" name="safety" class="w-100">
					  </div>
					  @if(!empty(@$concierge->safety))
						<button type="button" class="btn btn-default clear-button" style="{{empty(@$concierge->safety) ? 'display:none;' : '' }}color: #fff;">
							<span class="fa fa-trash"></span> 
							Delete
						</button>
						<button type="submit" class="btn btn-default upload-button" style="{{empty(@$concierge->safety) ? 'display:none;' : '' }}color: #fff;">
							@if (empty(@$concierge->safety))  
							<span class="fa fa-save"></span> 
								Save
							@endif
						</button>
					  @endif
					</span>
					<input type="text" class="form-control filename2 add-btn" style="{{empty(@$concierge->safety) ? 'display:none;' : '' }}" id="edit_terms" disabled="disabled" value="{{@$concierge->safety}}">
					<span class="input-group-btn"></span>
				</div>
			</form>
		</div>
			@if(!empty($concierge))
			<a href="{{route('admin.deleteConciergeBanner',$concierge->id)}}" class="event-delete-btn float-end">Delete</a>
			@endif
		</div>
 	</form>
</main>

@endsection
@push('script')
<script>
	function addimage(input,box,lable){

	  	$.uploadPreview({
	    input_field:"#"+input ,
	    preview_box: "#"+box ,
	    label_field: "#"+lable 
	  	});
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
			data :{type : 'concierge',_token:'{{ csrf_token() }}'},
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