@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','News Feed')

@section('content')


<!-- <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position">
	<div class="news-feed-wrapper">

		<div class="row">

			<div class="col-lg-4">
				<form>
					<div class="banner-wrapper">
						<h2>Banner</h2>
						<label>Banner Photo</label>
						<div class="banner-pic-wrapper">
							<div class="bannr-img-container" id="add-banner-img-preview">
								<label for="add-tenant-img-upload" id="add-banner-img-label">ADD IMAGE</label>
								<input type="file" name="image" id="add-banner-img-upload" />
								
                            </div>

                            <div class="bannr-img-container" id="add-banner1-img-preview">
                            	<label for="add-tenant-img-upload" id="add-banner1-img-label">ADD IMAGE</label>
                            	<input type="file" name="image" id="add-banner1-img-upload" />
                            	
                            </div>

                            <div class="bannr-img-container" id="add-banner2-img-preview">
                            	<label for="add-tenant-img-upload" id="add-banner2-img-label">ADD IMAGE</label>
                            	<input type="file" name="image" id="add-banner2-img-upload" />
                            	
                            </div>
                        </div>
                        <div class="banner-text-wrapper">
                        	<label>Banner Text</label>
                        	<textarea  placeholder="Input Text..."></textarea>
                        </div>
                        <a href="#">update</a>
                    </div>
                </form>
            </div>


            <div class="col-lg-4">
            	<h2>Offers & Update</h2>
            	<label class="select-offer my-4"  onclick="openofferForm()"> 
            		ADD OFFER<br>
            		<img src="{{asset('alfardan/assets/add.png')}}" alt="add-ico" class="mt-3">
            	
            	</label>
            	<form id="myForm" class="offer-form-popup">
            		<div class="offer-update-wrapper">

            			<label>Offer 1</label>
            			<div class="offer-img">
            				<img src="{{asset('alfardan/assets/class-view-3.3.jpg')}}">
            			</div>

            			<div class="checkbox-form-wrapper mb-4">
            				<label>Property</label>
            				<div class="form-check d-inline-block">
            					<input class="form-check-input" type="checkbox" value="" id="property1" >
            					<label class="form-check-label" for="property1">
            						Property 1
            					</label>
            				</div>

            				<div class="form-check d-inline-block">
            					<input class="form-check-input" type="checkbox" value="" id="property2" >
            					<label class="form-check-label" for="property2">
            						Property 2
            					</label>
            				</div>

            				<div class="form-check d-inline-block">
            					<input class="form-check-input" type="checkbox" value="" id="property3" >
            					<label class="form-check-label" for="property3">
            						Property 3
            					</label>
            				</div>

            				<div class="form-check d-inline-block">
            					<input class="form-check-input" type="checkbox" value="" id="property4" >
            					<label class="form-check-label" for="property4">
            						Property 4
            					</label>
            				</div>

            				<div class="form-check d-inline-block">
            					<input class="form-check-input" type="checkbox" value="" id="property5" >
            					<label class="form-check-label" for="property5">
            						Property 5
            					</label>
            				</div>

            				<div class="form-check d-inline-block">
            					<input class="form-check-input" type="checkbox" value="" id="property6" >
            					<label class="form-check-label" for="property6">
            						Property 6
            					</label>
            				</div>

            				<div class="form-check d-inline-block">
            					<input class="form-check-input" type="checkbox" value="" id="property7" >
            					<label class="form-check-label" for="property7">
            						Property 7
            					</label>
            				</div>

            				<label class="pt-2">Tenant</label>
            				<div class="form-check d-inline-block">
            					<input class="form-check-input" type="checkbox" value="" id="vip" >
            					<label class="form-check-label" for="vip">
            						Elite
            					</label>
            				</div>
            				<div class="form-check d-inline-block">
            					<input class="form-check-input" type="checkbox" value="" id="regular" >
            					<label class="form-check-label" for="regular">
            						Regular
            					</label>
            				</div>
            				<div class="form-check d-inline-block">
            					<input class="form-check-input" type="checkbox" value="" id="non-tenant" >
            					<label class="form-check-label" for="non-tenant">
            						Privilege
            					</label>
            				</div>
            			</div>

            		

            			<div class="input-fields-wrapper">
            				<label for="Offer-Title">Offer Title</label>
            				<input type="text" name="offer-title" placeholder="Input Text...">
            				<label>Discount</label>
            				<input type="text" name="discount" placeholder="Input Text...">
            				<label>Offer Description</label>
            				<textarea placeholder="Input Text..."></textarea>
            			</div>
            			<div class="offer-btn-wrapper pb-4">
            				<button type="button"  onclick="closeofferForm()" class="click-close-btn">UPDATE</button>
            				<button type="button" class="click-close-btn fff-btn-bg">DELETE</button> 
            			</div>


            		</div>
            	</form>
            </div>


            <div class="col-lg-4">
            	<h2>Gallery</h2>
            	<label class="select-gallery my-4" onclick="opengalleryForm()"> 
            		ADD GALLERY<br>
            		
            		<img src="{{asset('alfardan/assets/add.png')}}" alt="add-ico" class="mt-3" >
            	
            	</label>
            	<form id="galleryForm" class="gallery-form-popup">
            		<div class="gallery-wrapper">

            			<label>Gallery Image</label>
            			<div class="gallery-img">
            				<img src="{{asset('alfardan/assets/class-view-3.3.jpg')}}">
            			</div>

            			<label>Description</label>
            			<textarea placeholder="Input Text..."></textarea>


            			<div class="offer-btn-wrapper pb-4 mb-3">
            				<button type="button"  onclick="closegalleryForm()" class="click-close-btn">UPDATE</button>
            				<button type="button" class="click-close-btn fff-btn-bg">DELETE</button> 
            			</div>



            			<div class="gallery-image-wrapper">
            				<div class="gallery-img">
            					<img src="{{asset('alfardan/assets/class-view-3.3.jpg')}}">
            				</div>

            				<div class="gallery-img">
            					<img src="{{asset('alfardan/assets/class-view-3.3.jpg')}}">
            				</div>

            				<div class="gallery-img">
            					<img src="{{asset('alfardan/assets/class-view-3.3.jpg')}}">
            				</div>

            				<div class="gallery-img">
            					<img src="{{asset('alfardan/assets/class-view-3.3.jpg')}}">
            				</div>
            			</div>
            		</div>
            	</form>
            </div>

        </div>

    </div>
</main> -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position">
    @include('notification.notify')
    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="alert alert-danger">
              {{$error}}
            </div>
        @endforeach
    @endif
  <div class="news-feed-wrapper">

      <div class="row">

        <div class="col-lg-6">
           <form method="post" action="{{route('admin.addNewsFeed')}}" enctype="multipart/form-data">
                 {{csrf_field()}}
                 <input type="hidden" name="newsfeedid" value="{{$newsfeed[0]->id}}">
              <div class="banner-wrapper">
                <h2>Banner</h2>
                <label>Banner Photo</label>
                <div class="banner-pic-wrapper news-banner">
                  <div class="bannr-img-container" id="add-banner-img-preview" style="background-image: url({{$newsfeed[0]->photo}});">
                   <label for="add-tenant-img-upload" id="add-banner-img-label">ADD IMAGE</label>
                   <input type="file" name="image" id="add-banner-img-upload" onclick="addimage('add-banner-img-upload','add-banner-img-preview','add-banner-img-label')"/>
               </div>
               <div class="bannr-img-container" id="add-banner1-img-preview" style="background-image: url({{$newsfeed[0]->photo1}});">
                   <label for="add-tenant-img-upload" id="add-banner1-img-label">ADD IMAGE</label>
                   <input type="file" name="image1" id="add-banner1-img-upload" onclick="addimage('add-banner1-img-upload','add-banner1-img-preview','add-banner1-img-label')"/>
               </div>
               <div class="bannr-img-container" id="add-banner2-img-preview" style="background-image: url({{$newsfeed[0]->photo2}});">
                   <label for="add-tenant-img-upload" id="add-banner2-img-label">ADD IMAGE</label>
                   <input type="file" name="image2" id="add-banner2-img-upload" onclick="addimage('add-banner2-img-upload','add-banner2-img-preview','add-banner2-img-label')"/>
               </div>
           </div>
           <div class="banner-text-wrapper">
              <label>Banner Description</label>
              <textarea  placeholder="Input Text..." name="description">{{$newsfeed[0]->description}}</textarea>
          </div>
          <!-- <a href="#">Save</a> -->
           <button class="form-btn" type="submit" style="background-color: #C89328;">SAVE</button>
          <!-- <a class="add-btn my-3" href="#" type="button" data-bs-toggle="modal" data-bs-target="#addnewhotel">ADD NEW HOTEL</a> -->
      </div>
  </form>
</div>
</div>

</div>
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
@endpush