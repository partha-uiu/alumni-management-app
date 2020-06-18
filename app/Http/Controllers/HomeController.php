<?php

namespace App\Http\Controllers;

use App\HomeContent;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ((Auth::Check()) && (Auth::user()->hasAnyRole('super-admin|admin|editor|faculty-stuff'))) {
            return redirect()->route('admin.home');
        }

        if ((Auth::Check()) && (Auth::user()->hasAnyRole('alumni|student'))) {
            return redirect()->route('user.home');
        }

        $alumni = User::with('profile')->whereHas('userType', function ($query) {
                    $query->where('name', 'alumni')
                          ->orWhere('name', 'faculty-stuff')
                          ->orWhere('name', 'student');
        })->where('is_approved', 1)->where('is_deleted', 0)->latest()->limit(12)->get();

        $home = HomeContent::first();

        if (!$home) {
            $home = false;
        }
        
        return view('home.index')
            ->with('alumni', $alumni)->with('home', $home);
    }

    public function update(Request $request)
    {
        $homeData = HomeContent::first();
        if ($homeData) {
            $id = $homeData->id;
            $home = HomeContent::find($id);
        } else {
            $home = New HomeContent;
        }

        if ($request->file('logo_url')) {
            $logoImage = $request->file('logo_url');
            $logoImageSaveAsName = time() . Auth::id() . "-logo." . $logoImage->getClientOriginalExtension();
            $logoImage->storeAs('public/logo', $logoImageSaveAsName);
            $logoImageUrl = "logo/" . $logoImageSaveAsName;
        } elseif ($homeData) {
            $logoImageUrl = $homeData->logo_url;
        } else {
            $logoImageUrl = null;
        }

        if ($request->file('home_image_url')) {
            $homeImage = $request->file('home_image_url');
            $homeImageSaveAsName = time() . Auth::id() . "-home." . $homeImage->getClientOriginalExtension();
            $homeImage->storeAs('public/home', $homeImageSaveAsName);
            $homeImageUrl = "home/" . $homeImageSaveAsName;
        } elseif ($homeData) {
            $homeImageUrl = $homeData->home_image_url;
        } else {
            $homeImageUrl = null;
        }

        $home->alumni_association_title = $request->alumni_association_title;
        $home->logo_url = $logoImageUrl;
        $home->home_image_url = $homeImageUrl;
        $home->nav_color = $request->nav_color;
        $home->box_title_1 = $request->box_title_1;
        $home->box_description_1 = $request->box_description_1;
        $home->box_title_2 = $request->box_title_2;
        $home->box_description_2 = $request->box_description_2;
        $home->box_title_3 = $request->box_title_3;
        $home->box_description_3 = $request->box_description_3;
        $home->box_title_4 = $request->box_title_4;
        $home->box_description_4 = $request->box_description_4;
        $home->content_box_5_title = $request->content_box_5_title;
        $home->content_box_5_description = $request->content_box_5_description;
        $home->contact_heading = $request->contact_heading;
        $home->contact_description = $request->contact_description;
        $home->save();

        return redirect()->back()->with('success', 'Home page contents has been successfully updated !');

    }

    public function notApproved()
    {
        return view('approval.index');
    }

    public function destroyLogo()
    {
        $getHomeContent = HomeContent::select('logo_url')->first();
        if (file_exists('storage/' . $getHomeContent->logo_url)) {

            unlink('storage/' . $getHomeContent->logo_url);
            $home = HomeContent::first();
            $home->logo_url = null;
            $home->save();

            return redirect()->back()->with('success', "Logo has been successfully removed");
        }
    }

    public function destroyBackgroundImage()
    {
        $getHomeContent = HomeContent::select('home_image_url')->first();
        if (file_exists('storage/' . $getHomeContent->home_image_url)) {

            unlink('storage/' . $getHomeContent->home_image_url);
            $home = HomeContent::first();
            $home->home_image_url = null;
            $home->save();

            return redirect()->back()->with('success', "Home background has been successfully removed");
        }
    }

}
