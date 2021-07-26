<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MmRounds extends Model
{

    const ROUND_CHANCE_STARTED          = 1;
    const ROUND_CHANCE_RESULT_STARTED   = 2;
    const ROUND_OVERALL_RESULT_STARTED  = 3;
    const ROUND_END                     = 4;

    //New round status

    const ROUND_ACTIVE = 1;
    const ROUND_RESULT_ACTIVE = 2;
    const ROUND_COMPLETED = 3;

    protected $table = 'mm_rounds';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'event_id', 'round', 'start_time', 'end_time', 'crop_id', 'crop_cost', 'crop_name', 'weather', 'economy', 'foreign_production', 'market_cost', 'demand', 'max_profit_limit', 'max_loss_limit', 'status'
    ];

    public static function getLatestRound ($eventId){

        return DB::table('mm_rounds')
                    ->where(['event_id' => $eventId])
                    ->orderBy( 'round', 'DESC' )
                    ->first();
    }

    public static function getLastestChanceCollection( $eventId ) { 
        return SELF::where( 'event_id', $eventId )
                ->where( 'round', function( $q ) use ( $eventId ) { 
                            $q->from( 'mm_rounds' )
                            ->selectRaw( 'max(round)' )
                            ->where('event_id', '=', $eventId);
                        })
                ->orderBy( 'round', 'DESC' )->get( );
    }

    public static function updateAllRoundsStatus ($eventId, $status =2){
        return DB::table('mm_rounds')
            ->where('event_id', $eventId)
            ->update([
                'status' => $status
            ]);
    }

    /*fetch all active event rounds*/
    public static function getActiveEventRounds ($totalRounds){
        return DB::table('mm_rounds')
            ->select(DB::raw('mm_rounds.*'))
            ->join('events', 'events.id', '=', 'mm_rounds.event_id')
            ->where('mm_rounds.status', '!=', MmRounds::ROUND_COMPLETED)
            ->where('mm_rounds.round', '<=', $totalRounds)
            ->where('events.status',1)
            ->get();
    }
}
