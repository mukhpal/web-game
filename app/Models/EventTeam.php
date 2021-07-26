<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EventTeam extends Model
{

    protected $table = 'event_teams';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id', 'team_id', 'status',
    ];


    public function teamusers()
    {
        return $this->hasMany('App\Models\UserTeam', 'team_id', 'team_id');
    }

    public static function getAllTeamMembers($eventId, $teamId, $userId){

        $sql = DB::table('event_teams as et')
            ->select(DB::raw('u.id,u.email,u.name,u.avatar'))
            ->join('user_team as ut', 'ut.team_id', '=', 'et.team_id')
            ->join('users as u', 'u.id', '=', 'ut.user_id')
            ->where(['et.event_id' => $eventId, 'ut.team_id' => $teamId])
            ->whereRaw("u.id != $userId")
            ->get();
        return $sql;
    }
}
