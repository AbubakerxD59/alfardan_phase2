<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Property;
use App\Jobs\ContractEnd;
use App\Models\Apartment;
use App\Models\FamilyMember;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\UserPropertyRelation;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	function __construct() {
		 $users = User::where('status', 1)->orderby('full_name', 'asc')->get();
		 View::share('userslist', $users);
		 View::share('properties', Property::all());
		 View::share('apartments', Apartment::all());
		 View::share('usertypes', ['all']);
		
		
	}
	
    public function index()
    {
		ContractEnd::dispatch();
		dispatch(new ContractEnd());
        return view('admin.users.index')->with('title','All Users');
    }
	
    public function corporate_individual()
    {
        return view('admin.users.index')->with('title','Corporate Individual')->with('usertypes',['corporate', 10]);
    } 
	
	public function family_member()
    {
        return view('admin.users.index')->with('title','Family Members')->with('usertypes',['FAMILY MEMBER']);
    }
	
    public function dashboard()
    {
        return view('admin.users.index')->with('title','Tenant')->with('usertypes',['INDIVIDUAL']);
    }
	  
	function listing(Request $request){
        $data=$request->all();
        $search=@$data['search']['value'];
        $order=end($data['order']);
        $orderby=$data['columns'][$order['column']]['data'];
    	$iTotalRecords=User::with('userpropertyrelation');
        $users=User::with('userpropertyrelation','linkfamily');
        
		if($request->has('usertypes')){
			if(count($request->usertypes)==1 ){
				 $usertypes=$request->usertypes[0];
				if($usertypes!='all'){
					$users->where('registered_as',$usertypes)->where("status",1);
					$iTotalRecords->where('registered_as',$usertypes)->where("status",1);
				}
			}else if(count($request->usertypes)>1){
				$users->whereIn('registered_as',$request->usertypes)->where("status",1);
				$iTotalRecords->whereIn('registered_as',$request->usertypes)->where("status",1);
			}
		}else if($request->has('requestonly')){
			$users->where("status",0);
			$iTotalRecords->where("status",0);
		}
		 
        if(!empty($search))
        {
            $users->where(function($q) use ($search){
               $q->orWhere('first_name','like', '%'.$search.'%');
               $q->orWhere('last_name','like', '%'.$search.'%');
               $q->orWhere('full_name','like', '%'.$search.'%');
               $q->orWhere('email','like', '%'.$search.'%');
               $q->orWhere('mobile','like', '%'.$search.'%');
               $q->orWhere('telephone','like', '%'.$search.'%');
               $q->orWhere('registered_as','like', '%'.$search.'%');
               $q->orWhere('type','like', '%'.$search.'%');				
            });
        }
        
        $users->orderBy($orderby, $order['dir']);
        $totalRecordswithFilter=clone $users;
        
        /*Set limit offset */
        $users->offset(intval($data['start']));
        $users->limit(intval($data['length']));
        
        /*Fetch Data*/
        $users=$users->get();
		  foreach($users as $k=>$user){
			  $user->rowclass="";
				// $user->dob=Carbon::createFromFormat('y-m-d H::s',  $user->dob); 
			  if(is_null($user->linkfamily) && strtolower($user->registered_as)==strtolower('FAMILY MEMBER')){
					$user->rowclass=" bg-info ";
			  }else if(strtolower($user->registered_as)==strtolower('FAMILY MEMBER')){
				  if(!$user->linkfamily->status){
				 	 $user->rowclass=" bg-info ";
				  }
			  }
			  
			  if(!$user->userpropertyrelation){
					$user->rowclass=" bg-warning ";
			  }
			  
			  if(empty($user->tenant_type)){
				 $user->rowclass=" bg-danger ";
			  }
			  
			  
			  if(strtolower($user->registered_as)!=strtolower('FAMILY MEMBER')){
				  if(strtolower($user->registered_as)!=strtolower($user->type)){
					$user->rowclass=" bg-danger ";
				  }
			  }
			  
			  if(empty($user->registered_as)|| empty($user->type) || $user->type=='-'){
				 $user->rowclass=" bg-danger ";
			  }
			  
			  if(strtolower($user->type)==strtolower('FAMILY MEMBER')){
					$user->rowclass=" bg-danger ";
			  }
			  
			  	  
			  $users[$k]=$user;
		  }
        return response()->json([
               "draw" => intval($data['draw']),
                "iTotalRecords" => $iTotalRecords->count(),
                "iTotalDisplayRecords" => $totalRecordswithFilter->count(),
                "aaData" => $users
            ]);
    }

	
	 public function create(){
    
		
	}

    public function store(Request $request)
	{
		
	}
	
	public function show($id){
 		$user=User::findOrFail($id);
		if(strtolower($user->registered_as)==strtolower('FAMILY MEMBER')){
			return redirect()->route('admin.family_member_view',[$id]);
		}else if(strtolower($user->registered_as)==strtolower('CORPORATE')){
			return redirect()->route('admin.corporate_view',[$id]);
		}
        return view('admin.users.show')->with('user',$user);
    }
	
	
	
	public function edit($id)
    {
		$user=User::findOrFail($id);
		//$user->dob=$this->changedate($user->dob);
		if(!$user->status){
			
			//dd($user->familylink);
			return view('admin.users.modals.allrequested')->with('user',$user);
		}
		
		
		if(strtolower($user->registered_as)==strtolower('FAMILY MEMBER')){
			return view('admin.users.modals.editfamily_member')->with('user',$user);
		}else if(strtolower($user->registered_as)==strtolower('CORPORATE')){
			 $users = User::where('status', 1)->orderby('id', 'desc')->get();
			return view('admin.users.modals.editcorporate')->with('user',$user);
		}
		return view('admin.users.modals.edittenant')->with('user',$user);
		
    }
	
	// public function changedate($date){
	// 	if($date){
	// 		$data=$date;
	// 		$explode_date=explode("-",$date);
	// 		if($explode_date['0']<1000){
	// 			$month=$explode_date['0'];
	// 			$day=$explode_date['1'];
	// 			$year=$explode_date['2'];
	// 			$new_date=$year.'-'.$month.'-'.$day;		
	// 			return $new_date;
	// 		}
	// 		return $data;
	// 	}
	// }
	
	
	public function update(Request $request, $id)
	{
		$user=User::findOrFail($id);
		$rule=['full_name'=>'required|max:190'];
		$rule['registered_as']='required';
		$rule['type']='required';
		$rule['mobile']='required|max:190';
		$rule['email']= ['required',Rule::unique($user->getTable())->ignore($user->id, 'id')];
		if(!$user->status){
			$rule['tenant_type']='required';
			$rule['contract']='mimes:pdf|max:8000';
		}else if(strtolower($user->registered_as)==strtolower('FAMILY MEMBER')){
			if($user->status){
		 		//$rule['linkfamily']='required';
			}
		}else if(strtolower($user->registered_as)==strtolower('CORPORATE')){
		 	$rule['company_name']='required|max:190';
		 	$rule['property']='required';
		 	$rule['original_tenant_name']='required|max:190';
		}else{
		 	$rule['start_date']='required';
		 	$rule['tenant_type']='required';
		 	$rule['property']='required';
		}
		$validated = $request->validate($rule);
		
		 $user->full_name=$request->full_name;
		 $user->registered_as=$request->registered_as;
		 $user->type=$request->type;
		 $user->mobile=$request->mobile;
		 $user->email=$request->email;
		
		if($request->has('company_name')){
		 	$user->company_name=$request->company_name;
		}
		
		if($request->has('original_tenant_name')){
		 	$user->original_tenant_name=$request->original_tenant_name;
		}
		
		if($request->has('start_date')){
		 	$user->start_date=$request->start_date;
		}
		
		if($request->has('tenant_type')){
		 	$user->tenant_type=$request->tenant_type;
		}
		
		if($request->has('dob')){
		 	$user->dob=$request->dob;
		}
		
		if($request->has('end_date')){
		 	$user->end_date=$request->end_date;
		}
		
		if($request->has('password')){
		 	//$user->end_date=$request->end_date;
		}
		
		if($request->has('property')){
		 	$user->property=$request->property;
		}
		
		if($request->has('apartment')){
		 	$user->apt_number=$request->apartment;
		}
		
		
		if($request->has('contract')){
			$file = $request->File('contract');
			$contract = $file->getClientOriginalName();
			$destinationPath = public_path() . '/uploads';
			$file->move($destinationPath, $contract);
			$user->contract=$contract;
		}
		
		if($request->has('linkfamily')&& !empty(@$request->linkfamily)){
			
			if($user->linkfamily){
				$link=$user->linkfamily;
				
			}else if($user->familylink){
				$link=$user->familylink;
				
			}else{
				$link=new FamilyMember();
				$link->name=$user->full_name;
				$link->email=$user->email;
				$link->phone_number=$user->mobile;
				$link->status=0;
			}
			
			if($user->status){
				$link->user_id=$user->id;
			}
			$allowchangep=$link->refrence_id!=$request->linkfamily?true:false;
			 
			
			$link->refrence_id=$request->linkfamily;
			$link->save();
			
			if($allowchangep){
				UserPropertyRelation::where('user_id', $user->id)->update(['status'=>0]);
				$user->setfamiltmemberproperty();
			}
		}
		
		
		$user->save();
		
		
		if($request->has('property') && $request->has('apartment')){
			if($request->property!=@$user->userpropertyrelation->property_id || $request->apartment!=@$user->userpropertyrelation->apartment_id){
				
				UserPropertyRelation::where('user_id', $user->id)->update(['status'=>0]);
				
				if(strtolower($user->registered_as)==strtolower('FAMILY MEMBER')){
				
					$user->setfamiltmemberproperty();
				}else{
					$property_details = array(
						'user_id' => $user->id,
						'property_id' => $request->property,
						'apartment_id' => $request->apartment,
						'status' => 1,
					);
					UserPropertyRelation::create($property_details);
					
				}
				
			}
		
		}
		
		return back()->with('flash_success', 'Record Updated Successfully!');
	}
	
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('users.index');
    }
 
    public function allrequests()
    {
       return view('admin.users.requests');
    }
	
	
    public function familylisting(Request $request)
    {
        $data=$request->all();
        $search=@$data['search']['value'];
        $order=end($data['order']);
        $orderby=$data['columns'][$order['column']]['data'];
    	$iTotalRecords=FamilyMember::with('user');
      	$family = FamilyMember::with('user')->where('status', 0);
		

		$admin=\App\Helpers\helpers::$admin;
		 if($admin->type>2){
			 $property=json_decode($admin->property_id); 
			 $family->whereHas('user',function ($query) use ($property) {
				 $query->whereHas('userpropertyrelation',function ($query) use ($property) {
					 $query->whereIn('property_id',$property);
				 });
			 }); 
		}
		
		
		
        if(!empty($search))
        {
            $family->where(function($q) use ($search){
               $q->orWhere('name','like', '%'.$search.'%');
               $q->orWhere('email','like', '%'.$search.'%');
               $q->orWhere('phone_number','like', '%'.$search.'%');
				$q->orwhereHas('user',function ($query) use ($search) {
					$query->Where(function($q) use ($search){
						$q->orWhere('first_name','like', '%'.$search.'%');
						$q->orWhere('last_name','like', '%'.$search.'%');
						$q->orWhere('full_name','like', '%'.$search.'%');
						$q->orWhere('email','like', '%'.$search.'%');
						$q->orWhere('mobile','like', '%'.$search.'%');
						$q->orWhere('telephone','like', '%'.$search.'%');
						$q->orWhere('registered_as','like', '%'.$search.'%');
						$q->orWhere('type','like', '%'.$search.'%');	
					});
				});
            });
        }
		
		
		
		$totalRecordswithFilter = clone $family;
		
		$family->orderBy($orderby, $order['dir']);
        
        /*Set limit offset */
        $family->offset(intval($data['start']));
        $family->limit(intval($data['length']));
		
		
		$family=$family->get();
		foreach($family as $k=>$val){
			$val->submitted_date=$val->created_at->format('Y-m-d H:i:s');
			$family[$k]=$val;
		}
		
		   return response()->json([
               "draw" => intval($data['draw']),
                "iTotalRecords" => $iTotalRecords->count(),
                "iTotalDisplayRecords" => $totalRecordswithFilter->count(),
                "aaData" => $family
           ]);
    }

	public function expiredContracts(){
		$today = date("Y-m-d");
		$users = User::where('end_date', '<=', $today)->get();
		return view('admin.users.expired_contracts')->with('title','Expired Contracts');
	}

	function expiredListing(Request $request){
        $data=$request->all();
        $search=@$data['search']['value'];
        $order=end($data['order']);
        $orderby=$data['columns'][$order['column']]['data'];
    	$iTotalRecords=User::with('userpropertyrelation');
		$today = date("Y-m-d");
		$users = User::with('userpropertyrelation','linkfamily')->where('end_date', '<=', $today);
        // $users=User::with('userpropertyrelation','linkfamily');
        
		if($request->has('usertypes')){
			if(count($request->usertypes)==1 ){
				 $usertypes=$request->usertypes[0];
				if($usertypes!='all'){
					$users->where('registered_as',$usertypes)->where("status",1);
					$iTotalRecords->where('registered_as',$usertypes)->where("status",1);
				}
			}else if(count($request->usertypes)>1){
				$users->whereIn('registered_as',$request->usertypes)->where("status",1);
				$iTotalRecords->whereIn('registered_as',$request->usertypes)->where("status",1);
			}
		}else if($request->has('requestonly')){
			$users->where("status",0);
			$iTotalRecords->where("status",0);
		}
		 
        if(!empty($search))
        {
            $users->where(function($q) use ($search){
               $q->orWhere('first_name','like', '%'.$search.'%');
               $q->orWhere('last_name','like', '%'.$search.'%');
               $q->orWhere('full_name','like', '%'.$search.'%');
               $q->orWhere('email','like', '%'.$search.'%');
               $q->orWhere('mobile','like', '%'.$search.'%');
               $q->orWhere('telephone','like', '%'.$search.'%');
               $q->orWhere('registered_as','like', '%'.$search.'%');
               $q->orWhere('type','like', '%'.$search.'%');				
            });
        }
        
        $users->orderBy($orderby, $order['dir']);
        $totalRecordswithFilter=clone $users;
        
        /*Set limit offset */
        $users->offset(intval($data['start']));
        $users->limit(intval($data['length']));
        
        /*Fetch Data*/
        $users=$users->get();
		  foreach($users as $k=>$user){
			  $user->rowclass="";
				// $user->dob=Carbon::createFromFormat('y-m-d H::s',  $user->dob); 
			  if(is_null($user->linkfamily) && strtolower($user->registered_as)==strtolower('FAMILY MEMBER')){
					$user->rowclass=" bg-info ";
			  }else if(strtolower($user->registered_as)==strtolower('FAMILY MEMBER')){
				  if(!$user->linkfamily->status){
				 	 $user->rowclass=" bg-info ";
				  }
			  }
			  
			  if(!$user->userpropertyrelation){
					$user->rowclass=" bg-warning ";
			  }
			  
			  if(empty($user->tenant_type)){
				 $user->rowclass=" bg-danger ";
			  }
			  
			  
			  if(strtolower($user->registered_as)!=strtolower('FAMILY MEMBER')){
				  if(strtolower($user->registered_as)!=strtolower($user->type)){
					$user->rowclass=" bg-danger ";
				  }
			  }
			  
			  if(empty($user->registered_as)|| empty($user->type) || $user->type=='-'){
				 $user->rowclass=" bg-danger ";
			  }
			  
			  if(strtolower($user->type)==strtolower('FAMILY MEMBER')){
					$user->rowclass=" bg-danger ";
			  }
			  
			  	  
			  $users[$k]=$user;
		  }
        return response()->json([
               "draw" => intval($data['draw']),
                "iTotalRecords" => $iTotalRecords->count(),
                "iTotalDisplayRecords" => $totalRecordswithFilter->count(),
                "aaData" => $users
            ]);
    }
}
