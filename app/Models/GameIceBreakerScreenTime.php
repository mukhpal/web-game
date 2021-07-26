<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class GameIceBreakerScreenTime extends Model
{
    private static $instance;

    protected $table = 'game_ice_breaker_screen_time';

    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ibst_event_id', 'ibst_team_id', 'ibst_event_start_time', 'ibst_awaiting_screen_time', 'ibst_fun_facts_screen_time','ibst_ice_breaker_game_screen_time', 'ibst_mm_awaiting_screen_time'
    ];

}
