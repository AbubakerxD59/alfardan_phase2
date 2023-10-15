@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Floor View')

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
    <h2 class="table-cap pb-2 mb-3 text-capitalize">{{$floor->name}}</h2>
    <div class="d-flex justify-content-between">
        <a class="add-btn my-3 mx-2 col-3" href="#" type="button" data-bs-toggle="modal" data-bs-target="#add-apart">Add Apartment</a>
        <form action="{{route('admin.importApartments')}}" method="POST" enctype="multipart/form-data" class="px-2">
            {{csrf_field()}}
            <input type="hidden" name="floor" value="{{$floor->id}}">
            <input type="file" name="file" id="selectfile" class="d-none">
            <label class="add-btn my-3" for="selectfile">Import Apartments</label>
            <div class="btn-holder input-group">
                <input type="submit" name="status" value="Publish" class="form-btn mx-xxl-2 publish" />
                <input type="submit" name="status" value="Draft" class="draft" />
            </div>
        </form>
    </div>
    <!-- First row -->
    <div class="row">
        {{-- <h4 class="table-cap pb-2 mb-3 text-capitalize">Apartments</h4> --}}
        <div class="col-xxl-8 col-xl-8 mt-2">
            <div class="table-responsive tenant-table">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Apartment</th>
                            <th>Floor</th>
                            <th>Tower Name</th>
                            <th>Property Name</th>
                            <th>Location</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $apart_list=$floor->apartments()->paginate(10);    
                        ?>
                        @foreach ($apart_list as $apart_details)
                        <tr>
                            <td><a href="{{(route('admin.apartment_view',$apart_details->id))}}">{{$apart_details->name}}</a></td>
                            <td>{{$apart_details->name}}</td>
                            <td>{{$floor->tower->name}}</td>
                            <td>{{$floor->property->name}}</td>
                            <td>{{$floor->property->location}}</td>
                            <td>
                                {{$apart_details->status==1?'Publish':'Draft'}}
                            </td>
                            <td class="p-0"> <a class="cursor-pointer fw-bold table-edit add-btn" id="{{$apart_details->id}}" data-bs-toggle="modal" data-bs-target="#edit-apartment">Edit</a>
                            </td>
                            <td><a type="button" class="table-delete fw-bold" data-bs-toggle="modal" data-bs-target="#remove-item" data-apartmentid="{{$apart_details->id}}">Remove</a></td>/
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$apart_list->links()}}
            </div>
        </div>
    </div>
</main>
<!--Add apartment  model start -->
<div class="modal fade" id="add-apart" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 bg-transparent">
            <div class="modal-body profile-model">
                <div class="container-fluid">
                    <div class="scnd-type-modal-form-wrapper more-extra-width" style="max-width: 45%;">
                        <form method="post" action="{{route('admin.addApartment')}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="property_id" value="{{$floor->property->id}}">
                            <input type="hidden" name="tower_id" value="{{$floor->tower->id}}">
                            <input type="hidden" name="floor_id" value="{{$floor->id}}">
                            <h2 class="form-caption">Add Apartment</h2>
                            <button type="button" class="btn-close-modal float-sm-end float-start mt-0 me-sm-0 me-4" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle" aria-hidden="true"></i></button>
                            <div class="row">
                                <div class="col-xl-10 col-lg-10 col-md-10 apartment-select">
                                    <div class="row">
                                        <div class="input-field-group">
                                            <label for="property">Property</label>
                                            <input type="text" name="property" value="{{$floor->property->name}}" required readonly>
                                        </div>
                                        <div class="input-field-group">
                                            <label for="tower">Tower</label>
                                            <input type="text" name="tower" value="{{$floor->tower->name}}" required readonly>
                                        </div>
                                        <div class="input-field-group">
                                            <label for="floor">Floor</label>
                                            <input type="text" name="floor" value="{{$floor->name}}" required readonly>
                                        </div>
                                        <div class="input-field-group location" id="addApart">
                                            <label for="apartment">Apartment Name</label>
                                            <input type="text" name="apt_name[]" required>
                                        </div>
                                        <div class="add-benefits">
                                            <a class="add-btn my-3 float-end pro-btn" onclick="addnewinput('apt_name','addApart')" href="#" type="button">+</a>
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
<div class="modal fade" id="edit-apartment" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 bg-transparent">
            <div class="modal-body profile-model">
                <div class="container-fluid">
                    <div class="scnd-type-modal-form-wrapper more-extra-width" style="max-width: 45%;">
                        <form method="post" action="{{route('admin.addApartment')}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="apartmentid" id="apartmentid">
                            <input type="hidden" name="property_id" value="{{$floor->property->id}}">
                            <input type="hidden" name="tower_id" value="{{$floor->tower->id}}">
                            <input type="hidden" name="floor_id" value="{{$floor->id}}">
                            <h2 class="form-caption">Edit Floor</h2>
                            <button type="button" class="btn-close-modal float-sm-end float-start mt-0 me-sm-0 me-4" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle" aria-hidden="true"></i></button>
                            <div class="row">
                                <div class="col-xl-8 col-lg-8 col-md-8 apartment-select">
                                    <div class="row">
                                        <div class="input-field-group">
                                            <label for="property">Property</label>
                                            <input type="text" name="property" value="{{$floor->property->name}}" required readonly>
                                        </div>
                                        <div class="input-field-group">
                                            <label for="tower">Tower</label>
                                            <input type="text" name="tower" value="{{$floor->tower->name}}" required readonly>
                                        </div>
                                        <div class="input-field-group">
                                            <label for="floor">Floor</label>
                                            <input type="text" name="floor" value="{{$floor->name}}" required readonly>
                                        </div>
                                        <div class="input-field-group">
                                            <label for="apartment">Apartment Name</label>
                                            <input type="text" name="apt_name" id="apt_name" required>
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
<!--edit apartment model end -->
<!-- delete modal start -->
<div class="modal remove-item" id="remove-item" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <form method="POST" action="{{ route('admin.deleteApartment','apartment') }}">
                {{method_field('delete')}}
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="remove-content-wrapper">
                        <p>Are you sure you want to delete?</p>
                        <input type="hidden" name="apartmentid" id="apartmentid" value="">

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
        $('.table-edit').click(function(e) {
            e.preventDefault(); // prevent form from reloading page
            var id = $(this).attr('id');
            $.ajax({
                url: "{{route('admin.getApartment')}}"
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
                    $('#apartmentid').val(response.id);
                    $('#apt_name').val(response.name);
                }
                , complete: function(data) {
                    // Hide image container
                    $("#loader").hide();
                }
            });
        });
    });
    //actions happening when the button is clicked
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
    $('#remove-item').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget);

        if (button.hasClass("deleteitem")) {

            $("#remove-item form").attr('action', button.data('url'));

        } else {
            $("#remove-item form").attr('action', "{{ route('admin.deleteApartment','apartment') }}");
            var apartmentid = button.data('apartmentid')
            var modal = $(this)
            modal.find('.modal-body #apartmentid').val(apartmentid);
        }
    });

</script>
@endpush
