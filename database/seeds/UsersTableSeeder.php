<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Faker\Factory as Faker;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => 'Reza',
            'last_name' => 'Haque',
            'email' => 'rubel@gmail.com',
            'password' => bcrypt('spadmin123'),
            'user_type_id' => null,
            'is_approved' => 1,
            'verified' => 1,
            'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d h:i:s')
        ]);

        $user->assignRole('super-admin');

        $user = User::create(['first_name' => 'partha',
            'last_name' => 'acharjya',
            'email' => 'partha@gmail.com',
            'password' => bcrypt('admin123'),
            'user_type_id' =>null,
            'is_approved' => 1,
            'verified' => 1,
            'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d h:i:s')

        ]);
        $user->assignRole('admin');

    }
}
