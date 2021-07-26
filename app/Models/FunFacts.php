<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FunFacts extends Model
{
    private static $instance;

    protected $table = 'event_fun_facts';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'event_id', 'team_id', 'fun_facts', 'statementtype', 'status'
    ];


    public static function getInstance() {
      if (!isset(self::$instance)) {
          self::$instance = new static();
      }
      return self::$instance;
    }

    public static function getRandomQuestion ( $eventId, $teamId )
    {
      return DB::select('SELECT id, fun_facts, 1 as pending,user_id FROM event_fun_facts WHERE team_id = '.$teamId.' AND event_id = '.$eventId.' AND status = 1 order by RAND() LIMIT 1');

      // old code removed from And condition
      // AND id NOT IN (SELECT fun_fact_id from event_fun_facts_answers WHERE player_id = '.$playerId.')   
    }

    public static function getPendingQuestionCount ( $eventId, $teamId )
    {
      return DB::select('SELECT COUNT(id) as pending
            FROM event_fun_facts
            WHERE team_id = '.$teamId.' AND event_id = '.$eventId.' AND status = 1 
            GROUP BY event_fun_facts.event_id order by id asc');

      // old code removed from And condition
      // AND id NOT IN (SELECT fun_fact_id from event_fun_facts_answers WHERE player_id = '.$playerId.')   
    }

    public static function getQuestions ($eventId, $teamId)
    {
      return DB::select('SELECT id,fun_facts,COUNT(id) as pending,user_id
            FROM event_fun_facts
            WHERE team_id = '.$teamId.' AND event_id = '.$eventId.' AND status = 1 
            GROUP BY event_fun_facts.event_id order by id asc');

      // old code removed from And condition
      // AND id NOT IN (SELECT fun_fact_id from event_fun_facts_answers WHERE player_id = '.$playerId.')   
    }

    public static function getQuestionsCount ($eventId, $teamId)
    {
      return DB::select('SELECT COUNT(id) as total
            FROM event_fun_facts
            WHERE team_id = '.$teamId.' AND event_id = '.$eventId.' GROUP BY event_fun_facts.event_id');
    }

    public static function getOptions ($playerId, $eventId, $teamId)
    {
      return DB::table('event_fun_facts as eff')
            ->select(DB::raw('u.id,u.name'))
            ->join('users as u', 'u.id', '=', 'eff.user_id')
            ->whereRaw("eff.team_id = $teamId AND eff.event_id = $eventId")
            ->groupBy('eff.user_id')
            ->orderBy('u.id','ASC')
            ->get();
    }


    public static function getFunFactsUsersCount($eventId=NULL, $teamId=NULL){
      $sql = DB::table('event_fun_facts')
                ->where(["event_id"=>$eventId, "team_id"=>$teamId])
                ->groupBy('user_id')
                ->get();
      return $sql->count();

    }

    public static function getResultScreenData ($eventId, $teamId){
      $sql = DB::table('event_fun_facts_answers')
            ->select(DB::raw('count(event_fun_facts_answers.correct_answer) as correct_ans,event_fun_facts_answers.player_id,users.name,users.avatar'))
            ->join('users', 'users.id', '=', 'event_fun_facts_answers.player_id')
            ->whereRaw("event_id = $eventId and correct_answer = 1")
            ->groupBy('event_fun_facts_answers.player_id')
            ->orderBy('correct_ans','DESC');

      $query = DB::table('event_join_details')
            ->select(DB::raw("SUM(IF(event_fun_facts_answers.correct_answer = 1 AND event_fun_facts_answers.event_id = $eventId, 1,0) ) as correct_ans,event_join_details.user_id,users.name,users.avatar"))
            ->join('users', 'users.id', '=', 'event_join_details.user_id', 'LEFT')
            ->join('event_fun_facts_answers', 'event_join_details.user_id', '=', 'event_fun_facts_answers.player_id', 'LEFT')
            ->whereRaw("event_join_details.event_id = $eventId and event_join_details.team_id = $teamId")
            ->groupBy('event_join_details.user_id')
            ->orderBy('correct_ans','DESC');

      return $query->get();
    }

}