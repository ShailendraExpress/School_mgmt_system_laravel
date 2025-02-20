<?php

namespace Database\Seeders;

use App\Models\Day;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //  // Days table ko pehle empty karein
        //  DB::table('days')->truncate();

        Day::insert([
            ['name'=>'Monday'],
            ['name'=>'Tuesday'],
            ['name'=>'Wednesday'],
            ['name'=>'Thursday'],
            ['name'=>'Friday'],
            ['name'=>'Saturday'],
            ['name'=>'Sunday'],
        ]
            
        );
    }
}
