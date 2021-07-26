<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PlayerCash extends Model
{

    protected $table = 'player_cash';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'team_id', 'event_id', 'cash'
    ];

    /*player cash for a particular round*/
    public static function getPlayerWalletCash ($userId, $eventId, $teamId){

    	$playerCash = DB::table('player_cash')
            ->select('cash')
            ->where(['user_id' => $userId, 'event_id' => $eventId])
            ->first();

        if($playerCash){
        	$cash = $playerCash->cash;
        }else{
        	$cash = 0;
        }

        return $cash;
    }

    /*Team cash / total user cash for a particular team in an event*/
    public static function getTeamCash ($eventId, $teamId){

    	$teamCash = DB::table('player_cash')
    		->select(DB::raw('sum(cash) as cash'))
            ->where(['team_id' => $teamId, 'event_id' => $eventId])
            ->first();

        if($teamCash){
        	$cash = $teamCash->cash;
        }else{
        	$cash = 0;
        }
        
        return $cash;
    }

    public static function getRoundTeamsCash (){

        $sql = DB::table('player_cash')
            ->select(DB::raw('sum(cash) as money,team_id'))
            ->groupBy('team_id')
            ->get();

        return $sql;
    }

    public static function winningTeam($eventId)
    {   
        $sql = DB::table('player_cash')
            ->select(DB::raw('sum(cash) as money,team_id'))
            ->where(['event_id' => $eventId])
            ->groupBy('team_id')
            ->orderBy( 'money', 'DESC' )
            ->first();

        return $sql;
    }
}
