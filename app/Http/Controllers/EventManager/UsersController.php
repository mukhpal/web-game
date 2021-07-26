<?php

namespace App\Http\Controllers\EventManager;


use Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserParents;
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
use Carbon\Carbon;
use App\Http\Controllers\Admin\CommonController;
use Illuminate\Support\Facades\URL;
use Vinkla\Hashids\Facades\Hashids;
use App\Http\Traits\CommonMethods;

class UsersController extends Controller{

  use CommonMethods;

  public function __construct() {
    $this->middleware('guest:event_manager');
  }

  /* get userlisting  */
  public function userListing(Request $request){

    $title = "User Management";
    return view('eventmanager.users.users', ['title' => $title, "breadcrumbItem" => "Manage Users" , "breadcrumbTitle" => "", "breadcrumbLink" =>""]);
  }


  /** add user form **/
  public function addUser(){
    $title = "Add User";
    $countries = Countries::all();
    return view('eventmanager.users.add_user', ['title' => $title, "breadcrumbItem" => "Manage Users" , "breadcrumbTitle"=> "Add User", "breadcrumbLink" => "eventmanager.userlist", 'countries' => $countries]);
  }


  /** save new user record **/
  public function saveUser(Request $request){

    $eventmanager = session('manager_id');

    $userdata = User::where("email" , $request->email)->first();
    
    if($userdata){
      $checkParent = UserParents::where(['user_id' => $userdata['id'], "event_manager" => $eventmanager])->first();

      if($checkParent){
        return redirect()->route('eventmanager.userlist')->with(['error'=>'User already exist in your team.']);
      }else{
        $user_parent = array(
          "user_id" => $userdata['id'],
          "event_manager" => $eventmanager
        );

        $userParent = UserParents::create($user_parent);

        if($userParent){
          return redirect()->route('eventmanager.userlist')->with(['success'=>'User has been added successfully in your team.']);
        }
      }
    }
    $validatedData = $this->validate($request, [
        'fullname' => 'regex:/^[0-9a-zA-Z\s]+$/u',
        'email' => "required|unique:users,email",
        'country' => 'required',
        'state' => 'required',
    ]);
    
    $user_details = array(
      "event_manager" => $eventmanager,
      "name" => $request->fullname,
      "email" => $request->email,
      "coutry_id" => $this->decodeId($request->country),
      "state_id" => $this->decodeId($request->state),
      "status" => 1
    );

    $user = User::create($user_details);

    if($user){

      $user_parent = array(
        "user_id" => $user->id,
        "event_manager" => $eventmanager
      );

      $userParent = UserParents::create($user_parent);

      $uniqueIdentity = $this->uniqueId($user->id, 'usr');
      $userupdate = User::find($user->id);
      $userupdate->enc_id = $uniqueIdentity;
      $userupdate->save();

      return redirect()->route('eventmanager.userlist')->with(['success'=>'User detail has been added successfully.']);
    }else{
      return redirect()->route('eventmanager.userlist')->with(['error'=>'Error occured while adding user.']);
    }

  }
  

  /** edit form user **/
  public function editUser($id){
    $title = "Edit User";
    $decryptUserId = Hashids::decode($id);
    $user_detail = User::find($decryptUserId[0]);
    $countries = Countries::all();
    $states = States::where( ["country_id" => $user_detail->coutry_id] )->get();
    return view('eventmanager.users.edit_user', ['title' => $title, "user"=> $user_detail, "breadcrumbItem" => "Manage Users" , "breadcrumbTitle"=> "Edit User", "breadcrumbLink" => "eventmanager.userlist", 'countries' => $countries, 'states' => $states]);
  }


  /** update user record **/
  public function updateUser(Request $request){

    $validatedData = $this->validate($request, [
        'fullname' => 'regex:/^[0-9a-zA-Z\s]+$/u',
        'email' => 'required|unique:users,email,' . $request->userid,
        "country" => 'required',
        "state" => 'required'
    ]);

    $user = User::find($request->userid);
    $user->name = $request->fullname;
    $user->email = $request->email;
    $user->coutry_id = $this->decodeId($request->country);
    $user->state_id = $this->decodeId($request->state);
    $user->updated_at = Carbon::now();
    $user->save();

    if($user){
      return redirect()->route('eventmanager.userlist')->with(['success'=>'User detail has been updated successfully.']);
    }else{
      return redirect()->route('eventmanager.userlist')->with(['error'=>'Error occured while updating user.']);
    }

  }


  /** Fetch users data of logged in event manager **/
  public function ajaxDataLoad(Request $request){
    $eventmanager = session('manager_id');

    $draw = $_GET['draw'];
    $row = $_GET['start'];
    $rowperpage = $_GET['length']; // Rows display per page
    $columnIndex = $_GET['order'][0]['column']; // Column index
    $columnName = $_GET['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $_GET['order'][0]['dir']; // asc or desc
    $searchValue = $_GET['search']['value']; // Search value
    
    $columns = [
        0 => 'u.id',
        1 => 'u.name',
        2 => 'u.email',
        3 => 'u.status',
        4 => 'u.created_at',
        5 => 'u.email'
    ];
    $columnName = $columns[$columnIndex];

    ## Search 
    // $searchQuery = " ";
    // if($searchValue != ''){
    //    $searchQuery = " and (name like '%".$searchValue."%' or email like '%".$searchValue."%' ) ";
    // }
    
    ## Total number of records
    $totalRecords = UserParents::getMyUsersCount($eventmanager);
    // $totalRecords = User::whereRaw(" (status = '1' or status = '0') and event_manager = '$eventmanager' ")->count();
    
    ## Total number of record with filtering
    $totalRecordwithFilter = UserParents::getMyUsersFilterCount ($eventmanager, $searchValue);
    // $totalRecordwithFilter = User::whereRaw(" (status = '1' or status = '0') and event_manager = '$eventmanager' ". $searchQuery)->count();
    
    ## Fetch records
    $userlist = UserParents::getMyUsersDetails ($eventmanager, $searchValue, $columnName, $columnSortOrder, $row, $rowperpage);
    // $userlist = User::whereRaw(" (status = '1' or status = '0') and event_manager = '$eventmanager' ". $searchQuery)->orderBy($columnName, $columnSortOrder)->skip($row)->take($rowperpage)->get();

    $checkbox = ""; $data = array(); $action = "";
    if(!empty($userlist)){
      $x = 0;
        foreach($userlist as $users){
        $encryptId = Hashids::encode($users->id);
        $encryptRelationId = Hashids::encode($users->relation_id);
        $name = $users->name;
        $action = "<a href='javascript:void(0);' onclick=\"delete_child('".$encryptRelationId."', '$name', '".$x."')\"><i class='fa fa-trash' aria-hidden='true'></i></a>";
        $checkbox = '';
        $status = $users->status =="1" ? "<span class='badge' style='background:green; color:#FFF; padding:5px;'><a class='active-inactive' href='javascript:void(0);' title='Click to make it inactive' >Active</a></span>" : "<span class='badge' style='background:#FF0000; color:#FFF; padding:5px;'><a class='active-inactive' href='javascript:void(0);' title='Click to make it active'>Inactive</a></span>";
        
        if($users->manager == $users->event_manager){
          $action = "<a href=\"edituser/".$encryptId."\"><i class='fa fa-pencil' aria-hidden='true'></i></a> &nbsp;&nbsp; <a href='javascript:void(0);' onclick=\"delete_row('".$encryptId."', '$name', '".$x."')\"><i class='fa fa-trash' aria-hidden='true'></i></a></i>";

          $checkbox = '<div class="animated-checkbox"><label style="margin-bottom:0px;"><input type="checkbox" name="ids[]" value="'.Hashids::encode($users->id).'" /><span class="label-text"></span></label></div>';

          $status = $users->status =="1" ? "<span class='badge' style='background:green; color:#FFF; padding:5px;'><a class='active-inactive' href='javascript:void(0);' title='Click to make it inactive' onclick=\"activeInactiveState('".$encryptId."', '0')\">Active</a></span>" : "<span class='badge' style='background:#FF0000; color:#FFF; padding:5px;'><a class='active-inactive' href='javascript:void(0);' onclick=\"activeInactiveState('".$encryptId."', '1')\" title='Click to make it active'>Inactive</a></span>";       
        }
        

           $data[] = array( 
              $checkbox,
              $name,
              $users->email,
              $status,
              date("d M, Y", strtotime($users->created_at)),
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

  public function getEmailIdsAjax (REQUEST $request){

    $result = User::MatchEmail($request->search);

    return json_encode($result);
  }

  public function getEmailIData (REQUEST $request){

    $userdata = User::where("email" , $request->email)->first();

    if($userdata){
      $userdata['coutry_id'] = Hashids::encode($userdata['coutry_id']);
      $userdata['state_id'] = Hashids::encode($userdata['state_id']);
    }else{
      $userdata = [];
    }
    return $userdata;
  }

}//class ends
