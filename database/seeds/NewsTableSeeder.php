<?php

use App\News;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        News::truncate();

        $allUsers = User::all()->pluck('id')->toArray();

        $faker = Faker::create();
        $items = [];
        foreach (range(1, 30) as $index) {

            $items[] = [
                'user_id' => $faker->randomElement($allUsers),
                'heading' => $faker->word,
                'description' => $faker->paragraph,
                'image_url' => $faker->imageUrl($width = 640, $height = 480),
                'link' => $faker->url,
                'edited_by' => $faker->randomElement($allUsers),
                'edit_time' => $faker->dateTime,
                'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d h:i:s')
            ];
        }

        News::insert($items);
    }
}
