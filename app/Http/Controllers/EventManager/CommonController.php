<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

use App\Models\Team;
use App\Models\User;
use App\Models\Event;
use App\Models\EventTeam;
use App\Models\EventManagers;
use App\Models\Emails;
use App\Models\States;
use App\Http\Traits\CommonMethods;

use Illuminate\Support\Str;

class CommonController extends Controller
{

  use CommonMethods;

  private static $instance;

  public function __construct() {
    
  }

  public static function getInstance() {
      if (!isset(self::$instance)) {
          self::$instance = new static();
      }
      return self::$instance;
  }

  /* Delete the single row of a model  */
  public function deleteRow(Request $request){
    $message = "Row deleted successfully.";
    $rowid = Hashids::decode($request->rowid); $model = $request->affected_data_model;
    if(isset($rowid) && isset($model)){
      if($model == 'events'){
        //cancel mail to all users
        $event = Event::find($rowid)->first();
        $usersInEvent = Event::usersInEvent($event->id);
        $delete = DB::table('event_teams')->where(["event_id"=>$rowid[0]])->delete();
        
      }
      $delete = DB::table($model)->where(["id"=>$rowid[0]])->delete();
      //mail to event users
      if($model == 'events'){
        //cancel mail to all users
        $mailStartTime = date('Y-m-d H:i:s',$event->start_time);
        $mailEndTime = date('Y-m-d H:i:s',$event->end_time);
        $eventmanagerdetails = EventManagers::find($event->event_manager);

        foreach ($usersInEvent as $user) { 
          $this->sendCancelEventEmail($event, $user,$mailStartTime, $mailEndTime, $eventmanagerdetails);
        }
        
        $message = "The event has been successfully deleted.";
      }
      //mail to event users
      try {
        if($delete){
          echo json_encode(array("code"=>200, "message"=> $message));
        }else{
          echo json_encode(array("code"=>203, "message"=>"Error occured while deleting user."));
        }
      
      }catch (Exception $e) {
           echo json_encode(array("code"=>500, "message"=>$e->getMessage()));
      }
      
    }else{
      echo json_encode(array("code"=>500, "message"=>"Some information is missing!"));
    }
  }

  /* Delete bulk rows of a model  */
  public function updateBulkRows(Request $request){
    $idsArr = array();
    foreach ($request->rowids as $value) {
      $rowids = Hashids::decode($value); 
      $idsArr[] = $rowids[0];
    }   
    $actiontype = $request->actiontype; $model = $request->affected_data_model; $alertText = "updated";
    if(isset($actiontype) && isset($model)){
      if($actiontype==2){
        $alertText = "deleted";
        $delete = DB::table($model)->whereIn('id', $idsArr)->delete();
      }else{
        $delete = DB::table($model)->whereIn('id', $idsArr)->update(["status"=>$actiontype]);
      }
      try {
        if($delete){
          echo json_encode(array("code"=>200, "message"=>"Rows ".$alertText." successfully."));
        }else{
          echo json_encode(array("code"=>203, "message"=>"Error occured while updating data."));
        }
      }catch(Exception $e){
          echo json_encode(array("code"=>500, "message"=>$e->getMessage()));
      }

    }else{
        echo json_encode(array("code"=>500, "message"=>"Some information is missing!"));
    }

  }



  /* Common method to set Active/Inactive status  */
  public function setActiveInactive(Request $request){
    $rowid = Hashids::decode($request->affected_id); $model = $request->affected_data_model; $status = $request->status;
    if(isset($rowid) && isset($model)){
      $update = DB::table($model)->where(["id"=>$rowid[0]])->update(['status' => $status]);
      
      try {
        if($update){
          echo json_encode(array("code"=>200, "message"=>"Status updated successfully."));
        }else{
          echo json_encode(array("code"=>203, "message"=>"Error occured while updating user."));
        }
      
      }catch (Exception $e) {
           echo json_encode(array("code"=>500, "message"=>$e->getMessage()));
      }
      
    }else{
      echo json_encode(array("code"=>500, "message"=>"Some information is missing!"));
    }
  }

  
  public function sendCancelEventEmail($event, $user,$mailStartTime, $mailEndTime, $eventmanagerdetails)
  {        
        $eventmanager = $eventmanagerdetails->id;

        $userteam = User::find( $user->user_id )->userteam()->first();
        // $team = ( $userteam )?Team::find( $userteam->team_id ):false;
        $team = Team::find( $user->team_id );
        //get email ids for all members within the team
        $emailids = Team::getTeamEmailIds($user->team_id)->emailids;
        $emailids = str_replace(',',"<br>",$emailids);

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
        $todaystamp = date('Ymd\THis', strtotime($todayTime));
        $uid = date('Ymd').'T'.date('His').'-'.rand().'@yourdomain.com';
        $description = strip_tags($event->description);
        $location = "";
        $titulo_invite = $event->name;
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
        $mail[16] = "STATUS:CANCELLED";
        $mail[17] = "SUMMARY:" . $titulo_invite;
        $mail[18] = "TRANSP:OPAQUE";
        $mail[19] = "END:VEVENT";
        $mail[20] = "END:VCALENDAR";
        
        $mail = implode("\r\n", $mail);
        header("text/calendar");
        file_put_contents($filename, $mail);
        //outlook calendar link code ends here..
        $meeting_link = Emails::where(['email_slug' => 'event_cancelled'])->first();
        $emailTemplateDecode = html_entity_decode($meeting_link['email_template']);
        $email_body = str_replace("##name##", $user->name, $emailTemplateDecode);
        $email_body = str_replace("##logopath##", url('/').'/assets/front/images/email/logo.png', $email_body);
        $email_body = str_replace("##teamemails##", $emailids, $email_body);
        $email_body = str_replace("##starttime##", $convertedStartTime, $email_body);
        $email_body = str_replace("##endtime##", $convertedEndTime, $email_body);
        $email_body = str_replace("##timezone##", $userTimeZone, $email_body);
        $email_body = str_replace("##eventname##", $event->name, $email_body);
        $email_body = str_replace("##description##", $event->description? nl2br( Str::substr( $event->description, 0, 250 ) . ( strlen( $event->description ) > 250?'...':'' ) ):'NA', $email_body);
        $email_body = str_replace("##managername##", $eventmanagerdetails->name, $email_body);

        $email_body = str_replace("##teamname##", ( $team )?$team->name:'', $email_body);

        $emailParams = array("to"=>$user->email, "subject"=>$meeting_link['subject'], "content"=>$email_body
        // 'files' => [
        //         [ 'file' => $filename, 'mime' => 'text/calendar' ],
        //     ] 
          );
        //Method to send email
        $this->sendEmail($emailParams);
    }

}
