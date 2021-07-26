<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Others extends Model
{
	private static $instance;

	protected $table = 'other_content';

    protected $fillable = [ 
        'key', 'parent_key', 'content'
     ];

}
