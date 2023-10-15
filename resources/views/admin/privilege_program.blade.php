@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Privilage Program')

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
	<h2 class="table-cap pb-1 text-capitalize">privilege program</h2>
	<!-- <a class="add-btn my-2 px-1"  type="button">Update brochure</a> -->
  <form method="post" enctype="multipart/form-data" action="{{route('admin.addPrivilegeBrochure')}}">
    {{csrf_field()}}
    <input type="hidden" name="privilegeid" value="{{@$privileges[0]->id}}">
	 <div class="d-flex">
     <div class="input-field-group upload-pdf col-6">
       <!-- <label for="Contract">Update brochure</label> -->
       <!-- <input type="text" name="contract" id="Contract"> -->
       <span class="input-group-btn">
         <div class="btn btn-default browse-button2">
          <!-- <label class="px-2 text-white">Update brochure</label> -->
          <span class="browse-button-text2 text-white">
           <i class="fa fa-folder-open"></i> UPDATE BROCHURE </span>
           <input type="file" accept=".pdf" name="brochure"/>
         </div>
         <button type="button" class="btn btn-default clear-button" style="display:none;color: #fff;">
           <span class="fa fa-times"></span> Clear
         </button>
       </span>
       <input type="text" class="form-control filename2 add-btn" id="contract" disabled="disabled" value="{{@$privileges[0]->file}}">
       <span class="input-group-btn"></span>
     </div>
     <div class="col-6">
       <h2 class="table-cap">FAQ</h2>
       <a class="add-btn my-3 px-0" href="#" type="button"  data-bs-toggle="modal" data-bs-target="#add-question">Add new question</a>
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
    <div class="row mt-5">
        <div class="col-12">
          <div class="btn-holder">
           <button class="form-btn" type="submit" style="background-color: #C89328;">Update</button>
            <!-- <a href="#">Draft</a> -->
          </div>
        </div>
    </div>
  </form>
  <form action="">
  </form>
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
                   <input type="hidden" name="type" value="privilege">
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
  // Show filename, show clear button and change browse 
  //button text when a valid extension file is selected
  $(".browse-button2 input:file").change(function (){
    $("input[name='brochure']").each(function() {
      var fileName = $(this).val().split('/').pop().split('\\').pop();
    
      $(".filename2").val(fileName);
      $(".browse-button-text2").html('<i class="fa fa-refresh"></i> Change');
      $(".clear-button").show();
    });
  });
  //actions happening when the button is clicked
  $('.clear-button').click(function(){
    
    $('.filename2').val("");
    $('.clear-button').hide();
    $('.browse-button2 input:file').val("");
    $(".browse-button-text2").html('<i class="fa fa-folder-open"></i> Browse'); 
  });
</script>
@endpush