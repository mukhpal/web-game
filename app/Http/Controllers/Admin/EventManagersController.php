<?php

namespace App\Http\Controllers\Admin;


use Auth;
use App\Http\Controllers\Controller;
use App\Models\EventManagers;
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

class EventManagersController extends Controller{
  use CommonMethods;

  public function __construct() {
    $this->middleware('guest:admin');
  }

  /* get userlisting  */
  public function eventManagerListing(Request $request){

    $title = "Event Managers";
    return view('admin.eventmanagers.event_managers', ['title' => $title, "breadcrumbItem" => "Event Managers" , "breadcrumbTitle"=>"Event Managers", "breadcrumbLink" =>"", "breadcrumbTitle2"=> ""]);
  }

  public function addEventManager(){
    $title = "Add Event Manager";
    $countries = Countries::all();
    return view('admin.eventmanagers.add_event_manager', ['title' => $title, "breadcrumbItem" => "Event Managers" , "breadcrumbTitle"=> "Add Event Manager", "breadcrumbLink" =>"admin.eventmanagerlist", "breadcrumbTitle2"=>"Add Event Manager", 'countries' => $countries]);
  }


  public function saveEventManager(Request $request){

    $validatedData = $this->validate($request, [
        'fullname' => 'required|regex:/^[0-9a-zA-Z\s]+$/u',
        'companyname' => 'required|regex:/^[0-9a-zA-Z\s]+$/u',
        'email' => 'required|unique:event_managers,email',
        'country' => 'required',
        'state' => 'required',
    ]);

    $randomPassword = str_random(6);
    $details = array(
      "name" => $request->fullname,
      "company_name" => $request->companyname,
      "email" => $request->email,
      "password" => Hash::make($randomPassword),
      "country_id" => $this->decodeId($request->country),
      "state_id" => $this->decodeId($request->state),
      "status" => 1
    );   

    $response = EventManagers::create($details); 
    if($response){

      $signup_email = Emails::where(['email_slug' => 'register_email'])->first();

      $emailTemplateDecode = html_entity_decode($signup_email['email_template']);
      $email_body = str_replace("##name##", $request->fullname, $emailTemplateDecode);
      $email_body = str_replace("##email##", $request->email, $email_body);
      $email_body = str_replace("##password##", $randomPassword, $email_body);
      $email_body = str_replace("##logopath##", url('/').'/assets/front/images/email/logo.png', $email_body);
      
      $emailParams = array("to"=>$request->email, "subject"=>$signup_email['subject'], "content"=>$email_body);
      //Method to send email
      $this->sendEmail($emailParams);

      return redirect()->route('admin.eventmanagerlist')->with(['success'=>'Details has been added successfully.']);
    }else{
      return redirect()->route('admin.eventmanagerlist')->with(['error'=>'Error occured while adding details.']);
    }

  }
  


  public function editEventManager($id){
    $title = "Edit Event Manager";
    $decryptId = Hashids::decode($id);
    $data = EventManagers::find($decryptId[0]);
    $countries = Countries::all();
    $states = States::where( ["country_id" => $data->country_id] )->get();
    return view('admin.eventmanagers.edit_event_manager', ['title' => $title, "data"=> $data, "breadcrumbItem" => "Event Managers" , "breadcrumbTitle"=> "Edit Event manager", "breadcrumbLink" =>"admin.eventmanagerlist", "breadcrumbTitle2"=>"Edit Event Manager", 'countries' => $countries, 'states' => $states]);
  }


  public function updateEventManager(Request $request){

    $validatedData = $this->validate($request, [
        'fullname' => 'required|regex:/^[0-9a-zA-Z\s]+$/u',
        'companyname' => 'required|regex:/^[0-9a-zA-Z\s]+$/u',
        'email' => 'required|unique:event_managers,email,' . $request->id,
        "country" => 'required',
        "state" => 'required'
        /*,
        'password' => 'nullable|min:6',
        'gender' => 'required'*/
    ]);

    $randomPassword = str_random(6);
    $eventnamager = EventManagers::find($request->id);
    if($request->email!=$eventnamager->email){
      $signup_email = Emails::where(['email_slug' => 'register_email'])->first();

      $emailTemplateDecode = html_entity_decode($signup_email['email_template']);
      $email_body = str_replace("##name##", $request->fullname, $emailTemplateDecode);
      $email_body = str_replace("##email##", $request->email, $email_body);
      $email_body = str_replace("##password##", $randomPassword, $email_body);

      $emailParams = array("to"=>$request->email, "subject"=>$signup_email['subject'], "content"=>$email_body);
      //Method to send email
      $this->sendEmail($emailParams);
    }
    $eventnamager->name = $request->fullname;
    $eventnamager->company_name = $request->companyname;
    $eventnamager->email = $request->email;
    $eventnamager->country_id = $this->decodeId($request->country);
    $eventnamager->state_id = $this->decodeId($request->state);
    $eventnamager->updated_at = Carbon::now();
    $eventnamager->save();

    if($eventnamager){
      return redirect()->route('admin.eventmanagerlist')->with(['success'=>'Details has been updated successfully.']);
    }else{
      return redirect()->route('admin.eventmanagerlist')->with(['error'=>'Error occured while updating details.']);
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
        2 => 'email',
        3 => 'company_name',
        4 => 'status',
        5 => 'created_at',
        6 => 'email'
    ];
    $columnName = $columns[$columnIndex];

    ## Search 
    $searchQuery = " ";
    if($searchValue != ''){
       $searchQuery = " and (name like '%".$searchValue."%' or email like '%".$searchValue."%' or company_name like '%".$searchValue."%' ) ";
    }
    
    ## Total number of records
    $totalRecords = EventManagers::whereRaw(" (status = '1' or status = '0' )")->count();
    
    ## Total number of record with filtering
    $totalRecordwithFilter = EventManagers::whereRaw("(status = '1' or status = '0' ) ". $searchQuery)->count();
    
    ## Fetch records
    $list = EventManagers::whereRaw("(status = '1' or status = '0' ) ". $searchQuery)->orderBy($columnName, $columnSortOrder)->skip($row)->take($rowperpage)->get();

    $checkbox = ""; $data = array(); $action = "";
    if(!empty($list)){
        $x = 0;
        foreach($list as $list){
        $encryptId = Hashids::encode($list["id"]);  
        $checkbox = '<div class="animated-checkbox"><label style="margin-bottom:0px;"><input type="checkbox" name="ids[]" value="'.Hashids::encode($list['id']).'" /><span class="label-text"></span></label></div>';
        $action = "<a href=\"editeventmanager/".$encryptId."\"><i class='fa fa-pencil' aria-hidden='true'></i></a> &nbsp;&nbsp; <a href='javascript:void(0);' onclick=\"delete_row('".$encryptId."', '$list[name]', '".$x."')\"><i class='fa fa-trash' aria-hidden='true'></i></a></i>";
           $data[] = array( 
              $checkbox,
              $list['name'],
              $list['email'],
              $list['company_name'],
              ( ( $list['approved'] == 0 ) ? "<span class='badge' style='background:#FF0000; color:#FFF; padding:5px;'><a class='active-inactive' href='javascript:void(0);' onclick=\"markApproved( '".$encryptId."', '#eventmanagerTable' )\" title='Admin approval pending, Click here to mark it approved'>Approval Pending</a></span>" :( $list['status'] =="1" ? "<span class='badge' style='background:green; color:#FFF; padding:5px;'><a class='active-inactive' href='javascript:void(0);' title='Click to make it inactive' onclick=\"activeInactiveState('".$encryptId."', '0')\">Active</a></span>" : "<span class='badge' style='background:#FF0000; color:#FFF; padding:5px;'><a class='active-inactive' href='javascript:void(0);' onclick=\"activeInactiveState('".$encryptId."', '1')\" title='Click to make it active'>Inactive</a></span>" ) ),
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
    
  function approveEventManageAccount( Request $request ){
    $validatorObj = Validator::make($request->all(), [
          'id' => 'required'
        ],[
          'id.required' => 'Please select at least one package'
        ]);

    if( !$validatorObj->validate() ) {
      return response()->json([ 'status' => 0, 'msg' => 'Please select event manager' ]);
    }

    $decodedId = Hashids::decode( (string)$request->id );
    if( !$decodedId ) { 
      return response()->json([ 'status' => 0, 'msg' => 'Please select event manager' ]);
    }

    $decodedId = reset( $decodedId );
    if( $decodedId <= 0 ) { 
      return response()->json([ 'status' => 0, 'msg' => 'Please select event manager' ]);
    }

    $obj = EventManagers::find( $decodedId );
    if( !$obj ) { 
      return response()->json([ 'status' => 0, 'msg' => 'Event manager not found' ]);
    }

    if( $obj->approved == 1 ) { 
      return response()->json([ 'status' => 0, 'msg' => 'Event manager already approved' ]);
    }

    $obj->approved = 1;
    $obj->save( );

    return response()->json([ 'status' => 1, 'msg' => 'Event manager approved!' ] );

  }

}
