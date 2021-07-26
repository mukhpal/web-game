<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CiGuests extends Model
{
    protected $guard = 'ci_guests';

    protected $table = 'ci_guests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'role', 'type', 'age', 'height', 'weight', 'eye_color', 'hair_color', 'image', 
        'description', 'fingerprints_img'
    ];
}
