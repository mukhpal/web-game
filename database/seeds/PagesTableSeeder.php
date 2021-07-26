<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $updated_at = $created_at = Carbon::now()->format('Y-m-d H:i:s');

        foreach( [
            [ 'page_key' => 'HOME', 'page_title' => 'Welcome To Office Campfire', 'created_at' => $created_at, 'updated_at' => $updated_at ],
            [ 'page_key' => 'ABOUT_US', 'page_title' => 'About Us', 'created_at' => $created_at, 'updated_at' => $updated_at ],
            [ 'page_key' => 'HOW_IT_WORKS', 'page_title' => 'How It Works', 'created_at' => $created_at, 'updated_at' => $updated_at ],
            [ 'page_key' => 'PACKAGES', 'page_title' => 'Our Packages', 'created_at' => $created_at, 'updated_at' => $updated_at ],
            [ 'page_key' => 'FAQS', 'page_title' => 'Frequently Asked Questions', 'created_at' => $created_at, 'updated_at' => $updated_at ],
            [ 'page_key' => 'CONTACT_US', 'page_title' => 'Contact Us', 'created_at' => $created_at, 'updated_at' => $updated_at ],
        ] as $data ) { 
            DB::table('pages')->insert( $data );
        }
    }
}
