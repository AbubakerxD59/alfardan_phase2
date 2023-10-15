@extends('admin.layouts.layout')

@section('title', 'Restaurants')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')


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
        <h2 class="table-cap pb-1">Restaurants</h2>
        <a class="add-btn my-3" href="#" type="button" data-bs-toggle="modal" data-bs-target="#addrestaurent">ADD NEW
            RESTAURANTS</a>
        <div class=" table-responsive tenant-table">
            <table class="table  table-bordered" id="myTable">
                <thead>
                    <tr>
                        <th>Restaurant Name</th>
                        <th scope="col"><span>Date Added</span></th>
                        <th scope="col"><span>Location</span></th>
                        <th scope="col"><span>Status</span></th>
                        <th scope="col"><span>Order</span></th>
                        <th style="background: transparent;"></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($restaurants as $restaurant)
                        <tr>
                            <td><a href="{{ route('admin.restaurant_view', $restaurant->id) }}">{{ $restaurant->name }}</a>
                            </td>
                            <td>{{ $restaurant->date }}</td>

                            <td>{{ $restaurant->location }}</td>
                            <td>
                                @if ($restaurant->status == 1)
                                    Publish
                                @else
                                    Draft
                                @endif
                            </td>
                            <td>
                                {{$restaurant->order}}
                            </td>
                            <td class="cursor-pointer fw-bold table-edit" id="{{ $restaurant->id }}" data-bs-toggle="modal"
                                data-bs-target="#editrestaurent">Edit</td>
                            <td class="btn-bg2"><a type="button" class="table-delete fw-bold" data-bs-toggle="modal"
                                    data-bs-target="#remove-item" data-restaurantid="{{ $restaurant->id }}">Delete</a></td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </main>
    <!-- model start -->
    <div class="modal fade" id="addrestaurent" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">

            <div class="modal-content">
                <div class="modal-body profile-model">
                    <div class="container-fluid px-0">
                        <div class="body-wrapper">
                            <h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">Add Restaurant</h2>
                            <button type="button" class="btn-close-modal float-sm-end float-start mt-0 me-sm-0 me-4"
                                data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"
                                    aria-hidden="true"></i></button>
                            <form method="post" action="{{ route('admin.addRestaurant') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="latitude" class="latitude">
                                <input type="hidden" name="longitude" class="longitude">
                                <div class="row">
                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4  ">
                                        <div class="add-family-form-wrapper ps-2 pe-3">
                                            <label>Restaurent Name</label>
                                            <input type="text" name="restaurant_name" required="required">
                                            <label>Location detail</label>
                                            <input type="text" name="locationdetail" required="required">
                                            <label>Call Number</label>
                                            <input type="text" name="phone">
                                            <label>Booking Link</label>
                                            <input type="text" name="view_link">
                                            <label>Added Date</label>
                                            <input type="date" name="date" required="required">
                                            <div class="location-indicator">
                                                <label>Location</label>
                                                <input class="pe-4 location" type="text" name="location"
                                                    required="required">
                                                <i class="fa fa-map-marker-alt"></i>
                                            </div>
                                            <label>Whatsapp Number</label>
                                            <input type="number" name="whatsapp">
                                            <label>Facebook</label>
                                            <input type="text" name="facebook">
                                            <label>Instagram</label>
                                            <input type="text" name="instagram">
                                            <label>Snapchat</label>
                                            <input type="text" name="snapchat">
                                            <label>TikTok</label>
                                            <input type="text" name="tiktok">
                                            <label>Description</label>
                                            <textarea class="description-text-small" name="description" required="required"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 ps-4 label-size">
                                        <div class="profile-img-holder add-event-img-holder  mb-3">
                                            <figcaption>Images</figcaption>
                                            <div id="add-restaurent-img-preview-modal1" class="image-preview">
                                                <label class="text-uppercase" for="add-restaurent-img-upload-modal1"
                                                    id="add-restaurent-img-label-modal1">add image</label>
                                                <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
												<input type="file" name="image1" class="restaurant-image"
                                                    id="add-restaurent-img-upload-modal1" />
                                            </div>
                                            <div id="add-restaurent-img-preview-modal2" class="image-preview">
                                                <label class="text-uppercase" for="add-restaurent-img-upload-modal2"
                                                    id="add-restaurent-img-label-modal2">add image</label>
                                                <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
												<input type="file" name="image2" class="restaurant-image"
                                                    id="add-restaurent-img-upload-modal2" />
                                            </div>
                                            <div id="add-restaurent-img-preview-modal3" class="image-preview">
                                                <label class="text-uppercase" for="add-restaurent-img-upload-modal3"
                                                    id="add-restaurent-img-label-modal3">add image</label>
                                                <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
												<input type="file" name="image3" class="restaurant-image"
                                                    id="add-restaurent-img-upload-modal3" />
                                            </div>
                                        </div>
                                        <h2>Tenant</h2>
                                        <div class="profile-tenant-form">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                                    name="tenant_type[]" value="Elite">
                                                <label class="form-check-label" for="inlineCheckbox1">Elite</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="tenant_type[]" type="checkbox"
                                                    id="inlineCheckbox2" value="Regular">
                                                <label class="form-check-label" for="inlineCheckbox2">Regular</label>
                                            </div>

                                            <div class="form-check form-check-inline mb-2">
                                                <input class="form-check-input" name="tenant_type[]" type="checkbox"
                                                    id="inlineCheckbox3" value="Non-Tenant">
                                                <label class="form-check-label" for="inlineCheckbox3">Non-Tenant</label>
                                            </div>

                                            <!--<div class="form-check form-check-inline mb-2">
                   <input class="form-check-input" name="tenant_type[]" type="checkbox" id="" value="Privilege">
                   <label class="form-check-label" for="inlineCheckbox3">Privilege</label>
                  </div>-->

                                            <h2>Property</h2>
                                            <div class="property-input-wrapper">
                                                @foreach ($properties as $property)
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input property_radio" name="property[]"
                                                            type="checkbox" id="property" value="{{ $property->id }}">
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
                                                <!-- menu start -->
                                                <div class="res-menu-wrapper">
                                                    <h2 class="pt-4">Menu</h2>
                                                    <div id="add-restaurent-img-preview-modal4"
                                                        class="image-preview-menu float-start">
                                                        <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
														<input type="file" name="menu1" class="menu-image"
                                                            id="add-restaurent-img-upload-modal4" />
                                                    </div>
                                                    <div id="add-restaurent-img-preview-modal5"
                                                        class="image-preview-menu float-start ms-2">
                                                        <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
														<input type="file" name="menu2" class="menu-image" 
                                                            id="add-restaurent-img-upload-modal5" />
                                                    </div>
                                                    <div id="add-restaurent-img-preview-modal11"
                                                        class="image-preview-menu float-start ms-2">
                                                        <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
														<input type="file" name="menu3" class="menu-image"
                                                            id="add-restaurent-img-upload-modal11" />
                                                    </div>
                                                    <div id="add-restaurent-img-preview-modal12"
                                                        class="image-preview-menu float-start ms-2">
                                                        <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
														<input type="file" name="menu4" class="menu-image"
                                                            id="add-restaurent-img-upload-modal12" />
                                                    </div>
                                                    <div id="add-restaurent-img-preview-modal13"
                                                        class="image-preview-menu float-start ms-2">
                                                        <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
														<input type="file" name="menu5" class="menu-image"
                                                            id="add-restaurent-img-upload-modal13" />
                                                    </div>
                                                </div>
                                                <!-- menu end -->
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-btn-holder mb-3 text-end  me-xxl-0">
                                    <!-- <button class="form-btn btnsubmit" type="submit">Publish</button>
                <button class="form-btn">Draft</button> -->
                                    <input class="form-btn publish" name="publish" type="submit" value="Publish"></>
                                    <input type="submit" name="draft" value="Draft" class="draft"></>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>
    <!--add restaurent  model end -->
    <!--Edit restaurent model start -->
    <div class="modal fade" id="editrestaurent" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">

            <div class="modal-content">
                <div class="modal-body profile-model">
                    <div class="container-fluid px-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="body-wrapper">
                                    <h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">Edit restaurant</h2>
                                    <button type="button"
                                        class="btn-close-modal float-sm-end float-start mt-0 me-sm-0 me-4"
                                        data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"
                                            aria-hidden="true"></i></button>
                                    <form method="post" action="{{ route('admin.addRestaurant') }}"
                                        enctype="multipart/form-data" id="editform">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="restaurantid" id="restaurantid">
                                        <input type="hidden" name="latitude" class="latitude" id="latitude">
                                        <input type="hidden" name="longitude" class="longitude" id="longitude">

                                        <div class="row">
                                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4  ">
                                                <div class="add-family-form-wrapper ps-2 pe-3">
                                                    <label>Restaurent Name</label>
                                                    <input type="text" name="restaurant_name" id="restaurant_name"
                                                        required>
                                                    <label>Location detail</label>
                                                    <input type="text" name="locationdetail" id="locationdetail"
                                                        required="required">
                                                    <label>Call Number</label>
                                                    <input type="text" name="phone" id="phone">
                                                    <label>Booking Link</label>
                                                    <input type="text" name="view_link" id="view_link">
                                                    <label>Added Date</label>
                                                    <input type="date" name="date" id="date"
                                                        required="required">
                                                    <div class="location-indicator">
                                                        <label>Location</label>
                                                        <input class="pe-4 location" type="text" name="location"
                                                            id="location" required>
                                                        <i class="fa fa-map-marker-alt"></i>
                                                    </div>
                                                    <label>Whatsapp Number</label>
                                                    <input type="number" name="whatsapp" id="whatsapp">
                                                    <label>Facebook</label>
                                                    <input type="text" name="facebook" id="facebook">
                                                    <label>Instagram</label>
                                                    <input type="text" name="instagram" id="instagram">
                                                    <label>Snapchat</label>
                                                    <input type="text" name="snapchat" id="snapchat">
                                                    <label>TikTok</label>
                                                    <input type="text" name="tiktok" id="tiktok">
                                                    <label>Order</label>
                                                    <input type="number" name="order" id="order">
                                                    <label>Description</label>
                                                    <textarea class="description-text-small" name="description" id="description" required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 ps-4 label-size">
                                                <div class="profile-img-holder add-event-img-holder  mb-3">
                                                    <figcaption>Images</figcaption>
                                                    <div id="edit-restaurent-img-preview-modal1" class="image-preview">
                                                        <a href="" id="image_form_1" class="d-none"></a>
                                                        <label class="text-uppercase"
                                                            for="edit-restaurent-img-upload-modal1"
                                                            id="edit-restaurent-img-label-modal1">CHANGE IMAGE</label>
                                                            <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
														<input type="file" name="image1" class="edit-restaurant-image"
                                                            id="edit-restaurent-img-upload-modal1" />
                                                        <input type="hidden" name="image_1" id="image1">

                                                    </div>
                                                    <div id="edit-restaurent-img-preview-modal2" class="image-preview">
                                                        <label class="text-uppercase"
                                                            for="edit-restaurent-img-upload-modal2"
                                                            id="edit-restaurent-img-label-modal2">CHANGE IMAGE</label>
                                                        <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
														<input type="file" name="image2" class="edit-restaurant-image"
                                                            id="edit-restaurent-img-upload-modal2" />
                                                        <input type="hidden" name="image_2" id="image2">
                                                        <a href="" id="image_form_2" class="d-none"></a>
                                                    </div>
                                                    <div id="edit-restaurent-img-preview-modal3" class="image-preview">
                                                        <label class="text-uppercase"
                                                            for="edit-restaurent-img-upload-modal3"
                                                            id="edit-restaurent-img-label-modal3">CHANGE IMAGE</label>
                                                        <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
														<input type="file" name="image3" class="edit-restaurant-image"
                                                            id="edit-restaurent-img-upload-modal3" />
                                                        <input type="hidden" name="image_3" id="image3">
                                                        <a href="" id="image_form_3" class="d-none"></a>
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
                                                        <div class="res-menu-wrapper">
                                                            <h2 class="pt-4">Menu</h2>
                                                            <div id="edit-restaurent-img-preview-modal13"
                                                                class="image-preview-menu float-start">
                                                                <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
																<input type="file" name="menu1" class="edit-menu-image"
                                                                    id="edit-restaurent-img-upload-modal4" />
                                                                <input type="hidden" name="menu_1" class="menu-hidden" id="menu1">
                                                            </div>
                                                            <div id="edit-restaurent-img-preview-modal5"
                                                                class="image-preview-menu float-start ms-2">
                                                                <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
																<input type="file" name="menu2" class="edit-menu-image"
                                                                    id="edit-restaurent-img-upload-modal5" />
                                                                <input type="hidden" name="menu_2" class="menu-hidden" id="menu2">

                                                            </div>
                                                            <div id="edit-restaurent-img-preview-modal11"
                                                                class="image-preview-menu float-start ms-2">
                                                                <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
																<input type="file" name="menu3" class="edit-menu-image"
                                                                    id="edit-restaurent-img-upload-modal11" />
                                                                <input type="hidden" name="menu_3" class="menu-hidden" id="menu3">
                                                            </div>
                                                            <div id="edit-restaurent-img-preview-modal12"
                                                                class="image-preview-menu float-start ms-2">
                                                                <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
																<input type="file" name="menu4" class="edit-menu-image"
                                                                    id="edit-restaurent-img-upload-modal12" />
                                                                <input type="hidden" name="menu_4" class="menu-hidden" id="menu4">
                                                            </div>
                                                            <div id="edit-restaurent-img-preview-modal19"
                                                                class="image-preview-menu float-start ms-2">
                                                                <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
																<input type="file" name="menu5" class="edit-menu-image"
                                                                    id="edit-restaurent-img-upload-
                                                                    modal19" />
                                                                <input type="hidden" name="menu_5" class="menu-hidden" id="menu5">
                                                            </div>
                                                        </div>
                                                        <div class="res-menu-wrapper">
                                                            <div class="d-flex text-white">
                                                                <div>
                                                                    <span id="preview-modal13"></span>
                                                                </div>
                                                                <div>
                                                                    <span id="preview-modal5"></span>
                                                                </div>
                                                                <div>
                                                                    <span id="preview-modal11"></span>
                                                                </div>
                                                                <div>
                                                                    <span id="preview-modal12"></span>
                                                                </div>
                                                                <div>
                                                                    <span id="preview-modal19"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-btn-holder    mb-3 text-end  me-xxl-0">
                                            <!-- <button class="form-btn text-capitalize btnsubmit">apply</button>
                  <button class="form-btn text-capitalize">Draft</button> -->
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
    <!--edit restaurent model end -->
    <!-- delete modal start -->
    <div class="modal remove-item" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-transparent border-0">
                <form method="POST" action="{{ route('admin.deleteRestaurant', 'user') }}">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="remove-content-wrapper">
                            <p>Are you sure you want to delete?</p>
                            <input type="hidden" name="restaurantid" id="restaurantid" value="">

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
            $("#myTable").on("click", ".table-edit", function(e) {
                // $('.table-edit').click(function(e) {
                e.preventDefault(); // prevent form from reloading page
                $('#editform').trigger("reset");
                $("#edit-restaurent-img-preview-modal").css("background-image", "unset");
                $("#edit-restaurent-img-preview-modal").css("background-image", "unset");
                $("#edit-restaurent-img-preview-modal").css("background-image", "unset");
                $("#edit-restaurent-img-preview-modal13").css("background-image", "unset");
                $("#edit-restaurent-img-preview-modal5").css("background-image", "unset");
                $("#edit-restaurent-img-preview-modal11").css("background-image", "unset");
                $("#edit-restaurent-img-preview-modal12").css("background-image", "unset");
                $("#edit-restaurent-img-preview-modal19").css("background-image", "unset");
				$('.edit-restaurant-image').prev().removeClass('d-flex justify-content-end');
			    $('.edit-restaurant-image').prev().addClass('d-none');
                $('.edit-menu-image').prev().removeClass('d-flex justify-content-end');
			    $('.edit-menu-image').prev().addClass('d-none');


                var id = $(this).attr('id');

                $.ajax({
                    url: "{{ route('admin.getRestaurant') }}",
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
                        // console.log(response.menu1);
                        $('#restaurantid').val(response.id);
                        $('#restaurant_name').val(response.name);
                        $('#locationdetail').val(response.locationdetail);

                        $('#phone').val(response.phone);
                        $('#location').val(response.location);
                        $('#date').val(response.date);
                        $('#view_link').val(response.view_link);
                        $('#whatsapp').val(response.whatsapp);
                        $('#facebook').val(response.facebook);
                        $('#instagram').val(response.instagram);
                        $('#snapchat').val(response.snapchat);
                        $('#tiktok').val(response.tiktok);
                        $('#order').val(response.order);
                        $('#description').val(response.description);
                        $('#latitude').val(response.latitude);
                        $('#longitude').val(response.longitude);
                        // $('#preview-modal13').html(response.menu1);
                        if(response.menu1){
                            $('#preview-modal13').html(response.menu1.replace(/.*uploads\//, ''));
                        }
                        if(response.menu2){
                            $('#preview-modal5').html(response.menu2.replace(/.*uploads\//, ''));
                        }
                        if(response.menu3){
                            $('#preview-modal11').html(response.menu3.replace(/.*uploads\//, ''));
                        }
                        if(response.menu4){
                            $('#preview-modal12').html(response.menu4.replace(/.*uploads\//, ''));
                        }
                        if(response.menu5){
                            $('#preview-modal19').html(response.menu5.replace(/.*uploads\//, ''));
                        }



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

                        if (response.menu1 != '' && response.menu1 != null) {

                            $("#edit-restaurent-img-preview-modal13").css("background-image",
                                "url(" + response.menu1 + ")");
                            if (response.menu1.split('.').pop() == 'pdf') {
                                $("#edit-restaurent-img-preview-modal13").css(
                                    "background-image",
                                    "url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRVpLdNnCEtTc83vk2jkzs1H47PqiQfBxn74Q&usqp=CAU)"
                                );
                            }

                            $("#edit-restaurent-img-upload-modal4").prev().removeClass('d-none');
                            $("#edit-restaurent-img-upload-modal4").prev().addClass('d-flex justify-content-end');
							$("#menu1").val(response.menu1);
                        }

                        if (response.menu2 != '' && response.menu2 != null) {
                            $("#edit-restaurent-img-preview-modal5").css("background-image",
                                "url(" + response.menu2 + ")");

                            if (response.menu2.split('.').pop() == 'pdf') {
                                $("#edit-restaurent-img-preview-modal5").css("background-image",
                                    "url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRVpLdNnCEtTc83vk2jkzs1H47PqiQfBxn74Q&usqp=CAU)"
                                );
                            }
                            $("#edit-restaurent-img-upload-modal5").prev().removeClass('d-none');
                            $("#edit-restaurent-img-upload-modal5").prev().addClass('d-flex justify-content-end');
							$("#menu2").val(response.menu2);
                        }

                        if (response.menu3 != '' && response.menu3 != null) {
                            $("#edit-restaurent-img-preview-modal11").css("background-image",
                                "url(" + response.menu3 + ")");

                            if (response.menu3.split('.').pop() == 'pdf') {
                                $("#edit-restaurent-img-preview-modal11").css(
                                    "background-image",
                                    "url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRVpLdNnCEtTc83vk2jkzs1H47PqiQfBxn74Q&usqp=CAU)"
                                );
                            }
                             $("#edit-restaurent-img-upload-modal11").prev().removeClass('d-none');
                            $("#edit-restaurent-img-upload-modal11").prev().addClass('d-flex justify-content-end');
							$("#menu3").val(response.menu3);
                        }

                        if (response.menu4 != '' && response.menu4 != null) {
                            $("#edit-restaurent-img-preview-modal12").css("background-image",
                                "url(" + response.menu4 + ")");

                            if (response.menu4.split('.').pop() == 'pdf') {
                                $("#edit-restaurent-img-preview-modal12").css(
                                    "background-image",
                                    "url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRVpLdNnCEtTc83vk2jkzs1H47PqiQfBxn74Q&usqp=CAU)"
                                );
                            }

                            $("#edit-restaurent-img-upload-modal12").prev().removeClass('d-none');
                            $("#edit-restaurent-img-upload-modal12").prev().addClass('d-flex justify-content-end');
							$("#menu4").val(response.menu4);
                        }

                        if (response.menu5 != '' && response.menu5 != null) {
                            $("#edit-restaurent-img-preview-modal19").css("background-image",
                                "url(" + response.menu5 + ")");


                            if (response.menu5.split('.').pop() == 'pdf') {
                                $("#edit-restaurent-img-preview-modal19").css(
                                    "background-image",
                                    "url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRVpLdNnCEtTc83vk2jkzs1H47PqiQfBxn74Q&usqp=CAU)"
                                );
                            }

                            $("#edit-restaurent-img-upload-modal19").prev().removeClass('d-none');
                            $("#edit-restaurent-img-upload-modal19").prev().addClass('d-flex justify-content-end');
							$("#menu5").val(response.menu5);
                        }
                        for (var i = 0; i <= 3; i++) {
                            if (i < response.images.length) {
                                var img = i + 1;
                                $("#edit-restaurent-img-preview-modal" + img + "").css(
                                    "background-image", "url(" + response.images[i].path +
                                    ")");
                                $("#image" + img).val(response.images[i].id);
                                var image_id=response.images[i].id;
                                var route='{{route('admin.deleteimage',[0])}}'
                                $("#image_form_"+img).attr('href', route+image_id);
                                if(response.images[i].path){
                                    $("#edit-restaurent-img-upload-modal" + img + "").prev().removeClass('d-none');
                                    $("#edit-restaurent-img-upload-modal" + img + "").prev().addClass('d-flex justify-content-end');
                                }
                            } else {
                                var img = i + 1;
                                $("#edit-restaurent-img-preview-modal" + img + "").css(
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

            var restaurantid = button.data('restaurantid')
            var modal = $(this)

            modal.find('.modal-body #restaurantid').val(restaurantid);
        })
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            // add restaurent
            $.uploadPreview({
                input_field: "#add-restaurent-img-upload-modal1",
                preview_box: "#add-restaurent-img-preview-modal1",
                label_field: "#add-restaurent-img-label-modal1"
            });

            $.uploadPreview({
                input_field: "#add-restaurent-img-upload-modal2",
                preview_box: "#add-restaurent-img-preview-modal2",
                label_field: "#add-restaurent-img-label-modal2"
            });

            $.uploadPreview({
                input_field: "#add-restaurent-img-upload-modal3",
                preview_box: "#add-restaurent-img-preview-modal3",
                label_field: "#add-restaurent-img-label-modal3"
            });
			$('.restaurant-image').on('change', function(){
    	        $delete_image = $(this).prev();
    	        $delete_image.removeClass('d-none');
    	        $delete_image.addClass('d-flex justify-content-end');
            });

            // Edit Modal start
            $.uploadPreview({
                input_field: "#edit-restaurent-img-upload-modal1",
                preview_box: "#edit-restaurent-img-preview-modal1",
                label_field: "#edit-restaurent-img-label-modal1"
            });

            $.uploadPreview({
                input_field: "#edit-restaurent-img-upload-modal2",
                preview_box: "#edit-restaurent-img-preview-modal2",
                label_field: "#edit-restaurent-img-label-modal2"
            });

            $.uploadPreview({
                input_field: "#edit-restaurent-img-upload-modal3",
                preview_box: "#edit-restaurent-img-preview-modal3",
                label_field: "#edit-restaurent-img-label-modal3"
            });
			$('.edit-restaurant-image').on('change', function(){
    	        $delete_image = $(this).prev();
    	        $delete_image.removeClass('d-none');
    	        $delete_image.addClass('d-flex justify-content-end');
            });


            // $( "#addrestaurent form" ).submit(function( event ) {

            // 	var form=0;

            // 	if($(this).find("#inlineCheckbox1").is(':checked') || $(this).find("#inlineCheckbox2").is(':checked') || $(this).find("#inlineCheckbox3").is(':checked')){
            // 		form++;
            // 	}else{
            // 		alert("Please Select Tenant type");
            // 	}

            // 	if($(this).find('.property-input-wrapper input:checked').length){
            // 		form++;
            // 	}else{
            // 		alert("Please Select Property");
            // 	}

            // 	 //console.log($(this).find('.property-input-wrapper .profile-img-holder input:hasValue').serialize());
            // 	return form>1?true:event.preventDefault();

            // });

            $("#editform").submit(function(event) {

                var form = 0;

                 if ($(this).find("#elite").is(':checked') ||
                    $(this).find("#regular").is(':checked') ||
                    $(this).find("#nontenant").is(':checked')) {
                form++;
            } else {
                alert("Please Select Tenant type");
            }
            if ($(this).find('input:checked.property_radio').length) {
                form++;
            } else {
                alert("Please Select Property");
            }
			// $(this).find('#edit-restaurent-img-upload-modal1').val(''); 
            // if ($(this).find('#edit-restaurent-img-upload-modal1').val() || 
            //     $(this).find('#edit-restaurent-img-upload-modal2').val() || 
            //     $(this).find('#edit-restaurent-img-upload-modal3').val()) {
            //     form++;
            // } else {
            //     alert("Please Select one image");
            // }
            // if ($(this).find('#edit-restaurent-img-upload-modal4').val() || $(this).find(
            //         '#menu1').val() || $(this).find(
            //         '#menu2').val() || $(this).find(
            //         '#menu3').val() || $(this).find(
            //         '#menu4').val()) {
            //     form++;
            // } else {
            //     alert("Please Select one Menu image");
            // }
            return form > 1 ? true : event.preventDefault();

            });
        });

        $('.menu-image').on('change', function(){
            $delete_image = $(this).prev();
            $delete_image.removeClass('d-none');
    	    $delete_image.addClass('d-flex justify-content-end');
        });
		$.uploadPreview({
            input_field: "#add-restaurent-img-upload-modal13",
            preview_box: "#add-restaurent-img-preview-modal13",
            // label_field: "#edit-restaurent-img-label-modal3"
        });
		$.uploadPreview({
            input_field: "#add-restaurent-img-upload-modal4",
            preview_box: "#add-restaurent-img-preview-modal4",
            // label_field: "#edit-restaurent-img-label-modal3"
        });
        $.uploadPreview({
            input_field: "#add-restaurent-img-upload-modal5",
            preview_box: "#add-restaurent-img-preview-modal5",
            // label_field: "#edit-restaurent-img-label-modal3"
        });
        $.uploadPreview({
            input_field: "#add-restaurent-img-upload-modal11",
            preview_box: "#add-restaurent-img-preview-modal11",
            // label_field: "#edit-restaurent-img-label-modal3"
        });
        $.uploadPreview({
            input_field: "#add-restaurent-img-upload-modal12",
            preview_box: "#add-restaurent-img-preview-modal12",
            // label_field: "#edit-restaurent-img-label-modal3"
        });
        $.uploadPreview({
            input_field: "#edit-restaurent-img-upload-modal4",
            preview_box: "#edit-restaurent-img-preview-modal13",
            // label_field: "#edit-restaurent-img-label-modal3"
        });
        $.uploadPreview({
            input_field: "#edit-restaurent-img-upload-modal5",
            preview_box: "#edit-restaurent-img-preview-modal5",
            // label_field: "#edit-restaurent-img-label-modal3"
        });
        $.uploadPreview({
            input_field: "#edit-restaurent-img-upload-modal11",
            preview_box: "#edit-restaurent-img-preview-modal11",
            // label_field: "#edit-restaurent-img-label-modal3"
        });
        $.uploadPreview({
            input_field: "#edit-restaurent-img-upload-modal12",
            preview_box: "#edit-restaurent-img-preview-modal12",
            // label_field: "#edit-restaurent-img-label-modal3"
        });
		 $.uploadPreview({
            input_field: "#edit-restaurent-img-upload-modal19",
            preview_box: "#edit-restaurent-img-preview-modal19",
            // label_field: "#edit-restaurent-img-label-modal3"
        });
		$('.edit-menu-image').on('change', function(){
            $delete_image = $(this).prev();
            $delete_image.removeClass('d-none');
    	    $delete_image.addClass('d-flex justify-content-end');
        });
    </script>
    <script>
        $("#addrestaurent form").submit(function(event) {
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

            if ($(this).find('#add-restaurent-img-upload-modal1').val() || $(this).find(
                    '#add-restaurent-img-upload-modal2').val() || $(this).find(
                    '#add-restaurent-img-upload-modal3').val()) {
                form++;
            } else {
                // event.preventDefault()
                alert("Please Select one image");
            }

            if ($(this).find('#add-restaurent-img-upload-modal4').val() || $(this).find(
                    '#add-restaurent-img-upload-modal5').val() || $(this).find(
                    '#add-restaurent-img-upload-modal11').val() || $(this).find(
                    '#add-restaurent-img-upload-modal12').val() || $(this).find(
                    '#add-restaurent-img-upload-modal13').val() || true) {
                form++;
            } else {
                // event.preventDefault()
                alert("Please Select one Menu image");
            }
            //console.log($(this).find('.property-input-wrapper .profile-img-holder input:hasValue').serialize());
            return form > 3 ? true : event.preventDefault();
        });
    </script>

    <style>
        .image-preview-menu {
            background-size: contain;
            background-repeat-y: no-repeat;
        }
    </style>
<script>
    $('.delete-image').on('click', function(){
        $url=$(this).parent().find('a').attr('href');
        console.log($url);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $url,
            type: 'DELETE',
            data: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });
        $(this).next().val('');
        $(this).siblings('.menu-hidden').val('');
        $(this).parent().addClass("ms-2").css({"background-image":"unset", "background-size":"", "background-repeat":""});
        $(this).addClass('d-none');
    });
</script>
@endpush
