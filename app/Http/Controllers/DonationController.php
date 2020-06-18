<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonationRequest;
use App\Donation;
use App\Session;
use App\Institution;
use App\Department;
use App\UserActivity;
use App\Http\Requests\UpdateDonationRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $q = Donation::query();

        if ($request->filled('q')) {
            $searchKeyword = $request->q;
            $q->where(function ($query) use ($searchKeyword) {
                $query->where('title', 'like', '%' . $searchKeyword . '%')
                    ->orWhere('description', 'like', '%' . $searchKeyword . '%')
                    ->orWhere('payment_info', 'like', '%' . $searchKeyword . '%');
            });
        }
        if ($request->filled('status')) {

            $status = $request->status;

            if ($status == 'approved') {
                $q->where('is_approved', '=', 1);
            } elseif ($status == 'pending') {
                $q->where('is_approved', '=', 0);

            }
        }

        $allDonations = $q->latest()->paginate(10);


        $donations = $q->filteredDonations($q)->where('is_approved', 1)->latest()->paginate(10);

        return view('donations.index')
            ->with('approvedDonations', $donations)
            ->with('allDonations', $allDonations);
    }

    public function create()
    {
        $latestDonations = Donation::where('is_approved', 1)->latest()->take(5)->get();

        $sessions = Session::all();
        $department = Department::first();
        $institution = Institution::first();

        return view('donations.create')->with('latestDonations', $latestDonations) 
                                        ->with('sessions',  $sessions)
                                        ->with('department', $department)
                                        ->with('institution', $institution);
    }

    public function store(StoreDonationRequest $request)
    {
        $userId = Auth::id();
        $donation = new Donation;
        $donation->user_id = $userId;
        $donation->title = $request->title;
        $donation->description = $request->description;
        $donation->payment_info = $request->payment_info;

        if( $request->session_id =='all')
            
             {
               $donation->session_id = null;
             }
        else
             {
               $donation->session_id = $request->session_id;

             }
        

        $donation->department_id = $request->department_id;
        $donation->institution_id = $request->institution_id;

        if ($request->start_date) {
            $donation->start_date = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
        }
        if ($request->end_date) {
            $donation->end_date = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');
        }

        if ($request->hasFile('image_url')) {
            $donationImage = $request->file('image_url');
            $donationImageSaveAsName = time() . Auth::id() . "-donation." . $donationImage->getClientOriginalExtension();
            $donationImage->storeAs('public/donation', $donationImageSaveAsName);
            $donation->image_url = "donation/" . $donationImageSaveAsName;
        }

        $user = Auth::user();

        if ($user->hasAnyRole('super-admin|admin|editor|faculty-stuff')) {
            $donation->is_approved = '1';
        }

        $donation->save();
        if ($user->hasAnyRole('super-admin|admin|editor|faculty-stuff')) {

            UserActivity::logActivity(Auth::user()->id, 'donation_approved', ['relatable_type' => 'App\Donation','relatable_id'=> $donation->id]);

        }

        UserActivity::logActivity(Auth::user()->id, 'donation_created', ['relatable_type' => 'App\Donation','relatable_id'=>  $donation->id]);

        return redirect()->back()->with('success', 'Donation has been successfully added');

    }

    public function edit($id)
    {
        $donation = Donation::find($id);
        $latestDonations = Donation::where('is_approved', 1)->latest()->take(5)->get();

        return view('donations.edit')
            ->with('donation', $donation)
            ->with('latestDonations', $latestDonations);

    }

    public function show($id)
    {
        $donation = Donation::find($id);
        $latestDonations = Donation::where('is_approved', 1)->latest()->take(5)->get();

        return view('donations.show')
            ->with('donation', $donation)
            ->with('latestDonations', $latestDonations);
    }

    public function update($id, UpdateDonationRequest $request)
    {
        $donation = Donation::find($id);
        $donation->title = $request->title;
        $donation->description = $request->description;
        $donation->payment_info = $request->payment_info;
        if ($request->start_date) {
            $donation->start_date = Carbon::createFromFormat('d-M-Y', $request->start_date)->format('Y-m-d');
        }
        if ($request->end_date) {
            $donation->end_date = Carbon::createFromFormat('d-M-Y', $request->end_date)->format('Y-m-d');
        }
        if ($request->hasFile('image_url')) {
            $donationImage = $request->file('image_url');
            $donationImageSaveAsName = time() . Auth::id() . "-donation." . $donationImage->getClientOriginalExtension();
            $donationImage->storeAs('public/donation', $donationImageSaveAsName);
            $donation->image_url = "donation/" . $donationImageSaveAsName;
        }

        $donation->edited_by = Auth::id();
        $donation->edit_time = Carbon::now()->toDateTimeString();

        $donation->save();

        return redirect()->back()->with('success', 'Donation has been updated!');
    }

    public function destroy($id)
    {
        Donation::find($id)->delete();

        return redirect()->back()->with('success', 'Donation has been deleted!');
    }

    public function approve($id)
    {
        Donation::where('id', $id)->update(['is_approved' => 1, 'approved_by' => Auth::id()]);

        UserActivity::logActivity(Auth::user()->id, 'donation_approved', ['relatable_type' => 'App\Donation','relatable_id'=> $id]);



        return redirect()->back()->with('success', 'Donation has been successfully approved !');
    }

    public function batchAction(Request $request)
    {
        $action = $request->action;
        $ids = $request->ids;
        $arrayIds = explode(",", $ids);

        if ($action == 'approve') {
            Donation::whereIn('id', $arrayIds)->update(['is_approved' => 1, 'approved_by' => Auth::id()]);
        foreach($arrayIds as $arrayId) {
              UserActivity::logActivity(Auth::user()->id, 'donation_approved', ['relatable_type' => 'App\Donation','relatable_id'=> $arrayId]);
       
           }

        } elseif ($action == 'disapprove') {
            Donation::whereIn('id', $arrayIds)->update(['is_approved' => 0, 'approved_by' => null]);
        } elseif ($action == 'delete') {
            Donation::whereIn('id', $arrayIds)->delete();
        }

        return redirect()->back()->with('success', 'Action Successfully Done !');
    }

}
