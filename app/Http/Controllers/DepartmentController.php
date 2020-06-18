<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();

        return view('departments.index')->with('departments', $departments);
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:departments'
        ]);

        $department = new Department;
        $department->name = $request->name;
        $department->save();

        return redirect()->back()->with('success', 'Department has been successfully added');
    }

    public function edit($id)
    {
        $department = Department::find($id);

        return view('departments.edit')
            ->with('department', $department);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:departments'
        ]);

        $department = Department::find($id);
        $department->name = $request->name;
        $department->save();

        return redirect()->back()->with('success', 'Department has been successfully updated!');
    }

    public function destroy($id)
    {
        Department::find($id)->delete();

        return redirect()->back()->with('success', 'Department has been successfully deleted!');
    }

}
