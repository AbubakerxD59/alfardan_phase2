<header class="navbar  sticky-top  shadow">
	<a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="{{route('admin.dashboard')}}">
		<img src="{{asset('alfardan/assets/logo.png')}}"></a>
	
	
	
	<form action="{{route('admin.logout')}}" method="POST">
		@csrf
		
		
		<a href="{{ route('admin.notifications', ['id' => 'bell']) }}" class="m-md-3" title="Notification"><i class="fa fa-bell"></i></a>
		<a href="{{route('admin.settings')}}" class="m-md-3" title="Settings "><i class="fa-bahai fas"></i></a>
		<button type="submit"  class="pe-3 download-btn " style="background: inherit;">
		<!--<img src="{{asset('alfardan/assets/download-svg.png')}}" class="pe-3"> -->
		Logout</button> 
	</form>
	
		<button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
			<i class="fas fa-bars navbar-toggle-icon"></i>
	</button> 
</header>