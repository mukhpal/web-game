<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    protected $table = 'pages';

    protected $primaryKey = 'page_key';

    public $incrementing = false;

    public function pageContent( ) { 
        return $this->hasMany('App\Models\PageContent', 'pc_page_key');
    }
}
