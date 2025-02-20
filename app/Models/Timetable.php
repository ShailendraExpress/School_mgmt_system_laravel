<?php

namespace App\Models;

use App\Models\Day;
use App\Models\Classes;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $fillable = [
        'class_id',
        'subject_id',
        'day_id',
        'end_time',
        'start_time',
        'room_no'
    ];

    public function class(){
     
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function subject(){
     
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function day(){
     
        return $this->belongsTo(Day::class, 'day_id');
    }
}
