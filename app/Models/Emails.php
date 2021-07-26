<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emails extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'emailtemplates';


    protected $primaryKey = 'id';


    protected $fillable = [
        'subject', 'email_template','status'
    ];


}
