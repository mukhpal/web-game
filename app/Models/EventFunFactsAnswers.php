<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EventFunFactsAnswers extends Model
{
    private static $instance;

    protected $table = 'event_fun_facts_answers';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fun_fact_id', 'player_id ', 'event_id', 'selected_option_userids', 'correct_answer'
    ];


    public static function getInstance() {
      if (!isset(self::$instance)) {
          self::$instance = new static();
      }
      return self::$instance;
    }

    public static function getTotalAnswredCount ($funfactId, $eventId){
      $sql = DB::table('event_fun_facts_answers')->where(["fun_fact_id" => $funfactId, "event_id"=>$eventId])->get();
      return $sql->count();
    }

}
