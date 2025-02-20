<?php

namespace App\Http\Controllers;

use App\Models\FeeHead;
use Illuminate\Http\Request;

class FeeHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.fee-head.fee-head');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'name'=>'required',
         ]);
         
         $fee = new FeeHead();
         $fee->name = $request->name;
         $fee->save();
         return redirect()->route('fee-head.create')->with('success', 'Fee Head Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function read()
    {
        $fees['fee_data'] = FeeHead::latest()->get();
        return view('admin.fee-head.fee-head-list', $fees);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $fee_row['fee'] = FeeHead::find($id);
        return view('admin.fee-head.edit_fee_head', $fee_row);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name'=>'required'
        ]);


        $update_data = FeeHead::find($request->id);
        $update_data->name = $request->name;
        $update_data->update();
        return redirect()->route('fee-head.read')->with('success', "Feed Head Updated Successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $fee_del = FeeHead::find($id);
        $fee_del->delete();
        return redirect()->route('fee-head.read')->with('success', 'Fee Head Deleted Successfully!');
    }

}
