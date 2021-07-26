<?php

use Illuminate\Database\Seeder;

class NewEmailTemplatesSeeder extends Seeder
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
            'subject' => 'New event manager registration. Waiting for account approval.', 
            'email_template' => '&#x3C;!DOCTYPE html&#x3E;
                    &#x3C;html&#x3E;
                    &#x3C;head&#x3E;
                        &#x3C;title&#x3E;&#x3C;/title&#x3E;
                    &#x3C;/head&#x3E;
                    &#x3C;body&#x3E;
                        &#x3C;p&#x3E;&#x3C;b&#x3E;Hi Admin,&#x3C;/b&#x3E; &#x3C;/p&#x3E;
                        &#x3C;p&#x3E;A new event manager has registered on our portal, Please check the details and approve this manager from Admin Panel&#x3C;/p&#x3E;
&#x3C;p&#x3E;Manager Name: ##manager_name##&#x3C;/p&#x3E;
&#x3C;p&#x3E;Manager Email: ##manager_email##&#x3C;/p&#x3E;
&#x3C;p&#x3E;Manager Company: ##manager_company##&#x3C;/p&#x3E;

                        &#x3C;p&#x3E;Regards&#x3C;br /&#x3E;Office-Campfire Admin&#x3C;/p&#x3E;
                    &#x3C;/body&#x3E;
                    &#x3C;/html&#x3E;',
            'status' => 1,
            'email_slug' => 'new_manager_signup'
        ],
        [
        'subject' => 'Please wait for admin approval.', 
            'email_template' => '&#x3C;!DOCTYPE html&#x3E;
                    &#x3C;html&#x3E;
                    &#x3C;head&#x3E;
                        &#x3C;title&#x3E;&#x3C;/title&#x3E;
                    &#x3C;/head&#x3E;
                    &#x3C;body&#x3E;
                        &#x3C;p&#x3E;&#x3C;b&#x3E;Dear ##manager##,&#x3C;/b&#x3E; &#x3C;/p&#x3E;
                        &#x3C;p&#x3E;Thank you for the registration.&#x3C;/p&#x3E;
                        &#x3C;p&#x3E;We will be get in touch with you shortly regarding your account approval.&#x3C;/p&#x3E;
                        &#x3C;p&#x3E;Regards&#x3C;br /&#x3E;Office-Campfire Admin&#x3C;/p&#x3E;
                    &#x3C;/body&#x3E;
                    &#x3C;/html&#x3E;',
            'status' => 1,
            'email_slug' => 'account_approval'
        ]
    ]);
    }
}
