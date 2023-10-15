<?php
 
namespace App\Scopes;
 
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Auth;
use App\Models\Employee;
 
class UserScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $tables = array("properties","users","products","chats","tenant_registrations","service_requests","pet_applications","maintenance_absentia_requests","access_key_requests","vehicle_requests","housekeeper_requests","complaints",'guest_access_requests');
	 
		 if (Auth::check() && !in_array($model->getTable(), $tables)) {
			 
			 $property=\Schema::hasColumn($model->getTable(), 'property')?'property':'';
			 $property=\Schema::hasColumn($model->getTable(), 'property_id')?'property_id':$property;
			 
			 $apartment=\Schema::hasColumn($model->getTable(), 'apartment_id')?'apartment_id':'';
			 $apartment=\Schema::hasColumn($model->getTable(), 'apartment')?'apartment':$apartment;
			 
			 $tenant_type=\Schema::hasColumn($model->getTable(), 'tenant_type')?'tenant_type':'';
			 
             $user=Auth::user();
			 
			 if(\Schema::hasColumn($model->getTable(), 'status')){
				 
			 }
			
			 $builder->orderBy('id', 'DESC');
			 
			 
			 if(!empty($property)){
				 $builder->where(function($query) use ($user,$property){
					$query->orwhere($property,$user->userpropertyrelation->property_id);
					$query->orwhere($property,'like','%,'.$user->userpropertyrelation->property_id);
					$query->orwhere($property,'like',$user->userpropertyrelation->property_id.',%');
					$query->orwhere($property,'like','%,'.$user->userpropertyrelation->property_id.',%');
				});
			 }
			
			 if(!empty($tenant_type)){
				  $builder->where(function($query) use ($user,$tenant_type){
					  $query->orwhere($tenant_type,$user->tenant_type);
					  $query->orwhere($tenant_type,'like',$user->tenant_type.',%');
					  $query->orwhere($tenant_type,'like','%,'.$user->tenant_type.',%');
					  $query->orwhere($tenant_type,'like','%,'.$user->tenant_type);

				 });
			 }
			 
			 if(!empty($apartment)){
				 $builder->where(function($query) use ($user,$apartment){
					$query->orwhere($apartment,$user->userpropertyrelation->apartment_id);
					$query->orwhere($apartment,'like','%,'.$user->userpropertyrelation->apartment_id);
					$query->orwhere($apartment,'like',$user->userpropertyrelation->apartment_id.',%');
					$query->orwhere($apartment,'like','%,'.$user->userpropertyrelation->apartment_id.',%');
				});
			 }
			 
			  //->where('status','=',1)
			 //dd($user->userpropertyrelation->property_id);
        }else if(Auth::guard('admin')->check()){
			  //dd($model);
			if(method_exists($model,'scopeAdmin')){
				$builder->Admin();
			}
			 
		}
		
    }
}