<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\UserType;

class UserTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserType::truncate();


        $userTypes = [
            'alumni',
            'faculty-stuff',
            'student',
        ];

        $items = [];

        foreach ($userTypes as $userType) {

            $items[] = [
                'name' => $userType,
                'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d h:i:s')
            ];
        }

        UserType::insert($items);

    }
}
