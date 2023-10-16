<?php

namespace App\Http\Controllers\Admin;

use App\Models\Property;
use Illuminate\Support\Str;
use App\Models\ArtGalleries;
use Illuminate\Http\Request;
use Image as InterventionImage;
use App\Http\Controllers\Controller;

class ArtGalleriesController extends Controller
{
    public function index(){
        $properties = Property::all();
        $art = ArtGalleries::orderby('id', 'desc')->paginate(10);
        return view('admin.art_galleries')
            ->with('properties', $properties)
            ->with('arts', $art);
    }
    public function addArtGallery(Request $request)
    {
        $this->validate($request, ArtGalleries::getRules());

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
            // $img_resize = InterventionImage::make($file->getRealPath())
            //     ->orientate()->save(public_path('uploads/' . $image));
            $input['photo'] = $image;
        }
        $art = ArtGalleries::create($input);
        return redirect()->back()->with('flash_success', 'Record added Successfully!');
    }

    public function getArtGallery(Request $request)
    {
        $result = ArtGalleries::where('id', $request->id)->first();
        return $result;

    }
    public function updateArtGallery(Request $request)
    {
        if ($request->input('artid')) {

            $this->validate($request, ArtGalleries::getRules());
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
                // $img_resize = InterventionImage::make($file->getRealPath())
                //     ->orientate()->save(public_path('uploads/' . $image));
                $detail = array(
                    'photo' => $image,
                );
                ArtGalleries::where('id', $request->artid)->update($detail);
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
            ArtGalleries::where('id', $request->artid)->update($details);
            return redirect()->back()->with('flash_success', 'Record updated Successfully!');
        }
    }

    public function deleteArtGallery(Request $request)
    {
        $result = ArtGalleries::find($request->artid)->delete();
        if ($result) {
            return redirect()->back()->with('flash_success', 'Record Deleted Successfully!');
        }
    }
}
