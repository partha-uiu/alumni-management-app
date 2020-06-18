<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Profile;
use App\Session;
use App\Department;
use App\Institution;
use App\Country;
use App\User;
use Carbon\Carbon;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profile::truncate();

        $allUsers = User::all()->pluck('id')->toArray();
        $allSessions = Session::all()->pluck('id')->toArray();
        $allDepartments = Department::all()->pluck('id')->toArray();
        $institute = Institution::all()->pluck('id')->toArray();
        $allCountries = Country::all()->pluck('id')->toArray();

        $faker = Faker::create();
        $items = [];
        foreach (range(1, 30) as $index) {

            $items[] = [
                'user_id' => $faker->randomElement($allUsers),
                'profile_photo_url' => $faker->imageUrl($width = 640, $height = 480),
                'session_id' => $faker->randomElement($allSessions),
                'department_id' => $faker->randomElement($allDepartments),
                'institution_id' => $faker->randomElement($institute),
                'company_institute' => rand(0, 1) ? $faker->company : null,
                'position' => rand(0, 1) ? $faker->word : null,
                'address' => $faker->address,
                'dist_state' => $faker->randomElement(['Texas', 'Sylhet', 'Dhaka', 'Chittagong', 'California']),
                'country_id' => $faker->randomElement($allCountries),
                'dob' => $faker->date,
                'blood_group' => $faker->randomElement(['A+', 'B-', 'O+', 'AB+']),
                'contact_no' => $faker->phoneNumber,
                'summary' => $faker->paragraph,
                'visibility_status' => $faker->randomElement(['0', '1']),
                'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d h:i:s')
            ];
        }

        Profile::insert($items);
    }
}
