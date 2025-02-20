<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\AcademicYear;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class StudentController extends Controller
{
    public function index(){

    $data['classes'] =  Classes::all();
    $data['academic_years'] =  AcademicYear::all();
    
    return view('admin.student.student', $data);
   }


        public function store(Request $request){

            $request-> validate([
                'academic_year_id'=>'required',
                'class_id'=>'required',
                'name'=>'required',
                'father_name'=>'required',
                'mother_name'=>'required',
                'admission_date'=>'required',
                'dob'=>'required',
                'mobno'=>'required',
                'email'=>'required',
                'password'=>'required',
                
            ]);

            $user = new User();
            $user->academic_year_id = $request->academic_year_id;
            $user->class_id = $request->class_id;
            $user->name = $request->name;
            $user->father_name = $request->father_name;
            $user->mother_name = $request->mother_name;
            $user->admission_date = $request->admission_date;
            $user->mobno = $request->mobno;
            $user->email = $request->email;
            $user->dob = $request->dob;
            $user->password = Hash::make($request->password);
            $user->role = 'student';
            $user->save();
            
            return redirect()->route('student.create')->with('success', 'Student Addeed Successfully!');
 }

        public function read(Request $request){
        $query = User::with(['studentClass','studentAcademicYear'])->where('role', 'student')->latest('id');
        if($request->filled('academic_year_id')){
            $query->where('academic_year_id', $request->get('academic_year_id'));
        }
        if($request->filled('class_id')){
            $query->where('class_id', $request->get('class_id'));
        }
        $student = $query->get();
        $data['students'] = $student;
        $data['academic_years'] = AcademicYear::all();
        $data['classes'] = Classes::all();
        return view('admin.student.student_list',$data);
    }


        public function edit($id){
            $data ['student'] = User::find($id);
            $data['academic_years'] = AcademicYear::all();
            $data['classes'] = Classes::all();
            return view('admin.student.edit_student', $data);
        }
        
        public function update(Request $request, $id){
            $user = User::find($id);

            $user->academic_year_id = $request->academic_year_id;
            $user->class_id = $request->class_id;
            $user->name = $request->name;
            $user->father_name = $request->father_name;
            $user->mother_name = $request->mother_name;
            $user->admission_date = $request->admission_date;
            $user->mobno = $request->mobno;
            $user->email = $request->email;
            $user->dob = $request->dob;
            $user->update();
            return redirect()->route('student.read')->with('success', 'Student Updated Successfully');
        }

        public function delete($id){
            $deleteStudent = User::find($id);
            $deleteStudent->delete();
            return redirect()->route('student.read')->with('success', 'Student Deleted Successfully');
        }
}
