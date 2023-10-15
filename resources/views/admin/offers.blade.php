@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title', 'Offers')

@section('content')

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position">
        @include('notification.notify')
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @endforeach
        @endif
        <h2 class="table-cap pb-1">Offers</h2>
        <a class="add-btn art-btn my-3" href="#" type="button" data-bs-toggle="modal" data-bs-target="#addart">ADD NEW</a>
        <a href="{{ route("admin.offers_delete") }}" class="add-btn art-btn my-3 d-none" style="margin-right: 5px !important;" id="delete_records">Delete</a>
        <form action="{{route("admin.offers_delete")}}" method="POST" class="d-none" id="parking_form">
            @csrf
            <input type="text" name="parking" id="input_parking">
        </form>
        <div class=" table-responsive tenant-table clear-both">
            <table class="table  table-bordered" id="myTable">
                <thead>
                    <tr>
                        <th scope="col"><input type="checkbox" name="parking" id="multiselect"></th>
                        <th scope="col"><span>Offer Title</span></th>
                        <th scope="col"><span>Offer Details</span></th>
                        <th scope="col"><span>Outlet</span></th>
                        {{-- <th scope="col"><span>Outlet</span></th> --}}
                        {{-- <th scope="col"><span>Property</span></th> --}}
                        <th scope="col"><span>Submission Date</span></th>
                        <th scope="col"><span>Status </span></th>
                        <th scope="col"><span>Order </span></th>
						
						
                         <th ></th>
                         <th ></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($offers as $offer)
                        <tr>
                            <td><input class="multi_box" type="checkbox" name="parking_checkbox" id={{ $offer->id }}></td>
                            {{-- <td><a href="{{ route('admin.offerView', $offer->id) }}">{{ $offer->title }}</a></td> --}}
                            <td>{{ $offer->title }}</td>
                            <td>{{ $offer->description }}</td>
                            <td>{{ $offer->outlet }}</td>
                            {{-- <td>{{ $offer->outlet }}</td> --}}
                            {{-- <td>{{ @$offer->property->name }}</td> --}}
                            <td>{{ $offer->submission }}</td>
                            <td>
                                @if ($offer->status == 1)
                                    Publish
                                @else
                                    Draft
                                @endif
                            </td>
                            <td>
                                {{$offer->order}}
                            </td>
                            <td class="cursor-pointer table-edit fw-bold" id="{{ $offer->id }}" data-bs-toggle="modal"
                                data-bs-target="#editart">Edit</td>
                            <td class="btn-bg2"><a type="button" class="table-delete fw-bold" data-bs-toggle="modal"
                                    data-bs-target="#remove-item" data-offerid="{{ $offer->id }}">Remove</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </main>
    <!--add Updates & Offers Model model start -->
    <div class="modal fade" id="addart" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body profile-model">
                    <div class="container-fluid px-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="body-wrapper">
                                    <h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">Add offer</h2>
                                    <button type="button" class="btn-close-modal float-end" data-bs-dismiss="modal"
                                        aria-label="Close"><i class="far fa-times-circle"></i></button>
                                    <form method="post" enctype="multipart/form-data"
                                        action="{{ route('admin.add_offer') }}" id="add_offer_form">
                                        {{ csrf_field() }}
                                        <input type="hidden" id="publish" name="publish" value="Publish">
                                        <input type="hidden" id="draft" name="draft" value="Draft">
                                        <div class="row">
                                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 service-select ">
                                                <div class="add-family-form-wrapper ps-2 pe-3">
                                                    <div class="input-field-group">
                                                        <label>Offer Title</label>
                                                        <input type="text" name="title" required>
                                                    </div>
                                                    <div class="input-field-group">
                                                        <label style="display: block !important;">Outlet</label>
                                                        <select name="type" id="add_type" class="custom-select2"
                                                            style="background-color: #2B2B2B;width: 100%;">
                                                            <option value="" selected>Select Option</option>
                                                            <option value="F&B">F&B</option>
                                                            <option value="Hotels">Hotels</option>
                                                            <option value="Wellness">Wellness</option>
                                                            <option value="Medical">Medical</option>
                                                        </select>
                                                    </div>
                                                    <div class="input-field-group">
                                                        <label style="display: block !important;">Outlet Name</label>
                                                        <select name="outlet" id="add_outlet" class="custom-select2"
                                                            style="background-color: #2B2B2B;width: 100%;">
                                                            <option value="" selected>Select Option</option>
                                                            @foreach ($restaurants as $restaurant)
                                                                <option value="{{ $restaurant->id }}" class="FB">
                                                                    {{ $restaurant->name }}</option>
                                                            @endforeach

                                                            @foreach ($hotels as $hotel)
                                                                <option value="{{ $hotel->id }}" style="display: none;"
                                                                    disabled="disabled" class="Hotels">{{ $hotel->name }}
                                                                </option>
                                                            @endforeach

                                                            @foreach ($resorts as $resort)
                                                                <option value="{{ $resort->id }}" style="display: none;"
                                                                    disabled="disabled" class="Wellness">
                                                                    {{ $resort->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    {{-- <div class="input-field-group">
                                                        <label style="display: block !important;">Link to</label>
                                                        <select name="data_id" id="add_data_id" class="custom-select2"
                                                            style="background-color: #2B2B2B;width: 100%;">
                                                            <option value="">Select Option</option>
                                                            @foreach ($restaurants as $restaurant)
                                                                <option value="{{ $restaurant->id }}" class="FB">
                                                                    {{ $restaurant->name }}</option>
                                                            @endforeach

                                                            @foreach ($hotels as $hotel)
                                                                <option value="{{ $hotel->id }}" style="display: none;"
                                                                    disabled="disabled" class="Hotels">{{ $hotel->name }}
                                                                </option>
                                                            @endforeach

                                                            @foreach ($resorts as $resort)
                                                                <option value="{{ $resort->id }}" style="display: none;"
                                                                    disabled="disabled" class="Wellness">
                                                                    {{ $resort->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div> --}}
                                                    <label>Phone Number</label>
                                                    <input type="number" name="phone">
                                                    <label>Booking Link</label>
                                                    <input type="text" name="link">
                                                    <label>Whatsapp Number</label>
                                                    <input type="number" name="whatsapp">
                                                    <label>Submission Date</label>
                                                    <input type="date" name="submission" required>
                                                </div>
                                            </div>
                                            <div  class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 ps-4">
                                                <div class="add-family-form-wrapper_offers ps-2 pe-3">
                                                    <label>Location Detail</label>
                                                    <input type="text" name="location_detail" required="required">
                                                    <label>Instagram Link</label>
                                                    <input type="text" name="instagram">
                                                    <label>Facebook Link</label>
                                                    <input type="text" name="facebook">
                                                    <label>Snapchat Link</label>
                                                    <input type="text" name="snapchat">
                                                    <label>TikTok Link</label>
                                                    <input type="text" name="tiktok">
                                                    <label>Offer Details</label>
                                                    <textarea class="description-text-small" name="description"></textarea>
                                                    <div class="input-field-group location_offers" id="pointsadd">
                                                        <label for="points">Offer Points</label>
                                                        <input type="text" class="pe-4" name="points[]">
                                                    </div>
                                                    <div class="add-benefits">
                                                        <a class="add-btn my-3 float-end pro-btn"
                                                            onclick="addnewinput('points','pointsadd')" href="#"
                                                            type="button">+</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 ps-4">
                                                <div class="profile-img-holder add-event-img-holder  mb-3">
                                                    <figcaption></figcaption>
                                                    <div id="add-class-img-preview-modal1" class="image-preview">
                                                        <label class="text-uppercase" for="add-class-img-upload-modal1"
                                                            id="add-class-img-label-modal1">add image</label>
                                                        <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
														<input type="file" name="image"
                                                            id="add-class-img-upload-modal1"
                                                            onclick="addimage('add-class-img-upload-modal1','add-class-img-preview-modal1','add-class-img-label-modal1')" />
                                                    </div>
                                                </div>
                                                <h2>Property</h2>
                                                <div class="profile-tenant-form">

                                                    <div class="property-input-wrapper">
                                                        @foreach ($properties as $property)
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input property_radio"
                                                                    name="property_id[]" type="checkbox"
                                                                    value="{{ $property->id }}">
                                                                <label class="form-check-label"
                                                                    for="property">{{ $property->name }}</label>
                                                            </div>
                                                        @endforeach

                                                    </div>

                                                    <h2>Tenant</h2>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox"
                                                        id="inlineCheckbox1" name="tenant_type[]" value="Elite">
                                                        <label class="form-check-label"
                                                            for="inlineCheckbox1">Elite</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="tenant_type[]"
                                                            id="inlineCheckbox2" type="checkbox" value="Regular">
                                                        <label class="form-check-label"
                                                            for="inlineCheckbox2">Regular</label>
                                                    </div>

                                                    <!--<div class="form-check form-check-inline mb-2">
                                     <input class="form-check-input" name="tenant_type[]" type="checkbox" value="Privilege">
                                     <label class="form-check-label" for="inlineCheckbox3">Privilege</label>
                                    </div>-->

                                                    <div class="form-btn-holder mb-3 text-end  me-xxl-0">
                                                        <!-- <button class="form-btn">Publish</button>
                                     <button class="form-btn">Draft</button> -->
                                                        <input class="form-btn publish submit_btn" value="Publish" href="#" type="button" data-bs-toggle="modal" data-bs-target="#confirmModal">
                                                        {{-- <input class="form-btn publish submit_btn" name="publish" type="submit" --}}
                                                            {{-- value="Publish" /> --}}
                                                        <input type="submit" name="draft" value="Draft"
                                                            class="draft" />
                                                    </div>
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
    <!--Add Updates & Offers model end -->
    <!--Edit Updates & Offers start -->
    <div class="modal fade" id="editart" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">

            <div class="modal-content">

                <div class="modal-body profile-model">
                    <div class="container-fluid px-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="body-wrapper">
                                    <h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">Edit offer</h2>
                                    <button type="button" class="btn-close-modal float-end" data-bs-dismiss="modal"
                                        aria-label="Close"><i class="far fa-times-circle"></i></button>
                                    <form method="post" enctype="multipart/form-data"
                                        action="{{ route('admin.edit_offer') }}">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 service-select ">
                                                <div class="add-family-form-wrapper ps-2 pe-3">
                                                    <div class="input-field-group">
                                                        <label>Offer Title</label>
                                                        <input type="text" name="title" id="title" required>
                                                    </div>
                                                    <div class="input-field-group">
                                                        <label style="display: block !important;">Outlet</label>
                                                        <select name="type" id="type" class="custom-select2"
                                                            style="background-color: #2B2B2B;width: 100%;">
                                                            <option value="" selected>Select Option</option>
                                                            <option value="F&B">F&B</option>
                                                            <option value="Hotels">Hotels</option>
                                                            <option value="Wellness">Wellness</option>
                                                            <option value="Medical">Medical</option>
                                                        </select>
                                                    </div>
                                                    <div class="input-field-group">
                                                        <label style="display: block !important;">Outlet Name</label>
                                                        <select name="outlet" id="outlet" class="custom-select2"
                                                            style="background-color: #2B2B2B;width: 100%;">
                                                            <option value="" selected>Select Option</option>
                                                            @foreach ($restaurants as $restaurant)
                                                                <option value="{{ $restaurant->id }}" class="FB">
                                                                    {{ $restaurant->name }}</option>
                                                            @endforeach

                                                            @foreach ($hotels as $hotel)
                                                                <option value="{{ $hotel->id }}" class="Hotels">
                                                                    {{ $hotel->name }}</option>
                                                            @endforeach

                                                            @foreach ($resorts as $resort)
                                                                <option value="{{ $resort->id }}" class="Wellness">
                                                                    {{ $resort->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    {{-- <div class="input-field-group">
                                                        <label style="display: block !important;">Link to</label>
                                                        <select name="data_id" id="add_data_id" class="custom-select2"
                                                            style="background-color: #2B2B2B;width: 100%;">
                                                            <option value="">Select Option</option>
                                                            @foreach ($restaurants as $restaurant)
                                                                <option value="{{ $restaurant->id }}" class="FB">
                                                                    {{ $restaurant->name }}</option>
                                                            @endforeach

                                                            @foreach ($hotels as $hotel)
                                                                <option value="{{ $hotel->id }}" style="display: none;"
                                                                    disabled="disabled" class="Hotels">{{ $hotel->name }}
                                                                </option>
                                                            @endforeach

                                                            @foreach ($resorts as $resort)
                                                                <option value="{{ $resort->id }}" style="display: none;"
                                                                    disabled="disabled" class="Wellness">
                                                                    {{ $resort->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div> --}}
                                                    <label>Phone Number</label>
                                                    <input type="number" name="phone" id="phone">
                                                    <label>Booking Link</label>
                                                    <input type="text" name="link" id="link">
                                                    <label>Whatsapp Number</label>
                                                    <input type="number" name="whatsapp" id="whatsapp">
                                                    <label>Submission Date</label>
                                                    <input type="date" name="submission" id="submission" required>
                                                    <label>Order</label>
												    <input type="number" name="order" id="order">
                                                </div>
                                            </div>
                                            <div  class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 ps-4">
                                                <div class="add-family-form-wrapper_offers ps-2 pe-3">
                                                    <label>Location Detail</label>
                                                    <input type="text" name="location_detail" required="required" id="location">
                                                    <label>Instagram Link</label>
                                                    <input type="text" name="instagram" id="instagram">
                                                    <label>Facebook Link</label>
                                                    <input type="text" name="facebook" id="facebook">
                                                    <label>Snapchat Link</label>
                                                    <input type="text" name="snapchat" id="snapchat">
                                                    <label>TikTok Link</label>
                                                    <input type="text" name="tiktok" id="tiktok">
                                                    <label>Offer Details</label>
                                                    <textarea class="description-text-small" name="description" id="description"></textarea>
                                                    <div class="input-field-group location_offers pointsedit" id="pointsedit">
                                                        <label for="points">Offer Points</label>
                                                        <input type="text" class="pe-4 edit_input_point" name="points[]">
                                                    </div>
                                                    <div class="add-benefits">
                                                        <a class="add-btn my-3 float-end pro-btn"
                                                            onclick="addnewinput('points','pointsedit')" href="#"
                                                            type="button">+</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 ps-4">
                                                <div class="profile-img-holder add-event-img-holder  mb-3">
                                                    <figcaption></figcaption>
                                                    <div id="edit-class-img-preview-modal1" class="image-preview">
                                                        <label class="text-uppercase" for="edit-class-img-upload-modal1"
                                                            id="edit-class-img-label-modal1">add image</label>
                                                        <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
														<input type="file" name="image"
                                                            id="edit-class-img-upload-modal1"
                                                            onclick="addimage('edit-class-img-upload-modal1','edit-class-img-preview-modal1','edit-class-img-label-modal1')" />
                                                    </div>
                                                </div>
                                                <h2>Property</h2>
                                                <div class="profile-tenant-form">

                                                    <div class="property-input-wrapper">
                                                        @foreach ($properties as $property)
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input property_radio"
                                                                    name="property_id[]" type="checkbox" id="property"
                                                                    value="{{ $property->id }}">
                                                                <label class="form-check-label"
                                                                    for="property">{{ $property->name }}</label>
                                                            </div>
                                                        @endforeach

                                                    </div>

                                                    <h2>Tenant</h2>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input tenantcheck" type="checkbox"
                                                            id="editinlineCheckbox1" name="tenant_type[]" value="Elite">
                                                        <label class="form-check-label"
                                                            for="editinlineCheckbox1">Elite</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input tenantcheck" name="tenant_type[]"
                                                            id="editinlineCheckbox2" type="checkbox" value="Regular">
                                                        <label class="form-check-label"
                                                            for="editinlineCheckbox2">Regular</label>
                                                    </div>

                                                    <!--<div class="form-check form-check-inline mb-2">
                                     <input class="form-check-input" name="tenant_type[]" type="checkbox" value="Privilege">
                                     <label class="form-check-label" for="inlineCheckbox3">Privilege</label>
                                    </div>-->

                                                    <div class="form-btn-holder mb-3 text-end  me-xxl-0">
                                                        <!-- <button class="form-btn">Publish</button>
                                     <button class="form-btn">Draft</button> -->
                                                            <input type="hidden" name="offerid" id="offerid">
                                                        <input class="form-btn publish" name="publish" type="submit"
                                                            value="Publish" />
                                                        <input type="submit" name="draft" value="Draft"
                                                            class="draft" />
                                                    </div>
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
    <!--Edit Class model end -->
    <div class="modal remove-item" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-transparent border-0">
                <form method="POST" action="{{ route('admin.offerDelete', 'offers') }}">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="remove-content-wrapper">
                            <p>Are you sure you want to delete?</p>
                            <input type="hidden" name="offerid" id="offerid" value="">

                            <div class="delete-btn-wrapper">
                                <a href="#" type="button" class="btn-close-modal" data-bs-dismiss="modal"
                                    aria-label="Close">cancel</a>
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

 <!-- save changes modal start -->
<div class="modal" id="confirmModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
	  <div class="modal-content bg-transparent border-0">
		<form method="POST">
		{{csrf_field()}}
		<div class="modal-body">
		  <div class="remove-content-wrapper">
			<p>Save Changes</p>
			<input type="hidden" name="eventid" id="eventid" value="">
  
			<div class="delete-btn-wrapper">
				<button class="col-4 save_btn" type="Submit" 
				style="color: #fff;
				font-size: 18px;
				max-width: 133px;
				height: 37px;
				padding: 5px 32px;
				border: 1px solid #C89328;
				text-transform: uppercase;
				background: #C89328;">
				Yes</button>
			  <a href="#" type="button" class="btn-close-modal col-4" style="background-color: transparent;" data-bs-dismiss="modal" aria-label="Close">No</a>
			  <!-- <a href="#">delete</a> -->
			</div>
		  </div>
		</div>
		</form>
	  </div>
	</div>
  </div>
  <!-- save changes modal end -->
@endsection
@push('script')
    <script>
		 $('#add-class-img-upload-modal1').on('change', function(){
    	$delete_image = $(this).prev();
    	$delete_image.removeClass('d-none');
    	$delete_image.addClass('d-flex justify-content-end');
    });
	$('#edit-class-img-upload-modal1').on('change', function(){
		$delete_image = $(this).prev();
		$delete_image.removeClass('d-none');
		$delete_image.addClass('d-flex justify-content-end');
	});
        function addimage(input, box, lable) {

            $.uploadPreview({
                input_field: "#" + input,
                preview_box: "#" + box,
                label_field: "#" + lable
            });
        }
        $(function() {
            // $("#myTable").on("click", ".table-edit", function(e){
            $('.table-edit').click(function(e) {
                e.preventDefault(); // prevent form from reloading page
                $('#editform').trigger("reset");
                $("#edit-class-img-preview-modal1").css("background-image", "unset");
                return;
            });
        });
        // delete popup modal
        $('#editart').on('show.bs.modal', function(event) {
            var button =$(event.relatedTarget);
            var id = button.attr('id');
            $.ajax({
                    url: "{{ route('admin.offer') }}",
                    type: 'Post',
                    data: {
                        'id': id,
                        _token: '{{ csrf_token() }}'
                    },
                    // dataType: 'json',
                    beforeSend: function() {
                        // Show image container
                        $("#loader").show();
                    },
                    success: function(response) {
                        // console.log(response);
                        $('#offerid').val(response.id);
                        $('#title').val(response.title);
                        // $('#outlet option[value="' + response.outlet + '"]').attr("selected", "selected");
                        $('#type').val(response.type).attr("selected", "selected");
                        if(response.type != "" && response.type != null){
                            $('#outlet option[value="' + response.outlet + '"].' + response.type
                                .replace("&", "")).attr("selected", "selected");
                        }
                        $("#type").trigger("change");
                        $('#phone').val(response.phone);
                        $('#link').val(response.link);
                        $('#whatsapp').val(response.whatsapp);
                        $('#submission').val(response.submission);
                        $('#order').val(response.order);
                        $('#location').val(response.location_detail);
                        $('#instagram').val(response.instagram);
                        $('#facebook').val(response.facebook);
                        $('#snapchat').val(response.snapchat);
                        $('#tiktok').val(response.tiktok);
                        $('#description').val(response.description);

                        if (response.points.length > 0) {
                            console.log(response.points);
                            console.log(response.points.length);
                            for (var i = 0; i < response.points.length; i++) {
                                var elem = $('<input>').attr({
                                    type: 'text',
                                    name: 'points[]',
                                    value: response.points[i],
                                    class: 'pe-4 pointfield' + i,
                                    id: i
                                });
                                var removeLink = $("<span class='pointfield" + i +
                                    "'  id=" + i + ">").html("X").click(function() {
                                    var spanid = $(this).attr('id');
                                    $(".pointfield" + spanid).remove();
                                });
                                $('.pointfield' + i).remove();
                                $('.edit_input_point').remove();
                                $('.pointsedit').append(elem).append(removeLink);
                            }
                        }

                        if (response.property_id != null) {
                            var property = response.property_id.split(',');
                            for (var i = 0; i < property.length; i++) {
                                var id = i + 1;
                                if (i < id) {
                                    $('input.property_radio[value="' + property[i] + '"]').prop(
                                        'checked', true);
                                }
                            }
                        }

                        if (response.tenant_type != null) {
                            var tenant_type = response.tenant_type.split(',');
                            for (var i = 0; i <= 3; i++) {
                                var id = i + 1;
                                if (i < response.tenant_type.length) {

                                    $('input.tenantcheck[value="' + tenant_type[i] + '"]').prop(
                                        'checked', true);
                                }
                            }
                        }
                        
                        if (response.photo != null) {
                            $("#edit-class-img-preview-modal1").css("background-image", "url(" +
                                response.photo + ")");
							 $("#edit-class-img-upload-modal1").prev().removeClass('d-none');
                            $("#edit-class-img-upload-modal1").prev().addClass('d-flex justify-content-end');
                        } else {
                            $("#edit-class-img-preview-modal1").css("background-image",
                                "unset");
                        }
                    },
                    complete: function(data) {
                        // Hide image container
                        $("#loader").hide();
                    }
                });
        });
        $('#remove-item').on('show.bs.modal', function(event) {
            console.log( event.relatedTarget );
            var button = $(event.relatedTarget)

            var offerid = button.data('offerid')
            var modal = $(this)

            modal.find('.modal-body #offerid').val(offerid);
        });

        $("#type").on("change", function() {
            var type = $(this).val();
            type = type.replace("&", "");
            $("select#outlet option").each(function() {
                $(this).attr("disabled", 'disabled');
                $(this).hide();
            });

            $("select#outlet option." + type).each(function() {
                $(this).removeAttr("disabled");
                $(this).show();
            });
        });

        $("#add_type").on("change", function() {
            var type = $(this).val();
            type = type.replace("&", "");
            $("select#add_outlet option").each(function() {
                $(this).attr("disabled", 'disabled');
                $(this).hide();
            });

            $("select#add_outlet option." + type).each(function() {
                $(this).removeAttr("disabled");
                $(this).show();
            });
        });
    </script>

    <script>
        $("#addart form").submit(function(event) {
            var form = 0;

            if ($(this).find("#inlineCheckbox1").is(':checked') || $(this).find("#inlineCheckbox2").is(
                    ':checked')) {
                form++;
            } else {
                alert("Please Select Tenant type");
            }

            if ($(this).find('input:checked.property_radio').length) {
                form++;
            } else {
                alert("Please Select Property");
            }

            if ($(this).find('#add-class-img-upload-modal1').val()) {
                form++;
            } else {
                // event.preventDefault()
                alert("Please Select one image");
            }

            //console.log($(this).find('.property-input-wrapper .profile-img-holder input:hasValue').serialize());
            return form > 2 ? true : event.preventDefault();
        });
    </script>
<script>
    $('.delete-image').on('click', function(){
        $(this).next().val('' );
        $(this).siblings('.menu-hidden').val('');
        $(this).parent().css("background-image",'none');
        $(this).addClass('d-none');
    });
</script>
<script>

    $("#multiselect").on("click", function () {
        if ($(this).is(":checked")) {
            $("input[name=parking_checkbox]").prop("checked", true);
            $("#delete_records").removeClass("d-none");
        } else {
            $("input[name=parking_checkbox]").prop("checked", false);
            $("#delete_records").addClass("d-none");
        }
    });

    $(".multi_box").on("click", function() {
        var length = $("input[name=parking_checkbox]:checked").length
        console.log(length);
        if (length > 0) {
            $("input[name=parking]").prop("checked", true);
            $("#delete_records").removeClass("d-none");
        } else {
            $("input[name=parking]").prop("checked", false);
            $("#delete_records").addClass("d-none");
        }
    });

    $("#delete_records").on("click", function (e) {
        e.preventDefault();
        console.log('asdasdsa');
        var array = [];
        $("input[name=parking_checkbox]:checked").each(function () {
            array.push(this.id);
        });
        $("#input_parking").val(array);
        $("#parking_form").submit();
    });

    function addnewinput(name, appendid, value = "") {
        var elem = $("<input/>", {
            type: "text",
            name: name + "[]",
            value: value + ""
        });
        var removeLink = $("<span/>").html("X").click(function() {
            $(elem).remove();
            $(this).remove();
        });
        $("#" + appendid).append(elem).append(removeLink);
    }
</script>
<script>
    $(".submit_btn").on('click', function(){
        var value = $(this).val();
        if(value == 'Publish'){
            $("#draft").remove();
            // $('#submit_type').val('Publish');
        }else{
            $("#publish").remove();
            $('#submit_type').val('Draft');
        }
        $(".save_btn").val(value);
    });
    $('.save_btn').on('click', function(e){
		e.preventDefault();
		$("#add_offer_form").submit();
	});
</script>
@endpush
