@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Notification')

@section('content')

<style>
    .tenant-table table tr td:nth-last-child(2) {
        background-color: transparent;
    }

    .tenant-table table tr td:last-child {
        background-color: #C89328;
    }

</style>

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
    <div class=" table-responsive tenant-table">

        <table class="table  table-bordered" id="notification-table">
            <thead>
                <tr>
                    <th scope="col"><span>Notification Detail</span></th>
                    <th scope="col"><span>Tenant</span></th>
                    <th scope="col"><span>Property</span></th>
                    <th scope="col"><span>Apartment</span></th>
                    <th scope="col"><span>Category</span></th>
                    <th></th>
                </tr>
            </thead>

        </table>
    </div>
</main>


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
                    data: 'apartment_id'
                }
                , {
                    data: 'category'
                , }
                , {
                    data: 'detail'
                    , orderable: false
                }

            ]
        , });
    });

</script>

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
@endpush
