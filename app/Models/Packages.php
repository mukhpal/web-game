<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    protected $table = 'packages';

    public static function resetOrder(){
        $packages = SELF::where( 'deleted', 0 )->orderBy( 'order', 'ASC' )->get( );
        if( $packages->count() > 0 ) { 
            $startOrder = 1;
            foreach( $packages as $package ){

                $package->order = $startOrder;
                $package->save( );
                $startOrder++;

            }
        }

        return true;
    }
}
