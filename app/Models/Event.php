<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Event extends Model
{

    protected $table = 'events';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'description', 'status', 'event_manager', 'start_date', 'start_time', 'end_time', 'intro_game', 'main_game'
    ];


    public function eventteam(){
	   return $this->hasOne('App\Models\EventTeam','event_id');
    }
    
    /**
     * Get the main game associated with the event.
     */
    public function game()
    {
        return $this->hasOne(Game::class, 'id', 'main_game');
    }
	

    public static function eventAlreadyExistSameTime($data=NULL,$startTime=NULL,$endTime=NULL){
    	$teamIds = ""; $eventmanager = session('manager_id');
    	foreach ($data->teams as $id) { $teamIds .= $id.","; }
    	$teamIds = substr($teamIds,0,-1);
    	$sql = DB::table('events as e')
            ->select(DB::raw('e.id'))
            ->join('event_teams as et', 'et.event_id', '=', 'e.id')
            ->where(['e.status' => 1])
            ->whereRaw("((start_time <= '$startTime' and end_time >= '$startTime') or (start_time <= '$endTime' and end_time >= '$endTime' ) or (start_time >= '$startTime' and end_time <= '$endTime')) and et.team_id IN (".$teamIds.") and event_manager='$eventmanager'")
            ->get();
        return $sql->count();
    }
    public static function eventAlreadyExistSameTimeUpdate($data=NULL,$startTime=NULL,$endTime=NULL){
    	$teamIds = ""; $eventmanager = session('manager_id');
    	foreach ($data->teams as $id) { $teamIds .= $id.","; }
    	$teamIds = substr($teamIds,0,-1);
    	$sql = DB::table('events as e')
            ->select(DB::raw('e.id'))
            ->join('event_teams as et', 'et.event_id', '=', 'e.id')
            ->whereRaw("((start_time <= '$startTime' and end_time >= '$startTime') or (start_time <= '$endTime' and end_time >= '$endTime' ) or (start_time >= '$startTime' and end_time <= '$endTime')) and et.team_id IN (".$teamIds.") and event_manager='$eventmanager' and e.id!= '$data->eventid'")
            ->get();
        return $sql->count();
    }


    public static function usersInEvent($eventId=NULL){
    	$rec = DB::table('events as e')
            ->select(DB::raw('u.email,u.name,u.enc_id,u.id as user_id,et.team_id'))
            ->join('event_teams as et', 'et.event_id', '=', 'e.id')
            ->join('user_team as ut', 'ut.team_id', '=', 'et.team_id')
            ->join('users as u', 'u.id', '=', 'ut.user_id')
            ->where("e.id", "=", $eventId)
            ->get();
        return $rec;
    	//SELECT u.email,u.name FROM `events` as e join event_teams as et on et.event_id=e.id join user_team as ut on ut.team_id=et.team_id join users as u on u.id=ut.user_id WHERE e.id='1' 
    }

    public static function getTimezoneAgainstEventId($eventId){
        return DB::table('events as e')
            ->select('s.timezone')
            ->join('event_managers as em', 'e.event_manager', '=', 'em.id')
            ->join('states as s', 'em.state_id', '=', 's.id')
            ->where('e.id', $eventId)
            ->first();   
    }

    public static function getTeamforEventAndUser($eventId, $userId){
        return DB::table('event_teams')
            ->select('event_teams.team_id')
            ->join('user_team', 'event_teams.team_id', '=', 'user_team.team_id')
            ->where(['event_teams.event_id' => $eventId, 'user_team.user_id' => $userId])
            ->first();
    }
}
