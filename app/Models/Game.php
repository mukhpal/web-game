<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [ 
        'id', 'key', 'name', 'description', 'status', 'game_type', 'link', 'price', 'image_lnk', 'game_times', 'desc_agenda'
     ];

     /**
     * Get the game that belongs to the event.
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'main_game', 'id');
    }
}
