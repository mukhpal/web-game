<?php

namespace App\Http\Controllers\EventManager;


use Auth;
use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use App\Models\UserParents;
use App\Models\UserTeam;
use App\Models\GameSettings;
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

class TeamsController extends Controller{

  public function __construct() {
    $this->middleware('guest:event_manager');
  }

  /* get teamlisting  */
  public function teamListing(Request $request){

    $title = "Team Management";
    return view('eventmanager.teams.teams', ['title' => $title, "breadcrumbItem" => "Manage Teams" , "breadcrumbTitle"=>"", "breadcrumbLink" => ""]);
  }

  /** add team form **/
  public function addTeam(){
    $title = "Create Team";
    
    $assigned_teamusers = UserTeam::getMyteamUsers(session('manager_id'));   // because as per the discussion with Shiv Sir one user add in one team.
    $data = [];
    foreach($assigned_teamusers as $user) {
      $data[] = $user->user_id;
    }

    $teamSize = GameSettings::find('1');

    $unassigned_teamusers = UserParents::unassignedTeamusers($data);

    return view('eventmanager.teams.add_team', ['title' => $title, "breadcrumbItem" => "Manage Teams" , "breadcrumbTitle"=> "Create Team", "unassigned_teamusers" => $unassigned_teamusers, "breadcrumbLink" => "eventmanager.teamlist", "teamSize"=>$teamSize->team_size, "minteamSize"=>$teamSize->min_team_size]);
  }


  /** save new team record **/
  public function saveTeam(Request $request){

    $teamSize = GameSettings::find('1');

    $validatedData = $this->validate($request, [
        'teamname' => 'required|regex:/^[0-9a-zA-Z\s]+$/u'
    ]);

    $selectedusers = explode(",", $request->selected_users);
    if(count($selectedusers) > $teamSize->team_size){
      return redirect()->route('eventmanager.teamlist')->with(['error'=>'You cannot add more than '.$teamSize->team_size.' user(s) in a team.']);
      exit;
    }

    if(count($selectedusers) < $teamSize->min_team_size){
      return redirect()->route('eventmanager.teamlist')->with(['error'=>'You cannot add less than '.$teamSize->min_team_size.' user(s) in a team.']);
      exit;
    }

    $eventmanager = session('manager_id');

    $checkTeamName = Team::where(['name'=>$request->teamname, 'event_manager'=>$eventmanager])->count();

    if($checkTeamName){
      return redirect()->route('eventmanager.addteam')->with(['error'=> $request->teamname.'  is already exists in you team list.']);
      exit;
    }

    $data = array(
      "event_manager" => $eventmanager,
      "name" => $request->teamname,
      "status" => 1
    );
    $team = Team::create($data); 
    if($team){
      $selectedusers = explode(",", $request->selected_users);
      foreach ($selectedusers as $usersInteam) {
        $users = UserParents::userExistInAnyTeam($usersInteam);
        // $users = User::where(["email"=>$usersInteam, "event_manager"=>$eventmanager])->first();

        UserTeam::create(["user_id"=>$users->id, "team_id"=>$team->id]);
      }
      return redirect()->route('eventmanager.teamlist')->with(['success'=>'Team has been added successfully.']);
    }else{
      return redirect()->route('eventmanager.teamlist')->with(['error'=>'Error occured while adding team.']);
    }

  }
  

  /** edit form team **/
  public function editTeam($id){

    $title = "Edit Team";
    $decryptId = Hashids::decode($id);

    $team_detail = Team::find($decryptId[0]);
    $assigned_teamusers = Team::find($decryptId[0])->users()->get();

    $existingteamusers = "";
    foreach($assigned_teamusers as $user) {
      $existingteamusers .= $user->email.",";
    }
    $existingteamusers = substr($existingteamusers, 0, -1);
    // foreach($assigned_teamusers as $user) {
    //   $data[] = $user->id;
    // }
    $assigned_teamusersagainstEvent = UserTeam::getMyteamUsers(session('manager_id'));   // because as per the discussion with Shiv Sir one user add in one team.
    $data = [];
    foreach($assigned_teamusersagainstEvent as $user) {
      $data[] = $user->user_id;
    }

    $unassigned_teamusers = UserParents::unassignedTeamusers($data);
    
    $teamSize = GameSettings::find('1');
    return view('eventmanager.teams.edit_team', ['title' => $title, "team"=> $team_detail, "breadcrumbItem" => "Manage Teams" , "breadcrumbTitle"=> "Edit Team", "unassigned_teamusers"=> $unassigned_teamusers, "assigned_teamusers"=> $assigned_teamusers, "existingteamusers"=>$existingteamusers, "breadcrumbLink" => "eventmanager.teamlist", "teamSize"=>$teamSize->team_size, "minteamSize"=>$teamSize->min_team_size]);
  }


  /** update team record **/
  public function updateTeam(Request $request){

    $validatedData = $this->validate($request, [
        'teamname' => 'required|regex:/^[0-9a-zA-Z\s]+$/u'
    ]);

    $teamSize = GameSettings::find('1');

    $selectedusers = explode(",", $request->selected_users);
    if(count($selectedusers) > $teamSize->team_size){
      return redirect()->route('eventmanager.teamlist')->with(['error'=>'You cannot add more than '.$teamSize->team_size.' user(s) in a team.']);
      exit;
    }
    if(count($selectedusers) < $teamSize->min_team_size){
      return redirect()->route('eventmanager.teamlist')->with(['error'=>'You cannot add less than '.$teamSize->min_team_size.' user(s) in a team.']);
      exit;
    }
    
    $eventmanager = session('manager_id');

    $checkTeamName = Team::where(['name'=>$request->teamname, 'event_manager'=>$eventmanager])
                          ->where('id', '!=' , $request->teamid)
                          ->count();

    if($checkTeamName){
      return redirect()->route('eventmanager.teamlist')->with(['error'=> $request->teamname.'  is already exists in you team list.']);
      exit;
    }

    $team = Team::where('id', $request->teamid)->update(['name' => $request->teamname]);
    if($team){
      UserTeam::where(["team_id"=>$request->teamid])->delete();
      $selectedusers = explode(",", $request->selected_users);
      foreach ($selectedusers as $usersInteam) {
        $users = UserParents::userExistInAnyTeam($usersInteam);
        // where(["email"=>$usersInteam, "event_manager"=>$eventmanager])->first();
        if($users){
          UserTeam::create(["user_id"=>$users->id, "team_id"=>$request->teamid]);
        }
      }
      
      return redirect()->route('eventmanager.teamlist')->with(['success'=>'Team detail has been updated successfully.']);
    }else{
      return redirect()->route('eventmanager.teamlist')->with(['error'=>'Error occured while updating team.']);
    }

  }


  /***** check if posted users already exist in any team ***/
  public function userExistInAnyTeam(Request $request){
    $existUserEmail = [];
    foreach ($request->users as $value) {
      $users = UserParents::userExistInAnyTeam($value);
      $existUser = UserTeam::checkUserIdExistsinMyTeams($users->id, session('manager_id'));
      if(!empty($existUser)){
        $existUserEmail[] = $value;
      }
    }
    echo json_encode($existUserEmail);
    exit;

  }



  /***** get team members name of posted team id ****/
  public function getTeamMembers(Request $request){
    $decryptId = Hashids::decode($request->team_id);
    $teamMembers = UserTeam::where("team_id", "=" ,$decryptId[0])->get();
    $html = "";
    if($teamMembers){
      $x=1;
      foreach ($teamMembers as $key => $value) {
        $users = User::find($value->user_id);
        $html .= "<tr><td>".$x."</td><td>".$users->name."</td></tr>";
        $x++;
      }
    }else{
        $html .="<tr><td colspan='2'>No users found.</td></tr>";
    }
    echo $html;  
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
        0 => 'id',
        1 => 'name',
        2 => 'status',
        3 => 'created_at',
        4 => 'status'
    ];
    $columnName = $columns[$columnIndex];

    ## Search 
    $searchQuery = " ";
    if($searchValue != ''){
       $searchQuery = " and (name like '%".$searchValue."%') ";
    }
    
    ## Total number of records
    $totalRecords = Team::whereRaw(" (status = '1' or status = '0') and event_manager = '$eventmanager' ")->count();
    
    ## Total number of record with filtering
    $totalRecordwithFilter = Team::whereRaw(" (status = '1' or status = '0') and event_manager = '$eventmanager' ". $searchQuery)->count();
    
    ## Fetch records
    $teamlist = Team::whereRaw(" (status = '1' or status = '0') and event_manager = '$eventmanager' ". $searchQuery)->orderBy($columnName, $columnSortOrder)->skip($row)->take($rowperpage)->get();

    $checkbox = ""; $data = array(); $action = "";
    if(!empty($teamlist)){
        $x=0;
        foreach($teamlist as $teams){
        $encryptId = Hashids::encode($teams["id"]);  
        
        $checkbox = '<div class="animated-checkbox"><label style="margin-bottom:0px;"><input type="checkbox" name="ids[]" value="'.Hashids::encode($teams['id']).'" /><span class="label-text"></span></label></div>';
        $action = "<a href=\"editteam/".$encryptId."\"><i class='fa fa-pencil' aria-hidden='true'></i></a> &nbsp;&nbsp; <a href='javascript:void(0);' onclick=\"delete_row('".$encryptId."', '$teams[name]', '".$x."')\"><i class='fa fa-trash' aria-hidden='true'></i></a></i>";

           $data[] = array( 
              $checkbox,
              "<a href='javascript:void(0);' onclick=getTeamMembers('".$encryptId."')>".$teams['name']."</a>",
              $teams['status'] =="1" ? "<span class='badge' style='background:green; color:#FFF; padding:5px;'><a class='active-inactive' href='javascript:void(0);' title='Click to make it inactive' onclick=\"activeInactiveState('".$encryptId."', '0')\">Active</a></span>" : "<span class='badge' style='background:#FF0000; color:#FFF; padding:5px;'><a class='active-inactive' href='javascript:void(0);' onclick=\"activeInactiveState('".$encryptId."', '1')\" title='Click to make it active'>Inactive</a></span>",
              date("d M, Y", strtotime($teams['created_at'])),
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
