
@include('notification.notify')
@if($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">
      {{$error}}
    </div>
  	@endforeach
 @endif

		
<?php 
if(!empty($chat_histories)){?>

<div class="right-heading">

	<div class="chat-left">
		<!-- <i class="fa fa-user-circle"></i> -->
		<div class="chat-img ">
				<!-- <i class="fa fa-user-circle"></i> -->
				
			@if(!empty($chat_histories[0]->user2->profile))
			<img src="{{$chat_histories[0]->user2->profile}}">
			@else
			<img src="{{asset('alfardan/assets/profile-pic.jpg')}}" alt="...">
			@endif
		</div>
		
		<h4>{{@$chat_histories[0]->user2->full_name}}</h4>
		<p>{{@$chat_histories[0]->user2->property}}</p>
	</div>
	<div class="chat-right">
		<h4>{{@$chat_histories[0]->user2->type}}</h4>
	</div>
</div>
	<div class="chat-body chat-holder-scroll" >
	<div class="customscroll" >
		@foreach($chat_histories as $chat)
		@foreach($chat->messages as $value)
		@if($value->sender_id!=1)
		<div class="chat-row">
			<div class="customer-chat-holder admin">
				<p>{{$value->text}}</p>
			</div>
		</div>
		@endif
		@if($value->sender_id ==1)
		<div class="chat-row">
			<div class="customer-chat-holder ">
				<p>{{$value->text}}</p>
			</div>
		</div>
		@endif
		@endforeach
		@endforeach

		<span id="uploaded_image"></span>
	</div>
</div>
<div class="chat-footer">
	<form id="frm-submit" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
		{{csrf_field()}}
		<div class="back-fotter-color">
			<input type="hidden" name="user_id" id="user_id" value="{{@$chat_histories[0]->user2_id}}">
			<input type="hidden" name="chat_id" id="chat_id" value="{{@$chat_histories[0]->id}}">
			<input type="hidden" name="type" value="{{@$chat_histories[0]->type}}">

			<div class="input-group md-form form-sm form-2 pl-0 footer-input">
				<input class="form-control my-0 py-1 amber-border footer-input-holder" type="text" name="message" id="message">
				<div class="input-group-append mt-2">
					<div>
						<input type="file" name="file" id="selectfile" class="d-none" >
						<label class="chat-attach"for="selectfile"><i class="fa fa-paperclip" ></i></label> 
					</div>
				</div>
			</div>
			<div class="send-msg">
				<i class="fa fa-paper-plane" aria-hidden="true" for="frm-submit" ></i>
				<button type="button" name="submit" id="btnsubmit" class="chat-send-btn">Send</button>
			</div>
		</div>
		<span class="text-danger" id="errormessage"></span> 
	</form>
</div>
<?php } ?>
@push('script')

<script>
	
	// $('#frm-submit').submit(function(e) {
	$(document).on('click', '#btnsubmit', function (e) {
		e.preventDefault();
       //alert(url);
  		message = $('#message').val();
  		if(message!=''){

  		var data='<div class="chat-row"><div class="customer-chat-holder admin"><p>'+ message +'</p></div></div>';
  		}

  		$('.chat-holder-scroll .customscroll .mCSB_container').append(data);
   		$.ajax({
	        type: "POST",
	        url: "{{route('admin.sendMessage')}}",
	        data: $("#frm-submit").serialize(),
	        enctype: 'multipart/form-data',
	        success: function(data) {
	        // alert(msg);
	        $('#uploaded_image').html(data.uploaded_image);
	        },
	       //  error: function(response) {
	       //  $('#errormessage').text(response.responseJSON.errors.message).delay(5000).fadeOut(); 
	        
	      	// },
	    });
	    message = $('#message').val('');
	});
	// $('#frm-submit').on('submit', function(e) {
	//     e.preventDefault(); 
	//     alert("here");
	//     $.ajax({
	//         type: "POST",
	//         url: "{{route('admin.sendMessage')}}",
	//         data: $(this).serialize(),
	//         success: function(msg) {
	//         alert(msg);
	//         }
	//     });
	// });
</script>
@endpush