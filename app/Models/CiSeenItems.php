<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CiSeenItems extends Model
{
    protected $guard = 'ci_seen_items';

    protected $table = 'ci_seen_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'team_id', 'event_id', 'item_id', 'item_name', 'action', 'suspect_id'
    ];
}
