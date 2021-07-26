<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class States extends Model
{

    protected $table = 'states';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'country_id', 'timezone',
    ];

    public static function getTimezone ($id, $type = 'users'){

    	$table = ($type == 'users') ? 'users' : 'event_managers';

    	return DB::table($table .' as a')
            ->select('s.timezone')
            ->join('states as s', 'a.state_id', '=', 's.id')
            ->where('a.id', $id)
            ->first();    	
    }
}
