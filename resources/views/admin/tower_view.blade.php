    @extends('admin.layouts.layout')

    @include('admin.layouts.header')

    @include('admin.layouts.sidebar')

    @section('title','Tower View')

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
        <h2 class="table-cap pb-2 mb-3 text-capitalize">{{$tower->name}}</h2>
        <!-- First row -->
        <div class="d-flex justify-content-between">
            <a class="add-btn my-3 mx-2 col-3" href="#" type="button" data-bs-toggle="modal" data-bs-target="#add-floor">Add Floor</a>
            <form action="{{route('admin.importFloors')}}" method="POST" enctype="multipart/form-data" class="px-2">
                {{csrf_field()}}
                <input type="hidden" name="tower_id" value="{{$tower->id}}">
                <input type="file" name="file" id="selectFloors" class="d-none">
                <label class="add-btn my-3" for="selectFloors">Import Floors</label>
                <div class="btn-holder input-group">
                    <input type="submit" name="status" value="Publish" class="form-btn mx-xxl-2 publish" />
                    <input type="submit" name="status" value="Draft" class="draft" />
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-xxl-8 col-xl-8 mt-2">
                <div class="table-responsive tenant-table">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Floor</th>
                                <th>Tower Name</th>
                                <th>Property Name</th>
                                <th>Location</th>
                                <th>Import ID</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $floor_list=$tower->floors()->paginate(10);    
                            ?>
                            @foreach ($floor_list as $floor_details)
                            <tr>
                                <td><a href="{{(route('admin.floor_view',$floor_details->id))}}">{{$floor_details->name}}</a></td>
                                <td>{{$tower->name}}</td>
                                <td>{{$tower->property->name}}</td>
                                <td>{{$tower->property->location}}</td>
                                <td>{{$floor_details->id}}</td>
                                <td>
                                    {{$floor_details->status==1?'Publish':'Draft'}}
                                </td>
                                <td class="cursor-pointer fw-bold table-edit" id="{{$floor_details->id}}" data-bs-toggle="modal" data-bs-target="#edit-floor" style="background-color: #C89328;">Edit</td>
                                <td><a type="button" class="table-delete fw-bold" data-bs-toggle="modal" data-bs-target="#remove-item" data-floorid="{{$floor_details->id}}">Remove</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$floor_list->links()}}
                </div>
            </div>
        </div>
    </main>

    <!--Add apartment  model start -->
    <div class="modal fade" id="add-floor" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 bg-transparent">
                <div class="modal-body profile-model">
                    <div class="container-fluid">
                        <div class="scnd-type-modal-form-wrapper more-extra-width" style="max-width: 45%;">
                            <form method="post" action="{{route('admin.addFloor')}}" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <input type="hidden" name="property_id" value="{{$tower->property->id}}">
                                <input type="hidden" name="tower_id" value="{{$tower->id}}">
                                <h2 class="form-caption">Add Floor</h2>
                                <button type="button" class="btn-close-modal float-sm-end float-start mt-0 me-sm-0 me-4" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle" aria-hidden="true"></i></button>
                                <div class="row">
                                    <div class="col-xl-10 col-lg-10 col-md-10 apartment-select">
                                        <div class="row">
                                            <div class="input-field-group">
                                                <label for="property">Property</label>
                                                <input type="text" name="property" class="custom-select2 w-100 mx-0 px-0" value="{{$tower->property->name}}" required readonly>
                                            </div>
                                            <div class="input-field-group">
                                                <label for="tower">Tower</label>
                                                <select name="tower" class="custom-select2 w-100 mx-0 px-0">
                                                    <option value="">Select Tower</option>
                                                    @foreach ($towers as $tower)
                                                    <option value="{{ $tower->id }}">{{ $tower->name }}</option>
                                                    @endforeach
                                                </select>
                                                {{-- <input type="text" name="tower" value="{{$tower->name}}" required readonly> --}}
                                            </div>
                                            <div class="input-field-group location" id="addfloor">
                                                <label for="floor">Floor Name</label>
                                                <input type="text" name="floor_name[]" class="custom-select2 w-100 mx-0 px-0" required>
                                            </div>
                                            <div class="add-benefits">
                                                <a class="add-btn my-3 float-end pro-btn" onclick="addnewinput('floor_name','addfloor')" href="#" type="button">+</a>
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
    <div class="modal fade" id="edit-floor" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 bg-transparent">
                <div class="modal-body profile-model">
                    <div class="container-fluid">
                        <div class="scnd-type-modal-form-wrapper more-extra-width" style="max-width: 45%;">
                            <form method="post" action="{{route('admin.addFloor')}}" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <input type="hidden" name="floorid" id="floorid">
                                <input type="hidden" name="property_id" value="{{$tower->property->id}}">
                                <input type="hidden" name="tower_id" value="{{$tower->id}}">
                                <h2 class="form-caption">Edit Floor</h2>
                                <button type="button" class="btn-close-modal float-sm-end float-start mt-0 me-sm-0 me-4" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle" aria-hidden="true"></i></button>
                                <div class="row">
                                    <div class="col-xl-10 col-lg-10 col-md-10 apartment-select">
                                        <div class="row">
                                            <div class="input-field-group">
                                                <label for="property">Property</label>
                                                <input type="text" name="property" class="custom-select2 w-100 mx-0 px-0" value="{{$tower->property->name}}" required readonly>
                                            </div>
                                            <div class="input-field-group">
                                                <label for="tower">Tower</label>
                                                <select name="tower" class="custom-select2 w-100 mx-0 px-0">
                                                    <option value="">Select Tower</option>
                                                    @foreach ($towers as $tower)
                                                    <option value="{{ $tower->id }}">{{ $tower->name }}</option>
                                                    @endforeach
                                                </select>
                                                {{-- <input type="text" name="tower" value="{{$tower->name}}" required readonly> --}}
                                            </div>
                                            <div class="input-field-group">
                                                <label for="floor">Floor Name</label>
                                                <input type="text" name="floor_name" id="floor_name" class="custom-select2 w-100 mx-0 px-0" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn-holder">
                                        <input class="form-btn publish" name="publish" type="submit" class="" value="Publish"></>
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
                <form method="POST" action="{{ route('admin.deleteFloor','floor') }}">
                    {{method_field('delete')}}
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="remove-content-wrapper">
                            <p>Are you sure you want to delete?</p>
                            <input type="hidden" name="floorid" id="floorid" value="">

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
                    url: "{{route('admin.getFloor')}}"
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
                        $('#floorid').val(response.id);
                        $('#floor_name').val(response.name);
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
                $("#remove-item form").attr('action', "{{ route('admin.deleteFloor','floor') }}");
                var floorid = button.data('floorid')
                var modal = $(this)
                modal.find('.modal-body #floorid').val(floorid);
            }
        });

    </script>
    @endpush
