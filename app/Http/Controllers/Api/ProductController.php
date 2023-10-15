<?php

namespace App\Http\Controllers\Api;
use Carbon\Carbon; 
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Product;

class ProductController extends BaseController
{
    public function buy(Request $request)
    {
		$sold_product = Product::where('status', '3')->get();
        $endDate = Carbon::now();
        foreach($sold_product as $val){
            $startDate = Carbon::parse($val->updated_at);
            $monthsDifference = $startDate->diffInMonths($endDate);
            if($monthsDifference >= 3){
                $val->deleted_at = Carbon::now();
                $val->save();
            }
        }
		
        $categories = ProductCategory::all();
        $category_id = $request->category_id ?? $categories->first()->id;
        
       $newely_added = Product::where('status',1);
        if(intval($category_id)>0){
            $newely_added->where('category_id', $category_id);
        }
        

        if($request->has('property_id')){
            $property_id=$request->property_id;
            $newely_added->whereHas('seller', function ($qry) use ($property_id) {
                $qry->whereHas('userpropertyrelation', function ($qry) use ($property_id) {

                     $qry->where('property_id', $property_id); 
                });
            });
        }

       if($request->has('max_price')){
            $newely_added->where('price','<=', $request->max_price);
        }

        if($request->has('min_price')){
            $newely_added->where('price','>=', $request->min_price);
        }

        if($request->has('keyword')){
            $keyword=$request->keyword;
              $newely_added->where(function ($query) use ($keyword) {
                 $query->where('name','like', "%".$keyword."%");
                 $query->orWhere('description','like', "%".$keyword."%");
                 $query->orWhere('condition','like', "%".$keyword."%");
              });
        }



        $newely_added->orderBy('id', 'desc');

        $featured = clone $newely_added;

        $newely_added=$newely_added->where('featured', '0')->get();


        $featured=$featured->where('featured', 1)->orderby('id','DESC')->get();
		
        $location = $request->location;
        $price = $request->price;

        $data = [
            'categories' => $categories,
            'category_id' => $category_id,
            'newely_added' => $newely_added,
            'featured' => $featured,
            'location' => $location,
            'price' => $price
        ];

        return $this->successResponse($data);
    }

    public function show($id)
    {
        $product = Product::with(['images', 'seller'])->where('id', $id)->first();

        return $this->successResponse($product);
    }

    public function my()
    {
        $products = Product::where('user_id', auth()->id())->orderby('id','DESC')->get();

        return $this->successResponse($products);
    }

    public function categories()
    {
        $categories = ProductCategory::all();
        
        return $this->successResponse($categories);
    }

    public function add(Request $request)
    {
        $product = Product::create($request->all() + ['user_id' => auth()->id()]);

        //if ($request->image_ids) {
        //    $product->addImages($request->image_ids);
      //  }
		 if ($request->file('images')) {
           $product->addImages($request->file('images'));
        }
		$data=[
		'images' =>$product->images
		];
        return $this->successResponse($product, 'Product has been added successfully');
    }

    public function remove($id,$sold=0)
    {
        $product=Product::findOrFail($id);
		if($sold==1){
			$product->status=3;
			$product->save();
		}else{
			$product->delete();		
		}
		
        return $this->successResponse([], 'Product has been removed successfully');
    }
	public function all(){
		 $product = Product::with(['images','category','seller'])->where('status',1)->where('featured','0')->orderby('id','DESC')->paginate(10);

        return $this->successResponse($product);
	}

	public function all_featured(){
		 $product = Product::with(['images','category','seller'])->where('status',1)->where('featured','1')->orderby('id','DESC')->paginate(10);

        return $this->successResponse($product);
	}
}
