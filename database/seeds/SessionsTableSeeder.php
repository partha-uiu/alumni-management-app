<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Session;
use Carbon\Carbon;

class SessionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Session::truncate();


        $sessions = [
            '2003-2004',
            '2004-2005',
            '2005-2006',
            '2006-2007',
            '2007-2008',
            '2008-2009',
            '2009-2010',
            '2010-2011',
            '2011-2012',
            '2013-2014',
            '2014-2015',
            '2015-2016',
            '2016-2017',
            '2017-2018',
            '2018-2019',
            '2019-2020',
        ];

        $items = [];
        foreach ($sessions as $session) {

            $items[] = [
                'name' => $session,
                'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d h:i:s')
            ];
        }

        Session::insert($items);
    }
}
