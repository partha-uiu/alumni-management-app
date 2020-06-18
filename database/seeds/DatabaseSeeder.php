<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(UserTypesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(InstitutionsTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(SessionsTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(MentorshipTopicsTableSeeder::class);
        $this->call(DegreesTableSeeder::class);
        $this->call(EducationalDetailsTableSeeder::class);
        $this->call(DonationsTableSeeder::class);
        $this->call(EventsTableSeeder::class);
        $this->call(JobsTableSeeder::class);
        $this->call(NewsTableSeeder::class);
        $this->call(ProfilesTableSeeder::class);
    }
}
