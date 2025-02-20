<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{

    public function read(){
        $data['academic_year'] = AcademicYear::get();

        return view('admin.academic_year_list', $data);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.academic_year');
    }

    /**
     * Show the form for creating a new resource.
     */
  
    public function store(Request $request)
    {

        $request->validate([
            'name'=>'required'
        ]);

        $data = new AcademicYear();
        $data->name = $request->name;
        $data->save();
        return redirect()->route('academic-year.create')->with('success', 'Class Added Successfully!');

    }

    /**
     * Show the form for editing the specified resource.
     */
    

    public function delete($id)
    {
        $data = AcademicYear::find($id);
        $data->delete();
        return redirect()->route('academic-year.read')->with('success', 'Academic Year Deleted Successfully!');

    }

    public function edit(Request $request, $id)
    {
        $data['academic_year']= AcademicYear::find($id);
        return view('admin.edit_academic_year', $data);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name'=>'required'
        ]);

        $data = AcademicYear::find($request->id);
        $data->name = $request->name;
        $data->update();
        return redirect()->route('academic-year.read')->with('success', 'Academic Year Updated Successfully!');

    }

  
}
