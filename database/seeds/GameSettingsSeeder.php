<?php

use Illuminate\Database\Seeder;

class GameSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('game_settings')->insert([
            'game_time' => 60,
            'awaiting_screen_time' => 5,
            'team_size' => 5, 
            'min_team_size' => 3, 
            'single_question_time' => 20, 
            'answer_screen_time' => 5, 
            'min_teams_for_event' => 2, 
            'team_cash' => 1080, 
            'round_team_cash' => 240, 
            'max_loss_profit_limit' => 20, 
            'market_demond' => 1000, 
            'foreign_production_amount' => '500,1000,1500', 
            'total_rounds' => 8, 
            'chance_in_round' => 2, 
            'chance_time' => 30, 
            'chance_result_time' => 15, 
            'round_results_time' => 30
        ]);
    }
}
