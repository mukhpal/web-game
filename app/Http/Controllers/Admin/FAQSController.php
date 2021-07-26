<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Vinkla\Hashids\Facades\Hashids;

use App\Models\Faqs;

class FAQSController extends Controller{ 

    public function __construct() {
        $this->middleware('guest:admin');
    }
    
    public function index( ){
        $title = "Faqs";
        return view('admin.cms.faqs.index', [ 'title' => $title, "breadcrumbItem" => "FAQ'S" , "breadcrumbTitle"=>"FAQ'S", "breadcrumbLink" =>"", "breadcrumbTitle2"=> ""]);
    }

    public function list( Request $request) { 

        $requestedData  = $request->all();

        $draw           = ( isset( $requestedData[ 'draw' ] ) && $requestedData[ 'draw' ] > 0 )?$requestedData[ 'draw' ]:1;
        $start          = ( isset( $requestedData[ 'start' ] ) && $requestedData[ 'start' ] > 0 )?$requestedData[ 'start' ]:0;
        $perfaq        = ( isset( $requestedData[ 'length' ] ) && $requestedData[ 'length' ] > 0 )?$requestedData[ 'length' ]:10;
        $search         = ( isset( $requestedData[ 'search' ] ) && isset( $requestedData[ 'search' ][ 'value' ] ) )?$requestedData[ 'search' ][ 'value' ]:'';
        
        $orderColumn    = ( isset( $requestedData[ 'order' ] ) && isset( $requestedData[ 'order' ][ 0 ] ) && isset( $requestedData[ 'order' ][ 0 ][ 'column' ] ) )?$requestedData[ 'order' ][ 0 ][ 'column' ]:0;
        $orderDir        = ( isset( $requestedData[ 'order' ] ) && isset( $requestedData[ 'order' ][ 0 ] ) && isset( $requestedData[ 'order' ][ 0 ][ 'dir' ] ) )?$requestedData[ 'order' ][ 0 ][ 'dir' ]:'ASC';

        $tblName        = with( new Faqs )->getTable( ); 
        $orderByColumns = [ 0 => $tblName . '.order', 1 => $tblName . '.question', 2 => $tblName . '.order' ];

        $faqObj = Faqs::orderBy( $orderByColumns[ $orderColumn ], $orderDir );

        $totalItems = $faqObj->count( );

        if( $search ) { 
            $faqObj->where( $tblName . '.question', 'like', "%{$search}%" );
        }

        $recordsFiltered = $faqObj->count( );

        $faqs = $faqObj->offset( $start )->limit( $perfaq )->get( );

        $data = [ "draw" => $draw, "recordsTotal" => $totalItems, "recordsFiltered" => $recordsFiltered, "data" => [] ];
        if( $faqs->count( ) > 0 ) { 
            foreach( $faqs as $faq ) { 
                $data[ 'data' ][] = [ 
                                    '<div class="animated-checkbox"><label style="margin-bottom:0px;"><input type="checkbox" name="ids[]" value="'.Hashids::encode($faq->id).'" /><span class="label-text"></span></label></div>',
                                    $faq->question,
                                    $faq->order,
                                    '<a href="' . route('admin.edit_faq', [ 'key'=> Hashids::encode( $faq->id ) ] ) . '" class="add" title="Edit Question"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="return deleteOne( \'' . Hashids::encode( $faq->id ) . '\' );" class="add" title="Delete Question"><i class="fa fa-trash"></i></a>',
                                    Hashids::encode( $faq->id ),
                                    $faq->order
                                ];
            }
        }

        return response( )->json($data);
    }
    
    public function create( ){
        $title = "Add New Question";
        return view('admin.cms.faqs.create', [ 'title' => $title, "breadcrumbItem" => "FAQ'S" , "breadcrumbTitle"=>"FAQ'S", "breadcrumbLink" => 'admin.faqs', "breadcrumbTitle2"=> "Add New Question"]);
    }
    
    public function add( Request $request ){
        $request->validate([
                'question' => 'required',
                'answer' => 'required',
        ]);

        $isFaqAlreadyAdded = Faqs::where( 'question', $request->question )->count();
        if( $isFaqAlreadyAdded > 0 ) { 
            return redirect()->back()->withInput()->with('custom_errors', 'Entered question already added in the system' );
        }
            
        $faqObj = new Faqs;
        $faqObj->question = strip_tags($request->question);
        $faqObj->answer = strip_tags($request->answer);
        $isAdded = $faqObj->save();
        if( !$isAdded ){
            return redirect()->back()->withInput()->with('custom_errors', 'Something went wrong to add faq, please try again later.');
        }

        $faqObj->order = $faqObj->id;
        $faqObj->save( );

        Faqs::resetOrder();
        
        return redirect()->route( 'admin.faqs' )->with( 'success', 'Faq has been successfully added!' );
    }

    public function edit( $encodedId ) {
        $encodedId = (string)$encodedId;
        if( !$encodedId ) { 
            return redirect( )->route( 'admin.faqs' )->with('errors', 'Invalid Request');
        }

        $decodedId = Hashids::decode( $encodedId );
        if( !$decodedId ) { 
            return redirect( )->route( 'admin.faqs' )->with('errors', 'Invalid Request');
        }

        $decodedId = reset( $decodedId );
        if( $decodedId <= 0 ) { 
            return redirect( )->route( 'admin.faqs' )->with('errors', 'Invalid Request');
        }

        $faq = faqs::find( $decodedId );
        if( !$faq ) { 
            return redirect( )->route( 'admin.faqs' )->with('errors', 'Selected faq not found');
        }
        
        $title = "Edit Faq: " . substr( $faq->question, 0, 30 ) . ( ( strlen( $faq->question ) > 30 )?'...':'' );
        
        return view( 
                'admin.cms.faqs.edit',
                [ 
                    'title' => $title,
                    "breadcrumbItem" => "FAQ's",
                    "breadcrumbTitle" => $title,
                    "breadcrumbLink" => 'admin.faqs',
                    "breadcrumbTitle2" => $title,
                    'faq' => $faq
                ]
            );
    }

    public function update( $encodedId, Request $request ){

        $encodedId = (string)$encodedId;
        if( !$encodedId ) { 
            return redirect( )->route( 'admin.faqs' )->with('errors', 'Invalid Request');
        }

        $decodedId = Hashids::decode( $encodedId );
        if( !$decodedId ) { 
            return redirect( )->route( 'admin.faqs' )->with('errors', 'Invalid Request');
        }

        $decodedId = reset( $decodedId );
        if( $decodedId <= 0 ) { 
            return redirect( )->route( 'admin.faqs' )->with('errors', 'Invalid Request');
        }

        $faq = faqs::find( $decodedId );
        if( !$faq ) { 
            return redirect( )->route( 'admin.faqs' )->with('errors', 'Selected faq not found');
        }

        $request->validate([
                'question' => 'required',
                'answer' => 'required',
        ]);

        $isFaqAlreadyAdded = Faqs::where( 'question', $request->question )->where( 'id', '!=', $decodedId  )->count();
        if( $isFaqAlreadyAdded > 0 ) { 
            return redirect()->back()->withInput()->with('custom_errors', 'Entered question already added in the system' );
        }

        $faq->question = strip_tags($request->question);
        $faq->answer = strip_tags($request->answer);
        $isUpdated = $faq->save();
        if( !$isUpdated ){
            return redirect()->back()->withInput()->with('custom_errors', 'Something went wrong to update faq, please try again later.');
        }

        Faqs::resetOrder();
        
        return redirect()->back( )->with( 'success', 'Faq has been successfully updated!' );
    }

    function delete( Request $request ){

        $validatorObj = Validator::make($request->all(), [
                                            'ids.*' => 'required',
                                        ],[
                                            'ids.*.required' => 'Please select at least one faq'
                                        ]);
        if( !$validatorObj->validate() ) {
            return response()->json([ 'status' => 0, 'msg' => 'Please select at least one faq' ]);
        }

        $decodedIds = [];
        $errors = false;
        foreach( $request->ids as $id ){
            $decodedId = Hashids::decode( (string)$id );
            if( !$decodedId ) { 
                $errors = true;
                break;
            }

            $decodedId = reset( $decodedId );
            if( $decodedId <= 0 ) { 
                $errors = true;
                break;
            }
            $decodedIds[] = $decodedId;
        }

        if( $errors ) {
            return response()->json([ 'status' => 0, 'msg' => 'Selected faq(s) not found' ]);
        }

        Faqs::whereIn( 'id', $decodedIds )->delete();

        Faqs::resetOrder();
        
        return response()->json([ 'status' => 1, 'msg' => 'Faq deleted successfully!' ] );
    }

    public function reorder( Request $request ) { 
        $request_data = $request->all();

        $validator = $request->validate([
                'replace_ids' => 'required'
            ]);

        if( count( $request_data['replace_ids'] ) <= 1 ) { 
            return response()->json([ 'errors' => 'Unable to update order, please try again later.' ]);
        }

        $positions = $ids = [];
        foreach( array_keys( $request_data['replace_ids'] ) as $id ) { 
            $ids[] = Hashids::decode( ( string )$id )[0];
            $positions[ Hashids::decode( ( string )$id )[0] ] = $request_data['replace_ids'][ $id ];
        }
            
        $items = Faqs::whereIn( 'id', $ids )->get();
        if( $items->count() !=  count( $request_data['replace_ids'] ) ) { 
            return response()->json([ 'errors' => 'Unable to update order, please try again later.' ]);
        }

        foreach( $items as $item ){ 
            $item->order = $positions[ $item->id ];
            $item->save();
        }

        Faqs::resetOrder();
        
        return response()->json([ 'success' => 'Order updated successfully' ]);

    }

}