@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Notification')

@section('content')


<main class="col-md-12 ms-lg-auto col-lg-10 px-md-4 pt-5 position">
    @include('notification.notify')
    @if($errors->any())
    @foreach($errors->all() as $error)
    <div class="alert alert-danger">
        {{$error}}
    </div>
    @endforeach
    @endif
    <h2 class="table-cap  mb-2">Notification</h2>
    {{-- <div>
		<div>
			<a class="add-btn my-3 modal-click" href="#" type="button" data-bs-toggle="modal" data-bs-target="#addnotification">ADD NOTIFICATION</a>
		</div>
	</div> --}}
    {{-- <a class="add-btn my-3" href="#" type="button"  data-bs-toggle="modal" data-bs-target="#addcorporatemember">ADD NEW USER</a> --}}
    <div class=" table-responsive tenant-table">

        <div class="row">
            <div class="col-12">
                <div class="body-wrapper">
                    <form method="post" enctype="multipart/form-data" action="{{route('admin.notificationadd')}}" id="add_form">
                        {{csrf_field()}}
                        <input type="hidden" name="type" value="0" id="type">
                        <div class="row">
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                <div class="add-family-form-wrapper ps-2 pe-3 d-flex">
                                    <div class="col-6 px-2">
                                        <label>Notification Title</label>
                                        <input type="text" name="title" required="required">
                                    </div>
                                    <div class="col-6 px-2">
                                        <label>Notification Date</label>
                                        <input type="date" name="date" required="required">
                                    </div>
                                </div>
                                <div class="add-family-form-wrapper ps-2 pe-3 d-flex">
                                    <div class="col-3 px-2">
                                        <label class="text-white" for="property">Property</label>
                                        <select name="property[]" class="custom-select2" multiple id="multiselect-drop3" style="background-color: #2B2B2B;width: 247px;">
                                            @foreach($properties as $property)
                                            <option value="{{$property->id}}">{{$property->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-3 px-2">
                                        <label class="text-white" for="tower">Tower</label>
                                        <select name="tower[]" class="custom-select2" multiple id="multiselect-drop7" style="background-color: #2B2B2B;width: 247px;">
                                            @foreach($towers as $tower)
                                            <option value="{{$tower->id}}">{{$tower->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-3 px-2">
                                        <label class="text-white" for="floors">Floors</label>
                                        <select name="floors[]" class="custom-select2" multiple id="multiselect-drop8" style="background-color: #2B2B2B;width: 247px;">
                                            @foreach($floors as $floor)
                                            <option value="{{$floor->id}}">{{$floor->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-3 px-2">
                                        <label class="text-white" for="location">Apartment</label>
                                        <select name="apartment_id[]" class="custom-select2  " multiple id="multiselect-drop1" style="background-color: #2B2B2B;width: 247px;">
                                            @foreach($apartments as $apartment)
                                            <option value="{{$apartment->id}}">{{$apartment->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="add-family-form-wrapper ps-2 pe-3 p-3">
                                    <label>Description</label>
                                    <textarea class="description-text" name="description" required="required"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-btn-holder mb-3 text-end me-xxl-0 px-3">
                            <input class="form-btn publish submit_btn" name="publish" value="Publish" href="#" type="button" data-bs-toggle="modal" data-bs-target="#confirmModal">
                            <input name="draft" value="Draft" class="draft submit_btn" href="#" type="button" data-bs-toggle="modal" data-bs-target="#confirmModal">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

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
                            <button class="col-4 save_btn" type="Submit" style="color: #fff;
				font-size: 18px;
				max-width: 133px;
				height: 37px;
				padding: 5px 32px;
				border: 1px solid #C89328;
				text-transform: uppercase;
				background: #C89328;">
                                Yes</button>
                            <a href="#" type="button" class="btn-close-modal col-4" style="background-color: transparent;" data-bs-dismiss="modal" aria-label="Close">No</a>
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
<script type="text/javascript">
    jQuery(function() {
        $('#notification-table').DataTable({
            "paging": true
            , 'iDisplayLength': 25
            , "lengthChange": true
            , "searching": true
            , "ordering": true
            , "info": true
            , "autoWidth": false
            , "responsive": true
            , "processing": false
            , "serverSide": true
            , "createdRow": function(row, data, dataIndex) {
                $(row).addClass(data.rowclass);
            }
            , ajax: {
                beforeSend: function() {
                    // Show image container
                    $("#loader").show();
                }
                , url: "{{route('admin.notifications.listing')}}"
                , complete: function(data) {
                    // Hide image container
                    $("#loader").hide();
                }
            }
            , columns: [{
                    data: 'message'
                }
                , {
                    data: 'user_id'
                }
                , {
                    data: 'property_id'
                }
                , {
                    data: 'apartment'
                }
                , {
                    data: 'cat'
                },

            ]
        , });
    });

</script>
@include('admin.users.modals.allmodalsscript');

<style>
    table.dataTable tbody tr.bg-danger {
        background-color: #dc3545 !important;
    }


    table.dataTable tbody tr.bg-warning {
        background-color: #a68216 !important;
    }

    table.dataTable tbody tr.bg-info {
        background-color: #0dcaf0 !important;
    }

</style>
<script>
    $(".submit_btn").on('click', function() {
        var value = $(this).val();
        $(".save_btn").val(value);
    });
    $('.save_btn').on('click', function(e) {
        e.preventDefault();
        var value = $(this).val();
        $('#type').val(value);
        $("#add_form").submit();
    });

</script>
@endpush
