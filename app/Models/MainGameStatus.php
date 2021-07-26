<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MainGameStatus extends Model
{
    protected $guard = 'main_game_status';

    protected $table = 'main_game_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'team_id', 'event_id', 'game_key', 'start_time', 'end_time' ,'status', 'rank'
    ];
}