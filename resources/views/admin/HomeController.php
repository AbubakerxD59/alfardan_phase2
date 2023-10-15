<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TenantExport;
use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Imports\ApartmentsImport;
use App\Models\AccessKeyRequest;
use App\Models\AlfardanProfile;
use App\Models\Apartment;
use App\Models\Art;
use App\Models\ArtGallery;
use App\Models\BecomeTenant;
use App\Models\Booking;
use App\Models\Chat;
use App\Models\ChatView;
use App\Models\ClassEvent;
use App\Models\ClassSlot;
use App\Models\Complaint;
use App\Models\Concierge;
use App\Models\CorporateIndividual;
use App\Models\Employee;
use App\Models\Event;
use App\Models\Facility;
use App\Models\FamilyMember;
use App\Models\Faq;
use App\Models\GuestAccessRequest;
use App\Models\Hotel;
use App\Models\HousekeeperRequest;
use App\Models\Image;
use App\Models\MaintenanceAbsentiaRequest;
use App\Models\MaintenanceRequest;
use App\Models\Message;
use App\Models\NewsFeed;
use App\Models\Notification;
use App\Models\OfferUpdate;
use App\Models\PetApplication;
use App\Models\PrivilegeProgram;
use App\Models\Product;
use App\Models\Property3dview;
use App\Models\Property;
use App\Models\PropertyGallery;
use App\Models\Resort;
use App\Models\Restaurant;
use App\Models\Review;
use App\Models\ServiceRequest;
use App\Models\Survey;
use App\Models\TenantRegistration;
use App\Models\Update;
use App\Models\User;
use App\Models\UserPropertyRelation;
use App\Models\VehicleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Image as InterventionImage;
use Maatwebsite\Excel\Facades\Excel;
use Mail;

class HomeController extends Controller
{
    public function index()
    {
        // dd(\Auth::guard('admin')->user()->hasRole('editor'));
        // $user=User::paginate(10);
        $user = User::where('status', 1)
            ->where('type', 'individual')->orderby('id', 'desc')->get();

        $properties = Property::all();
        $apartments = Apartment::all();

        return view('admin.dashboard')
            ->with('users', $user)
            ->with('properties', $properties)
            ->with('apartments', $apartments);
    }

    public function getUser(Request $request)
    {
        $user = User::with('images')->with('families')->where('id', $request->id)->first();
        return $user;
    }

    public function updateUser(Request $request)
    {
        // echo "<pre>";
        // print_r($request->has('tenant_type')?implode(",", $request->input('tenant_type')):'');
        // exit;
        $validated = $request->validate([
            'full_name' => 'required',
            'tenant_type' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'image' => 'mimes:gif,jpg,jpeg,png|max:2048',

        ]);
        // $tenant_type=$request->has('tenant_type')?implode(",", $request->input('tenant_type')):'';
        // $property=$request->has('property')?implode(",", $request->input('property')):'';
        if ($request->input('property')) {
            $result = Property::where('id', $request->input('property'))->first();
            if ($request->input('apt_number')) {
                $apt = Apartment::where('id', $request->input('apt_number'))->first();
            } else {
                $apt = Apartment::where('property_id', $result->id)->first();
            }

            $detail = array(
                'status' => 0,
            );
            UserPropertyRelation::where('user_id', $request->input('userid'))->update($detail);

            $data = array(

                'user_id' => $request->input('userid'),
                'property_id' => $result->id,
                'apartment_id' => $apt->id,
                'status' => 1,
            );

            UserPropertyRelation::create($data);
        }

        if ($request->input('userid')) {

            $details = array(
                // 'first_name' =>$request->first_name,
                'full_name' => $request->full_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'apt_number' => $apt->id,
                'tenant_type' => $request->tenant_type,
                // 'nom'        =>$request->nom,
                'type' => $request->leasing_type,
                'start_date' => $request->start_date,
                // 'fusername'  =>$request->username,
                // 'name'       =>$request->name,
                // 'registered_as' =>$request->registered_as,
                'property' => $request->property,

            );

            $result = User::where('id', $request->userid)->update($details);

            if ($request->hasFile('image') != '') {
                $file = $request->File('image');
                $image = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image));
                // $img_resize->resize(300,300);
                // $img_resize->save(public_path('uploads/'.$image));
                $details = array(
                    'profile' => $image,
                );
                User::where('id', $request->userid)->update($details);

                // $details=array(
                //     'path'      =>$image,
                //     'user_id'  =>$request->userid
                // );
                // if($request->image_1 !=''){

                // Image::where('user_id',$request->userid)
                //         ->where('id',$request->image_1)->update($details);
                // }else{

                //     Image::create($details);
                // }
            }
            if ($result) {

                return redirect(route('admin.dashboard'))->with('flash_success', 'Record Updated Successfully!');
            }

        }
    }

    public function update_tenant_request(Request $request)
    {
        // dd('asdasdas');
        $validated = $request->validate([
            // 'property'    => 'required',
            'tenant_type' => 'required',
            'email' => 'required|unique=users',
            'mobile' => 'required',
            'contract' => 'mimes:pdf|max:8000',

        ]);

        if ($request->input('userid')) {
            if ($request->hasFile('contract') != '') {
                $file = $request->File('contract');
                $contract = $file->getClientOriginalName();
                $destinationPath = public_path() . '/uploads';
                $file->move($destinationPath, $contract);
                $detail = array(
                    'contract' => $contract,

                );
                User::where('id', $request->userid)->update($detail);
            }
            $dob = \Carbon\Carbon::parse($request->dob)->format('m-d-Y');

            $details = array(
                'full_name' => $request->username,
                'name' => $request->name,
                'email' => $request->email,
                'dob' => $dob,
                'start_date' => $request->start_date,
                'mobile' => $request->mobile,
                // 'type'      =>$request->leasing_type,
                // 'apt_number'=>$request->apartment,
                // 'property'  =>$request->property,
                'registered_as' => $request->registered_as,
                'tenant_type' => $request->tenant_type,
                'end_date' => $request->end_date,
                'original_tenant_name' => $request->tenant_name,
                'company_name' => $request->company_name,
                // 'message'     =>$request->message,

            );

            $result = User::where('id', $request->userid)->update($details);

            if ($result) {

                return redirect(route('admin.tenant_request'))->with('flash_success', 'Record Updated Successfully!');
            }

        }
    }
    public function user_info(Request $request)
    {
        $user = User::find($request->id);
        $concierge = $user->conciergeview();
        $lifestyle = $user->lifestyleview();

        return view('admin.user_info')
            ->with('userinfo', $user)
            ->with('concierges', $concierge)
            ->with('lifestyles', $lifestyle);

    }

    public function delete_user(Request $request)
    {
        Booking::where('user_id', $request->user_id)->delete();
        Review::where('user_id', $request->user_id)->delete();

        $family = FamilyMember::where('refrence_id', $request->user_id)->first();
        // echo "<pre>";
        // print_r($family);
        // exit;
        if ($family) {

            user::where('email', $family['email'])->delete();
        }
        FamilyMember::where('refrence_id', $request->user_id)->delete();

        $deleteuser = User::find($request->user_id)->delete();

        if ($deleteuser) {
            return redirect(route('admin.dashboard'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function empolyee_list()
    {

        $properties = Property::all();

        $apartments = Apartment::all();

        $employee = Employee::orderby('id', 'desc')->get();

        return view('admin.employee')
            ->with('properties', $properties)
            ->with('apartments', $apartments)
            ->with('employees', $employee);

    }

    public function tenant_request()
    {

        $user = User::where('status', 0)->orderby('id', 'desc')->get();

        $family = FamilyMember::where('status', 0)->orderby('id', 'desc')->get();

        $corporate = CorporateIndividual::where('status', 0)->get();

        $properties = Property::all();

        $apartments = Apartment::all();
        return view('admin.tenant_request')
            ->with('users', $user)
            ->with('properties', $properties)
            ->with('apartments', $apartments)
            ->with('families', $family)
            ->with('corporates', $corporate);
    }

    public function non_tenants()
    {
        return view('admin.non_tenants');

    }

    public function family_member()
    {

        $users = User::where('status', 1)->orderby('id', 'desc')->get();

        $properties = Property::all();

        $apartments = Apartment::all();

        // $family=FamilyMember::with('users')->get();
        // $family=FamilyMember::all();

        $family = User::where('status', 1)
            ->where('type', 'family member')->get();

        return view('admin.family_members')
            ->with('users', $users)
            ->with('properties', $properties)
            ->with('apartments', $apartments)
            ->with('families', $family);

    }

    public function corporate_individual()
    {

        $users = User::where('status', 1)->orderby('id', 'desc')->get();

        $properties = Property::all();

        // $corporate=CorporateIndividual::with('users')->get();
        // $corporate=CorporateIndividual::all();

        $corporate = User::where('status', 1)->whereIn('type', ['corporate', 10])->get();

        return view('admin.corporate_individual')
            ->with('users', $users)
            ->with('properties', $properties)
            ->with('corporates', $corporate);

    }

    public function events()
    {

        $events = Event::get();

        $properties = Property::all();

        return view('admin.events')
            ->with('events', $events)
            ->with('properties', $properties);

    }

    public function classes()
    {

        $class = ClassEvent::get();

        $properties = Property::all();

        return view('admin.classes')
            ->with('classes', $class)
            ->with('properties', $properties);

    }

    public function facilities()
    {

        $facility = Facility::get();

        $properties = Property::all();

        return view('admin.facilities')
            ->with('facilities', $facility)
            ->with('properties', $properties);

    }

    public function hotels()
    {

        $hotel = Hotel::all();

        $properties = Property::all();

        return view('admin.hotels')
            ->with('hotels', $hotel)
            ->with('properties', $properties);

    }

    public function restaurants()
    {

        $restaurant = Restaurant::all();

        $properties = Property::all();

        return view('admin.restaurants')
            ->with('restaurants', $restaurant)
            ->with('properties', $properties);

    }

    public function wellness()
    {

        $resort = Resort::all();

        $properties = Property::all();

        return view('admin.wellness')
            ->with('resorts', $resort)
            ->with('properties', $properties);
    }

    public function property()
    {

        $property = Property::all();

        return view('admin.properties')
            ->with('properties', $property);

    }

    public function apartments()
    {

        $property = Property::all();

        $apartment = Apartment::with('property')->get();
        return view('admin.apartments')
            ->with('properties', $property)
            ->with('apartments', $apartment);

    }

    public function maintenance()
    {

        $users = User::where('status', 1)->get();

        $properties = Property::all();

        $apartments = Apartment::all();

        $maintenance = MaintenanceRequest::with('users')->orderby('id', 'desc')->get();

        return view('admin.maintenance')
            ->with('users', $users)
            ->with('properties', $properties)
            ->with('apartments', $apartments)
            ->with('maintenances', $maintenance);
    }

    public function services()
    {

        $service = ServiceRequest::orderby('id', 'desc')->get();

        $users = User::where('status', 1)->get();

        $properties = Property::all();

        $apartments = Apartment::all();
        return view('admin.services')
            ->with('services', $service)
            ->with('users', $users)
            ->with('properties', $properties)
            ->with('apartments', $apartments);

    }

    public function pet_form()
    {

        $pet = PetApplication::orderby('id', 'desc')->get();

        $users = User::where('status', 1)->get();

        $properties = Property::all();

        $apartments = Apartment::all();
        return view('admin.pet_form')
            ->with('pets', $pet)
            ->with('users', $users)
            ->with('properties', $properties)
            ->with('apartments', $apartments);

    }

    public function maintenance_in_absentia()
    {
        $maintenance = MaintenanceAbsentiaRequest::orderby('id', 'desc')->get();

        $users = User::where('status', 1)->get();

        $properties = Property::all();

        $apartments = Apartment::all();
        return view('admin.maintenance_in_absentia')
            ->with('maintenances', $maintenance)
            ->with('users', $users)
            ->with('properties', $properties)
            ->with('apartments', $apartments);

    }

    public function automated_guest_access()
    {
        $guest = GuestAccessRequest::orderby('id', 'desc')->get();

        $users = User::where('status', 1)->get();

        $properties = Property::all();

        $apartments = Apartment::all();
        return view('admin.automated_guest_access')
            ->with('guests', $guest)
            ->with('users', $users)
            ->with('properties', $properties)
            ->with('apartments', $apartments);

    }

    public function access_key_card()
    {
        $access = AccessKeyRequest::orderby('id', 'desc')->get();

        $users = User::where('status', 1)->get();

        $properties = Property::all();

        $apartments = Apartment::all();
        return view('admin.access_key_card')
            ->with('accesskey', $access)
            ->with('users', $users)
            ->with('properties', $properties)
            ->with('apartments', $apartments);

    }

    public function vehicle_form()
    {
        $vehicle = VehicleRequest::orderby('id', 'desc')->get();

        $users = User::where('status', 1)->get();

        $properties = Property::all();

        $apartments = Apartment::all();
        return view('admin.vehicle_form')
            ->with('vehicles', $vehicle)
            ->with('users', $users)
            ->with('properties', $properties)
            ->with('apartments', $apartments);

    }

    public function housekeeping_form()
    {

        $housekeeper = HousekeeperRequest::orderby('id', 'desc')->get();

        $users = User::where('status', 1)->get();

        $properties = Property::all();

        $apartments = Apartment::all();
        return view('admin.housekeeping_form')
            ->with('housekeepers', $housekeeper)
            ->with('users', $users)
            ->with('properties', $properties)
            ->with('apartments', $apartments);

    }

    public function privilege_program()
    {
        $privilege = PrivilegeProgram::get();

        return view('admin.privilege_program')
            ->with('privileges', $privilege);

    }

    public function alfardan_profile()
    {
        $faq = Faq::all();
        $profile = AlfardanProfile::get();

        return view('admin.alfardan_living_profile')
            ->with('faqs', $faq)
            ->with('profiles', $profile);

    }

    public function servay()
    {

        $survey = Survey::orderby('id', 'desc')->get();

        $properties = Property::all();

        $apartments = Apartment::all();

        return view('admin.servay')
            ->with('properties', $properties)
            ->with('apartments', $apartments)
            ->with('surveys', $survey);

    }

    public function complaints()
    {

        $complaint = Complaint::orderby('id', 'desc')->get();

        $users = User::where('status', 1)->get();

        $properties = Property::all();

        $apartments = Apartment::all();

        return view('admin.complaints')

            ->with('users', $users)
            ->with('properties', $properties)
            ->with('apartments', $apartments)
            ->with('complaints', $complaint);

    }

    public function circular_update()
    {
        $update = Update::orderby('id', 'desc')->get();
        $properties = Property::all();

        $apartments = Apartment::all();
        return view('admin.circular_update')
            ->with('properties', $properties)
            ->with('apartments', $apartments)
            ->with('updates', $update);

    }

    public function employee_view($id)
    {

        $employee = Employee::with('images')->where('id', $id)->first();

        return view('admin.employee_view')
            ->with('employee', $employee);

    }
    public function corporate_view(Request $request)
    {
        $user = User::find($request->id);
        $concierge = $user->conciergeview();
        $lifestyle = $user->lifestyleview();
        $hospitality = $user->hospitalityview();

        return view('admin.corporate_individual_view')
            ->with('userinfo', $user)
            ->with('concierges', $concierge)
            ->with('lifestyles', $lifestyle)
            ->with('hospitalities', $hospitality);

    }

    public function event_view($id)
    {

        $event = Event::with('images')->where('id', $id)->first();

        $properties = Property::all();

        return view('admin.event_view')
            ->with('event', $event)
            ->with('properties', $properties);

    }

    public function class_view($id)
    {

        $class = ClassEvent::with('images')->where('id', $id)->first();

        return view('admin.class_view')
            ->with('class', $class);

    }

    public function facility_view($id)
    {

        $facility = Facility::with('images')->where('id', $id)->first();

        return view('admin.facility_view')
            ->with('facility', $facility);

    }

    public function hotel_view($id)
    {

        $hotel = Hotel::with('images')->where('id', $id)->first();

        return view('admin.hotel_view')
            ->with('hotel', $hotel);

    }

    public function restaurant_view($id)
    {

        $restaurant = Restaurant::with('images')->where('id', $id)->first();

        return view('admin.restaurant_view')
            ->with('restaurant', $restaurant);

    }

    public function wellness_view($id)
    {

        $resort = Resort::with('images')->where('id', $id)->first();

        return view('admin.wellness_view')
            ->with('resort', $resort);

    }

    public function property_view($id)
    {

        $property = Property::with('images')->where('id', $id)->first();

        // $apartment = Property::with('apartments')->where('id', $id)->get();

        return view('admin.property_view')
            ->with('property', $property);
        // ->with('apart',$apartment);

    }

    public function apartment_view($id)
    {

        $apartment = Apartment::with('images')->where('id', $id)->first();

        $property = Apartment::with('property')->get();

        return view('admin.apartment_view')
            ->with('apartments', $property)
            ->with('apartment', $apartment);

    }

    public function maintenance_view($id)
    {

        $maintenance = MaintenanceRequest::with('images')->with('users')->where('id', $id)->first();

        // $maintenance_request=MaintenanceRequest::with('users')->first();

        return view('admin.maintenance_view')
            ->with('maintenances', $maintenance);
        // ->with('maintenances',$maintenance_request);
    }

    public function family_member_view(Request $request)
    {
        $user = User::find($request->id);
        $tenant = User::join('family_members', 'family_members.refrence_id', 'users.id')
            ->where('family_members.user_id', $request->id)
            ->select('users.*')
            ->get();
        // echo "<pre>";
        // print_r($tenant->toSql());
        // exit;
        $concierge = $user->conciergeview();
        $lifestyle = $user->lifestyleview();
        $hospitality = $user->hospitalityview();
        return view('admin.family_member_view')
            ->with('userinfo', $user)
            ->with('concierges', $concierge)
            ->with('lifestyles', $lifestyle)
            ->with('hospitalities', $hospitality)
            ->with('tenants', $tenant);

    }

    public function housekeeping_form_view(Request $request)
    {
        $housekeeper = HousekeeperRequest::where('id', $request->id)->first();
        return view('admin.housekeeping_form_view')
            ->with('housekeeper', $housekeeper);

    }

    public function vehicle_form_view(Request $request)
    {
        $vehicle = VehicleRequest::where('id', $request->id)->first();
        return view('admin.vehicle_form_view')
            ->with('vehicle', $vehicle);

    }

    public function service_view(Request $request)
    {
        $service = ServiceRequest::where('id', $request->id)->first();
        return view('admin.service_view')
            ->with('service', $service);

    }

    public function pet_form_view(Request $request)
    {
        $pet = PetApplication::where('id', $request->id)->first();
        return view('admin.pet_form_view')
            ->with('pet', $pet);

    }

    public function maintenance_in_absentia_view(Request $request)
    {
        $maintenance = MaintenanceAbsentiaRequest::where('id', $request->id)->first();
        return view('admin.maintenance_in_absentia_view')
            ->with('maintenance', $maintenance);

    }

    public function automated_guest_view(Request $request)
    {

        $guest = GuestAccessRequest::where('id', $request->id)->first();

        return view('admin.automated_guest_view')
            ->with('guest', $guest);

    }

    public function access_key_card_view(Request $request)
    {
        $access = AccessKeyRequest::where('id', $request->id)->first();
        return view('admin.access_key_card_view')
            ->with('access', $access);

    }

    public function complaint_view($id)
    {

        $complaint = Complaint::with('images')->where('id', $id)->first();

        return view('admin.complaint_view')
            ->with('complaint', $complaint);

    }

    public function circular_update_view($id)
    {
        $update = Update::where('id', $id)->first();
        return view('admin.circular_update_view')
            ->with('update', $update);

    }
    public function accept_tenant_request(Request $request)
    {

        $details = array(

            'status' => '1',
        );

        $accept_tenant = user::find($request->id);
        $errors = [];

        if (empty($accept_tenant->start_date)) {
            $errors[] = "Contract start date is missing";
        }

        if (empty($accept_tenant->end_date)) {
            $errors[] = "Contract end date is missing";
        }

        if (empty($accept_tenant->contract)) {
            $errors[] = "Contract file is missing";
        }

        if (empty($accept_tenant->original_tenant_name)) {
            $errors[] = "Tenant name is missing";
        }

        if (empty($accept_tenant->tenant_type)) {
            $errors[] = "Tenant type is missing";
        }

        if (count($errors)) {
            return back()->with('flash_error', implode("<br/>", $errors));
        }

        $title = 'Alfardan';
        $message = 'Your user registration for "' . $accept_tenant['full_name'] . '" is completed.';
        $type = 10;
        $notification = new Notification();
        $details = array(
            'type' => $type,
            'user_id' => $request->id,
            'status' => 1,
            'title' => $title,
            'message' => $message,
        );

        $notification->create($details);
        unset($details['type']);
        unset($details['user_id']);

        NotificationHelper::pushnotification($title, $message, $request->id, $type);

        if (strtolower($accept_tenant['type']) == 'individual') {
            Mail::send(
                'emailtemplate.accept',
                [
                    'email' => $accept_tenant['email'],
                    'type' => $accept_tenant['type'],

                ],
                function ($message) use ($accept_tenant) {
                    $message->to($accept_tenant->email)->subject('Registration  Approved');
                }
            );
            $accept_tenant->update($details);

            return redirect(route('admin.dashboard'))->with('flash_success', 'Tenant Request Accepted Successfully!');
        } elseif (strtolower($accept_tenant['type']) == 'corporate') {
            Mail::send(
                'emailtemplate.accept',
                [
                    'email' => $accept_tenant['email'],
                    'type' => $accept_tenant['type'],

                ],
                function ($message) use ($accept_tenant) {
                    $message->to($accept_tenant->email)->subject('Registration  Approved');
                }
            );
            $accept_tenant->update($details);

            return redirect(route('admin.corporate_individual'))->with('flash_success', 'Tenant Request Accepted Successfully!');
        } elseif (strtolower($accept_tenant['type']) == 'family member') {
            Mail::send(
                'emailtemplate.accept',
                [
                    'email' => $accept_tenant['email'],
                    'type' => $accept_tenant['type'],

                ],
                function ($message) use ($accept_tenant) {
                    $message->to($accept_tenant->email)->subject('Registration  Approved');
                }
            );
            $accept_tenant->update($details);

            $details = array(
                'user_id' => $accept_tenant['id'],
            );

            FamilyMember::where('email', $accept_tenant['email'])->update($details);
            // Mail::send('emailtemplate.test', ['emailBody'=>'<h1>TESTING</h1>'], function($message)
            // {
            //  $message->to('naeemamin71@gmail.com')->subject('Password reset');
            // });

            return redirect(route('admin.family_member'))->with('flash_success', 'Tenant Request Accepted Successfully!');
        }
    }

    public function reject_tenant_request(Request $request)
    {
        $id = $request->input('userid');

        $reject_tenant = user::find($id);
        $title = 'Alfardan';
        $message = 'Your user registration for "' . (@$reject_tenant->full_name) . '" is rejected.';
        $type = 11;
        $notification = new Notification();
        $details = array(
            'type' => $type,
            'user_id' => $request->userid,
            'status' => 'Registration Rejected',
            'title' => $title,
            'message' => $message,
        );

        $notification->create($details);
        NotificationHelper::pushnotification($title, $message, $request->userid, $type);
        //FamilyMember::where('refrence_id',$id)->delete();
        FamilyMember::where('email', $reject_tenant['email'])->delete();
        // $details=array(

        //     'reject_reason' =>$request->rejection_reason
        // );
        Mail::send(
            'emailtemplate.reject',
            [
                'email' => $reject_tenant['email'],
                'type' => $reject_tenant['type'],
                'reason' => $request->rejection_reason,

            ],
            function ($message) use ($reject_tenant) {
                $message->to($reject_tenant->email)->subject('Rejected Registration');
            }
        );
        $reject_tenant->delete();

        // if($reject_tenant){

        return redirect(route('admin.tenant_request'))->with('flash_success', 'Tenant Request Rejected Successfully!');
        // }
    }

    public function accept_family_request(Request $request)
    {
        $result = FamilyMember::find($request->id);
        $user = User::find($result['refrence_id']);
        // echo "<pre>";
        // print_r($result['refrence_id']);
        // print_r($user['first_name']);

        // exit;
        Mail::send(
            'emailtemplate.familymember',
            [
                'name' => $user['first_name'] . ' ' . $user['last_name'],
                'email' => $result['email'],

            ],
            function ($message) use ($result) {
                $message->to($result->email)->subject('Invitation to Register on Alfardan Living');
            }
        );
        $details = array(

            'status' => '1',

        );
        FamilyMember::find($request->id)->update($details);

        return redirect(route('admin.tenant_request'))->with('flash_success', 'Request Accepted Successfully!');
    }

    public function reject_family_request(Request $request)
    {

        $id = $request->input('familyid');
        $result = FamilyMember::find($id);

        // $details=array(

        //     'reject_reason' =>$request->rejection_reason
        // );
        Mail::send(
            'emailtemplate.reject',
            [
                'email' => $result['email'],
                'mobile' => $result['phone_number'],
                'reason' => $request->rejection_reason,

            ],
            function ($message) use ($result) {
                $message->to($result->email)->subject('Rejected Family Member Request');
            }
        );
        $result->delete();

        // if($reject_tenant){

        return redirect(route('admin.tenant_request'))->with('flash_success', 'Request Rejected Successfully!');
        // }
    }

    public function accept_corporate_request(Request $request)
    {

        $details = array(

            'status' => '1',
        );
        CorporateIndividual::find($request->id)->update($details);

        return redirect(route('admin.tenant_request'))->with('flash_success', 'Request Accepted Successfully!');
    }

    public function reject_corporate_request(Request $request)
    {

        $id = $request->input('corporateid');

        $details = array(

            'reject_reason' => $request->rejection_reason,
        );

        $reject_tenant = CorporateIndividual::where('id', $id)->update($details);

        if ($reject_tenant) {

            return redirect(route('admin.tenant_request'))->with('flash_success', 'Request Rejected Successfully!');
        }
    }

    public function forgot_password()
    {
        return view('admin.forgot_password');
    }

    public function newsfeed()
    {
        $newsfeed = NewsFeed::get();

        return view('admin.newsfeed')
            ->with('newsfeed', $newsfeed);
    }

    public function buy_sell()
    {
        $pruduct = Product::orderby('id', 'desc')->paginate(10);
        return view('admin.buy_sell')
            ->with('products', $pruduct);
    }

    public function addEmployee(Request $request)
    {
        $validated = $request->validate([
            'emp_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            // 'password'  => 'required',
            'job_role' => 'required',
            'access_type' => 'required',
            'dob' => 'required',
            'phone' => 'required',
            'office_number' => 'required',

        ]);

        if ($request->input('employeeid')) {

            $details = array(

                'emp_id' => $request->emp_id,
                'name' => $request->name,
                'email' => $request->email,
                'job_role' => $request->job_role,
                'type' => $request->access_type,
                'dob' => $request->dob,
                'phone' => $request->phone,
                'office_number' => $request->office_number,
                'property_id' => json_encode($request->property),
                'status' => $request->status,
                //'apartment_id'    =>$request->apartment
            );
            if (!empty($request->password)) {
                $details['password'] = bcrypt($request->password);
            }
            $result = Employee::where('id', $request->employeeid)->update($details);

            if ($request->hasFile('image') != '') {
                $file = $request->File('image');
                $image = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image));

                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image);

                $details = array(
                    'profile' => $image,
                );

                Employee::where('id', $request->employeeid)->update($details);
            }

            return redirect(route('admin.empolyee_list'))->with('flash_success', 'Employee Updated Successfully!');

        } else {
            $employee = new Employee();

            $details = array(

                'emp_id' => $request->emp_id,
                'name' => $request->name,
                'email' => $request->email,
                'job_role' => $request->job_role,
                'type' => $request->access_type,
                'dob' => $request->dob,
                'phone' => $request->phone,
                'office_number' => $request->office_number,
                //'apartment_id'  =>$request->apartment,
                'property_id' => json_encode($request->property),
                'status' => $request->status,
            );
            if (!empty($request->password)) {
                $details['password'] = bcrypt($request->password);
            }
            $result = $employee->create($details);

            if ($request->hasFile('image')) {

                $file = $request->File('image');
                $image = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image);

                $details = array(
                    'profile' => $image,

                );
                Employee::where('id', $request->id)->update($details);

            }

            return redirect(route('admin.empolyee_list'))->with('flash_success', 'Employee Added Successfully!');

        }
    }

    public function deleteEmployee(Request $request)
    {
        $result = Employee::find($request->employeeid)->delete();

        if ($result) {
            return redirect(route('admin.empolyee_list'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }
    public function addFamilyMember(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required',
            'username' => 'required',
            'image' => 'mimes:jpg,jpeg,png|max:2048',

        ]);
        if ($request->input('familymemberid')) {

            $details = array(

                // 'fusername'     =>$request->username,
                'email' => $request->email,
                'mobile' => $request->phone,
                // 'property'      =>$request->property,
                // 'apartment'     =>$request->apartment,
                // 'user_id'       =>$request->userid
            );
            User::where('id', $request->familymemberid)->update($details);

            $details = array(

                'name' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone,
                'refrence_id' => $request->userid,
            );

            $result = FamilyMember::where('user_id', $request->familymemberid)->update($details);

            if ($request->hasFile('image') != '') {
                $file = $request->File('image');
                $image = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image);
                $details = array(
                    'profile' => $image,
                );
                User::where('id', $request->familymemberid)->update($details);

            }

            return redirect(route('admin.family_member'))->with('flash_success', 'Family Member Updated Successfully!');

        } else {
            $family = new user();

            $result = user::find($request->userid);
            // print_r($result);
            // exit;
            $details = array(
                'full_name' => $result['full_name'],
                // 'last_name'     =>$result['last_name'],
                'property' => $result['property'],
                'apt_number' => $result['apt_number'],
                'tenant_type' => $result['tenant_type'],
                // 'nom'           =>$result['nom'],
                'start_date' => $result['start_date'],
                // 'fusername'     =>$request->username,
                'email' => $request->email,
                'mobile' => $request->phone,
                'password' => bcrypt('password'),
                'status' => 1,
                'registered_as' => $request->registeredas,
                'type' => $request->type,
                'refrence_id' => $result['id'],

            );
            // mail to tenant
            Mail::send(
                'emailtemplate.tenant',
                [
                    'name' => $request->username,
                    'email' => $request->email,

                ],
                function ($message) use ($result) {
                    $message->to($result->email)->subject('Notification-Family Member Registration on Alfardan Living');
                }
            );
            // mail to family member
            Mail::send(
                'emailtemplate.familymember',
                [
                    'name' => $result['first_name']?$result['first_name'] . ' ' . $result['last_name']:$result['full_name'],
                    'email' => $request->email,

                ],
                function ($message) use ($request) {
                    $message->to($request->email)->subject('Invitation to Register on Alfardan Living');
                }
            );

            $result = $family->create($details);

            $details = array(

                'name' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone,
                'refrence_id' => $request->userid,
                'user_id' => $result->id,
                'status' => 1,
            );

            $result1 = FamilyMember::create($details);

            if ($request->hasFile('image')) {

                $file = $request->File('image');
                $image = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image);

                $detail = array(
                    'profile' => $image,
                );
                User::where('id', $result->id)->update($detail);

            }

            return redirect(route('admin.family_member'))->with('flash_success', 'Family Member Added Successfully!');

        }
    }

    public function deleteFamily(Request $request)
    {
        // $result=FamilyMember::where('id',$request->familyid)->delete();
        $result = user::find($request->familyid)->delete();

        if ($result) {
            return redirect(route('admin.family_member'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }
    public function addCorporateIndividual(Request $request)
    {

        if ($request->input('corporateid')) {
            $details = array(

                // 'fusername'     =>$request->username,
                'email' => $request->email,
                'mobile' => $request->phone,
                'property' => $request->property,
                'company_name' => $request->company_name,
                // 'password'      =>bcrypt('password'),
                // 'status'        =>1,
                // 'registered_as' =>$request->registeredas,
                // 'type'       =>$request->type

                // 'user_id'       =>$request->userid
            );

            user::where('id', $request->corporateid)->update($details);

            $details = array(

                'username' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone,
                'property' => $request->property,
                'company_name' => $request->company_name,
                'refrence_id' => $request->userid,
            );

            $result = CorporateIndividual::where('id', $request->corporateid)->update($details);

            return redirect(route('admin.corporate_individual'))->with('flash_success', 'Corporate Individual Updated Successfully!');

        } else {
            $corporate = new user();

            $result = user::find($request->userid);

            $details = array(
                'full_name' => $result['full_name'],
                // 'last_name'     =>$result['last_name'],
                'apt_number' => $result['apt_number'],
                'tenant_type' => $result['tenant_type'],
                'nom' => $result['nom'],
                'start_date' => $result['start_date'],
                'fusername' => $request->username,
                'email' => $request->email,
                'mobile' => $request->phone,
                'property' => $request->property,
                'company_name' => $request->company_name,
                'password' => bcrypt('password'),
                'status' => 1,
                'registered_as' => $request->registeredas,
                'type' => $request->type,
                'refrence_id' => $result['id'],

                // 'user_id'       =>$request->userid
            );

            $result = $corporate->create($details);

            $details = array(

                'username' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone,
                'property' => $request->property,
                'company_name' => $request->company_name,
                'refrence_id' => $request->userid,
                'user_id' => $result->id,
                'status' => 1,
            );

            $result = CorporateIndividual::create($details);

            if ($result) {

                return redirect(route('admin.corporate_individual'))->with('flash_success', 'Corporate Individual Added Successfully!');

            }
        }
    }

    public function deleteCorporate(Request $request)
    {
        // $result=CorporateIndividual::where('id',$request->corporate_id)->delete();
        $family = user::findOrFail($request->corporate_id);

        if (user::where('email', $family['email'])->count()) {
            user::where('email', $family['email'])->delete();
        }

        if (FamilyMember::where('refrence_id', $request->corporate_id)->count()) {
            FamilyMember::where('refrence_id', $request->corporate_id)->delete();
        }

        $family->delete();

        return redirect(route('admin.corporate_individual'))->with('flash_success', 'Record Deleted Successfully!');

    }

    public function addEvent(Request $request)
    {

        $validated = $request->validate([
            'property' => 'required',
            'tenant_type' => 'required',
            'eventname' => 'required',
            'date' => 'required',
            'location' => 'required',
            'description' => 'required|max:1000',
            'image1' => 'mimes:jpeg,png,jpg|max:2048',
            'image2' => 'mimes:jpeg,png,jpg|max:2048',
            'image3' => 'mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($request->input('publish')) {
            $status = 1;
        } elseif ($request->input('draft')) {
            $status = 0;
        }
        if ($request->input('eventid')) {
            $tenant_type = $request->has('tenant_type') ? implode(",", $request->input('tenant_type')) : '';

            $property = $request->has('property') ? implode(",", $request->input('property')) : '';

            $details = array(
                'name' => $request->eventname,
                'date' => $request->date,
                'location' => $request->location,
                'locationdetail' => @$request->locationdetail,
                'description' => $request->description,
                'time' => $request->time,
                'tenant_type' => $tenant_type,
                'property' => $property,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status' => $status,

            );

            $result = Event::where('id', $request->eventid)->update($details);

            if ($request->hasFile('image1') != '') {
                $file = $request->File('image1');
                $image1 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image1));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image1);

                $details = array(
                    'path' => $image1,
                    'event_id' => $request->eventid,
                );
                if ($request->image_1 != 0) {

                    Image::where('event_id', $request->eventid)
                        ->where('id', $request->image_1)->update($details);
                } else {

                    Image::create($details);
                }
                $details = array(
                    'cover' => $image1,
                );
                Event::where('id', $request->eventid)->update($details);
            }
            if ($request->hasFile('image2') != '') {
                $file = $request->File('image2');
                $image2 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image2));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image2);

                $details = array(
                    'path' => $image2,
                    'event_id' => $request->eventid,
                );
                if ($request->image_2 != 0) {
                    Image::where('event_id', $request->eventid)
                        ->where('id', $request->image_2)->update($details);
                } else {
                    Image::create($details);
                }
            }

            if ($request->hasFile('image3') != '') {
                $file = $request->File('image3');
                $image3 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image3));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image3);

                $details = array(
                    'path' => $image3,
                    'event_id' => $request->eventid,
                );
                if ($request->image_3 != 0) {
                    Image::where('event_id', $request->eventid)
                        ->where('id', $request->image_3)->update($details);
                } else {
                    Image::create($details);
                }

            }

            return redirect(route('admin.events'))->with('flash_success', 'Event updated Successfully!');
        } else {
            $tenant_type = $request->has('tenant_type') ? implode(",", $request->input('tenant_type')) : '';
            $property = $request->has('property') ? implode(",", $request->input('property')) : '';
            $event = new Event();

            $details = array(
                'name' => $request->eventname,
                'date' => $request->date,
                'location' => $request->location,
                'locationdetail' => @$request->locationdetail,
                'description' => $request->description,
                'time' => $request->time,
                'tenant_type' => $tenant_type,
                'property' => $property,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status' => $status,

            );

            $result = $event->create($details);

            if ($request->hasFile('image1')) {
                $file = $request->File('image1');
                $image1 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image1));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image1);

                $details = array(
                    'path' => $image1,
                    'event_id' => $result->id,
                );
                Image::create($details);
                $details = array(
                    'cover' => $image1,
                );
                Event::where('id', $result->id)->update($details);
            }
            if ($request->hasFile('image2')) {
                $file = $request->File('image2');
                $image2 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image2));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image2);

                $details = array(
                    'path' => $image2,
                    'event_id' => $result->id,
                );

                Image::create($details);
            }
            if ($request->hasFile('image3')) {
                $file = $request->File('image3');
                $image3 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image3));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image3);

                $details = array(
                    'path' => $image3,
                    'event_id' => $result->id,
                );

                Image::create($details);

            }
            return redirect(route('admin.events'))->with('flash_success', 'Event Added Successfully!');
        }
    }

    public function deleteEvent(Request $request)
    {
        $result = Event::find($request->eventid)->delete();

        if ($result) {
            return redirect(route('admin.events'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function addClass(Request $request)
    {

        $validated = $request->validate([
            'property' => 'required',
            'tenant_type' => 'required',
            'class_name' => 'required',
            'teacher_name' => 'required',
            'seats' => 'required',
            'location' => 'required',
            'description' => 'required|max:1000',
            'image1' => 'mimes:jpeg,png,jpg|max:2048',
            'image2' => 'mimes:jpeg,png,jpg|max:2048',
            'image3' => 'mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($request->input('publish')) {
            $status = 1;
        } elseif ($request->input('draft')) {
            $status = 0;
        }
        if ($request->input('classid')) {
            $tenant_type = $request->has('tenant_type') ? implode(",", $request->input('tenant_type')) : '';
            $property = $request->has('property') ? implode(",", $request->input('property')) : '';
            $details = array(
                'name' => $request->class_name,
                'teacher' => $request->teacher_name,
                'location' => $request->location,
                'locationdetail' => @$request->locationdetail,
                'description' => $request->description,
                'seats' => $request->seats,
                'tenant_type' => $tenant_type,
                'time' => $request->time,
                'date' => $request->date,
                'property' => $property,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'total_seats' => $request->seats,
                'status' => $status,
            );

            $result = ClassEvent::find($request->classid);
            $result->update($details);

            if ($request->hasFile('image1') != '') {
                $file = $request->File('image1');
                $image1 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image1));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image1);

                $details = array(
                    'path' => $image1,
                    'class_id' => $request->classid,
                );
                if ($request->image_1 != 0) {

                    Image::where('class_id', $request->classid)
                        ->where('id', $request->image_1)->update($details);
                } else {

                    Image::create($details);
                }

                $details = array(
                    'cover' => $image1,
                );
                $result->update($details);
            }
            if ($request->hasFile('image2') != '') {
                $file = $request->File('image2');
                $image2 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image2));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image2);

                $details = array(
                    'path' => $image2,
                    'class_id' => $request->classid,
                );
                if ($request->image_2 != 0) {
                    Image::where('class_id', $request->classid)
                        ->where('id', $request->image_2)->update($details);
                } else {

                    Image::create($details);
                }
            }

            if ($request->hasFile('image3') != '') {
                $file = $request->File('image3');
                $image3 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image3));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image3);

                $details = array(
                    'path' => $image3,
                    'class_id' => $request->classid,
                );
                if ($request->image_3 != 0) {
                    Image::where('class_id', $request->classid)
                        ->where('id', $request->image_3)->update($details);
                } else {
                    Image::create($details);
                }

            }
            if ($result->images()->count() < 1 && $status) {
                $result->status = 0;
                $result->save();
                return redirect(route('admin.classes'))->with('flash_success', 'Class updated Successfully! Please upload all images for publish');
            } else if ($result->status != $status) {
                $result->status = $status;
                $result->save();
            }

            return redirect(route('admin.classes'))->with('flash_success', 'Class updated Successfully!');
        } else {
            $tenant_type = $request->has('tenant_type') ? implode(",", $request->input('tenant_type')) : '';
            $property = $request->has('property') ? implode(",", $request->input('property')) : '';
            $class = new ClassEvent();
            if ($request->input('publish')) {
                $status = 1;
            } elseif ($request->input('draft')) {
                $status = 0;
            }
            $details = array(
                'name' => $request->class_name,
                'teacher' => $request->teacher_name,
                'location' => $request->location,
                'locationdetail' => @$request->locationdetail,
                'description' => $request->description,
                'seats' => $request->seats,
                'tenant_type' => $tenant_type,
                'time' => $request->time,
                'date' => $request->date,
                'property' => $property,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'total_seats' => $request->seats,
                'status' => $status,

            );

            $result = $class->create($details);

            if ($request->hasFile('image1')) {
                $file = $request->File('image1');
                $image1 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image1));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image1);

                $details = array(
                    'path' => $image1,
                    'class_id' => $result->id,
                );
                Image::create($details);

                $details = array(
                    'cover' => $image1,
                );
                ClassEvent::where('id', $result->id)->update($details);
            }
            if ($request->hasFile('image2')) {
                $file = $request->File('image2');
                $image2 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image2));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image2);

                $details = array(
                    'path' => $image2,
                    'class_id' => $result->id,
                );

                Image::create($details);
            }
            if ($request->hasFile('image3')) {
                $file = $request->File('image3');
                $image3 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image3));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image3);

                $details = array(
                    'path' => $image3,
                    'class_id' => $result->id,
                );

                Image::create($details);

            }
            if ($result->images->count() < 1 && $status) {
                $result->status = 0;
                $result->save();
                return redirect(route('admin.classes'))->with('flash_success', 'Class Added Successfully! Please upload all images for publish');
            } else if ($result->status != $status) {
                $result->status = $status;
                $result->save();
            }
            return redirect(route('admin.classes'))->with('flash_success', 'Class Added Successfully!');
        }
    }

    public function deleteClass(Request $request)
    {
        $result = ClassEvent::find($request->classid)->delete();

        if ($result) {
            return redirect(route('admin.classes'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function addFacility(Request $request)
    {
        $validated = $request->validate([
            'property' => 'required',
            'tenant_type' => 'required',
            'facilityname' => 'required',
            'location' => 'required',
            'description' => 'required|max:1000',
            'image1' => 'mimes:jpeg,png,jpg|max:2048',
            'image2' => 'mimes:jpeg,png,jpg|max:2048',
            'image3' => 'mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($request->input('publish')) {
            $status = 1;
        } elseif ($request->input('draft')) {
            $status = 0;
        }
        if ($request->input('facilityid')) {
            $tenant_type = $request->has('tenant_type') ? implode(",", $request->input('tenant_type')) : '';
            $property = $request->has('property') ? implode(",", $request->input('property')) : '';
            $details = array(
                'name' => $request->facilityname,
                'location' => $request->location,
                'locationdetail' => @$request->locationdetail,
                'description' => $request->description,
                'tenant_type' => $tenant_type,
                'time' => $request->time,
                'endtime' => $request->endtime,
                'avlb_days' => $request->avlb_days,
                'date' => $request->date,
                'property' => $property,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status' => $status,

            );

            $result = Facility::where('id', $request->facilityid)->update($details);

            if ($request->hasFile('image1') != '') {
                $file = $request->File('image1');
                $image1 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image1));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image1);

                $details = array(
                    'path' => $image1,
                    'facility_id' => $request->facilityid,
                );
                if ($request->image_1 != 0) {

                    Image::where('facility_id', $request->facilityid)
                        ->where('id', $request->image_1)->update($details);
                } else {

                    Image::create($details);
                }
                $details = array(
                    'cover' => $image1,
                );
                Facility::where('id', $request->facilityid)->update($details);
            }
            if ($request->hasFile('image2') != '') {
                $file = $request->File('image2');
                $image2 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image2));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image2);

                $details = array(
                    'path' => $image2,
                    'facility_id' => $request->facilityid,
                );
                if ($request->image_2 != 0) {
                    Image::where('facility_id', $request->facilityid)
                        ->where('id', $request->image_2)->update($details);
                } else {

                    Image::create($details);
                }
            }

            if ($request->hasFile('image3') != '') {
                $file = $request->File('image3');
                $image3 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image3));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image3);

                $details = array(
                    'path' => $image3,
                    'facility_id' => $request->facilityid,
                );
                if ($request->image_3 != 0) {
                    Image::where('facility_id', $request->facilityid)
                        ->where('id', $request->image_3)->update($details);
                } else {
                    Image::create($details);
                }

            }

            return redirect(route('admin.facilities'))->with('flash_success', 'Facility updated Successfully!');
        } else {
            $tenant_type = $request->has('tenant_type') ? implode(",", $request->input('tenant_type')) : '';
            $property = $request->has('property') ? implode(",", $request->input('property')) : '';
            $facility = new Facility();

            $details = array(
                'name' => $request->facilityname,
                'location' => $request->location,
                'locationdetail' => @$request->locationdetail,
                'description' => $request->description,
                'tenant_type' => $tenant_type,
                'time' => $request->time,
                'endtime' => $request->endtime,
                'avlb_days' => $request->avlb_days,
                'date' => $request->date,
                'property' => $property,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status' => $status,

            );

            $result = $facility->create($details);

            if ($request->hasFile('image1')) {
                $file = $request->File('image1');
                $image1 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image1));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image1);

                $details = array(
                    'path' => $image1,
                    'facility_id' => $result->id,
                );
                Image::create($details);

                $details = array(
                    'cover' => $image1,
                );
                Facility::where('id', $result->id)->update($details);
            }
            if ($request->hasFile('image2')) {
                $file = $request->File('image2');
                $image2 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image2));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image2);

                $details = array(
                    'path' => $image2,
                    'facility_id' => $result->id,
                );

                Image::create($details);
            }
            if ($request->hasFile('image3')) {
                $file = $request->File('image3');
                $image3 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image3));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image3);

                $details = array(
                    'path' => $image3,
                    'facility_id' => $result->id,
                );

                Image::create($details);

            }
            return redirect(route('admin.facilities'))->with('flash_success', 'Facility Added Successfully!');
        }

    }

    public function deleteFacility(Request $request)
    {
        $result = Facility::find($request->facilityid)->delete();

        if ($result) {
            return redirect(route('admin.facilities'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function addHotel(Request $request)
    {
        $validated = $request->validate([
            'property' => 'required',
            'tenant_type' => 'required',
            'hotel_name' => 'required',
            'phone' => 'required',
            'location' => 'required',
            'description' => 'required|max:1000',
            'image1' => 'mimes:jpeg,png,jpg|max:2048',
            'image2' => 'mimes:jpeg,png,jpg|max:2048',
            'image3' => 'mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($request->input('publish')) {
            $status = 1;
        } elseif ($request->input('draft')) {
            $status = 0;
        }
        if ($request->input('hotelid')) {
            $tenant_type = $request->has('tenant_type') ? implode(",", $request->input('tenant_type')) : '';
            $property = $request->has('property') ? implode(",", $request->input('property')) : '';
            $details = array(
                'name' => $request->hotel_name,
                'location' => $request->location,
                'locationdetail' => $request->locationdetail,
                'description' => $request->description,
                'phone' => $request->phone,
                'tenant_type' => $tenant_type,
                'date' => $request->date,
                'view_link' => $request->view_link,
                'property' => $property,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status' => $status,

            );

            $result = Hotel::where('id', $request->hotelid)->update($details);

            if ($request->hasFile('image1') != '') {
                $file = $request->File('image1');
                $image1 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image1));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image1);

                $details = array(
                    'path' => $image1,
                    'hotel_id' => $request->hotelid,
                );
                if ($request->image_1 != 0) {

                    Image::where('hotel_id', $request->hotelid)
                        ->where('id', $request->image_1)->update($details);
                } else {

                    Image::create($details);
                }

                $details = array(
                    'cover' => $image1,
                );
                Hotel::where('id', $request->hotelid)->update($details);
            }
            if ($request->hasFile('image2') != '') {
                $file = $request->File('image2');
                $image2 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image2));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image2);

                $details = array(
                    'path' => $image2,
                    'hotel_id' => $request->hotelid,
                );
                if ($request->image_2 != 0) {
                    Image::where('hotel_id', $request->hotelid)
                        ->where('id', $request->image_2)->update($details);
                } else {

                    Image::create($details);
                }
            }

            if ($request->hasFile('image3') != '') {
                $file = $request->File('image3');
                $image3 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image3));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image3);

                $details = array(
                    'path' => $image3,
                    'hotel_id' => $request->hotelid,
                );
                if ($request->image_3 != 0) {
                    Image::where('hotel_id', $request->hotelid)
                        ->where('id', $request->image_3)->update($details);
                } else {
                    Image::create($details);
                }

            }

            return redirect(route('admin.hotels'))->with('flash_success', 'Hotel updated Successfully!');
        } else {
            $tenant_type = $request->has('tenant_type') ? implode(",", $request->input('tenant_type')) : '';
            $property = $request->has('property') ? implode(",", $request->input('property')) : '';
            $hotel = new Hotel();

            $details = array(
                'name' => $request->hotel_name,
                'location' => $request->location,
                'locationdetail' => $request->locationdetail,
                'description' => $request->description,
                'phone' => $request->phone,
                'tenant_type' => $tenant_type,
                'date' => $request->date,
                'view_link' => $request->view_link,
                'property' => $property,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status' => $status,

            );

            $result = $hotel->create($details);

            if ($request->hasFile('image1')) {
                $file = $request->File('image1');
                $image1 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image1));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image1);

                $details = array(
                    'path' => $image1,
                    'hotel_id' => $result->id,
                );
                Image::create($details);
                $details = array(
                    'cover' => $image1,
                );
                Hotel::where('id', $result->id)->update($details);
            }
            if ($request->hasFile('image2')) {
                $file = $request->File('image2');
                $image2 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image2));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image2);

                $details = array(
                    'path' => $image2,
                    'hotel_id' => $result->id,
                );

                Image::create($details);
            }
            if ($request->hasFile('image3')) {
                $file = $request->File('image3');
                $image3 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image3));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image3);

                $details = array(
                    'path' => $image3,
                    'hotel_id' => $result->id,
                );

                Image::create($details);

            }
            return redirect(route('admin.hotels'))->with('flash_success', 'Hotel Added Successfully!');

        }

    }

    public function deleteHotel(Request $request)
    {
        $result = Hotel::find($request->hotelid)->delete();

        if ($result) {
            return redirect(route('admin.hotels'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function addRestaurant(Request $request)
    {
        $validated = $request->validate([
            'property' => 'required',
            'tenant_type' => 'required',
            'restaurant_name' => 'required',
            'phone' => 'required',
            'location' => 'required',
            'description' => 'required|max:1000',
            'image1' => 'required|mimes:jpeg,png,jpg|max:2048',
            'image2' => 'required|mimes:jpeg,png,jpg|max:2048',
            'image3' => 'required|mimes:jpeg,png,jpg|max:2048',
            'menu1' => 'mimes:jpeg,png,jpg,pdf|max:2048',

        ]);
        if ($request->input('publish')) {
            $status = 1;
        } elseif ($request->input('draft')) {
            $status = 0;
        }
        if ($request->input('restaurantid')) {
            $tenant_type = $request->has('tenant_type') ? implode(",", $request->input('tenant_type')) : '';
            $property = $request->has('property') ? implode(",", $request->input('property')) : '';

            if ($request->hasFile('menu1')) {
                $file = $request->File('menu1');
                $onlyName = (explode('.' . $file->getClientOriginalExtension(), $file->getClientOriginalName()));
                unset($onlyName[count($onlyName) - 1]);
                $menu1 = Str::slug(time() . end($onlyName)) . "." . $file->getClientOriginalExtension();
                /*$img_resize = InterventionImage::make($file->getRealPath())
                ->orientate()->save(public_path('uploads/'.$menu1));   */
                $destinationPath = public_path() . '/uploads';
                $file->move($destinationPath, $menu1);

                $detail = array(

                    'menu1' => $menu1,
                );

                Restaurant::where('id', $request->restaurantid)->update($detail);
            }

            if ($request->hasFile('menu2')) {
                $file = $request->File('menu2');
                $onlyName = (explode('.' . $file->getClientOriginalExtension(), $file->getClientOriginalName()));
                unset($onlyName[count($onlyName) - 1]);
                $menu2 = Str::slug(time() . end($onlyName)) . "." . $file->getClientOriginalExtension();
                /*$img_resize = InterventionImage::make($file->getRealPath())
                ->orientate()->save(public_path('uploads/'.$menu2));*/
                $destinationPath = public_path() . '/uploads';
                $file->move($destinationPath, $menu2);

                $detail = array(

                    'menu2' => $menu2,
                );

                Restaurant::where('id', $request->restaurantid)->update($detail);
            }

            if ($request->hasFile('menu3')) {
                $file = $request->File('menu3');
                $onlyName = (explode('.' . $file->getClientOriginalExtension(), $file->getClientOriginalName()));
                unset($onlyName[count($onlyName) - 1]);
                $menu3 = Str::slug(time() . end($onlyName)) . "." . $file->getClientOriginalExtension();
                /*$img_resize = InterventionImage::make($file->getRealPath())
                ->orientate()->save(public_path('uploads/'.$menu3));*/
                $destinationPath = public_path() . '/uploads';
                $file->move($destinationPath, $menu3);

                $detail = array(

                    'menu3' => $menu3,
                );

                Restaurant::where('id', $request->restaurantid)->update($detail);
            }
            if ($request->hasFile('menu4')) {
                $file = $request->File('menu4');
                $onlyName = (explode('.' . $file->getClientOriginalExtension(), $file->getClientOriginalName()));
                unset($onlyName[count($onlyName) - 1]);
                $menu4 = Str::slug(time() . end($onlyName)) . "." . $file->getClientOriginalExtension();
                /*$img_resize = InterventionImage::make($file->getRealPath())
                ->orientate()->save(public_path('uploads/'.$menu4));*/
                $destinationPath = public_path() . '/uploads';
                $file->move($destinationPath, $menu4);

                $detail = array(

                    'menu4' => $menu4,
                );

                Restaurant::where('id', $request->restaurantid)->update($detail);
            }
            if ($request->hasFile('menu5')) {
                $file = $request->File('menu5');
                $onlyName = (explode('.' . $file->getClientOriginalExtension(), $file->getClientOriginalName()));
                unset($onlyName[count($onlyName) - 1]);
                $menu4 = Str::slug(time() . end($onlyName)) . "." . $file->getClientOriginalExtension();
                /*$img_resize = InterventionImage::make($file->getRealPath())
                ->orientate()->save(public_path('uploads/'.$menu4));*/
                $destinationPath = public_path() . '/uploads';
                $file->move($destinationPath, $menu4);

                $detail = array(

                    'menu5' => $menu4,
                );

                Restaurant::where('id', $request->restaurantid)->update($detail);
            }
            $details = array(
                'name' => $request->restaurant_name,
                'location' => $request->location,
                'locationdetail' => @$request->locationdetail,
                'description' => $request->description,
                'phone' => $request->phone,
                'date' => $request->date,
                'view_link' => $request->view_link,
                'tenant_type' => $tenant_type,
                'property' => $property,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status' => $status,

            );

            $result = Restaurant::where('id', $request->restaurantid)->update($details);

            if ($request->hasFile('image1') != '') {
                $file = $request->File('image1');
                $image1 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image1));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image1);

                $details = array(
                    'path' => $image1,
                    'restaurant_id' => $request->restaurantid,
                );
                if ($request->image_1 != 0) {

                    Image::where('restaurant_id', $request->restaurantid)
                        ->where('id', $request->image_1)->update($details);
                } else {

                    Image::create($details);
                }
                $details = array(
                    'cover' => $image1,
                );
                Restaurant::where('id', $request->restaurantid)->update($details);

            }
            if ($request->hasFile('image2') != '') {
                $file = $request->File('image2');
                $image2 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image2));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image2);

                $details = array(
                    'path' => $image2,
                    'restaurant_id' => $request->restaurantid,
                );
                if ($request->image_2 != 0) {
                    Image::where('restaurant_id', $request->restaurantid)
                        ->where('id', $request->image_2)->update($details);
                } else {

                    Image::create($details);
                }
            }

            if ($request->hasFile('image3') != '') {
                $file = $request->File('image3');
                $image3 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image3));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image3);

                $details = array(
                    'path' => $image3,
                    'restaurant_id' => $request->restaurantid,
                );
                if ($request->image_3 != 0) {
                    Image::where('restaurant_id', $request->restaurantid)
                        ->where('id', $request->image_3)->update($details);
                } else {
                    Image::create($details);
                }

            }

            return redirect(route('admin.restaurants'))->with('flash_success', 'Restaurant updated Successfully!');
        } else {
            $tenant_type = $request->has('tenant_type') ? implode(",", $request->input('tenant_type')) : '';
            $property = $request->has('property') ? implode(",", $request->input('property')) : '';
            $restaurant = new Restaurant();
            if ($request->hasFile('menu1')) {
                $file = $request->File('menu1');
                // $menu1 = Str::slug(time().$file->getClientOriginalName()) ;
                /*$img_resize = InterventionImage::make($file->getRealPath())
                ->orientate()->save(public_path('uploads/'.$menu1));   */

                $onlyName = (explode('.' . $file->getClientOriginalExtension(), $file->getClientOriginalName()));
                unset($onlyName[count($onlyName) - 1]);
                $menu1 = Str::slug(time() . end($onlyName)) . "." . $file->getClientOriginalExtension();
                $destinationPath = public_path() . '/uploads';
                $file->move($destinationPath, $menu1);

            } else {
                $menu1 = '';
            }
            if ($request->hasFile('menu2')) {
                $file = $request->File('menu2');
                /*$menu2 = Str::slug(time().$file->getClientOriginalName()) ;
                $img_resize = InterventionImage::make($file->getRealPath())
                ->orientate()->save(public_path('uploads/'.$menu2));  */
                $onlyName = (explode('.' . $file->getClientOriginalExtension(), $file->getClientOriginalName()));
                unset($onlyName[count($onlyName) - 1]);
                $menu2 = Str::slug(time() . end($onlyName)) . "." . $file->getClientOriginalExtension();
                $destinationPath = public_path() . '/uploads';
                $file->move($destinationPath, $menu2);
            } else {
                $menu2 = '';
            }
            if ($request->hasFile('menu3')) {
                $file = $request->File('menu3');
                /*$menu3 = Str::slug(time().$file->getClientOriginalName()) ;
                $img_resize = InterventionImage::make($file->getRealPath())
                ->orientate()->save(public_path('uploads/'.$menu3));  */
                $onlyName = (explode('.' . $file->getClientOriginalExtension(), $file->getClientOriginalName()));
                unset($onlyName[count($onlyName) - 1]);
                $menu3 = Str::slug(time() . end($onlyName)) . "." . $file->getClientOriginalExtension();
                $destinationPath = public_path() . '/uploads';
                $file->move($destinationPath, $menu3);

            } else {
                $menu3 = '';
            }
            if ($request->hasFile('menu4')) {
                $file = $request->File('menu4');
                /*$menu4 = Str::slug(time().$file->getClientOriginalName()) ;
                $img_resize = InterventionImage::make($file->getRealPath())
                ->orientate()->save(public_path('uploads/'.$menu4)); */
                $onlyName = (explode('.' . $file->getClientOriginalExtension(), $file->getClientOriginalName()));
                unset($onlyName[count($onlyName) - 1]);
                $menu4 = Str::slug(time() . end($onlyName)) . "." . $file->getClientOriginalExtension();
                $destinationPath = public_path() . '/uploads';
                $file->move($destinationPath, $menu4);
            } else {
                $menu4 = '';
            }
            if ($request->hasFile('menu5')) {
                $file = $request->File('menu5');
                /*$menu5 = Str::slug(time().$file->getClientOriginalName()) ;
                $img_resize = InterventionImage::make($file->getRealPath())
                ->orientate()->save(public_path('uploads/'.$menu5)); */

                $onlyName = (explode('.' . $file->getClientOriginalExtension(), $file->getClientOriginalName()));
                unset($onlyName[count($onlyName) - 1]);
                $menu5 = Str::slug(time() . end($onlyName)) . "." . $file->getClientOriginalExtension();
                $destinationPath = public_path() . '/uploads';
                $file->move($destinationPath, $menu5);
            } else {
                $menu5 = '';
            }

            $details = array(
                'name' => $request->restaurant_name,
                'location' => $request->location,
                'locationdetail' => @$request->locationdetail,
                'description' => $request->description,
                'phone' => $request->phone,
                'date' => $request->date,
                'view_link' => $request->view_link,
                'tenant_type' => $tenant_type,
                'property' => $property,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'menu1' => $menu1,
                'menu2' => $menu2,
                'menu3' => $menu3,
                'menu4' => $menu4,
                'menu5' => $menu5,
                'status' => $status,

            );

            $result = $restaurant->create($details);
            $result->status = $status;
            $result->save();
            if ($request->hasFile('image1')) {
                $file = $request->File('image1');
                $image1 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image1));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image1);

                $details = array(
                    'path' => $image1,
                    'restaurant_id' => $result->id,
                );
                Image::create($details);
                $details = array(
                    'cover' => $image1,
                );
                Restaurant::where('id', $result->id)->update($details);
            }
            if ($request->hasFile('image2')) {
                $file = $request->File('image2');
                $image2 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image2));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image2);

                $details = array(
                    'path' => $image2,
                    'restaurant_id' => $result->id,
                );

                Image::create($details);
            }
            if ($request->hasFile('image3')) {
                $file = $request->File('image3');
                $image3 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image3));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image3);

                $details = array(
                    'path' => $image3,
                    'restaurant_id' => $result->id,
                );

                Image::create($details);

            }
            return redirect(route('admin.restaurants'))->with('flash_success', 'Restaurant Added Successfully!');
        }

    }

    public function deleteRestaurant(Request $request)
    {
        $result = Restaurant::find($request->restaurantid)->delete();

        if ($result) {
            return redirect(route('admin.restaurants'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function addWellness(Request $request)
    {
        $validated = $request->validate([
            'property' => 'required',
            'tenant_type' => 'required',
            'wellness_name' => 'required',
            'phone' => 'required',
            'location' => 'required',
            'description' => 'required|max:1000',
            'image1' => 'mimes:jpeg,png,jpg|max:2048',
            'image2' => 'mimes:jpeg,png,jpg|max:2048',
            'image3' => 'mimes:jpeg,png,jpg|max:2048',

        ]);
        if ($request->input('publish')) {
            $status = 1;
        } elseif ($request->input('draft')) {
            $status = 0;
        }
        if ($request->input('resortid')) {
            $tenant_type = $request->has('tenant_type') ? implode(",", $request->input('tenant_type')) : '';
            $property = $request->has('property') ? implode(",", $request->input('property')) : '';
            $details = array(
                'name' => $request->wellness_name,
                'location' => $request->location,
                'locationdetail' => @$request->locationdetail,
                'description' => $request->description,
                'phone' => $request->phone,
                'date' => $request->date,
                'view_link' => $request->view_link,
                'tenant_type' => $tenant_type,
                'property' => $property,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status' => $status,

            );

            $result = Resort::where('id', $request->resortid)->update($details);

            if ($request->hasFile('image1') != '') {
                $file = $request->File('image1');
                $image1 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image1));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image1);

                $details = array(
                    'path' => $image1,
                    'resort_id' => $request->resortid,
                );
                if ($request->image_1 != 0) {

                    Image::where('resort_id', $request->resortid)
                        ->where('id', $request->image_1)->update($details);
                } else {

                    Image::create($details);
                }

                $details = array(
                    'cover' => $image1,
                );
                Resort::where('id', $request->resortid)->update($details);
            }
            if ($request->hasFile('image2') != '') {
                $file = $request->File('image2');
                $image2 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image2));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image2);

                $details = array(
                    'path' => $image2,
                    'resort_id' => $request->resortid,
                );
                if ($request->image_2 != 0) {
                    Image::where('resort_id', $request->resortid)
                        ->where('id', $request->image_2)->update($details);
                } else {

                    Image::create($details);
                }
            }

            if ($request->hasFile('image3') != '') {
                $file = $request->File('image3');
                $image3 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image3));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image3);

                $details = array(
                    'path' => $image3,
                    'resort_id' => $request->resortid,
                );
                if ($request->image_3 != 0) {
                    Image::where('resort_id', $request->resortid)
                        ->where('id', $request->image_3)->update($details);
                } else {
                    Image::create($details);
                }
            }

            return redirect(route('admin.wellness'))->with('flash_success', 'Wellness updated Successfully!');
        } else {
            $tenant_type = $request->has('tenant_type') ? implode(",", $request->input('tenant_type')) : '';
            $property = $request->has('property') ? implode(",", $request->input('property')) : '';
            $restaurant = new Resort();

            $details = array(
                'name' => $request->wellness_name,
                'location' => $request->location,
                'locationdetail' => @$request->locationdetail,
                'description' => $request->description,
                'phone' => $request->phone,
                'date' => $request->date,
                'view_link' => $request->view_link,
                'tenant_type' => $tenant_type,
                'property' => $property,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status' => $status,

            );

            $result = $restaurant->create($details);

            if ($request->hasFile('image1') != '') {
                $file = $request->File('image1');
                $image1 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image1));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image1);

                $details = array(
                    'path' => $image1,
                    'resort_id' => $result->id,
                );
                Image::create($details);
                $details = array(
                    'cover' => $image1,
                );
                Resort::where('id', $result->id)->update($details);
            }
            if ($request->hasFile('image2') != '') {
                $file = $request->File('image2');
                $image2 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image2));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image2);

                $details = array(
                    'path' => $image2,
                    'resort_id' => $result->id,
                );

                Image::create($details);
            }
            if ($request->hasFile('image3') != '') {
                $file = $request->File('image3');
                $image3 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image3));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image3);

                $details = array(
                    'path' => $image3,
                    'resort_id' => $result->id,
                );

                Image::create($details);

            }
            return redirect(route('admin.wellness'))->with('flash_success', 'Wellness Added Successfully!');
        }

    }

    public function deleteResort(Request $request)
    {
        $result = Resort::find($request->resortid)->delete();

        if ($result) {
            return redirect(route('admin.wellness'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function addProperty(Request $request)
    {
        $validated = $request->validate([
            'short_description' => 'required|max:1000',
            'image1' => 'mimes:jpeg,png,jpg|max:2048',
            'image2' => 'mimes:jpeg,png,jpg|max:2048',
            'image3' => 'mimes:jpeg,png,jpg|max:2048',
            'image4' => 'mimes:jpeg,png,jpg|max:2048',
            'image5' => 'mimes:jpeg,png,jpg|max:2048',

        ]);
        if ($request->input('publish')) {
            $status = 1;
        } elseif ($request->input('draft')) {
            $status = 0;
        }
        if ($request->input('propertyid')) {
            // echo "<pre>";
            // print_r($request->all());
            // exit;
            $residences = $request->has('residences') ? implode(",", $request->input('residences')) : '';
            $facilities = $request->has('facilities') ? implode(",", $request->input('facilities')) : '';
            $services = $request->has('services') ? implode(",", $request->input('services')) : '';
            $privileges = $request->has('privileges') ? implode(",", $request->input('privileges')) : '';

            $details = array(
                'name' => $request->property_name,
                'location' => $request->location,
                'locationdetail' => @$request->locationdetail,
                'status' => $status,
                'phone' => $request->phone,
                'email' => $request->email,
                'view_link' => $request->link,
                'residences' => $residences,
                'facilities' => $facilities,
                'services' => $services,
                'privileges' => $privileges,
                'short_description' => $request->short_description,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'view_link_1' => $request->view_link_1,
                'view_link_2' => $request->view_link_2,
                'view_link_3' => $request->view_link_3,
                'view_link_4' => $request->view_link_4,
                'cpnumber' => $request->cpnumber,
            );

            $result = Property::where('id', $request->propertyid)->update($details);

            if ($request->hasFile('image1') != '') {
                $file = $request->File('image1');
                $image1 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image1));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image1);

                $details = array(
                    'path' => $image1,
                    'property_id' => $request->propertyid,
                );
                if ($request->image_1 != 0) {

                    Image::where('property_id', $request->propertyid)
                        ->where('id', $request->image_1)->update($details);
                } else {

                    Image::create($details);
                }
                $details = array(
                    'cover' => $image1,
                );
                Property::where('id', $request->propertyid)->update($details);
            }
            if ($request->hasFile('image2') != '') {
                $file = $request->File('image2');
                $image2 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image2));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image2);

                $details = array(
                    'path' => $image2,
                    'property_id' => $request->propertyid,
                );
                if ($request->image_2 != 0) {

                    Image::where('property_id', $request->propertyid)
                        ->where('id', $request->image_2)->update($details);
                } else {

                    Image::create($details);
                }
            }
            if ($request->hasFile('image3') != '') {
                $file = $request->File('image3');
                $image3 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image3));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image3);

                $details = array(
                    'path' => $image3,
                    'property_id' => $request->propertyid,
                );
                if ($request->image_3 != 0) {

                    Image::where('property_id', $request->propertyid)
                        ->where('id', $request->image_3)->update($details);
                } else {

                    Image::create($details);
                }
            }
            if ($request->hasFile('image4') != '') {
                $file = $request->File('image4');
                $image4 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image4));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image3);

                $details = array(
                    'path' => $image4,
                    'property_id' => $request->propertyid,
                );
                if ($request->image_4 != 0) {

                    Image::where('property_id', $request->propertyid)
                        ->where('id', $request->image_4)->update($details);
                } else {

                    Image::create($details);
                }
            }
            if ($request->hasFile('image5') != '') {
                $file = $request->File('image5');
                $image5 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image5));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image3);

                $details = array(
                    'path' => $image5,
                    'property_id' => $request->propertyid,
                );
                if ($request->image_5 != 0) {

                    Image::where('property_id', $request->propertyid)
                        ->where('id', $request->image_5)->update($details);
                } else {

                    Image::create($details);
                }
            }

            return redirect(route('admin.property'))->with('flash_success', 'Property updated Successfully!');
        } else {
            $property = new Property();

            $residences = $request->has('residences') ? implode(",", $request->input('residences')) : '';
            $facilities = $request->has('facilities') ? implode(",", $request->input('facilities')) : '';
            $services = $request->has('services') ? implode(",", $request->input('services')) : '';
            $privileges = $request->has('privileges') ? implode(",", $request->input('privileges')) : '';

            $details = array(
                'name' => $request->property_name,
                'location' => $request->location,
                'locationdetail' => @$request->locationdetail,
                // 'description'   =>  $request->description,
                'phone' => $request->phone,
                'email' => $request->email,
                'view_link' => $request->link,
                'residences' => $residences,
                'facilities' => $facilities,
                'services' => $services,
                'privileges' => $privileges,
                'short_description' => $request->short_description,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status' => $status,
                'view_link_1' => $request->view_link_1,
                'view_link_2' => $request->view_link_2,
                'view_link_3' => $request->view_link_3,
                'view_link_4' => $request->view_link_4,
                'cpnumber' => $request->cpnumber,
            );

            $result = $property->create($details);

            if ($request->hasFile('image1')) {
                $file = $request->File('image1');
                $image1 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image1));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image1);

                $details = array(
                    'path' => $image1,
                    'property_id' => $result->id,
                );
                Image::create($details);

                $details = array(
                    'cover' => $image1,
                );
                Property::where('id', $result->id)->update($details);
            }
            if ($request->hasFile('image2')) {
                $file = $request->File('image2');
                $image2 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image2));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image2);

                $details = array(
                    'path' => $image2,
                    'property_id' => $result->id,
                );
                Image::create($details);
            }
            if ($request->hasFile('image3')) {
                $file = $request->File('image3');
                $image3 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image3));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image3);

                $details = array(
                    'path' => $image3,
                    'property_id' => $result->id,
                );
                Image::create($details);

            }
            if ($request->hasFile('image4')) {
                $file = $request->File('image4');
                $image4 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image4));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image3);

                $details = array(
                    'path' => $image4,
                    'property_id' => $result->id,
                );
                Image::create($details);

            }
            if ($request->hasFile('image5')) {
                $file = $request->File('image5');
                $image5 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image5));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image3);

                $details = array(
                    'path' => $image5,
                    'property_id' => $result->id,
                );
                Image::create($details);

            }

            $notification = new Notification();
            $message = 'New Property added to leasing';
            $details = array(
                'property_id' => $result->id,
                'type' => 1,
                'title' => $result->name,
                'message' => $message,
            );

            $notification->create($details);

            return redirect(route('admin.property'))->with('flash_success', 'Property Added Successfully!');
        }

    }

    public function deleteProperty(Request $request)
    {
        $result = Property::find($request->propertyid)->delete();

        if ($result) {
            return redirect(route('admin.property'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function addApartment(Request $request)
    {

        $validated = $request->validate([
            'apt_name' => 'required',
            // 'image1'         => 'mimes:jpeg,png,jpg|max:2048',
            // 'image2'         => 'mimes:jpeg,png,jpg|max:2048',
            // 'image3'         => 'mimes:jpeg,png,jpg|max:2048'

        ]);
        if ($request->input('publish')) {
            $status = 1;
        } elseif ($request->input('draft')) {
            $status = 0;
        }
        if ($request->input('apartmentid')) {

            $details = array(
                'name' => $request->apt_name,
                'property_id' => $request->property_id,
                'status' => $status,
                // 'location'      =>  $request->location,
                // 'description'   =>  $request->description,
                // 'phone'         =>  $request->phone,
                // 'email'         =>  $request->email,
                // 'bedrooms'      =>  $request->bedrooms,
                // 'bathrooms'     =>  $request->bathroom,
                // 'area'          =>  $request->area,
                // 'view_link'     =>  $request->link,
                // 'short_description'   =>  $request->short_description,
                // 'availability'  =>  $request->availability,
                // 'latitude'      =>  $request->latitude,
                // 'longitude'      =>  $request->longitude
            );

            $result = Apartment::where('id', $request->apartmentid)->update($details);

            // if($request->hasFile('image1')!=''){
            //     $file = $request->File('image1');
            //     $image1 = Str::slug(time().$file->getClientOriginalName()) ;
            //     $img_resize = InterventionImage::make($file->getRealPath())
            //     ->orientate()
            //     ->fit(345, 300, function ($constraint) {
            //     $constraint->upsize();
            //      })
            //     ->save(public_path('uploads/'.$image1));

            //     $details=array(
            //         'path'      =>$image1,
            //         'apartment_id'  =>$request->apartmentid
            //     );
            //     if($request->image_1 !=0){

            //     Image::where('apartment_id',$request->apartmentid)
            //             ->where('id',$request->image_1)->update($details);
            //     }else{

            //         Image::create($details);
            //     }
            //     $details=array(
            //         'cover' =>$image1
            //     );
            //     $result=Apartment::where('id',$request->apartmentid)->update($details);
            // }
            // if($request->hasFile('image2')!=''){
            //     $file = $request->File('image2');
            //     $image2 = Str::slug(time().$file->getClientOriginalName()) ;
            //     $img_resize = InterventionImage::make($file->getRealPath())
            //     ->orientate()
            //     ->fit(345, 300, function ($constraint) {
            //     $constraint->upsize();
            //      })
            //     ->save(public_path('uploads/'.$image2));

            //     $details=array(
            //         'path'      =>$image2,
            //         'apartment_id'  =>$request->apartmentid
            //     );
            //     if($request->image_2 !=0){

            //     Image::where('apartment_id',$request->apartmentid)
            //             ->where('id',$request->image_2)->update($details);
            //     }else{

            //         Image::create($details);
            //     }
            // }
            // if($request->hasFile('image3')!=''){
            //     $file = $request->File('image3');
            //     $image3 = Str::slug(time().$file->getClientOriginalName()) ;
            //     $img_resize = InterventionImage::make($file->getRealPath())
            //     ->orientate()
            //     ->fit(345, 300, function ($constraint) {
            //     $constraint->upsize();
            //      })
            //     ->save(public_path('uploads/'.$image3));

            //     $details=array(
            //         'path'      =>$image3,
            //         'apartment_id'  =>$request->apartmentid
            //     );
            //     if($request->image_3 !=0){

            //     Image::where('apartment_id',$request->apartmentid)
            //             ->where('id',$request->image_3)->update($details);
            //     }else{

            //         Image::create($details);
            //     }
            // }

            return redirect()->back()->with('flash_success', 'Apartment updated Successfully!');
        } else {
            $apartment = new Apartment();
            // $details=[];
            foreach ($request->input('apt_name') as $apt_name) {

                $details = array(

                    'name' => $apt_name,
                    'property_id' => $request->property_id,
                    'status' => $status,
                );
                $result = $apartment->create($details);
            }
            // $details=array(
            //     'name'          =>  $request->apt_name,
            //     'property_id'   =>  $request->property_id,
            //     'status'        =>  $status,
            // 'location'      =>  $request->location,
            // 'description'   =>  $request->description,
            // 'phone'         =>  $request->phone,
            // 'email'         =>  $request->email,
            // 'bedrooms'      =>  $request->bedrooms,
            // 'bathrooms'     =>  $request->bathroom,
            // 'area'          =>  $request->area,
            // 'view_link'     =>  $request->link,
            // 'short_description'   =>  $request->short_description,
            // 'availability'  =>  $request->availability,
            // 'latitude'      =>  $request->latitude,
            // 'longitude'      =>  $request->longitude

            // );

            // if($request->hasFile('image1')){
            //     $file = $request->File('image1');
            //     $image1 = Str::slug(time().$file->getClientOriginalName());
            //     $img_resize = InterventionImage::make($file->getRealPath())
            //     ->orientate()
            //     ->fit(345, 300, function ($constraint) {
            //     $constraint->upsize();
            //      })
            //     ->save(public_path('uploads/'.$image1));

            //     $details=array(
            //         'path'      =>$image1,
            //         'apartment_id'  =>$result->id
            //     );
            //     Image::create($details);
            // }
            // if($request->hasFile('image2')){
            //     $file = $request->File('image2');
            //     $image2 = Str::slug(time().$file->getClientOriginalName());
            //     $img_resize = InterventionImage::make($file->getRealPath())
            //     ->orientate()
            //     ->fit(345, 300, function ($constraint) {
            //     $constraint->upsize();
            //      })
            //     ->save(public_path('uploads/'.$image2));

            //     $details=array(
            //         'path'      =>$image2,
            //         'apartment_id'  =>$result->id
            //     );
            //     Image::create($details);
            // }
            // if($request->hasFile('image3')){
            //     $file = $request->File('image3');
            //     $image3 = Str::slug(time().$file->getClientOriginalName());
            //     $img_resize = InterventionImage::make($file->getRealPath())
            //     ->orientate()
            //     ->fit(345, 300, function ($constraint) {
            //     $constraint->upsize();
            //      })
            //     ->save(public_path('uploads/'.$image3));

            //     $details=array(
            //         'path'      =>$image3,
            //         'apartment_id'  =>$result->id
            //     );
            //     Image::create($details);

            //     $details=array(
            //         'cover' =>$image1
            //     );
            //     $result=Apartment::where('id',$result->id)->update($details);
            // }
            return redirect()->back()->with('flash_success', 'Apartment Added Successfully!');
        }

    }

    public function deleteApartment(Request $request)
    {
        $result = Apartment::find($request->apartmentid)->delete();

        if ($result) {
            return redirect()->back()->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function addMaintenance(Request $request)
    {
        $v = [
            'type' => 'required',
            'description' => 'required',
            'tenant_type' => 'required',
            'emp_name' => 'required',
            'status' => 'required',
            'image' => 'mimes:jpeg,png,jpg|max:2048',
        ];
        if (@$request->status != 'open') {
            $v['complaintclosedate'] = 'required';
        }
        $validated = $request->validate($v);
        if ($request->input('publish')) {
            $status = 1;
        } elseif ($request->input('draft')) {
            $status = 0;
        }
        if ($request->input('maintenanceid')) {

            $details = array(
                // 'name'          =>  $request->name,
                'type' => $request->type,
                'property_id' => $request->property,
                'apartment_id' => $request->apartment,
                'ticket_id' => $request->ticket_id,
                'date' => $request->date,
                'time' => $request->time,
                'description' => $request->description,
                'status' => $request->status,
                'user_id' => $request->user_id,
                'tenant_type' => $request->tenant_type,
                'emp_name' => $request->emp_name,
                'form_status' => $status,
                'complaintclosedate' => $request->complaintclosedate,
            );
            $result = MaintenanceRequest::where('id', $request->maintenanceid)->update($details);
            $title = 'Maintenance Status';
            $message = 'Your maintenance request status has changed';
            $type = 12;
            if ($request->input('publish')) {
                $notification = new Notification();
                $details = array(
                    'maintenance_id' => $request->maintenanceid,
                    'type' => $type,
                    'user_id' => $request->userid,
                    'status' => $request->status,
                    'title' => $title,
                    'message' => $message,
                );

                $notification->create($details);
                NotificationHelper::pushnotification($title, $message, $request->user_id, $type);
            }

            if ($request->hasFile('image') != '') {
                $file = $request->File('image');
                $image = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image);

                $details = array(
                    'path' => $image,
                    'maintenance_request_id' => $request->maintenanceid,
                );
                if ($request->image_1 != 0) {

                    Image::where('maintenance_request_id', $request->maintenanceid)
                        ->where('id', $request->image_1)->update($details);
                } else {

                    Image::create($details);
                }
            }

            return redirect(route('admin.maintenance'))->with('flash_success', 'Record Updated Successfully!');

        } else {

            $maintenance = new MaintenanceRequest();

            $details = array(
                // 'name'          =>  $request->name,
                'type' => $request->type,
                'property_id' => $request->property,
                'apartment_id' => $request->apartment,
                'ticket_id' => $request->ticket_id,
                'date' => $request->date,
                'time' => $request->time,
                'description' => $request->description,
                'status' => $request->status,
                'user_id' => $request->user_id,
                'tenant_type' => $request->tenant_type,
                'emp_name' => $request->emp_name,
                'form_status' => $status,
                'complaintclosedate' => $request->complaintclosedate,
            );

            $result = $maintenance->create($details);

            if ($request->hasFile('image')) {
                $file = $request->File('image');
                $image = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image));
                // $destinationPath = public_path().'/uploads';
                // $file->move($destinationPath,$image);

                $details = array(
                    'path' => $image,
                    'maintenance_request_id' => $result->id,
                );

                Image::create($details);
            }
            return redirect(route('admin.maintenance'))->with('flash_success', 'Record Added Successfully!');
        }
    }

    public function deleteMaintenance(Request $request)
    {
        $result = MaintenanceRequest::find($request->maintenanceid)->delete();

        if ($result) {
            return redirect(route('admin.maintenance'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function addComplaint(Request $request)
    {

        $v = [
            'userid' => 'required',
            'type' => 'required',
            'description' => 'required|max:500',
            'formid' => 'required',
            'status' => 'required',
            'image' => 'mimes:jpeg,png,jpg|max:2048',

        ];
        if ($request->input('complaintid') && $request->status != 'open') {

            $v['close'] = 'required';
        }
        $validated = $request->validate($v);

        if ($request->input('publish')) {
            $status = 1;
        } elseif ($request->input('draft')) {
            $status = 0;
        }
        if ($request->input('complaintid')) {

            $details = array(
                'user_id' => $request->userid,
                'type' => $request->type,
                'property_id' => $request->property_id,
                'apartment_id' => $request->apartment_id,
                'mobile' => $request->mobile,
                'description' => $request->description,
                'status' => $request->status,
                'form_id' => $request->formid,
                'form_status' => $status,
                'close' => $request->close,
            );

            $result = Complaint::where('id', $request->complaintid)->update($details);

            if ($request->hasFile('image') != '') {
                $file = $request->File('image');
                $image = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image);

                $details = array(
                    'path' => $image,
                    'complaint_id' => $request->complaintid,
                );
                if ($request->image_1 != 0) {

                    Image::where('complaint_id', $request->complaintid)
                        ->where('id', $request->image_1)->update($details);
                } else {

                    Image::create($details);

                }
            }
            // Notification::where('complaint_id',$request->complaintid)->delete();
            if ($request->input('publish')) {
                $notification = new Notification();
                $title = 'Complaint Status';
                $type = 2;
                $message = 'Your complaint request status has changed Please check it.';
                $details = array(
                    'complaint_id' => $request->complaintid,
                    'type' => $type,
                    'user_id' => $request->userid,
                    'status' => $request->status,
                    'title' => $title,
                    'message' => $message,
                );

                $notification->create($details);
                NotificationHelper::pushnotification($title, $message, $request->userid, $type);
            }
            return redirect(route('admin.complaints'))->with('flash_success', 'Record Updated Successfully!');

        } else {

            $complaint = new Complaint();

            $details = array(
                'user_id' => $request->userid,
                'type' => $request->type,
                'property_id' => $request->property_id,
                'apartment_id' => $request->apartment_id,
                'mobile' => $request->mobile,
                'description' => $request->description,
                'status' => $request->status,
                'form_id' => $request->formid,
                'form_status' => $status,

            );

            $result = $complaint->create($details);

            if ($request->hasFile('image')) {
                $file = $request->File('image');
                $image = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image));
                // $destinationPath = public_path().'/uploads';
                // $file->move($destinationPath,$image);

                $details = array(
                    'path' => $image,
                    'complaint_id' => $result->id,
                );

                Image::create($details);
            }
            return redirect(route('admin.complaints'))->with('flash_success', 'Record Added Successfully!');
        }
    }

    public function deleteComplaint(Request $request)
    {
        $result = Complaint::find($request->complaintid)->delete();

        if ($result) {
            return redirect(route('admin.complaints'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function addCircular(Request $request)
    {
        // dd($request->all());

        $validated = $request->validate([
            'description' => 'required|max:500',
            'circular_id' => 'required',
            'image1' => 'mimes:jpeg,png,jpg|max:2048',
            'image2' => 'mimes:jpeg,png,jpg|max:2048',
            'pdffile' => 'mimes:pdf|max:5120',

        ]);
        if ($request->input('publish')) {
            $status = 1;
        } elseif ($request->input('draft')) {
            $status = 0;
        }
        $property = $request->has('property_id') ? implode(",", $request->input('property_id')) : '';
        $apartment = $request->has('apartment_id') ? implode(",", $request->input('apartment_id')) : '';

        if ($request->input('circularid')) {

            if ($request->hasFile('image1') != '') {
                $file = $request->File('image1');
                $image1 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image1));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image1);

                $detail = array(
                    'cover' => $image1,
                );
                Update::where('id', $request->circularid)->update($detail);
            }

            if ($request->hasFile('file')) {

                $file = $request->File('file');
                $pdfilename = Str::slug(time() . $file->getClientOriginalName());
                $pdfilename = $pdfilename . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/pdfs', $pdfilename);
                $fileurl = 'uploads/pdfs/' . $pdfilename;
                $detail = array(
                    'pdffile' => $fileurl,
                );
                Update::where('id', $request->circularid)->update($detail);
            }

            // if($request->hasFile('image2')!=''){
            //     $file = $request->File('image2');
            //     $image2 = Str::slug(time().$file->getClientOriginalName()) ;
            //     $file->move($destinationPath,$image2);

            //     $detail=array(
            //         'image' => $image2
            //     );
            //     Update::where('id',$request->circularid)->update($detail);
            // }

            $details = array(
                'circular_name' => $request->circular_name,
                'circular_id' => $request->circular_id,
                'property_id' => $property,
                'apartment_id' => $apartment,
                'description' => $request->description,
                'status' => $status,

            );

            $result = Update::where('id', $request->circularid)->update($details);

            return redirect(route('admin.circular_update'))->with('flash_success', 'Record Updated Successfully!');
        } else {
            $property = $request->has('property_id') ? implode(",", $request->input('property_id')) : '';
            $apartment = $request->has('apartment_id') ? implode(",", $request->input('apartment_id')) : '';
            $update = new Update();

            if ($request->hasFile('image2') != '') {
                $file = $request->File('image2');
                $image2 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image2));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image2);
            }

            $fileurl = "";
            if ($request->hasFile('file')) {

                $file = $request->File('file');
                $pdfilename = Str::slug(time() . $file->getClientOriginalName());
                $pdfilename = $pdfilename . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/pdfs', $pdfilename);
                $fileurl = 'uploads/pdfs/' . $pdfilename;

            }

            $details = array(

                'circular_name' => $request->circular_name,
                'circular_id' => $request->circular_id,
                'property_id' => $property,
                'apartment_id' => $apartment,
                'description' => $request->description,
                'cover' => $request->File('image1'),
                'status' => $status,
                'pdffile' => $fileurl,
                // 'image'           =>  $image2

            );

            $result = $update->create($details);
            if ($request->input('publish')) {

                $notification = new Notification();

                $title = $request->circular_name;
                $message = 'Circular has been added for your apartment';
                $type = 32;

                $users = User::wherein("apt_number", $request->apartment_id)->get();
                foreach ($users as $user) {

                    $notification = new Notification();

                    $details = array(
                        'serivec_id' => $result->id,
                        'type' => $type,
                        'user_id' => $user->id,
                        'status' => 1,
                        'title' => $title,
                        'message' => $message,
                    );

                    $notification->create($details);
                    NotificationHelper::pushnotification($title, $message, $user->id, $type);
                }
            }

            return redirect(route('admin.circular_update'))->with('flash_success', 'Record Added Successfully!');
        }
    }

    public function deleteCircular(Request $request)
    {
        $result = Update::find($request->circularid)->delete();

        if ($result) {
            return redirect(route('admin.circular_update'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function addSurvey(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'link' => 'required',
            'surveyid' => 'required',
        ]);
        if ($request->input('publish')) {
            $status = 1;
        } elseif ($request->input('draft')) {
            $status = 0;
        }
        if ($request->input('survey_id')) {
            $tenant_type = $request->has('tenant_type') ? implode(",", $request->input('tenant_type')) : '';
            $property = $request->has('property') ? implode(",", $request->input('property')) : '';
            $details = array(

                'name' => $request->name,
                'property_id' => $property,
                'apartment_id' => implode(",", $request->apartment_id),
                'link' => $request->link,
                'survey_id' => $request->surveyid,
                'status' => $status,
                'tenant_type' => $tenant_type,

            );

            Survey::where('id', $request->survey_id)->update($details);

            return redirect(route('admin.survey'))->with('flash_success', 'Record Updated Successfully!');
        } else {

            $survey = new Survey();
            $tenant_type = '';
            if ($request->has('tenant_type')) {
                $tenant_type = $request->has('tenant_type') ? implode(",", $request->input('tenant_type')) : '';
            }
            $property = $request->has('property') ? implode(",", $request->input('property')) : '';
            $details = array(

                'name' => $request->name,
                'property_id' => $property,
                'apartment_id' => implode(",", $request->apartment_id),
                'link' => $request->link,
                'survey_id' => $request->surveyid,
                'status' => $status,
                'tenant_type' => $tenant_type,

            );

            $result = $survey->create($details);

            if ($request->input('publish')) {

                $notification = new Notification();

                $title = $request->name;
                $message = 'Survey has been added for your apartment.';
                $type = 31;

                $users = User::wherein("apt_number", $request->apartment_id)->get();
                foreach ($users as $user) {

                    $notification = new Notification();

                    $details = array(
                        'serivec_id' => $result->id,
                        'type' => $type,
                        'user_id' => $user->id,
                        'status' => 1,
                        'title' => $title,
                        'message' => $message,
                    );

                    $notification->create($details);

                    NotificationHelper::pushnotification($title, $message, $user->id, $type);
                }
            }

            return redirect(route('admin.survey'))->with('flash_success', 'Record Added Successfully!');
        }

    }

    public function addServices(Request $request)
    {
        $validated = $request->validate([
            'userid' => 'required',
            'formid' => 'required',
            'date' => 'required',
            'type' => 'required',
            'reason' => 'required|max:100',
        ]);
        if ($request->input('publish')) {
            $status = 1;
        } elseif ($request->input('draft')) {
            $status = 0;
        }
        if ($request->input('service_id')) {

            $details = array(

                'user_id' => $request->userid,
                'form_id' => $request->formid,
                'submission_date' => $request->submission,
                'date' => $request->date,
                'type' => $request->type,
                'property_id' => $request->property_id,
                'apartment_id' => $request->apartment_id,
                'attendee' => $request->attendee,
                'reason' => $request->reason,
                'status' => $request->status,
                'form_status' => $status,

            );
            ServiceRequest::where('id', $request->service_id)->update($details);
            if ($request->input('publish')) {
                $notification = new Notification();

                $title = 'Services Status';
                $message = 'Your services request status has changed';
                $type = 3;
                $details = array(
                    'serivec_id' => $request->service_id,
                    'type' => $type,
                    'user_id' => $request->userid,
                    'status' => $request->status,
                    'title' => $title,
                    'message' => $message,
                );

                $notification->create($details);
                NotificationHelper::pushnotification($title, $message, $request->userid, $type);
            }

            return redirect(route('admin.services'))->with('flash_success', 'Record Updated Successfully!');
        } else {

            $service = new ServiceRequest();

            $details = array(

                'user_id' => $request->userid,
                'form_id' => $request->formid,
                'submission_date' => $request->submission,
                'date' => $request->date,
                'type' => $request->type,
                'property_id' => $request->property_id,
                'apartment_id' => $request->apartment_id,
                'attendee' => $request->attendee,
                'reason' => $request->reason,
                'status' => $request->status,
                'form_status' => $status,

            );

            $result = $service->create($details);

            return redirect(route('admin.services'))->with('flash_success', 'Record Added Successfully!');
        }

    }

    public function getServices(Request $request)
    {
        $service = ServiceRequest::with('user')->where('id', $request->id)->first();
        return $service;
    }

    public function deleteServices(Request $request)
    {
        $result = ServiceRequest::find($request->serviceid)->delete();

        if ($result) {
            return redirect(route('admin.services'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function addPet(Request $request)
    {
        $validated = $request->validate([
            'userid' => 'required',
            'name' => 'required',
            'family' => 'required',
            'species' => 'required',
            'size' => 'required',
            'weight' => 'required',

        ]);
        if ($request->input('publish')) {
            $status = 1;
        } elseif ($request->input('draft')) {
            $status = 0;
        }
        if ($request->input('pet_id')) {

            $details = array(

                'user_id' => $request->userid,
                'name' => $request->name,
                'family' => $request->family,
                'species' => $request->species,
                'size' => $request->size,
                'weight' => $request->weight,
                'date' => $request->date,
                'property_id' => $request->property_id,
                'apartment_id' => $request->apartment_id,
                'mobile' => $request->mobile,
                'term' => $request->term,
                'status' => $request->status,
                'form_status' => $status,

            );
            PetApplication::where('id', $request->pet_id)->update($details);
            if ($request->input('publish')) {
                $title = 'Pet Application';
                $message = 'Your pet application request status has changed';
                $type = 4;
                $notification = new Notification();
                $details = array(
                    'pet_id' => $request->pet_id,
                    'type' => $type,
                    'user_id' => $request->userid,
                    'status' => $request->status,
                    'title' => $title,
                    'message' => $message,
                );

                $notification->create($details);
                NotificationHelper::pushnotification($title, $message, $request->userid, $type);
            }

            return redirect(route('admin.pet_form'))->with('flash_success', 'Record Updated Successfully!');
        } else {

            $pet = new PetApplication();

            $details = array(

                'user_id' => $request->userid,
                'name' => $request->name,
                'family' => $request->family,
                'species' => $request->species,
                'size' => $request->size,
                'weight' => $request->weight,
                'date' => $request->date,
                'property_id' => $request->property_id,
                'apartment_id' => $request->apartment_id,
                'mobile' => $request->mobile,
                'status' => $request->status,
                'form_status' => $status,
                'term' => $request->term,

            );

            $result = $pet->create($details);

            return redirect(route('admin.pet_form'))->with('flash_success', 'Record Added Successfully!');
        }

    }

    public function getPet(Request $request)
    {
        $pet = PetApplication::with('user')->where('id', $request->id)->first();
        return $pet;
    }

    public function deletePet(Request $request)
    {
        $result = PetApplication::find($request->petid)->delete();

        if ($result) {
            return redirect(route('admin.pet_form'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function addMaintenanceAbsentia(Request $request)
    {
        $validated = $request->validate([
            'userid' => 'required',
            'formid' => 'required',
            'phone' => 'required',
            'date' => 'required',
            'reason' => 'required|max:100',

        ]);
        if ($request->input('publish')) {
            $status = 1;
        } elseif ($request->input('draft')) {
            $status = 0;
        }
        if ($request->input('maintenance_id')) {

            $details = array(

                'user_id' => $request->userid,
                'form_id' => $request->formid,
                'submission_date' => $request->submission,
                'phone' => $request->phone,
                'date' => $request->date,
                'property_id' => $request->property_id,
                'apartment_id' => $request->apartment_id,
                'reason' => $request->reason,
                'status' => $request->status,
                'form_status' => $status,
                'term' => $request->term,

            );
            MaintenanceAbsentiaRequest::where('id', $request->maintenance_id)->update($details);
            if ($request->input('publish')) {
                $title = 'Maintenance Absentia Status';
                $message = 'Your maintenance absentia request status has changed';
                $type = 5;
                $notification = new Notification();
                $details = array(
                    'maintenance_absentia_id' => $request->maintenance_id,
                    'type' => $type,
                    'user_id' => $request->userid,
                    'status' => $request->status,
                    'title' => $title,
                    'message' => $message,
                );

                $notification->create($details);
                NotificationHelper::pushnotification($title, $message, $request->userid, $type);
            }

            return redirect(route('admin.maintenance_in_absentia'))->with('flash_success', 'Record Updated Successfully!');
        } else {

            $maintenance = new MaintenanceAbsentiaRequest();

            $details = array(

                'user_id' => $request->userid,
                'form_id' => $request->formid,
                'submission_date' => $request->submission,
                'phone' => $request->phone,
                'date' => $request->date,
                'property_id' => $request->property_id,
                'apartment_id' => $request->apartment_id,
                'reason' => $request->reason,
                'status' => $request->status,
                'form_status' => $status,
                'term' => $request->term,

            );

            $result = $maintenance->create($details);

            return redirect(route('admin.maintenance_in_absentia'))->with('flash_success', 'Record Added Successfully!');
        }

    }

    public function getMaintenanceAbsentia(Request $request)
    {
        $maintenance = MaintenanceAbsentiaRequest::with('user')->where('id', $request->id)->first();
        return $maintenance;
    }

    public function deleteMaintenanceAbsentia(Request $request)
    {
        $result = MaintenanceAbsentiaRequest::find($request->maintenanceid)->delete();

        if ($result) {
            return redirect(route('admin.maintenance_in_absentia'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function addVehicle(Request $request)
    {
        $validated = $request->validate([
            'userid' => 'required',
            'formid' => 'required',
            'phone' => 'required',
            'model' => 'required',
            'color' => 'required',
            'registration' => 'required',
            'parking_space' => 'required',
            'reason' => 'required|max:100',
        ]);
        if ($request->input('publish')) {
            $status = 1;
        } elseif ($request->input('draft')) {
            $status = 0;
        }
        if ($request->input('vehicle_id')) {

            $details = array(

                'user_id' => $request->userid,
                'form_id' => $request->formid,
                'submission_date' => $request->submission,
                'name' => $request->name,
                'model' => $request->model,
                'color' => $request->color,
                'registration' => $request->registration,
                'parking_space' => $request->parking_space,
                'phone' => $request->phone,
                'property_id' => $request->property_id,
                'apartment_id' => $request->apartment_id,
                'reason' => $request->reason,
                'status' => $request->status,
                'form_status' => $status,

            );
            VehicleRequest::where('id', $request->vehicle_id)->update($details);
            if ($request->input('publish')) {
                $title = 'Vehicle Status';
                $message = 'Your vehicle  request status has changed';
                $type = 8;
                $notification = new Notification();
                $details = array(
                    'vehicle_id' => $request->vehicle_id,
                    'type' => $type,
                    'user_id' => $request->userid,
                    'status' => $request->status,
                    'title' => $title,
                    'message' => $message,
                );

                $notification->create($details);
                NotificationHelper::pushnotification($title, $message, $request->userid, $type);
            }

            return redirect(route('admin.vehicle_form'))->with('flash_success', 'Record Updated Successfully!');
        } else {

            $maintenance = new VehicleRequest();

            $details = array(

                'user_id' => $request->userid,
                'form_id' => $request->formid,
                'submission_date' => $request->submission,
                'name' => $request->name,
                'model' => $request->model,
                'color' => $request->color,
                'registration' => $request->registration,
                'parking_space' => $request->parking_space,
                'phone' => $request->phone,
                'property_id' => $request->property_id,
                'apartment_id' => $request->apartment_id,
                'reason' => $request->reason,
                'status' => $request->status,
                'form_status' => $status,

            );

            $result = $maintenance->create($details);

            return redirect(route('admin.vehicle_form'))->with('flash_success', 'Record Added Successfully!');
        }

    }

    public function getVehicle(Request $request)
    {
        $maintenance = VehicleRequest::with('user')->where('id', $request->id)->first();
        return $maintenance;
    }

    public function deleteVehicle(Request $request)
    {
        $result = VehicleRequest::find($request->vehicleid)->delete();

        if ($result) {
            return redirect(route('admin.vehicle_form'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function addHousekeeping(Request $request)
    {
        $validated = $request->validate([
            'userid' => 'required',
            'formid' => 'required',
            'phone' => 'required',
            'name' => 'required',
            'qatar_id' => 'required',
            'reason' => 'required|max:100',
        ]);
        if ($request->input('publish')) {
            $status = 1;
        } elseif ($request->input('draft')) {
            $status = 0;
        }
        if ($request->input('housekeeping_id')) {

            $details = array(

                'user_id' => $request->userid,
                'form_id' => $request->formid,
                'contact' => $request->phone,
                'name' => $request->name,
                'qatar_id' => $request->qatar_id,
                'property_id' => $request->property_id,
                'apartment_id' => $request->apartment_id,
                'reason' => $request->reason,
                'status' => $request->status,
                'form_status' => $status,

            );
            HousekeeperRequest::where('id', $request->housekeeping_id)->update($details);
            if ($request->input('publish')) {
                $title = 'Housekeeper Status';
                $message = 'Your housekeeper request status has changed';
                $type = 9;
                $notification = new Notification();
                $details = array(
                    'housekeeper_id' => $request->housekeeping_id,
                    'type' => $type,
                    'user_id' => $request->userid,
                    'status' => $request->status,
                    'title' => $title,
                    'message' => $message,
                );

                $notification->create($details);
                NotificationHelper::pushnotification($title, $message, $request->userid, $type);
            }

            return redirect(route('admin.housekeeping_form'))->with('flash_success', 'Record Updated Successfully!');
        } else {

            $housekeeper = new HousekeeperRequest();

            $details = array(

                'user_id' => $request->userid,
                'form_id' => $request->formid,
                'contact' => $request->phone,
                'name' => $request->name,
                'qatar_id' => $request->qatar_id,
                'property_id' => $request->property_id,
                'apartment_id' => $request->apartment_id,
                'reason' => $request->reason,
                'status' => $request->status,
                'form_status' => $status,

            );

            $result = $housekeeper->create($details);

            return redirect(route('admin.housekeeping_form'))->with('flash_success', 'Record Added Successfully!');
        }

    }

    public function getHousekeeping(Request $request)
    {
        $housekeeper = HousekeeperRequest::with('user')->where('id', $request->id)->first();
        return $housekeeper;
    }

    public function deleteHousekeeping(Request $request)
    {
        $result = HousekeeperRequest::find($request->housekeeperid)->delete();

        if ($result) {
            return redirect(route('admin.housekeeping_form'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function addAutomatedGuest(Request $request)
    {
        $validated = $request->validate([
            'userid' => 'required',
            'formid' => 'required',
            'phone' => 'required',
            'date' => 'required',
            'name' => 'required',
            'reason' => 'required|max:100',
            'image' => 'mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($request->input('publish')) {
            $status = 1;
        } elseif ($request->input('draft')) {
            $status = 0;
        }
        if ($request->input('automate_id')) {

            if ($request->hasFile('image') != '') {
                $file = $request->File('image');
                $image = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image);

                $detail = array(
                    'photo' => $image,
                );
                GuestAccessRequest::where('id', $request->automate_id)->update($detail);
            }

            $details = array(

                'user_id' => $request->userid,
                'form_id' => $request->formid,
                'submission_date' => $request->submission,
                'number' => $request->number,
                'date' => $request->date,
                'property_id' => $request->property_id,
                'apartment_id' => $request->apartment_id,
                'reason' => $request->reason,
                'status' => $request->status,
                'form_status' => $status,
                'term' => $request->term,
                'phone' => $request->phone,
                'name' => $request->name,

            );
            GuestAccessRequest::where('id', $request->automate_id)->update($details);
            if ($request->input('publish')) {
                $title = 'Automated Guest Status';
                $message = 'Your automated guest access request status has changed';
                $type = 6;
                $notification = new Notification();
                $details = array(
                    'guest_id' => $request->automate_id,
                    'type' => $type,
                    'user_id' => $request->userid,
                    'status' => $request->status,
                    'title' => $title,
                    'message' => $message,
                );

                $notification->create($details);
                NotificationHelper::pushnotification($title, $message, $request->userid, $type);
            }

            return redirect(route('admin.automated_guest_access'))->with('flash_success', 'Record Updated Successfully!');
        } else {

            $housekeeper = new GuestAccessRequest();

            $details = array(

                'user_id' => $request->userid,
                'form_id' => $request->formid,
                'submission_date' => $request->submission,
                'number' => $request->number,
                'date' => $request->date,
                'property_id' => $request->property_id,
                'apartment_id' => $request->apartment_id,
                'reason' => $request->reason,
                'status' => $request->status,
                'form_status' => $status,
                'term' => $request->term,
                'phone' => $request->phone,
                'photo' => $request->File('image'),
                'name' => $request->name,

            );

            $result = $housekeeper->create($details);

            return redirect(route('admin.automated_guest_access'))->with('flash_success', 'Record Added Successfully!');
        }

    }

    public function getAutomatedGuest(Request $request)
    {
        $housekeeper = GuestAccessRequest::with('user')->where('id', $request->id)->first();
        return $housekeeper;
    }

    public function deleteAutomatedGuest(Request $request)
    {
        $result = GuestAccessRequest::find($request->automatedid)->delete();

        if ($result) {
            return redirect(route('admin.automated_guest_access'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function addAccesskey(Request $request)
    {
        $validated = $request->validate([
            'userid' => 'required',
            'formid' => 'required',
            'card_request' => 'required',
            'access_type' => 'required',
            'expiry_date' => 'required',
            'quantity' => 'required',
            'charge' => 'required',
            'image' => 'mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($request->input('publish')) {
            $status = 1;
        } elseif ($request->input('draft')) {
            $status = 0;
        }
        if ($request->input('accesskey_id')) {

            if ($request->hasFile('image') != '') {
                $file = $request->File('image');
                $image = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image));
                // $destinationPath = public_path().'/uploads' ;
                // $file->move($destinationPath,$image);

                $detail = array(
                    'photo' => $image,
                );
                AccessKeyRequest::where('id', $request->accesskey_id)->update($detail);
            }

            $details = array(

                'user_id' => $request->userid,
                'form_id' => $request->formid,
                'submission_date' => $request->submission,
                'card_type' => $request->card_request,
                'access_type' => $request->access_type,
                'property_id' => $request->property_id,
                'apartment_id' => $request->apartment_id,
                'expiry_date' => $request->expiry_date,
                'quantity' => $request->quantity,
                'status' => $request->status,
                'form_status' => $status,
                'charge' => $request->charge,
                'description' => $request->description,

            );
            AccessKeyRequest::where('id', $request->accesskey_id)->update($details);
            if ($request->input('publish')) {
                $title = 'Access Key Status';
                $message = 'Your access key request status has changed';
                $type = 7;
                $notification = new Notification();
                $details = array(
                    'access_id' => $request->accesskey_id,
                    'type' => $type,
                    'user_id' => $request->userid,
                    'status' => $request->status,
                    'title' => $title,
                    'message' => $message,
                );

                $notification->create($details);
                NotificationHelper::pushnotification($title, $message, $request->userid, $type);
            }

            return redirect(route('admin.access_key_card'))->with('flash_success', 'Record Updated Successfully!');
        } else {

            $access = new AccessKeyRequest();

            $details = array(

                'user_id' => $request->userid,
                'form_id' => $request->formid,
                'submission_date' => $request->submission,
                'card_type' => $request->card_request,
                'access_type' => $request->access_type,
                'property_id' => $request->property_id,
                'apartment_id' => $request->apartment_id,
                'expiry_date' => $request->expiry_date,
                'quantity' => $request->quantity,
                'status' => $request->status,
                'form_status' => $status,
                'charge' => $request->charge,
                'description' => $request->description,
                'photo' => $request->File('image'),

            );

            $result = $access->create($details);

            return redirect(route('admin.access_key_card'))->with('flash_success', 'Record Added Successfully!');
        }

    }

    public function getAccesskey(Request $request)
    {
        $access = AccessKeyRequest::with('user')->where('id', $request->id)->first();
        return $access;
    }

    public function deleteAccesskey(Request $request)
    {
        $result = AccessKeyRequest::find($request->accessid)->delete();

        if ($result) {
            return redirect(route('admin.access_key_card'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function getSurvey(Request $request)
    {
        $survey = Survey::where('id', $request->id)->first();
        return $survey;
    }

    public function deleteSurvey(Request $request)
    {
        $result = Survey::find($request->surveyid)->delete();

        if ($result) {
            return redirect(route('admin.survey'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function getEmpolyee(Request $request)
    {

        $employee = Employee::with('images')->where('id', $request->id)->first();

        return $employee;
    }

    public function getFamilyMember(Request $request)
    {

        // $family=FamilyMember::with('images')->where('id', $request->id)->first();
        $family = user::with('images')->with('linkfamily')->where('id', $request->id)->first();

        return $family;
    }

    public function getCorporateIndividual(Request $request)
    {
        // $corporate=CorporateIndividual::where('id',$request->id)->first();
        $corporate = user::where('id', $request->id)->first();

        return $corporate;
    }

    public function getEvent(Request $request)
    {

        $event = Event::with('images')->where('id', $request->id)->first();

        return $event;
    }

    public function getClass(Request $request)
    {
        $class = ClassEvent::with('images')->where('id', $request->id)->first();
        return $class;
    }

    public function getFacility(Request $request)
    {
        $facility = Facility::with('images')->where('id', $request->id)->first();
        return $facility;
    }

    public function getHotel(Request $request)
    {
        $hotel = Hotel::with('images')->where('id', $request->id)->first();
        return $hotel;
    }

    public function getRestaurant(Request $request)
    {
        $restaurant = Restaurant::with('images')->where('id', $request->id)->first();
        return $restaurant;
    }

    public function getResort(Request $request)
    {
        $resort = Resort::with('images')->where('id', $request->id)->first();
        return $resort;
    }

    public function getProperty(Request $request)
    {
        $property = Property::with('images')->where('id', $request->id)->first();
        return $property;
    }

    public function getApartment(Request $request)
    {
        $apartment = Apartment::with('images')->where('id', $request->id)->first();
        return $apartment;
    }

    public function getMaintenanceRequest(Request $request)
    {
        $maintenance = MaintenanceRequest::with('users')->with('images')->where('id', $request->id)->first();
        return $maintenance;
    }

    public function getComplaints(Request $request)
    {
        $complaint = Complaint::with('images')->with('user')->where('id', $request->id)->first();
        return $complaint;
    }

    public function getCircular(Request $request)
    {
        $update = Update::where('id', $request->id)->first();
        return $update;
    }
    public function ajaxGetProperty(Request $request)
    {

        $department['data'] = Apartment::orderby('id', 'asc')
            ->select('id', 'name')
            ->where('property_id', $request->id)
            ->get();

        return response()->json($department);

    }

    public function deleteReview(Request $request)
    {

        $result = Review::find($request->id)->delete();

        if ($result) {
            return redirect()->back()->with('flash_success', 'Review Deleted Successfully!');

        }
    }

    public function deleteEventView(Request $request)
    {
        $result = Event::find($request->id)->delete();

        if ($result) {
            return redirect(route('admin.events'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }
    public function deleteClassView(Request $request)
    {
        $result = ClassEvent::find($request->id)->delete();

        if ($result) {
            return redirect(route('admin.classes'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function deleteFacilityView(Request $request)
    {
        $result = Facility::find($request->id)->delete();

        if ($result) {
            return redirect(route('admin.facilities'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function deleteHotelView(Request $request)
    {
        $result = Hotel::find($request->id)->delete();

        if ($result) {
            return redirect(route('admin.hotels'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function setNewsfeed(Request $request)
    {
        // $details=array(
        //     'status' => 0
        // );
        // $event=Event::where('id','!=',$request->id)->update($details);
        $details = array(
            'news_feed' => 1,
        );
        $event = Event::where('id', $request->id)->update($details);

        return redirect()->back()->with('flash_success', 'Newsfeed added Successfully!');

    }

    public function unsetNewsfeed(Request $request)
    {
        $details = array(
            'news_feed' => 0,
        );
        $event = Event::where('id', $request->id)->update($details);

        return redirect()->back()->with('flash_success', 'Newsfeed unset Successfully!');

    }

    public function setClassNewsfeed(Request $request)
    {

        $details = array(
            'news_feed' => 1,
        );
        $event = ClassEvent::where('id', $request->id)->update($details);

        return redirect()->back()->with('flash_success', 'Newsfeed added Successfully!');

    }

    public function unsetClassNewsfeed(Request $request)
    {
        $details = array(
            'news_feed' => 0,
        );
        $event = ClassEvent::where('id', $request->id)->update($details);

        return redirect()->back()->with('flash_success', 'Newsfeed unset Successfully!');

    }

    public function setFacilityNewsfeed(Request $request)
    {

        $details = array(
            'news_feed' => 1,
        );
        $event = Facility::where('id', $request->id)->update($details);

        return redirect()->back()->with('flash_success', 'Newsfeed added Successfully!');

    }

    public function unsetFacilityNewsfeed(Request $request)
    {
        $details = array(
            'news_feed' => 0,
        );
        $event = Facility::where('id', $request->id)->update($details);

        return redirect()->back()->with('flash_success', 'Newsfeed unset Successfully!');

    }

    public function setHotelNewsfeed(Request $request)
    {

        $details = array(
            'news_feed' => 1,
        );
        $event = Hotel::where('id', $request->id)->update($details);

        return redirect()->back()->with('flash_success', 'Newsfeed added Successfully!');

    }

    public function unsetHotelNewsfeed(Request $request)
    {
        $details = array(
            'news_feed' => 0,
        );
        $event = Hotel::where('id', $request->id)->update($details);

        return redirect()->back()->with('flash_success', 'Newsfeed unset Successfully!');

    }

    public function setRestaurantNewsfeed(Request $request)
    {

        $details = array(
            'news_feed' => 1,
        );
        $event = Restaurant::where('id', $request->id)->update($details);

        return redirect()->back()->with('flash_success', 'Newsfeed added Successfully!');

    }

    public function unsetRestaurantNewsfeed(Request $request)
    {
        $details = array(
            'news_feed' => 0,
        );
        $event = Restaurant::where('id', $request->id)->update($details);

        return redirect()->back()->with('flash_success', 'Newsfeed unset Successfully!');

    }

    public function setResortNewsfeed(Request $request)
    {

        $details = array(
            'news_feed' => 1,
        );
        $event = Resort::where('id', $request->id)->update($details);

        return redirect()->back()->with('flash_success', 'Newsfeed added Successfully!');

    }

    public function unsetResortNewsfeed(Request $request)
    {
        $details = array(
            'news_feed' => 0,
        );
        $event = Resort::where('id', $request->id)->update($details);

        return redirect()->back()->with('flash_success', 'Newsfeed unset Successfully!');

    }

    public function addFaq(Request $request)
    {
        if ($request->input('faq_id')) {
            $details = array(

                'questions' => $request->question,
                'answers' => $request->answer,
            );

            Faq::where('id', $request->faq_id)->update($details);
            return redirect(route('admin.alfardan_profile'))->with('flash_success', 'Record Updated Successfully!');

        } else {

            $details = array(

                'questions' => $request->question,
                'answers' => $request->answer,
            );

            $faq = Faq::create($details);
            return redirect(route('admin.alfardan_profile'))->with('flash_success', 'Record Added Successfully!');
        }
    }

    public function getFaq(Request $request)
    {
        $faq = Faq::where('id', $request->id)->first();
        return $faq;
    }

    public function deleteFaq(Request $request)
    {
        $result = Faq::find($request->faqid)->delete();

        if ($result) {
            return redirect(route('admin.alfardan_profile'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function alfardanProfile(Request $request)
    {
        $validated = $request->validate([
            'image' => 'mimes:jpeg,png,jpg|max:2048',
            'image1' => 'mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image') != '') {
            $file = $request->File('image');
            $image = Str::slug(time() . $file->getClientOriginalName());
            $img_resize = InterventionImage::make($file->getRealPath())
                ->orientate()->save(public_path('uploads/' . $image));
            // $destinationPath = public_path().'/uploads' ;
            // $file->move($destinationPath,$image);

            $detail = array(
                'photo' => $image,
            );
            AlfardanProfile::where('id', $request->profileid)->update($detail);
        }

        if ($request->hasFile('image1') != '') {
            $file = $request->File('image1');
            $image1 = Str::slug(time() . $file->getClientOriginalName());
            $img_resize = InterventionImage::make($file->getRealPath())
                ->orientate()->save(public_path('uploads/' . $image1));
            // $destinationPath = public_path().'/uploads' ;
            // $file->move($destinationPath,$image1);

            $detail = array(
                'photo1' => $image1,
            );
            AlfardanProfile::where('id', $request->profileid)->update($detail);
        }

        $details = array(

            'title' => $request->title,
            'title1' => $request->title1,
            'description' => $request->description,
            'description1' => $request->description1,

        );

        AlfardanProfile::where('id', $request->profileid)->update($details);

        return redirect(route('admin.alfardan_profile'))->with('flash_success', 'Record Updated Successfully!');
    }

    public function addPrivilegeBrochure(Request $request)
    {
        $request->validate([
            'brochure' => 'required|max:500000',
        ]);
        if ($request->hasFile('brochure') != '') {
            $file = $request->File('brochure');
            $brochure = Str::slug(time() . $file->getClientOriginalName());
            $destinationPath = public_path() . '/uploads';
            $file->move($destinationPath, $brochure);

            $detail = array(
                'file' => $brochure,
            );
            PrivilegeProgram::where('id', $request->privilegeid)->update($detail);
            return redirect(route('admin.privilege_program'))->with('flash_success', 'Record Updated Successfully!');
        }
    }

    public function deleteRestaurantView(Request $request)
    {
        $result = Restaurant::find($request->id)->delete();

        if ($result) {
            return redirect(route('admin.restaurants'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function deleteResortView(Request $request)
    {
        $result = Resort::find($request->id)->delete();

        if ($result) {
            return redirect(route('admin.wellness'))->with('flash_success', 'Record Deleted Successfully!');
        }
    }
    public function getFamilyRequest(Request $request)
    {

        $family = FamilyMember::with('user')->where('id', $request->id)->first();

        return $family;
    }

    public function addFamilyRequest(Request $request)
    {

        if ($request->input('familymemberid')) {

            $details = array(

                'name' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone,
            );

            $result = FamilyMember::where('id', $request->familymemberid)->update($details);

            return redirect()->back()->with('flash_success', 'Record Updated Successfully!');
        }
    }

    public function getTenantFamily(Request $request)
    {

        $family = FamilyMember::where('id', $request->id)->first();

        return $family;
    }
    public function deleteTenantFamily(Request $request)
    {
        $result = FamilyMember::find($request->fmid)->delete();

        if ($result) {
            return redirect()->back()->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function addTenantHandbook(Request $request)
    {
        $validated = $request->validate([
            'handbook' => 'mimes:pdf|max:8000',
            'safety' => 'mimes:pdf|max:8000',
            'brochure' => 'mimes:pdf|max:8000',

        ]);
        if ($request->input('submit')) {

            if ($request->hasFile('handbook') != '') {
                $file = $request->File('handbook');
                $handbook = Str::slug(time() . $file->getClientOriginalName());
                $destinationPath = public_path() . '/uploads';
                $file->move($destinationPath, $handbook);

                $details = array(

                    'handbook' => $handbook,

                );
                Property::where('id', $request->input('propertyid'))->update($details);
            }
            if ($request->hasFile('safety') != '') {
                $file = $request->File('safety');
                $safety = Str::slug(time() . $file->getClientOriginalName());
                $destinationPath = public_path() . '/uploads';
                $file->move($destinationPath, $safety);

                $details = array(

                    'safety' => $safety,

                );
                Property::where('id', $request->input('propertyid'))->update($details);
            }
            if ($request->hasFile('brochure') != '') {
                $file = $request->File('brochure');
                $brochure = Str::slug(time() . $file->getClientOriginalName());
                $destinationPath = public_path() . '/uploads';
                $file->move($destinationPath, $brochure);

                $details = array(

                    'brochure' => $brochure,

                );
                Property::where('id', $request->input('propertyid'))->update($details);
            }

            return redirect()->back()->with('flash_success', 'Record Updated Successfully!');
        }
    }

    public function getSellRequest(Request $request)
    {
        $product = Product::with('seller')->with('category')->where('id', $request->id)->first();
        return $product;
    }

    public function updateSellRequest(Request $request)
    {
        if ($request->input('publish')) {
            $status = 1;
        } elseif ($request->input('draft')) {
            $status = 0;
        }
        $details = array(

            'status' => $status,
        );

        Product::where('id', $request->productid)->update($details);
        $product = Product::find($request->productid);

        if ($request->input('publish')) {
            if ($product) {

                $notification = new Notification();
                $title = "";
                $type = 1997;

                $title = $product->name;

                $message = 'Your listing ' . $title . ' is';
                if ($product->status == 1) {
                    $message = $message . " Approved";
                } else {
                    $message = $message . " Rejected";
                }

                $notification = new Notification();

                $details = array(
                    'serivec_id' => $product->id,
                    'type' => $type,
                    'user_id' => $product->user_id,
                    'status' => 1,
                    'title' => $title,
                    'message' => $message,
                );

                $notification->create($details);
                NotificationHelper::pushnotification($title, $message, $product->user_id, $type);
            }
        }

        return redirect()->back()->with('flash_success', 'Record Updated Successfully!');
    }

    public function deleteSellRequest(Request $request)
    {
        Product::where('id', $request->proid)->delete();
        return redirect()->back()->with('flash_success', 'Record Deleted Successfully!');
    }
    public function draftProperty(Request $request)
    {

        $detail = array(
            'status' => 'draft',
        );
        Property::find($request->id)->update($detail);
        return redirect()->back()->with('flash_success', 'Property Draft Successfully!');
    }

    public function becomeTenant()
    {
        $tenant = BecomeTenant::all();
        return view('admin.become_tenant')
            ->with('tenants', $tenant);
    }

    public function updateBecomeTenant(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'bedrooms' => 'required|integer',
            'message' => 'required',

        ]);
        if ($request->input('userid')) {
            $details = array(

                'fullname' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'bedrooms' => $request->bedrooms,
                'message' => $request->message,
            );

            BecomeTenant::where('id', $request->userid)->update($details);
            return redirect()->back()->with('flash_success', 'Record Updated Successfully!');

        }

    }

    public function importApartments(Request $request)
    {
        $validated = $request->validate([
            // 'property'    => 'required',
            'file' => 'required|mimes:xlsx|max:8000',

        ]);
        $file = new ApartmentsImport();
        $file->status = $request->input('status') == 'Publish' ? 1 : 0;
        $return = Excel::import($file, request()->file('file'));
        return back();
    }
    public function getBecomeTenant(Request $request)
    {
        $tenant = BecomeTenant::where('id', $request->id)->first();
        return $tenant;
    }

    public function deleteBecomeTenant(Request $request)
    {
        $result = BecomeTenant::find($request->tenant_id)->delete();

        if ($result) {
            return redirect()->back()->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function tenantRegistration()
    {
        $properties = Property::all();

        $apartments = Apartment::all();
        $tenant = TenantRegistration::orderby('id', 'desc')->paginate(10);
        return view('admin.tenant_registration')
            ->with('properties', $properties)
            ->with('apartments', $apartments)
            ->with('tenants', $tenant);
    }

    public function addTenantRegistration(Request $request)
    {
        $this->validate($request, TenantRegistration::getRules());
        TenantRegistration::create($request->all());
        return redirect()->back()->with('flash_success', 'Record added Successfully!');

    }

    public function getTenantRegistration(Request $request)
    {
        return $tenant = TenantRegistration::where('id', $request->id)->first();
    }

    public function updateTenantRegistration(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:190',
            'property_id' => 'required|integer',
            'apartment_id' => 'required|integer',
            'dob' => 'required|string|max:190',
            'email' => Rule::unique('tenant_registrations')->ignore($request->userid, 'id'),
            'emergency_contact' => 'required|string|max:190',
            'nationality' => 'required|string|max:190',
            'occupants' => 'required|integer',
            'occupant_name' => 'required|string|max:190',

        ]);
        if ($request->input('userid')) {
            $details = array(

                'name' => $request->name,
                'property_id' => $request->property_id,
                'apartment_id' => $request->apartment_id,
                'dob' => $request->dob,
                'email' => $request->email,
                'emergency_contact' => $request->emergency_contact,
                'nationality' => $request->nationality,
                'occupants' => $request->occupants,
                'occupant_name' => $request->occupant_name,

            );

            TenantRegistration::where('id', $request->userid)->update($details);
            return redirect()->back()->with('flash_success', 'Record updated Successfully!');

        }

    }

    public function deleteTenantRegistration(Request $request)
    {
        $result = TenantRegistration::find($request->tenant_id)->delete();

        if ($result) {
            return redirect()->back()->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function tenantExport()
    {
        return Excel::download(new TenantExport, 'tenant.xlsx');
    }

    public function artGallery()
    {
        $properties = Property::all();
        $art = ArtGallery::orderby('id', 'desc')->paginate(10);
        return view('admin.art_gallery')
            ->with('properties', $properties)
            ->with('arts', $art);

    }

    public function offerUpdates()
    {
        $properties = Property::all();
        $offer = OfferUpdate::orderby('id', 'desc')->paginate(10);
        $hotels = Hotel::all();
        $restaurants = Restaurant::all();
        $resorts = Resort::all();

        return view('admin.offers_updates')
            ->with('properties', $properties)
            ->with('offers', $offer)
            ->with('hotels', $hotels)
            ->with('restaurants', $restaurants)
            ->with('resorts', $resorts);
    }

    public function artGalleryview($id)
    {
        $art = ArtGallery::where('id', $id)->first();
        //$addart=Art::with('gallery')->orderby('id','desc')->paginate(10);
        return view('admin.art_gallery_view')
            ->with('art', $art);
        //  ->with('addart',$addart);

    }

    public function addArtGallery(Request $request)
    {
        $this->validate($request, ArtGallery::getRules());

        $input = $request->all();

        $tenant_type = $request->has('tenant_type') ? implode(",", $request->input('tenant_type')) : '';
        $property = $request->has('property_id') ? implode(",", $request->input('property_id')) : '';

        if ($request->input('publish')) {
            $status = 1;
        } elseif ($request->input('draft')) {
            $status = 0;
        }

        $input['tenant_type'] = $tenant_type;
        $input['property_id'] = $property;
        $input['status'] = $status;

        if ($request->hasFile('image') != '') {
            $file = $request->File('image');
            $image = Str::slug(time() . $file->getClientOriginalName());
            $img_resize = InterventionImage::make($file->getRealPath())
                ->orientate()->save(public_path('uploads/' . $image));
            $input['photo'] = $image;

        }

        ArtGallery::create($input);
        return redirect()->back()->with('flash_success', 'Record added Successfully!');
    }

    public function getArtGallery(Request $request)
    {
        $result = ArtGallery::where('id', $request->id)->first();
        return $result;

    }
    public function updateArtGallery(Request $request)
    {
        if ($request->input('artid')) {

            $this->validate($request, ArtGallery::getRules());
            $tenant_type = $request->has('tenant_type') ? implode(",", $request->input('tenant_type')) : '';
            $property = $request->has('property_id') ? implode(",", $request->input('property_id')) : '';

            if ($request->input('publish')) {
                $status = 1;
            } elseif ($request->input('draft')) {
                $status = 0;
            }

            if ($request->hasFile('image') != '') {
                $file = $request->File('image');
                $image = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image));
                $detail = array(
                    'photo' => $image,
                );
                ArtGallery::where('id', $request->artid)->update($detail);
            }

            $details = array(

                'name' => $request->name,
                'phone' => $request->phone,
                'location' => $request->location,
                'description' => $request->description,
                'view_link' => $request->view_link,
                'property_id' => $property,
                'tenant_type' => $tenant_type,
                'status' => $status,

            );
            ArtGallery::where('id', $request->artid)->update($details);
            return redirect()->back()->with('flash_success', 'Record updated Successfully!');
        }
    }

    public function deleteArtGallery(Request $request)
    {

        $result = ArtGallery::find($request->artid)->delete();

        if ($result) {
            return redirect()->back()->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function addArt(Request $request)
    {
        $this->validate($request, Art::getRules());
        $totalart = Art::where('art_gallery_id', $request->art_gallery_id)->count();

        if ($totalart >= 9) {
            return redirect()->back()->with('flash_error', 'Limit exceeded only 9 art can upload!');
        }
        if ($request->input('publish')) {
            $status = 1;
        } elseif ($request->input('draft')) {
            $status = 0;
        }
        if ($request->hasFile('photo')) {
            $file = $request->File('photo');
            $photo = Str::slug(time() . $file->getClientOriginalName());
            $img_resize = InterventionImage::make($file->getRealPath())
                ->orientate()->save(public_path('uploads/' . $photo));
            // $destinationPath = public_path().'/uploads' ;
            // $file->move($destinationPath,$menu4);
        } else {
            $photo = '';
        }
        if ($request->hasFile('photo1')) {
            $file = $request->File('photo1');
            $photo1 = Str::slug(time() . $file->getClientOriginalName());
            $img_resize = InterventionImage::make($file->getRealPath())
                ->orientate()->save(public_path('uploads/' . $photo1));
            // $destinationPath = public_path().'/uploads' ;
            // $file->move($destinationPath,$menu4);
        } else {
            $photo1 = '';
        }
        if ($request->hasFile('photo2')) {
            $file = $request->File('photo2');
            $photo2 = Str::slug(time() . $file->getClientOriginalName());
            $img_resize = InterventionImage::make($file->getRealPath())
                ->orientate()->save(public_path('uploads/' . $photo2));
            // $destinationPath = public_path().'/uploads' ;
            // $file->move($destinationPath,$menu4);
        } else {
            $photo2 = '';
        }
        if ($request->hasFile('photo3')) {
            $file = $request->File('photo3');
            $photo3 = Str::slug(time() . $file->getClientOriginalName());
            $img_resize = InterventionImage::make($file->getRealPath())
                ->orientate()->save(public_path('uploads/' . $photo3));
            // $destinationPath = public_path().'/uploads' ;
            // $file->move($destinationPath,$menu4);
        } else {
            $photo3 = '';
        }
        if ($request->hasFile('photo4')) {
            $file = $request->File('photo4');
            $photo4 = Str::slug(time() . $file->getClientOriginalName());
            $img_resize = InterventionImage::make($file->getRealPath())
                ->orientate()->save(public_path('uploads/' . $photo4));
            // $destinationPath = public_path().'/uploads' ;
            // $file->move($destinationPath,$menu4);
        } else {
            $photo4 = '';
        }
        $details = array(
            'name' => $request->name,
            'artist_name' => $request->artist_name,
            'submission' => $request->submission,
            'description' => $request->description,
            'art_gallery_id' => $request->art_gallery_id,
            'photo' => $photo,
            'photo1' => $photo1,
            'photo2' => $photo2,
            'photo3' => $photo3,
            'photo4' => $photo4,
            'status' => $status,
        );

        Art::create($details);
        return redirect()->back()->with('flash_success', 'Record added Successfully!');

    }

    public function getArt(Request $request)
    {
        $art = Art::where('id', $request->id)->first();
        return $art;

    }
    public function updateArt(Request $request)
    {
        $this->validate($request, Art::getRules());
        if ($request->input('artid')) {
            if ($request->input('publish')) {
                $status = 1;
            } elseif ($request->input('draft')) {
                $status = 0;
            }
            if ($request->hasFile('photo')) {
                $file = $request->File('photo');
                $photo = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $photo));

                $detail = array(

                    'photo' => $photo,
                );
                Art::where('id', $request->artid)->update($detail);
            }

            if ($request->hasFile('photo1')) {
                $file = $request->File('photo1');
                $photo1 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $photo1));
                $detail = array(

                    'photo1' => $photo1,
                );
                Art::where('id', $request->artid)->update($detail);

            }

            if ($request->hasFile('photo2')) {
                $file = $request->File('photo2');
                $photo2 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $photo2));
                $detail = array(

                    'photo2' => $photo2,
                );
                Art::where('id', $request->artid)->update($detail);
            }

            if ($request->hasFile('photo3')) {
                $file = $request->File('photo3');
                $photo3 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $photo3));
                $detail = array(

                    'photo3' => $photo3,
                );
                Art::where('id', $request->artid)->update($detail);
            }

            if ($request->hasFile('photo4')) {
                $file = $request->File('photo4');
                $photo4 = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $photo4));
                $detail = array(

                    'photo4' => $photo4,
                );
                Art::where('id', $request->artid)->update($detail);
            } else {
                $photo4 = '';
            }
            $details = array(
                'name' => $request->name,
                'artist_name' => $request->artist_name,
                'submission' => $request->submission,
                'description' => $request->description,
                'art_gallery_id' => $request->art_gallery_id,
                'status' => $status,
            );

            Art::where('id', $request->artid)->update($details);
            return redirect()->back()->with('flash_success', 'Record updated Successfully!');
        }
    }

    public function deleteArt(Request $request)
    {
        $result = Art::find($request->artid)->delete();

        if ($result) {
            return redirect()->back()->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function addOffers(Request $request)
    {
        $this->validate($request, OfferUpdate::getRules());

        $input = $request->all();

        $tenant_type = $request->has('tenant_type') ? implode(",", $request->input('tenant_type')) : '';
        $property = $request->has('property_id') ? implode(",", $request->input('property_id')) : '';

        if ($request->input('publish')) {
            $status = 1;
        } elseif ($request->input('draft')) {
            $status = 0;
        }

        $input['tenant_type'] = $tenant_type;
        $input['property_id'] = $property;
        $input['status'] = $status;

        if ($request->hasFile('image') != '') {
            $file = $request->File('image');
            $image = Str::slug(time() . $file->getClientOriginalName());
            $img_resize = InterventionImage::make($file->getRealPath())
                ->orientate()->save(public_path('uploads/' . $image));
            $input['photo'] = $image;

        }

        $offer = OfferUpdate::create($input);
        //userpropertyrelation
        $property_id = $request->input('property_id');
        $users = User::wherein("tenant_type", $request->input('tenant_type'));
        $users->whereHas('userpropertyrelation', function ($qry) use ($property_id) {
            $qry->wherein('property_id', $property_id);
        });
        $users = $users->get();
        //dd($users);

        if ($request->input('publish')) {
            $notification = new Notification();
            $title = $offer->title;
            $type = 1999;
            $message = 'A new offer is added.';
            $details = array(
                'serivec_id' => $offer->id,
                'type' => $type,
                'user_id' => 0,
                'status' => 1,
                'title' => $title,
                'message' => $message,
            );
            foreach ($users as $user) {
                $notification = new Notification();
                $details['user_id'] = $user->id;

                $notification->create($details);
                NotificationHelper::pushnotification($title, $message, $user->id, $type);
            }
        }

        return redirect()->back()->with('flash_success', 'Record added Successfully!');
    }

    public function getOffers(Request $request)
    {
        $offers = OfferUpdate::where('id', $request->id)->first();
        return $offers;

    }
    public function updateOffers(Request $request)
    {
        $this->validate($request, OfferUpdate::getRules());
        if ($request->input('offerid')) {

            $this->validate($request, OfferUpdate::getRules());
            $tenant_type = $request->has('tenant_type') ? implode(",", $request->input('tenant_type')) : '';
            $property = $request->has('property_id') ? implode(",", $request->input('property_id')) : '';

            if ($request->input('publish')) {
                $status = 1;
            } elseif ($request->input('draft')) {
                $status = 0;
            }

            if ($request->hasFile('image') != '') {
                $file = $request->File('image');
                $image = Str::slug(time() . $file->getClientOriginalName());
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $image));
                $detail = array(
                    'photo' => $image,
                );
                OfferUpdate::where('id', $request->offerid)->update($detail);
            }

            $details = array(

                'title' => $request->title,
                'type' => $request->type,
                'link' => $request->link,
                'submission' => $request->submission,
                'description' => $request->description,
                'property_id' => $property,
                'tenant_type' => $tenant_type,
                'status' => $status,
                'data_id' => $request->data_id,

            );
            OfferUpdate::where('id', $request->offerid)->update($details);
            return redirect()->back()->with('flash_success', 'Record updated Successfully!');
        }
    }

    public function deleteOffers(Request $request)
    {
        $result = OfferUpdate::find($request->offerid)->delete();
        if ($result) {
            return redirect()->back()->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function offerView($id)
    {
        $offer = OfferUpdate::where('id', $id)->first();
        return view('admin.offer_view')
            ->with('offer', $offer);

    }

    public function addNewsFeed(Request $request)
    {
        $this->validate($request, NewsFeed::getRules());
        if ($request->hasFile('image') != '') {
            $file = $request->File('image');
            $image = Str::slug(time() . $file->getClientOriginalName());
            $img_resize = InterventionImage::make($file->getRealPath())
                ->orientate()->save(public_path('uploads/' . $image));
            $detail = array(
                'photo' => $image,
            );
            NewsFeed::where('id', $request->newsfeedid)->update($detail);
        }

        if ($request->hasFile('image1') != '') {
            $file = $request->File('image1');
            $image1 = Str::slug(time() . $file->getClientOriginalName());
            $img_resize = InterventionImage::make($file->getRealPath())
                ->orientate()->save(public_path('uploads/' . $image1));

            $detail = array(
                'photo1' => $image1,
            );
            NewsFeed::where('id', $request->newsfeedid)->update($detail);
        }
        if ($request->hasFile('image2') != '') {
            $file = $request->File('image2');
            $image2 = Str::slug(time() . $file->getClientOriginalName());
            $img_resize = InterventionImage::make($file->getRealPath())
                ->orientate()->save(public_path('uploads/' . $image2));

            $detail = array(
                'photo2' => $image2,
            );
            NewsFeed::where('id', $request->newsfeedid)->update($detail);
        }
        $details = array(
            'description' => $request->description,

        );

        NewsFeed::where('id', $request->newsfeedid)->update($details);

        return redirect()->back()->with('flash_success', 'Record Updated Successfully!');
    }

    public function maintenanceChat()
    {

        $chat = ChatView::where('type', 'maintenance')->orderby('messagesid', 'desc')->get();
        // $chat=Chat::join('users','users.id','=','chats.user2_id')
        // ->join('messages','messages.chat_id','=','chats.id')
        // ->where('chats.type','=','maintenance')
        // ->select('chats.user2_id','chats.type as chat_type','users.type','users.full_name','users.profile','chats.id as chat_id','messages.*','messages.created_at as message_date','messages.id as msg_id')
        // ->orderby('messages.created_at','desc')
        // ->groupBy('messages.chat_id')
        // ->get();
        // ->values()
        // ->all();
        // echo $chat->toSql();
        // echo "<pre>";
        // print_r($chat);
        // exit;
        return view('admin.maintenance_chat')
            ->with('chats', $chat);
    }

    public function conciergeChat()
    {
        $chat = ChatView::where('type', 'concierge')->orderby('messagesid', 'desc')->get();
        return view('admin.concierge_chat')
            ->with('chats', $chat);
    }

    public function customerServiceChat()
    {
        $chat = ChatView::where('type', 'customer_service')->orderby('messagesid', 'desc')->get();
        return view('admin.customer_service_chat')
            ->with('chats', $chat);
    }

    public function chatHistory(Request $request)
    {
        $chat_history = Chat::where('id', $request->id)->get();
        // echo "<pre>";
        // print_r($chat_history);
        // exit;
        $view = view('admin.chat_view')
            ->with('chat_histories', $chat_history)->render();
        return response()->json(['html' => $view]);

    }

    public function sendMessage(Request $request)
    {
        if ($request->File('file') == '') {

            $request->validate([
                'message' => 'required|string',
                // 'file' => 'mimes:jpeg,png,jpg,gif|max:2048'
            ]);
        }
        // $notification=new Notification();
        //$message= 'New Message From Admin';
        // $details=array(
        //     'user_id'    => $request->user_id,
        //     'type'        => 3,
        //     'title'       => $title,
        //     'message'     => $message
        // );
        if ($request->type == 'maintenance') {
            $type = 13;

        } elseif ($request->type == 'concierge') {
            $type = 14;

        } elseif ($request->type == 'customer_service') {
            $type = 15;

        }
        // $notification->create($details);
        $title = 'Alfardan Living';
        if ($request->hasFile('file')) {
            $file = $request->File('file');
            $photo = Str::slug(time() . $file->getClientOriginalName());
            $img_resize = InterventionImage::make($file->getRealPath())
                ->orientate()->save(public_path('uploads/' . $photo));

            $detail = array(

                'file' => $photo,
                'sender_id' => 1,
                'receiver_id' => $request->user_id,
                'chat_id' => $request->chat_id,
                'text' => $request->message,
            );
            $response = Message::create($detail);
            NotificationHelper::pushnotification($title, $request->message, $request->user_id, $type);
            return response()->json([
                'uploaded_image' => '<img src="' . $response->file . '" class="img-thumbnail" style="width: 100px;float: right;" />',
            ]);
        } else {

            $detail = array(
                'sender_id' => 1,
                'receiver_id' => $request->user_id,
                'chat_id' => $request->chat_id,
                'text' => $request->message,
            );
            Message::create($detail);
            NotificationHelper::pushnotification($title, $request->message, $request->user_id, $type);
            return response()->json(['success' => 'Message Sent Successfully']);
        }
        // return redirect()->back()->with('flash_success', 'Message Send Successfully!');
    }

    public function maintenancechatSearch(Request $request)
    {

        $chat = Chat::join('users', 'users.id', '=', 'chats.user2_id')
            ->join('messages', 'messages.chat_id', '=', 'chats.id');
        if ($request->keyword != '') {
            $chat->where('users.full_name', 'LIKE', '%' . $request->keyword . '%');

        }
        $chat->where('chats.type', '=', 'maintenance');
        $chat->select('chats.*', 'users.*', 'chats.id as chat_id', 'messages.*', 'messages.created_at as message_date');
        $chat->groupBy('messages.chat_id');

        return response()->json([
            'users' => $chat->get(),
        ]);

    }

    public function conciergechatSearch(Request $request)
    {

        $chat = Chat::join('users', 'users.id', '=', 'chats.user2_id')
            ->join('messages', 'messages.chat_id', '=', 'chats.id');
        if ($request->keyword != '') {
            $chat->where('users.full_name', 'LIKE', '%' . $request->keyword . '%');

        }
        $chat->where('chats.type', '=', 'concierge');
        $chat->select('chats.*', 'users.*', 'chats.id as chat_id', 'messages.*', 'messages.created_at as message_date');
        $chat->groupBy('messages.chat_id');

        return response()->json([
            'users' => $chat->get(),
        ]);

    }

    public function customerchatSearch(Request $request)
    {

        $chat = Chat::join('users', 'users.id', '=', 'chats.user2_id')
            ->join('messages', 'messages.chat_id', '=', 'chats.id');
        if ($request->keyword != '') {
            $chat->where('users.full_name', 'LIKE', '%' . $request->keyword . '%');

        }
        $chat->where('chats.type', '=', 'customer_service');
        $chat->select('chats.*', 'users.*', 'chats.id as chat_id', 'messages.*', 'messages.created_at as message_date');
        $chat->groupBy('messages.chat_id');

        return response()->json([
            'users' => $chat->get(),
        ]);

    }
    public function getFamilyTenant(Request $request)
    {

        $tenant = User::where('id', $request->id)->first();

        return $tenant;
    }
    public function editFamilyTenant(Request $request)
    {

        if ($request->input('familymemberid')) {

            $details = array(

                'full_name' => $request->username,
                // 'email'         =>$request->email,
                // 'phone_number'  =>$request->phone,
            );

            $result = User::where('id', $request->familymemberid)->update($details);

            return redirect()->back()->with('flash_success', 'Record Updated Successfully!');
        }
    }

    public function deleteFamilyTenant(Request $request)
    {
        $result = User::find($request->fmid)->delete();

        if ($result) {
            return redirect()->back()->with('flash_success', 'Record Deleted Successfully!');
        }
    }

    public function concierge()
    {
        $concierge = Concierge::first();
        return view('admin.concierge')
            ->with('concierge', $concierge);
    }

    public function addConciergeBanner(Request $request)
    {
        $validated = $request->validate([
            'banner' => 'required|mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($request->hasFile('banner')) {
            Concierge::where('id', $request->id)->delete();

            $file = $request->File('banner');
            $banner = Str::slug(time() . $file->getClientOriginalName());
            $img_resize = InterventionImage::make($file->getRealPath())
                ->orientate()->save(public_path('uploads/' . $banner));

            $detail = array(
                'banner' => $banner,
            );
            Concierge::create($detail);

            return redirect()->back()->with('flash_success', 'Record Updated Successfully!');
        }
    }

    public function deleteConciergeBanner($id)
    {
        Concierge::where('id', $id)->delete();

        return redirect()->back()->with('flash_success', 'Record Deleted Successfully!');

    }
    public function adminTest()
    {
        // if(\Auth::guard('admin')->user()->hasRole('admin')){
        //     dd('only admin allowed');
        // }

        if (\Gate::forUser(\Auth::guard('admin')->user())->allows('admin')) {
            dd('only admin allowed');
        }
        abort(403);
    }

    public function editorTest()
    {
        if (\Auth::guard('admin')->user()->hasRole('editor')) {
            dd('only editor allowed');
        }
        abort(403);
    }

    public function chatrefresh($id, Request $request)
    {
        $chat_history = Chat::where('id', $id)->get();

        $maxid = $chat_history[0]->messages()->max('id');
        $view = "";
        if ($request->maxid < $maxid) {
            $view = view('admin.chat_histories')->with('chat_histories', $chat_history)->render();
        }

        return response()->json(['html' => $view, 'maxid' => $maxid]);
    }

    public function ClassSlot($classid, $slot = null, Request $request)
    {

        $validated = $request->validate(ClassSlot::$rules);

        if ($slot) {
            $classslot = ClassSlot::find($slot);
        } else {
            $classslot = new ClassSlot();
        }
        $classslot->class_id = $classid;
        $classslot->time = $request->time;
        $classslot->seats_available = $request->seats_available;
        $classslot->days = $request->days;
        $classslot->status = $request->status;

        $classslot->save();

        if ($slot) {
            return redirect()->back()->with('flash_success', 'Record Updated Successfully!');
        } else {
            return redirect()->back()->with('flash_success', 'Record saved Successfully!');
        }
    }

    public function propertygallery($id, Request $request)
    {

        $files = $request->file('files');

        if ($request->hasFile('files')) {
            foreach ($files as $key => $file) {
                $name = time() . '-' . $id . '-' . $key . '.' . $file->extension();
                $file->storeAs('', $name, 'uploads');

                $img = new PropertyGallery();
                $img->property_id = $id;
                $img->image_url = 'uploads/' . $name;
                $img->name = $file->getClientOriginalName();
                $img->save();
            }
        }
        return back();
    }

    public function propertygallerydelete($id)
    {
        $img = PropertyGallery::findOrFail($id);
        $img->delete();
        return redirect()->back()->with('flash_success', 'Record deleted Successfully!');
    }

    public function property3ddelete($id)
    {
        $img = Property3dview::findOrFail($id);
        $img->delete();
        return redirect()->back()->with('flash_success', 'Record deleted Successfully!');
    }

    public function property3dadd($id, Request $request)
    {
        $data = $request->all();
        $img = new Property3dview();
        $img->property_id = $id;
        $img->name = $request->input('name');
        $img->url = $request->input('url');
        $img->save();
        return redirect()->back()->with('flash_success', 'Record Saved Successfully!');
    }

    public function property3dupdate($id, $imgid, Request $request)
    {
        $data = $request->all();
        $img = Property3dview::findOrFail($imgid);
        $img->name = $request->input('name');
        $img->url = $request->input('url');
        $img->save();
        return redirect()->back()->with('flash_success', 'Record Updated Successfully!');
    }

    public function updatebooking(Request $request)
    {
        if ($request->has('booking_id')) {
            if ($request->booking_id > 0) {
                $booking = Booking::findOrFail($request->booking_id);
                $booking->reservations = $request->input('reservations', $booking->reservations);
                $booking->status = $request->input('status', $booking->status);
                if ($request->has('slot_id')) {
                    $booking->slot_id = $request->input('slot_id', $booking->slot_id);
                } else {
                    $booking->date = $request->input('date', $booking->date);
                    $booking->time = $request->input('time', $booking->time);
                }
                $booking->save();

                if ($booking->status > 0 && ($booking->slot_id != 0 || !is_null($booking->event_id) || !is_null($booking->facility_id))) {

                    $notification = new Notification();
                    $title = "";
                    $type = 1024;
                    if ($booking->slot_id != 0) {
                        $type = 1994;
                        $title = $booking->class->name;
                    } else if (!is_null($booking->facility_id)) {
                        $type = 1995;

                        $title = $booking->facility->name;

                    } else if (!is_null($booking->event_id)) {
                        $type = 1996;

                        $title = $booking->event->name;
                    }

                    $message = 'Your request for ' . $title . ' is';
                    if ($booking->status == 1) {
                        $message = $message . " Approved";
                    } else {
                        $message = $message . " Rejected";
                    }

                    $notification = new Notification();

                    $details = array(
                        'serivec_id' => $booking->id,
                        'type' => $type,
                        'user_id' => $booking->user_id,
                        'status' => 1,
                        'title' => $title,
                        'message' => $message,
                    );

                    $notification->create($details);
                    NotificationHelper::pushnotification($title, $message, $booking->user_id, $type);
                }
                return redirect()->back()->with('flash_success', 'Record Updated Successfully!');
            }
        }
    }

    public function apartmentslist(Request $request)
    {
        $ids = $request->ids;
        if (is_array($ids)) {
            $apartments = Apartment::where("status", 1)->wherein("property_id", $ids)->get();
        } else {
            $apartments = Apartment::where("status", 1)->get();
        }
        return response()->json($apartments);
    }

    public function deletebooking($booking_id)
    {

        $booking = Booking::findOrFail($booking_id);
        $booking->delete();
        return redirect()->back()->with('flash_success', 'Booking Remove Successfully!');

    }

    public function deleteslot($booking_id)
    {

        $booking = ClassSlot::findOrFail($booking_id);
        $booking->delete();
        return redirect()->back()->with('flash_success', 'Slot Remove Successfully!');

    }

    public function deleteimage($id)
    {
        $image = Image::findOrFail($id);
        //dd($image);

        $image->delete();
        return redirect()->back()->with('flash_success', 'Image deleted Successfully!');
    }

    public function deleteartimage($id, $image)
    {
        $art = Art::findOrFail($id);
        if (\Schema::hasColumn($art->getTable(), $image)) {
            $art->$image = null;
            $art->save();
            return redirect()->back()->with('flash_success', 'Image deleted Successfully!');

        } else {
            abort(404);
        }
    }

    public function deletemenu($id, $menu)
    {
        $restaurant = Restaurant::findOrFail($id);

        if (\Schema::hasColumn($restaurant->getTable(), $menu)) {
            $restaurant->$menu = null;
            $restaurant->save();
            return redirect()->back()->with('flash_success', $restaurant->name . ' Restaurant Menu deleted Successfully!');

        } else {
            abort(404);
        }
    }

    public function deleteartphoto($id)
    {
        $art = ArtGallery::findOrFail($id);

        $art->photo = null;
        $art->save();
        return redirect()->back()->with('flash_success', $art->name . ' Image deleted Successfully!');
    }

    public function deleteofferphoto($id)
    {
        $art = OfferUpdate::findOrFail($id);

        $art->photo = null;
        $art->save();
        return redirect()->back()->with('flash_success', $art->name . ' Image deleted Successfully!');
    }

    public function deleteprofilephoto($id, $photo)
    {
        $art = AlfardanProfile::findOrFail($id);

        if (\Schema::hasColumn($art->getTable(), $photo)) {
            $art->$photo = null;
            $art->save();
            return redirect()->back()->with('flash_success', $art->name . ' Image deleted Successfully!');

        } else {
            abort(404);
        }

    }

    public function deleteuserprofilephoto($id)
    {
        $art = User::findOrFail($id);

        $art->profile = null;
        $art->save();
        return redirect()->back()->with('flash_success', $art->name . ' Image deleted Successfully!');

    }

    public function send_forgot_password_link(Request $request)
    {

        $validated = $request->validate([
            'email' => 'required|exists:employees,email',
        ]);
        $employe = Employee::where('email', $request->input('email'))->first();

        $password = Str::random(8);
        $hashed = Hash::make($password);
        Mail::send(
            'emailtemplate.forgotpassword',
            [
                'password' => $password,
                'name' => $employe->name,

            ],
            function ($message) use ($employe) {
                $message->to($employe->email)->subject(' New Tenant Registration');
            }
        );
        $employe->password = $hashed;
        $employe->save();
        return redirect()->back()->with('flash_success', ' New Password has been sent to your email address');

    }

    public function settings()
    {

        return view('admin.reset_password');
    }
    public function updatepassword(Request $request)
    {
        $validated = $request->validate([
            'oldpassword' => 'required',
            'password' => [
                'required',
                'min:8',
                'confirmed',
            ],
        ]);
        $employe = \Auth::guard('admin')->user();

        if (!Hash::check($request->oldpassword, $employe->password)) {
            return back()->with('flash_error', "please check old password");
        }

        $hashed = Hash::make($request->password);
        $employe->password = $hashed;
        $employe->save();
        return redirect()->back()->with('flash_success', ' Your Password has been updated Successfully');
    }

}
