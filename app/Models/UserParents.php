<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserParents extends Model
{
    protected $table = 'user_parents';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'event_manager'
    ];

    public static function getMyUsersCount ($eventManager){
    	$result = DB::table('user_parents as up')
            ->select(DB::raw('up.id'))
            ->join('users as u', 'u.id', '=', 'up.user_id')
            ->where('up.event_manager', $eventManager)
            ->whereRaw(" (status = '1' or status = '0')")
            ->count();
        return $result;
    }

    public static function getMyUsersFilterCount ($eventManager, $searchValue){

    	$searchQuery = " ";
	    if($searchValue != ''){
	       $searchQuery = " and (u.name like '%".$searchValue."%' or u.email like '%".$searchValue."%' ) ";
	    }

    	$result = DB::table('user_parents as up')
            ->select(DB::raw('up.id'))
            ->join('users as u', 'u.id', '=', 'up.user_id')
            ->where('up.event_manager', $eventManager)
            ->whereRaw(" (status = '1' or status = '0') ". $searchQuery)
            ->count();
        return $result;
    }

    public static function getMyUsersDetails ($eventManager, $searchValue, $columnName, $columnSortOrder, $row, $rowperpage){
    	## Search 
    	$searchQuery = " ";
	    if($searchValue != ''){
	       $searchQuery = " and (u.name like '%".$searchValue."%' or u.email like '%".$searchValue."%' ) ";
	    }
    	$result = DB::table('user_parents as up')
            ->select(DB::raw('u.*,up.event_manager as manager,up.id as relation_id'))
            ->join('users as u', 'u.id', '=', 'up.user_id')
            ->where('up.event_manager', $eventManager)
            ->whereRaw(" (status = '1' or status = '0') ". $searchQuery)
            ->orderBy($columnName, $columnSortOrder)->skip($row)->take($rowperpage)->get()->toArray();
        return $result;
    }

    public static function unassignedTeamusers ($data){
        $result = DB::table('user_parents as up')
            ->select(DB::raw('u.email'))
            ->join('users as u', 'u.id', '=', 'up.user_id')
            ->where(["u.status"=>1, "up.event_manager" =>session('manager_id')])
            ->whereNotIn('up.user_id', $data)
            ->get()
            ->toArray();
        return $result;
    }

    public static function userExistInAnyTeam ($email){
        // User::where(["email"=>$value, "event_manager"=>session('manager_id')])->first();
        $result = DB::table('user_parents as up')
            ->select(DB::raw('u.*'))
            ->join('users as u', 'u.id', '=', 'up.user_id')
            ->where(["u.email"=>$email, "up.event_manager"=>session('manager_id')])->first();
        return $result;
    }
}
