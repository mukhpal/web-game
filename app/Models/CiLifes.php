<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CiLifes extends Model
{
    protected $guard = 'ci_lifes';

    protected $table = 'ci_lifes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'team_id', 'event_id', 'question'
    ];
}
