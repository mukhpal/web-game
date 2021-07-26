<?php

use Illuminate\Database\Seeder;

class ContentConfigurationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach( [
            [ 'cc_key' => 'CONF_WORLD_MAP_COUNTRIES', 'cc_value' => 'a:10:{i:0;s:5:"India";i:1;s:9:"Argentina";i:2;s:3:"USA";i:3;s:9:"Australia";i:4;s:5:"Itlay";i:5;s:5:"China";i:6;s:8:"Malaysia";i:7;s:6:"Canada";i:8;s:6:"France";i:9;s:6:"Russia";}', 'cc_serialize' => 1 ],

            [ 'cc_key' => 'CONF_FOOTER_DESC', 'cc_value' => 'OfficeCampfire provides online team building events through fun and strategic, multiteam and multiplayer games designed to bring teams together.
            It also includes an inbuilt video and audio chat feature!
            
            So what are you waiting for ...?', 'cc_serialize' => 0 ],
            [ 'cc_key' => 'CONF_FOOTER_CONTACT_HEADING', 'cc_value' => 'Contact Us
            ', 'cc_serialize' => 0 ],
            [ 'cc_key' => 'CONF_CONTACT_ADDRESS', 'cc_value' => 'California, USA', 'cc_serialize' => 0 ],
            
            [ 'cc_key' => 'CONF_CONTACT_EMAIL', 'cc_value' => 'info@officecampfire.com', 'cc_serialize' => 0 ],
            [ 'cc_key' => 'CONF_CONTACT_PHONE', 'cc_value' => '', 'cc_serialize' => 0 ],
            [ 'cc_key' => 'CONF_CONTACT_SKYPE', 'cc_value' => '', 'cc_serialize' => 0 ],

            [ 'cc_key' => 'CONF_FOOTER_COPYRIGHT', 'cc_value' => '© Copyright 2020. All Rights Reserved.', 'cc_serialize' => 0 ],
            [ 'cc_key' => 'CONF_SOCIAL_INSTA', 'cc_value' => '', 'cc_serialize' => 0 ],
            [ 'cc_key' => 'CONF_SOCIAL_TWITTER', 'cc_value' => '', 'cc_serialize' => 0 ],
            [ 'cc_key' => 'CONF_SOCIAL_YOUTUBE', 'cc_value' => '', 'cc_serialize' => 0 ],
            [ 'cc_key' => 'CONF_SOCIAL_FACEBOOK', 'cc_value' => '', 'cc_serialize' => 0 ],
        ] as $data ) { 
            DB::table('content_configurations')->insert( $data );
        }
    }
}
