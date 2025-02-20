<?php

namespace App\Http\Controllers;

use App\Models\User;
//use Illuminate\Foundation\Auth\User;
use App\Models\Timetable;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\AssignTeacherToClass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        return view('student.login');
    }

    public function authenticate(Request $request){
      if( Auth::attempt(['email'=>$request->email,'password'=>$request->password])){

        if(Auth::user()->role!='student'){
            Auth::logout();
            return redirect()->route('student.login')->with('error', 'Unauthorise user. Access Denied!');
        }
        return redirect()->route('student.dashboard');

    }else{
        return redirect()->route('student.login')->with('error', 'Invalid Email or Password!');
    }
    }

    public function dashboard(){
       $data['announcements']= Announcement::where('type','student')->latest()->limit(1)->get();
        return view('student.dashboard',  $data);
    }
    

    public function mySubject(){
        $class_id = Auth::guard('web')->user()->class_id;
        $data['my_subjects'] = AssignTeacherToClass::where('class_id',$class_id)->with('subject', 'user')->get();
        return view('student.my_subject', $data);
    }
    

    
    public function logout(){
        Auth::logout();
        return redirect()->route('student.login')->with('error', 'You have logged out Successfully!');
    }

    public function changePassword(){
        return view('student.change_password');
    }

    public function updatePassword(Request $request){
        $request->validate([
            'old_password'=>'required',
            'new_password'=>'required',
            'password_confirmation'=>'required|same:new_password',
        ]);
            $old_password = $request->old_password;
            $new_password = $request->new_password;
            $user = User::find(Auth::user()->id);
            if(Hash::check($old_password, $user->password )){
                $user->password =$new_password;
                $user->update();
                return redirect()->back()->with('success','Password changed successfully!');

            }else{
                return redirect()->back()->with('error','Old password doesn\'t matched!');
            }
    }


    public function timetable(){
        $class_id=Auth::guard('web')->user()->class_id;
        $timetable=Timetable::with('subject', 'day')->where('class_id', $class_id)->get();
        $group = [];
        foreach($timetable as $data){
            $group[$data->day->name][]=[
              'subject' => $data->subject->name,
                'start_time' => $data->start_time,
               'end_time' => $data->end_time,
               'room_no' => $data->room_no,
            ];
        }
        $data['timetable'] =$group;
        return view('student.timetable', $data);
    }
}
