<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\AssignSubjectToClass;
use App\Models\AssignTeacherToClass;

class AssignTeacherToClassController extends Controller
{
  
    public function index()
    {

        //Fetching class and subject
        $data['classes'] = Classes::all();
        $data['subjects'] = Subject::all();
        $data['teachers'] = User::where('role','teacher')->get();
        return view('admin.assign_teacher.assign_teacher_form', $data);
    }
    
    
    public function findSubject(Request $request){
        $class_id = $request->class_id;
      
        $subjects = AssignSubjectToClass::with('subject')->where('class_id',$class_id)->get();
        return response()->json([
            'status'=>true,
            'subjects'=>$subjects
        ]);
    }
 

    public function store(Request $request)
    {
        $request->validate([
            'class_id' =>'required', 
            'subject_id' =>'required', 
            'teacher_id' =>'required', 
        ]);

        AssignTeacherToClass::updateOrCreate([
            'class_id'=>$request->class_id,
            'subject_id'=>$request->subject_id,
        ],[
            'class_id'=>$request->class_id,
            'subject_id'=>$request->subject_id,
            'teacher_id'=>$request->teacher_id,
            
        ]);

        return redirect()->route('assign-teacher.create')->with('success', 'Teacher assigned successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function read(Request $request)
    {
        
        //Filter Data
        $query = AssignTeacherToClass::with(['class', 'subject', 'user'])->latest();
     
        if($request->filled('class_id')){
             $query->where('class_id', $request->class_id);
        }
        $data['assign_teachers'] = $query->get();
        // Select Class Data
        $data['classes'] = Classes::all();
        return view('admin.assign_teacher.assign_teacher_list',$data);

    }

        public function delete($id){
            
            $deleteData = AssignTeacherToClass::find($id);
            $deleteData->delete();
            return redirect()->route('assign-teacher.read')->with('success', 'Teacher Deleted successfully!');

        }


    
    public function edit($id)
    {
         $res = AssignTeacherToClass::find($id);

         $data['assign_teachers'] = $res;
         $data['subjects'] = AssignSubjectToClass::with('subject')->where('class_id', $res->class_id)->get();
         $data['classes'] = Classes::all();
         $data['teachers'] = User::where('role','teacher')->get();
        return view('admin.assign_teacher.edit_assign_teacher',$data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'class_id' =>'required', 
        //     'subject_id' =>'required', 
        //     'teacher_id' =>'required', 
        // ]);

        $record = AssignTeacherToClass::find($id);
        $record->class_id = $request->class_id;
        $record->subject_id = $request->subject_id;
        $record->teacher_id= $request->teacher_id;
        $record->update();
        return redirect()->route('assign-teacher.read')->with('success', 'Assigned teacher updated successfully!');

    }
}
