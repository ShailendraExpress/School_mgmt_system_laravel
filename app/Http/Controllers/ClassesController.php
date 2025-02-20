<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;

class ClassesController extends Controller
{

    //Show the class
    public function read(){
        $data['class'] = Classes::get();

        return view('admin.class.class_list', $data);
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.class.class');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name'=>'required'
        ]);

        $data = new Classes();
        $data->name = $request->name;
        $data->save();
        return redirect()->route('class.create')->with('success', 'Class Added Successfully!');

    }


    public function delete($id){
        $data = Classes::find($id);
        $data->delete();
        return redirect()->route('class.read')->with('success', 'Class Deleted Successfully!');


    }

    public function edit($id){
        $data['class_data']= Classes::find($id);
        return view('admin.class.edit_class', $data);
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'name'=>'required'
        ]);

        $data = Classes::find($request->id);
        $data->name = $request->name;
        $data->update();
        return redirect()->route('class.read')->with('success', 'Class Updated Successfully!');

    }

}
