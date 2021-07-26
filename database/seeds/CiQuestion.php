<?php

use Illuminate\Database\Seeder;

class CiQuestion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ci_questions')->insert([
        	[
	            'serial'   => 1,
	            'question' => 'During what time was the painting replaced?',
                'answer'   =>   '9'
        	],
        	[
	            'serial' => 2,
	            'question' => 'Select all the suspects who could not possibly replace the Black Square painting.',
                'answer'   =>   '9,10,11'
        	],
        	[
	            'serial' => 3,
	            'question' => 'Who stole the painting?',
                'answer'   =>   '2,3'
        	]
        ]);
    }
}
