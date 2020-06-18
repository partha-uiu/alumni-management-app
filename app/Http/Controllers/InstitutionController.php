<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Institution;

class InstitutionController extends Controller
{
    public function index()
    {
        $institution = Institution::first();

        return view('institution.index')->with('institution', $institution);
    }

    public function add()
    {
        return view('institution.add');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:institutions',
            'address' => 'required'
        ]);

        $institution = new Institution;
        $institution->name = $request->name;
        $institution->address = $request->address;
        $institution->save();

        return redirect()->back()->with('success', 'Institution has been added');
    }

    public function edit($id)
    {
        $institution = Institution::find($id);

        return view('institution.edit')
            ->with('institution', $institution);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:institutions',
            'address' => 'required'
        ]);

        $institution = Institution::find($id);
        $institution->name = $request->name;
        $institution->address = $request->address;
        $institution->save();

        return redirect()->back()->with('success', 'Institution has been successfully updated!');
    }

    public function destroy($id)
    {
       Institution::find($id)->delete();

        return redirect()->back()->with('success', 'Institution has been successfully deleted!');
    }
}
