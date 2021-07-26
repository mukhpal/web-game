<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EventJoin extends Model
{
    private static $instance;

    protected $table = 'event_join_details';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id', 'user_id', 'team_id', 'socket_id', 'current_screen_with_time', 'tutorials_seen'
    ];


    public static function getInstance() {
      if (!isset(self::$instance)) {
          self::$instance = new static();
      }
      return self::$instance;
    }


    public static function getJoinEventTeamUsersCount($eventId=NULL, $teamId=NULL){
      $sql = DB::table('event_join_details')->where(["event_id"=>$eventId, "team_id"=>$teamId])->get();
      return $sql->count();
    }

    public static function getEventJoinedTeamsNmembers ($eventId){
      $sql = DB::table('event_join_details')
              ->select(DB::raw('COUNT(user_id) as members,team_id,event_id,user_id'))
              ->where(["event_id"=>$eventId,])
              ->groupBy('team_id')
              ->having('members', '>', 1)
              ->get();
      return $sql;
    }

    public static function getEventJoinedTeamsWithMembers ($eventId, $minTeamSize = 2){
      $sql = DB::table('event_join_details')
              ->select(DB::raw('COUNT(user_id) as members,team_id'))
              ->where(["event_id"=>$eventId])
              ->groupBy('team_id')
              ->having('members', '>=', intval( $minTeamSize ))
              ->get();
      return $sql;
    }

    public static function getOptions ($eventId, $teamId)
    {
      return DB::table('event_join_details as ejd')
            ->select(DB::raw('u.id,u.name,u.avatar'))
            ->join('users as u', 'u.id', '=', 'ejd.user_id')
            ->whereRaw("ejd.team_id = $teamId AND ejd.event_id = $eventId")
            ->groupBy('ejd.user_id')
            ->orderBy('u.id','ASC')
            ->get();
    }

    public static function getLeftJoinUsersWithourProduction( $mmRoundId, $chanceId, $teamId ){
      return SELF::where( 'event_id', function( $q ) use ( $mmRoundId, $teamId ) { 
            return $q->from( 'mm_rounds' )
                    ->selectRaw( 'event_id' )
                    ->where( 'id', $mmRoundId )->pluck( 'event_id' )->first();
        })
        ->whereNotIn( 'user_id', function( $q ) use ( $chanceId, $teamId ) { 
            $d =  $q->from( 'production' )
                    ->selectRaw( 'user_id' )
                    ->where( ['chance_id' => $chanceId, "team_id" => $teamId] )->pluck( 'user_id' )->toArray( );
            return $d;
        })
        ->where( 'team_id', $teamId );
    }

    public static function getTeamsWhoJoinedEvents ($eventId ){
      $sql = DB::table('event_join_details')
              ->where(["event_id"=>$eventId])
              ->groupBy('team_id')
              ->pluck( 'team_id' );
      return $sql;
    }

    public static function getActiveMMTeamsWithMembers ($eventId, $minTeamSize = 2){
      $sql = DB::table('event_join_details')
              ->select(DB::raw('COUNT(user_id) as members,team_id'))
              ->where(["event_id"=>$eventId, 'tutorials_seen' => 1])
              ->groupBy('team_id')
              ->having('members', '>=', intval( $minTeamSize ))
              ->get();
      return $sql;
    }

    public static function getActiveTeamsForChat ($eventId){
      $sql = DB::table('event_join_details')
              ->select(DB::raw('team_id'))
              ->where(["event_id"=>$eventId])
              ->groupBy('team_id')
              ->get();
      return $sql;
    }

}
