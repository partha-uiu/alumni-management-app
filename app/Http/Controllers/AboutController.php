<?php

namespace App\Http\Controllers;

use App\AboutContent;
use App\HomeContent;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $about = AboutContent::first();

        $home = HomeContent::first();
        if (!$home) {
            $home = false;
        }

        return view('about.index')->with('about', $about)->with('home', $home);
    }

    public function update(Request $request)
    {
        $aboutData = AboutContent::first();

        if (!$aboutData) {
            $about = new AboutContent;
        } else {
            $id = $aboutData->id;
            $about = AboutContent::find($id);
        }
        $about->alumni_title = $request->alumni_title;
        $about->department_slogan_title = $request->department_slogan_title;
        $about->department_slogan_elaboration = $request->department_slogan_elaboration;
        $about->mission_vision_title = $request->mission_vision_title;
        $about->mission_vision_description = $request->mission_vision_description;
        $about->foundation_date = $request->foundation_date;
        $about->total_alumni = $request->total_alumni;
        $about->current_students = $request->current_students;
        $about->save();
        $aboutTab = 1;
        return redirect()->back()->with('success', 'About page contents has been successfully updated !')->with('aboutTab', $aboutTab);
    }

}
