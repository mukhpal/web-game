<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Vinkla\Hashids\Facades\Hashids;

use App\Models\Packages;

class PackagesController extends Controller{ 

    public function __construct() {
        $this->middleware('guest:admin');
    }
    
    public function index( ){
        $title = "Packages";
        return view('admin.cms.packages.index', [ 'title' => $title, "breadcrumbItem" => $title, "breadcrumbTitle" => $title, "breadcrumbLink" => "", "breadcrumbTitle2"=> ""]);
    }

    public function list( Request $request) { 

        $requestedData  = $request->all();

        $draw           = ( isset( $requestedData[ 'draw' ] ) && $requestedData[ 'draw' ] > 0 )?$requestedData[ 'draw' ]:1;
        $start          = ( isset( $requestedData[ 'start' ] ) && $requestedData[ 'start' ] > 0 )?$requestedData[ 'start' ]:0;
        $perPackage        = ( isset( $requestedData[ 'length' ] ) && $requestedData[ 'length' ] > 0 )?$requestedData[ 'length' ]:10;
        $search         = ( isset( $requestedData[ 'search' ] ) && isset( $requestedData[ 'search' ][ 'value' ] ) )?$requestedData[ 'search' ][ 'value' ]:'';
        
        $orderColumn    = ( isset( $requestedData[ 'order' ] ) && isset( $requestedData[ 'order' ][ 0 ] ) && isset( $requestedData[ 'order' ][ 0 ][ 'column' ] ) )?$requestedData[ 'order' ][ 0 ][ 'column' ]:0;
        $orderDir        = ( isset( $requestedData[ 'order' ] ) && isset( $requestedData[ 'order' ][ 0 ] ) && isset( $requestedData[ 'order' ][ 0 ][ 'dir' ] ) )?$requestedData[ 'order' ][ 0 ][ 'dir' ]:'ASC';

        $tblName        = with( new Packages )->getTable( ); 
        $orderByColumns = [ 0 => $tblName . '.id', 1 => $tblName . '.name', 4 => $tblName . '.status', 5 => $tblName . '.order' ];

        $packageObj = Packages::where( 'deleted', 0 )->orderBy( $orderByColumns[ $orderColumn ], $orderDir );

        $totalItems = $packageObj->count( );

        if( $search ) { 
            $packageObj->where( $tblName . '.name', 'like', "%{$search}%" );
        }

        $recordsFiltered = $packageObj->count( );

        $packages = $packageObj->offset( $start )->limit( $perPackage )->get( );

        $durations = \Config::get( 'constants.packags_duration' );

        $data = [ "draw" => $draw, "recordsTotal" => $totalItems, "recordsFiltered" => $recordsFiltered, "data" => [] ];
        if( $packages->count( ) > 0 ) { 
            foreach( $packages as $package ) { 
                $encId = Hashids::encode( $package->id );
                $data[ 'data' ][] = [ 
                                    '<div class="animated-checkbox"><label style="margin-bottom:0px;"><input type="checkbox" name="ids[]" value="'.Hashids::encode($package->id).'" /><span class="label-text"></span></label></div>',
                                    $package->name,
                                    $durations[ $package->durations ],
                                    '$' . $package->price,
                                    $package->status =="1" ? "<span class='badge' style='background:green; color:#FFF; padding:5px;'><a class='active-inactive' href='javascript:void(0);' title='Click to make it inactive' onclick=\"activeInactiveState('".$encId."', '0')\">Active</a></span>" : "<span class='badge' style='background:#FF0000; color:#FFF; padding:5px;'><a class='active-inactive' href='javascript:void(0);' onclick=\"activeInactiveState('".$encId."', '1')\" title='Click to make it active'>Inactive</a></span>",
                                    $package->order,
                                    '<a href="' . route('admin.edit_package', [ 'key'=>  $encId ] ). '" class="add" title="Edit Package"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="return deleteOne( \'' . $encId . '\' );" class="add" title="Delete Package"><i class="fa fa-trash"></i></a>',
                                    $encId,
                                    $package->order
                                ];
            }
        }

        return response( )->json($data);
    }
    
    public function create( ){
        $title = "Add New Package";

        $durations = \Config::get( 'constants.packags_duration' );

        return view( 'admin.cms.packages.create', [ 'title' => $title, "breadcrumbItem" => "Packages", "breadcrumbTitle" => $title, "breadcrumbLink" => 'admin.packages', "breadcrumbTitle2" => $title, 'durations' => $durations ] );
    }
    
    public function add( Request $request ){
        
        $request->validate([
                'name' => 'required|max:100',
                'durations' => 'required',
                'price' => 'required',
                'image' => 'sometimes|nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageField = isset( $request->image )?$request->image:false;
        $fileName = '';

        if( $imageField ) { 
            $uploadPath = public_path('upload/packages/');
            $imageName = time( ).'-' . $imageField->getClientOriginalName( );
            $uploadedFile = $imageField->move( $uploadPath, $imageName );
            if( $uploadedFile ) { 
                $fileName = $uploadedFile->getFilename( );
            }
        }
        
        $isPackageAlreadyAdded = Packages::where( 'name', $request->name )->count( );
        if( $isPackageAlreadyAdded > 0 ) { 
            return redirect()->back()->withInput()->with('custom_errors', 'Package already exists' );
        }
            
        $packageObj = new Packages;
        $packageObj->name = $request->name;
        $packageObj->durations = $request->durations;
        $packageObj->description = strip_tags($request->description);
        $packageObj->price = number_format( $request->price, 2, '.', '' );
        $packageObj->image = $fileName;

        $isAdded = $packageObj->save();
        if( !$isAdded ){
            return redirect()->back()->withInput()->with('custom_errors', 'Something went wrong to add package, please try again later.');
        }

        $packageObj->order = $packageObj->id;
        $packageObj->save( );

        Packages::resetOrder();
        
        return redirect()->route( 'admin.packages' )->with( 'success', 'Package has been successfully added!' );
    }

    public function edit( $encodedId ) {
        $encodedId = (string)$encodedId;
        if( !$encodedId ) { 
            return redirect( )->route( 'admin.packages' )->with('errors', 'Invalid Request');
        }

        $decodedId = Hashids::decode( $encodedId );
        if( !$decodedId ) { 
            return redirect( )->route( 'admin.packages' )->with('errors', 'Invalid Request');
        }

        $decodedId = reset( $decodedId );
        if( $decodedId <= 0 ) { 
            return redirect( )->route( 'admin.packages' )->with('errors', 'Invalid Request');
        }

        $package = Packages::where( 'deleted', 0 )->find( $decodedId );
        if( !$package ) { 
            return redirect( )->route( 'admin.packages' )->with('errors', 'Selected packages not found');
        }
        
        $title = "Edit Package: " . substr( $package->name, 0, 30 ) . ( ( strlen( $package->name ) > 30 )?'...':'' );
        
        $durations = \Config::get( 'constants.packags_duration' );

        return view( 
                'admin.cms.packages.edit',
                [ 
                    'title' => $title,
                    "breadcrumbItem" => "Packages",
                    "breadcrumbTitle" => $title,
                    "breadcrumbLink" => 'admin.packages',
                    "breadcrumbTitle2" => $title,
                    'package' => $package,
                    'durations' => $durations
                ]
            );
    }

    public function update( $encodedId, Request $request ){

        $encodedId = (string)$encodedId;
        if( !$encodedId ) { 
            return redirect( )->route( 'admin.packages' )->with('errors', 'Invalid Request');
        }

        $decodedId = Hashids::decode( $encodedId );
        if( !$decodedId ) { 
            return redirect( )->route( 'admin.packages' )->with('errors', 'Invalid Request');
        }

        $decodedId = reset( $decodedId );
        if( $decodedId <= 0 ) { 
            return redirect( )->route( 'admin.packages' )->with('errors', 'Invalid Request');
        }

        $package = Packages::where( 'deleted', 0 )->find( $decodedId );
        if( !$package ) { 
            return redirect( )->route( 'admin.packages' )->with('errors', 'Selected packge not found');
        }

        $regex = "/^[0-9]*\.[0-9]{2}$/";

        $request->validate([
            'name' => 'required|max:100',
            'durations' => 'required',
            'price' => 'required',
            'image' => 'sometimes|nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $isPackageAlreadyAdded = Packages::where( 'name', $request->name )->where( 'id', '!=', $decodedId  )->count();
        if( $isPackageAlreadyAdded > 0 ) { 
            return redirect()->back()->withInput()->with('custom_errors', 'Package already exists' );
        }

        $imageField = isset( $request->image )?$request->image:false;
        $fileName = $package->image;

        if( $imageField ) { 
            $uploadPath = public_path('upload/packages/');
            $imageName = time( ).'-' . $imageField->getClientOriginalName( );
            $uploadedFile = $imageField->move( $uploadPath, $imageName );
            if( $uploadedFile ) { 
                if( $fileName ){
                    $filename = $uploadPath.$fileName;
                    \File::delete($filename);
                }

                $fileName = $uploadedFile->getFilename( );
            }
        }

        $package->name = $request->name;
        $package->durations = $request->durations;
        $package->description = strip_tags($request->description);
        $package->price = number_format( $request->price, 2, '.', '' );
        $package->image = $fileName;

        $isUpdated = $package->save();
        if( !$isUpdated ){
            return redirect()->back()->withInput()->with('custom_errors', 'Something went wrong to update package, please try again later.');
        }

        Packages::resetOrder();
        
        return redirect()->back( )->with( 'success', 'Package has been successfully updated!' );
    }

    function delete( Request $request ){

        $validatorObj = Validator::make($request->all(), [
                                            'ids.*' => 'required',
                                        ],[
                                            'ids.*.required' => 'Please select at least one package'
                                        ]);
        if( !$validatorObj->validate() ) {
            return response()->json([ 'status' => 0, 'msg' => 'Please select at least one package' ]);
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
            return response()->json([ 'status' => 0, 'msg' => 'Selected package(s) not found' ]);
        }

        $packageObj = Packages::whereIn( 'id', $decodedIds )->update(['deleted' => 1]);

        Packages::resetOrder();
        
        return response()->json([ 'status' => 1, 'msg' => 'Package(s) deleted successfully!' ] );
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
        
        $items = Packages::whereIn( 'id', $ids )->get();
        if( $items->count() !=  count( $request_data['replace_ids'] ) ) { 
            return response()->json([ 'errors' => 'Unable to update order, please try again later.' ]);
        }

        foreach( $items as $item ){ 
            $item->order = $positions[ $item->id ];
            $item->save();
        }
        
        Packages::resetOrder();
        
        return response()->json([ 'success' => 'Order updated successfully' ]);

    }

}