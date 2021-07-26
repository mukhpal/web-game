<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{

    protected $table = 'survey';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'event_id', 'user_id', 'team_id', 'rating', 'survey'
    ];

}
