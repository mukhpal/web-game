<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faqs extends Model
{
    protected $table = 'faqs';

    public static function resetOrder(){
        $faqs = SELF::orderBy( 'order', 'ASC' )->get();
        if( $faqs->count() > 0 ) { 
            $startOrder = 1;
            foreach( $faqs as $faq ){

                $faq->order = $startOrder;
                $faq->save( );
                $startOrder++;

            }
        }

        return true;
    }
}
