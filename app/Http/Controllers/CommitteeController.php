<?php

namespace App\Http\Controllers;

use App\Committee;
use App\CommitteeMember;
use App\HomeContent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommitteeController extends Controller
{
    public function index()
    {
        $committee = Committee::first();

       
        if($committee) {

            $committeeMembers = CommitteeMember::where('committee_id', $committee->id)->get();
        
        }
        else {
            $committeeMembers = false;
            $committee = false;
        }

        $home = HomeContent::first();

        if (!$home) {
            $home = false;
        }
        

        return view('committee.index')
            ->with('committee', $committee)->with('committeeMembers', $committeeMembers)->with('home', $home);
    }

    public function update(Request $request)
    {
        if ($request->has('committee')) {

            $request->validate([
                'title' => 'required',
            ]);

            $committee = Committee::first();

            if (!$committee) {
                $committee = new Committee;
            } else {
                $id = $committee->id;
                $committee = Committee::find($id);
            }

            $committee->title = $request->title;
            $committee->description = $request->description;
            
            $committee->department_id = $request->department_id;
            $committee->institution_id = $request->institution_id;

            $committee->save();
            $committeeTab = "active";

            return redirect()->back()->with('success', 'Committee has been successfully updated')->with('committeeTab', $committeeTab);
     
        } elseif ($request->has('committee_members')) {
            $request->validate([
                'member_name.*' => 'required',
                'member_title.*' => 'required',
            ]);

            if (count($request->member_name) && ($request->member_name[0] != null)) {
                $url = [];
                if ($request->file('member_image')) {
                    $files = $request->file('member_image');
                    foreach ($files as $file) {
                        $photoSaveAsName = Auth::id() . time() . rand(0, 10000) . "-member." . $file->getClientOriginalExtension();
                        $file->storeAs('public/member', $photoSaveAsName);
                        $url[] = "member/" . $photoSaveAsName;
                    }
                }

                $memberCount = count($request->member_name);

                $now = Carbon::now()->toDateTimeString();

                $memberDetails = [];

                $committee = Committee::first();

                if (!$committee) {
                    return redirect()->back()->with('error', 'Please add a Committee first');
                }

                $id = $committee->id;

                for ($i = 0; $i < $memberCount; $i++) {
                    $memberDetails[$i]['committee_id'] = $id;
                    $memberDetails[$i]['member_name'] = $request->member_name[$i];
                    $memberDetails[$i]['member_title'] = $request->member_title[$i];
                    if (count($url)) {
                        $memberDetails[$i]['member_image'] = $url[$i];
                    } else {
                        $memberDetails[$i]['member_image'] = null;
                    }
                    $memberDetails[$i]['created_at'] = $now;
                    $memberDetails[$i]['updated_at'] = $now;
                }
                CommitteeMember::insert($memberDetails);
                $committeeTab = "active";

                return redirect()->back()->with('success', 'Committee member successfully updated')->with('committeeTab', $committeeTab);

            }
        }
    }

    public function editMember(Request $request, $id)
    {
        $member = CommitteeMember::find($id);

        return view('committee.member-edit')->with('member', $member);
    }

    public function updateMember(Request $request, $id)
    {
        $request->validate([
            'member_name' => 'required',

        ]);

        $member = CommitteeMember::find($id);
        $member->member_name = $request->member_name;
        $member->member_title = $request->member_title;

        if ($request->hasFile('member_image')) {
            $memberImage = $request->file('member_image');
            $memberImageSaveAsName = time() . Auth::id() . "-member" . $memberImage->getClientOriginalExtension();
            $memberImage->storeAs('public/member', $memberImageSaveAsName);
            $member->member_image = "member/" . $memberImageSaveAsName;
        }
        $member->save();

        return redirect()->back()->with('success', 'Member information has been successfully updated !');
    }

    public function destroyMember(Request $request, $id)
    {
        $member = CommitteeMember::find($id);
        $member->delete();
        
        $committeeTab = "active";

        return redirect()->back()->with('success', 'Member  has been successfully deleted !')->with('committeeTab', $committeeTab);
    }

}
