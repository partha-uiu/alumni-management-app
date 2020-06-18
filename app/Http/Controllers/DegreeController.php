<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Degree;
use Carbon\Carbon;

class DegreeController extends Controller
{
    public function index()
    {
        $degrees = Degree::all();

        return view('degrees.index')->with('degrees', $degrees);
    }

    public function create()
    {
        return view('degrees.create');
    }

    public function store(Request $request)
    {
        
        $this->validate($request, [
            'name.*' => 'required|unique:degrees,name',
        ]);
        // dd($request->name);
        if (count($request->name)) {
           
            $degreeDataCount = count($request->name);

            $now = Carbon::now()->toDateTimeString();

            $degreeName = [];

            for ($i = 0; $i < $degreeDataCount; $i++) {

                $degreeName[$i]['name'] = $request->name[$i];
                $degreeName[$i]['created_at'] = $now;
                $degreeName[$i]['updated_at'] = $now;
            }

            Degree::insert($degreeName);
        }
        $degreesTab = "active";

        return redirect()->back()->with('success', 'Degree has been added')->with('degreesTab', $degreesTab);
    }

    public function edit($id)
    {
        $degree = Degree::find($id);

        return view('degrees.edit')
            ->with('degree', $degree);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:degrees',
        ]);

        $degree = Degree::find($id);
        $degree->name = $request->name;
        $degree->save();

        return redirect()->back()->with('success', 'Degree has been successfully updated!');
    }

    public function destroy($id)
    {
        Degree::find($id)->delete();
        $degreesTab = "active";

        return redirect()->back()->with('success', 'Degree has been deleted!')->with('degreesTab', $degreesTab);
    }

}
