<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\AssignSubjectToClass;

class AssignSubjectToClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['classes'] = Classes::all();
        $data['subjects'] = Subject::all();
        return view('admin.assign_subject.assign_subject_form', $data);
    }

   
    public function read(Request $request)
    {
        $query=AssignSubjectToClass::with(['class', 'subject']);

        if($request->filled('class_id')){
            $query->where('class_id',$request->class_id);
        }
        $data['assign_subjects'] = $query->get();
        $data['classes'] = Classes::all();
        return view('admin.assign_subject.assign_subject_table',$data);
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'class_id'=>'required',
            'subject_id'=>'required',
        ]);

        $class_id= $request->class_id;
        $subject_id= $request->subject_id;

        foreach($subject_id as $subject_id){
            AssignSubjectToClass::updateOrCreate([
                'class_id'=>$class_id,
                'subject_id'=>$subject_id
            ],
            [
                'class_id'=>$class_id,
                'subject_Id'=>$subject_id
            ]
            );
        }
        return redirect()->route('assign-subject.create')->with('success', 'Subject assigned to a class successfully!');
    }
 
    public function delete ($id)
    {
        $delete_data = AssignSubjectToClass::find($id);
        $delete_data->delete();
        return redirect()->route('assign-subject.read')->with('success', 'Subject assigned to a class deleted successfully!');
    }


    public function edit($id){
        $data['assign_subject'] = AssignSubjectToClass::find($id);

        $data['classes'] = Classes::all();
        $data['subjects'] = Subject::all();
        return view('admin.assign_subject.edit_assign_subject_form', $data);
    }

    public function update(Request $request, $id){
        $data= AssignSubjectToClass::find($id);
        $data->class_id = $request->class_id;
        $data->subject_id = $request->subject_id;
        $data->update();
        return redirect()->route('assign-subject.read')->with('success', 'Subject assigned to a class updated successfully!');

    }

}




