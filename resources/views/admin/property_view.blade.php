@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Property View')

@section('content')
<style type="text/css">
    .upload-pdf {
        margin-top: 10px;
    }

    .upload-pdf input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 10;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
    }

    .upload-pdf .input-group {
        background-color: #A0A0A0;
        /*max-width: 27%;*/
    }

    .upload-pdf .form-control:disabled,
    .form-control[readonly] {
        background-color: #C89328;
        opacity: 1;
        border: 0;
    }

    #imageviewer {
        background: transparent;
        padding: 10px;
        margin: 0;
        text-align: center;
        position: relative;
        width: initial;
    }

    #imageviewer:fullscreen,
    #imageviewer:-webkit-full-screen,
    #imageviewer:-moz-full-screen {
        padding: 0;
        background-color: #000;
    }

    #choose {
        height: 150px;
        width: 150px;
        background: #333333;
    }

    .slide input {
        display: none;
    }

    .slide label {
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }

    .slide-img img {
        border: 1px solid black;
        padding: 11px;
        height: 150px;
        max-width: 150px;
    }

    #imageviewer {
        padding: 0px;
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
    }

    .pure-button {
        border: 0;
    }

    .choose-file {
        height: 160px !important;
    }

    .profile-slider1 {
        max-width: 100%;
    }

    .property-profile {
        height: 160px !important;
        margin-inline: 10px;
    }

    .property-profile {
        position: relative;
        z-index: 1;
        padding-top: 8px;
    }

    .property-profile .cross-img {
        position: absolute;
        content: 'X';
        z-index: 3;
        top: 0;
        right: -8px;
        height: 25px;
        width: 25px;
        border-radius: 50%;
        background-color: #7E7E7E;
        text-align: center;
        color: white;
        cursor: pointer;
    }

    .profile-slider1 .slick-prev:before,
    .profile-slider1 .slick-next:before {
        content: '';

    }

    .profile-slider1 .slick-prev:before {
        content: '';
    }

    .profile-slider1 .slick-prev:hover:before,
    .profile-slider1 .slick-next:hover:before {
        color: white;
    }

    .profile-slider1 .slick-prev:hover,
    .profile-slider1 .slick-prev:focus,
    .profile-slider1 .slick-next:hover,
    .profile-slider1 .slick-next:focus {
        color: transparent !important;
        background: url({{asset('alfardan/assets/right.png')}});
    font-size: 0px;
    height: 20px;
    width: 15px;
    background-repeat: no-repeat;
    background-size: 12px;
    }

    .profile-slider1 .slick-prev:hover,
    .profile-slider1 .slick-prev:focus {
        transform: rotate(179deg);
        top: 35%;
        left: -25px;
    }

    .profile-slider1 .slick-prev,
    .profile-slider1 .slick-next {
        right: -30px;
        background: url({{asset('alfardan/assets/right.png')}});
    position: absolute;
    z-index: 1;
    top: 35%;
    font-size: 26px;
    height: 20px;
    width: 15px;
    background-repeat: no-repeat;
    background-size: 12px;
    }

    .profile-slider1 .slick-prev {
        transform: rotate(179deg);
        top: 35%;
        left: -25px;
    }

    .profile-slider1 .d-none {
        display: none;
    }

</style>
<main class="user-info-wrapper col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position">
    @include('notification.notify')
    @if($errors->any())
    @foreach($errors->all() as $error)
    <div class="alert alert-danger">
        {{$error}}
    </div>
    @endforeach
    @endif
    <h2 class="table-cap pb-2 mb-3 text-capitalize">{{$property->name}}</h2>

    <!-- First row -->
    <div class="row mb-4">
        <div class="col-xxl-4 col-xl-4 col-lg-4 col-sm-5 col-12 profile-slider">

            @foreach($property->images as $image)
            <div>
                <figure class="property-profile">
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remove-item" data-id="{{$image->id}}" data-url="{{route('admin.deleteimage',[$image->id])}}" class="deleteitem cross-img">X</a>
                    <img src="{{$image->path}}" alt="property Info Profile Pic">
                </figure>
            </div>
            @endforeach

        </div>
        <div class="col-xxl-8 col-xl-9">
            <div class="row mb-4">
                <div class="col-xxl-8">
                    <div class="table-responsive tenant-table">
                        <table class="table  table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col"><span>Location</span></th>
                                    <th scope="col" class="d-none"><span>3D View Link</span></th>
                                    <th scope="col"><span>Email</span></th>
                                    <th scope="col"><span>Call Number</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$property->location}}</td>
                                    <td class="d-none"><a href="{{$property->view_link}}" target="_blank">Link</a></td>
                                    <td>{{$property->email}}</td>
                                    <td>{{$property->phone}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-xxl-4 d-flex justify-content-end">
                    <div class="property-btn-holder">
                        <form action="{{route('admin.addTenantHandbook')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="propertyid" value="{{$property->id}}">
                            <div class="input-group  upload-pdf">
                                <span class="input-group-btn">
                                    <div class="btn btn-default browse-button p-0">
                                        <label class="add-btn property-btn text-white" style="white-space: nowrap;">Tenant Handbook</label>
                                        <input type="file" accept=".pdf" name="handbook" />
                                    </div>
                                </span>
                            </div>
                            <div class="input-group upload-pdf">

                                <span class="input-group-btn">
                                    <div class="btn btn-default browse-button2 p-0">
                                        <label class="add-btn property-btn text-white" style="white-space: nowrap;">Safety & Insurance</label>
                                        <input type="file" accept=".pdf" name="safety" />
                                    </div>
                                </span>
                            </div>
                            <div class="input-group  upload-pdf">
                                <span class="input-group-btn">
                                    <div class="btn btn-default browse-button3 p-0">
                                        <label class="add-btn property-btn text-white" style="white-space: nowrap;">Apartment Brochure</label>
                                        <input type="file" accept=".pdf" name="brochure" />
                                    </div>
                                </span>
                            </div>

                            <div class="input-group  upload-pdf">
                                <span class="input-group-btn">
                                    <div class="btn btn-default browse-button3 p-0">
                                        <label class="add-btn property-btn text-white" style="white-space: nowrap;">Safety Handbook</label>
                                        <input type="file" accept=".pdf" name="safety_handbook" />
                                    </div>
                                </span>
                            </div>
                            <div class="form-btn-holder mt-3 text-end  me-xxl-0 btn-holder">
                                <input class="form-btn" type="submit" name="submit" value="Upload" style="color: #fff;
													            font-size: 18px;
													            max-width: 133px;
													            height: 37px;
													            border: 1px solid #C89328;
													            text-transform: uppercase;
													            background: #C89328;">
                            </div>
                        </form>


                    </div>




                </div>
            </div>

            <div class="row">
                <div class="col-xxl-4">
                    <!-- small table start -->
                    <div class="table-responsive tenant-table small-status-table">

                        <table class="table  table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col"><span>Description </span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <p class="ps-3">{{$property->short_description}}</p>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- small table end -->
                </div>
            </div>
        </div>
    </div>






    <div class="row">

        <div class="col-xxl-2 slide mb-3">

            <button class="pure-button " id="files-holder">

                <label for="files" id="choose" class="choose-file"><svg xmlns="http://www.w3.org/2000/svg" width="70.247" height="70.247" viewBox="0 0 70.247 70.247">
                        <g id="Group_744" data-name="Group 744" transform="translate(-1046 -537.5)">
                            <line id="Line_541" data-name="Line 541" y2="70.247" transform="translate(1081.124 537.5)" fill="none" stroke="#fff" stroke-width="2" />
                            <line id="Line_542" data-name="Line 542" y2="70.247" transform="translate(1116.247 572.624) rotate(90)" fill="none" stroke="#fff" stroke-width="2" />
                        </g>
                    </svg>
                </label>
                <form action="{{route('admin.propertygalleryadd',[$property->id])}}" id="image_upload" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input id="files" type="file" multiple="" accept="image" name="files[]" id="selectfile" class="d-none" class="hidden">
                </form>
            </button>
        </div>

        <div class="col-xxl-5 slide-img mb-3">

            @if($property->gallery->count()<4) <div id="imageviewer">
                @foreach($property->gallery as $image)

                <figure class="property-profile">
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remove-item" data-id="{{$image->id}}" data-url="{{route('admin.propertygallerydelete',[$image->id])}}" class="deleteitem cross-img">X</a>
                    <img src="{{$image->image_url}}" alt="property Info Profile Pic" style="height: auto;max-width: 100%;">
                </figure>
                @endforeach
        </div>

        @else

        <div class="profile-slider1">
            @foreach($property->gallery as $image)
            <div>
                <figure class="property-profile">
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remove-item" data-id="{{$image->id}}" data-url="{{route('admin.propertygallerydelete',[$image->id])}}" class="deleteitem cross-img">X</a>
                    <img src="{{$image->image_url}}" alt="property Info Profile Pic" style="height: auto;max-width: 100%;">
                </figure>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <h2 class="table-cap pb-2 mb-3 text-capitalize">3D View </h2>
    <a class="add-btn my-3 add-btn" type="button" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#linkModal">ADD NEW 3D VIEW</a>

    <div class="row">
        <div class="col-xxl-4 col-xl-4">
            <div class="table-responsive tenant-table maintenance-table">

                <table class="table  table-bordered">
                    <thead>
                        <tr>
                            <th scope="col"><span>Name</span></th>
                            <th scope="col"><span>Link</span></th>
                        </tr>
                    </thead>
                    <tbody>

                        @if(!empty($property->view_link))
                        <tr>
                            <td><a href="{{$property->view_link}}" target="_blank">Link 1</a></td>
                            <td>{{$property->name}}</td>
                        </tr>
                        @endif

                        @if(!empty($property->view_link_1))
                        <tr>
                            <td><a href="{{$property->view_link_1}}" target="_blank">Link 2</a></td>
                            <td>{{$property->name}}</td>
                        </tr>
                        @endif

                        @if(!empty($property->view_link_2))
                        <tr>
                            <td><a href="{{$property->view_link_2}}" target="_blank">Link 3</a></td>
                            <td>{{$property->name}}</td>
                        </tr>
                        @endif

                        @if(!empty($property->view_link_3))
                        <tr>
                            <td><a href="{{$property->view_link_2}}" target="_blank">Link 4</a></td>
                            <td>{{$property->name}}</td>
                        </tr>
                        @endif

                        @if(!empty($property->view_link_4))
                        <tr>
                            <td><a href="{{$property->view_link_4}}" target="_blank">Link 5</a></td>
                            <td>{{$property->name}}</td>

                        </tr>
                        @endif

                        @foreach($property->p3dview as $image)
                        <tr>
                            <td><a target="_blank" href="{{$image->url}}">{{$image->name}}</a></td>
                            <td>{{$property->name}}</td>
                            <td class="p-0"> <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#linkModal" class="edit3dlink add-btn" data-id="{{$image->id}}" data-url="{{$image->url}}" data-name="{{$image->name}}" data-property_id="{{$image->property_id}}" data-route="{{route('admin.property3dupdate',[$image->property_id,$image->id])}}">Edit</a></td>


                            <td><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#remove-item" data-id="{{$image->id}}" data-url="{{route('admin.property3ddelete',[$image->id])}}" class="deleteitem">Remove</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <h2 class="table-cap pb-2 mb-3 text-capitalize">Towers</h2>
    <a class="add-btn my-3 mx-2" href="#" type="button" data-bs-toggle="modal" data-bs-target="#add-tower">Add Tower</a>
    <div>
        <div class="d-flex justify-content-between">
            <form action="{{route('admin.importTowers')}}" method="POST" enctype="multipart/form-data" class="px-2">
                {{csrf_field()}}
            <input type="hidden" name="property_id" value="{{$property->id}}">
            <input type="file" name="file" id="selectTowers" class="d-none">
                <label class="add-btn my-3" for="selectTowers">Import Towers</label>
                <div class="btn-holder input-group">
                    <input type="submit" name="status" value="Publish" class="form-btn mx-xxl-2 publish" />
                    <input type="submit" name="status" value="Draft" class="draft" />
                </div>
            </form>
            <form action="{{route('admin.importFloors')}}" method="POST" enctype="multipart/form-data" class="px-2">
                {{csrf_field()}}
            <input type="file" name="file" id="selectFloors" class="d-none">
                <label class="add-btn my-3" for="selectFloors">Import Floors</label>
                <div class="btn-holder input-group">
                    <input type="submit" name="status" value="Publish" class="form-btn mx-xxl-2 publish" />
                    <input type="submit" name="status" value="Draft" class="draft" />
                </div>
            </form>
            <form action="{{route('admin.importApartments')}}" method="POST" enctype="multipart/form-data" class="px-2">
                {{csrf_field()}}
            <input type="file" name="file" id="selectfile" class="d-none">
                <label class="add-btn my-3" for="selectfile">Import Apartments</label>
                <div class="btn-holder input-group">
                    <input type="submit" name="status" value="Publish" class="form-btn mx-xxl-2 publish" />
                    <input type="submit" name="status" value="Draft" class="draft" />
                </div>
            </form>
        </div>
    </div>
    <!-- second row start -->
    <div class="row">
        <div class="col-xxl-12 col-xl-12">
            <div class="table-responsive tenant-table maintenance-table">

                <table class="table  table-bordered">
                    <thead>
                        <tr>
                            <th scope="col"><span>Tower</span></th>
                            <th scope="col"><span>Property Name</span></th>
                            <th scope="col"><span>Location</span></th>
                            <th scope="col"><span>Import ID</span></th>
                            <th scope="col"><Span>Status</Span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                              $tower_list=$property->towers()->paginate(10);
                        ?>
                        @foreach($tower_list as $tower_details)
                        <tr>
                            <td><a href="{{(route('admin.tower_view',$tower_details->id))}}">{{$tower_details->name}}</a></td>
                            <td>{{$property->name}}</td>
                            <td>{{$property->location}}</td>
                            <td>{{$tower_details->id}}</td>
                            <td>
                                {{$tower_details->status==1?'Publish':'Draft'}}
                            </td>
                            <td class="cursor-pointer fw-bold table-edit" id="{{$tower_details->id}}" data-bs-toggle="modal" data-bs-target="#edit-tower" style="background-color: #C89328;">Edit</td>
                            <td><a type="button" class="table-delete fw-bold" data-bs-toggle="modal" data-bs-target="#remove-item" data-towerid="{{$tower_details->id}}">Remove</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $tower_list->links() }}
            </div>

        </div>
    </div>





















    @if(false)








    <!-- First row -->
    <div class="row">
        <div class="col-xxl-4 col-xl-4 col-lg-4 col-sm-5 col-12">

            <div class="profile-slider">
                @foreach($property->images as $image)
                <div>
                    <figure class="property-profile">
                        <img src="{{$image['path']}}" alt="property Info Profile Pic">
                    </figure>
                </div>
                @endforeach
                <!-- <div> <figure class="property-profile">
                <img src="assets/shutterstock.jpg" alt="property Info Profile Pic">
              </figure></div>
                  <div> <figure class="property-profile">
                <img src="assets/shutterstock.jpg" alt="property Info Profile Pic">
              </figure></div> -->
            </div>

            <!--  <figure class="property-profile">
                <img src="assets/shutterstock.jpg" alt="property Info Profile Pic">
              </figure> -->
        </div>

        <div class="col-xxl-8 col-xl-9">
            <div class="row">
                <div class="col-xxl-6">
                    <div class="table-responsive tenant-table">
                        <table class="table  table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col"><span>Location</span></th>
                                    <th scope="col"><span>3D View Link</span></th>
                                    <th scope="col"><span>Email</span></th>
                                    <th scope="col"><span>Call Number</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href="#">{{$property->location}}</a></td>
                                    <td>{{$property->view_link}}</td>
                                    <td>{{$property->email}}</td>
                                    <td>{{$property->phone}}</td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- <div class="col-xxl-6 d-flex justify-content-end "> -->
                <div class="col-xxl-6  justify-content-end ">
                    <form action="{{route('admin.addTenantHandbook')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="propertyid" value="{{$property->id}}">
                        <!-- <div class="property-btn-holder">
						<a href="#" class="add-btn property-btn mb-2">Tenant Handbook</a>
						<a href="#" class="add-btn property-btn mb-2">Safety & Insurance</a>
					</div> -->
                        <div class="input-group  upload-pdf">
                            <span class="input-group-btn">
                                <div class="btn btn-default browse-button">
                                    <label class="px-2 text-white">Tenant Handbook</label>
                                    <span class="browse-button-text text-white">
                                        <i class="fa fa-folder-open"></i> Browse</span>
                                    <input type="file" accept=".pdf" name="handbook" />
                                </div>
                                <button type="button" class="btn btn-default clear-button" style="display:none;color: #fff;">
                                    <span class="fa fa-times"></span> Clear
                                </button>
                            </span>
                            <input type="text" class="form-control filename add-btn " value="{{$property->handbook}}" disabled="disabled" @if(empty($property->handbook)) style="display:none" @endif >
                            <span class="input-group-btn"></span>
                        </div>

                        <div class="input-group upload-pdf">

                            <span class="input-group-btn">
                                <div class="btn btn-default browse-button2">
                                    <label class="px-2 text-white">Safety & Insurance</label>
                                    <span class="browse-button-text2 text-white">
                                        <i class="fa fa-folder-open"></i> Browse</span>
                                    <input type="file" accept=".pdf" name="safety" />

                                </div>
                                <button type="button" class="btn btn-default clear-button2" style="display:none;color: #fff;">
                                    <span class="fa fa-times"></span> Clear
                                </button>
                            </span>
                            <input type="text" class="form-control filename2 add-btn" disabled="disabled" value="{{$property->safety}}" disabled="disabled" @if(empty($property->safety)) style="display:none" @endif>
                            <span class="input-group-btn"></span>
                        </div>
                        <div class="input-group  upload-pdf">
                            <span class="input-group-btn">
                                <div class="btn btn-default browse-button3">
                                    <label class="px-2 text-white">Apartment Brochure</label>
                                    <span class="browse-button-text3 text-white">
                                        <i class="fa fa-folder-open"></i> Browse</span>
                                    <input type="file" accept=".pdf" name="brochure" />
                                </div>
                                <button type="button" class="btn btn-default clear-button3" style="display:none;color: #fff;">
                                    <span class="fa fa-times"></span> Clear
                                </button>
                            </span>
                            <input type="text" class="form-control filename3 add-btn " value="{{$property->brochure}}" disabled="disabled" @if(empty($property->brochure)) style="display:none" @endif >
                            <span class="input-group-btn"></span>
                        </div>
                        <div class="form-btn-holder mt-3 text-end  me-xxl-0 btn-holder">
                            <input class="form-btn" type="submit" name="submit" value="Upload" style="color: #fff;
		            font-size: 18px;
		            max-width: 133px;
		            height: 37px;
		            border: 1px solid #C89328;
		            text-transform: uppercase;
		            background: #C89328;">
                        </div>
                    </form>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-xxl-4">
                    <!-- small table start -->
                    <div class="table-responsive tenant-table small-status-table">

                        <table class="table  table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col"><span>Description </span></th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <p class="ps-3">{{$property->short_description}}</p>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- small table end -->
                </div>
                <div class="col-xxl-8">
                    <!-- small table start -->
                    <div class="table-responsive tenant-table small-description-table">

                        <!-- <table class="table  table-bordered">
							<thead>
								<tr>
									<th scope="col"><span>Short Description </span></th>

								</tr>
							</thead>
							<tbody>
								<tr>
									<td><p class="ps-2 text-start">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum d</p></td>

								</tr>       
							</tbody>
						</table> -->
                    </div>
                    <!-- small table end -->
                </div>
            </div>
        </div>
    </div>


    <h2 class="table-cap py-2 mb-3 text-capitalize">Apartments </h2>
    <div class="import" style="display: flex;justify-content: space-between;">
        <a class="add-btn my-3" href="#" type="button" data-bs-toggle="modal" data-bs-target="#add-apartment">ADD NEW APARTMENT</a>

        <form action="{{route('admin.importApartments')}}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="file" name="file" id="selectfile" class="d-none">
            <label class="add-btn my-3" for="selectfile">Select file</label>

            <br>
            <button class="add-btn">Import</button>
        </form>
    </div>
    <!-- second row start -->
    <div class="row">
        <div class="col-xxl-12 col-xl-12">
            <div class="table-responsive tenant-table maintenance-table">

                <table class="table  table-bordered">
                    <thead>
                        <tr>
                            <th scope="col"><span>Apartment Name</span></th>
                            <th scope="col"><span>Property Name</span></th>
                            <!-- <th scope="col"><span>Location</span></th>
							<th scope="col"><span>No. Of Bedrooms</span></th>
							<th scope="col"><span>No. Of Bathrooms</span></th>
							<th scope="col"><span>Availability</span></th>
							<th scope="col"><span>Area</span></th> -->
                            <th scope="col"><Span>Status</Span></th>



                        </tr>
                    </thead>
                    <tbody>
                        <?php 
								$apart_list=$property->apartments()->paginate(10);
							?>
                        @foreach($apart_list as $apart_details)
                        <tr>
                            <td><a href="{{(route('admin.apartment_view',$apart_details->id))}}">{{$apart_details->name}}</a></td>
                            <td>{{$property->name}}</td>

                            <td>@if($apart_details->status==1)
                                Publish

                                @else
                                Draft

                                @endif</td>
                            <td class="cursor-pointer fw-bold table-edit" id="{{$apart_details->id}}" data-bs-toggle="modal" data-bs-target="#edit-tower">Edit</td>
                            <td><a type="button" class="table-delete fw-bold" data-bs-toggle="modal" data-bs-target="#remove-item" data-towerid="{{$apart_details->id}}">Remove</a></td>
                        </tr>
                        @endforeach


                    </tbody>
                </table>


                {{ $apart_list->links() }}

            </div>

        </div>
    </div>

    @endif

</main>
<!--Add apartment  model start -->
<div class="modal fade" id="add-tower" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content border-0 bg-transparent">
            <div class="modal-body profile-model">
                <div class="container-fluid">
                    <div class="scnd-type-modal-form-wrapper more-extra-width" style="max-width: 45%;">
                        <form method="post" action="{{route('admin.addTower')}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="property_id" value="{{$property->id}}">
                            <input type="hidden" name="latitude" class="latitude">
                            <input type="hidden" name="longitude" class="longitude">
                            <h2 class="form-caption">Add Tower</h2>
                            <button type="button" class="btn-close-modal float-sm-end float-start mt-0 me-sm-0 me-4" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle" aria-hidden="true"></i></button>
                            <div class="row">
                                <div class="col-xl-10 col-lg-10 col-md-10 apartment-select">
                                    <!-- frst row -->
                                    <div class="row">
                                        <div class="input-field-group">
                                            <label for="property">Property</label>
                                            <input type="text" name="" value="{{$property->name}}" required readonly>
                                        </div>
                                        <div class="input-field-group location" id="addtower">
                                            <label for="tower">Tower Name</label>
                                            <input type="text" name="tower_name[]" required>
                                        </div>
                                        <div class="add-benefits">
                                            <a class="add-btn my-3 float-end pro-btn" onclick="addnewinput('tower_name','addtower')" href="#" type="button">+</a>
                                        </div>
                                    </div>

                                </div>
                                <div class="btn-holder">
                                    <input class="form-btn publish" name="publish" type="submit" value="Publish"></>
                                    <input type="submit" name="draft" value="Draft" class="draft"></>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
<!--add apartmnet model end -->
<!--edit apartment model start -->
<div class="modal fade" id="edit-tower" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 bg-transparent">
            <div class="modal-body profile-model">
                <div class="container-fluid">
                    <div class="scnd-type-modal-form-wrapper more-extra-width" style="max-width: 45%;">
                        <form method="post" action="{{route('admin.addTower')}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="towerid" id="towerid">
                            <input type="hidden" name="property_id" value="{{$property->id}}">
                            <h2 class="form-caption">Edit Tower</h2>
                            <button type="button" class="btn-close-modal float-sm-end float-start mt-0 me-sm-0 me-4" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle" aria-hidden="true"></i></button>
                            <div class="row">
                                <div class="col-xl-8 col-lg-8 col-md-8 apartment-select">
                                    <!-- frst row -->
                                    <div class="row">
                                        <div class="input-field-group">
                                            <label for="Apartment">Property</label>
                                            <input type="text" name="" value="{{$property->name}}" required readonly>
                                        </div>
                                        <div class="input-field-group">
                                            <label for="tower">Tower Name</label>
                                            <input type="text" name="tower_name" id="tower_name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="btn-holder">
                                    <input class="form-btn publish" name="publish" type="submit" value="Publish"></>
                                    <input type="submit" name="draft" value="Draft" class="draft"></>
                                </div>
                            </div>

                        </form>
                    </div>
                    <!-- sixth row-->
                </div>
            </div>
        </div>
    </div>
</div>
<!--edit apartment model end -->




<!-- Modal -->
<div class="modal fade" id="linkModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-user thred-link">
            <div class="modal-body profile-model">
                <div class="container-fluid px-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="body-wrapper">
                                <h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-2 ">Add New 3D links</h2>
                                <button type="button" class="btn-close-modal float-end" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
                                <form method="POST" action="{{route('admin.property3dadd',[$property->id])}}">
                                    {{csrf_field()}}
                                    {{method_field('POST')}}
                                    <div class="row">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                            <div class="add-family-form-wrapper ps-2 pe-3">
                                                <label>Name</label>
                                                <input type="text" name="name" id="name" required>
                                            </div>
                                        </div>
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                            <div class="add-family-form-wrapper ps-2 pe-3">
                                                <label>Add link</label>
                                                <input type="text" name="url" id="url" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="form-btn-holder mt-4 mb-3 text-end  me-xxl-0 px-4">
                                            <button class="form-btn">Publish</button>
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


<!-- delete modal start -->
<div class="modal remove-item" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <form method="POST" action="{{ route('admin.deleteTower','tower') }}">
                {{method_field('delete')}}
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="remove-content-wrapper">
                        <p>Are you sure you want to delete?</p>
                        <input type="hidden" name="towerid" id="towerid" value="">

                        <div class="delete-btn-wrapper">
                            <a href="#" type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close">cancel</a>
                            <!-- <a href="#">delete</a> -->
                            <button type="Submit" style="color: #fff;
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
<!-- delete modal end -->
@endsection
@push('script')
<script>
    $(function() {

        $(".profile-slider1").slick({
            lazyLoad: 'ondemand', // ondemand progressive anticipated
            infinite: true
            , slidesToShow: 3
            , slidesToScroll: 1

        });

        $(".table-delete").click(function(e){
            e.preventDefault();
            var id = $(this).attr('id');

        })


        $('.table-edit').click(function(e) {
            e.preventDefault(); // prevent form from reloading page
            var id = $(this).attr('id');
            $.ajax({
                url: "{{route('admin.getTower')}}"
                , type: 'Post'
                , data: {
                    'id': id
                    , _token: '{{ csrf_token() }}'
                }
                , dataType: 'json'
                , beforeSend: function() {
                    // Show image container
                    $("#loader").show();
                }
                , success: function(response) {
                    $('#towerid').val(response.id);
                    $('#tower_name').val(response.name);
                }
                , complete: function(data) {
                    // Hide image container
                    $("#loader").hide();
                }
            });
        });
    });
    // Show filename, show clear button and change browse 
    //button text when a valid extension file is selected
    $(".browse-button2 input:file").change(function() {
        $("input[name='handbook']").each(function() {
            var fileName = $(this).val().split('/').pop().split('\\').pop();
            $(".filename").show();
            $(".filename").val(fileName);
            $(".browse-button-text").html('<i class="fa fa-refresh"></i> Change');
            $(".clear-button").show();
        });
    });

    // secnd file
    $(".browse-button2 input:file").change(function() {
        $("input[name='safety']").each(function() {
            var fileName = $(this).val().split('/').pop().split('\\').pop();
            $(".filename2").show();
            $(".filename2").val(fileName);
            $(".browse-button-text2").html('<i class="fa fa-refresh"></i> Change');
            $(".clear-button2").show();
        });
    });

    $(".browse-button3 input:file").change(function() {
        $("input[name='brochure']").each(function() {
            var fileName = $(this).val().split('/').pop().split('\\').pop();
            $(".filename3").show();
            $(".filename3").val(fileName);
            $(".browse-button-text3").html('<i class="fa fa-refresh"></i> Change');
            $(".clear-button3").show();
        });
    });

    //actions happening when the button is clicked
    $('.clear-button').click(function() {
        $('.filename').hide();
        $('.filename').val("");
        $('.clear-button').hide();
        $('.browse-button2 input:file').val("");
        $(".browse-button-text").html('<i class="fa fa-folder-open"></i> Browse');
    });
    // secnd pdf
    $('.clear-button2').click(function() {
        $('.filename2').hide();
        $('.filename2').val("");
        $('.clear-button2').hide();
        $('.browse-button2 input:file').val("");
        $(".browse-button-text2").html('<i class="fa fa-folder-open"></i> Browse');
    });

    $('.clear-button3').click(function() {
        $('.filename3').hide();
        $('.filename3').val("");
        $('.clear-button3').hide();
        $('.browse-button3 input:file').val("");
        $(".browse-button-text3").html('<i class="fa fa-folder-open"></i> Browse');
    });

    $('#remove-item').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget);

        if (button.hasClass("deleteitem")) {

            $("#remove-item form").attr('action', button.data('url'));

        } else {
            $("#remove-item form").attr('action', "{{ route('admin.deleteTower','tower') }}");
            var towerid = button.data('towerid')
            var modal = $(this)
            modal.find('.modal-body #towerid').val(towerid);
        }
    });


    $('#linkModal').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget);

        if (button.hasClass("edit3dlink")) {

            $("#linkModal form").attr('action', button.data('route'));

            $("#linkModal #name").val(button.data('name'));
            $("#linkModal input[name=_method]").val("PATCH");
            $("#linkModal #url").val(button.data('url'));

        } else {

            $("#linkModal form").attr('action', "{{route('admin.property3dadd',[$property->id])}}");
            $("#linkModal #name").val("");
            $("#linkModal input[name=_method]").val("POST");
            $("#linkModal #url").val("");
        }
    });

    function addnewinput(name, appendid, value = "") {

        var elem = $("<input/>", {
            type: "text"
            , name: name + "[]"
            , value: value + ""
        });
        var removeLink = $("<span/>").html("X").click(function() {
            $(elem).remove();
            $(this).remove();
        });
        $("#" + appendid).append(elem).append(removeLink);
    }


    $(document).ready(function() {
        $("#files").change(function() {
            $("#image_upload").submit();
        });

    });

</script>
@endpush
