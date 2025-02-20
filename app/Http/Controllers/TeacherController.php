<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AssignTeacherToClass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index(){
        return view('admin.teacher.teacher_form');
    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required',
            'father_name'=>'required',
            'mother_name'=>'required',
            'dob'=>'required',
            'mobno'=>'required | integer',
            'email'=>'required|email',
            'password'=>'required',
        ],
        [
            'mobno.required' => 'The mobile number field is required.', // Custom error message
            'mobno.integer' => 'Mobile number must be numeric only.', // Custom error message
            
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->father_name = $request->father_name;
        $user->mother_name = $request->mother_name;
        $user->dob = $request->dob;
        $user->mobno = $request->mobno;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'teacher';
        $user->save();

        return redirect()->route('teacher.create')->with('success', 'Teacher added successfully!');
    }


    public function read(){
        $data['teachers'] = User::where('role', 'teacher')->latest()->get();
        return view('admin.teacher.teacher_list', $data);
    }

    public function edit($id){
        $data['teacher'] = User::find($id);
        return view('admin.teacher.edit_teacher_form', $data);
    }


    public function update(Request $request,$id){
        $user = User::find($id);
        $user->name = $request->name;
        $user->father_name = $request->father_name;
        $user->mother_name = $request->mother_name;
        $user->dob = $request->dob;
        $user->mobno = $request->mobno;
        $user->email = $request->email;
        $user->update();
        return redirect()->route('teacher.read')->with('success', 'Teacher updated successfully!');
    }
    
    public function delete($id){
        $dataDelete = User::find($id);
        $dataDelete->delete();
        return redirect()->route('teacher.read')->with('success', 'Teacher deleted successfully!');

    }
    public function login(){
        return view('teacher.login');
    }


    public function authenticate(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if(Auth::guard('teacher')->attempt(['email' => $request->email, 'password' => $request->password])){

            if(Auth::guard('teacher')->user()->role!='teacher'){
                Auth::guard('teacher')->logout();
                return redirect()->route('teacher.login')->with('error', 'Unauthorised User. Access Denied!');
            }
            return redirect()->route('teacher.dashboard');

        }else{
            return redirect()->route('teacher.login')->with('error', 'Invalid Email or Password!');
        }
    }

    public function dashboard(){
     return view('teacher.dashboard');
     
    }


    public function logout(){
        Auth::guard('teacher')->logout();
        return redirect()->route('teacher.login')->with('success', 'You logged out successfully!');
    }

    public function myClass(){
        $teacher_id = Auth::guard('teacher')->user()->id;

        $data['assign_class'] = AssignTeacherToClass::where('teacher_id', $teacher_id)->with(['class','subject'])->get();
        return view('teacher.my_class',$data);
    }

}
