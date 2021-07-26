<?php

namespace App\Http\Controllers\Admin;


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
use Hash;
use Carbon\Carbon;
use App\Http\Controllers\Admin\CommonController;
use Illuminate\Support\Facades\URL;
use Vinkla\Hashids\Facades\Hashids;
use App\Http\Traits\CommonMethods;

class UsersController extends Controller{

  use CommonMethods;
  
  public function __construct() {
    $this->middleware('guest:admin');
  }

  /* get userlisting  */
  public function userListing(Request $request){
    $title = "User Management";
    return view('admin.users.users', ['title' => $title, "breadcrumbItem" => "Manage Users" , "breadcrumbTitle"=>"Users List"]);
  }

  public function addUser(){
    $title = "Add User";
    return view('admin.users.add_user', ['title' => $title, "breadcrumbItem" => "Manage Users" , "breadcrumbTitle"=> "Add User"]);
  }


  public function saveUser(Request $request){

    $validatedData = $this->validate($request, [
        'fullname' => 'required|regex:/^[a-zA-Z]+$/u',
        'email' => 'required|email',
        'password' => 'required|min:6',
        'gender' => 'required'
    ]);

    $user_details = array(
      "name" => $request->fullname,
      "email" => $request->email,
      "password" => Hash::make($request->password),
      "gender" => $request->gender,
      "email_verified_at" => Carbon::now(),
      "role_id" => 2
    );    
    $user = User::create($user_details); 
    if($user){
      return redirect()->route('admin.userlist')->with(['success'=>'User detail has been added successfully.']);
    }else{

    }

  }
  


  public function editUser($id){
    $title = "Edit User";
    $decryptUserId = Hashids::decode($id);
    $user_detail = User::find($decryptUserId[0]);
    $countries = Countries::all();
    $states = States::where( ["country_id" => $user_detail->coutry_id] )->get();
    return view('admin.users.edit_user', ['title' => $title, "user"=> $user_detail, "breadcrumbItem" => "Manage Users" , "breadcrumbTitle"=> "Edit User", "breadcrumbLink" => "admin.userlist", 'countries' => $countries, 'states' => $states]);
  }


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
      return redirect()->route('admin.userlist')->with(['success'=>'User detail has been updated successfully.']);
    }else{
      return redirect()->route('admin.userlist')->with(['error'=>'Error occured while updating user.']);
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
        0 => 'u.id',
        1 => 'u.name',
        2 => 'u.email',
        3 => 'em.name',
        4 => 'u.status',
        5 => 'u.created_at'
    ];
    $columnName = $columns[$columnIndex];

    ## Search 
    // $searchQuery = " ";
    // if($searchValue != ''){
    //    $searchQuery = " and (name like '%".$searchValue."%' or email like '%".$searchValue."%' ) ";
    // }
    
    ## Total number of records
    // $totalRecords = Users::whereRaw("u.status = 1")->count();
    // $totalRecords = User::whereRaw(" (status = '1' or status = '0')")->count();
    $totalRecords = User::getMyUsersCount();
    
    ## Total number of record with filtering
    $totalRecordwithFilter = User::getMyUsersFilterCount ( $searchValue);
    // $totalRecordwithFilter = User::whereRaw(" (status = '1' or status = '0') ". $searchQuery)->count();
    
    ## Fetch records
    $userlist = User::fetchUsersWithManager ($searchValue, $columnName, $columnSortOrder, $row, $rowperpage);
    // $userlist = User::whereRaw(" (status = '1' or status = '0')". $searchQuery)->orderBy($columnName, $columnSortOrder)->skip($row)->take($rowperpage)->get();
    // print_r($userlist); die;
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
        
        // if($users->manager == $users->event_manager){
          $action = "<a href=\"edituser/".$encryptId."\"><i class='fa fa-pencil' aria-hidden='true'></i></a> &nbsp;&nbsp; <a href='javascript:void(0);' onclick=\"delete_row('".$encryptId."', '$name', '".$x."')\"><i class='fa fa-trash' aria-hidden='true'></i></a></i>";

          $checkbox = '<div class="animated-checkbox"><label style="margin-bottom:0px;"><input type="checkbox" name="ids[]" value="'.Hashids::encode($users->id).'" /><span class="label-text"></span></label></div>';

          $status = $users->status =="1" ? "<span class='badge' style='background:green; color:#FFF; padding:5px;'><a class='active-inactive' href='javascript:void(0);' title='Click to make it inactive' onclick=\"activeInactiveState('".$encryptId."', '0')\">Active</a></span>" : "<span class='badge' style='background:#FF0000; color:#FFF; padding:5px;'><a class='active-inactive' href='javascript:void(0);' onclick=\"activeInactiveState('".$encryptId."', '1')\" title='Click to make it active'>Inactive</a></span>";
        // }
        

           $data[] = array( 
              $checkbox,
              $name,
              $users->email,
              $manager = $users->manager,
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
    


}
