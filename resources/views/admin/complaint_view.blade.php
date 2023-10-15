@extends('admin.layouts.layout')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

@section('title','Complaints View')

@section('content')

<main class="user-info-wrapper col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 position">

	<h2 class="table-cap pb-2 mb-3 text-capitalize">Complaints View</h2>
	<!-- First row end -->
	<div class="row">
		<div class="col-xxl-12 col-xl-12">
			<div class="table-responsive tenant-table maintenance-table">

				<table class="table  table-bordered">
					<thead>
						<tr>
							<th>User ID</th>
							<th>User  Name</th>
							<th>Contact Number</th>
							<th>Form ID</th>
							<th>Submission Date</th>
							<th>Submission Time</th>
							<th>Complaint Type</th>
							<th>Apartment</th>
							<th>Property</th>
							<th>Status</th>
							<th>Rate</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{$complaint->user_id}}</td>
							<td>{{@$complaint->user->full_name}}</td>
							<td>{{@$complaint->user->mobile}}</td>
							<td>{{$complaint->form_id}}</td>
							<td>{{$complaint->created_at->todatestring()}}</td>                     
							<td>{{$complaint->created_at->totimestring()}}</td>                    
							<td>{{$complaint->type}}</td>                    
							<td>{{@$complaint->user->apt_number}} </td>
							<td>{{@$complaint->user->property}}</td>
							<td>{{$complaint->status}}</td>
							<td></td>
						</tr>       
					</tbody>
				</table>
			</div>

		</div>
	</div>
	<!-- First row end -->
	<!-- second row start -->
	<div class="row">
		<div class="col-xxl-3 col-xl-3">
			<figure class="user-profile-pic">
				@if(!empty($complaint->user->profile))
				<img src="{{@$complaint->user->profile}}" alt="User Info Profile Pic">
				@else
				<img src="{{asset('alfardan/assets/maintenance1.jpg')}}" alt="User Info Profile Pic">
				@endif
			</figure>
		</div>
		<div class="col-xxl-9 col-xl-9">

			<!-- small table start -->
			<div class="table-responsive tenant-table small-chat-table">
				<table class="table  table-bordered">
					<thead>
						<tr>
							<th>Description</th>
							<th>Photo</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><p class="ps-2 text-start">{{$complaint->description}}</p></td>
							<td class="p-0"><a href="#">
							<div>
								@if(!empty($complaint->images[0]['path']))
								<img src="{{@$complaint->images[0]['path']}}" style="height: 60px;" alt="complaint-img">
								@else
								<img src="{{asset('alfardan/assets/complaint.jpg')}}">
								@endif
							</div></a></td>

						</tr>       
					</tbody>
				</table>
			</div>
			<!-- small table end -->

			<section class="msger chat-holder">

				<header class="msger-header">
					<div class="msger-header-title m-auto">
						<h3>Chat</h3>
					</div>
				</header>

				<main class="msger-chat">
					<div class="msg left-msg">
						<div
						class="msg-img"
						style="background-image: url(https://image.flaticon.com/icons/svg/327/327779.svg)"
						></div>

						<div class="msg-bubble-radius">

							<div class="msg-text">
								Hello!!! &#128522;
							</div>
						</div>
					</div>
					<div class="msg left-msg">
						<div
						class="msg-img"
						style="background-image: url(https://image.flaticon.com/icons/svg/327/327779.svg)"
						></div>

						<div class="msg-bubble">
                       <!--    <div class="msg-info">
                            <div class="msg-info-name">BOT</div>
                            <div class="msg-info-time">12:45</div>
                        </div> -->

                        <div class="msg-text">
                        	Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do Lorem ipsum dolor sit  &#128522;
                        </div>
                    </div>
                </div>

                <div class="msg right-msg">
                        <!-- <div
                         class="msg-img"
                         style="background-image: url(https://image.flaticon.com/icons/svg/145/145867.svg)"
                         ></div> -->

                         <div class="msg-bubble chat-bg">
                         <!--  <div class="msg-info">
                            <div class="msg-info-name">Sajad</div>
                            <div class="msg-info-time">12:46</div>
                        </div> -->

                        <div class="msg-text">
                        	Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do Lorem ipsum dolor sit  
                        </div>
                    </div>
                </div>
                <div class="msg right-msg">
                        <!-- <div
                         class="msg-img"
                         style="background-image: url(https://image.flaticon.com/icons/svg/145/145867.svg)"
                         ></div> -->

                         <div class="msg-bubble chat-bg">
                         <!--  <div class="msg-info">
                            <div class="msg-info-name">Sajad</div>
                            <div class="msg-info-time">12:46</div>
                        </div> -->

                        <div class="msg-text">
                        	Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do Lorem ipsum dolor sit  
                        </div>
                    </div>
                </div>
            </main>


        </section>

    </div>
</div>
<!-- second row end -->



</main>


@endsection
