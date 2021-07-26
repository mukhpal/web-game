<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserTeam extends Model
{
    private static $instance;

    protected $table = 'user_team';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'team_id',
    ];


    public static function getInstance() {
      if (!isset(self::$instance)) {
          self::$instance = new static();
      }
      return self::$instance;
    }

    public function usersinteam()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function userteams()
    {
        return $this->belongsTo('App\Models\EventTeam', 'team_id');
    }


    public function getValidUserOfCurrentEvent($eventId=NULL, $userId=NULL){
        $result = DB::table('event_teams as et')
            ->select(DB::raw('et.team_id, ut.user_id'))
            ->join('user_team as ut', 'ut.team_id', '=', 'et.team_id')
            ->where('et.event_id', $eventId)
            ->where('ut.user_id', $userId)
            ->count();
        return $result;

        //SELECT et.team_id, ut.user_id FROM `event_teams` as et join user_team as ut on ut.team_id=et.team_id where et.event_id='1' and ut.user_id = '3'
    } 
    
    public static function getMyteamUsers ($eventManager, $status = 1){
        $result = DB::table('teams as t')
            ->select(DB::raw('ut.user_id'))
            ->join('user_team as ut', 'ut.team_id', '=', 't.id')
            ->where('t.event_manager', $eventManager)
            ->where('t.status', $status)
            ->get();
        return $result;
    }

    public static function checkUserIdExistsinMyTeams($userId, $eventManager){
        $result = DB::table('teams as t')
            ->select(DB::raw('ut.user_id'))
            ->join('user_team as ut', 'ut.team_id', '=', 't.id')
            ->where('t.event_manager', $eventManager)
            ->where('ut.user_id', $userId)
            ->count();
        return $result;
    }

}
