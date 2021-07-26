<?php

namespace App\Http\Controllers\Admin;


use Auth;
use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\EventTeam;
use App\Models\Event;
use App\Models\States;
use App\Models\Game;
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
use Illuminate\Support\Facades\DB;

class EventsController extends Controller{

  public function __construct() {
    $this->middleware('guest:admin');
  }

  /* get teamlisting  */
  public function eventListing(Request $request){

    $title = "Event Management";
    return view('admin.events.events', ['title' => $title, "breadcrumbItem" => "Manage Events" , "breadcrumbTitle"=>"Manage Events", "breadcrumbLink" => "", "breadcrumbTitle2"=>""]);
  }

  public function eventDetails($id){

    $title = "Event Details";
    $decryptId = Hashids::decode($id);

    $event_detail = Event::find($decryptId[0]);
    $event_detail->introgame = Game::find($event_detail->intro_game);
    $event_detail->maingame = Game::find($event_detail->main_game);
    $managerTimezone = States::getTimezone($event_detail['event_manager'], 'manager')->timezone;
    $event_teams = EventTeam::where(["event_id"=>$decryptId[0]])->get();  
    $data = [];
    foreach($event_teams as $event) {
      $data[] = $event->team_id;
    }
    $teams = Team::where(["status"=>1])->whereIn('id', $data)->get();
    
    return view('admin.events.event_details', ['title' => $title, "event_detail"=> $event_detail, "breadcrumbItem" => "Manage Events" , "breadcrumbTitle"=> "Event Details", "teams"=> $teams, "breadcrumbLink" => "admin.eventlist", "breadcrumbTitle2"=>"Event Details", 'eventId' => $id, 'timezone' =>$managerTimezone]);
  }


  /** add event form **/
  /*public function addEvent(){
    $title = "Add Event";
    
    $teams = Team::where(["status"=>1, "event_manager"=>session('manager_id')])->get();
    return view('eventmanager.events.add_event', ['title' => $title, "breadcrumbItem" => "Manage Events" , "breadcrumbTitle"=> "Add Event", "teams" => $teams, "breadcrumbLink" => "eventmanager.eventlist"]);
  }*/


  /** save new event record **/
  /*public function saveEvent(Request $request){
    
    //Generate a timestamp using mt_rand.
    $timestamp = mt_rand(3, time()); 
    //Format that timestamp into a readable date string.
    $randomDate = date("d M Y H:i:s", $timestamp); 
    //Print it out.
    //echo strtotime($randomDate);   // Random meeting invite number created


    $validatedData = $this->validate($request, [
        'eventname' => 'required|regex:/^[a-zA-Z\s]+$/u',
        "teams.*"  => "required",
        'startdate' => 'required',
        'starttime' => 'required',
        'endtime' => 'required'
    ]);

    $eventmanager = session('manager_id');
    $data = array(
      "event_manager" => $eventmanager,
      "name" => $request->eventname,
      "startdate" => $request->startdate,
      "starttime" => strtotime("Y-m-d ".$request->starttime),
      "endtime" => strtotime("Y-m-d ".$request->endtime),
      "description" => $request->description
    );    

    $event = Event::create($data); 
    if($event){
      $selectedteam = explode(",", $request->team);
      foreach ($selectedusers as $usersInteam) {
        $users = User::where(["email"=>$usersInteam, "event_manager"=>$eventmanager])->first();

        UserTeam::create(["user_id"=>$users->id, "team_id"=>$team->id]);
      }
      return redirect()->route('eventmanager.teamlist')->with(['success'=>'Team has been added successfully.']);
    }else{
      return redirect()->route('eventmanager.teamlist')->with(['error'=>'Error occured while adding team.']);
    }

  }*/
  

  /** edit form team **/
  /*public function editTeam($id){
    $title = "Edit Team";
    $decryptId = Hashids::decode($id);

    $team_detail = Team::find($decryptId[0]);
    $assigned_teamusers = Team::find($decryptId[0])->users()->get();
    $existingteamusers = "";
    foreach($assigned_teamusers as $user) {
      $existingteamusers .= $user->email.",";
    }
    $existingteamusers = substr($existingteamusers, 0, -1);
    foreach($assigned_teamusers as $user) {
      $data[] = $user->id;
    }
    $unassigned_teamusers = User::where(["status"=>1])->whereNotIn('id', $data)->get();
    
    return view('eventmanager.teams.edit_team', ['title' => $title, "team"=> $team_detail, "breadcrumbItem" => "Manage Teams" , "breadcrumbTitle"=> "Edit Team", "unassigned_teamusers"=> $unassigned_teamusers, "assigned_teamusers"=> $assigned_teamusers, "existingteamusers"=>$existingteamusers]);
  }
*/

  /** update team record **/
 /* public function updateTeam(Request $request){

    $validatedData = $this->validate($request, [
        'teamname' => 'required|regex:/^[a-zA-Z\s]+$/u'
    ]);
    $eventmanager = session('manager_id');
    $team = Team::where('id', $request->teamid)->update(['name' => $request->teamname]);
    if($team){
      UserTeam::where(["team_id"=>$request->teamid])->delete();
      $selectedusers = explode(",", $request->selected_users);
      foreach ($selectedusers as $usersInteam) {
        $users = User::where(["email"=>$usersInteam, "event_manager"=>$eventmanager])->first();
        UserTeam::create(["user_id"=>$users->id, "team_id"=>$request->teamid]);
      }
      
      return redirect()->route('eventmanager.teamlist')->with(['success'=>'Team detail has been updated successfully.']);
    }else{
      return redirect()->route('eventmanager.teamlist')->with(['error'=>'Error occured while updating team.']);
    }

  }*/


  /** Fetch users data of logged in event manager **/
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
        2 => 'event_manager',
        3 => 'start_date',
        4 => 'usercount',
        5 => 'status'
    ];
    $columnName = $columns[$columnIndex];

    ## Search 
    $searchQuery = " ";
    if($searchValue != ''){
       $searchQuery = " and (em.name like '%".$searchValue."%' or e.name like '%".$searchValue."%' or e.description like '%".$searchValue."%') ";
    }
    
    $totalRecords = DB::table('events as e')
            ->select(DB::raw('e.id,em.name as event_manager,e.name,e.start_date,e.status'))
            ->join('event_managers as em', 'em.id', '=', 'e.event_manager')
            ->whereRaw(" e.status = '1' or e.status = '0' or e.status = '2'")
            ->count();

    $totalRecordwithFilter = DB::table('events as e')
            ->select(DB::raw('e.id,em.name as event_manager,e.name,e.start_date,e.status'))
            ->join('event_managers as em', 'em.id', '=', 'e.event_manager')
            ->whereRaw(" (e.status = '1' or e.status = '0' or e.status = '2') ". $searchQuery)
            ->count();

    $eventlist = DB::table('events as e')
            ->select(DB::raw('e.id,em.name as event_manager,e.name,e.start_date,e.status,COUNT(ut.user_id) as usercount'))
            ->join('event_managers as em', 'em.id', '=', 'e.event_manager', 'left')
            ->join('event_teams as et', 'et.event_id', '=', 'e.id', 'left')
            ->join('user_team as ut', 'ut.team_id', '=', 'et.team_id', 'left')
            ->whereRaw(" (e.status = '1' or e.status = '0' or e.status = '2') ". $searchQuery)
            ->groupBy('e.id')
            ->orderBy($columnName, $columnSortOrder)->skip($row)->take($rowperpage)->get();



    ## Total number of records
    //$totalRecords = Event::whereRaw(" (status = '1' or status = '0') ")->count();
    
    ## Total number of record with filtering
    //$totalRecordwithFilter = Event::whereRaw(" (status = '1' or status = '0') ". $searchQuery)->count();
    
    ## Fetch records
    //$eventlist = Event::whereRaw(" (status = '1' or status = '0') ". $searchQuery)->orderBy($columnName, $columnSortOrder)->skip($row)->take($rowperpage)->get();

    $checkbox = 1; $data = array(); $action = "";
    if(!empty($eventlist)){
        foreach($eventlist as $events){
        $encryptId = Hashids::encode($events->id);  
        
        // $checkbox = '<div class="animated-checkbox"><label style="margin-bottom:0px;"><input type="checkbox" name="ids[]" value="'.Hashids::encode($events->id).'" /><span class="label-text"></span></label></div>';
        //$action = '<a href="#"><i class="fa fa-pencil" aria-hidden="true"></i></a> &nbsp;&nbsp; <a href="javascript:void(0);" onclick=delete_row("'.$encryptId.'")><i class="fa fa-trash" aria-hidden="true"></i></a></i>';
        $action = '<a href="javascript:void(0);"><i class="fa fa-pencil" aria-hidden="true"></i></a> &nbsp;&nbsp; <a href="javascript:void(0);"><i class="fa fa-trash" aria-hidden="true"></i></a></i>';
           $data[] = array( 
              $checkbox,
              "<a href='eventdetails/".Hashids::encode($events->id)."'>".$events->name."</a>",
              $events->event_manager,
              date("d M, Y", strtotime($events->start_date)),
              $events->usercount,
             /* $events->status == '2' ? "<span class='badge' style='background:blue; color:#FFF; padding:5px;'>Completed</span>" : 
              ($events->status =="1" ? "<span class='badge' style='background:green; color:#FFF; padding:5px;'>Active</span>" : "<span class='badge' style='background:#FF0000; color:#FFF; padding:5px;'>Inactive</span>"),*/
              $events->status == "2" ? "<span class='badge' style='background:blue; color:#FFF; padding:5px;'>Completed</span>" : 
              ($events->status =="1" ? "<span class='badge' style='background:green; color:#FFF; padding:5px;'><a class='active-inactive' href='javascript:void(0);' title='Click to make it inactive' onclick=\"activeInactiveState('".$encryptId."', '0')\">Active</a></span>" : "<span class='badge' style='background:#FF0000; color:#FFF; padding:5px;'><a class='active-inactive' href='javascript:void(0);' onclick=\"activeInactiveState('".$encryptId."', '1')\" title='Click to make it active'>Inactive</a></span>"),
              // $action
           );
           $checkbox++;
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
    
  public function ajaxEventMembers ($id, Request $request){

    $eventId = Hashids::decode($id)[0];
    
    $draw = $_GET['draw'];
    $row = $_GET['start'];
    $rowperpage = $_GET['length']; // Rows display per page
    $columnIndex = $_GET['order'][0]['column']; // Column index
    $columnName = $_GET['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $_GET['order'][0]['dir']; // asc or desc
    $searchValue = $_GET['search']['value']; // Search value
    
    $columns = [
        // 0 => 'id',
        0 => 'u.email',
        1 => 't.name',
        2 => 'u.enc_id',
    ];

    $columnName = $columns[$columnIndex];

    ## Search 
    $searchQuery = " ";
    if($searchValue != ''){
       $searchQuery = " and (u.email like '%".$searchValue."%' or t.name like '%".$searchValue."%' or u.enc_id like '%".$searchValue."%' or e.meeting_token like '%".$searchValue."%') ";
    }
    
    $totalRecords = DB::table('events as e')
            ->select(DB::raw('u.id'))
            ->join('event_teams as et', 'et.event_id', '=', 'e.id', 'left')
            ->join('user_team as ut', 'ut.team_id', '=', 'et.team_id', 'left')
            ->join('users as u', 'u.id', '=', 'ut.user_id', 'left')
            ->whereRaw(" (e.id = $eventId) ")
            ->count();

    $totalRecordwithFilter = DB::table('events as e')
            ->select(DB::raw('u.id'))
            ->join('event_teams as et', 'et.event_id', '=', 'e.id', 'left')
            ->join('user_team as ut', 'ut.team_id', '=', 'et.team_id', 'left')
            ->join('users as u', 'u.id', '=', 'ut.user_id', 'left')
            ->join('teams as t', 't.id', '=', 'ut.team_id', 'left')
            ->whereRaw(" (e.id = $eventId) ". $searchQuery)
            ->count();

    $eventlist = DB::table('events as e')
            ->select(DB::raw('u.name as username,u.email,t.name as teamname,concat(u.enc_id,"-",e.meeting_token) as link'))
            ->join('event_teams as et', 'et.event_id', '=', 'e.id', 'left')
            ->join('user_team as ut', 'ut.team_id', '=', 'et.team_id', 'left')
            ->join('users as u', 'u.id', '=', 'ut.user_id', 'left')
            ->join('teams as t', 't.id', '=', 'ut.team_id', 'left')
            ->whereRaw(" (e.id = $eventId) ". $searchQuery)
            ->orderBy($columnName, $columnSortOrder)->skip($row)->take($rowperpage)->get();

    $checkbox = ""; $data = array(); $action = "";
    if(!empty($eventlist)){
        foreach($eventlist as $events){
           $data[] = array( 
              // $checkbox,
              $events->email,
              $events->teamname,
              url('/homepage/'.$events->link)
           );
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
