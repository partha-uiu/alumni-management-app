<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Degree;
use Carbon\Carbon;


class DegreesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Degree::truncate();

        $degrees =[
            'SSC',
            'HSC',
            'Diploma',
            'B Sc.',
            'M Sc.',
            'Postgraduate Diploma',
            'M Phil.',
            'PHD'
        ];

        $items = [];
        foreach ($degrees as $degree) {

            $items[] = [
                'name' => $degree,
                'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d h:i:s')
            ];
        }

        Degree::insert($items);
    }
}
