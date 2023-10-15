<?php

namespace App\Http\Controllers\Api;

use App\Models\Faq;
use App\Models\User;
use App\Models\Event;
use App\Models\Hotel;
use App\Models\Image;
use App\Models\Offer;
use App\Models\Resort;
use App\Models\Product;
use App\Models\Category;
use App\Models\Facility;
use App\Models\NewsFeed;
use App\Models\ArtGallery;
use App\Models\ClassEvent;
use App\Models\NewsLetter;
use App\Models\Restaurant;
use App\Models\OfferUpdate;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\TermCondition;
use Intervention as InterventionImage;
use App\Models\NewsLetterHead;
use App\Models\AlfardanProfile;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController;

class HomeController extends BaseController
{
    public function newsfeed(Request $request)
    {
       $data = [
			'Banners' => NewsFeed::get()
           // 'events' => Event::limit(3)->get(),
           // 'products' => Product::limit(3)->get(),
           // 'restaurants' => Restaurant::limit(2)->get(),
        ];

        return $this->successResponse($data);
    }
	
	public function artGallery(){
	
	  $data = [
			'Gallery' => ArtGallery::with('art')->get()
        ];

        return $this->successResponse($data);
	}
	
	public function offerUpdates(){
	 $data = [
			'OfferUpdates' => OfferUpdate::get()
        ];

        return $this->successResponse($data);
	}
	
	public function lifestyleNewsFeed(){
		$data=[
				'Classes'	 =>ClassEvent::where('news_feed',1)->limit(5)->get(),

				'Facilities' =>Facility::where('news_feed',1)->limit(5)->get(),		

				'Events'    =>Event::where('news_feed',1)->limit(5)->get(),
			];
		
		//$data = $classes->concat($facilities);
       // $data = $data->concat($events);

        return $this->successResponse($data);
	
	}
	
	public function hospitalityNewsFeed(){
		$data=[
			'Hotels'=>Hotel::where('news_feed',1)->limit(5)->get(),

			'Restaurants'=>Restaurant::where('news_feed',1)->limit(5)->get(),		

			'Resorts'=>Resort::where('news_feed',1)->limit(5)->get(),
		 ];
		//$data = $hotels->concat($restaurants);
		
       // $data = $data->concat($resorts);

        return $this->successResponse($data);
	
	}
    public function categories(Request $request)
    {
        $categories = Category::where('id', '<>', '11')->get();
        if(strtolower(auth()->user()->tenant_type) != 'elite'){
            $categories = Category::where('name' , 'NOT LIKE', 'Privilege Programme')->get();
        }

        return $this->successResponse($categories);
    }

    public function guestCategories(Request $request)
    {
        $categories = Category::whereIn('id', [7, 2, 10])->get();

        return $this->successResponse($categories);
    }

    public function uploadImages(Request $request)
    {
        $images = [];
        if ($request->file('images')) { 
            if(is_array($request->file('images'))){
                foreach ($request->file('images') as $key => $file) {
                    $file = $request->File('images');
                    $name = time() .'-'. $key .'.'. $file->extension();
                    return $name;
                    $img_resize = InterventionImage::make($file->getRealPath())
                        ->orientate()->save(public_path('uploads/' . $name));
                    // $img_resize->resize(300,300);
                    // $img_resize->save(public_path('uploads/'.$image));
                    $file->storeAs('', $name, 'uploads');
    
                    $images[] = Image::create([
                        'path' => $name
                    ]);
                }
            } else {
                $file = $request->File('images');
                $name = time() .'-'. '1' .'.'. $file->extension();
                return $name;
                $img_resize = InterventionImage::make($file->getRealPath())
                    ->orientate()->save(public_path('uploads/' . $name));
                // $img_resize->resize(300,300);
                // $img_resize->save(public_path('uploads/'.$image));
                $file->storeAs('', $name, 'uploads');
    
                $images[] = Image::create([
                    'path' => $name
                ]);
            }
        } 

        return $this->successResponse($images);
    }

    public function lifestyleHistory()
    {
        $classes = ClassEvent::join('bookings', 'bookings.class_id', 'classes.id')
            ->whereNotNull('class_id')
            ->where('user_id', auth()->id())
            ->select('classes.*', 'bookings.reservations', 'bookings.time')
            ->get();

        $facilities = Facility::join('bookings', 'bookings.facility_id', '=', 'facilities.id')
            ->whereNotNull('facility_id')
            ->where('user_id', auth()->id())
            ->select('facilities.*')
            ->get();

        $events = Event::join('bookings', 'bookings.event_id', '=', 'events.id')
            ->whereNotNull('event_id')
            ->where('user_id', auth()->id())
            ->select('events.*')
            ->get();

        $data = $classes->concat($facilities);
        $data = $data->concat($events);

        return $this->successResponse($data);
    }
	
	public function emailValidation(Request $request){
		$validator =  Validator::make($request->all(), [
            
            'email' => 'required|email|max:255|unique:users',
           
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first());
        }
	}
	public function offerTypes(Request $request){
		$offer=new OfferUpdate();
		 if($request->has("q")){
           
            $data = [
                'Offer' =>  $offer->where("type","like","%".$request->input('q')."%")->get()
            ];
            return $this->successResponse($data);
        }  
	}
    
    public function getNotification(Request $request){
       		$notification=Notification::whereNull('user_id')->orwhere('user_id', auth()->id())->orderBy('id', 'desc');
			
           	$notification->where('is_read',0);
            $data = [
                'Notification' => $notification->get(),
                //'others' => Notification::where('user_id', auth()->id())->get()
            ];
            return $this->successResponse($data);
        
    }
	
	 public function readNotification($id){
	 	 $notification=Notification::findOrFail($id);
		 if($notification->user_id== auth()->id()){
            $notification->is_read=1;
            $notification->save();
            return $this->successResponse([],"Read Notification Successfully");
         }else if(is_null($notification->user_id)){
            return $this->successResponse([],"Read Notification Successfully");
         }else{
		 	return $this->errorResponse("Notification Not Found",404);
		 }
	 }	
    
    public function alfardanprofile(Request $request){
         
            return $this->successResponse(alfardanprofile::first());
        
    }
    
    public function faqs(Request $request){
         
            return $this->successResponse(Faq::where('type', 'alfardan')->get());
        
    }
    public function faqs_privilege(Request $request){
         
        return $this->successResponse(Faq::where('type', 'privilege')->get());
        
    }


    public function email_exist(Request $request){
        $data=Validator::make($request->all(), [
            "email"=>"required|email|max:255",
        ]);
        if($data->fails()){
            return response()->json([
                "success" => false,
                "errors" => [$data->errors()->first()],
            ]);
        }
        $data=$request->all();
        $user=User::where('email',$data['email'])->first();
        // return $user;

        if($user){
            return response()->json([
                "success"=>false,
                "message"=>"Email already exists."
            ]);
        }
        return response()->json([
            "success"=>true,
            "message"=>"Email does not exist."
        ]);
    }

    public function term_conditions(){
        $term_conds = TermCondition::latest()->first();
        $term_conds->tenant_reg_term = ($term_conds->tenant_reg_term !=null ) ? asset('uploads/' . $term_conds->tenant_reg_term) : "";
        $term_conds->services_term = ($term_conds->services_term !=null ) ? asset('uploads/' . $term_conds->services_term) : "";
        $term_conds->pet_form_term = ($term_conds->pet_form_term !=null ) ? asset('uploads/' . $term_conds->pet_form_term) : "";
        $term_conds->maintenance_in_absentia_term = ($term_conds->maintenance_in_absentia_term !=null ) ? asset('uploads/' . $term_conds->maintenance_in_absentia_term) : "";
        $term_conds->automated_guest_access_term = ($term_conds->automated_guest_access_term !=null ) ? asset('uploads/' . $term_conds->automated_guest_access_term) : "";
        $term_conds->access_key_card_term = ($term_conds->access_key_card_term !=null ) ? asset('uploads/' . $term_conds->access_key_card_term) : "";
        $term_conds->vehicle_form_term = ($term_conds->vehicle_form_term !=null ) ? asset('uploads/' . $term_conds->vehicle_form_term) : "";
        $term_conds->housekeeping_form_term = ($term_conds->housekeeping_form_term !=null ) ? asset('uploads/' . $term_conds->housekeeping_form_term) : "";
        $term_conds->alfardan_profile_term = ($term_conds->alfardan_profile_term !=null ) ? asset('uploads/' . $term_conds->alfardan_profile_term) : "";
        return $this->successResponse($term_conds);
    }

    public function offer(){
        $data = [
            'offers' => Offer::where('status', '1')->orderBy('order', 'ASC')->get()
        ];
        return $this->successResponse($data);
    }

    public function getOffer($id=null){
        if(!empty($id)){
            $data = [
                'offer' => Offer::where('id', $id)->get()
            ];
            return $this->successResponse($data);
        }
    }

    public function deleteNotification(Request $request){
        if(!empty($request->id)){
            $ids = explode(',', $request->id);
            $notification = Notification::whereIn('id', $ids)->delete();
            return $this->successResponse([], "Notifications deleted successfully.");
        }
    }

    public function getNotificationType(){
        $notifications = array(
            "Maintenance" => "12",
            "Survey" => "02",
            "Offers" => "50",
            "Events" => "51",
            "Classes" => "52",
            "Other" => "00",
        );
        $types = array();
        foreach($notifications as $key => $notification){
            $obj = (object)array();
            $obj->type = $notification;
            $obj->title = $key;
            array_push($types, $obj);
        }
		return $this->successResponse($types);
    }

    public function filterNotification(Request $request){
        // return $request->type;
        if(!empty($request->type)){
            $ids = explode(',', $request->type);
        $notification = Notification::whereIn('type', $ids)->get();
            $notification = $notification->where('is_read', 0);
            $notification = $notification->where('user_id', null);
        }
        else{
            $notification = Notification::whereNull('user_id')->orwhere('user_id', auth()->id())->where('is_read',0)->orderBy('id', 'desc')->get();
        }
        $data = [
            "notification" => $notification
        ];
        return $this->successResponse($data);
    }

    public function art_gallery($id=null){
        if(!empty($id)){
            $data = [
                'Art' => ArtGallery::find($id)
            ];    
            return $this->successResponse($data);
        }
    }

    public function get_newsletter(){
        // $title = NewsLetterHead::find('1');
        $heading = NewsLetterHead::find('2');
        $newsletter = NewsLetter::all();

        $data = array(
            // "title" => $title,
            "heading" => $heading,
            "newsletters" => $newsletter
        );
        return $this->successResponse($data);
    }

    public function newsletter(){
        $data = array(
            "Newsletter" => NewsLetterHead::find('1')
        );
        return $this->successResponse($data);
    }
}
