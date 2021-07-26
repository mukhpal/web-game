<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentConfigurations extends Model
{
    protected $table = 'content_configurations';

    protected $primaryKey = 'cc_key';

    public $incrementing = false;

    public $timestamps = false;
    
    public static function getAll( $keys = [] ){

        if( $keys ) $confs = static::whereIn( 'cc_key', $keys )->get( )->toArray( );
        else $confs = static::get( )->toArray( );

        $data = [];
        foreach( $confs as $conf ){
            $data[ $conf[ 'cc_key' ] ] = ( $conf[ 'cc_serialize' ] )?unserialize( $conf[ 'cc_value' ] ):$conf[ 'cc_value' ];
        }

        return $data;

    }

    public static function getConf( $key ){
        if( !$key ) return false;
        $conf = static::find( $key );
        return ( $conf[ 'cc_serialize' ] )?unserialize( $conf[ 'cc_value' ] ):$conf[ 'cc_value' ];
    }

}
