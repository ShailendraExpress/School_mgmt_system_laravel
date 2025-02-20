<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        return view('admin.subject.subject_form');
    }

    
    public function read()
    {
        $data ['subjects'] = Subject::latest()->get();
        return view('admin.subject.subject_list', $data);
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'type'=>'required'
        ]);

        // Check if subject already exists with same name and type
        $existingSubject = Subject::where('name', $request->name)->where('type', $request->type)->first();
        if ($existingSubject) 
        {
        return redirect()->route('subject.create')->with('error', "Subject '{$request->name}' already exists as {$request->type}.");
        }
          // If not exists, create a new subject
        $subject = new Subject();
        $subject->name = $request->name;
        $subject->type = $request->type;
        $subject->save();
        return redirect()->route('subject.create')->with('success', 'Subject created successfully!');


    }

   
    public function show(Subject $subject)
    {
        //
    }

    
    public function edit($id)
    {
        $data['subjects'] = Subject::find($id);
        return view('admin.subject.edit_subject', $data);

    }

  
    public function update(Request $request,$id)
    {

        $request->validate([
            'name'=>'required',
            'type'=>'required'
        ]);
        $data = Subject::find($id);
     
        $data->name = $request->name;
        $data->type = $request->type;
        $data->update();
        return redirect()->route('subject.read')->with('success', 'Subject updated successfully!');

    }

    
    public function delete ($id)
    {
        $dataDeleted = Subject::find($id);
        $dataDeleted->delete();
        return redirect()->back()->with('success', 'Subject deleted successfully!');


    }
}
