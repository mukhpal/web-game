<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CiQuestions extends Model
{

	protected $guard = 'ci_questions';

    protected $table = 'ci_questions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'serial', 'question'
    ];
}
