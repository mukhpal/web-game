<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Vinkla\Hashids\Facades\Hashids;

use App\Models\Game;

class GamesController extends Controller{ 

    public function __construct() {
        $this->middleware('guest:admin');
    }

    
    public function index( ){
        $title = "Games";
        return view('admin.games.index', [ 'title' => $title, "breadcrumbItem" => "Games" , "breadcrumbTitle"=>"Games", "breadcrumbLink" =>"", "breadcrumbTitle2"=> ""]);
    }

    public function list( Request $request) { 

        $requestedData  = $request->all();

        $draw           = ( isset( $requestedData[ 'draw' ] ) && $requestedData[ 'draw' ] > 0 )?$requestedData[ 'draw' ]:1;
        $start          = ( isset( $requestedData[ 'start' ] ) && $requestedData[ 'start' ] > 0 )?$requestedData[ 'start' ]:0;
        $perPage        = ( isset( $requestedData[ 'length' ] ) && $requestedData[ 'length' ] > 0 )?$requestedData[ 'length' ]:10;
        $search         = ( isset( $requestedData[ 'search' ] ) && isset( $requestedData[ 'search' ][ 'value' ] ) )?$requestedData[ 'search' ][ 'value' ]:'';
        
        $orderColumn    = ( isset( $requestedData[ 'order' ] ) && isset( $requestedData[ 'order' ][ 0 ] ) && isset( $requestedData[ 'order' ][ 0 ][ 'column' ] ) )?$requestedData[ 'order' ][ 0 ][ 'column' ]:0;
        $orderDir        = ( isset( $requestedData[ 'order' ] ) && isset( $requestedData[ 'order' ][ 0 ] ) && isset( $requestedData[ 'order' ][ 0 ][ 'dir' ] ) )?$requestedData[ 'order' ][ 0 ][ 'dir' ]:'ASC';

        $tblName        = with( new Game )->getTable( ); 
        $orderByColumns = [ 0 => $tblName . '.id', 1 => $tblName . '.name' , 2 => $tblName . '.game_type' ];

        $gameObj = Game::orderBy( $orderByColumns[ $orderColumn ], $orderDir );

        $totalItems = $gameObj->count( );

        if( $search ) { 
            $gameObj->where( $tblName . '.name', 'like', "%{$search}%" );
        }

        $recordsFiltered = $gameObj->count( );

        $games = $gameObj->offset( $start )->limit( $perPage )->get( );

        $data = [ "draw" => $draw, "recordsTotal" => $totalItems, "recordsFiltered" => $recordsFiltered, "data" => [] ];
        if( $games->count( ) > 0 ) { 
            foreach( $games as $game ) { 

                $data[ 'data' ][] = [ 
                                    ++$start,
                                    $game->name,
                                    $game->game_type == 0 ? "Introductory" : "Main game",
                                    $game->status == 0 ? "<span class='badge' style='background:red; color:#FFF; padding:5px;'><a class='active-inactive' href='javascript:void(0);' title='Click to make it active' onclick=\"activeInactiveState('". Hashids::encode( $game->id ) ."', '1')\">Inactive</a></span>" : "<span class='badge' style='background:green; color:#FFF; padding:5px;'><a class='active-inactive' href='javascript:void(0);' title='Click to make it inactive' onclick=\"activeInactiveState('". Hashids::encode( $game->id ) ."', '0')\">Active</a></span>",
                                    '<a href="' . route('admin.edit_game', [ 'key'=> Hashids::encode( $game->id ) ] ) . '" class="add" title=""><i class="fa fa-edit"></i></a>'
                                ];
            }
        }

        return response( )->json($data);
    }

    public function edit( $pageKey ) {
        $encodedId = (string)$pageKey;
        if( !$encodedId ) { 
            return redirect( )->route( 'admin.games' )->with('errors', 'Invalid Request');
        }

        $decodedId = Hashids::decode( $encodedId );
        if( !$decodedId ) { 
            return redirect( )->route( 'admin.games' )->with('errors', 'Invalid Request');
        }

        $decodedId = reset( $decodedId );
        if( $decodedId <= 0 ) { 
            return redirect( )->route( 'admin.games' )->with('errors', 'Invalid Request');
        }

        $game = Game::find( $decodedId );
        if( !$game ) { 
            return redirect( )->route( 'admin.games' )->with('errors', 'Selected game not found');
        }
        
        $title = "Edit Game";
        return view( 
                'admin.games.edit',
                [ 
                    'title' => $title,
                    "breadcrumbItem" => "games",
                    "breadcrumbTitle" => $title,
                    "breadcrumbLink" => 'admin.games',
                    "breadcrumbTitle2" => $title,
                    'data' => $game
                ]
            );
    }

    public function update( $pageKey, Request $request ) {
        $encodedId = (string)$pageKey;
        if( !$encodedId ) { 
            return redirect( )->route( 'admin.games' )->with('errors', 'Invalid Request');
        }

        $decodedId = Hashids::decode( $encodedId );
        if( !$decodedId ) { 
            return redirect( )->route( 'admin.games' )->with('errors', 'Invalid Request');
        }

        $decodedId = reset( $decodedId );
        if( $decodedId <= 0 ) { 
            return redirect( )->route( 'admin.games' )->with('errors', 'Invalid Request');
        }

        $validatedData = $this->validate($request, [
            'name' => 'required',
            'game_type' => 'required',
        ]);

        $game = Game::find( $decodedId );
        if( !$game ) { 
            return redirect( )->route( 'admin.games' )->with('errors', 'Selected game not found');
        }

        $game->name = $request->name;
        $game->description = $request->description;
        $game->game_type = $request->game_type;
        $game->link = $request->link;
        $game->price = $request->price;
        $game->updated_at = Carbon::now();
        $game->save();

        if($game){
          return redirect()->route('admin.games')->with(['success'=>'Game details has been updated successfully.']);
        }
    }
    
}