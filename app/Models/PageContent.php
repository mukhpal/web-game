<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    protected $table = 'page_content';

    protected $primaryKey = null;

    public $incrementing = false;

    public function page( ) { 
        return $this->belongsTo( 'App\Models\Pages' );
    }

}
