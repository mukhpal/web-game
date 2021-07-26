<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TeamTotalAssets extends Model
{
    protected $table = 'round_team_assets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'round', 'event_id', 'team_id', 'total_asset'
    ];
}
