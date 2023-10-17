<?php

use App\Models\ArtGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\ResortController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\ClassController;
use App\Http\Controllers\Api\FacilityController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\MaintenanceController;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\ApartmentController;
use App\Http\Controllers\Api\PrivilegeController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\UpdatesController;
use App\Http\Controllers\Api\ComplaintController;
use App\Http\Controllers\Api\SurveyController;
use App\Http\Controllers\Api\ConciergeController;
use App\Http\Controllers\Api\FamilyMemberController;
use App\Http\Controllers\Api\BecomeTenantController;
use App\Http\Controllers\Api\TenantRegistrationController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('check/family/member', [AuthController::class, 'checkFamilyMember']);
Route::post('forgotPassword', [AuthController::class, 'forgotPassword']);
Route::post('become/tenant', [BecomeTenantController::class, 'store']);

Route::get('send-phone-verification-code', [AuthController::class, 'sendPhoneVerificationCode']);

Route::get('guest/home', [HomeController::class, 'guestCategories']);

Route::get('hotel/{id}', [HotelController::class, 'show']);

Route::get('restaurant/{id}', [RestaurantController::class, 'show']);

Route::get('resort/{id}', [ResortController::class, 'show']);

Route::get('properties', [PropertyController::class, 'index']);
Route::get('property/{id}', [PropertyController::class, 'show']);

Route::get('apartments', [ApartmentController::class, 'index']);
Route::get('apartment/{id}', [ApartmentController::class, 'show']);

Route::post('email/validation', [HomeController::class, 'emailValidation']);

Route::get('aboutus', [HomeController::class, 'alfardanprofile']);

Route::get('faqs', [HomeController::class, 'faqs']);

Route::get('faqs/privilege', [HomeController::class, 'faqs_privilege']);

Route::get('term/conditions', [HomeController::class, 'term_conditions']);    


Route::post('email/exist', [HomeController::class, 'email_exist']);

    
	Route::get('restaurants', [RestaurantController::class, 'index']);
	Route::get('hotels', [HotelController::class, 'index']);
    Route::get('resorts', [ResortController::class, 'index']);
    Route::get('reviews', [ReviewController::class, 'index']);

    Route::get('home', [HomeController::class, 'categories']);

Route::middleware('auth:sanctum')->group(function(){

	Route::post('update/profile', [AuthController::class, 'update_profile']);
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);
	Route::post('changePassword', [AuthController::class, 'changePassword']);
    
    // Route::get('home', [HomeController::class, 'categories']);
    Route::get('newsfeed', [HomeController::class, 'newsfeed']);
	Route::get('art/gallery', [HomeController::class, 'artGallery']);
    Route::get('artgallery/{id}/{type}', [HomeController::class, 'art_gallery']);
	Route::get('offers/updates', [HomeController::class, 'offerUpdates']);
	Route::get('offers', [HomeController::class, 'offer']);
	Route::get('lifestyle/newsfeed', [HomeController::class, 'lifestyleNewsFeed']);
	Route::get('hospitality/newsfeed', [HomeController::class, 'hospitalityNewsFeed']);
	
	Route::get('get/notification', [HomeController::class, 'getNotification']);

    Route::post('notification/read/{id}', [HomeController::class, 'readNotification']);

    Route::post('notification/delete', [HomeController::class, 'deleteNotification']);

    Route::post('notification/filter', [HomeController::class, 'filterNotification']);

    Route::get('get/notification/type', [HomeController::class, 'getNotificationType']);
	
	Route::get('get/offertypes', [HomeController::class, 'offerTypes']);
	Route::get('get/offer/{id?}', [HomeController::class, 'getOffer']);


    Route::post('book/hotel/{id}', [HotelController::class, 'book']);
    Route::post('cancel/booking/hotel/{id}', [HotelController::class, 'cancelBooking']);

    Route::post('book/restaurant/{id}', [RestaurantController::class, 'book']);
    Route::post('cancel/booking/restaurant/{id}', [RestaurantController::class, 'cancelBooking']);

    Route::post('book/resort/{id}', [ResortController::class, 'book']);
    Route::post('cancel/booking/resort/{id}', [ResortController::class, 'cancelBooking']);
    //Route::get('resorts', [ResortController::class, 'index']);
    //Route::get('resort/{id}', [ResortController::class, 'show']);
    Route::get('events', [EventController::class, 'index']);
    Route::get('event/{id}', [EventController::class, 'show']);
    Route::post('book/event/{id}', [EventController::class, 'book']);
    Route::post('cancel/booking/event/{id}', [EventController::class, 'cancelBooking']);

    Route::get('classes', [ClassController::class, 'index']);
    Route::get('class/{id}', [ClassController::class, 'show']);
    Route::post('book/class/{id}', [ClassController::class, 'book']);
    Route::post('cancel/booking/class/{id}', [ClassController::class, 'cancelBooking']);

    Route::get('facilities', [FacilityController::class, 'index']);
    Route::get('facility/{id}', [FacilityController::class, 'show']);
    Route::post('book/facility/{id}', [FacilityController::class, 'book']);
    Route::post('cancel/booking/facility/{id}', [FacilityController::class, 'cancelBooking']);

    Route::get('buy', [ProductController::class, 'buy']);
    Route::get('product/{id}', [ProductController::class, 'show']);
    Route::get('my/products', [ProductController::class, 'my']);
    Route::get('products/categories', [ProductController::class, 'categories']);
    Route::post('products/add', [ProductController::class, 'add']);
    Route::post('products/remove/{id}/{sold?}', [ProductController::class, 'remove']);
	Route::get('all/products', [ProductController::class, 'all']);

    Route::get('all/products/featured', [ProductController::class, 'all_featured']);

    Route::post('upload/images', [HomeController::class, 'uploadImages']);
    Route::get('lifestyle/history', [HomeController::class, 'lifestyleHistory']);

    Route::get('maintenance/requests', [MaintenanceController::class, 'requests']);
    Route::get('maintenance/request/{id}', [MaintenanceController::class, 'show']);
    Route::post('new/request', [MaintenanceController::class, 'newRequest']);
    Route::post('cancel/request/{id}', [MaintenanceController::class, 'cancelRequest']);
    Route::post('open/request/{id}', [MaintenanceController::class, 'openRequest']);

    Route::get('privilege', [PrivilegeController::class, 'index']);

    Route::get('privilege/restaurants', [PrivilegeController::class, 'privilege_restaurants']);
    Route::get('privilege/hotels', [PrivilegeController::class, 'privilege_hotels']);
    Route::get('privilege/wellness ', [PrivilegeController::class, 'privilege_wellness']);

    Route::get('chat', [ChatController::class, 'index']);
    Route::post('send/msg', [ChatController::class, 'sendMessage']);

    Route::get('updates', [UpdatesController::class, 'index']);
    Route::get('update/{id}', [UpdatesController::class, 'show']);
    Route::get('complaints/history', [ComplaintController::class, 'history']);
    Route::get('complaint/{id}', [ComplaintController::class, 'show']);
    Route::post('raise/complaint', [ComplaintController::class, 'raise']);
    Route::post('cancel/complaint/{id}', [ComplaintController::class, 'cancel']);
    Route::post('open/complaint/{id}', [ComplaintController::class, 'open']);

    Route::get('survey', [SurveyController::class, 'index']);
    Route::get('get/survey', [SurveyController::class, 'getSurvey']);

    Route::post('feedback', [SurveyController::class, 'feedback']);

    Route::post('review', [ReviewController::class, 'review']);

    Route::get('services', [ConciergeController::class, 'services']);
    Route::post('request/service', [ConciergeController::class, 'requestService']);
	Route::post('cancel/service/{id}', [ConciergeController::class, 'cancelService']);
	Route::post('open/service/{id}', [ConciergeController::class, 'openService']);
	Route::get('concierge/banner', [ConciergeController::class, 'getConciergeBanner']);
	
    Route::get('pet/application', [ConciergeController::class, 'petApplication']);
    Route::post('submit/pet/application', [ConciergeController::class, 'submitPetApplication']);
	Route::post('cancel/pet/{id}', [ConciergeController::class, 'cancelPetRequest']);
	Route::post('open/pet/{id}', [ConciergeController::class, 'openPetRequest']);
	
	Route::get('maintenanceabsentia', [ConciergeController::class, 'getMaintenanceAbsentia']);
    Route::post('request/maintenance', [ConciergeController::class, 'requestMaintenance']);
	Route::post('cancel/maintenance/{id}', [ConciergeController::class, 'cancelMaintenanceRequest']);
	Route::post('open/maintenance/{id}', [ConciergeController::class, 'openMaintenanceRequest']);
	
	Route::get('guestaccess', [ConciergeController::class, 'getGuestAccess']);
    Route::post('guest/access', [ConciergeController::class, 'guestAccess']);
	Route::post('cancel/guestaccess/{id}', [ConciergeController::class, 'cancelGuestAccessRequest']);
	Route::post('open/guestaccess/{id}', [ConciergeController::class, 'openGuestAccessRequest']);
	
	Route::get('housekeeper', [ConciergeController::class, 'getHousekeeperInformation']);
    Route::post('housekeeper/information', [ConciergeController::class, 'housekeeperInformation']);
	Route::post('cancel/housekeeper/{id}', [ConciergeController::class, 'cancelHousekeeperRequest']);
	Route::post('open/housekeeper/{id}', [ConciergeController::class, 'openHousekeeperRequest']);
	
	Route::get('vehicle', [ConciergeController::class, 'getVehicleInformation']);
    Route::post('vehicle/information', [ConciergeController::class, 'vehicleInformation']);
	Route::post('cancel/vehicle/{id}', [ConciergeController::class, 'cancelVehicleRequest']);
	Route::post('open/vehicle/{id}', [ConciergeController::class, 'openVehicleRequest']);

    Route::get('access/key', [ConciergeController::class, 'accessKey']);
    Route::post('request/access/key', [ConciergeController::class, 'requestAccessKey']);
	Route::post('cancel/accesskey/{id}', [ConciergeController::class, 'cancelAccessKeyRequest']);
	Route::post('open/accesskey/{id}', [ConciergeController::class, 'openAccessKeyRequest']);
    
    Route::post('add/family_member', [FamilyMemberController::class, 'store']);
    Route::get('brochure', [PrivilegeController::class, 'getBrochure']);
	
	Route::post('tenant/registration', [TenantRegistrationController::class, 'store']);
	Route::get('get/tenant/registration', [TenantRegistrationController::class, 'index']);
    Route::get('get/newsletter', [HomeController::class, 'get_newsletter']);
    Route::get('newsletter', [HomeController::class, 'newsletter']);

    Route::get('art/galleries', [HomeController::class, 'artGalleries']);
});
