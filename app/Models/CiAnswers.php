<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CiAnswers extends Model
{
    protected $guard = 'ci_answers';

    protected $table = 'ci_answers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'team_id', 'event_id', 'question', 'answer', 'status', 'answered_at'
    ];
}
