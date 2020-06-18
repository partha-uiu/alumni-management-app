<?php

use App\Degree;
use App\EducationalDetail;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EducationalDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EducationalDetail::truncate();

        $allUsers = User::all()->pluck('id')->toArray();
        $allDegrees = Degree::all()->pluck('id')->toArray();

        $faker = Faker::create();
        $items = [];

        foreach (range(1, 30) as $index) {
            $items[] = [
                'user_id' => $faker->randomElement($allUsers),
                'field_of_study' => $faker->word,
                'degree_id' => $faker->randomElement($allDegrees),
                'passing_year' => $faker->year,
                'institution' => $faker->company,
                'edited_by' => $faker->randomElement($allUsers),
                'edit_time' => $faker->dateTime,
                'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d h:i:s')
            ];
        }

        EducationalDetail::insert($items);
    }
}
