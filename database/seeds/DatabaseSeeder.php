<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminTableSeeder::class);
        $this->call(GameSettingsSeeder::class);
        $this->call(EmailTemplatesSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(ContactEmailSeeder::class);
        $this->call(ContentConfigurationsSeeder::class);
        $this->call(GamesSeeder::class);
        $this->call(NewEmailTemplatesSeeder::class);
        $this->call(PageContentTableSeeder::class);
        $this->call(GuestSeeder::class);
        $this->call(CiQuestion::class);
        $this->call(CiInterviewSeeder::class);
    }
}
