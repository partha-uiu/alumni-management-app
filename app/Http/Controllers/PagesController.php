<?php

namespace App\Http\Controllers;

use App\AboutContent;
use App\Committee;
use App\CommitteeMember;
use App\HomeContent;
use App\Institution;
use App\Department;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        $home = HomeContent::first();
        $about = AboutContent::first();
        $committeeTitle = Committee::first();
        $committeeMembers = CommitteeMember::all();

        $department = Department::first();
        $institution = Institution::first();

        return view('pages.index')->with('about', $about)
            ->with('committeeTitle', $committeeTitle)
            ->with('committeeMembers', $committeeMembers)
            ->with('home', $home) 
            ->with('department', $department)
            ->with('institution', $institution);

    }
}
