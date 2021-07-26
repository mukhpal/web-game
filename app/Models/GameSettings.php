<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Facades\DB;

class GameSettings extends Model
{
    private static $instance;

    protected $table = 'game_settings';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'game_time', 'awaiting_screen_time', 'team_size', 'min_team_size', 'single_question_time', 'answer_screen_time', 
        'min_teams_for_event', 'team_cash', 'round_team_cash', 'forecasting_charge', 'max_loss_profit_limit', 
        'market_demond', 'foreign_production_amount', 'total_rounds', 'chance_in_round', 'chance_time', 
        'chance_result_time', 'round_results_time', 'ib_tl_game_time', 'ib_tl_single_question_time', 
        'ib_tl_answer_screen_time', 'statement_screen_time', 'statement_waiting_screen_time', 'ci_timer', 
        'ci_lifes', 'min_teams_for_ci', 'ci_hint_timer'
    ];


    public static function getInstance() {
      if (!isset(self::$instance)) {
          self::$instance = new static();
      }
      return self::$instance;
    }


}
