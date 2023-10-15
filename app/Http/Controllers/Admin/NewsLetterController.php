<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsLetter;
use App\Models\NewsLetterHead;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image as InterventionImage;

class NewsLetterController extends Controller
{
    public function index()
    {
        $newsletters = NewsLetter::all();
        $heads = NewsLetterHead::where('type', '1')->first();
        $news = NewsLetterHead::where('type', '2')->first();
        return view('admin.news_letter')
            ->with('heads', $heads)
            ->with('news', $news)
            ->with('newsletters', $newsletters);
    }

    public function newsletter_title(Request $request)
    {
        $validated = $request->validate([
            "title" => 'required',
            "photo" => 'sometimes',
        ]);
        if ($request->input('publish')) {
            $status = 1;
        } elseif ($request->input('draft')) {
            $status = 0;
        }
        $photo = null;

        if ($request->hasFile('photo') != '') {
            $file = $request->File('photo');
            $photo = Str::slug(time() . $file->getClientOriginalName());
            $img_resize = InterventionImage::make($file->getRealPath())->orientate()->save(public_path('uploads/' . $photo));
        }

        $detail = array(
            "title" => $request->title,
            "photo" => $photo,
            "status" => $status,
            "type" => "1"
        );
        $news = NewsLetterHead::updateOrCreate([
            "type" => "1",
        ], $detail);
        return redirect()->back()->with('flash_success', 'Record added Successfully!');
    }

    public function add_newsletter(Request $request)
    {
        $validated = $request->validate([
            "newletter_title" => "required",
            "newletter_date" => "required|date",
            "intro" => "required",
            "section_title" => "required",
            "section_description" => "required",
            // "cta_button" => "required",
            // "cta_link" => "required",
            //"photo" => "required",
        ]);
        $create = true;
        if ($request->input('publish')) {
            $status = 1;
        } elseif ($request->input('draft')) {
            $status = 0;
        }
        $photo = '';
        if ($request->hasFile('photo') != '') {
            $file = $request->File('photo');
            $photo = Str::slug(time() . $file->getClientOriginalName());
            $img_resize = InterventionImage::make($file->getRealPath())->orientate()->save(public_path('uploads/' . $photo));
        }
        $heading = array(
            'title' => $request->newletter_title,
            'publish_date' => date('Y-m-d', time()),
            'intro' => $request->intro,
            'photo' => $photo,
            'status' => $status,
            'type' => '2'
        );

        $news = NewsLetterHead::updateOrCreate([
            "type" => "2",
        ], $heading);
        for ($i = 0; $i < count($request->section_title); $i++) {
            // dd($request->section_id);
            $create = true;
            if (isset($request->section_id[$i])) {
                $create = false;
            }
            // dd($request->all());
            $detail = array(
                "title" => $request->section_title[$i],
                "description" => $request->section_description[$i],
                "cta_button" => count($request->cta_button) ? $request->cta_button[$i] : null,
                "cta_link" => count($request->cta_link) ? $request->cta_link[$i] : null,
                "photo" => $photo,
                "status" => $status,
                "head_id" => "2",
            );
            if ($create) {
                $news = NewsLetter::create($detail);
            } else {
                $news = NewsLetter::find($request->section_id[$i]);
                $news->update($detail);
            }
        }
        return redirect()->back()->with('flash_success', 'Record added Successfully!');
    }

    public function deleteHead(Request $request){
        // dd($request->all());
        $id = $request->headid;
        NewsLetterHead::find($id)->delete();
        return redirect()->back()->with('flash_success', 'Record deleted Successfully!');
    }

    public function deleteNews(Request $request){
        $id = $request->newsid;
        NewsLetter::find($id)->delete();
        return redirect()->back()->with('flash_success', 'Record deleted Successfully!');
    }
}
