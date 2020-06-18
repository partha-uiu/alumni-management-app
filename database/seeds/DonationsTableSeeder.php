<?php

use App\Donation;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DonationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Donation::truncate();

        $allUsers = User::all()->pluck('id')->toArray();

        $faker = Faker::create();
        $items = [];
        foreach (range(1, 30) as $index) {

            $items[] = [
                'user_id' => $faker->randomElement($allUsers),
                'title' => $faker->word,
                'description' => $faker->paragraph,
                'payment_info' => $faker->paragraph,
                'start_date' => $faker->date,
                'end_date' => $faker->date,
                'image_url' => $faker->imageUrl($width = 640, $height = 480),
                'is_approved' => $faker->randomElement([0, 1]),
                'edited_by' => $faker->randomElement([1, 3, 5, 6]),
                'edit_time' => $faker->dateTime,
                'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d h:i:s')
            ];
        }

        Donation::insert($items);
    }
}
