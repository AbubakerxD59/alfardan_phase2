@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Expired Contracts')

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
	<h2 class="table-cap  mb-2">{{@$title}}</h2> 
	@if(in_array('FAMILY MEMBER',$usertypes))
		<a class="add-btn my-3" href="#" type="button"  data-bs-toggle="modal" data-bs-target="#addfamilymember">ADD NEW USER</a>
	@endif
	
	@if(in_array('corporate',$usertypes))
		<a class="add-btn my-3" href="#" type="button"  data-bs-toggle="modal" data-bs-target="#addcorporatemember">ADD NEW USER</a>
	@endif
	<div class=" table-responsive tenant-table">
		
		<table class="table  table-bordered" id="users-table">
			<thead>
				<tr>
					<th>User Name</th>
					<th scope="col"><span>Email</span></th>
					<th scope="col"><span>Start Date</span></th>
					<th scope="col"><span>Date of Birth</span></th>
					<th scope="col"><span>End Date</span></th>
					<th scope="col"><span>Phone Number</span></th>
					<th scope="col"><span>Leasing Type</span></th>
					<th scope="col"><span>Registered AS</span></th>
					<th scope="col"><Span>Tenant Type</Span></th>
					<th scope="col"><span>Property</span></th>
					<th scope="col"><span>Apartment</span></th>
					@if(in_array('all',$usertypes))
						<th>Status</th>
					@endif
				</tr>
			</thead>
			
		</table>
	</div>
</main>



@include('admin.users.modals.allmodals');
@endsection
@push('script')
<script type="text/javascript">
    
  jQuery(function() {
	  $('#users-table').DataTable({
              "paging": true,
		  	  'iDisplayLength': 25,
              "lengthChange": true,
              "searching": true,
              "ordering": true,
              "info": true,
              "autoWidth": false,
              "responsive": true,
              "processing": false,
              "serverSide": true,
			   "createdRow": function( row, data, dataIndex){
				   $(row).addClass(data.rowclass); 
				},
               ajax: { 
				    beforeSend: function() {
                        // Show image container
                        $("#loader").show();
                    },
				   url: "{{route('admin.users_expired.listing')}}",
				   data: function ( d ) {
				   		d.usertypes={!!json_encode($usertypes)!!};
				   },
				   complete:function(data){
						// Hide image container
						$("#loader").hide();
				   }
			   	},
                 columns: [
                    { data:'full_name',
					 "render": function ( data, type, row, meta) { 
						 return '<a href="{{route('admin.users.index')}}/'+row.id+'">'+data+'</a>';
					 }}, 
                    { data: 'email'},
                    { data: 'start_date' },
                    { data: 'dob'},
                    { data: 'end_date'},
                    { data: 'mobile' },
                    { data: 'type' },
                    { data: 'registered_as'},
                    { data: 'tenant_type'},
                    { data: 'userpropertyrelation',
					 orderable: false, 
					 "render": function (data) {return data?data.property?data.property.name:'-':'-'; }
					},
                    { data: 'userpropertyrelation',
					 orderable: false, 
					 "render": function (data) {return data?data.apartment?data.apartment.name:'-':'-'; }
					},
					@if(in_array('all',$usertypes))
						{ data: 'status',
						 "render": function (data) {return data?'<span class="btn-bg1 p-1">Approved</span>':'<span class="p-1">Requested</span>';}
						},
					@endif
	  				@if(in_array('FAMILY MEMBER',$usertypes))
					{ data: 'id',
						orderable: false, 
						 "render": function ( data, type, row, meta) { return row.linkfamily?row.linkfamily.user?row.linkfamily.user.full_name:'':'';}
						},
					@endif
					{ data: 'id',
					 orderable: false, 
					 "render": function (data) {return '<span class="btn-bg1 table-edit" id="'+data+'"  data-bs-toggle="modal" 																		data-bs-target="#editUser" style="cursor: pointer;">EDIT</span>'; }
					}
                 ],
            });
  });
  
</script>
@include('admin.users.modals.allmodalsscript');

<style>
	table.dataTable tbody tr.bg-danger {
		background-color: #dc3545!important;
	}
	
	
	table.dataTable tbody tr.bg-warning {
    	background-color: #a68216!important;
	}
	
	table.dataTable tbody tr.bg-info {
		background-color: #0dcaf0!important;
	}
</style>
@endpush
 