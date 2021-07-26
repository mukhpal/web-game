<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Crops extends Model
{

    protected $guard = 'crops';


    protected $table = 'crops';

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'cost', 'status', 'round'
    ];

   
}
