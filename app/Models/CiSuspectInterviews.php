<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CiSuspectInterviews extends Model
{
    protected $guard = 'ci_suspect_interviews';

    protected $table = 'ci_suspect_interviews';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'suspect_id', 'interview', 'status', 'created_at', 'updated_at'
    ];
}
