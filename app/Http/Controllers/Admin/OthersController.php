<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Vinkla\Hashids\Facades\Hashids;

use App\Models\Others;

class OthersController extends Controller{ 

    public function __construct() {
        $this->middleware('guest:admin');
    }

    
    public function index(){
        $title = "Other Configurations";
        return view('admin.others.others', ['title' => $title,"breadcrumbItem"=>"Others" , "breadcrumbTitle"=>"Others", "breadcrumbTitle2"=>""]);
    }

    public function callouts( ) {

        $callouts_db = Others::where( ["parent_key" => 'callouts'] )->get();

        if( !$callouts_db ) { 
            return redirect( )->route( 'admin.others' )->with('errors', 'Selected content not found');
        }
        
        $callouts_heading = $callouts = "";

        foreach ($callouts_db as $record) {
            if($record->key == 'callouts_heading' ){
                $callouts_heading = $record->content;
            }

            if($record->key == 'callouts' ){
                $callouts = $record->content;
            }
        }

        $title = "Edit callouts";
        return view( 
                'admin.others.callouts',
                [ 
                    'title' => $title,
                    "breadcrumbItem" => "callouts",
                    "breadcrumbTitle" => $title,
                    "breadcrumbLink" => 'admin.callouts',
                    "breadcrumbTitle2" => $title,
                    "callouts_heading"  =>  $callouts_heading,
                    "callouts"  =>  $callouts
                ]
            );
    }

    public function updateCallout(REQUEST $request) {

        $validatedData = $this->validate($request, [
            'callouts_heading' => 'required',
            'callouts' => 'required'
        ]);

        $callouts_heading = Others::where('key', 'callouts_heading')->count();

        if(!$callouts_heading){
            Others::create(['key'=> 'callouts_heading', 'parent_key' => 'callouts', 'content' => $request->callouts_heading, 'created_at' => Carbon::now()]); 
        }else{
            Others::where('key', 'callouts_heading')->update(['content' => $request->callouts_heading]);
        }

        $callouts = Others::where('key', 'callouts')->count();
        
        if(!$callouts){
            Others::create(['key'=> 'callouts', 'parent_key' => 'callouts', 'content' => $request->callouts, 'created_at' => Carbon::now()]); 
        }else{
            Others::where('key', 'callouts')->update(['content' => $request->callouts, 'updated_at' => Carbon::now()]);
        }
        
        return redirect()->route('admin.callouts')->with(['success'=>'Callouts details has been updated successfully.']);
    }
    
}