<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Chances extends Model
{

    const CHANCE_ACTIVE = 1;
    const CHANCE_RESULT_ACTIVE = 2;
    const CHANCE_RESULT_COMPLETED = 3;

    protected $guard = 'chance';


    protected $table = 'chance';

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'round_id', 'chance', 'weather', 'start_time', 'end_time', 'status'
    ];

    public static function getLatestChance ($roundId){

        return DB::table('chance')
            ->where(['round_id' => $roundId])
            ->orderBy( 'chance', 'DESC' )->get( )
            ->first();
    }

    public static function updateAllChanceStatus ($roundId, $status =2){
        return DB::table('chance')
            ->where('round_id', $roundId)
            ->update([
                'status' => $status
            ]);
    }
}
