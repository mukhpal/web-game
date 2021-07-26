<?php

namespace App\Http\Controllers\Admin;


use Auth;
use App\Http\Controllers\Controller;
use App\Models\Crops;
use App\Models\Emails;
use App\Models\Countries;
use App\Models\States;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Http\Middleware\RedirectIfAuthenticated;
use Session;
use Illuminate\Support\Facades\Redirect;
use Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Input;
use Config;
use xmlapi;
use Hash;
use Carbon\Carbon;
use App\Http\Controllers\Admin\CommonController;
use Illuminate\Support\Facades\URL;
use Vinkla\Hashids\Facades\Hashids;
use App\Http\Traits\CommonMethods;

class CropsController extends Controller{
  use CommonMethods;

  public function __construct() {
    $this->middleware('guest:admin');
  }

  /* get userlisting  */
  public function cropsListing(Request $request){
    $title = "Manage Crops";
    return view('admin.crops.crops', ['title' => $title, "breadcrumbItem" => "Manage Crops" , "breadcrumbTitle"=>"Manage Crops", "breadcrumbLink" =>"", "breadcrumbTitle2"=> ""]);
  }

  public function addCrop(){
    $title = "Add Crop";
    return view('admin.crops.add_crop', ['title' => $title, "breadcrumbItem" => "Crops" , "breadcrumbTitle"=> "Add Crop", "breadcrumbLink" =>"admin.cropslist", "breadcrumbTitle2"=>"Add Crop"]);
  }


  public function saveCrop(Request $request){

    $validatedData = $this->validate($request, [
        'name' => 'required|regex:/^[0-9a-zA-Z\s]+$/u|unique:crops,name',
        'cost' => 'required|between:0,99.99',
        'round' => 'required|between:1,8'
    ]);

    $details = array(
      "name" => $request->name,
      "cost" => $request->cost,
      "round" => $request->round,
      "status" => 1
    );   

    $response = Crops::create($details); 
    if($response){
      return redirect()->route('admin.cropslist')->with(['success'=>'Details has been added successfully.']);
    }else{
      return redirect()->route('admin.cropslist')->with(['error'=>'Error occured while adding details.']);
    }

  }
  


  public function editCrop($id){
    $title = "Edit Crop";
    $decryptId = Hashids::decode($id);
    $data = Crops::find($decryptId[0]);

    return view('admin.crops.edit_crop', ['title' => $title, "data"=> $data, "breadcrumbItem" => "Manage Crops" , "breadcrumbTitle"=> "Edit Crop", "breadcrumbLink" =>"admin.cropslist", "breadcrumbTitle2"=>"Edit Crop"]);
  }


  public function updateCrop(Request $request){

    $validatedData = $this->validate($request, [
        'name' => 'required|regex:/^[0-9a-zA-Z\s]+$/u',
        'cost' => 'required|between:0,99.99',
        'round' => 'required|between:0,99.99'
    ]);

    $crop = Crops::find($request->id);

    $crop->name = $request->name;
    $crop->cost = $request->cost;
    $crop->round = $request->round;
    $crop->updated_at = Carbon::now();
    $crop->save();

    if($crop){
      return redirect()->route('admin.cropslist')->with(['success'=>'Details has been updated successfully.']);
    }else{
      return redirect()->route('admin.cropslist')->with(['error'=>'Error occured while updating details.']);
    }

  }



  public function ajaxDataLoad(Request $request){

    $draw = $_GET['draw'];
    $row = $_GET['start'];
    $rowperpage = $_GET['length']; // Rows display per page
    $columnIndex = $_GET['order'][0]['column']; // Column index
    $columnName = $_GET['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $_GET['order'][0]['dir']; // asc or desc
    $searchValue = $_GET['search']['value']; // Search value
    
    $columns = [
        0 => 'id',
        1 => 'name',
        2 => 'round',
        3 => 'cost',
        4 => 'status',
        5 => 'created_at',
        6 => 'action'
    ];
    $columnName = $columns[$columnIndex];

    ## Search 
    $searchQuery = " ";
    if($searchValue != ''){
       $searchQuery = " and (name like '%".$searchValue."%' or cost like '%".$searchValue."%' or round like '%".$searchValue."%' ) ";
    }
    
    ## Total number of records
    $totalRecords = Crops::whereRaw(" (status = '1' or status = '0' )")->count();
    
    ## Total number of record with filtering
    $totalRecordwithFilter = Crops::whereRaw("(status = '1' or status = '0' ) ". $searchQuery)->count();
    
    ## Fetch records
    $list = Crops::whereRaw("(status = '1' or status = '0' ) ". $searchQuery)->orderBy($columnName, $columnSortOrder)->skip($row)->take($rowperpage)->get();

    $checkbox = ""; $data = array(); $action = "";
    if(!empty($list)){
        $x = 0;
        foreach($list as $list){
        $encryptId = Hashids::encode($list["id"]);  
        $checkbox = '<div class="animated-checkbox"><label style="margin-bottom:0px;"><input type="checkbox" name="ids[]" value="'.Hashids::encode($list['id']).'" /><span class="label-text"></span></label></div>';
        $action = "<a href=\"editcrop/".$encryptId."\"><i class='fa fa-pencil' aria-hidden='true'></i></a> &nbsp;&nbsp; <a href='javascript:void(0);' onclick=\"delete_row('".$encryptId."', '$list[name]', '".$x."')\"><i class='fa fa-trash' aria-hidden='true'></i></a></i>";
           $data[] = array( 
              $checkbox,
              $list['name'],
              $list['round'],
              $list['cost'],
              $list['status'] =="1" ? "<span class='badge' style='background:green; color:#FFF; padding:5px;'><a class='active-inactive' href='javascript:void(0);' title='Click to make it inactive' onclick=\"activeInactiveState('".$encryptId."', '0')\">Active</a></span>" : "<span class='badge' style='background:#FF0000; color:#FFF; padding:5px;'><a class='active-inactive' href='javascript:void(0);' onclick=\"activeInactiveState('".$encryptId."', '1')\" title='Click to make it active'>Inactive</a></span>",
              date("d M, Y", strtotime($list['created_at'])),
              $action
           );
           $x++;
        }
    }
    ## Response
    $response = array(
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordwithFilter,
      "aaData" => $data
    );
    echo json_encode($response);
    exit;
  }
    


}
