<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtGalleriesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('admin.login');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
require __DIR__ . '/auth.php';

// Admin
Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
    Route::namespace('Auth')->middleware('guest:admin')->group(function () {
        // login route
        Route::get('login', 'AuthenticatedSessionController@create')->name('login');
        Route::post('login', 'AuthenticatedSessionController@store')->name('adminlogin');
        Route::post('verify/code', 'AuthenticatedSessionController@verifycode')->name('verifycode');
    });

    Route::middleware('admin')->group(function () {
        /*All user Controller*/
        Route::resource('users', 'UserController');
        Route::get('users/datatable/list', 'UserController@listing')->name('users.listing');
        Route::get('users_expired/datatable/list', 'UserController@expiredListing')->name('users_expired.listing');
        Route::get('corporate-individual', 'UserController@corporate_individual')->name('corporate_individual');
        Route::get('dashboard', 'UserController@dashboard')->name('dashboard');
        Route::get('family-members', 'UserController@family_member')->name('family_member');
        Route::get('all-requests', 'UserController@allrequests')->name('users.all_requests');
        Route::get('all-expired_contracts', 'UserController@expiredContracts')->name('users.expired_contracts');
        Route::get('familylisting', 'UserController@familylisting')->name('users.familylisting');

        //Route::get('dashboard','HomeController@index')->name('dashboard');
        /*End All user Controller*/

        // Route::get('tenant-listing', 'HomeController@tenant_listing')->name('tenant_listing');

        Route::get('admin-test', 'HomeController@adminTest')->name('admintest');

        Route::get('editor-test', 'HomeController@editorTest')->name('editortest');

        Route::resource('posts', 'PostController');

        Route::post('get/user', 'HomeController@getUser')->name('getUser');

        Route::post('update/user', 'HomeController@updateUser')->name('updateUser');

        Route::post('update/tenant/request', 'HomeController@update_tenant_request')->name('update_tenant_request');

        Route::delete('deleteuser/{id}', 'HomeController@delete_user')->name('delete_user');

        Route::get('userinfo/{id}', 'HomeController@user_info')->name('user_info');

        Route::get('empolyees', 'HomeController@empolyee_list')->name('empolyee_list');

        Route::get('tenant/request', 'HomeController@tenant_request')->name('tenant_request');

        Route::get('non-tenants', 'HomeController@non_tenants')->name('non_tenants');

        Route::get('events', 'HomeController@events')->name('events');

        Route::get('classes', 'HomeController@classes')->name('classes');

        Route::get('facilities', 'HomeController@facilities')->name('facilities');

        Route::get('hotels', 'HomeController@hotels')->name('hotels');

        Route::get('restaurants', 'HomeController@restaurants')->name('restaurants');

        Route::get('wellness', 'HomeController@wellness')->name('wellness');

        Route::get('properties', 'HomeController@property')->name('property');

        Route::get('apartments', 'HomeController@apartments')->name('apartments');

        Route::get('services', 'HomeController@services')->name('services');

        Route::get('pet-form', 'HomeController@pet_form')->name('pet_form');

        Route::get('maintenance-in-absentia', 'HomeController@maintenance_in_absentia')->name('maintenance_in_absentia');

        Route::post('term/maintenance-in-absentia', 'HomeController@maintenance_in_absentia_term')->name('maintenance_in_absentia_term');

        Route::get('automated-guest-access', 'HomeController@automated_guest_access')->name('automated_guest_access');

        Route::post('term/automated-guest-access', 'HomeController@automated_guest_access_term')->name('automated_guest_access_term');

        Route::get('access-key-card', 'HomeController@access_key_card')->name('access_key_card');

        Route::get('vehicle-form', 'HomeController@vehicle_form')->name('vehicle_form');

        Route::get('housekeeping-form', 'HomeController@housekeeping_form')->name('housekeeping_form');

        Route::get('privilege-program', 'HomeController@privilege_program')->name('privilege_program');

        Route::get('alfardan-living-profile', 'HomeController@alfardan_profile')->name('alfardan_profile');

        Route::post('alfardan-profile-term', 'HomeController@alfardan_profile_term')->name('alfardan_profile_term');

        Route::get('survey', 'HomeController@servay')->name('survey');

        Route::get('complaints', 'HomeController@complaints')->name('complaints');

        Route::get('circular-update', 'HomeController@circular_update')->name('circular_update');

        Route::get('employee-view/{id}', 'HomeController@employee_view')->name('employee_view');

        Route::get('corporate-individual-view/{id}', 'HomeController@corporate_view')->name('corporate_view');

        Route::get('family-member-view/{id}', 'HomeController@family_member_view')->name('family_member_view');

        Route::get('housekeeping-form-view/{id}', 'HomeController@housekeeping_form_view')->name('housekeeping_form_view');

        Route::post('term/housekeeping-form', 'HomeController@housekeeping_form_term')->name('housekeeping_form_term');

        Route::get('accept_tenant_request/{id}', 'HomeController@accept_tenant_request')->name('accept_tenant_request');

        Route::post('reject_tenant_request', 'HomeController@reject_tenant_request')->name('reject_tenant_request');

        Route::get('newsfeed', 'HomeController@newsfeed')->name('newsfeed');

        Route::get('buy/sell', 'HomeController@buy_sell')->name('buy_sell');

        Route::get('featured', 'HomeController@featured')->name('featured');

        Route::post('add/featured', 'HomeController@addFeatured')->name('addFeatured');

        Route::post('get/featured', 'HomeController@getFeatured')->name('getFeatured');

        Route::get('maintenance', 'HomeController@maintenance')->name('maintenance');

        Route::post('add/employee', 'HomeController@addEmployee')->name('addEmployee');

        Route::delete('delete/employee/{id}', 'HomeController@deleteEmployee')->name('deleteEmployee');

        Route::post('add/event', 'HomeController@addEvent')->name('addEvent');

        Route::delete('delete/event/{id}', 'HomeController@deleteEvent')->name('deleteEvent');

        Route::get('event-view/{id}', 'HomeController@event_view')->name('event_view');

        Route::post('add/class', 'HomeController@addClass')->name('addClass');

        Route::delete('delete/class/{id}', 'HomeController@deleteClass')->name('deleteClass');

        Route::get('class-view/{id}', 'HomeController@class_view')->name('class_view');

        Route::post('add/facility', 'HomeController@addFacility')->name('addFacility');

        Route::delete('delete/facility/{id}', 'HomeController@deleteFacility')->name('deleteFacility');

        Route::get('facility-view/{id}', 'HomeController@facility_view')->name('facility_view');

        Route::post('add/family', 'HomeController@addFamilyMember')->name('addFamilyMember');

        Route::delete('delete/family/{id}', 'HomeController@deleteFamily')->name('deleteFamily');

        Route::post('add/corporate', 'HomeController@addCorporateIndividual')->name('addCorporateIndividual');

        Route::delete('delete/corporate/{id}', 'HomeController@deleteCorporate')->name('deleteCorporate');

        Route::post('add/hotel', 'HomeController@addHotel')->name('addHotel');

        Route::delete('delete/hotel/{id}', 'HomeController@deleteHotel')->name('deleteHotel');

        Route::get('hotel-view/{id}', 'HomeController@hotel_view')->name('hotel_view');

        Route::post('add/restaurant', 'HomeController@addRestaurant')->name('addRestaurant');

        Route::delete('delete/restaurant/{id}', 'HomeController@deleteRestaurant')->name('deleteRestaurant');

        Route::get('restaurant-view/{id}', 'HomeController@restaurant_view')->name('restaurant_view');

        Route::post('add/wellness', 'HomeController@addWellness')->name('addWellness');

        Route::delete('delete/resort/{id}', 'HomeController@deleteResort')->name('deleteResort');

        Route::get('wellness-view/{id}', 'HomeController@wellness_view')->name('wellness_view');

        Route::post('add/property', 'HomeController@addProperty')->name('addProperty');

        Route::delete('delete/property/{id}', 'HomeController@deleteProperty')->name('deleteProperty');

        Route::get('property-view/{id}', 'HomeController@property_view')->name('property_view');

        Route::post('propertygallery/{id}', 'HomeController@propertygallery')->name('propertygalleryadd');

        Route::delete('propertygallerydelete/{id}', 'HomeController@propertygallerydelete')->name('propertygallerydelete');

        Route::delete('property3ddelete/{id}', 'HomeController@property3ddelete')->name('property3ddelete');

        Route::post('property3dadd/{id}', 'HomeController@property3dadd')->name('property3dadd');

        Route::patch('property3dupdate/{id}/{imgid}', 'HomeController@property3dupdate')->name('property3dupdate');

        Route::post('add/apartment', 'HomeController@addApartment')->name('addApartment');

        Route::post('add/tower', 'HomeController@addTower')->name('addTower');

        Route::post('add/floor', 'HomeController@addFloor')->name('addFloor');

        Route::delete('delete/apartment/{id}', 'HomeController@deleteApartment')->name('deleteApartment');

        Route::delete('delete/tower/{id}', 'HomeController@deleteTower')->name('deleteTower');

        Route::delete('delete/floor/{id}', 'HomeController@deleteFloor')->name('deleteFloor');

        Route::get('apartment-view/{id}', 'HomeController@apartment_view')->name('apartment_view');

        Route::get('tower-view/{id}', 'HomeController@tower_view')->name('tower_view');

        Route::get('floor-view/{id}', 'HomeController@floor_view')->name('floor_view');

        Route::post('add/maintenance', 'HomeController@addMaintenance')->name('addMaintenance');

        Route::delete('delete/maintenance/{id}', 'HomeController@deleteMaintenance')->name('deleteMaintenance');

        Route::get('maintenance-view/{id}', 'HomeController@maintenance_view')->name('maintenance_view');

        Route::get('vehicle-view/{id}', 'HomeController@vehicle_form_view')->name('vehicle_form_view');

        Route::post('term/vehicle-view', 'HomeController@vehicle_form_term')->name('vehicle_form_term');

        Route::get('service-view/{id}', 'HomeController@service_view')->name('service_view');

        Route::get('pet-view/{id}', 'HomeController@pet_form_view')->name('pet_form_view');

        Route::post('term/pet', 'HomeController@pet_form_term')->name('pet_form_term');

        Route::get('maintenance-in-absentia-view/{id}', 'HomeController@maintenance_in_absentia_view')->name('maintenance_in_absentia_view');

        Route::get('automated-guest-view/{id}', 'HomeController@automated_guest_view')->name('automated_guest_view');

        Route::get('access-key-card-view/{id}', 'HomeController@access_key_card_view')->name('access_key_card_view');

        Route::post('term/access-key-card', 'HomeController@access_key_card_term')->name('access_key_card_term');

        Route::get('complaint-view/{id}', 'HomeController@complaint_view')->name('complaint_view');

        Route::get('circular-update-view/{id}', 'HomeController@circular_update_view')->name('circular_update_view');

        Route::post('get/employee', 'HomeController@getEmpolyee')->name('getEmpolyee');

        Route::post('get/family-member', 'HomeController@getFamilyMember')->name('getFamilyMember');

        Route::post('get/corporate', 'HomeController@getCorporateIndividual')->name('getCorporateIndividual');

        Route::post('get/event', 'HomeController@getEvent')->name('getEvent');

        Route::post('get/class', 'HomeController@getClass')->name('getClass');

        Route::post('get/facility', 'HomeController@getFacility')->name('getFacility');

        Route::post('get/hotel', 'HomeController@getHotel')->name('getHotel');

        Route::post('get/restaurant', 'HomeController@getRestaurant')->name('getRestaurant');

        Route::post('get/resort', 'HomeController@getResort')->name('getResort');

        Route::post('get/property', 'HomeController@getProperty')->name('getProperty');

        Route::post('get/apartment', 'HomeController@getApartment')->name('getApartment');

        Route::post('get/tower', 'HomeController@getTower')->name('getTower');

        Route::post('get/floor', 'HomeController@getFloor')->name('getFloor');

        Route::post('get/maintenance/request', 'HomeController@getMaintenanceRequest')->name('getMaintenanceRequest');

        Route::get('get/propertyajax', 'HomeController@ajaxGetProperty')->name('ajaxGetProperty');

        Route::get('accept_family_request/{id}', 'HomeController@accept_family_request')->name('accept_family_request');

        Route::post('reject_family_request', 'HomeController@reject_family_request')->name('reject_family_request');

        Route::get('accept_corporate_request/{id}', 'HomeController@accept_corporate_request')->name('accept_corporate_request');

        Route::post('add/complaint', 'HomeController@addComplaint')->name('addComplaint');

        Route::post('get/complaint', 'HomeController@getComplaints')->name('getComplaints');

        Route::delete('delete/complaint/{id}', 'HomeController@deleteComplaint')->name('deleteComplaint');

        Route::post('add/circular', 'HomeController@addCircular')->name('addCircular');

        Route::post('get/circular', 'HomeController@getCircular')->name('getCircular');

        Route::delete('delete/circular/{id}', 'HomeController@deleteCircular')->name('deleteCircular');

        Route::post('add/survey', 'HomeController@addSurvey')->name('addSurvey');

        Route::post('get/survey', 'HomeController@getSurvey')->name('getSurvey');

        Route::delete('delete/survey/{id}', 'HomeController@deleteSurvey')->name('deleteSurvey');

        Route::post('add/services', 'HomeController@addServices')->name('addServices');

        Route::post('get/services', 'HomeController@getServices')->name('getServices');

        Route::delete('delete/service/{id}', 'HomeController@deleteServices')->name('deleteServices');

        Route::post('term/service', 'HomeController@services_term')->name('services_term');

        Route::post('add/pet', 'HomeController@addPet')->name('addPet');

        Route::post('get/pet', 'HomeController@getPet')->name('getPet');

        Route::delete('delete/pet/{id}', 'HomeController@deletePet')->name('deletePet');

        Route::post('add/maintenanceabsentia', 'HomeController@addMaintenanceAbsentia')->name('addMaintenanceAbsentia');

        Route::post('get/maintenanceabsentia', 'HomeController@getMaintenanceAbsentia')->name('getMaintenanceAbsentia');

        Route::delete('delete/maintenanceabsentia/{id}', 'HomeController@deleteMaintenanceAbsentia')->name('deleteMaintenanceAbsentia');

        Route::post('add/vehicle', 'HomeController@addVehicle')->name('addVehicle');

        Route::post('get/vehicle', 'HomeController@getVehicle')->name('getVehicle');

        Route::delete('delete/vehicle/{id}', 'HomeController@deleteVehicle')->name('deleteVehicle');

        Route::post('add/housekeeping', 'HomeController@addHousekeeping')->name('addHousekeeping');

        Route::post('get/housekeeping', 'HomeController@getHousekeeping')->name('getHousekeeping');

        Route::delete('delete/housekeeping/{id}', 'HomeController@deleteHousekeeping')->name('deleteHousekeeping');

        Route::post('add/automateguest', 'HomeController@addAutomatedGuest')->name('addAutomatedGuest');

        Route::post('get/automateguest', 'HomeController@getAutomatedGuest')->name('getAutomatedGuest');

        Route::delete('delete/automateguest/{id}', 'HomeController@deleteAutomatedGuest')->name('deleteAutomatedGuest');

        Route::post('add/accesskey', 'HomeController@addAccesskey')->name('addAccesskey');

        Route::post('get/accesskey', 'HomeController@getAccesskey')->name('getAccesskey');

        Route::delete('delete/accesskey/{id}', 'HomeController@deleteAccesskey')->name('deleteAccesskey');

        Route::get('set/newsfeed/event{id}', 'HomeController@setNewsfeed')->name('setNewsfeed');

        Route::get('unset/newsfeed/event{id}', 'HomeController@unsetNewsfeed')->name('unsetNewsfeed');

        Route::get('set/newsfeed/class{id}', 'HomeController@setClassNewsfeed')->name('setClassNewsfeed');

        Route::get('unset/newsfeed/class{id}', 'HomeController@unsetClassNewsfeed')->name('unsetClassNewsfeed');

        Route::get('set/newsfeed/facility{id}', 'HomeController@setFacilityNewsfeed')->name('setFacilityNewsfeed');

        Route::get('unset/newsfeed/facility{id}', 'HomeController@unsetFacilityNewsfeed')->name('unsetFacilityNewsfeed');

        Route::get('set/newsfeed/hotel{id}', 'HomeController@setHotelNewsfeed')->name('setHotelNewsfeed');

        Route::get('set/privilege/hotel{id}', 'HomeController@setHotelPrivilege')->name('setHotelPrivilege');

        Route::get('unset/newsfeed/hotel{id}', 'HomeController@unsetHotelNewsfeed')->name('unsetHotelNewsfeed');

        Route::get('unset/privilege/hotel{id}', 'HomeController@unsetHotelPrivilege')->name('unsetHotelPrivilege');

        Route::get('set/newsfeed/restaurant{id}', 'HomeController@setRestaurantNewsfeed')->name('setRestaurantNewsfeed');

        Route::get('set/privilege/restaurant{id}', 'HomeController@setRestaurantPrivilege')->name('setRestaurantPrivilege');

        Route::get('unset/newsfeed/restaurant{id}', 'HomeController@unsetRestaurantNewsfeed')->name('unsetRestaurantNewsfeed');

        Route::get('unset/privilege/restaurant{id}', 'HomeController@unsetRestaurantPrivilege')->name('unsetRestaurantPrivilege');

        Route::get('set/newsfeed/resort{id}', 'HomeController@setResortNewsfeed')->name('setResortNewsfeed');

        Route::get('set/privilege/resort{id}', 'HomeController@setResortPrivilege')->name('setResortPrivilege');

        Route::get('unset/newsfeed/resort{id}', 'HomeController@unsetResortNewsfeed')->name('unsetResortNewsfeed');

        Route::get('unset/privilege/resort{id}', 'HomeController@unsetResortPrivilege')->name('unsetResortPrivilege');

        Route::post('add/faq', 'HomeController@addFaq')->name('addFaq');

        Route::post('get/faq', 'HomeController@getFaq')->name('getFaq');

        Route::delete('delete/faq/{id}', 'HomeController@deleteFaq')->name('deleteFaq');

        Route::post('add/alfardan/profile', 'HomeController@alfardanProfile')->name('alfardanProfile');

        Route::post('add/privilege/program', 'HomeController@addPrivilegeBrochure')->name('addPrivilegeBrochure');

        Route::post('reject_corporate_request', 'HomeController@reject_corporate_request')->name('reject_corporate_request');

        Route::get('delete/review/{id}', 'HomeController@deleteReview')->name('deleteReview');

        Route::get('delete/event_view/{id}', 'HomeController@deleteEventView')->name('deleteEventView');

        Route::get('delete/class_view/{id}', 'HomeController@deleteClassView')->name('deleteClassView');

        Route::get('delete/facility_view/{id}', 'HomeController@deleteFacilityView')->name('deleteFacilityView');

        Route::get('delete/hotel_view/{id}', 'HomeController@deleteHotelView')->name('deleteHotelView');

        Route::get('delete/restaurant_view/{id}', 'HomeController@deleteRestaurantView')->name('deleteRestaurantView');

        Route::get('delete/resort_view/{id}', 'HomeController@deleteResortView')->name('deleteResortView');

        Route::post('get/family-request', 'HomeController@getFamilyRequest')->name('getFamilyRequest');

        Route::post('add/family-request', 'HomeController@addFamilyRequest')->name('addFamilyRequest');

        Route::post('get/tenant/family', 'HomeController@getTenantFamily')->name('getTenantFamily');

        Route::delete('delete/tenant/family/{id}', 'HomeController@deleteTenantFamily')->name('deleteTenantFamily');

        Route::post('property/view', 'HomeController@addTenantHandbook')->name('addTenantHandbook');

        Route::post('get/sellrequest', 'HomeController@getSellRequest')->name('getSellRequest');

        Route::post('get/featuredsellrequest', 'HomeController@getFeaturedSellRequest')->name('getFeaturedSellRequest');

        Route::post('update/sellrequest', 'HomeController@updateSellRequest')->name('updateSellRequest');

        Route::delete('delete/sellrequest/{id}', 'HomeController@deleteSellRequest')->name('deleteSellRequest');

        Route::get('draft/property/{id}', 'HomeController@draftProperty')->name('draftProperty');

        Route::get('become/tenant/', 'HomeController@becomeTenant')->name('becomeTenant');

        Route::post('getbecome/tenant/', 'HomeController@getBecomeTenant')->name('getBecomeTenant');

        Route::post('update/become/tenant/', 'HomeController@updateBecomeTenant')->name('updateBecomeTenant');

        Route::delete('deletetenant/{id}', 'HomeController@deleteBecomeTenant')->name('deleteBecomeTenant');

        Route::post('import/towers', 'HomeController@importTowers')->name('importTowers');

        Route::post('import/floors', 'HomeController@importFloors')->name('importFloors');

        Route::post('import/apartment', 'HomeController@importApartments')->name('importApartments');

        Route::get('tenant/registration', 'HomeController@tenantRegistration')->name('tenantRegistration');

        Route::post('add/tenant/registration', 'HomeController@addTenantRegistration')->name('addTenantRegistration');

        Route::post('update/tenant/registration', 'HomeController@updateTenantRegistration')->name('updateTenantRegistration');

        Route::post('get/tenant/registration', 'HomeController@getTenantRegistration')->name('getTenantRegistration');

        Route::delete('delete/tenantregistration/{id}', 'HomeController@deleteTenantRegistration')->name('deleteTenantRegistration');

        Route::post('term/tenantregistration/', 'HomeController@tenant_registration_term')->name('tenant_registration_term');

        Route::post('term/delete', 'HomeController@delete_term')->name('delete_term');

        Route::get('tenant/export', 'HomeController@tenantExport')->name('tenantExport');

        Route::get('art/gallery', 'HomeController@artGallery')->name('artGallery');

        Route::get('art/galleries', 'ArtGalleriesController@index')->name('artGalleries');

        Route::get('offers/updates', 'HomeController@offerUpdates')->name('offerUpdates');

        Route::get('get/offers', 'HomeController@get_offers')->name('get_offers');

        Route::post('offer', 'HomeController@offer')->name('offer');

        Route::post('add/offer', 'HomeController@add_offer')->name('add_offer');

        Route::post('edit/offer', 'HomeController@edit_offer')->name('edit_offer');

        Route::delete('offer/delete', 'HomeController@offerDelete')->name('offerDelete');

        Route::get('art/gallery/view/{id}', 'HomeController@artGalleryView')->name('artGalleryview');

        Route::post('add/art/gallery', 'HomeController@addArtGallery')->name('addArtGallery');

        Route::post('get/art/gallery', 'HomeController@getArtGallery')->name('getArtGallery');

        Route::post('update/art/gallery', 'HomeController@updateArtGallery')->name('updateArtGallery');

        Route::delete('delete/art/gallery', 'HomeController@deleteArtGallery')->name('deleteArtGallery');

        Route::post('add/art/galleries', 'ArtGalleriesController@addArtGallery')->name('addArtGalleries');

        Route::post('get/art/galleries', 'ArtGalleriesController@getArtGallery')->name('getArtGalleries');

        Route::post('update/art/galleries', 'ArtGalleriesController@updateArtGallery')->name('updateArtGalleries');

        Route::delete('delete/art/galleries', 'ArtGalleriesController@deleteArtGallery')->name('deleteArtGalleries');

        Route::post('add/art', 'HomeController@addArt')->name('addArt');

        Route::post('get/art', 'HomeController@getArt')->name('getArt');

        Route::post('update/art', 'HomeController@updateArt')->name('updateArt');

        Route::delete('delete/art', 'HomeController@deleteArt')->name('deleteArt');

        Route::post('add/offers', 'HomeController@addOffers')->name('addOffers');

        Route::post('get/offers', 'HomeController@getOffers')->name('getOffers');

        Route::post('update/offers', 'HomeController@updateOffers')->name('updateOffers');

        Route::delete('delete/offers', 'HomeController@deleteOffers')->name('deleteOffers');

        Route::get('offer/view/{id}', 'HomeController@offerView')->name('offerView');

        Route::post('add/newsfeed', 'HomeController@addNewsFeed')->name('addNewsFeed');

        Route::get('maintenance/chat', 'HomeController@maintenanceChat')->name('maintenanceChat');

        Route::get('concierge/chat', 'HomeController@conciergeChat')->name('conciergeChat');

        Route::get('customer/service/chat', 'HomeController@customerServiceChat')->name('customerServiceChat');

        Route::post('chat/history', 'HomeController@chatHistory')->name('chatHistory');

        Route::post('chat/chatrefresh/{id}', 'HomeController@chatrefresh')->name('chatrefresh');

        Route::post('send/message', 'HomeController@sendMessage')->name('sendMessage');

        Route::post('maintenance/search', 'HomeController@maintenancechatSearch')->name('maintenancechatSearch');

        Route::post('concierge/search', 'HomeController@conciergechatSearch')->name('conciergechatSearch');

        Route::post('customer/search', 'HomeController@customerchatSearch')->name('customerchatSearch');

        Route::post('get/tenant', 'HomeController@getFamilyTenant')->name('getFamilyTenant');

        Route::post('edit/tenant', 'HomeController@editFamilyTenant')->name('editFamilyTenant');

        Route::delete('delete/tenant/{id}', 'HomeController@deleteFamilyTenant')->name('deleteFamilyTenant');

        Route::get('concierge', 'HomeController@concierge')->name('concierge');

        Route::post('add/concierge', 'HomeController@addConciergeBanner')->name('addConciergeBanner');

        Route::get('delete/concierge/{id}', 'HomeController@deleteConciergeBanner')->name('deleteConciergeBanner');
        // start pdf generator routes

        Route::get('service/pdf/{id}', 'PdfGeneratorController@pdfServiceView')->name('pdfServiceView');

        Route::get('pet/pdf/{id}', 'PdfGeneratorController@pdfPetView')->name('pdfPetView');

        Route::get('maintenance/absentia/pdf/{id}', 'PdfGeneratorController@maintenanceAbsentia')->name('maintenanceAbsentia');

        Route::get('guest/access/pdf/{id}', 'PdfGeneratorController@guestAccess')->name('guestAccess');

        Route::get('access/key/pdf/{id}', 'PdfGeneratorController@accessKey')->name('accessKey');

        Route::get('vehicle/pdf/{id}', 'PdfGeneratorController@vehicle')->name('vehicle');

        Route::get('housekeeper/pdf/{id}', 'PdfGeneratorController@housekeeper')->name('housekeeper');

        Route::post('updatebooking', 'HomeController@updatebooking')->name('updatebooking');

        Route::post('apartmentslist', 'HomeController@apartmentslist')->name('apartmentslist');

        Route::post('tenantslist', 'HomeController@tenantslist')->name('tenantslist');

        Route::delete('deletebooking/{id}', 'HomeController@deletebooking')->name('deletebooking');

        Route::delete('deleteslot/{id}', 'HomeController@deleteslot')->name('deleteslot');
        Route::delete('deleteimage/{id}', 'HomeController@deleteimage')->name('deleteimage');

        Route::delete('deletemenu/{id}/{menu}', 'HomeController@deletemenu')->name('deletemenu');

        Route::delete('deleteart/photo/{id}', 'HomeController@deleteartphoto')->name('deleteartphoto');
        Route::delete('deleteoffer/photo/{id}', 'HomeController@deleteofferphoto')->name('deleteofferphoto');
        Route::delete('deleteprofile/{id}/{photo}', 'HomeController@deleteprofilephoto')->name('deleteprofilephoto');
        Route::delete('deleteprofile/{id}/{photo}', 'HomeController@deleteprofilephoto')->name('deleteprofilephoto');

        Route::delete('deleteuserprofile/{id}', 'HomeController@deleteuserprofilephoto')->name('deleteuserprofilephoto');

        Route::get('settings', 'HomeController@settings')->name('settings');

        Route::post('updatepassword', 'HomeController@updatepassword')->name('updatepassword');

        Route::post('event/term', 'HomeController@event_term')->name('event_term');

        Route::get('notifications/{id?}', 'HomeController@notifications')->name('notifications');

        Route::get('notifications/datatable/list', 'HomeController@notification_listing')->name('notifications.listing');

        Route::post('notification/add', 'HomeController@notificationadd')->name('notificationadd');

        Route::get('news/Letter', 'NewsLetterController@index')->name('newsLetter');

        Route::post('add/newsletter', 'NewsLetterController@add_newsletter')->name('add_newsletter');

        Route::post('newsletter/title', 'NewsLetterController@newsletter_title')->name('newsletter_title');

        Route::post('delete/newsletter', 'NewsLetterController@delete_newsletter')->name('delete_newsletter');

        Route::post('delete/head', 'NewsLetterController@deleteHead')->name('deleteHead');

        Route::post('delete/news', 'NewsLetterController@deleteNews')->name('deleteNews');

    });
    Route::get('forgot_password', 'HomeController@forgot_password')->name('forgot_password');
    Route::post('forgot_password', 'HomeController@send_forgot_password_link')->name('send_forgot_password_link');

    Route::post('logout', 'Auth\AuthenticatedSessionController@destroy')->name('logout');

    Route::post('classslot/{classid}/{slot?}', 'HomeController@ClassSlot')->name('addclassslot');

    Route::post('offers/updates/delete', 'HomeController@offer_update_delete')->name('offer_update_delete');

    Route::post('offers/delete', 'HomeController@offers_delete')->name('offers_delete');
});
