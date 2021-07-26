<?php

use Illuminate\Database\Seeder;

class EmailTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('emailtemplates')->insert([
        	[
            'subject' => 'Welcome to Office-Campfire', 
            'email_template' => '&#x3C;!DOCTYPE html&#x3E;
&#x3C;html&#x3E;
&#x3C;head&#x3E;
&#x9;&#x3C;title&#x3E;&#x3C;/title&#x3E;
&#x3C;/head&#x3E;
&#x3C;body&#x3E;

&#x9;&#x3C;p&#x3E;&#x3C;b&#x3E;Hi ##name##,&#x3C;/b&#x3E; &#x3C;/p&#x3E;
&#x9;&#x3C;p&#x3E;Your account is succesfully created on Office-Campfire. Below are your login details : &#x3C;/p&#x3E;

&#x9;&#x3C;p&#x3E;Email : ##email## &#x3C;br /&#x3E; Password : ##password##&#x9;&#x3C;/p&#x3E;

&#x9;&#x3C;p&#x3E;&#x3C;b&#x3E;Note : Please change your password immediately after your first login.&#x3C;/b&#x3E;&#x3C;/p&#x3E;
&#x3C;p&#x3E;Regards&#x3C;br /&#x3E;Office-Campfire Admin&#x3C;/p&#x3E;
&#x3C;/body&#x3E;
&#x3C;/html&#x3E;',
            'status' => 1,
            'email_slug' => 'register_email'
        ],
        [
        'subject' => 'Forgot Password', 
            'email_template' => '&#x3C;!DOCTYPE html&#x3E;
&#x3C;html&#x3E;
&#x3C;head&#x3E;
&#x9;&#x3C;title&#x3E;&#x3C;/title&#x3E;
&#x3C;/head&#x3E;
&#x3C;body&#x3E;

&#x9;&#x3C;p&#x3E;&#x3C;b&#x3E;Hi ##name##,&#x3C;/b&#x3E; &#x3C;/p&#x3E;
&#x9;&#x3C;p&#x3E;You recently requested to reset your password for your Office-Campfire account. Click the link below to reset it&#x3C;/p&#x3E;

&#x9;&#x3C;p&#x3E;
&#x9;&#x9;&#x3C;a style=&#x22;color:#f14e4e;font-family: Arial&#x22; href=&#x22;https://www.officecampfire.com/##module##/resetPassword/##verification_code##&#x22;&#x3E;Reset your password&#x3C;/a&#x3E;
&#x9;&#x3C;/p&#x3E;

&#x3C;/body&#x3E;
&#x3C;/html&#x3E;',
            'status' => 1,
            'email_slug' => 'forgot_password'
        ],
        [
        'subject' => 'Verify Your Link', 
            'email_template' => '&#x3C;!DOCTYPE html&#x3E;
&#x3C;html&#x3E;
&#x3C;head&#x3E;
&#x9;&#x3C;title&#x3E;&#x3C;/title&#x3E;
&#x3C;/head&#x3E;
&#x3C;body&#x3E;

&#x9;&#x3C;p&#x3E;&#x3C;b&#x3E;Hi ##name##,&#x3C;/b&#x3E; &#x3C;/p&#x3E;
&#x9;&#x3C;p&#x3E;Please click on link below to verify your account : &#x3C;/p&#x3E;

&#x9;&#x3C;p&#x3E;&#x3C;a style=&#x22;color:#f14e4e;font-family: Arial&#x22; href=&#x22;https://www.officecampfire.com/event_manager/accountVerify/##verification_code##&#x22;&#x3E;https://www.officecampfire.com/event_manager/accountVerify/##verification_code##&#x3C;/a&#x3E;&#x9;&#x3C;/p&#x3E;

&#x3C;p&#x3E;Regards&#x3C;br /&#x3E;Office-Campfire Admin&#x3C;/p&#x3E;
&#x3C;/body&#x3E;
&#x3C;/html&#x3E;',
            'status' => 1,
            'email_slug' => 'verify_email'
        ],
        [
        'subject' => 'Office Campfire team building event details', 
        'email_template' => '&#x3C;!DOCTYPE html&#x3E;
&#x3C;html&#x3E;
&#x3C;head&#x3E;
&#x9;&#x3C;title&#x3E;&#x3C;/title&#x3E;
&#x3C;/head&#x3E;
&#x3C;body&#x3E;

&#x9;&#x3C;p&#x3E;&#x3C;b&#x3E;Hi ##name##,&#x3C;/b&#x3E; &#x3C;/p&#x3E;
&#x9;&#x3C;p&#x3E;You have been invited to join an online team building event by ( &#x3C;b&#x3E;##managername##&#x3C;/b&#x3E; ).&#x3C;br/&#x3E;
&#x9;&#x3C;p&#x3E;
&#x9;&#x9;&#x3C;b&#x3E;Agenda of the event:&#xA0;&#x3C;/b&#x3E;
&#x9;&#x9;&#x3C;br/&#x3E;
&#x26;emsp; 1) Ice Breaker (5-10 mins): This is a short, non-competitive game to get to know your teammates better.
&#x3C;br/&#x3E;
&#x26;emsp; 2) Game (35-40 mins): Multiplayer, multi-team competitive&#xA0;based online game. Please feel free to refer to the game rules using this &#x3C;a style=&#x22;color:blue;font-family: Arial&#x22; href=&#x22;##baseurl##/tutorials&#x22;&#x3E;link.&#x3C;/a&#x3E;&#x3C;/p&#x3E;

&#x9;&#x3C;b&#x3E;Below are the event details and your link to join: &#x3C;/b&#x3E;&#x3C;/p&#x3E;

&#x9;&#x3C;p&#x3E;&#x3C;a style=&#x22;color:blue;font-family: Arial&#x22; href=&#x22;##baseurl##/homepage/##userkey##-##eventkey##&#x22;&#x3E;Click here to join..&#x3C;/a&#x3E;&#x3C;/p&#x3E;

&#x9;&#x3C;p style=&#x22;margin:3px 0px 3px 0px;&#x22;&#x3E;&#x3C;b&#x3E;Event Name&#x3C;/b&#x3E; : ##eventname##&#x3C;/p&#x3E;
&#x9;&#x3C;p style=&#x22;margin:3px 0px 3px 0px;&#x22;&#x3E;&#x3C;b&#x3E;Team Name&#x3C;/b&#x3E; : ##teamname##&#x3C;/p&#x3E;
&#x9;&#x3C;p style=&#x22;margin:3px 0px 3px 0px;&#x22;&#x3E;&#x3C;b&#x3E;Event Start Time&#x3C;/b&#x3E; : ##starttime##  (As per Timezone ##timezone##)&#x3C;/p&#x3E;
&#x9;&#x3C;p style=&#x22;margin:3px 0px 3px 0px;&#x22;&#x3E;&#x3C;b&#x3E;Event End Time&#x3C;/b&#x3E; : ##endtime##  (As per Timezone ##timezone##)&#x3C;/p&#x3E;

&#x9;&#x3C;p style=&#x22;margin:3px 0px 3px 0px;&#x22;&#x3E;&#x3C;b&#x3E;Event Description&#x3C;/b&#x3E; : ##description##&#x3C;/p&#x3E;

&#x9;&#x3C;p&#x3E;Please don&#x2019;t forget to add the attached invite file to your calendar.&#x3C;/p&#x3E;
&#x9;&#x3C;!-- &#x3C;p style=&#x22;color: red; font-family: Arial&#x22;&#x3E;Feel free to go through the attached Game Play of one of the games, which will be played during the event.&#x3C;/p&#x3E; --&#x3E;

&#x9;&#x3C;p&#x3E;Regards&#x3C;br /&#x3E;##managername##&#x3C;/p&#x3E;

&#x9;&#x3C;p&#x3E;Powered by Office-Campfire&#x3C;br /&#x3E;Office-Campfire&#x3C;/p&#x3E;
&#x3C;/body&#x3E;
&#x3C;/html&#x3E;',
            'status' => 1,
            'email_slug' => 'meeting_link'
        ]
    ]);
    }
}
