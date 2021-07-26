<?php

use Illuminate\Database\Seeder;

class ContactEmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach( [
            [ 'cc_key' => 'CONF_CONTACT_REQUEST_SEND_TO_EMAILS', 'cc_value' => 'info@officecampfire.com', 'cc_serialize' => 0 ]
        ] as $data ) { 
            DB::table('content_configurations')->insert( $data );
        }

        foreach( [
            [
                'subject' => 'Contact Request', 
                    'email_template' => '&#x3C;!DOCTYPE html&#x3E;
                    &#x3C;html&#x3E;
                    &#x3C;head&#x3E;
                        &#x3C;title&#x3E;&#x3C;/title&#x3E;
                    &#x3C;/head&#x3E;
                    &#x3C;body&#x3E;
                        &#x3C;p&#x3E;&#x3C;b&#x3E;Hi Admin,&#x3C;/b&#x3E; &#x3C;/p&#x3E;
                        &#x3C;p&#x3E;Below are the new contact request details: &#x3C;/p&#x3E;
                        &#x3C;p&#x3E;Name: ##name##&#x3C;/p&#x3E;
                        &#x3C;p&#x3E;Email: ##email##&#x3C;/p&#x3E;
                        &#x3C;p&#x3E;Message: &#x3C;/p&#x3E;##message##
                        &#x3C;p&#x3E;Regards&#x3C;br /&#x3E;Office-Campfire Admin&#x3C;/p&#x3E;
                    &#x3C;/body&#x3E;
                    &#x3C;/html&#x3E;',
                    'status' => 1,
                    'email_slug' => 'contact_request'
                ]
        ] as $data ) { 
            DB::table('emailtemplates')->insert( $data );
        }
    }
}
