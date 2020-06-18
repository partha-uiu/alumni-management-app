<?php

use Illuminate\Database\Seeder;
use App\Institution;
use Carbon\Carbon;

class InstitutionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Institution::truncate();

        Institution::insert([
            [
                'name' => 'University of Bangladesh',
                'address' => 'Road-8,house-10,Dhaka',
                'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d h:i:s')
            ]
        ]);
    }
}
