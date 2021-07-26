<?php
namespace App\Http\Traits;

use Vinkla\Hashids\Facades\Hashids;

use App\Models\Event;
use App\Models\User;
use App\Models\GameSettings;
use App\Models\States;
use App\Models\EventManagers;
use App\Models\UserTeam;
use App\Models\GameIceBreakerScreenTime;
use Mail;
use Carbon\Carbon;
use DateTimeZone;
use DateTime;

//use App\Brand;

trait CommonMethods { 

    public static $MEETING_RUNNING = 1;
    public static $MEETING_ERROR_INVALID_USER = 2;
    public static $MEETING_ERROR_EVENT_EXPIRED = 3;
    public static $MEETING_ERROR_EVENT_NOT_STARTED = 4;
    public static $MEETING_ERROR_INACTIVE_USER = 5;
    public static $MEETING_ERROR_INVALID_MEETING_LINK = 6;
    public static $MEETING_GOING_TO_START = 7;



    public static $EVENT_STARTS_IN_TIMER = 15;

    private $event = false;
    private $user = false;
    private $runningTime = false;

    public function defaultTimeZone (){
        return 'Asia/Kolkata';
    }

    public function getEvent(){
        return $this->event;
    }

    public function getUser(){
        return $this->user;
    }

    public function getEventRunningTime(){
        return $this->runningTime;
    }

	public function checkMeetingTokenValidOrNot( $encryptedId = NULL ){

        /* $status = 1; */
		/** $encryptId split with an "-"  and the first array value is userToken, second is meetingToken  ***/
        $explodeMeetingId = explode("-", $encryptedId);
        $userToken = $explodeMeetingId[0]; $meetingToken = $explodeMeetingId[1];

        $event = $this->event = Event::where(["meeting_token"=>$meetingToken])->first();
        if( !$event ){
            //return redirect()->route('invalid')->with(['error'=>'Invalid meeting link.']);
            // return false;
            return SELF::$MEETING_ERROR_INVALID_MEETING_LINK; //Invalid meeting link
        }

        $user = $this->user = User::where(["enc_id"=>$userToken, "status"=>1])->first();
        if( !$user ){
            //return redirect()->route('invalid')->with(['error'=>'Inactive user.']);
                // return false;
            return SELF::$MEETING_ERROR_INACTIVE_USER; //check user token in database table first
        }

        $success = ""; $error = "";

        // echo "cur: ".$userCurrentTime. ' start '.$eventStartTimeForUser . ' end '.$eventEndTimeForUser; die;

        //current timestamp server
        $currentTimeStamp = $this->getServerTime($event->id); 

        $startTime = date('Y-m-d H:i:s', $event->start_time);
        $endTime = date('Y-m-d H:i:s', $event->end_time);
        
        $getEventUserTimeZone = $this->getEventUserTimeZone($user->id);
        $eventStartTimeForUser = $this->getUserTimeZone($user->id, $startTime, $event->event_manager);
        $eventEndTimeForUser = $this->getUserTimeZone($user->id, $endTime, $event->event_manager);
        $userCurrentTime = $this->getCurrentTimeofTimeZone($getEventUserTimeZone);

        // check if current time is between the event start and end time
        if($userCurrentTime >= $eventStartTimeForUser && $userCurrentTime <= $eventEndTimeForUser){ 
            // check user is participate in any team which is assign to this event
            $result = $this->userTeamModelInstance->getValidUserOfCurrentEvent($event->id, $user->id);
            
            if($result){ 
                $this->runningTime = $this->getTimeDifference(strtotime($userCurrentTime), strtotime($eventStartTimeForUser));
                //$userteam = User::find($user->id)->userteam()->first();
                return SELF::$MEETING_RUNNING;
            }

            //return redirect()->route('invalid')->with(['error'=>'Invalid user for this event.']);
            return SELF::$MEETING_ERROR_INVALID_USER; // Invalid User.

        }else{ 
            if($eventEndTimeForUser < $userCurrentTime){
                return SELF::$MEETING_ERROR_EVENT_EXPIRED; // Event expired
            }

            //return redirect()->route('invalid')->with(['error'=>'Event not started yet.']);                 
       		// return false;
            
            $pendingTime = $this->getTimeDifference(strtotime($userCurrentTime), strtotime($eventStartTimeForUser));
            if($pendingTime['minutesonly'] < SELF::$EVENT_STARTS_IN_TIMER ){ 
                $this->runningTime = $this->getTimeDifference(strtotime($userCurrentTime), strtotime($eventStartTimeForUser));
                return SELF::$MEETING_GOING_TO_START; 
            }
            
            return SELF::$MEETING_ERROR_EVENT_NOT_STARTED; // Event not Started yet..

        }

	}

    public function getInvalidMeetingRequestErrorMsgs( ){
        return [
            SELF::$MEETING_ERROR_INVALID_USER => 'Invalid User',
            SELF::$MEETING_ERROR_EVENT_EXPIRED => 'Event expired',
            SELF::$MEETING_ERROR_EVENT_NOT_STARTED => 'Sorry, you are way too early &#128522;<br/>
                                                        You can join the event as early as '.SELF::$EVENT_STARTS_IN_TIMER.' minutes before the event  actually starts.</br>
                                                        Please join us back at that time.</br>
                                                        See you soon!',
            SELF::$MEETING_ERROR_INACTIVE_USER => 'Inactive user',
            SELF::$MEETING_ERROR_INVALID_MEETING_LINK=> 'Invalid meeting link',
        ];
    }

    public function getInvalidMeetingRequestErrorMsgsTitle( ){
        return [
            SELF::$MEETING_ERROR_INVALID_USER => 'Invalid User!!',
            SELF::$MEETING_ERROR_EVENT_EXPIRED => 'Event expired!!',
            SELF::$MEETING_ERROR_EVENT_NOT_STARTED => 'Sorry, you are way too early!!',
            SELF::$MEETING_ERROR_INACTIVE_USER => 'Inactive user!!',
            SELF::$MEETING_ERROR_INVALID_MEETING_LINK=> 'Invalid meeting link!!',
        ];
    }


    public function uniqueId($id=NULL, $uniqueChar = NULL) {
        // created user unique id.
        $unique = $id."".time()."".$uniqueChar."".uniqid(mt_rand(5, 5));
        return $unique;
    }

    public function getServerTime($eventId=NULL) {

        $timezone = Event::getTimezoneAgainstEventId($eventId)->timezone;
        $timestamp = Carbon::parse(date("Y-m-d H:i:s"))->timezone($timezone)->toDateTimeString();        
        $timestamp = strtotime($timestamp);
        return $timestamp;
    }


    public function getUTCTime(){
        $timestamp = Carbon::parse(date("Y-m-d H:i:s"))->timezone('UTC')->toDateTimeString();
        
        $timestamp = strtotime($timestamp);
        return $timestamp;
    }

    public function encodeId($id=NULL) {
        // get the server time and convert it into timestamp.
        $encId = Hashids::encode($id);
        return $encId;
    }

    public function decodeId($encodedId=NULL) {
        // get the server time and convert it into timestamp.
        $decodeId = Hashids::decode($encodedId);
        return $decodeId[0];
    }

    public function getTimeDifference($userJoinTime=NULL, $eventStartTime=NULL){

        // Formulate the Difference between two dates 
		$diff = abs($eventStartTime - $userJoinTime);  
		  
		  
		// To get the year divide the resultant date into 
		// total seconds in a year (365*60*60*24) 
		$years = floor($diff / (365*60*60*24));  
		  
		  
		// To get the month, subtract it with years and 
		// divide the resultant date into 
		// total seconds in a month (30*60*60*24) 
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));  
		  
		  
		// To get the day, subtract it with years and  
		// months and divide the resultant date into 
		// total seconds in a days (60*60*24) 
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
		  
		  
		// To get the hour, subtract it with years,  
		// months & seconds and divide the resultant 
		// date into total seconds in a hours (60*60) 
		$hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));  
		  
		  
		// To get the minutes, subtract it with years, 
		// months, seconds and hours and divide the  
		// resultant date into total seconds i.e. 60 
		$minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);  
		  
		  
		// To get the minutes, subtract it with years, 
		// months, seconds, hours and minutes  
		$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));  
		  
		// Print the result 
		//printf("%d years, %d months, %d days, %d hours, ". "%d minutes, %d seconds", $years, $months, $days, $hours, $minutes, $seconds);

        $minutesonly = $days * 24 * 60;
        $minutesonly += $hours * 60;

        $secondsOnly = $minutesonly;
        $secondsOnly += $minutes * 60;
        $secondsOnly += $seconds;

        $minutesonly += $minutes;

		$timeArr = array("minutesonly"=> $minutesonly, "minutes"=>$minutes , "seconds" =>$seconds, "secondsonly" => $secondsOnly);
		return $timeArr;

    }


    /*** If event timer time is 5 than we add the +5 minutes in event start time and get the end time of countdown timer ****/
    public function getEventEndTime($eventStartTime=NULL){
        $setting = $this->getGameSettings();
    	// $countdowntime = \Config::get('constants.countdowntime');
        $countdowntime = '+'.$setting->awaiting_screen_time.' minutes';
    	return strtotime($countdowntime, $eventStartTime);
    }

    // common function to send email
    public function sendEmail($dataArry=NULL){
        $to = $dataArry['to']; $subject = $dataArry['subject'];$emailBody = $dataArry['content'];
        $files = ( isset( $dataArry['files'] ) && $dataArry['files'] )?$dataArry['files']:[];

        if(isset($dataArry['file']) && isset($dataArry['mime'])){
            $file = $dataArry['file'];
            $mime = $dataArry['mime'];
        }else{
            $file = "";
            $mime = "";
        }
        Mail::send([], [], function($message) use($to, $subject, $emailBody, $files, $file, $mime) {
          $message->setBody($emailBody, 'text/html');
          $message->from(\Config::get('constants.from_email'), \Config::get('constants.from_name'));
          $message->to($to);
          $message->subject($subject);
          if( $files ) { 
            foreach( $files as $fl ) { 
                $message->attach( $fl[ 'file' ], array('mime' => $fl[ 'mime' ] ) );
            }
          }
          if($file){
            $message->attach($file, array('mime' => $mime));
          }
        });

    }


    public function getGameSettings(){
        $settings = GameSettings::find('1');
        return $settings;
    }


    public function getTimeFromTimestamp($timestamp=NULL){
        return date("H:i", $timestamp);
    }
    //get coverted time as per user timezone for Event Time.
    public function getUserTimeZone ($userId, $time, $manager_id)
    {
        $managerTimeZone = $this->getEventManagerTimeZone ($manager_id);
        $userTimeZone = $this->getEventUserTimeZone ($userId);

        if($managerTimeZone){
            date_default_timezone_set($managerTimeZone);
            $datetime = new DateTime($time);
            $datetime->format('Y-m-d H:i:s') . "\n";
            $la_time = new DateTimeZone($userTimeZone);
            $datetime->setTimezone($la_time);
            $finaltime = $datetime->format('Y-m-d H:i:s');
            date_default_timezone_set( $this->defaultTimeZone() );
            return $finaltime;
        }
    }

    //get coverted time as per event manager timezone for Event Time.
    public function getDateAndTimeFromEventTimeZone ( $time, $manager_id )
    {
        $managerTimeZone = $this->getEventManagerTimeZone ($manager_id);

        if($managerTimeZone){
            date_default_timezone_set($managerTimeZone);
            $datetime = new DateTime($time);
            $convertedDateTime = $datetime->format('Y-m-d H:i:s');
            date_default_timezone_set( $this->defaultTimeZone() );
            return $convertedDateTime;
        }
    }

    //get the Timezone of Manager by Id
    public function getEventManagerTimeZone ($managerId)
    {
        $stateId = EventManagers::where(['id' => $managerId])->first();
        if($stateId->state_id){
            $timezone = States::where(['id' => $stateId->state_id])->first();
            return $timezone->timezone;
        }else{
            return $this->defaultTimeZone();
        }
    }
    //get the Timezone of user by user Id
    public function getEventUserTimeZone ($userId)
    {
        $userdata = User::where(['id' => $userId])->first();
        if($userdata->state_id){
            $usertimezone = States::where(['id' => $userdata->state_id])->first();
            return $usertimezone->timezone;
        }else{
            return $this->defaultTimeZone();
        }
    }
    //Method to get expected timezone current time.
    public function getCurrentTimeofTimeZone ($timezone)
    {
        if($timezone){
            date_default_timezone_set($timezone);
            $data = date('Y-m-d H:i:s');
            date_default_timezone_set($this->defaultTimeZone());
            return $data;
        }else{
            return false;
        }        
    }

    public function redirectToScreen( Event $event, User $user, UserTeam $userTeam, $current = 'funfacts' ) {
        $screenData = GameIceBreakerScreenTime::where(["ibst_event_id"=> $event->id, "ibst_team_id"=> $userTeam->team_id])->first();
        if( $screenData ) { 
            if( $screenData->ibst_ice_breaker_game_screen_time ) { 
                return ( $current != 'gamescreen' )?redirect()->route('front.gamescreen',['encryptedId'=>$user->enc_id."-".$event->meeting_token]):false;
            }elseif( $screenData->ibst_fun_facts_screen_time ) { 
                return ( $current != 'funfacts' )?redirect()->route('front.funfacts',['encryptedId'=>$user->enc_id."-".$event->meeting_token]):false;
            }
        }
    }

    public function mmGameValidations($eventId, $currentTime){

        $eventDetails = Event::find($eventId);
        
        if( $eventDetails->count() ){

            $managerTimeZone = $this->getEventManagerTimeZone($eventDetails->event_manager);

            $end_time = date('Y-m-d H:i:s', $eventDetails->end_time);
            $start_time = date('Y-m-d H:i:s', $eventDetails->start_time);
            //convert end time to UTC
            $date = date_create($end_time, timezone_open($managerTimeZone));
            date_timezone_set($date, timezone_open('UTC'));
            $convertedToUTCendTime = strtotime(date_format($date, 'Y-m-d H:i:sP')) . "\n";
            //convert start time to UTC
            $date = date_create($start_time, timezone_open($managerTimeZone));
            date_timezone_set($date, timezone_open('UTC'));
            $convertedToUTCstartTime = strtotime(date_format($date, 'Y-m-d H:i:sP')) . "\n";
            // echo $currentTime . ' | ' . $convertedToUTC; die;
            if($currentTime < $convertedToUTCendTime && $currentTime > $convertedToUTCstartTime){
                return true;
            }else{
                return false;
            }
        }
    }

    public function getUTCTimeStamp (){
        $defaultT = date_default_timezone_get();
        date_default_timezone_set("UTC");
        $date=date_create();
        $timestamp = date_timestamp_get($date);
        date_default_timezone_set($defaultT);
        return $timestamp;
    }

    public function getEventUTCTimes ( $eventDetails ){
        
        $ret = ['status' => false];
        $currentUTC = $this->getUTCTimeStamp();
        
        $managerTimeZone = $this->getEventManagerTimeZone($eventDetails->event_manager);
        $start_time = date('Y-m-d H:i:s', $eventDetails->start_time);
        $end_time = date('Y-m-d H:i:s', $eventDetails->end_time);
        
        $date = new DateTime($start_time, new DateTimeZone($this->defaultTimeZone()));
        $date->format('Y-m-d H:i:sP');
        $date->setTimezone(new DateTimeZone('UTC'));
        $dateCon = $date->format('Y-m-d H:i:sP'); 
        $startTimeUTC = strtotime($dateCon);

        $hours = '- 5 hours';
        $mins = '- 30 minutes';
        $startTimeUTC = strtotime($hours, $startTimeUTC);
        $startTimeUTC = strtotime($mins, $startTimeUTC);

        $date = new DateTime($end_time, new DateTimeZone($this->defaultTimeZone()));
        $date->format('Y-m-d H:i:sP');
        $date->setTimezone(new DateTimeZone('UTC'));
        $dateCon = $date->format('Y-m-d H:i:sP'); 
        $endTimeUTC = strtotime($dateCon);

        $endTimeUTC = strtotime($hours, $endTimeUTC);
        $endTimeUTC = strtotime($mins, $endTimeUTC);

        $ret['currentUTC'] = $currentUTC;
        $ret['startTimeUTC'] = $startTimeUTC;
        $ret['endTimeUTC'] = $endTimeUTC;
        $ret['status'] = true;

        return $ret;
    }

}