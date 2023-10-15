@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Maintenance Chat')

@section('content')
<main class="event-wrapper chat col-md-9 ms-sm-auto col-lg-10 px-md-4 position">
	<div class="row">
		<div class="col col-sm-12 col-xl-4 service-chat">

			<div class="search-holder">
				<h2 class="table-cap chat-heading">Maintenance Chat</h2>
				<form action="" method="POST">
				<div class="input-group md-form form-sm form-2 pl-0 mt-2">
					<input class="form-control my-0 py-1 amber-border" id="search" type="text" placeholder="Search" aria-label="Search">
					<div class="input-group-append">
						<span class="input-group-text amber lighten-3" id="basic-text1"><i class="fas fa-search text-grey" aria-hidden="true"></i></span>
					</div>
				</div>
				</form>
			</div>
			<div class="customscroll user_data">
				@if(!empty($chats))
				@foreach($chats as $value)
				 
@include('admin.layouts.chatlist')
				<!--<div class="customer-side customer-top user-chat cursor-pointer" id="{{$value->id}}">
					<div class="customer-info">
						<div class="chat-img ">
							<!-- <i class="fa fa-user-circle"></i> - - >

							@if(!empty($value->sender->profile))
							<img src="{{@$value->user2->profile}}">
							@else
							<img src="{{asset('alfardan/assets/profile-pic.jpg')}}" alt="...">
							@endif
						</div>
						<div class="customer-detail">
							<h4>{{@$value->user2->full_name}}</h4>
							<p>{{@$value->last_msg->text}}</p>
						</div>

					</div>
					<div class="service-info">
						<h4>{{@$value->user2->type}}</h4>
						<p>{{@$value->last_msg->created_at}}</p>
					</div>
				</div> -->
				 
				@endforeach
				@endif
			</div>
	<!-- <div class="customer-side">
		<div class="customer-info">
			<div class="icon-holder">
				<i class="fa fa-user-circle"></i>
			</div>
			<div class="customer-detail">
				<h4>FirstName LastName</h4>
				<p>Last message displayed here...</p>
			</div>

		</div>
		<div class="service-info">
			<h4>Corporate Individual</h4>
			<p>12:05 PM</p>
		</div>
	</div>
	<div class="customer-side">
		<div class="customer-info">
			<div class="icon-holder">
				<i class="fa fa-user-circle"></i>
			</div>
			<div class="customer-detail">
				<h4>FirstName LastName</h4>
				<p>Last message displayed here...</p>
			</div>

		</div>
		<div class="service-info">
			<h4>Corporate Individual</h4>
			<p>12:05 PM</p>
		</div>
	</div> -->
		</div>
	
<div class="col col-sm-12 col-xl-8 chat-profile-holder" id="chat-profile-holder">
	@include('admin.chat_view')

	<!-- <div class="right-heading">
		<div class="chat-left">
			<i class="fa fa-user-circle"></i>
			<h4>FirstName LastName</h4>
			<p>Location</p>
		</div>
		<div class="chat-right">
			<h4>Corporate Individual</h4>
		</div>
	</div>
	<div class="chat-body">
		<div class="admin-chat-holder">
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
		</div>
		<div class="customer-chat-holder">
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
		</div>
		<div class="admin-chat-holder">
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
		</div>
	</div> -->
	<!-- <div class="chat-footer">
		<div class="back-fotter-color">
			<div class="input-group md-form form-sm form-2 pl-0 footer-input">
				<input class="form-control my-0 py-1 amber-border footer-input-holder" type="text">
				<div class="input-group-append mt-2">
					<div>
						<input type="file" name="file" id="selectfile" class="d-none" >
						<label class="chat-attach"for="selectfile"><i class="fa fa-paperclip" ></i></label> 
					</div>
				</div>
			</div>
			<div class="send-msg">
				<i class="fa fa-paper-plane" aria-hidden="true"></i>
				<a href=#>Send</a>
			</div>
		</div>
	</div> -->
</div>
</div>
</main>
@endsection
@push('script')
<script>
	
	$(function() {
        
        // $('.user-chat').click(function(e) {
        $(document).on('click', '.user-chat', function (e) {
    		e.preventDefault();
    	  	var id=$(this).attr('id');
    	  	
    	  	$.ajax({
                url  : "{{route('admin.chatHistory')}}",
                type : 'Post',
                data :{'id':id,_token:'{{ csrf_token() }}'},
                dataType: 'json',   
                success : function(response) {
                	$("#chat-profile-holder").html(response.html);
	    //             $(".customscroll").mCustomScrollbar({
					//     autoHideScrollbar:true
					// });
					var input=document.getElementById("message");
				    input.addEventListener("keyup", function(event) {
					    event.preventDefault();
					    if (event.keyCode === 13) {
					        document.getElementById("btnsubmit").click();
					    }
					});
                }

              
            });

        })
    });

</script> 

<script>

	$('#search').on('keyup', function(){
	    search();
	});
	// search();
	function search(){
	     var keyword = $('#search').val();
	     $.post('{{ route("admin.maintenancechatSearch") }}',
	      {
	         _token: $('meta[name="csrf-token"]').attr('content'),
	         keyword:keyword
	       },
	       function(data){
	        table_post_row(data);
	          // console.log(data);
	       });

	}
	//table row with ajax
	function table_post_row(res){
		// if(res){
		let htmlView = '';
			if(res.users.length <= 0){
			    htmlView+= `
			     <p style="color: #fff;text-align: center;">Record Not Found.</p>
			      `;
			}
			for(let i = 0; i < res.users.length; i++){
			    htmlView += '<div class="customer-side customer-top user-chat cursor-pointer" id='+res.users[i].chat_id +'><div class="customer-info"><div class="chat-img"><img src="{{asset('uploads')}}/'+res.users[i].profile+'"></div><div class="customer-detail"><h4>'+res.users[i].full_name +'</h4><p>'+res.users[i].text +'</p></div></div><div class="service-info"><h4>'+res.users[i].type +'</h4></div></div>';   
			}
			    $('.user_data').html(htmlView);
		// }
	}
</script>
@endpush 