<?php

use Illuminate\Database\Seeder;

class GamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('games')->insert([
            [
                'key'       => 'ice_breaker',
                'name'      => 'Ice Breaker',
                'status'    => 1
            ],[
                'key'       => 'ice_breaker_truth_lie',
                'name'      => 'Ice Breaker ( Truth & lie)',
                'status'    => 1
            ],[
                'key'       => 'market_madness',
                'name'      => 'Market Madness',
                'status'    => 1
            ],[
                'key'       => 'escape_room',
                'name'      => 'Escape room',
                'status'    => 0
            ]
        ]);
    }
}
