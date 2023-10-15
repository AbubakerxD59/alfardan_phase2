
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
		<div class="chat-img ">
			@if(!empty($chat_histories[0]->user2->profile))
			<img src="{{$chat_histories[0]->user2->profile}}">
			@else
			<img src="{{asset('alfardan/assets/profile-pic.jpg')}}" alt="...">
			@endif
		</div>
		<h4>{{@$chat_histories[0]->user2->full_name}}</h4>
		<p>{{@$chat_histories[0]->user2->property}}</p>
		<p>-{{@$chat_histories[0]->user2->aptnumber}}</p>
	</div>
	
	<div class="chat-right">
		<h4>{{@$chat_histories[0]->user2->type}}</h4>
	</div>
</div>
	<div class="chat-body chat-holder-scroll" id="scroll" style="">
		<div class="customscroll" id="chat_histories" id="chat_histories" onload="chat_historiesload()" data-chat_id="{{@$chat_histories[0]->id}}" data-maxid="{{@$chat_histories[0]->messages()->max('id')}}">
			@include('admin.chat_histories') 
		</div>		
		<div id="uploaded_image" style="float: right;width: 100%;margin-top: 10px;display: none;"></div>
	</div>

	<div class="chat-footer">
		<form id="frm-submit" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
		
			<div class="back-fotter-color">
				<input type="hidden" name="user_id" id="user_id" value="{{@$chat_histories[0]->user2_id}}">
				<input type="hidden" name="chat_id" id="chat_id" value="{{@$chat_histories[0]->id}}">
				<input type="hidden" name="type" id="type" value="{{@$chat_histories[0]->type}}">

				<div class="input-group md-form form-sm form-2 pl-0 footer-input">
					<input class="form-control my-0 py-1 amber-border footer-input-holder" type="text" name="message" id="message">
					<div class="input-group-append mt-2">
						<div>
							<input type="file" name="file" id="selectfile" class="d-none"/>
							<label class="chat-attach"for="selectfile"><i class="fa fa-paperclip" ></i></label> 
						</div>
					</div>
				</div>
				<div class="send-msg">
					<a href="#." id="btnsubmit"><i class="fa fa-paper-plane" aria-hidden="true" for="frm-submit" ></i></a>
					<button type="button" name="submit" id="btnsubmit" class="chat-send-btn btnsub"  >Send</button>
				</div>
			</div>
			<span class="text-danger" id="errormessage"></span> 
		</form>
	</div>


 
	<script>
		setInterval(function(){
			if($("#chat_histories").data("chat_id")!={{$chat_histories[0]->id}}){
				return false;
			}
			var maxid=$("#chat_histories").data("maxid");
				$.ajax({
					url: "{{route('admin.chatrefresh',[$chat_histories[0]->id])}}?maxid="+maxid,
					type: 'POST',
					contentType: false,
					processData: false,
					headers: {
						'X-CSRF-TOKEN':'{{ csrf_token() }}'
					},
					success: function(data) {
						if(data.html!=""){
					 		$("#chat_histories").html(data.html);
					 		$("#chat_histories").data("maxid",data.maxid);
						}
					},
					error: function(response) {

					},
				});
			}, 5000); 
	</script>
<?php } 
  ?>

@push('script')
<style type="text/css">
	.customer-chat-holder {
	    padding: 6px 18px !important;
	}
</style>
<script>		
	$(document).on('change', '#selectfile', function (e) {
		 if(this.files.length>0){
			 $('#btnsubmit' ).trigger( "click" );
		 }
	});
 

	// $('#frm-submit').submit(function(e) {
	$(document).on('click', '#btnsubmit', function (e) {
		e.preventDefault();
		
       var fd = new FormData();

        var files = $('#selectfile')[0].files;
  		var message = $('#message').val();
  		var user_id = $('#user_id').val();
  		var chat_id = $('#chat_id').val();
  		var type = $('#type').val();
            fd.append('file',files[0]);
            fd.append('message',message);
            fd.append('user_id',user_id);
            fd.append('chat_id',chat_id);
            fd.append('type',type);
        // alert(fd);
        // Check file selected or not
  		if(message!=''){
  		
  		var data='<div class="chat-row"><div class="customer-chat-holder"><p>'+ message +'</p></div></div>';
  		}

  		// $('.chat-holder-scroll .customscroll .mCSB_container').append(data);
  		$('.chat-holder-scroll .customscroll').append(data);

  		$("#scroll").animate({ scrollTop: $('.chat-holder-scroll .customscroll ').height() }, "fast");
   		$.ajax({
	        url: "{{route('admin.sendMessage')}}",
	        type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
	        success: function(data) {
	        	console.log(data.uploaded_image);
	        $('#uploaded_image').html(data.uploaded_image);
	        },
	        error: function(response) {
	        document.getElementById("errormessage").style.display = 'block';	
	        $('#errormessage').text(response.responseJSON.errors.message); 
	        setTimeout(function() {
                        document.getElementById("errormessage").style.display = 'none';
                    }, 3000); 
	      	},
	    });
	   
	    message = $('#message').val('');
	   //  user_id = $('#user_id').val('');
  		// chat_id = $('#chat_id').val('');
  		// type = $('#type').val('');
  		files = $('#selectfile').val(null);
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
