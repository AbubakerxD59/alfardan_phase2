@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Alfardan Living Profile')

@section('content')

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position border border-primary">
  @include('notification.notify')
  @if($errors->any())
      @foreach($errors->all() as $error)
        <div class="alert alert-danger">
          {{$error}}
        </div>
      @endforeach
    @endif
	<div class="row">
		<div class="col-xxl-6 col-xl-6 col-12">
			<h2 class="table-cap  mb-2">Alfardan Living Profile</h2>
			<div class="alfarada-living-wrapper">
				 <form method="post" action="{{route('admin.alfardanProfile')}}" enctype="multipart/form-data">
                 {{csrf_field()}}
                 <input type="hidden" name="profileid" value="{{$profiles[0]->id}}">
					<div class="row">
						<div class="col-xxl-5 col-xl-5 col-lg-4 col-md-5 col-sm-5 ">
							<div class="profile-img-holder mb-3">
									<a href="javascript:void(0)" 
									   data-bs-toggle="modal" 
									   data-bs-target="#remove-item" 
									   data-id="{{$profiles[0]->id}}" 
									   data-url="{{route('admin.deleteprofilephoto',[$profiles[0]->id,'photo'])}}" 
									   class="deleteitem cross-img">X</a>
				
								<figcaption>Image 1</figcaption>
								<div id="alfarada-img1-preview" class="image-preview" style="background-image: url({{$profiles[0]->photo}});">
									<label for="alfarada-img1-upload" id="alfarada-img1-label">EDIT IMAGE</label>
									<input type="file" name="image" id="alfarada-img1-upload" />
								</div> 
							</div>
						</div>
						<div class="col-xxl-7 ps-xl-5  ps-xxl-4 ps-lg-0 ps-md-4 col-xl-7 col-lg-8 col-md-7 col-sm-7">
							<div class="input-field-group ">
								<label for="username">Ttile 1</label>
								<input class="w-100" type="text" name="title" required value="{{$profiles[0]->title}}">
							</div>
							<div class="input-field-group ">
								<label for="username">Description 1</label>
								<textarea name="description" required> {{$profiles[0]->description}}</textarea>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xxl-5 col-xl-5 col-lg-4 col-md-5 col-sm-5">
							<div class="profile-img-holder mb-3">
								<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remove-item" data-id="{{$profiles[0]->id}}" data-url="{{route('admin.deleteprofilephoto',[$profiles[0]->id,'photo1'])}}" class="deleteitem cross-img" tabindex="0">X</a>
				
								<figcaption>Image 2</figcaption>
								<div id="alfarada-img2-preview" class="image-preview" style="background-image: url({{$profiles[0]->photo1}});">
									<label for="alfarada-img2-upload" id="alfarada-img2-label">EDIT IMAGE</label>
									<input type="file" name="image1" id="alfarada-img2-upload" />
								</div> 
							</div>
						</div>
						<div class="col-xxl-7 ps-xxl-4 ps-xl-5 col-xl-7 col-lg-8 col-sm-7 col-md-7 ps-lg-0 ps-md-4">
							<div class="input-field-group ">
								<label for="username">Ttile 2</label>
								<input class="w-100" type="text" name="title1" required value="{{$profiles[0]->title1}}">
							</div>
							<div class="input-field-group ">
								<label for="username">Description 2</label>
								<textarea name="description1" required>{{$profiles[0]->description1}}</textarea>
							</div>
						</div>
					</div>
					<!-- scnd row -->
		            <div class="row">
		                <div class="col-12">
		                  <div class="btn-holder">
		                   <button class="form-btn" type="submit" style="background-color: #C89328;">Update</button>
		                    <!-- <a href="#">Draft</a> -->
		                  </div>
		                </div>
		            </div>
				</form>
			</div>
		</div>
		<div class="col-xxl-6 col-xl-6 col-12">
			<div>
				<h2 class="table-cap  mb-2">FAQ</h2>
				<a class="add-btn my-3 px-0" href="#" type="button"  data-bs-toggle="modal" data-bs-target="#add-question">Add new question</a>
			</div>
			<div class=" table-responsive tenant-table" >
				<table class="table  table-bordered" id="myTable">
					<thead>
						<tr>
							<th>Question</th>
							<th>Answer</th>
							<th style="background: transparent;"></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($faqs as $faq)
						<tr>
							<td class="p-2">
								<p class="text-start fs-13">{{$faq->questions}}</p>
							</td>
							<td class="p-2">
								<p class="text-start fs-13">
									{{$faq->answers}}
								</p>
							</td>
							<td class="table-edit fw-bold table-edit" id="{{$faq->id}}" data-bs-toggle="modal" data-bs-target="#edit-question">Edit</td> 
							<td  class=" fw-bold" data-faqid="{{$faq->id}}" data-bs-toggle="modal" data-bs-target="#remove-item">REMOVE</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</main>
<!-- add question model start -->
<div class="modal fade" id="add-question"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog ">
    
    <div class="modal-content  bg-transparent border-0">
      <div class="modal-body">
        <div class="container-fluid px-0">
          <div class="scnd-type-modal-form-wrapper">
            <form method="post" action="{{route('admin.addFaq')}}" enctype="multipart/form-data">
                {{csrf_field()}}
              <h2 class="form-caption">add Question</h2>
              <button type="button" class="btn-close-modal float-end mt-0 me-0" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
              <!-- frst row -->
              <div class="row">
                <div class="col-12">
                  <div class="input-field-group">
                    <label >Question</label>
                    <textarea class="description" name="question" required></textarea>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class=" col-12">
                  <div class="input-field-group">
                    <label >Answer</label>
                    <textarea class="description" name="answer" required></textarea>
                  </div>
                </div>
              </div>

              <!-- scnd row -->
              <div class="row">
                <div class="col-12">
                  <div class="btn-holder">
                   <button class="form-btn" type="submit">Publish</button>
                    <a href="#">Draft</a>
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
<!-- add question model end -->
<!-- edit question model start -->
<div class="modal fade" id="edit-question"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog ">
    
    <div class="modal-content  bg-transparent border-0">
      <div class="modal-body">
        <div class="container-fluid px-0">
          <div class="scnd-type-modal-form-wrapper">
            <form method="post" action="{{route('admin.addFaq')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" name="faq_id" id="faq_id">
              <h2 class="form-caption">Edit Question</h2>
              <button type="button" class="btn-close-modal float-end mt-0 me-0" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
              <!-- frst row -->
              <div class="row">
                <div class="col-12">
                  <div class="input-field-group">
                    <label >Question</label>
                    <textarea class="description" name="question" required id="question"></textarea>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class=" col-12">
                  <div class="input-field-group">
                    <label >Answer</label>
                    <textarea class="description" name="answer" required id="answer"></textarea>
                  </div>
                </div>
              </div>

              <!-- scnd row -->
              <div class="row">
                <div class="col-12">
                  <div class="btn-holder">
                    <button class="form-btn" type="submit">Publish</button>
                    <a href="#">Draft</a>
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
<!-- edit question model end -->
<!-- delete modal start -->
<div class="modal remove-item" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-transparent border-0">
      <form method="POST" action="{{ route('admin.deleteFaq','user') }}">
      {{method_field('delete')}}
      {{csrf_field()}}
      <div class="modal-body">
        <div class="remove-content-wrapper">
          <p>Are you sure you want to delete?</p>
          <input type="hidden" name="faqid" id="faqid" value="">

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
        
        $('.table-edit').click(function(e) {
            e.preventDefault(); // prevent form from reloading page
          
            var id=$(this).attr('id');

            $.ajax({
                url  : "{{route('admin.getFaq')}}",
                type : 'Post',
                data :{'id':id,_token:'{{ csrf_token() }}'},
                dataType: 'json',    
                success : function(response) {
                        // console.log(response.images[0].path);
        			$('#faq_id').val(response.id);            
        			$('#question').val(response.questions);
        			$('#answer').val(response.answers);
        			
                }
            });
        });
    });

    // delete popup modal
    $('#remove-item').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var modal = $(this);
		
		if(button.hasClass("deleteitem")){
			modal.find('form').attr("action",button.data("url"));
		 }else{
			 
        var faqid = button.data('faqid') ;
			modal.find('.modal-body #faqid').val(faqid);
		}
    })
    $(document).ready(function() {
    	$.uploadPreview({
      // for add modal
      input_field: "#alfarada-img1-upload",
      preview_box: "#alfarada-img1-preview",
      label_field: "#alfarada-img1-label"
  		});

    	$.uploadPreview({
      // for add modal
      input_field: "#alfarada-img2-upload",
      preview_box: "#alfarada-img2-preview",
      label_field: "#alfarada-img2-label"
  		});

    });
	
</script>

<style>
 
	.profile-img-holder>a.deleteitem.cross-img {
		position: absolute;
		z-index: 99;
		right: 0;
		top: -13px;
		background: #000;
		border-radius: 100%;
		padding: 3px 6px;
	}	 
</style>
@endpush