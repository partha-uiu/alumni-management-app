<?php

use App\Event;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Event::truncate();

        $allUsers = User::all()->pluck('id')->toArray();

        $faker = Faker::create();
        $items = [];
        foreach (range(1, 30) as $index) {

            $items[] = [
                'user_id' => $faker->randomElement($allUsers),
                'title' => $faker->word,
                'description' => $faker->paragraph,
                'start_date' => $faker->date,
                'start_time' => $faker->time,
                'end_date' => $faker->date,
                'end_time' => $faker->time,
                'location' => $faker->address,
                'link' => $faker->url,
                'is_approved' => $faker->randomElement([0, 1]),
                'edited_by' => $faker->randomElement($allUsers),
                'edit_time' => $faker->dateTime,
                'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d h:i:s')
            ];
        }

        Event::insert($items);
    }
}
