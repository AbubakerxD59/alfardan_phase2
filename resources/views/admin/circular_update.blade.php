@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Circular Update')

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
    <div class="table-cap-space-between">
        <h2 class="table-cap pb-2 float-start text-capitalize">Circular Update</h2>
        <a class="add-btn my-3 float-end" id="add-new" href="#" type="button" data-bs-toggle="modal" data-bs-target="#add-circular-update">Add new</a>
    </div>
    <div class=" table-responsive tenant-table clear-both ">
        <table class="table  table-bordered " id="myTable">
            <thead>
                <tr>
                    <th>Circular ID</th>
                    <th>Submission Date/Time</th>
                    <!-- <th>Survey Link</a></th>  
					<th>Apartment</th>-->
                    <th>Property</th>
                    <th>Status</th>
                    <th style="background: transparent;"></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($updates as $update)
                <tr>
                    <td><a href="{{route('admin.circular_update_view',$update->id)}}">{{$update->circular_id}}</a></td>
                    <td>{{$update->created_at}}</td>
                    <!-- <td></td> 
					<td>{!!@$update->apartment()->implode('name',',<br/>')!!}</td>-->
                    <td>{!!@$update->property()->implode('name',',<br />')!!}</td>
                    <td>@if($update->status==1)
                        Publish
                        @else
                        Draft
                        @endif</td>
                    <td class="table-edit fw-bold cursor-pointer" id="{{$update->id}}" data-bs-toggle="modal" data-bs-target="#edit-circular-update">Edit</td>
                    <td class="btn-bg2"><a type="button" data-bs-toggle="modal" data-bs-target="#remove-item" data-circularid="{{$update->id}}" class="table-delete fw-bold">Remove</a></td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</main>

<div class="modal fade show" id="add-circular-update" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-modal="true" role="dialog" style="padding-right: 17px; display: none; padding-left: 0px;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body profile-model">
                <div class="container-fluid px-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="body-wrapper">
                                <h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">add Circular</h2>
                                <button type="button" class="btn-close-modal float-sm-end float-start mt-0 me-sm-0 me-4" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle" aria-hidden="true"></i></button>
                                <form method="post" enctype="multipart/form-data" action="{{route('admin.addCircular')}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="latitude" class="latitude">
                                    <input type="hidden" name="longitude" class="longitude">
                                    <div class="row">

                                        <div class="col-xxl-3 col-xl-3 col-lg-8 col-md-8 ps-4 label-size">
                                            <div class="profile-img-holder add-event-img-holder  mb-3">
                                                <figcaption>Circular Images</figcaption>
                                                <div id="add-class-img-preview-modal1" class="image-preview">
                                                    <label class="text-uppercase" for="add-class-img-upload-modal1" id="add-class-img-label-modal1">add image</label>
                                                    <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
                                                    <input type="file" name="image1" id="add-class-img-upload-modal1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-xl-3 col-lg-4 col-md-4  cutom-property">
                                            <div class="add-family-form-wrapper">
                                                <label>Circular Name</label>
                                                <input type="text" name="circular_name" required="required">
                                            </div>
                                            <label class="text-white" for="location">Property Name</label>
                                            <div class="property-input-wrapper label-name circular-inline addp">

                                                @foreach($properties as $property)
                                                <div class="form-check form-check-inline ">
                                                    <input class="form-check-input" name="property_id[]" type="checkbox" id="property{{$property->id}}" value="{{$property->id}}">
                                                    <label class="form-check-label " for="property{{$property->id}}">{{$property->name}}</label>
                                                </div>
                                                @endforeach

                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-xl-3 col-lg-4 col-md-4 cutom-property">
                                            <div class="add-family-form-wrapper ">
                                                <label>Circular ID</label>
                                                <input type="text" name="circular_id" required="required">

                                            </div>
                                            <label class="text-white" for="location">Apartments</label>
                                            <select name="apartment_id[]" class="custom-select2" multiple id="multiselect-drop1" style="background-color: #2B2B2B;width: 247px;">
                                                @foreach($apartments as $apartment)
                                                <option value="{{$apartment->id}}">{{$apartment->name}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 btm-border ">

                                            {{csrf_field()}}
                                            <div class="d-flex align-items-center">
                                                <input type="file" name="file" id="selectfileedit" class="d-none" onchange="display_pdf(this.value)">
                                                <label class="add-btn my-3 btn-upload" for="selectfileedit">Upload PDF</label>
                                                <span class="pdf_name text-light px-2"></span>
                                            </div>

                                            <div class="add-family-form-wrapper family-border">
                                                <label>Description</label>
                                                <textarea class="description-text" id="description_text" name="description"></textarea>
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

<!--edit circular-update form model start -->
<div class="modal fade" id="edit-circular-update" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body profile-model">
                <div class="container-fluid px-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="body-wrapper">
                                <h2 class="table-cap pb-2 text-capitalize mb-3 ms-2 mt-3 ">Edit Circular</h2>
                                <button type="button" class="btn-close-modal float-sm-end float-start mt-0 me-sm-0 me-4" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle" aria-hidden="true"></i></button>
                                <form method="post" enctype="multipart/form-data" action="{{route('admin.addCircular')}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="circularid" id="circularid">
                                    <div class="row">

                                        <div class="col-xxl-3 col-xl-3 col-lg-8 col-md-8 ps-4 label-size">
                                            <div class="profile-img-holder add-event-img-holder  mb-3">
                                                <figcaption>Circular Images</figcaption>
                                                <div id="edit-circular-image-preview" class="image-preview" style="background-size: contain;background-repeat: no-repeat;">
                                                    <label class="text-uppercase" for="edit-circular-image-upload" id="edit-circular-image-label">EDIT IMAGE</label>
                                                    <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
                                                    <input type="file" name="image1" id="edit-circular-image-upload">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-xl-3 col-lg-4 col-md-4  cutom-property">
                                            <div class="add-family-form-wrapper">
                                                <label>Circular Name</label>
                                                <input type="text" name="circular_name" id="circular_name" required="required">
                                            </div>
                                            <label class="text-white" for="location">Property Name</label>
                                            <div class="property-input-wrapper label-name circular-inline editc">

                                                @foreach($properties as $property)
                                                <div class="form-check form-check-inline ">
                                                    <input class="form-check-input" name="property_id[]" type="checkbox" id="property{{$property->id}}" value="{{$property->id}}">
                                                    <label class="form-check-label " for="property{{$property->id}}">{{$property->name}}</label>
                                                </div>
                                                @endforeach

                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-xl-3 col-lg-4 col-md-4 cutom-property edita">
                                            <div class="add-family-form-wrapper ">
                                                <label>Circular ID</label>
                                                <input type="text" name="circular_id" id="circular_id" required="required">

                                            </div>
                                            <label class="text-white" for="location">Apartments</label>
                                            <select name="apartment_id[]" class="custom-select2 " multiple id="multiselect-drop2" style="background-color: #2B2B2B;width: 247px;">
                                                @foreach($apartments as $apartment)
                                                <option value="{{$apartment->id}}">{{$apartment->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 btm-border ">

                                            {{csrf_field()}}
                                            <div class="d-flex align-items-center">
                                                <input type="file" name="file" id="selectfile" class="d-none" onchange="display_pdf(this.value)">
                                                <label class="add-btn my-3 btn-upload" for="selectfile">Upload PDF</label>
                                                <span class="pdf_name text-light px-2"></span>
                                            </div>

                                            <div class="add-family-form-wrapper family-border ">
                                                <label>Description</label>
                                                <textarea class="description mb-1 description-text" name="description" id="description" required="required"></textarea>

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
<!--Edit circular-update form model start -->
<!-- delete modal start -->
<div class="modal remove-item" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <form method="POST" action="{{ route('admin.deleteCircular','circular') }}">
                {{method_field('delete')}}
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="remove-content-wrapper">
                        <p>Are you sure you want to delete?</p>
                        <input type="hidden" name="circularid" id="circularid" value="">

                        <div class="delete-btn-wrapper">
                            <a href="#" type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close">cancel</a>
                            <!-- <a href="#">delete</a> -->
                            <button type="Submit" style="color: #fff;
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
@push('script')
<link rel="stylesheet" href="{{asset('richtexteditor/rte_theme_default.css')}}" />
<script type="text/javascript" src="{{asset('richtexteditor/rte.js')}}"></script>
<script type="text/javascript" src="{{asset('richtexteditor/plugins/all_plugins.js')}}"></script>

<style>
    .property-input-wrapper>.form-check.form-check-inline>label.form-check-label {
        color: #fff;
    }

    .ms-options-wrap>.ms-options>.ms-search>input[type="text"]::placeholder {
        color: #000;
    }

</style>
<script>
    $(function() {

        var editor1cfg = {};
        editor1cfg.toolbar = "basic";
        editor1cfg.skin = "gray";
        editor1cfg.maxTextLength = "500";
        var editor1 = new RichTextEditor("#description", editor1cfg);
        var editor2 = new RichTextEditor("#description_text", editor1cfg);

        $('#multiselect-drop2').multiselect({
            onOptionClick: function(element, option) {
                alert('selected_multi');
            }
        });



        $('.addp input').click(function(e) {
            var allprids = [];
            $('.addp input:checked').each(function(i, obj) {
                allprids.push($(this).val());
            });

            $.ajax({
                url: "{{route('admin.apartmentslist')}}"
                , type: 'Post'
                , data: {
                    'ids': allprids
                    , _token: '{{ csrf_token() }}'
                }
                , dataType: 'json'
                , beforeSend: function() {
                    // Show image container
                    $("#loader").show();
                }
                , success: function(response) {

                    $("#multiselect-drop1").html("");

                    $.each(response, function(index, value) {
                        var option = {
                            value: value.id
                            , text: value.name
                        };
                        $("#multiselect-drop1").append($('<option>', option));
                    });

                    $("#multiselect-drop1").multiselect('reload');

                }
                , complete: function(data) {
                    // Hide image container
                    $("#loader").hide();
                }
            });
        });


        $('.editc input').click(function(e) {
            var allprids = [];
            $('.editc input:checked').each(function(i, obj) {
                allprids.push($(this).val());
            });
            $.ajax({
                url: "{{route('admin.apartmentslist')}}"
                , type: 'Post'
                , data: {
                    'ids': allprids
                    , _token: '{{ csrf_token() }}'
                }
                , dataType: 'json'
                , beforeSend: function() {
                    // Show image container
                    $("#loader").show();
                }
                , success: function(response) {
                    var aps = $("#multiselect-drop2").data("apartment_id").split(",");

                    $("#multiselect-drop2").html("");

                    $.each(response, function(index, value) {
                        var option = {
                            value: value.id
                            , text: value.name
                        };
                        if (jQuery.inArray(value.id, aps) !== -1) {
                            option.selected = "selected";
                        }

                        $("#multiselect-drop2").append($('<option>', option));
                    });

                    $("#multiselect-drop2").val(aps);

                    $("#multiselect-drop2").multiselect('reload');

                }
                , complete: function(data) {
                    // Hide image container
                    $("#loader").hide();
                }
            });
        });

        $('.table-edit').click(function(e) {
            // $("#myTable").on("click", ".table-edit", function(e){	
            e.preventDefault(); // prevent form from reloading page
            $('#editform').trigger("reset");
            $("#edit-circular-image-preview").css("background-image", "unset");
            var id = $(this).attr('id');
            $("#edit-circular-image-upload").prev().removeClass('d-flex justify-content-end');
            $("#edit-circular-image-upload").prev().addClass('d-none');
            $('.pdf_name').html('');

            $.ajax({
                url: "{{route('admin.getCircular')}}"
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
                    // console.log( $pdfname.replace('uploads/pdfs/','') )
                    $pdfname = "";
                    if (response.pdffile != null) {
                        console.log('not null');
                        $pdfname = response.pdffile;
                        $('.pdf_name').html("( " + $pdfname.replace('uploads/pdfs/', '') + " )");
                    }
                    $('#circularid').val(response.id);
                    $('#description').val(response.description);
                    editor1.setHTMLCode(response.description);
                    $('#circular_id').val(response.circular_id);
                    $('#circular_name').val(response.circular_name);
                    var lastid = "";
                    $(".editc input").removeAttr("checked");

                    var allprids = response.property_id.split(",");
                    $.each(response.property_id.split(","), function(i, e) {
                        //$("#property_id option[value='" + e + "']").prop("selected", true);
                        $(".editc #property" + e).attr("checked", "checked");
                        //$(".editc #property"+e ).trigger( "click" );

                    });
                    // console.log(response.property_id.split(","));
                    $("#multiselect-drop2").val(response.apartment_id.split(","));
                    $("#multiselect-drop2").data("apartment_id", response.apartment_id);

                    $.ajax({
                        url: "{{route('admin.apartmentslist')}}"
                        , type: 'Post'
                        , data: {
                            'ids': allprids
                            , _token: '{{ csrf_token() }}'
                        }
                        , dataType: 'json'
                        , beforeSend: function() {
                            // Show image container
                            $("#loader").show();
                        }
                        , success: function(response) {
                            var aps = $("#multiselect-drop2").data("apartment_id").split(",");

                            $("#multiselect-drop2").html("");

                            $.each(response, function(index, value) {
                                var option = {
                                    value: value.id
                                    , text: value.name
                                };
                                if (jQuery.inArray(value.id, aps) !== -1) {
                                    option.selected = "selected";
                                }

                                $("#multiselect-drop2").append($('<option>', option));
                            });

                            $("#multiselect-drop2").val(aps);

                            $("#multiselect-drop2").multiselect('reload');

                        }
                        , complete: function(data) {
                            // Hide image container
                            $("#loader").hide();
                        }
                    });

                    //$(".editc input").trigger( "click" );
                    var name = [];


                    $.each(response.apartment_id.split(","), function(i, e) {
                        $("#multiselect-drop2 option[value='" + e + "']").prop("selected", true);
                        var input = $('.edita>.ms-options-wrap>.ms-options>ul>li input[value="' + e + '"]');
                        if (input) {
                            //input.attr("checked", "checked");
                            input.trigger("click");
                            //input.trigger( "change" );
                            name.push(input.attr('title'));
                        }
                    });
                    $('.edita>.ms-options-wrap>button').html(name.join(","));

                    // $('#property_id').val(response.property_id).attr("selected", "selected");
                    // $('#apartment_id').val(response.apartment_id).attr("selected", "selected");

                    if (response.cover != null) {

                        $("#edit-circular-image-preview").css("background-image", "url(" + response.cover + ")");
                        $("#edit-circular-image-upload").prev().removeClass('d-none');
                        $("#edit-circular-image-upload").prev().addClass('d-flex justify-content-end');
                    } else {

                        $("#edit-circular-image-preview").css("background-image", "unset");
                    }
                    // if(response.image!=''){

                    // 	$("#edit-circular-image-preview1").css("background-image", "url(" + response.image + ")");
                    // }
                    // else{

                    // 	$("#edit-circular-image-preview1").css("background-image", "unset");
                    // }

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

        var circularid = button.data('circularid')
        var modal = $(this)

        modal.find('.modal-body #circularid').val(circularid);
    })

    $(document).ready(function() {
        $.uploadPreview({
            input_field: "#add-class-img-upload-modal1"
            , preview_box: "#add-class-img-preview-modal1"
            , label_field: "#add-circular-image-preview"
        });

        $.uploadPreview({
            input_field: "#add-circular-image-upload"
            , preview_box: "#add-circular-image-preview"
            , label_field: "#add-circular-image-label"
        });

        $.uploadPreview({
            input_field: "#add-circular-image-upload1"
            , preview_box: "#add-circular-image-preview1"
            , label_field: "#add-circular-image-label1"
        });


        // For edit
        $.uploadPreview({
            input_field: "#edit-circular-image-upload"
            , preview_box: "#edit-circular-image-preview"
            , label_field: "#edit-circular-image-label"
        });

        $.uploadPreview({
            input_field: "#edit-circular-image-upload1"
            , preview_box: "#edit-circular-image-preview1"
            , label_field: "#edit-circular-image-label1"
        });
        $('#add-class-img-upload-modal1').on('change', function() {
            $delete_image = $(this).prev();
            $delete_image.removeClass('d-none');
            $delete_image.addClass('d-flex justify-content-end');
        });
        $('#edit-circular-image-upload').on('change', function() {
            $delete_image = $(this).prev();
            $delete_image.removeClass('d-none');
            $delete_image.addClass('d-flex justify-content-end');
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

    function display_pdf(pdf) {
        $file_name = "";
        if (pdf) {
            $file_name = "( " + pdf.replace(/C:\\fakepath\\/i, '') + " )";
        }
        console.log($file_name);
        $('.pdf_name').html($file_name);
    }

    $('#add-new').on('click', function() {
        $('.pdf_name').html('');
    });

</script>
@endpush
