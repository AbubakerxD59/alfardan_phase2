@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Classes')

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
    <h2 class="table-cap pb-1">Classes</h2>
    <div>
        <a class="add-btn my-3 modal-click" href="#" type="button" data-bs-toggle="modal" data-bs-target="#addclass">ADD NEW CLASS</a>
    </div>
    <div class=" table-responsive tenant-table">
        <table class="table  table-bordered" id="myTable">
            <thead>
                <tr>
                    <th scope="col"><span>Class Name</span></th>
                    <th scope="col"><span>Teacher Name</span></th>
                    <!--<th scope="col"><span>Date</span></th>-->
                    <th scope="col"><span>Time</span></th>
                    <th scope="col"><span>Location</span></th>
                    <th scope="col"><span>Number Of
                            Attendees</span></th>
                    <th scope="col"><span>Total
                            Available</span></th>
                    <th scope="col"><span>Status</span></th>
                    <th style="background: transparent;"></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($classes as $class)

                <tr>
                    <td><a href="{{route('admin.class_view',$class->id)}}"> {{$class->name}}</a></td>
                    <td>{{$class->teacher}}</td>
                    <!--<td>{{$class->date}}</td>-->
                    <td>{{$class->time}}</td>
                    <td>{{$class->location}}</td>
                    <td>{{$class->reservations()}}</td>
                    <td>{{$class->seats}}</td>
                    <td>@if($class->status==1)
                        Publish

                        @else
                        Draft

                        @endif</td>
                    <td class="cursor-pointer table-edit fw-bold modal-click" id="{{$class->id}}" data-bs-toggle="modal" data-bs-target="#editclass">Edit</td>
                    <td class="btn-bg2"><a type="button" class="table-delete fw-bold" data-bs-toggle="modal" data-bs-target="#remove-item" data-classid="{{$class->id}}">Delete</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
<!--add class Model model start -->
<div class="modal fade" id="addclass" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body profile-model">
                <div class="container-fluid px-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="body-wrapper">
                                <h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">add Class</h2>
                                <button type="button" class="btn-close-modal float-sm-end float-start mt-0 me-sm-0 me-4" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle" aria-hidden="true"></i></button>
                                <form method="post" enctype="multipart/form-data" action="{{route('admin.addClass')}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="latitude" class="latitude">
                                    <input type="hidden" name="longitude" class="longitude">
                                    <div class="row">
                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4  ">
                                            <div class="add-family-form-wrapper ps-2 pe-3">
                                                <label>Class Name</label>
                                                <input type="text" name="class_name" required="required">
                                                <label>Location detail</label>
                                                <input type="text" name="locationdetail" required="required">
                                                <label>Teacher Name</label>
                                                <input type="text" name="teacher_name" required="required">
                                                <label class="d-none">Date</label>
                                                <input class="d-none" type="date" name="date" value="{{date('Y-m-d')}}" required="required">
                                                <label>Time</label>
                                                <input type="time" name="time" required="required">
                                                <div class="location-indicator">
                                                    <label>Location</label>
                                                    <input type="text" class="pe-4 location" name="location" required="required">
                                                    <i class="fa fa-map-marker-alt"></i>
                                                </div>
                                                <label>Number of Seats</label>
                                                <input type="text" name="seats" value="0" readonly>
                                                <label>Description</label>
                                                <textarea class="description-text-small" name="description" required="required"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 ps-4 label-size">
                                            <div class="profile-img-holder add-event-img-holder  mb-3">
                                                <figcaption>Images</figcaption>
                                                <div id="add-class-img-preview-modal1" class="image-preview">
                                                    <label class="text-uppercase" for="add-class-img-upload-modal1" id="add-class-img-label-modal1">add image</label>
                                                    <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
                                                    <input type="file" class="class-image" name="image1" id="add-class-img-upload-modal1" />
                                                </div>
                                                <div id="add-class-image-preview-modal2" class="image-preview">
                                                    <label class="text-uppercase" for="add-class-image-upload-modal2" id="add-class-image-label-modal2">add image</label>
                                                    <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
                                                    <input type="file" class="class-image" name="image2" id="add-class-image-upload-modal2" />
                                                </div>
                                                <div id="add-class-image-preview-modal3" class="image-preview">
                                                    <label class="text-uppercase" for="add-class-image-upload-modal3" id="add-class-image-label-modal3">add image</label>
                                                    <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
                                                    <input type="file" class="class-image" name="image3" id="add-class-image-upload-modal3" />
                                                </div>
                                            </div>
                                            <h2>Tenant</h2>
                                            <div class="profile-tenant-form">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="tenant_type[]" value="Elite">
                                                    <label class="form-check-label" for="inlineCheckbox1">Elite</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="tenant_type[]" type="checkbox" id="inlineCheckbox2" value="Regular">
                                                    <label class="form-check-label" for="inlineCheckbox2">Regular</label>
                                                </div>
                                                <h2>Property</h2>
                                                <div class="property-input-wrapper">
                                                    @foreach($properties as $property)
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input propertyids" name="property[]" type="checkbox" id="property" value="{{$property->id}}">
                                                        <label class="form-check-label" for="property">{{$property->name}}</label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <div>
                                                    <div class="input-field-group upload-pdf">
                                                        <span class="input-group-btn" style="cursor: pointer;">
                                                            <div class="btn btn-default browse-button2">
                                                                <span class="browse-button-text2 text-white" style="cursor: pointer;">
                                                                    <i class="fa fa-upload"></i>
                                                                    TERMS & CONDITIONS
                                                                </span>
                                                                <input type="file" accept=".pdf" name="terms">
                                                            </div>
                                                            <button type="button" class="btn btn-default clear-button" style="display:none;color: #fff;">
                                                                <span class="fa fa-trash"></span>
                                                                Delete
                                                            </button>
                                                        </span>
                                                        <input type="text" class="form-control filename2 add-btn" style="display: none;" disabled="disabled" value="">
                                                        <span class="input-group-btn"></span>
                                                    </div>
                                                </div>
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
<!--Add Class model end -->
<!--Edit Class model start -->
<div class="modal fade" id="editclass" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body profile-model">
                <div class="container-fluid px-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="body-wrapper">
                                <h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">Edit Class</h2>
                                <button type="button" class="btn-close-modal float-sm-end float-start mt-0 me-sm-0 me-4" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle" aria-hidden="true"></i></button>
                                <form method="post" enctype="multipart/form-data" action="{{route('admin.addClass')}}" id="editform">
                                    {{csrf_field()}}
                                    <input type="hidden" name="classid" id="classid">
                                    <input type="hidden" name="latitude" class="latitude" id="latitude">
                                    <input type="hidden" name="longitude" class="longitude" id="longitude">
                                    <div class="row">
                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4  ">
                                            <div class="add-family-form-wrapper ps-2 pe-3">
                                                <label>Class Name</label>
                                                <input type="text" name="class_name" id="class_name" required>
                                                <label>Location detail</label>
                                                <input type="text" name="locationdetail" id="locationdetail" required="required">
                                                <label>Teacher Name</label>
                                                <input type="text" name="teacher_name" id="teacher_name" required>
                                                <label class="d-none">Date</label>
                                                <input type="date" name="date" id="date" class="d-none" required="required">
                                                <label>Time</label>
                                                <input type="time" name="time" id="time" required>
                                                <div class="location-indicator">
                                                    <label>Location</label>
                                                    <input type="text" class="pe-4 location" name="location" id="location" required>
                                                    <i class="fa fa-map-marker-alt"></i>
                                                </div>
                                                <label>Number of Seats</label>
                                                <input type="text" name="seats" id="seats" readonly>
                                                <label>Description</label>
                                                <textarea class="description-text-small" name="description" id="description" required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 ps-4 label-size">
                                            <div class="profile-img-holder add-event-img-holder  mb-3">
                                                <figcaption>Images</figcaption>
                                                <div id="edit-class-img-preview-modal1" class="image-preview">
                                                    <label class="text-uppercase" for="edit-class-img-upload-modal1" id="edit-class-img-label-modal1">CHANGE IMAGE</label>
                                                    <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
                                                    <input type="file" class="edit-class-image" name="image1" id="edit-class-img-upload-modal1" />
                                                    <input type="hidden" name="image_1" id="image1">
                                                </div>
                                                <div id="edit-class-img-preview-modal2" class="image-preview">
                                                    <label class="text-uppercase" for="edit-class-img-upload-modal2" id="edit-class-img-label-modal2">CHANGE IMAGE</label>
                                                    <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
                                                    <input type="file" class="edit-class-image" name="image2" id="edit-class-img-upload-modal2" />
                                                    <input type="hidden" name="image_2" id="image2">

                                                </div>
                                                <div id="edit-class-img-preview-modal3" class="image-preview">
                                                    <label class="text-uppercase" for="edit-class-img-upload-modal3" id="edit-class-img-label-modal3">CHANGE IMAGE</label>
                                                    <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
                                                    <input type="file" class="edit-class-image" name="image3" id="edit-class-img-upload-modal3" />
                                                    <input type="hidden" name="image_3" id="image3">

                                                </div>
                                            </div>
                                            <h2>Tenant</h2>
                                            <div class="profile-tenant-form">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input tenantcheck" type="checkbox" id="tenant_type1" name="tenant_type[]" value="Elite">
                                                    <label class="form-check-label" for="inlineCheckbox1">Elite</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input tenantcheck" name="tenant_type[]" type="checkbox" id="tenant_type2" value="Regular">
                                                    <label class="form-check-label" for="inlineCheckbox2">Regular</label>
                                                </div>
                                                <h2>Property</h2>
                                                <div class="property-input-wrapper">
                                                    <?php $i=1?>
                                                    @foreach($properties as $property)
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input property_radio" name="property[]" type="checkbox" id="property{{$i}}" value="{{$property->id}}">
                                                        <label class="form-check-label" for="property">{{$property->name}}</label>
                                                    </div>
                                                    <?php $i++?>
                                                    @endforeach
                                                </div>
                                                <div class="input-field-group upload-pdf">
                                                    <span class="input-group-btn" style="cursor: pointer;">
                                                        <div class="btn btn-default browse-button2">
                                                            <span class="browse-button-text2 text-white" style="cursor: pointer;">
                                                                <i class="fa fa-upload"></i>
                                                                TERMS & CONDITIONS
                                                            </span>
                                                            <input type="file" accept=".pdf" name="terms">
                                                        </div>
                                                        <button type="button" class="btn btn-default clear-button" id="edit_clear" style="display:none;color: #fff;">
                                                            <span class="fa fa-trash"></span>
                                                            Delete
                                                        </button>
                                                    </span>
                                                    <input type="text" class="form-control filename2 add-btn" id="edit_terms" disabled="disabled" value="">
                                                    <span class="input-group-btn"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-btn-holder mb-3 text-end  me-xxl-0">
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
    </div>
</div>
<!--Edit Class model end -->
<!-- delete modal start -->
<div class="modal remove-item" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <form method="POST" action="{{ route('admin.deleteClass','class') }}">
                {{method_field('delete')}}
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="remove-content-wrapper">
                        <p>Are you sure you want to delete?</p>
                        <input type="hidden" name="classid" id="classid" value="">
                        <div class="delete-btn-wrapper">
                            <a href="#" type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close">cancel</a>
                            <button type="Submit" style="color: #fff; font-size: 18px; max-width: 133px; height: 37px; padding: 5px 32px; border: 1px solid #C89328; text-transform: uppercase; background: #C89328;">
                                delete
                            </button>
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
            $("#edit-class-img-preview-modal1").css("background-image", "unset");
            $("#edit-class-img-preview-modal2").css("background-image", "unset");
            $("#edit-class-img-preview-modal3").css("background-image", "unset");
            $('.edit-class-image').prev().removeClass('d-flex justify-content-end');
            $('.edit-class-image').prev().addClass('d-none');


            var id = $(this).attr('id');

            $.ajax({
                url: "{{route('admin.getClass')}}"
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
                    console.log(response);
                    $('#classid').val(response.id);
                    $('#class_name').val(response.name);
                    $('#locationdetail').val(response.locationdetail);

                    $('#teacher_name').val(response.teacher);
                    $('#location').val(response.location);
                    $('#seats').val(response.seats);
                    $('#description').val(response.description);
                    $('#time').val(response.time);
                    $('#date').val(response.date);
                    $('#latitude').val(response.latitude);
                    $('#longitude').val(response.longitude);
                    $('#edit_clear').attr("data-classIds", response.id);
                    if (response.term_cond != null) {
                        $('#edit_terms').val(response.term_cond.replace(/.*uploads\//, ''));
                        $(".filename2").show();
                        $(".clear-button").show();
                        $(".browse-button-text2").html('<i class="fa fa-refresh"></i> Change');
                    }

                    if (response.tenant_type != null) {
                        var tenant_type = response.tenant_type.split(',');
                        for (var i = 0; i <= 3; i++) {
                            var id = i + 1;
                            if (i < tenant_type.length) {

                                $('input.tenantcheck[value="' + tenant_type[i] + '"]').prop('checked', true);
                                // $("#tenant_type"+id +"").prop('checked', true);
                            }

                        }
                    }
                    if (response.property != null) {
                        var property = response.property;
                        for (var i = 0; i < property.length; i++) {
                            var id = i + 1;
                            if (i < id) {
                                $('input.property_radio[value="' + property[i] + '"]').prop('checked', true);
                                // $("#property"+id +"").prop('checked', true);
                            }

                        }
                    }

                    for (var i = 0; i <= 3; i++) {

                        if (i < response.images.length) {
                            // console.log(response.images[i]);
                            var img = i + 1;
                            $("#edit-class-img-preview-modal" + img + "").css("background-image", "url(" + response.images[i].path + ")");
                            $("#image" + img).val(response.images[i].id);
                            $("#edit-class-img-upload-modal" + img + "").prev().removeClass('d-none');
                            $("#edit-class-img-upload-modal" + img + "").prev().addClass('d-flex justify-content-end');
                        } else {
                            var img = i + 1;
                            $("#edit-class-img-preview-modal" + img + "").css("background-image", "unset");
                            $("#image" + img).val(0);
                        }
                    }
                }
                , complete: function(data) {
                    // Hide image container
                    $("#loader").hide();
                }
            });
        });
    });

    // delete popup modal
    $('#remove-item').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget)

        var classid = button.data('classid')
        var modal = $(this)

        modal.find('.modal-body #classid').val(classid);
    })

</script>
<script type="text/javascript">
    $(document).ready(function() {
        // add class modal images      
        $.uploadPreview({
            input_field: "#add-class-img-upload-modal1"
            , preview_box: "#add-class-img-preview-modal1"
            , label_field: "#add-class-img-label-modal1"
        });

        $.uploadPreview({
            input_field: "#add-class-image-upload-modal2"
            , preview_box: "#add-class-image-preview-modal2"
            , label_field: "#add-class-image-label-modal2"
        });

        $.uploadPreview({
            input_field: "#add-class-image-upload-modal3"
            , preview_box: "#add-class-image-preview-modal3"
            , label_field: "#add-class-image-label-modal3"
        });
        $('.class-image').on('change', function() {
            $delete_image = $(this).prev();
            $delete_image.removeClass('d-none');
            $delete_image.addClass('d-flex justify-content-end');
        });

        // edit class modal images
        $.uploadPreview({
            input_field: "#edit-class-img-upload-modal1"
            , preview_box: "#edit-class-img-preview-modal1"
            , label_field: "#edit-class-img-label-modal1"
        });

        $.uploadPreview({
            input_field: "#edit-class-img-upload-modal2"
            , preview_box: "#edit-class-img-preview-modal2"
            , label_field: "#edit-class-img-label-modal2"
        });

        $.uploadPreview({
            input_field: "#edit-class-img-upload-modal3"
            , preview_box: "#edit-class-img-preview-modal3"
            , label_field: "#edit-class-img-label-modal3"
        });
        $('.edit-class-image').on('change', function() {
            $delete_image = $(this).prev();
            $delete_image.removeClass('d-none');
            $delete_image.addClass('d-flex justify-content-end');
        });



        $("#addclass form").submit(function(event) {

            var form = 0;

            if ($(this).find("#inlineCheckbox1").is(':checked') || $(this).find("#inlineCheckbox2").is(':checked')) {
                form++;
            } else {
                alert("Please Select Tenant type");
            }

            if ($(this).find('input:checked.propertyids').length) {
                form++;
            } else {
                alert("Please Select Property");
            }


            if ($(this).find('#add-class-img-upload-modal1').val() || $(this).find('#add-class-image-upload-modal2').val() || $(this).find('#add-class-image-upload-modal3').val()) {
                form++;
            } else {
                alert("Please Select one image");
            }

            //console.log($(this).find('.property-input-wrapper .profile-img-holder input:hasValue').serialize());
            return form > 2 ? true : event.preventDefault();

        });

    });

</script>
<script>
    $('.delete-image').on('click', function() {
        $(this).next().val('');
        $(this).siblings('.menu-hidden').val('');
        $(this).parent().css("background-image", 'none');
        $(this).addClass('d-none');
    });

    $('.modal-click').on('click', function() {
        $(".clear-button").hide();
        $(".filename2").hide();
        $('.browse-button2 input:file').val("");
        $(".browse-button-text2").html('<i class="fa fa-upload"></i> TERMS & CONDITIONS');
    });

</script>
<script>
    // Show filename, show clear button and change browse 
    //button text when a valid extension file is selected
    $(".browse-button2 input:file").change(function() {
        console.log('changed');
        // $("input[name='terms']").each(function() {
        var fileName = $(this).val().split('/').pop().split('\\').pop();
        console.log(fileName);
        $(".filename2").val(fileName);
        $(".browse-button-text2").html('<i class="fa fa-refresh"></i> Change');
        $(".clear-button").show();
        $(".filename2").show();
        // });
    });
    //actions happening when the button is clicked
    $('.clear-button').click(function() {

        $('.filename2').val("");
        $('.clear-button').hide();
        $('.filename2').hide();
        $('.browse-button2 input:file').val("");
        $(".browse-button-text2").html('<i class="fa fa-upload"></i> TERMS & CONDITIONS');
    });
    $('#edit_clear').click(function() {
        var class_id = $(this).attr("data-classIds");
        $.ajax({
            url: "{{route('admin.delete_term')}}"
            , type: "post"
            , data: {
                type: 'classes'
                , id: class_id
                , _token: '{{ csrf_token() }}'
            }
            , dataType: "json"
            , success: function(response) {
                if (response) {
                    $('.filename2').val("");
                    $('.clear-button').hide();
                    $(".filename2").hide();
                    $('.browse-button2 input:file').val("");
                    $(".browse-button-text2").html('<i class="fa fa-upload"></i> TERMS & CONDITIONS');
                }
            }
        });
    });

</script>
@endpush
