<?php

use App\Job;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Job::truncate();

        $allUsers = User::all()->pluck('id')->toArray();

        $faker = Faker::create();
        $items = [];
        foreach (range(1, 30) as $index) {

            $items[] = [
                'user_id' => $faker->randomElement($allUsers),
                'job_title' => $faker->word,
                'company_name' => $faker->company,
                'job_type' => $faker->randomElement(['Full time','Internship','Contract']),
                'position' => $faker->word,
                'location' => $faker->address,
                'description' => $faker->paragraph,
                'post_date' => $faker->date,
                'end_date' => $faker->date,
                'url' => $faker->url,
                'is_approved' => $faker->randomElement([0, 1]),
                'approved_by' => $faker->randomElement($allUsers),
                'edited_by' => $faker->randomElement($allUsers),
                'edit_time' => $faker->dateTime,
                'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d h:i:s'),
                'educational_requirements' => $faker->sentence,
                'job_requirements' => $faker->sentence,
                'salary_range' => $faker->word,
                'apply_instruction' => $faker->sentence
            ];
        }

        Job::insert($items);
    }
}
