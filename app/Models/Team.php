<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Team extends Model
{

    protected $table = 'teams';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status', 'event_manager',
    ];



    /**
     * The users that belong to the team.
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User','user_team','team_id','user_id')->where(['status'=> 1]);
    }
    

    public function teamfromeventteam(){
       return $this->hasMany('App\Models\UserTeam','team_id', 'id');
    }
    //fetch all email ids of team members comma sapratted
    public static function getTeamEmailIds ($teamId)
    {
        $sql = DB::table('teams')
              ->select(DB::raw('GROUP_CONCAT(users.email) as emailids'))
              ->join('user_team', 'user_team.team_id', '=', 'teams.id')
              ->join('users', 'user_team.user_id', '=', 'users.id')
              ->where(["teams.id"=>$teamId,])
              ->groupBy('user_team.team_id')
              ->get()
              ->first();
      return $sql;
    }
}
