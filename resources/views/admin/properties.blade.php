@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title', 'Properties')

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
        <div class="row">
            <div class="col-12">
                <div class="table-cap-space-between">
                    <h2 class="table-cap pb-2 float-start text-capitalize">Properties</h2>
                    <a class="add-btn my-3 float-end" href="#" type="button" data-bs-toggle="modal"
                        data-bs-target="#add-properties">Add new</a>
                </div>
                <div class=" table-responsive tenant-table clear-both ">
                    <table class="table  table-bordered " id="myTable">
                        <thead>
                            <tr>
                                <th> Property Name</th>
                                <th> Google Map</th>
                                <th> No. Apartments</th>
                                <th> Status</th>
                                <th> Order</th>
                                <th> Import ID</th>
                                <th style="background: transparent;"></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($properties as $property)
                                <tr>
                                    <td><a
                                            href="{{ route('admin.property_view', $property->id) }}">{{ $property->name }}</a>
                                    </td>
                                    <td>{{ $property->location }}</td>
                                    <td>{{ $property->total_apartment() }}</td>
                                    <td>
                                        @if ($property->status == 1)
                                            Publish
                                        @else
                                            Draft
                                        @endif
                                    </td>
                                    <td>{{ $property->order }}</td>
                                    <td>{{ $property->id }}</td>
                                    <!-- <td>Published</td> -->
                                    <td class="cursor-pointer fw-bold table-edit" id="{{ $property->id }}"
                                        data-bs-toggle="modal" data-bs-target="#edit-properties">Edit</td>
                                    <td class="btn-bg2"><a type="button" class="table-delete fw-bold"
                                            data-bs-toggle="modal" data-bs-target="#remove-item"
                                            data-propertyid="{{ $property->id }}">Remove</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>


    <!--Add properties form model start -->
    <div class="modal fade" id="add-properties" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog ">

            <div class="modal-content border-0 bg-transparent">
                <div class="modal-body">
                    <div class="container-fluid px-0">
                        <div class="scnd-type-modal-form-wrapper more-extra-width">
                            <form method="post" action="{{ route('admin.addProperty') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="latitude" class="latitude">
                                <input type="hidden" name="longitude" class="longitude">
                                <h2 class="form-caption">Add Property</h2>
                                <button type="button" class="btn-close-modal float-end mt-0 me-0" data-bs-dismiss="modal"
                                    aria-label="Close"><i class="far fa-times-circle"></i></button>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-5 service-select">
                                        <!-- frst row -->
                                        <div class="row">
                                            <div class="input-field-group">
                                                <label for="username">Property Name</label>
                                                <input type="text" name="property_name" required="required">
                                            </div>
                                            <div class="input-field-group">
                                                <label>Location detail</label>
                                                <input type="text" name="locationdetail" required="required">
                                            </div>

                                            <div class="input-field-group location">
                                                <label for="Location">Google Map</label>
                                                <input type="text" class="pe-4 location" name="location" required>
                                                <i class="fas fa-map-marker-alt"></i>
                                            </div>

                                            <div class="input-field-group  d-none">
                                                <label for="Link">3D View Link 1</label>
                                                <input type="text" name="link">
                                            </div>

                                            <div class="input-field-group d-none">
                                                <label for="Link">3D View Link 2</label>
                                                <input type="text" name="view_link_1" value="">
                                            </div>

                                            <div class="input-field-group d-none">
                                                <label for="Link">3D View Link 3</label>
                                                <input type="text" name="view_link_2" value="">
                                            </div>

                                            <div class="input-field-group d-none">
                                                <label for="Link">3D View Link 4</label>
                                                <input type="text" name="view_link_3" value="">
                                            </div>

                                            <div class="input-field-group d-none">
                                                <label for="Link">3D View Link 5</label>
                                                <input type="text" name="view_link_4" value="">
                                            </div>

                                            <div class="input-field-group">
                                                <label for="Number">Call Number</label>
                                                <input type="text" name="phone" required>
                                            </div>

                                            <div class="input-field-group">
                                                <label for="cpnumber">Concierge phone number</label>
                                                <input type="text" name="cpnumber" required>
                                            </div>
                                            <div class="input-field-group">
                                                <label for="whatsapp">Whatsapp Numberr</label>
                                                <input type="text" name="whatsapp" required>
                                            </div>

                                            <div class="input-field-group">
                                                <label for="Email">Email</label>
                                                <input type="email" name="email" required>
                                            </div>
                                            <!-- <div class="input-field-group">
                                   <label for="Residences">Residences</label>
                                   <div class="custom-select2 form-rounded my-2">

                                    <select name="residences">

                                     <option value="residence">Residence</option>
                                     
                                    </select>
                                   </div>
                                  </div> -->
                                            <div class="input-field-group location" id="residencesadd">
                                                <label for="Residences">Residences</label>
                                                <input type="text" class="pe-4" name="residences[]">
                                            </div>
                                            <div class="add-benefits">
                                                <a class="add-btn my-3 float-end pro-btn"
                                                    onclick="addnewinput('residences','residencesadd')" href="#"
                                                    type="button">+</a>
                                            </div>
                                            <!-- <div class="input-field-group">
                                   <label for="Facilities">Facilities</label>
                                   <div class="custom-select2 form-rounded my-2">

                                    <select name="facilities">

                                     <option value="facilities">Facilities</option>
                                     
                                    </select>
                                   </div>
                                  </div> -->
                                            <div class="input-field-group location" id="facilitiesadd">
                                                <label for="Residences">Facilities</label>
                                                <input type="text" class="pe-4" name="facilities[]">
                                            </div>
                                            <div class="add-benefits">
                                                <a class="add-btn my-3 float-end pro-btn"
                                                    onclick="addnewinput('facilities','facilitiesadd')" href="#"
                                                    type="button">+</a>
                                            </div>
                                            <!-- <div class="input-field-group">
                                   <label for="Services">Services</label>
                                   <div class="custom-select2 form-rounded my-2">

                                    <select name="services">

                                     <option value="services">Services</option>
                                     
                                    </select>
                                   </div>
                                  </div> -->
                                            <div class="input-field-group location" id="servicesadd">
                                                <label for="Residences">Services</label>
                                                <input type="text" class="pe-4" name="services[]">
                                            </div>
                                            <div class="add-benefits">
                                                <a class="add-btn my-3 float-end pro-btn"
                                                    onclick="addnewinput('services','servicesadd')" href="#"
                                                    type="button">+</a>
                                            </div>
                                        </div>

                                    </div>
                                    <div class=" col-xl-8 col-lg-8 ps-xl-0 ps-lg-5 col-md-7">

                                        <div class="profile-img-holder add-event-img-holder  mb-3">
                                            <figcaption>Images</figcaption>
                                            <div id="add-class-img-preview-modal1" class="image-preview">
                                                <label class="text-uppercase" for="add-class-img-upload-modal1"
                                                    id="add-class-img-label-modal1">add image</label>
                                                 <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
												<input type="file" class="property-image" name="image1" id="add-class-img-upload-modal1"
                                                    onclick="addimage('add-class-img-upload-modal1','add-class-img-preview-modal1','add-class-img-label-modal1')" />
                                            </div>
                                            <div id="add-class-image-preview-modal2" class="image-preview">
                                                <label class="text-uppercase" for="add-class-image-upload-modal2"
                                                    id="add-class-image-label-modal2">add image</label>
                                                 <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
												<input type="file" class="property-image" name="image2" id="add-class-image-upload-modal2"
                                                    onclick="addimage('add-class-image-upload-modal2','add-class-image-preview-modal2','add-class-image-label-modal2')" />
                                            </div>
                                            <div id="add-class-image-preview-modal3" class="image-preview">
                                                <label class="text-uppercase" for="add-class-image-upload-modal3"
                                                    id="add-class-image-label-modal3">add image</label>
                                                 <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
												<input type="file" class="property-image" name="image3" id="add-class-image-upload-modal3"
                                                    onclick="addimage('add-class-image-upload-modal3','add-class-image-preview-modal3','add-class-image-label-modal3')" />
                                            </div>
                                            <div id="add-class-image-preview-modal4" class="image-preview">
                                                <label class="text-uppercase" for="add-class-image-upload-modal4"
                                                    id="add-class-image-label-modal4">add image</label>
                                                 <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
												<input type="file" class="property-image" name="image4" id="add-class-image-upload-modal4"
                                                    onclick="addimage('add-class-image-upload-modal4','add-class-image-preview-modal4','add-class-image-label-modal4')" />
                                            </div>
                                            <div id="add-class-image-preview-modal5" class="image-preview">
                                                <label class="text-uppercase" for="add-class-image-upload-modal5"
                                                    id="add-class-image-label-modal5">add image</label>
                                                 <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
												<input type="file" class="property-image" name="image5" id="add-class-image-upload-modal5"
                                                    onclick="addimage('add-class-image-upload-modal5','add-class-image-preview-modal5','add-class-image-label-modal5')" />
                                            </div>
                                        </div>

                                        <!-- 2nd row -->
                                        <div class="row">
                                            <div class="input-field-group col-8">
                                                <label>Short Description</label>
                                                <textarea class="description mb-1" name="short_description" required></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6 service-select">

                                                <!-- <div class="input-field-group my-1">
                                    <label for="Privileges">Privileges</label>
                                    <div class="custom-select2 form-rounded my-2">

                                     <select name="privileges">

                                      <option value="privileges">privileges</option>
                                      
                                     </select>
                                    </div>
                                    
                                   </div> -->
                                                <div class="input-field-group location" id="privilegesadd">
                                                    <label for="Residences">Privileges</label>
                                                    <input type="text" class="pe-4" name="privileges[]">
                                                </div>
                                                <div class="add-benefits">
                                                    <a class="add-btn my-3 float-end pro-btn"
                                                        onclick="addnewinput('privileges','privilegesadd')" href="#"
                                                        type="button">+</a>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <!-- sixth row-->

                                <div class="form-btn-holder mb-3 text-end  me-xxl-0 btn-holder">
                                    <!-- <button class="form-btn " type="submit">Publish</button>
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
    <!--Add properties form model end -->
    <!--edit properties form model start -->
    <div class="modal fade" id="edit-properties" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog ">

            <div class="modal-content border-0 bg-transparent">
                <div class="modal-body">
                    <div class="container-fluid px-0">
                        <div class="scnd-type-modal-form-wrapper more-extra-width">
                            <form method="post" action="{{ route('admin.addProperty') }}" enctype="multipart/form-data"
                                id="editform">
                                {{ csrf_field() }}
                                <input type="hidden" name="propertyid" id="propertyid">
                                <input type="hidden" name="latitude" class="latitude" id="latitude">
                                <input type="hidden" name="longitude" class="longitude" id="longitude">
                                <h2 class="form-caption">Edit Property</h2>
                                <button type="button" class="btn-close-modal float-end mt-0 me-0"
                                    data-bs-dismiss="modal" aria-label="Close"><i
                                        class="far fa-times-circle"></i></button>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-5 service-select">
                                        <!-- frst row -->
                                        <div class="row">
                                            <div class="input-field-group">
                                                <label for="username">Property Name</label>
                                                <input type="text" name="property_name" id="property_name"
                                                    required="required">
                                            </div>

                                            <div class="input-field-group">
                                                <label>Location detail</label>
                                                <input type="text" name="locationdetail" id="locationdetail"
                                                    required="required">
                                            </div>
                                            <div class="input-field-group location">
                                                <label for="Location">Google Map</label>
                                                <input type="text" class="pe-4 location" name="location"
                                                    id="location" required>
                                                <i class="fas fa-map-marker-alt"></i>
                                            </div>

                                            <div class="input-field-group  d-none">
                                                <label for="Link">3D View Link 1</label>
                                                <input type="text" name="link" id="link">
                                            </div>

                                            <div class="input-field-group d-none">
                                                <label for="Link">3D View Link 2</label>
                                                <input type="text" name="view_link_1" id="view_link_1">
                                            </div>

                                            <div class="input-field-group  d-none">
                                                <label for="Link">3D View Link 3</label>
                                                <input type="text" name="view_link_2" id="view_link_2">
                                            </div>

                                            <div class="input-field-group  d-none">
                                                <label for="Link">3D View Link 4</label>
                                                <input type="text" name="view_link_3" id="view_link_3">
                                            </div>

                                            <div class="input-field-group  d-none">
                                                <label for="Link">3D View Link 5</label>
                                                <input type="text" name="view_link_4" id="view_link_4">
                                            </div>

                                            <div class="input-field-group">
                                                <label for="Number">Call Number</label>
                                                <input type="text" name="phone" id="phone" required>
                                            </div>

                                            <div class="input-field-group">
                                                <label for="cpnumber">Concierge phone number</label>
                                                <input type="text" name="cpnumber" id="cpnumber" required>
                                            </div>
                                            <div class="input-field-group">
                                                <label for="whatsapp">Whatsapp Numberr</label>
                                                <input type="text" name="whatsapp" id="whatsapp" required>
                                            </div>
                                            <div class="input-field-group">
                                                <label for="order">Order</label>
                                                <input type="text" name="order" id="order" required>
                                            </div>

                                            <div class="input-field-group">
                                                <label for="Email">Email</label>
                                                <input type="email" name="email" id="email" required>
                                            </div>
                                            <!-- <div class="input-field-group">
                                   <label for="Residences">Residences</label>
                                   <div class="custom-select2 form-rounded my-2">

                                    <select name="residences">

                                     <option value="residence">Residence</option>
                                     
                                    </select>
                                   </div>
                                  </div> -->
                                            <div class="input-field-group location residencesedit" id="residencesedit">
                                                <label for="Residences">Residences</label>
                                                <!-- <input type="text"  class="pe-4" name="residences[]" id="residences"> -->
                                            </div>
                                            <div class="add-benefits">
                                                <a class="add-btn my-3 float-end pro-btn"
                                                    onclick="addnewinput('residences','residencesedit')" href="#"
                                                    type="button">+</a>
                                            </div>
                                            <!-- <div class="input-field-group">
                                   <label for="Facilities">Facilities</label>
                                   <div class="custom-select2 form-rounded my-2">

                                    <select name="facilities">

                                     <option value="facilities">Facilities</option>
                                     
                                    </select>
                                   </div>
                                  </div> -->
                                            <div class="input-field-group location facilitiesedit" id="facilitiesedit">
                                                <label for="Residences">Facilities</label>
                                                <!-- <input type="text"  class="pe-4" name="facilities[]" > -->
                                            </div>
                                            <div class="add-benefits">
                                                <a class="add-btn my-3 float-end pro-btn"
                                                    onclick="addnewinput('facilities','facilitiesedit')" href="#"
                                                    type="button">+</a>
                                            </div>
                                            <!-- <div class="input-field-group">
                                   <label for="Services">Services</label>
                                   <div class="custom-select2 form-rounded my-2">

                                    <select name="services">

                                     <option value="services">Services</option>
                                     
                                    </select>
                                   </div>
                                  </div> -->
                                            <div class="input-field-group location servicesedit" id="servicesedit">
                                                <label for="Residences">Services</label>
                                                <!-- <input type="text"  class="pe-4" name="services[]" > -->
                                            </div>
                                            <div class="add-benefits">
                                                <a class="add-btn my-3 float-end pro-btn"
                                                    onclick="addnewinput('services','servicesedit')" href="#"
                                                    type="button">+</a>
                                            </div>
                                        </div>

                                    </div>
                                    <div class=" col-xl-8 col-lg-8 ps-xl-0 ps-lg-5 col-md-7">

                                        <div class="profile-img-holder add-event-img-holder  mb-3">
                                            <figcaption>Images</figcaption>
                                            <div id="edit-class-img-preview-modal1" class="image-preview">
                                                <label class="text-uppercase" for="edit-class-img-upload-modal1"
                                                    id="edit-class-img-label-modal1">CHANGE IMAGE</label>
                                                <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
												<input type="file" class="edit-property-image" name="image1" id="edit-class-img-upload-modal1"
                                                    onclick="addimage('edit-class-img-upload-modal1','edit-class-img-preview-modal1','edit-class-img-label-modal1')" />
                                                <input type="hidden" name="image_1" id="image1">
                                                <a href="" id="image_form_1" class="d-none"></a>
                                            </div>
                                            <div id="edit-class-img-preview-modal2" class="image-preview">
                                                <label class="text-uppercase" for="edit-class-img-upload-modal2"
                                                    id="edit-class-img-label-modal2">CHANGE IMAGE</label>
                                                <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
												<input type="file" class="edit-property-image" name="image2" id="edit-class-img-upload-modal2"
                                                    onclick="addimage('edit-class-img-upload-modal2','edit-class-img-preview-modal2','edit-class-img-label-modal2')" />
                                                <input type="hidden" name="image_2" id="image2">
                                                <a href="" id="image_form_2" class="d-none"></a>
                                            </div>
                                            <div id="edit-class-img-preview-modal3" class="image-preview">
                                                <label class="text-uppercase" for="edit-class-img-upload-modal3"
                                                    id="edit-class-img-label-modal3">CHANGE IMAGE</label>
                                                <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
												<input type="file" class="edit-property-image" name="image3" id="edit-class-img-upload-modal3"
                                                    onclick="addimage('edit-class-img-upload-modal3','edit-class-img-preview-modal3','edit-class-img-label-modal3')" />
                                                <input type="hidden" name="image_3" id="image3">
                                                <a href="" id="image_form_3" class="d-none"></a>
                                            </div>
                                            <div id="edit-class-img-preview-modal4" class="image-preview">
                                                <label class="text-uppercase" for="edit-class-img-upload-modal4"
                                                    id="edit-class-img-label-modal4">CHANGE IMAGE</label>
                                                <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
												<input type="file" class="edit-property-image" name="image4" id="edit-class-img-upload-modal4"
                                                    onclick="addimage('edit-class-img-upload-modal4','edit-class-img-preview-modal4','edit-class-img-label-modal4')" />
                                                <input type="hidden" name="image_4" id="image4">
                                                <a href="" id="image_form_4" class="d-none"></a>
                                            </div>
                                            <div id="edit-class-img-preview-modal5" class="image-preview">
                                                <label class="text-uppercase" for="edit-class-img-upload-modal5"
                                                    id="edit-class-img-label-modal5">CHANGE IMAGE</label>
                                                <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
												<input type="file" class="edit-property-image" name="image5" id="edit-class-img-upload-modal5"
                                                    onclick="addimage('edit-class-img-upload-modal5','edit-class-img-preview-modal5','edit-class-img-label-modal5')" />
                                                <input type="hidden" name="image_5" id="image5">
                                                <a href="" id="image_form_5" class="d-none"></a>
                                            </div>
                                        </div>

                                        <!-- 2nd row -->
                                        <div class="row">
                                            <div class="input-field-group col-8">
                                                <label>Short Description</label>
                                                <textarea class="description mb-1" name="short_description" id="short_description" required></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6 service-select">

                                                <!-- <div class="input-field-group my-1">
                                          <label for="Privileges">Privileges</label>
                                          <div class="custom-select2 form-rounded my-2">

                                          <select name="privileges">

                                          <option value="services">Services</option>

                                          </select>
                                          </div>
                                          
                                          </div> -->
                                                <div class="input-field-group location privilegesedit"
                                                    id="privilegesedit">
                                                    <label for="Residences">Privileges</label>
                                                    <!-- <input type="text"  class="pe-4" name="privileges[]" > -->
                                                </div>
                                                <div class="add-benefits">
                                                    <a class="add-btn my-3 float-end pro-btn"
                                                        onclick="addnewinput('privileges','privilegesedit')"
                                                        href="#" type="button">+</a>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <!-- sixth row-->

                                <div class="form-btn-holder mb-3 text-end  me-xxl-0 btn-holder">
                                    <!-- <button class="form-btn" type="submit">Publish</button>
                                      <a class="form-btn" id="draft" style="display: inline-block;
			    background-color: transparent;
			    border: 1px solid #C89328;
			    font-size: 15px;
			    font-weight: bold;
			    height: 48px;
			    line-height: 48px;
			    max-width: 154px;
			    padding-inline: 44px 59px;
			    margin-bottom: 17px;
			    color: #fff;">Draft</a> -->
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
    <!--Edit properties form model start -->


    <!-- delete modal start -->
    <div class="modal remove-item" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-transparent border-0">
                <form method="POST" action="{{ route('admin.deleteProperty', 'property') }}">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="remove-content-wrapper">
                            <p>Are you sure you want to delete?</p>
                            <input type="hidden" name="propertyid" id="propertyid" value="">

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
    <!-- delete modal end -->
    <!-- Image loader -->
    <!-- <div id="loader" style="display: none;top: 200px;left: 0;position: fixed;z-index: 100000;text-align: center;">
                          <img src="{{ asset('loader.gif') }}" width="100px" height="100px">
                        </div> -->
    <!-- Image loader -->
@endsection
@push('script')
    <script type="text/javascript">
        // document.ready function
		$('.property-image').on('change', function(){
    	    $delete_image = $(this).prev();
    	    $delete_image.removeClass('d-none');
    	    $delete_image.addClass('d-flex justify-content-end');
        });
        $('.edit-property-image').on('change', function(){
            $delete_image = $(this).prev();
            $delete_image.removeClass('d-none');
            $delete_image.addClass('d-flex justify-content-end');
        });
        $(function() {
            $("#myTable").on("click", ".table-edit", function(e) {
                // $('.table-edit').click(function(e) {
                e.preventDefault(); // prevent form from reloading page
                $('#editform').trigger("reset");
                $("#edit-class-img-preview-modal1").css("background-image", "unset");
                $("#edit-class-img-preview-modal2").css("background-image", "unset");
                $("#edit-class-img-preview-modal3").css("background-image", "unset");
                var id = $(this).attr('id');
				$('.edit-property-image').prev().removeClass('d-flex justify-content-end');
			    $('.edit-property-image').prev().addClass('d-none');

                $.ajax({
                    url: "{{ route('admin.getProperty') }}",
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
                        $('#propertyid').val(response.id);
                        $('#property_name').val(response.name);
                        $('#locationdetail').val(response.locationdetail);

                        $('#location').val(response.location);
                        $('#link').val(response.view_link);
                        $('#view_link_1').val(response.view_link_1);
                        $('#view_link_2').val(response.view_link_2);
                        $('#view_link_3').val(response.view_link_3);
                        $('#view_link_4').val(response.view_link_4);
                        $('#phone').val(response.phone);
                        $('#cpnumber').val(response.cpnumber);
                        $('#whatsapp').val(response.whatsapp);
                        $('#order').val(response.order);
                        $('#email').val(response.email);
                        $('#short_description').val(response.short_description);
                        // $('#privileges').val(response.privileges);
                        $('#latitude').val(response.latitude);
                        $('#longitude').val(response.longitude);

                        // $('#draft').attr('href','{{ url('/admin/draft/property') }}/'+response.id);

                        // residences data
                        if (response.residences.length > 0) {


                            for (var i = 0; i < response.residences.length; i++) {


                                var elem = $('<input>').attr({
                                    type: 'text',
                                    name: 'residences[]',
                                    value: response.residences[i],
                                    class: 'pe-4 redidencefield' + i,
                                    id: i
                                });
                                var removeLink = $("<span class='redidencefield" + i +
                                    "'  id=" + i + ">").html("X").click(function() {
                                    var spanid = $(this).attr('id');

                                    $(".redidencefield" + spanid).remove();

                                });
                                $('.redidencefield' + i).remove();
                                $('.residencesedit').append(elem).append(removeLink);
                            }
                        }
                        // else{
                        // 	$('.residencesedit').append("");
                        // }
                        // facilities data
                        if (response.facilities.length > 0) {


                            for (var i = 0; i < response.facilities.length; i++) {


                                var elem = $('<input>').attr({
                                    type: 'text',
                                    name: 'facilities[]',
                                    value: response.facilities[i],
                                    class: 'pe-4 facilitiesfield' + i,
                                    id: i
                                });
                                var removeLink = $("<span class='facilitiesfield" + i +
                                    "'  id=" + i + ">").html("X").click(function() {
                                    var spanid = $(this).attr('id');

                                    $(".facilitiesfield" + spanid).remove();

                                });
                                $('.facilitiesfield' + i).remove();
                                $('.facilitiesedit').append(elem).append(removeLink);
                            }
                        }
                        // else{
                        // 	$('.residencesedit').append("");
                        // }
                        // services data
                        if (response.services.length > 0) {


                            for (var i = 0; i < response.services.length; i++) {


                                var elem = $('<input>').attr({
                                    type: 'text',
                                    name: 'services[]',
                                    value: response.services[i],
                                    class: 'pe-4 servicesfield' + i,
                                    id: i
                                });
                                var removeLink = $("<span class='servicesfield" + i + "'  id=" +
                                    i + ">").html("X").click(function() {
                                    var spanid = $(this).attr('id');

                                    $(".servicesfield" + spanid).remove();

                                });
                                $('.servicesfield' + i).remove();
                                $('.servicesedit').append(elem).append(removeLink);
                            }
                        }

                        // privileges data
                        if (response.privileges.length > 0) {


                            for (var i = 0; i < response.privileges.length; i++) {


                                var elem = $('<input>').attr({
                                    type: 'text',
                                    name: 'privileges[]',
                                    value: response.privileges[i],
                                    class: 'pe-4 privilegesfield' + i,
                                    id: i
                                });
                                var removeLink = $("<span class='privilegesfield" + i +
                                    "'  id=" + i + ">").html("X").click(function() {
                                    var spanid = $(this).attr('id');

                                    $(".privilegesfield" + spanid).remove();

                                });
                                $('.privilegesfield' + i).remove();
                                $('.privilegesedit').append(elem).append(removeLink);
                            }
                        }
                        // else{
                        // 	$('.residencesedit').append("");
                        // }
                        for (var i = 0; i <= 5; i++) {

                            if (i < response.images.length) {
                                console.log(response.images[i].path);
                                var img = i + 1;
                                $("#edit-class-img-preview-modal" + img + "").css(
                                    "background-image", "url(" + response.images[i].path +
                                    ")");
                                $("#image" + img).val(response.images[i].id);
                                var image_id=response.images[i].id;
                                var route='{{route('admin.deleteimage',[0])}}'
                                $("#image_form_"+img).attr('href', route+image_id);
                                if(response.images[i].path){
                                    $("#edit-class-img-upload-modal" + img + "").prev().removeClass('d-none');
                                    $("#edit-class-img-upload-modal" + img + "").prev().addClass('d-flex justify-content-end');
                                }
                            } else {
                                var img = i + 1;
                                $("#edit-class-img-preview-modal" + img + "").css(
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

            var propertyid = button.data('propertyid')
            var modal = $(this)

            modal.find('.modal-body #propertyid').val(propertyid);
        })
    </script>
    <!-- <script type="text/javascript">
        $(document).ready(function() {

            $.uploadPreview({
                input_field: "#add-properties-image-upload",
                preview_box: "#add-properties-image-preview",
                label_field: "#add-properties-image-label"
            });

            $.uploadPreview({
                input_field: "#edit-properties-image-upload",
                preview_box: "#edit-properties-image-preview",
                label_field: "#edit-properties-image-label"
            });
        });
    </script> -->
    <script type="text/javascript">
        // dropdown
        // $(document).ready(function(){

        // add class modal images      
        // $.uploadPreview({
        //   input_field: "#add-class-img-upload-modal1",
        //   preview_box: "#add-class-img-preview-modal1",
        //   label_field: "#add-class-img-label-modal1"
        // });

        // $.uploadPreview({
        //   input_field: "#add-class-image-upload-modal2",
        //   preview_box: "#add-class-image-preview-modal2",
        //   label_field: "#add-class-image-label-modal2"
        // });

        // $.uploadPreview({
        //   input_field: "#add-class-image-upload-modal3",
        //   preview_box: "#add-class-image-preview-modal3",
        //   label_field: "#add-class-image-label-modal3"
        // });


        // edit class modal images
        // $.uploadPreview({
        //   input_field: "#edit-class-img-upload-modal1",
        //   preview_box: "#edit-class-img-preview-modal1",
        //   label_field: "#edit-class-img-label-modal1"
        // });

        // $.uploadPreview({
        //   input_field: "#edit-class-img-upload-modal2",
        //   preview_box: "#edit-class-img-preview-modal2",
        //   label_field: "#edit-class-img-label-modal2"
        // });

        // $.uploadPreview({
        //   input_field: "#edit-class-img-upload-modal3",
        //   preview_box: "#edit-class-img-preview-modal3",
        //   label_field: "#edit-class-img-label-modal3"
        // });

        // }); 


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

        function addimage(input, box, lable) {

            $.uploadPreview({
                input_field: "#" + input,
                preview_box: "#" + box,
                label_field: "#" + lable
            });
        }
    </script>

    <script>
        $("#add-properties form").submit(function(event) {
            var form = 0;

            if ($(this).find('#add-class-img-upload-modal1').val() ||
                $(this).find('#add-class-img-upload-modal2').val() ||
                $(this).find('#add-class-img-upload-modal3').val() ||
                $(this).find('#add-class-img-upload-modal4').val() ||
                $(this).find('#add-class-img-upload-modal5').val()) {
                form++;
            } else {
                // event.preventDefault()
                alert("Please Select one image");
            }

            //console.log($(this).find('.property-input-wrapper .profile-img-holder input:hasValue').serialize());
            return form > 0 ? true : event.preventDefault();
        });
    </script>
	<script>
    	$('.delete-image').on('click', function(){
            $url=$(this).parent().find('a').attr('href');
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
    		$(this).next().val('' );
    		$(this).siblings('.menu-hidden').val('');
    		$(this).parent().css("background-image",'none');
    		$(this).addClass('d-none');
    	});
    </script>
@endpush
