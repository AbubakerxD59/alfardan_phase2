<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class=" col-lg-2 d-lg-block sidebar collapse  customscroll">
      <div class="position-sticky">
        <div class="sidebar-wrapper">
          
          <ul class="nav flex-column mb-3">
            <!-- User Area-->
			@if(in_array($adminUser->type,[1,4,3]))  
			<li>
              <h2 class="sidebar-heading">Users</h2>
            </li>
			  @endif
			@if(in_array($adminUser->type,[1,4,3]))  
			  
			  
			  
			  @if($adminUser->type==1)   
			  	<li class="nav-item border-left">
				  <a class="nav-link" href="{{route('admin.users.index')}}">  
					All Users
				  </a>
				</li>			  
			  @endif
			  
			  
            <li class="nav-item border-left">
             <a class="nav-link active" href="{{route('admin.dashboard')}}">
                Tenant
              </a>
            </li>
			  
			  @if($adminUser->type==1)  
				<li class="nav-item border-left">
				  <a class="nav-link" href="{{route('admin.empolyee_list')}}">  
					Employees
				  </a>
				</li>
			   
			  @endif
           
            
            <li class="nav-item border-left">
              <a class="nav-link" href="{{route('admin.family_member')}}">
               Family Members
              </a>
            </li>

            <li class="nav-item border-left">
              <a class="nav-link" href="{{route('admin.corporate_individual')}}">
                Corporate Individuals
              </a>
            </li>
			 @endif
			  
			@if(in_array($adminUser->type,[1,4,3])) 
			  <!--<li class="nav-item border-left">
				  <a class="nav-link" href="{{route('admin.tenant_request')}}">
					Tenant Requests
				  </a>
			 	</li>-->
			  
			   <li class="nav-item border-left">
				  <a class="nav-link" href="{{route('admin.users.all_requests')}}">
					Tenant Requests
				  </a>
			 	</li>
        <li class="nav-item border-left">
          <a class="nav-link" href="{{route('admin.users.expired_contracts')}}">
					Inactive Contracts
				  </a>
			 	</li>
			 @endif
			 <!-- News Feed Area-->
			@if(in_array($adminUser->type,[1,2,6]))  
			<li>
				<h2 class="sidebar-heading">
					<a class="" href="{{route('admin.newsfeed')}}">News Feed</a>
				</h2>
			</li>
             <li class="nav-item border-left">
              <a class="nav-link" aria-current="page" href="{{route('admin.artGallery')}}">
                Shop
              </a>
            </li>
            <li class="nav-item border-left">
              <a class="nav-link" href="{{route('admin.newsLetter')}}">
                Newsletter
              </a>
            </li>
            <li class="nav-item border-left">
              <a class="nav-link" href="{{route('admin.offerUpdates')}}">
                News
              </a>
            </li>
			  @endif
			    <!-- News Feed Area-->
			@if(in_array($adminUser->type,[1,3]))  
            <li>
              <h2 class="sidebar-heading">Lifestyle</h2>
              
            </li>
            <li class="nav-item border-left">
              <a class="nav-link" aria-current="page" href="{{route('admin.events')}}">
                Events
              </a>
            </li>

            <li class="nav-item border-left">
              <a class="nav-link" href="{{route('admin.classes')}}">
                Classes
              </a>
            </li>

            <li class="nav-item border-left">
              <a class="nav-link" href="{{route('admin.facilities')}}">
                Facilities
              </a>
            </li>
			@endif
			  
			  @if(in_array($adminUser->type,[1,2]))  
            <!-- Hospetality -->
            <li>
              <h2 class="sidebar-heading">
                <a class="" href="{{route('admin.artGalleries')}}">Art Gallery</a>
              </h2>
            </li>

            <li>
              <h2 class="sidebar-heading">Hospitality </h2>
            </li>

            <li class="nav-item border-left">
              <a class="nav-link" aria-current="page" href="{{route('admin.get_offers')}}">
                Offers
              </a>
            </li>

            <li class="nav-item border-left">
              <a class="nav-link" aria-current="page" href="{{route('admin.hotels')}}">
                Hotels
              </a>
            </li>

            <li class="nav-item border-left">
              <a class="nav-link" href="{{route('admin.restaurants')}}">
                Restaurants
              </a>
            </li>

            <li class="nav-item border-left">
              <a class="nav-link" href="{{route('admin.wellness')}}">
                Wellness
              </a>
            </li>
			@endif
			  @if(in_array($adminUser->type,[1,4]))  
            <!-- buy and sell -->
            <li>
              <h2 class="sidebar-heading2 mt-4"><a href="{{route('admin.buy_sell')}}"> Buy & Sell</a></h2>
            </li>

            <li class="nav-item border-left">
              <a class="nav-link" aria-current="page" href="{{route('admin.featured')}}">
                Featured 
              </a>
            </li>
			@endif
			  <!--Leasing-->
			  @if(in_array($adminUser->type,[1,2,5,6]))  
            <li>
              <h2 class="sidebar-heading">Leasing</h2>
            </li>

            <li class="nav-item border-left">
              <a class="nav-link" aria-current="page" href="{{route('admin.property')}}">
                Properties 
              </a>
            </li>

           <!--  <li class="nav-item border-left">
              <a class="nav-link" href="">
                Apartments
              </a>
            </li>  -->
            <li class="nav-item border-left">
              <a class="nav-link" href="{{route('admin.becomeTenant')}}">
                Become A Tenant
              </a>
            </li>
			@endif
			   <!--Maintenance-->
			  @if(in_array($adminUser->type,[1,7,2]))  
			  
            <li>
              <h2 class="sidebar-heading2 mt-4"><a href="{{route('admin.maintenance')}}">Maintenance</a></h2>
            </li>
             <li class="nav-item border-left">
              <a class="nav-link" aria-current="page" href="{{route('admin.maintenanceChat')}}">
                Chat
              </a>
            </li>
          <!--   <li>
              <h2 class="sidebar-heading2"><a href="3">Media</a></h2>
            </li> -->
			@endif
			  @if(in_array($adminUser->type,[1,2,3]))  
			  
            <li>
              <h2 class="sidebar-heading"><a href="{{route('admin.concierge')}}">Concierge</a></h2>
            </li>
            <li class="nav-item border-left">
              <a class="nav-link " aria-current="page" href="{{route('admin.conciergeChat')}}">
                Chat 
              </a>
            </li>
            <li class="nav-item border-left">
              <a class="nav-link " aria-current="page" href="{{route('admin.tenantRegistration')}}">
                Tenant Registration 
              </a>
            </li>
            <li class="nav-item border-left">
              <a class="nav-link " aria-current="page" href="{{route('admin.services')}}">
                Services 
              </a>
            </li>

            <li class="nav-item border-left">
              <a class="nav-link" href="{{route('admin.pet_form')}}">
                Pet Form
              </a>
            </li>

            <li class="nav-item border-left">
              <a class="nav-link" href="{{route('admin.maintenance_in_absentia')}}">
                Maintennance in Absentia
              </a>
            </li>

            <li class="nav-item border-left">
              <a class="nav-link" href="{{route('admin.automated_guest_access')}}">
                Automated Guest Access
              </a>
            </li>

            <li class="nav-item border-left">
              <a class="nav-link" href="{{route('admin.access_key_card')}}">
                Access Key Card
              </a>
            </li>

            <li class="nav-item border-left">
              <a class="nav-link" href="{{route('admin.vehicle_form')}}">
                Vehicle Form
              </a>
            </li> 

            <li class="nav-item border-left">
              <a class="nav-link" href="{{route('admin.housekeeping_form')}}">
                Housekeeping Form
              </a>
            </li> 
			@endif
			  
			  @if(in_array($adminUser->type,[1,6,2]))  
            <li>
              <h2 class="sidebar-heading2 mt-4"><a href="{{route('admin.privilege_program')}}">Privilege Program</a></h2>
            </li>
			@endif
			  
			@if(in_array($adminUser->type,[1]))  
            	<li><h2 class="sidebar-heading2"><a href="{{route('admin.alfardan_profile')}}">Alfardan Living</a></h2></li>
            	<li><h2 class="sidebar-heading2"><a href="{{route('admin.notifications')}}">Notification</a></h2></li>
			@endif
			  
			  
			@if(in_array($adminUser->type,[1,2,4]))  
            <li>
              <h2 class="sidebar-heading">Customer Service</h2>
            </li>
            <li class="nav-item border-left">
              <a class="nav-link " href="{{route('admin.customerServiceChat')}}">
                Chat 
              </a>
            </li>
            <li class="nav-item border-left">
              <a class="nav-link " href="{{route('admin.survey')}}">
                Survey 
              </a>
            </li>

            <li class="nav-item border-left">
              <a class="nav-link" href="{{route('admin.complaints')}}">
                Complaints
              </a>
            </li>

            <li class="nav-item border-left">
              <a class="nav-link" href="{{route('admin.circular_update')}}">
                Circular Updates
              </a>
            </li>
			@endif
          </ul>       
        </div>
      </div>
    </nav>