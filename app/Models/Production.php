<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Production extends Model
{

    protected $table = 'production';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'team_id', 'chance_id', 'amount', 'production', 'expectedproduction'
    ];

    public static function getRoundProduction ($roundId){

        $sql = DB::table('chance as c')
            ->select(DB::raw('sum(production) as production,p.team_id,sum(amount) as amount'))
            ->join('production as p', 'c.id', '=', 'p.chance_id')
            ->where(['c.round_id' => $roundId])
            ->groupBy('p.team_id')
            ->get()->toArray();
        return $sql;
    }
}
