<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Facades\DB;

class SocketConnectUsers extends Model
{
    private static $instance;

    protected $table = 'socket_connected_users';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'event_id', 'socket_id',
    ];


    public static function getInstance() {
      if (!isset(self::$instance)) {
          self::$instance = new static();
      }
      return self::$instance;
    }


}
