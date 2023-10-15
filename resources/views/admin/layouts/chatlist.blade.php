
				<div class="customer-side customer-top user-chat cursor-pointer" id="{{$value->id}}">
					<div class="customer-info">
						<div class="chat-img ">
							<!-- <i class="fa fa-user-circle"></i> -->

							@if(!empty($value->sender->profile))
							<img src="{{@$value->user2->profile}}">
							@else
							<img src="{{asset('alfardan/assets/profile-pic.jpg')}}" alt="...">
							@endif
						</div>
						<div class="customer-detail">
							<h4>{{@$value->user2->full_name}}</h4>
							<p>{!!@$value->last_msg->text!!}</p>
						</div>

					</div>
					<div class="service-info">
						<h4 style="white-space: nowrap;">{{@$value->user2->type}}</h4>
						<p style="white-space: nowrap;">{{@$value->last_msg->created_at}}</p>
					</div>
				</div>