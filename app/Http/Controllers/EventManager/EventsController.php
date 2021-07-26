<?php

namespace App\Http\Controllers\EventManager;


use Auth;
use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use App\Models\Event;
use App\Models\EventTeam;
use App\Models\Emails;
use App\Models\EventLinkInvitedUsers;
use App\Models\EventManagers;
use App\Models\States;
use App\Models\Game;
use App\Models\Others;
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
use DateTimeZone;
use DateTime;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;

class EventsController extends Controller{

  use CommonMethods;

  public function __construct() {
    $this->middleware('guest:event_manager');
  }

  /* get all event listing  */
  public function eventListing(Request $request){
    $title = "Event Management";
    return view('eventmanager.events.events', ['title' => $title, "breadcrumbItem" => "Manage Events" , "breadcrumbTitle"=>"", "breadcrumbLink" => ""]);
  }

  /** add event form **/
  public function addEvent(){

    $title = "Add Event";
    $gameSettings = $this->getGameSettings();
    $introGame = Game::where(['status' => 1, 'game_type' => 0])->get();
    $mainGames = Game::where(['status' => 1, 'game_type' => 1])->get();
    $managerTimezone = States::getTimezone(session('manager_id'), 'manager')->timezone;
    $teams = Team::where(["status"=>1, "event_manager"=>session('manager_id')])->get();
    return view('eventmanager.events.add_event', ['title' => $title, "breadcrumbItem" => "Manage Events" , "breadcrumbTitle"=> "Add Event", "teams" => $teams, "breadcrumbLink" => "eventmanager.eventlist", "timezone" => $managerTimezone, "minTeamsForEvent" => $gameSettings->min_teams_for_event, 'introGame' => $introGame, 'mainGame'=> $mainGames]);
  }


  /** save new event record **/
  public function saveEvent(Request $request){
    //$sql = Event::find('1')->eventteam()->with('teamusers')->with('usersinteam')->get();
    /** Check that posted event total time is not greater than the time set by admin in game settings */
    $gameSettings = $this->getGameSettings();
    if(count($request->teams) < $gameSettings->min_teams_for_event){
      return redirect()->back()->with("error","Minimun $gameSettings->min_teams_for_event teams needed to create an event.")->withInput();
      exit;
    }
    $validatedData = $this->validate($request, [
        'eventname' => 'required|regex:/^[0-9a-zA-Z\s]+$/u',
        "teams.*"  => "required",
        'startdate' => 'required',
        'starttime' => 'required',
        'intro_game' => 'required',
        'main_game' => 'required',
        // 'endtime' => 'required'
    ]);
    
    // if($startTime == $endTime){
    //   return redirect()->back()->with("error","Start time and end cannot be same.")->withInput();
    // }
    $startTime = strtotime($request->startdate." ".$request->starttime.":00");

    $hour = 00;

    $today              = strtotime($hour . ':00:00');
    $yesterday          = strtotime('-1 day', $today);

    if($yesterday > $startTime){
        return redirect()->back()->with("error","Start date cannot be lesser than yesterday.")->withInput();
      exit;
    }

    $endTime = strtotime("+".$gameSettings->game_time." minutes", $startTime);

    // $getTimeInMinutes = $this->getTimeDifference($endTime, $startTime);
    
    $mailStartTime = date('Y-m-d H:i:s',$startTime);
    $mailEndTime = date('Y-m-d H:i:s',$endTime);

    $eventmanager = session('manager_id');
    $checkNameAlreadyExists = Event::where(['name' => $request->eventname, "event_manager" => $eventmanager, "start_date" => $request->startdate])->count();
    if($checkNameAlreadyExists){
      return redirect()->back()->with("error","Event exist in database with the same name for the same date.")->withInput();
    }
    $data = array(
      "event_manager" => $eventmanager,
      "name" => $request->eventname,
      "intro_game" => Hashids::decode($request->intro_game)[0],
      "main_game" => Hashids::decode($request->main_game)[0],
      "start_date" => $request->startdate,
      "start_time" => $startTime,
      "end_time" => $endTime,
      "description" => $request->description,
      "status" => 1
    );

    $eventmanagerdetails = EventManagers::find($eventmanager);

    /** Check if the event is already saved in table with same datetime and posted team exist **/
    $alreadyExist = Event::eventAlreadyExistSameTime($request,$startTime,$endTime);
    if($alreadyExist){
      return redirect()->back()->with("error","Event or teams added in this event is already exist in database with same datetime.")->withInput();
    }
    $event = Event::create($data);

    if($event){
      $eventTeams = [];$z=0;
      foreach ($request->teams as $team) {
        $eventTeams[$z] = array("event_id"=>$event->id, "team_id"=>$team, "status"=>1,"created_at"=>Carbon::now(), "updated_at"=>Carbon::now());
        $z++;
      }
      EventTeam::insert($eventTeams);
      
      $introGame = Game::find($event->intro_game);
      $mainGame = Game::find($event->main_game);

      $introgametutorial = $maingametutorial = " ";

      if($introGame->link){
        $introgametutorial = '<a href="'.$introGame->link.'" alt="" target="_blank" style="color:#300a79;font-weight: 600; "/>link.</a>';
      }

      if($mainGame->link){
        $maingametutorial = '<a href="'.$mainGame->link.'" alt="" target="_blank" style="color:#300a79;font-weight: 600; "/>link.</a>';
      }

      $meetingToken = $this->uniqueId($event->id, 'et');  // Unique encrypted meeting token of event
      $update = Event::find($event->id);
      $update->meeting_token = $meetingToken;
      $update->save();

      /***
        Event meeting link in email send to team users is pending for now
      ***/
      $usersInEvent = Event::usersInEvent($event->id);
      $meeting_link = Emails::where(['email_slug' => 'meeting_link'])->first();
      $email_body = ""; $inviteLinkUsers = []; $y=0;

      foreach ($usersInEvent as $user) { 

        $userteam = User::find( $user->user_id )->userteam()->first();
        // $team = ( $userteam )?Team::find( $userteam->team_id ):false;
        $team = Team::find( $user->team_id );
        //get email ids for all members within the team
        $emailids = Team::getTeamEmailIds($user->team_id)->emailids;
        $emailids = str_replace(',',"<br>",$emailids);

        $inviteLinkUsers[$y] = array('user_id'=>$user->user_id, 'event_id'=>$event->id, "created_at"=>Carbon::now(), "updated_at"=>Carbon::now() );

        //user timezone
        $userTimeZone = $this->getEventUserTimeZone($user->user_id);
        $tzid = ( $userTimeZone )?";TZID=" . $userTimeZone:'';

        $convertedStartTime = $this->getUserTimeZone($user->user_id, $mailStartTime, $eventmanager);
        $convertedEndTime = $this->getUserTimeZone($user->user_id, $mailEndTime, $eventmanager);
        $todayTime = $this->getUserTimeZone($user->user_id, date( 'Y-m-d H:i:s' ), $eventmanager);

        $callouts_db = Others::where( ["parent_key" => 'callouts'] )->get();
        $callouts_heading = $callouts = "";

        foreach ($callouts_db as $record) {
            if($record->key == 'callouts_heading' ){
                $callouts_heading = $record->content;
            }

            if($record->key == 'callouts' ){
                $callouts = $record->content;
            }
        }

        $emailTemplateDecode = html_entity_decode($meeting_link['email_template']);
        $email_body = str_replace("##name##", $user->name, $emailTemplateDecode);
        $email_body = str_replace("##baseurl##", url('/'), $email_body);
        
        $email_body = str_replace("##logopath##", url('/').'/assets/front/images/email/logo.png', $email_body);
        $email_body = str_replace("##icebreakerimgpath##", url('/').'/assets/front/images/email/'.$introGame->image_lnk, $email_body);
        $email_body = str_replace("##mmgameimgpath##", url('/').'/assets/front/images/email/'.$mainGame->image_lnk, $email_body);
        
        $email_body = str_replace("##teamemails##", $emailids, $email_body);

        $email_body = str_replace("##userkey##", $user->enc_id, $email_body);
        $email_body = str_replace("##eventkey##", $meetingToken, $email_body);
        $email_body = str_replace("##starttime##", $convertedStartTime, $email_body);
        $email_body = str_replace("##endtime##", $convertedEndTime, $email_body);
        $email_body = str_replace("##timezone##", $userTimeZone, $email_body);
        $email_body = str_replace("##eventname##", $request->eventname, $email_body);
        
        $email_body = str_replace("##introgametitle##", $introGame->name, $email_body);
        $email_body = str_replace("##introgamedesc##", $introGame->description, $email_body);
        $email_body = str_replace("##introgametutorial##", $introgametutorial, $email_body);
        $email_body = str_replace("##maingametitle##", $mainGame->name, $email_body);
        $email_body = str_replace("##maingamedesc##", $mainGame->description, $email_body);
        $email_body = str_replace("##maingametutorial##", $maingametutorial, $email_body);

        $email_body = str_replace("##introgametime##", $introGame->game_times, $email_body);
        $email_body = str_replace("##maingametime##", $mainGame->game_times, $email_body);

        $email_body = str_replace("##callouts_heading##", $callouts_heading, $email_body);
        $email_body = str_replace("##callouts##", $callouts, $email_body);

        $email_body = str_replace("##description##", $request->description? nl2br( Str::substr( $request->description, 0, 250 ) . ( strlen( $request->description ) > 250?'...':'' ) ):'NA', $email_body);
        $email_body = str_replace("##managername##", $eventmanagerdetails->name, $email_body);

        $email_body = str_replace("##teamname##", ( $team )?$team->name:'', $email_body);

        $emailParams = array("to"=>$user->email, "subject"=>$meeting_link['subject'], "content"=>$email_body,

        );
        //Method to send email
        $this->sendEmail($emailParams);
        $y++;
      }

      // Logs of users who recieved the invite link, so that we didn't send the invite link those users again on update events.
      EventLinkInvitedUsers::insert($inviteLinkUsers);

      return redirect()->route('eventmanager.eventlist')->with(['success'=>'Event created successfully.']);
    }else{
      return redirect()->route('eventmanager.eventlist')->with(['error'=>'Error occured while adding event.']);
    }

  }
  

  /** edit form team **/
  public function editEvent($id){
    $title = "Edit Event";
    $decryptId = Hashids::decode($id);
    $gameSettings = $this->getGameSettings();
    $teams = Team::where(["status"=>1, "event_manager"=>session('manager_id')])->get();
    $event_detail = Event::find($decryptId[0]);
    // echo "<pre>";
    // print_r($event_detail);
    $assigned_teams = Event::find($decryptId[0])->eventteam()->get();
    $assignTeamArr = [];
    foreach ($assigned_teams as $key => $value) {
      $assignTeamArr[] = $value->team_id;
    }
    
    //print_r($assignTeamArr);exit;
    $managerTimezone = States::getTimezone(session('manager_id'), 'manager')->timezone;

    return view('eventmanager.events.edit_event', ['title' => $title, "event"=> $event_detail, "breadcrumbItem" => "Manage Events" , "breadcrumbTitle"=> "Edit Event", "assignTeamArr"=> $assignTeamArr, "breadcrumbLink" => "eventmanager.eventlist", "teams"=> $teams, "timezone" => $managerTimezone, "minTeamsForEvent" => $gameSettings->min_teams_for_event]);
  }


  /** update event record **/
  public function updateEvent(Request $request){

    $validatedData = $this->validate($request, [
        'eventname' => 'required|regex:/^[0-9a-zA-Z\s]+$/u',
        "teams.*"  => "required",
        'startdate' => 'required',
        'starttime' => 'required'
        // 'endtime' => 'required'
    ]);
    
    /** Check that posted event total time is not greater than the time set by admin in game settings */
    $gameSettings = $this->getGameSettings();

    if(count($request->teams) < $gameSettings->min_teams_for_event){
      return redirect()->back()->with("error","Minimun $gameSettings->min_teams_for_event teams needed to create an event.")->withInput();
      exit;
    }

    $startTime = strtotime($request->startdate." ".$request->starttime.":00");
    $endTime = strtotime("+".$gameSettings->game_time." minutes", $startTime);

    $hour = 00;

    $today              = strtotime($hour . ':00:00');
    $yesterday          = strtotime('-1 day', $today);

    if($yesterday > $startTime){
        return redirect()->back()->with("error","Start date cannot be lesser than yesterday.")->withInput();
      exit;
    }


    $mailStartTime = date('Y-m-d H:i:s',$startTime);
    $mailEndTime = date('Y-m-d H:i:s',$endTime);

    /** Check if the event is already saved in table excluding posted event id with same datetime and posted team exist **/
    $alreadyExist = Event::eventAlreadyExistSameTimeUpdate($request,$startTime,$endTime);

    if($alreadyExist){
      return redirect()->back()->with("error","Event or teams added in this event is already exist in database with same datetime.")->withInput();
    }
    $eventmanager = session('manager_id');
    $eventmanagerdetails = EventManagers::find($eventmanager);

    $checkNameAlreadyExists = Event::where(['name' => $request->eventname, "event_manager" => $eventmanager])
                              ->where('id', '!=' , $request->eventid)
                              ->count();
    if($checkNameAlreadyExists){
      return redirect()->back()->with("error","Event exist in database with the same name.")->withInput();
    }
    $event = Event::find($request->eventid);
    $event->name = $request->eventname;
    $event->start_date = $request->startdate;
    $event->start_time = $startTime;
    $event->end_time = $endTime;
    $event->description = $request->description;
    $event->save();

    if($event){

      // Need to delete exsting teams for this event first
      $eventTeams = EventTeam::where("event_id", $event->id)->delete();
      
      // Insert again new teams for this event
      $eventTeams = [];$z=0;
      foreach ($request->teams as $team) {
        $eventTeams[$z] = array("event_id"=>$event->id, "team_id"=>$team, "status"=>1,"created_at"=>Carbon::now(), "updated_at"=>Carbon::now());
        $z++;
      }
      EventTeam::insert($eventTeams);

      /***
        Event meeting link in email send to team users
      ***/
      $usersInEvent = Event::usersInEvent($event->id);
      $meeting_link = Emails::where(['email_slug' => 'meeting_link'])->first();
      $email_body = "";$inviteLinkUsers = [];$y=0;
      foreach ($usersInEvent as $user) {
        
        $userteam = User::find( $user->user_id )->userteam()->first();
        // $team = ( $userteam )?Team::find( $userteam->team_id ):false;
        $team = Team::find( $user->team_id );
        //get email ids for all members within the team
        $emailids = Team::getTeamEmailIds($user->team_id)->emailids;
        $emailids = str_replace(',',"<br>",$emailids);
        
        $userExist = EventLinkInvitedUsers::where("user_id","=",$user->user_id)->count();
        if($userExist==0){

          $inviteLinkUsers[$y] = array('user_id'=>$user->user_id, 'event_id'=>$event->id, "created_at"=>Carbon::now(), "updated_at"=>Carbon::now() );
          $y++;
        }
          //user timezone
          $userTimeZone = $this->getEventUserTimeZone($user->user_id);
          $tzid = ( $userTimeZone )?";TZID=" . $userTimeZone:'';

          $convertedStartTime = $this->getUserTimeZone($user->user_id, $mailStartTime, $eventmanager);
          $convertedEndTime = $this->getUserTimeZone($user->user_id, $mailEndTime, $eventmanager);
          $todayTime = $this->getUserTimeZone($user->user_id, date( 'Y-m-d H:i:s' ), $eventmanager);

          //outlook calendar link code start here..
          $filename = "storage/invite.ics";
          file_put_contents($filename, '');
          $meeting_duration = (1800 * 2); // 2 hours
          $meetingstamp = strtotime( $convertedStartTime);
          $meetingendstamp = strtotime( $convertedEndTime);
          $dtstart = date('Ymd\THis', $meetingstamp);
          $dtend =  date('Ymd\THis', $meetingendstamp);
          $todaystamp = date('Ymd\THis', strtotime( $todayTime) );
          $uid = date('Ymd').'T'.date('His').'-'.rand().'@yourdomain.com';
          $description = strip_tags($request->description);
          $location = "";
          $titulo_invite = $request->eventname;
          $organizer = "CN= $eventmanagerdetails->name:$eventmanagerdetails->email";
          
          // ICS
          $mail = [];
          $mail[0]  = "BEGIN:VCALENDAR";
          $mail[1] = "PRODID:-//Google Inc//Google Calendar 70.9054//EN";
          $mail[2] = "VERSION:2.0";
          $mail[3] = "CALSCALE:GREGORIAN";
          $mail[4] = "METHOD:REQUEST";
          $mail[5] = "BEGIN:VEVENT";
          $mail[6] = "DTSTART{$tzid}:" . $dtstart;
          $mail[7] = "DTEND{$tzid}:" . $dtend;
          $mail[8] = "DTSTAMP{$tzid}:" . $todaystamp;
          $mail[9] = "UID:" . $uid;
          $mail[10] = "ORGANIZER;" . $organizer;
          $mail[11] = "CREATED:" . $todaystamp;
          $mail[12] = "DESCRIPTION:" . $description;
          $mail[13] = "LAST-MODIFIED:" . $todaystamp;
          $mail[14] = "LOCATION:" . $location;
          $mail[15] = "SEQUENCE:0";
          $mail[16] = "STATUS:CONFIRMED";
          $mail[17] = "SUMMARY:" . $titulo_invite;
          $mail[18] = "TRANSP:OPAQUE";
          $mail[19] = "END:VEVENT";
          $mail[20] = "END:VCALENDAR";
          
          $mail = implode("\r\n", $mail);
          header("text/calendar");
          file_put_contents($filename, $mail);
          //outlook calendar link code ends here..

          $emailTemplateDecode = html_entity_decode($meeting_link['email_template']);
          $email_body = str_replace("##name##", $user->name, $emailTemplateDecode);
          $email_body = str_replace("##baseurl##", url('/'), $email_body);

          $email_body = str_replace("##logopath##", url('/').'/assets/front/images/email/logo.png', $email_body);
          $email_body = str_replace("##icebreakerimgpath##", url('/').'/assets/front/images/email/img_1.jpg', $email_body);
          $email_body = str_replace("##mmgameimgpath##", url('/').'/assets/front/images/email/marketing_madness.png', $email_body);
          
          $email_body = str_replace("##teamemails##", $emailids, $email_body);

        
          $email_body = str_replace("##userkey##", $user->enc_id, $email_body);
          $email_body = str_replace("##eventkey##", $event->meeting_token, $email_body);
          $email_body = str_replace("##starttime##", $convertedStartTime, $email_body);
          $email_body = str_replace("##endtime##", $convertedEndTime, $email_body);
          $email_body = str_replace("##timezone##", $userTimeZone, $email_body);
          $email_body = str_replace("##eventname##", $request->eventname, $email_body);
          $email_body = str_replace("##description##", $request->description? nl2br( Str::substr( $request->description, 0, 250 ) . ( strlen( $request->description ) > 250?'...':'' ) ):'NA', $email_body);
          $email_body = str_replace("##managername##", $eventmanagerdetails->name, $email_body);

          $email_body = str_replace("##teamname##", ( $team )?$team->name:'', $email_body);

          $emailParams = array( "to" => $user->email, "subject" => $meeting_link[ 'subject' ], "content" => $email_body,
                          // 'files' => [
                                  // [ 'file' => $filename, 'mime' => 'text/calendar' ],
                                  // [ 'file' => 'assets/content/game-play.pdf', 'mime' => 'application/pdf' ]
                              // ] 
          );
          //Method to send email
          $this->sendEmail($emailParams);

      }

      // Added new users which is assign in this event
      EventLinkInvitedUsers::insert($inviteLinkUsers);

      return redirect()->route('eventmanager.eventlist')->with(['success'=>'Event updated successfully.']);
    }else{
      return redirect()->route('eventmanager.eventlist')->with(['error'=>'Error occured while updating event.']);
    }

  }


  /** Fetch users data of logged in event manager **/
  public function ajaxDataLoad(Request $request){
    $eventmanager = session('manager_id');
    $managerTimezone = States::getTimezone( $eventmanager, 'manager')->timezone;
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
        2 => 'start_date',
        3 => 'usercount',
        4 => 'status'
    ];
    $columnName = $columns[$columnIndex];

    ## Search 
    $searchQuery = " ";
    if($searchValue != ''){
      $searchQuery = " and (name like '%".$searchValue."%' or description like '%".$searchValue."%') ";
    }
    
    ## Total number of records
    $totalRecords = Event::whereRaw(" (status = '1' or status = '0' or status = '2') and event_manager = '$eventmanager' ")->count();
    
    ## Total number of record with filtering
    $totalRecordwithFilter = Event::whereRaw(" (status = '1' or status = '0' or status = '2') and event_manager = '$eventmanager' ". $searchQuery)->count();
    
    ## Fetch records
    // $eventlist = Event::whereRaw(" (status = '1' or status = '0') and event_manager = '$eventmanager' ". $searchQuery)
          // ->orderBy($columnName, $columnSortOrder)->skip($row)->take($rowperpage)->get();
    $eventlist = DB::table('events as e')
            ->select(DB::raw('e.id,e.name,e.start_date,e.start_time,e.end_time,e.status,COUNT(ut.user_id) as usercount'))
            ->join('event_teams as et', 'et.event_id', '=', 'e.id', 'left')
            ->join('user_team as ut', 'ut.team_id', '=', 'et.team_id', 'left')
            ->whereRaw(" (e.status = '1' or e.status = '0' or e.status = '2') and e.event_manager = '$eventmanager' ". $searchQuery)
            ->groupBy('e.id')
            ->orderBy($columnName, $columnSortOrder)->skip($row)->take($rowperpage)->get();

    $checkbox = 1; $data = array(); $action = "";
    if(!empty($eventlist)){
        $x=0;
        foreach($eventlist as $events){
        $encryptId = Hashids::encode($events->id);
        
        // $checkbox = '<div class="animated-checkbox"><label style="margin-bottom:0px;"><input type="checkbox" name="ids[]" value="'.Hashids::encode($events->id).'" /><span class="label-text"></span></label></div>';
        // $action = "<a href=\"editevent/".$encryptId."\"><i class='fa fa-pencil' aria-hidden='true'></i></a> &nbsp;&nbsp; ";
        $action = "<a href='javascript:void(0);' onclick=\"delete_row('".$encryptId."', '$events->name', '".$x."')\"><i class='fa fa-trash' aria-hidden='true'></i></a></i>";
        
         $data[] = array( 
            $checkbox,
            "<a href='eventdetails/".Hashids::encode($events->id)."'>".$events->name."</a>",
            date("d M, Y", strtotime($events->start_date)).' <br/>'.date("H:i", $events->start_time).' to '.date("H:i", $events->end_time)." ( " .$managerTimezone." )",
            $events->usercount,
            // $events->status == "2" ? "<span class='badge' style='background:blue; color:#FFF; padding:5px;'>Completed</span>" : 
            // ($events->status =="1" ? "<span class='badge' style='background:green; color:#FFF; padding:5px;'><a class='active-inactive' href='javascript:void(0);' title='Click to make it inactive' onclick=\"activeInactiveState('".$encryptId."', '0')\">Active</a></span>" : "<span class='badge' style='background:#FF0000; color:#FFF; padding:5px;'><a class='active-inactive' href='javascript:void(0);' onclick=\"activeInactiveState('".$encryptId."', '1')\" title='Click to make it active'>Inactive</a></span>"),

            // ($events->status != "2") ? $action : ""
            $events->status == "2" ? "<span class='badge' style='background:blue; color:#FFF; padding:5px;'>Completed</span>" : 
            ($events->status =="1" ? "<span class='badge' style='background:green; color:#FFF; padding:5px;'>Active</span>" : "<span class='badge' style='background:#FF0000; color:#FFF; padding:5px;'>Inactive</span>"),

            ($events->status != "2") ? $action : ""
         );
         $x++;
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


  public function eventDetails($id){
    $title = "Event Details";
    $decryptId = Hashids::decode($id);

    $event_detail = Event::find($decryptId[0]);
    $event_detail->introgame = Game::find($event_detail->intro_game);
    $event_detail->maingame = Game::find($event_detail->main_game);
    
    $managerTimezone = States::getTimezone(session('manager_id'), 'manager')->timezone;
    $event_teams = EventTeam::where(["event_id"=>$decryptId[0]])->get(); 
    
    $data = [];
    foreach($event_teams as $event) {
      $data[] = $event->team_id;
    }
    $teams = Team::where(["status"=>1])->whereIn('id', $data)->get();
    
    return view('eventmanager.events.event_details', ['title' => $title, "event_detail"=> $event_detail, "breadcrumbItem" => "Manage Events" , "breadcrumbTitle"=> "Event Details", "teams"=> $teams, "breadcrumbLink" => "eventmanager.eventlist", "breadcrumbTitle2"=>"Event Details", 'eventId' => $id, 'timezone' =>$managerTimezone]);
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
