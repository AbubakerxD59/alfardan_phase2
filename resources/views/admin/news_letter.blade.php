@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','News Letter')

@section('content')

<main class="user-info-wrapper col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position">
    @include('notification.notify')
    @if($errors->any())
    @foreach($errors->all() as $error)
    <div class="alert alert-danger">
        {{$error}}
    </div>
    @endforeach
    @endif
    <h2 class="table-cap pb-2 mb-3 text-capitalize">NewsLetter</h2>
    {{-- <div>
        <a class="add-btn my-3 modal-click" href="#" type="button" data-bs-toggle="modal" data-bs-target="#addnews">ADD NEWS LETTER</a>
    </div> --}}
    <div class="row">
        <div class="col-xxl-12 col-xl-12 mb-4">
            <div class="body-wrapper p-3" style="background-color:black;">
                <form method="post" enctype="multipart/form-data" action="{{ route('admin.newsletter_title') }}">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                            <div class="add-family-form-wrapper ps-2 pe-3 d-flex">
                                <div class="col-6 px-2">
                                    <label>Thumbnail Title</label>
                                    <input type="text" name="title" required="required" value="{{@$heads->title}}">
                                </div>
                                <div class="col-6 px-2">
                                    <div class="profile-img-holder add-event-img-holder mb-3">
                                        <div class="d-flex">
                                            <figcaption class="col-11">Image</figcaption>
                                            {{-- @if(@$heads)
                                            <div class="col-1 text-end">
                                                <a type="button" data-bs-toggle="modal" data-bs-target="#remove-head" data-headid="{{@$heads->id}}"><span><i class="fa fa-trash text-danger" style="font-size: 20px;"></i></span></a>
                                            </div>
                                            @endif --}}
                                        </div>
                                        <div id="add-class-image-preview-moda17" class="image-preview" style="background-size: cover; background-image: {{@$heads->photo}}">
                                            <label class="text-uppercase" for="add-class-img-upload-modal17" id="add-class-img-label-modal17">Add Image</label>
                                            <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
                                            <input type="file" class="class-image" name="photo" id="add-class-img-upload-modal17" />
                                        </div>
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
        <div class="col-xxl-12 col-xl-12 mt-1">
            <div class="body-wrapper p-4" style="background-color:black;">
                <form method="post" enctype="multipart/form-data" action="{{ route('admin.add_newsletter') }}">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                            <div class="add-family-form-wrapper ps-2 pe-3">
                                <div class="d-flex justify-content-between">
                                    <div class="col-6 px-2">
                                        <label>NewsLetter Title</label>
                                        <input type="text" name="newletter_title" required="required" value="{{@$news->title}}">
                                    </div>
                                    <div class="col-6 px-2">
                                        <div class="d-flex">
                                            <label class="col-11">Publishing Date</label>
                                            {{-- <div class="col-1 text-end">
                                                <a type="button" data-bs-toggle="modal" data-bs-target="#remove-head" data-headid="{{@$news->id}}"><span><i class="fa fa-trash text-danger" style="font-size: 20px;"></i></span></a>
                                            </div> --}}
                                        </div>
                                        <input type="date" name="newletter_date" required="required" value="{{@$news->publish_date}}" style="color-scheme: dark;">
                                    </div>
                                </div>
                                <div class="d-flex mt-3">
                                    <div class="col-12 px-2">
                                        <label>Intro Text</label>
                                        <textarea class="description-text-small" name="intro" required="required">{{@$news->intro}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(count($newsletters)==0)
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 my-2">
                            <div class="mx-3 p-3 add-family-form-wrapper d-flex justify-content-between mt-3 border border-warning">
                                <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-7">
                                    <div class="px-2">
                                        <label for="section_title">Section Title</label>
                                        <input type="text" name="section_title[]" required="required" value="{{@$newsletter->title}}">
                                    </div>
                                    <div class="px-2">
                                        <label for="section_description">Section Description</label>
                                        <input type="text" name="section_description[]" required="required" value="{{@$newsletter->description}}">
                                    </div>
                                    <div class="d-flex justify-content-betweem">
                                        <div class="col-6 px-2">
                                            <label for="cta_button">CTA Button</label>
                                            <input type="text" name="cta_button[]" value="{{@$newsletter->cta_button}}">
                                        </div>
                                        <div class="col-6 px-2">
                                            <label for="cta_link">CTA Link</label>
                                            <input type="text" name="cta_link[]" value="{{@$newsletter->cta_link}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-5">
                                    <div class="profile-img-holder add-event-img-holder mb-3">
                                        <figcaption>Image</figcaption>
                                        <div id="add-class-image-preview-moda16" class="image-preview" style="background-size: cover; background-image: {{@$newsletter->photo}}">
                                            <label class="text-uppercase" for="add-class-img-upload-modal16" id="add-class-img-label-modal16">Add Image</label>
                                            <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
                                            <input type="file" class="class-image" name="photo" id="add-class-img-upload-modal16" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @foreach ($newsletters as $key => $newsletter)
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 my-2">
                            <div class="mx-3 p-3 add-family-form-wrapper border border-warning d-flex justify-content-between mt-3">
                                <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-7">
                                    <input type="hidden" name="section_id[]" value="{{@$newsletter->id}}">
                                    <div class="px-2">
                                        <label for="section_title">Section Title</label>
                                        <input type="text" name="section_title[]" required="required" value="{{@$newsletter->title}}">
                                    </div>
                                    <div class="px-2">
                                        <label for="section_description">Section Description</label>
                                        <input type="text" name="section_description[]" required="required" value="{{@$newsletter->description}}">
                                    </div>
                                    <div class="d-flex justify-content-betweem">
                                        <div class="col-6 px-2">
                                            <label for="cta_button">CTA Button</label>
                                            <input type="text" name="cta_button[]" required value="{{@$newsletter->cta_button}}">
                                        </div>
                                        <div class="col-6 px-2">
                                            <label for="cta_link">CTA Link</label>
                                            <input type="text" name="cta_link[]" required value="{{@$newsletter->cta_link}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-5">
                                    <div class="profile-img-holder add-event-img-holder mb-3">
                                        <div class="d-flex">
                                            <figcaption class="col-11">Image</figcaption>
                                            <div class="col-1 text-end">
                                                <a type="button" data-bs-toggle="modal" data-bs-target="#remove-news" data-newsid="{{$newsletter->id}}"><span><i class="fa fa-trash text-danger" style="font-size: 20px;"></i></span></a>
                                            </div>
                                        </div>
                                        <div id="add-class-image-preview-moda{{$key+1}}" class="image-preview" style="background-size: cover; background-image: {{@$newsletter->photo}}">
                                            <label class="text-uppercase" for="add-class-img-upload-modal{{$key+1}}" id="add-class-img-label-modal{{$key+1}}">Add Image</label>
                                            <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
                                            <input type="file" class="class-image" name="photo" id="add-class-img-upload-modal{{$key+1}}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="old_section"></div>
                    <div class="col-12 mt-3 d-flex justify-content-center align-items-center">
                        <div class="col-1 plus_sign" style="cursor: pointer;">
                            <span class="form-btn w-100 d-flex justify-content-center align-items-center" style="font-size: 20px;">
                                <i class="fa fa-plus"></i>
                            </span>
                            {{-- <input class="form-btn publish" type="submit" value="+"> --}}
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
</main>
{{-- add new section --}}
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 my-2 new_section">
    <div class="mx-3 p-3 add-family-form-wrapper d-flex justify-content-between mt-3 border border-warning">
        <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-7">
            <div class="px-2">
                <label for="section_title">Section Title</label>
                <input type="text" name="section_title[]" required="required">
            </div>
            <div class="px-2">
                <label for="section_description">Section Description</label>
                <input type="text" name="section_description[]" required="required">
            </div>
            <div class="d-flex justify-content-betweem">
                <div class="col-6 px-2">
                    <label for="cta_button">CTA Button</label>
                    <input type="text" name="cta_button[]" required>
                </div>
                <div class="col-6 px-2">
                    <label for="cta_link">CTA Link</label>
                    <input type="text" name="cta_link[]" required>
                </div>
            </div>
        </div>
        <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-5">
            <div class="profile-img-holder add-event-img-holder mb-3">
                <figcaption>Image</figcaption>
                <div id="add-class-img-preview-moda" class="image-preview" style="background-size: cover; background-image: {{@$newsletter->photo}}">
                    <label class="text-uppercase" for="add-class-img-upload-moda" id="add-class-img-label-moda">Add Image</label>
                    <div class="delete-image d-none" style="cursor: pointer;"><span>x</span></div>
                    <input type="file" class="class-image" name="photo" id="add-class-img-upload-moda" />
                </div>
            </div>
        </div>
    </div>
</div>
{{-- add new section --}}
<!-- delete modal start -->
<div class="modal remove-head" id="remove-head" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <form method="POST" action="{{ route('admin.deleteHead') }}">
                {{-- {{method_field('delete')}} --}}
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="remove-content-wrapper">
                        <p>Are you sure you want to delete?</p>
                        <input type="hidden" name="headid" id="headid" value="">
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
<!-- delete modal start -->
<div class="modal remove-news" id="remove-news" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <form method="POST" action="{{ route('admin.deleteNews') }}">
                {{-- {{method_field('delete')}} --}}
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="remove-content-wrapper">
                        <p>Are you sure you want to delete?</p>
                        <input type="hidden" name="newsid" id="newsid" value="">
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
    $(document).ready(function() {
        // add class modal images
        $.uploadPreview({
            input_field: "#add-class-img-upload-moda"
            , preview_box: "#add-class-img-preview-moda"
            , label_field: "#add-class-img-label-moda"
        });
        $.uploadPreview({
            input_field: "#add-class-img-upload-modal1"
            , preview_box: "#add-class-image-preview-moda1"
            , label_field: "#add-class-img-label-modal1"
        });
        $.uploadPreview({
            input_field: "#add-class-img-upload-modal2"
            , preview_box: "#add-class-image-preview-moda2"
            , label_field: "#add-class-img-label-modal2"
        });
        $.uploadPreview({
            input_field: "#add-class-img-upload-modal3"
            , preview_box: "#add-class-image-preview-moda3"
            , label_field: "#add-class-img-label-modal3"
        });
        $.uploadPreview({
            input_field: "#add-class-img-upload-modal4"
            , preview_box: "#add-class-image-preview-moda4"
            , label_field: "#add-class-img-label-modal4"
        });
        $.uploadPreview({
            input_field: "#add-class-img-upload-modal5"
            , preview_box: "#add-class-image-preview-moda5"
            , label_field: "#add-class-img-label-modal5"
        });
        $.uploadPreview({
            input_field: "#add-class-img-upload-modal6"
            , preview_box: "#add-class-image-preview-moda6"
            , label_field: "#add-class-img-label-modal6"
        });
        $.uploadPreview({
            input_field: "#add-class-img-upload-modal7"
            , preview_box: "#add-class-image-preview-moda7"
            , label_field: "#add-class-img-label-modal7"
        });
        $.uploadPreview({
            input_field: "#add-class-img-upload-modal8"
            , preview_box: "#add-class-image-preview-moda8"
            , label_field: "#add-class-img-label-modal8"
        });
        $.uploadPreview({
            input_field: "#add-class-img-upload-modal9"
            , preview_box: "#add-class-image-preview-moda9"
            , label_field: "#add-class-img-label-modal9"
        });
        $.uploadPreview({
            input_field: "#add-class-img-upload-modal10"
            , preview_box: "#add-class-image-preview-moda10"
            , label_field: "#add-class-img-label-modal10"
        });
        $.uploadPreview({
            input_field: "#add-class-img-upload-modal11"
            , preview_box: "#add-class-image-preview-moda11"
            , label_field: "#add-class-img-label-modal11"
        });
        $.uploadPreview({
            input_field: "#add-class-img-upload-modal12"
            , preview_box: "#add-class-image-preview-moda12"
            , label_field: "#add-class-img-label-modal12"
        });
        $.uploadPreview({
            input_field: "#add-class-img-upload-modal13"
            , preview_box: "#add-class-image-preview-moda13"
            , label_field: "#add-class-img-label-modal13"
        });
        $.uploadPreview({
            input_field: "#add-class-img-upload-modal14"
            , preview_box: "#add-class-image-preview-moda14"
            , label_field: "#add-class-img-label-modal14"
        });
        $.uploadPreview({
            input_field: "#add-class-img-upload-modal15"
            , preview_box: "#add-class-image-preview-moda15"
            , label_field: "#add-class-img-label-modal15"
        });
        $.uploadPreview({
            input_field: "#add-class-img-upload-modal16"
            , preview_box: "#add-class-image-preview-moda16"
            , label_field: "#add-class-img-label-modal16"
        });
        $.uploadPreview({
            input_field: "#add-class-img-upload-modal17"
            , preview_box: "#add-class-image-preview-moda17"
            , label_field: "#add-class-img-label-modal17"
        });
        // Delete Thumbnail
        $('#remove-head').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var headid = button.data('headid');
            var modal = $(this);
            modal.find('.modal-body #headid').val(headid);
        })
        // Delete Newsletter
        $('#remove-news').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var newsid = button.data('newsid');
            var modal = $(this);
            modal.find('.modal-body #newsid').val(newsid);
        })
        // add new section
        $(".plus_sign").on('click', function() {
            var section = $(".new_section").html();
            $(".old_section").append(section)
        });

    });

</script>
@endpush
