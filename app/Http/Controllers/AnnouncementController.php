<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{

    public function create()
    {
        return view('admin.announcement.form');
    }


    public function store(Request $request)
    {
        $request->validate([
            'message'=>'required',
            'type' =>'required'
        ]);
        
        $announcement = new Announcement();
        $announcement->message = $request->message; 
        $announcement->type = $request->type;
        $announcement->save();
        return redirect()->route('announcement.create')->with('success', 'Announcement broadcast successfully');

    }

   
    public function read( )
    {
        $data['announcements'] = Announcement::latest('id')->get();
        
        return view('admin.announcement.announcement_list', $data );

    }

    public function edit($id){
        $data['announcements']  = Announcement::find($id);
        return view('admin.announcement.edit_announcement', $data);

    }

    
    public function update(Request $request, $id){
        $request->validate([
            'message'=>'required',
            
        ]);

        $data_update = Announcement::find($id);
        $data_update->message = $request->message;
        $data_update->update();
        return redirect()->route('announcement.read')->with('success', 'Announcement updated successfully!');
        
    }
    

    public function delete($id){
        $deleteData = Announcement::find($id);
        $deleteData->delete();
        return redirect()->route('announcement.read')->with('success', 'Announcement Deleted successfully!');
   

    }

}
