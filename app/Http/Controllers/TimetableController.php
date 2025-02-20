<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Timetable;
use Illuminate\Http\Request;
use App\Models\AssignSubjectToClass;

class TimetableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['days'] = Day::all();
        $data['classes'] = Classes::all();
        $data['subjects'] = Subject::all();
        
        return view('admin.timetable.timetable_create', $data);
    }

    
    public function read(Request $request)
    {
        $data['classes'] = Classes::all();
        $data['subjects'] = [];
    
        // Timetable query with relations
        $timetable = Timetable::with(['class', 'subject', 'day']);
    
        // Agar class_id select kiya hai to subjects bhi load karo
        if ($request->filled('class_id')) {
            $timetable->where('class_id', $request->class_id);
            $data['subjects'] = AssignSubjectToClass::with('subject')
                ->where('class_id', $request->class_id)
                ->get();
        }
    
        // Agar subject_id diya gaya hai, to filter karo
        if ($request->filled('subject_id')) {
            $timetable->where('subject_id', $request->subject_id);
            
            // Agar subjects already empty hai (matlab class_id nahi select tha)
            if (empty($data['subjects'])) {
                $data['subjects'] = AssignSubjectToClass::with('subject')
                    ->whereHas('subject', function ($query) use ($request) {
                        $query->where('id', $request->subject_id);
                    })->get();
            }
        }
    
        $data['timetables'] = $timetable->get();
    
        return view('admin.timetable.timetable_list', $data);
    }
    

    public function delete($id)
    {
        
        $datadelete= Timetable::find($id);
        $datadelete->delete();
        return redirect()->route('timetable.read')->with('success', 'Timetable record deleted successfully!');

        
    }

    
    // public function store(Request $request)
    // {
    //     $class_id = $request->class_id;
    //     $subject_id = $request->subject_id;
    //     $message = 'Timetable added successfully!'; // Default message

    //     foreach($request->timetable as $timetable){
    //         $day_id = $timetable['day_id'];  
    //         $start_time = $timetable['start_time'];
    //         $end_time = $timetable['end_time'];
    //         $room_no = $timetable['room_no'];

    //         if($start_time!=null){

    //             $timetableData =Timetable::updateOrCreate([
    //                 'class_id'=>$class_id,
    //                 'subject_id'=>$subject_id,
    //                 'day_id'=>$day_id,
    //             ],[
    //                 'class_id'=>$class_id,
    //                 'subject_id'=>$subject_id,
    //                 'day_id'=>$day_id,
    //                 'start_time'=>$start_time,
    //                 'end_time'=>$end_time,
    //                 'room_no'=>$room_no
    //             ]);
    //               // Agar record update hua to message change kar do
    //         if (!$timetableData->wasRecentlyCreated) {
    //             $message = 'Data already exists, so updated successfully!';
    //         }
    //         }

           
    //     }
    //     return redirect()->route('timetable.create')->with('success', $message);

    // }

    public function store(Request $request)
    {

        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            
        ]);
        $class_id = $request->class_id;
        $subject_id = $request->subject_id;
        $successMessage = 'Timetable added successfully!';
        $warningMessage = 'Data already exists, so updated successfully!';
        $messageType = 'success'; // Default class for success (green)

        foreach ($request->timetable as $timetable) {
            $day_id = $timetable['day_id'];
            $start_time = $timetable['start_time'];
            $end_time = $timetable['end_time'];
            $room_no = $timetable['room_no'];

            if ($start_time != null) {
                $timetableData = Timetable::updateOrCreate(
                    [
                        'class_id' => $class_id,
                        'subject_id' => $subject_id,
                    'day_id' => $day_id,
                ],
                [
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'room_no' => $room_no
                ]
            );
            // Agar record update hua to warning class ka message
            if (!$timetableData->wasRecentlyCreated) {
                $messageType = 'warning'; // Yellow message
                $successMessage = $warningMessage;
            }
        }
    }

    return redirect()->route('timetable.create')->with($messageType, $successMessage);
}

    
}
