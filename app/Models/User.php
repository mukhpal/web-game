<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;

class User extends Model implements JWTSubject{
    use Notifiable;
    protected $table = 'users';
    protected $mmAttributes = [];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'status', 'event_manager', 'enc_id', 'coutry_id', 'state_id'
    ];


    public function userteam(){
	   return $this->hasOne('App\Models\UserTeam','user_id');
	}
    // get matched email for add users
    public static function MatchEmail ( $keyword ){
        $result = DB::table('users')
            ->select(DB::raw('email'))
            ->where('email', 'like', "%$keyword%")
            ->get()->toArray();
        
        $emails = []; $x=0;   

        foreach ($result as $value) {
            $emails[$x] = $value->email;
          $x++;   
        }
        return $emails;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return $this->mmAttributes;
    }

    public function setMMAttribute($value) {
        $this->mmAttributes = $value; 
    }

    public static function fetchUsersWithManager ( $searchValue, $columnName, $columnSortOrder, $row, $rowperpage){
        ## Search 
        $searchQuery = " ";
        if($searchValue != ''){
           $searchQuery = " and (u.name like '%".$searchValue."%' or u.email like '%".$searchValue."%' ) ";
        }
        $result = DB::table('users as u')
            ->select(DB::raw('u.*,em.name as manager,em.id as relation_id'))
            ->join('event_managers as em', 'em.id', '=', 'u.event_manager')
            ->whereRaw(" (u.status = '1' or u.status = '0') ". $searchQuery)
            ->orderBy($columnName, $columnSortOrder)->skip($row)->take($rowperpage)->get()->toArray();
        return $result;
    }

    public static function getMyUsersCount (){
        $result = DB::table('users as u')
            ->select(DB::raw('u.id'))
            ->join('event_managers as em', 'em.id', '=', 'u.event_manager')
            ->whereRaw(" (u.status = '1' or u.status = '0')")
            ->count();
        return $result;
    }

    public static function getMyUsersFilterCount ( $searchValue){

        $searchQuery = " ";
        if($searchValue != ''){
           $searchQuery = " and (u.name like '%".$searchValue."%' or u.email like '%".$searchValue."%' ) ";
        }

        $result = DB::table('users as u')
            ->select(DB::raw('u.id'))
            ->join('event_managers as em', 'em.id', '=', 'u.event_manager')
            ->whereRaw(" (u.status = '1' or u.status = '0') ". $searchQuery)
            ->count();
        return $result;
    }
    // public function userfromuserteam()
    // {
    //     return $this->hasMany('App\Models\UserTeam', 'user_id');
    // }

}
