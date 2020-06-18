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
                'name' => 'Shahjalal University of Science and Technology (SUST)',
                'address' => 'Akhalia,Sylhet,Bangladesh',
                'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d h:i:s')
            ]
        ]);
    }
}
