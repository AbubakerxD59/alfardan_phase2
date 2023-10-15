@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title', 'Wellness')

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
        <h2 class="table-cap pb-0">Wellness</h2>
        <a class="add-btn my-3" href="#" type="button" data-bs-toggle="modal" data-bs-target="#addwellness">ADD NEW
            WELLNESS</a>
        <div class=" table-responsive tenant-table">
            <table class="table  table-bordered" id="myTable">
                <thead>
                    <tr>
                        <th scope="col"><span>Wellness Name</span></th>
                        <th scope="col"><span>Date Added</span></th>
                        <th scope="col"><span>Location</span></th>
                        <th scope="col"><span>Status</span></th>
                        <th scope="col"><span>Order</span></th>
                        <th style="background: transparent;"></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resorts as $resort)
                        <tr>
                            <td><a href="{{ route('admin.wellness_view', $resort->id) }}">{{ $resort->name }}</a></td>
                            <td>{{ $resort->date }}</td>
                            <td>{{ $resort->location }}</td>
                            <td>
                                @if ($resort->status == 1)
                                    Publish
                                @else
                                    Draft
                                @endif
                            </td>
                            <td>
                                {{$resort->order}}
                            </td>
                            <td class="cursor-pointer fw-bold table-edit" id="{{ $resort->id }}" data-bs-toggle="modal"
                                data-bs-target="#editwellness">Edit</td>
                            <td class="btn-bg2"><a type="button" class="table-delete fw-bold" data-bs-toggle="modal"
                                    data-bs-target="#remove-item" data-resortid="{{ $resort->id }}">Delete</a></td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </main>
    <!-- model start -->
    <div class="modal fade" id="addwellness" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">

            <div class="modal-content">
                <div class="modal-body profile-model">
                    <div class="container-fluid px-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="body-wrapper">
                                    <h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">Add Wellness</h2>
                                    <button type="button"
                                        class="btn-close-modal float-sm-end float-start mt-0 me-sm-0 me-4"
                                        data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"
                                            aria-hidden="true"></i></button>
                                    <form method="post" action="{{ route('admin.addWellness') }}"
                                        enctype="multipart/form-data" id="add_wellness">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="latitude" class="latitude">
                                        <input type="hidden" name="longitude" class="longitude">
                                        <div class="row">
                                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4  ">
                                                <div class="add-family-form-wrapper ps-2 pe-3">
                                                    <label>Wellness Name</label>
                                                    <input type="text" name="wellness_name" required="required">
                                                    <label>Location detail</label>
                                                    <input type="text" name="locationdetail" required="required">
                                                    <label>Call Number</label>
                                                    <input type="text" name="phone">
                                                    <label>Booking Link</label>
                                                    <input type="text" name="view_link">
                                                    <label>Whatsapp Number</label>
                                                    <input type="number" name="whatsapp">
                                                    <label>Instagram Link</label>
                                                    <input type="text" name="instagram">
                                                    <label>Facebook Link</label>
                                                    <input type="text" name="facebook">
                                                    <label>Snapchat Link</label>
                                                    <input type="text" name="snapchat">
                                                    <label>TikTok Link</label>
                                                    <input type="text" name="tiktok">
                                                    <label>Added Date</label>
                                                    <input type="date" name="date" required="required">
                                                    <div class="location-indicator">
                                                        <label>Location</label>
                                                        <input class="pe-4 location" type="text" name="location"
                                                            required="required">
                                                        <i class="fa fa-map-marker-alt"></i>
                                                    </div>
                                                    <label>Description</label>
                                                    <textarea class="description-text-small" name="description" required="required"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 ps-4 label-size">
                                                <div class="profile-img-holder add-event-img-holder  mb-3">
                                                    <figcaption>Images</figcaption>
                                                    <div id="add-wellness-img-preview-modal1" class="image-preview">
                                                        <label class="text-uppercase" for="add-wellness-img-upload-modal1"
                                                            id="add-wellness-img-label-modal1">add image</label>
                                                        <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
														<input type="file" name="image1" class="wellness-image"
                                                            id="add-wellness-img-upload-modal1" />
                                                    </div>
                                                    <div id="add-wellness-img-preview-modal2" class="image-preview">
                                                        <label class="text-uppercase" for="add-wellness-img-upload-modal2"
                                                            id="add-wellness-img-label-modal2">add image</label>
                                                        <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
														<input type="file" name="image2" class="wellness-image"
                                                            id="add-wellness-img-upload-modal2" />
                                                    </div>
                                                    <div id="add-wellness-img-preview-modal3" class="image-preview">
                                                        <label class="text-uppercase" for="add-wellness-img-upload-modal3"
                                                            id="add-wellness-img-label-modal3">add image</label>
                                                        <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
														<input type="file" name="image3" class="wellness-image"
                                                            id="add-wellness-img-upload-modal3" />
                                                    </div>
                                                </div>
                                                <h2>Tenant</h2>
                                                <div class="profile-tenant-form">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="inlineCheckbox1" name="tenant_type[]" value="Elite">
                                                        <label class="form-check-label"
                                                            for="inlineCheckbox1">Elite</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="tenant_type[]"
                                                            type="checkbox" id="inlineCheckbox2" value="Regular">
                                                        <label class="form-check-label"
                                                            for="inlineCheckbox2">Regular</label>
                                                    </div>

                                                    <div class="form-check form-check-inline mb-2">
                                                        <input class="form-check-input" name="tenant_type[]"
                                                            type="checkbox" id="inlineCheckbox3" value="Non-Tenant">
                                                        <label class="form-check-label"
                                                            for="inlineCheckbox3">Non-Tenant</label>
                                                    </div>
                                                    <!--<div class="form-check form-check-inline mb-2">
             <input class="form-check-input" name="tenant_type[]" type="checkbox" id="" value="Privilege">
             <label class="form-check-label" for="inlineCheckbox3">Privilege</label>
             </div> -->

                                                    <h2>Property</h2>
                                                    <div class="property-input-wrapper">
                                                        @foreach ($properties as $property)
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input property_radio"
                                                                    name="property[]" type="checkbox" id="property"
                                                                    value="{{ $property->id }}">
                                                                <label class="form-check-label"
                                                                    for="property">{{ $property->name }}</label>
                                                            </div>
                                                        @endforeach
                                                        <!-- <div class="form-check form-check-inline">
                          <input class="form-check-input" name="property" type="radio" id="Property1" value="option1">
                          <label class="form-check-label" for="Property1">Property 1</label>
                         </div>

                         <div class="form-check form-check-inline">
                          <input class="form-check-input" name="property" type="radio" id="Property2" value="option2">
                          <label class="form-check-label" for="Property2">Property 2</label>
                         </div>

                         <div class="form-check form-check-inline mb-2">
                          <input class="form-check-input" name="property" type="radio" id="Property3" value="option3">
                          <label class="form-check-label" for="Property3">Property 3</label>
                         </div>

                         <div class="form-check form-check-inline">
                          <input class="form-check-input" name="property" type="radio" id="Property4" value="option4">
                          <label class="form-check-label" for="Property4">Property 4</label>
                         </div>

                         <div class="form-check form-check-inline">
                          <input class="form-check-input" name="property" type="radio" id="Property5" value="option4">
                          <label class="form-check-label" for="Property5">Property 5</label>
                         </div>

                         <div class="form-check form-check-inline mb-2">
                          <input class="form-check-input" name="property" type="radio" id="Property6" value="option6">
                          <label class="form-check-label" for="Property6">Property 6</label>
                         </div>

                         <div class="form-check form-check-inline mb-2">
                          <input class="form-check-input" name="property" type="radio" id="Property7" value="option7">
                          <label class="form-check-label" for="Property7">Property 7</label>
                         </div> -->
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-btn-holder mb-3 text-end  me-xxl-0">
                                            <!-- <button class="form-btn btnsubmit">Publish</button>
                      <button class="form-btn">Draft</button> -->
                                            <input class="form-btn publish" name="publish" type="submit"
                                                value="Publish" />
                                            <input type="submit" name="draft" value="Draft" class="draft" />
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
    <!-- model end -->
    <!-- model start -->
    <div class="modal fade" id="editwellness" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">

            <div class="modal-content">
                <div class="modal-body profile-model">
                    <div class="container-fluid px-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="body-wrapper">
                                    <h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">Edit Wellness</h2>
                                    <button type="button"
                                        class="btn-close-modal float-sm-end float-start mt-0 me-sm-0 me-4"
                                        data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"
                                            aria-hidden="true"></i></button>
                                    <form method="post" action="{{ route('admin.addWellness') }}"
                                        enctype="multipart/form-data" id="editform">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="resortid" id="resortid">
                                        <input type="hidden" name="latitude" class="latitude" id="latitude">
                                        <input type="hidden" name="longitude" class="longitude" id="longitude">
                                        <div class="row">
                                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4  ">
                                                <div class="add-family-form-wrapper ps-2 pe-3">
                                                    <label>Hotel Name</label>
                                                    <input type="text" name="wellness_name" id="wellness_name"
                                                        required>
                                                    <label>Location detail</label>
                                                    <input type="text" name="locationdetail" id="locationdetail"
                                                        required="required">
                                                    <label>Call Number</label>
                                                    <input type="text" name="phone" id="phone">
                                                    <label>Booking Link</label>
                                                    <input type="text" name="view_link" id="view_link">
                                                    <label>Whatsapp Number</label>
                                                    <input type="number" name="whatsapp" id="whatsapp">
                                                    <label>Instagram Link</label>
                                                    <input type="text" name="instagram" id="instagram">
                                                    <label>Facebook Link</label>
                                                    <input type="text" name="facebook" id="facebook">
                                                    <label>Snapchat Link</label>
                                                    <input type="text" name="snapchat" id="snapchat">
                                                    <label>TikTok Link</label>
                                                    <input type="text" name="tiktok" id="tiktok">
                                                    <label>Order</label>
												    <input type="number" name="order" id="order">
                                                    <label>Added Date</label>
                                                    <input type="date" name="date" id="date"
                                                        required="required">
                                                    <div class="location-indicator">
                                                        <label>Location</label>
                                                        <input class="pe-4 location" type="text" name="location"
                                                            id="location" required>
                                                        <i class="fa fa-map-marker-alt"></i>
                                                    </div>
                                                    <label>Description</label>
                                                    <textarea class="description-text-small" name="description" id="description" required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 ps-4 label-size">
                                                <div class="profile-img-holder add-event-img-holder  mb-3">
                                                    <figcaption>Images</figcaption>
                                                    <div id="edit-wellness-img-preview-modal1" class="image-preview">
                                                        <label class="text-uppercase"
                                                            for="edit-wellness-img-upload-modal1"
                                                            id="edit-wellness-img-label-modal1">CHANGE IMAGE</label>
                                                        <input type="file" name="image1"
                                                            id="edit-wellness-img-upload-modal1" />
                                                        <input type="hidden" name="image_1" id="image1">

                                                    </div>
                                                    <div id="edit-wellness-img-preview-modal2" class="image-preview">
                                                        <label class="text-uppercase"
                                                            for="edit-wellness-img-upload-modal2"
                                                            id="edit-wellness-img-label-modal2">CHANGE IMAGE</label>
                                                        <input type="file" name="image2"
                                                            id="edit-wellness-img-upload-modal2" />
                                                        <input type="hidden" name="image_2" id="image2">

                                                    </div>
                                                    <div id="edit-wellness-img-preview-modal3" class="image-preview">
                                                        <label class="text-uppercase"
                                                            for="edit-wellness-img-upload-modal3"
                                                            id="edit-wellness-img-label-modal3">CHANGE IMAGE</label>
                                                        <input type="file" name="image3"
                                                            id="edit-wellness-img-upload-modal3" />
                                                        <input type="hidden" name="image_3" id="image3">

                                                    </div>
                                                </div>
                                                <h2>Tenant</h2>
                                                <div class="profile-tenant-form">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input tenantcheck" type="checkbox"
                                                            id="elite" name="tenant_type[]" value="Elite">
                                                        <label class="form-check-label"
                                                            for="inlineCheckbox1">Elite</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input tenantcheck" name="tenant_type[]"
                                                            type="checkbox" id="regular" value="Regular">
                                                        <label class="form-check-label"
                                                            for="inlineCheckbox2">Regular</label>
                                                    </div>

                                                    <div class="form-check form-check-inline mb-2">
                                                        <input class="form-check-input tenantcheck" name="tenant_type[]"
                                                            type="checkbox" id="nontenant" value="Non-Tenant">
                                                        <label class="form-check-label"
                                                            for="inlineCheckbox3">Non-Tenant</label>
                                                    </div>
                                                    <!--<div class="form-check form-check-inline mb-2">
             <input class="form-check-input tenantcheck" name="tenant_type[]" type="checkbox" id="privilege" value="Privilege">
             <label class="form-check-label" for="inlineCheckbox3">Privilege</label>
             </div>-->

                                                    <h2>Property</h2>
                                                    <div class="property-input-wrapper">
                                                        @foreach ($properties as $property)
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input property_radio"
                                                                    name="property[]" type="checkbox" id="property"
                                                                    value="{{ $property->id }}">
                                                                <label class="form-check-label"
                                                                    for="property">{{ $property->name }}</label>
                                                            </div>
                                                        @endforeach
                                                        <!-- <div class="form-check form-check-inline">
                          <input class="form-check-input" name="property" type="radio" id="Property1" value="option1">
                          <label class="form-check-label" for="Property1">Property 1</label>
                         </div>
                         
                         <div class="form-check form-check-inline">
                          <input class="form-check-input" name="property" type="radio" id="Property2" value="option2">
                          <label class="form-check-label" for="Property2">Property 2</label>
                         </div>
                         
                         <div class="form-check form-check-inline mb-2">
                          <input class="form-check-input" name="property" type="radio" id="Property3" value="option3">
                          <label class="form-check-label" for="Property3">Property 3</label>
                         </div>
                         
                         <div class="form-check form-check-inline">
                          <input class="form-check-input" name="property" type="radio" id="Property4" value="option4">
                          <label class="form-check-label" for="Property4">Property 4</label>
                         </div>
                         
                         <div class="form-check form-check-inline">
                          <input class="form-check-input" name="property" type="radio" id="Property5" value="option4">
                          <label class="form-check-label" for="Property5">Property 5</label>
                         </div>
                         
                         <div class="form-check form-check-inline mb-2">
                          <input class="form-check-input" name="property" type="radio" id="Property6" value="option6">
                          <label class="form-check-label" for="Property6">Property 6</label>
                         </div>
                         
                         <div class="form-check form-check-inline mb-2">
                          <input class="form-check-input" name="property" type="radio" id="Property7" value="option7">
                          <label class="form-check-label" for="Property7">Property 7</label>
                         </div> -->
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-btn-holder mb-3 text-end  me-xxl-0">
                                            <!-- <button class="form-btn btnsubmit">Apply</button>
                      <button class="form-btn">Draft</button> -->
                                            <input class="form-btn publish" name="publish" type="submit"
                                                value="Publish"></>
                                            <input type="submit" name="draft" value="Draft" class="draft"></>
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
    <!-- model end -->
    <!-- delete modal start -->
    <div class="modal remove-item" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-transparent border-0">
                <form method="POST" action="{{ route('admin.deleteResort', 'resort') }}">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="remove-content-wrapper">
                            <p>Are you sure you want to delete?</p>
                            <input type="hidden" name="resortid" id="resortid" value="">

                            <div class="delete-btn-wrapper">
                                <a href="#" type="button" class="btn-close-modal" data-bs-dismiss="modal"
                                    aria-label="Close">cancel</a>
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
            $(".add-btn ").on("click", function(){
                $("#add_wellness")[0].reset()
            });

            $("#myTable").on("click", ".table-edit", function(e) {
                // $('.table-edit').click(function(e) {
                e.preventDefault(); // prevent form from reloading page
                $('#editform').trigger("reset");
                $("#edit-wellness-img-preview-modal1").css("background-image", "unset");
                $("#edit-wellness-img-preview-modal2").css("background-image", "unset");
                $("#edit-wellness-img-preview-modal3").css("background-image", "unset");
                var id = $(this).attr('id');
				$('.edit-wellness-image').prev().removeClass('d-flex justify-content-end');
			    $('.edit-wellness-image').prev().addClass('d-none');

                $.ajax({
                    url: "{{ route('admin.getResort') }}",
                    type: 'Post',
                    data: {
                        'id': id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        // Show image container
                        $("#loader").show();
                    },
                    success: function(response) {
                        // console.log(response.images[0].path);
                        $('#resortid').val(response.id);
                        $('#wellness_name').val(response.name);
                        $('#locationdetail').val(response.locationdetail);


                        $('#phone').val(response.phone);
                        $('#location').val(response.location);
                        $('#date').val(response.date);
                        $('#view_link').val(response.view_link);
                        $('#whatsapp').val(response.whatsapp);
                        $('#instagram').val(response.instagram);
                        $('#facebook').val(response.facebook);
                        $('#snapchat').val(response.snapchat);
                        $('#tiktok').val(response.tiktok);
                        $('#order').val(response.order);
                        $('#description').val(response.description);
                        $('#latitude').val(response.latitude);
                        $('#longitude').val(response.longitude);
                        if (response.tenant_type != null) {

                            var tenant_type = response.tenant_type.split(',');

                            for (var i = 0; i <= 4; i++) {
                                var id = i + 1;
                                if (i < tenant_type.length) {

                                    $('input.tenantcheck[value="' + tenant_type[i] + '"]').prop(
                                        'checked', true);
                                    // $("#tenant_type"+id +"").prop('checked', true);
                                }

                            }
                        }
                        if (response.property != null) {

                            var property = response.property;

                            for (var i = 0; i < property.length; i++) {
                                var id = i + 1;
                                if (i < id) {
                                    $('input.property_radio[value="' + property[i] + '"]').prop(
                                        'checked', true);
                                    // $("#property"+id +"").prop('checked', true);
                                }

                            }
                        }


                        for (var i = 0; i <= 3; i++) {

                            if (i < response.images.length) {
                                // console.log(response.images[i]);
                                var img = i + 1;
                                $("#edit-wellness-img-preview-modal" + img + "").css(
                                    "background-image", "url(" + response.images[i].path +
                                    ")");
                                $("#image" + img).val(response.images[i].id);
								$("#edit-wellness-img-upload-modal" + img + "").prev().removeClass('d-none');
                                $("#edit-wellness-img-upload-modal" + img + "").prev().addClass('d-flex justify-content-end');
                            } else {
                                var img = i + 1;
                                $("#edit-wellness-img-preview-modal" + img + "").css(
                                    "background-image", "unset");
                                $("#image" + img).val(0);
                            }
                        }
                    },
                    complete: function(data) {
                        // Hide image container
                        $("#loader").hide();
                    }
                });
            });
        });
        // delete popup modal
        $('#remove-item').on('show.bs.modal', function(event) {

            var button = $(event.relatedTarget)

            var resortid = button.data('resortid')
            var modal = $(this)

            modal.find('.modal-body #resortid').val(resortid);
        })
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            // add facilities
            $.uploadPreview({
                input_field: "#add-wellness-img-upload-modal1",
                preview_box: "#add-wellness-img-preview-modal1",
                label_field: "#add-wellness-img-label-modal1"
            });

            $.uploadPreview({
                input_field: "#add-wellness-img-upload-modal2",
                preview_box: "#add-wellness-img-preview-modal2",
                label_field: "#add-wellness-img-label-modal2"
            });

            $.uploadPreview({
                input_field: "#add-wellness-img-upload-modal3",
                preview_box: "#add-wellness-img-preview-modal3",
                label_field: "#add-wellness-img-label-modal3"
            });
			$('.wellness-image').on('change', function(){
    	        $delete_image = $(this).prev();
    	        $delete_image.removeClass('d-none');
    	        $delete_image.addClass('d-flex justify-content-end');
            });
            // Edit Modal start
            $.uploadPreview({
                input_field: "#edit-wellness-img-upload-modal1",
                preview_box: "#edit-wellness-img-preview-modal1",
                label_field: "#edit-wellness-img-label-modal1"
            });

            $.uploadPreview({
                input_field: "#edit-wellness-img-upload-modal2",
                preview_box: "#edit-wellness-img-preview-modal2",
                label_field: "#edit-wellness-img-label-modal2"
            });

            $.uploadPreview({
                input_field: "#edit-wellness-img-upload-modal3",
                preview_box: "#edit-wellness-img-preview-modal3",
                label_field: "#edit-wellness-img-label-modal3"
            });
			$('.edit-wellness-image').on('change', function(){
    	        $delete_image = $(this).prev();
    	        $delete_image.removeClass('d-none');
    	        $delete_image.addClass('d-flex justify-content-end');
            });
        });
    </script>
    <script>
        $("#addwellness form").submit(function(event) {
            var form = 0;

            if ($(this).find("#inlineCheckbox1").is(':checked') || $(this).find("#inlineCheckbox2").is(
                    ':checked') || $(this).find("#inlineCheckbox3").is(':checked')) {
                form++;
            } else {
                alert("Please Select Tenant type");
            }

            if ($(this).find('input:checked.property_radio').length) {
                form++;
            } else {
                alert("Please Select Property");
            }

            if ($(this).find('#add-wellness-img-upload-modal1').val() || $(this).find(
                    '#add-wellness-img-upload-modal2').val() || $(this).find(
                    '#add-wellness-img-upload-modal3').val()) {
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
@endpush
