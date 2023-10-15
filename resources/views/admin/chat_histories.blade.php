		@foreach($chat_histories as $chat)
			@foreach($chat->messages as $value)

				@if(!empty($value->file) && false)
					<div class="chat-row  msg-file-{{$value->id}}">
					<div class="customer-chat-holder {{($value->sender_id==1 || $value->sender_id==auth()->id())?'admin':''}}">

						<div style="float: right;width: 100%;margin-top: 10px;">
							<a href="{{$value->file}}" target="_blank"><img src="{{$value->file}}" class="img-thumbnail" style="width: 100px;float: right;" /></a></div>
						</div>
					</div>	
				@endif 
				
				<div class="chat-row  msg-text-{{$value->id}}">
					<div class="customer-chat-holder {{$value->isuser()?'admin':''}}">
						@if(!empty($value->file))
						
						<div style="float: right;width: 100%;margin-top: 10px;">
							<a href="{{$value->file}}" target="_blank"><img src="{{$value->file}}" class="img-thumbnail" style="width: 100px;float: right;" /></a></div>
						@else
						<p>{!!$value->text!!}</p>
						@endif
					</div>
				</div>
 
			@endforeach
		@endforeach