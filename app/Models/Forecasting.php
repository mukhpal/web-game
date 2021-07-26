<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Forecasting extends Model
{

    protected $guard = 'forecasting';


    protected $table = 'forecasting';

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'round_id', 'chance_id', 'user_id', 'team_id', 'type', 'amount', 'impact'
    ];

    public static function checkForecastingTaken ($roundId, $teamId, $type = 1, $chance = 'x'){
        $where = ['round_id' => $roundId, 'team_id' => $teamId, 'type' => $type];
        if($chance != 'x'){
            $where['chance_id'] = $chance;
        }
        return DB::table('forecasting')
            ->where($where)
            ->count();
    }
}
