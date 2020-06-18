<?php

use App\MentorshipTopic;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MentorshipTopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MentorshipTopic::truncate();

        $allUsers = User::all()->pluck('id')->toArray();

        $faker = Faker::create();
        $items = [];
        foreach (range(1, 5) as $index) {

            $items[] = [
                'title' => $faker->unique()->randomElement(['Laravel', 'PHP', 'JavaScript', 'NodeJs', 'Java']),
                'edited_by' => $faker->randomElement($allUsers),
                'edit_time' => $faker->dateTime,
                'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d h:i:s')
            ];
        }

        MentorshipTopic::insert($items);
    }
}
