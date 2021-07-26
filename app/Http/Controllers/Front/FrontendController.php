<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Traits\CommonMethods;
use App\Models\Event;
use App\Models\User;
use App\Models\UserTeam;
use App\Models\EventJoin;
use App\Models\FunFacts;
use App\Models\EventFunFactsAnswers;
use App\Models\SocketConnectUsers;
use App\Models\EventTeam;
use App\Models\GameIceBreakerScreenTime;
use App\Models\MmRounds;
use App\Models\Game;
use App\Models\MainGameStatus;
use Carbon\Carbon;
use LRedis;
use \Config;

class FrontendController extends Controller
{

    use CommonMethods;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->userTeamModelInstance = new UserTeam;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */



    // Welcome page
    public function welcome(){
        $title = 'Welcome to Office-Campfire';
        return view('front.welcome', [
            'title' => $title
        ]);
    }
    
    /*** Home page where event team members join the event ***/
    public function homepage($encryptedId=NULL){

        $pendingMinut = '00';
        $pendingSeconds = '00';

        $status = $this->checkMeetingTokenValidOrNot($encryptedId);
        
        if( !in_array( $status, [ SELF::$MEETING_RUNNING, SELF::$MEETING_GOING_TO_START ] ) ) { 
            return redirect()->route('invalid')->with(['error'=>$this->getInvalidMeetingRequestErrorMsgs()[ $status ], 'error_title'=>$this->getInvalidMeetingRequestErrorMsgsTitle()[ $status ]]);
        }

        $event =$this->getEvent();
        $user = $this->getUser();
        $userteam = Event::getTeamforEventAndUser($event->id, $user->id);

        if( $status == SELF::$MEETING_GOING_TO_START ){
            $pendingTime = $this->getEventRunningTime( );
            $pendingMinut = $pendingTime['minutes'];
            $pendingSeconds = $pendingTime['seconds'];
        }

        $title = 'Join The Event';
        return view('front.homepage', [
            'title' => $title,
            'name' => $event->name,
            'user_id' => $this->encodeId($user->id),
            'team_id' => $this->encodeId($userteam->team_id),
            'event_id' => $this->encodeId($event->id),
            'validstatus' => $status,
            'pendingMinut' => $pendingMinut,
            'pendingSeconds' => $pendingSeconds,
            'initial_event_timer'   =>  SELF::$EVENT_STARTS_IN_TIMER
        ]);
    }

    public function invalid(){
        $title = \Session::get( 'error_title' );
        $title = $title?$title:'Invalid Meeting Link';
        return view('front.invalid', [
            'title' => $title
        ]);
    }

    public function reflections(){

        $title = 'Thank you!!';
        return view('front.reflection', [
            'title' => $title
        ]);
    }


    public function thankyou ( $encryptedId ){

        $status = $this->checkMeetingTokenValidOrNot( $encryptedId );
        
        if( $status != SELF::$MEETING_RUNNING ) { 
            return redirect()->route('invalid')->with(['error'=>$this->getInvalidMeetingRequestErrorMsgs()[ $status ], 'error_title'=>$this->getInvalidMeetingRequestErrorMsgsTitle()[ $status ]]);
        }

        $runningTime = $this->getEventRunningTime( );
        $gameSettings = $this->getGameSettings( );

        //$runningTime['secondsonly'] = 3590;
        $totalSecondsLeft = ( $gameSettings->game_time * 60 ) - $runningTime[ 'secondsonly' ];
        $mm = $ss = 00;
        if( $totalSecondsLeft > 0 ) { 
            $mm = floor( ( $totalSecondsLeft / 60 ) % 60 );
            $ss = $totalSecondsLeft % 60;
        }

        $title = 'Thank you!!';
        return view('front.thankyou', [
            'title' => $title,
            'mm' => $mm,
            'ss' => $ss
        ]);
    }

    public function tutorials(){
        $title = 'Tutorials!';
        return view('front.tutorials', [
            'title' => $title
        ]);
    }

    public function updateUserName(Request $request){

        $userId = $this->decodeId($request->user_id);
        $validatedData = $this->validate($request, [
            'fullname' => 'required|regex:/^[0-9a-zA-Z\s]+$/u',
            'avatar' => 'required|regex:/^[0-9a-zA-Z\s]+$/u'
        ]);

        $user = User::find($userId); 
        $user->name = $request->fullname;
        $user->avatar = $request->avatar;
        $user->save();
        if($user){
            $teamId = $this->decodeId($request->team_id);
            $eventId = $this->decodeId($request->event_id);
 
            $eventToken = Event::find( $eventId );
            $userToken = User::find( $userId );

            //check firt this user is already exist in the table with same event
            $isStartedTime = GameIceBreakerScreenTime::where([ "ibst_event_id"=> $eventId, "ibst_team_id"=> $teamId])->whereNotNull( 'ibst_event_start_time' )->pluck( 'ibst_event_start_time' )->first();
            if( !$isStartedTime ){ 
                
                $startTime = date('Y-m-d H:i:s', $eventToken->start_time);
                $eventStartTimeForUser = $this->getDateAndTimeFromEventTimeZone( $startTime, $eventToken->event_manager );
                $startTime = strtotime( $eventStartTimeForUser );

                GameIceBreakerScreenTime::updateOrCreate( [ "ibst_event_id" => $eventId, "ibst_team_id" => $teamId ], [ "ibst_event_start_time" => $startTime, "ibst_awaiting_screen_time" => $startTime ] );
            }

            $channelId = "event_".$eventId."".$teamId;
            $totalUserCount = EventJoin::getJoinEventTeamUsersCount($eventId, $teamId);

            /* User connected to socket */
            $json = json_encode(array('totalUserCount' => $totalUserCount, 'redirectTo' => 'funfacts', "RedirectBit"=>2));

            /* User connected to socket */
            $redis = LRedis::connection();
            $redis->publish($channelId, $json);

            return redirect()->route('front.eventstart',['encryptedId'=>$userToken->enc_id."-".$eventToken->meeting_token]); 
        }
    }

    public function eventStart($encryptedId=NULL)
    {
        $bitt = 1;
        //Check meeting link is valid or not
        $status = $this->checkMeetingTokenValidOrNot($encryptedId);

        if( $status != SELF::$MEETING_RUNNING ) { 
            return redirect()->route('invalid')->with(['error'=>$this->getInvalidMeetingRequestErrorMsgs()[ $status ], 'error_title'=>$this->getInvalidMeetingRequestErrorMsgsTitle()[ $status ]]);
        }
        
        $event =$this->getEvent();
        $user = $this->getUser();
        $userteam = $user->userteam()->first();
        $teamId = Event::getTeamforEventAndUser($event->id, $user->id)->team_id;
        
        $where = ["user_id"=>$user->id, "event_id"=>$event->id, "team_id"=>$teamId];

        $eventJoinUserObj = EventJoin::where( $where );

        if( $eventJoinUserObj->count() == 0 ) { 
           $data = array("user_id"=>$user->id, "event_id"=>$event->id, "team_id"=>$teamId, "socket_id"=>""); 
           EventJoin::create($data);
           $eventJoinUserObj = EventJoin::where( $where );
        }

        /*
        * Check current running screen time
        * Move to next screen if time ends
        * Remain here till minimum required user not connected
        * [ 
        */
        $runningTime = $this->getEventRunningTime( );
        $gameSettings = $this->getGameSettings( );
        $awaiting_screen_time = $gameSettings->awaiting_screen_time + 4;

        $ffst = $gameSettings->funfacts_screen_time > 0?$gameSettings->funfacts_screen_time:2;
        $ffwst = $gameSettings->funfacts_waiting_screen_time > 0?$gameSettings->funfacts_waiting_screen_time:1;
        $ibgst = $gameSettings->ib_game_screen_time > 0?$gameSettings->ib_game_screen_time:2;
        $ast = $gameSettings->awaiting_screen_time > 0?$gameSettings->awaiting_screen_time:5;

        $totalGameTime = $ffst + $ffwst + $ibgst + $ast;

        if( $runningTime[ 'minutesonly' ] > $totalGameTime - 1 ) { 
            return $this->updateStatusAndmoveToMainGame( $event->id, $teamId, $encryptedId );
        }

        //check for ICE Breaker game status
        $this->moveToMainGame ($event->id, $teamId, $encryptedId);
        /*
        * ]
        */

        $channelId = "event_".$event->id."".$teamId;
        $totalUserCount = EventJoin::getJoinEventTeamUsersCount($event->id, $teamId);

        /* User connected to socket */
        /*$json = json_encode( array( 'totalUserCount' => $totalUserCount, 'redirectTo' => 'funfacts', "RedirectBit"=>1, 'reconnect_stream' => true ) );*/
        $json = json_encode( array( 'totalUserCount' => $totalUserCount, 'redirectTo' => 'funfacts', "RedirectBit"=>1  ) );

        /* User connected to socket */
        $redis = LRedis::connection( );
        $redis->publish($channelId, $json);

        $title = 'Event Started';
        
        $mainGame = Event::find( $event->id )->game;

        $mainGameUrl = Config::get("constants.mm_url") . '?enc=' . $encryptedId;
        
        if($mainGame->key == 'escape_room'){
            $mainGameUrl = route('crimeinvestigation.splash' , $encryptedId);
        }

        return view('front.eventstart', 
                    [
                        'title'         =>  $title, 
                        'user_id'       =>  $this->encodeId($user->id),
                        'team_id'       =>  $this->encodeId($teamId),
                        'event_id'      =>  $this->encodeId($event->id), 
                        "channel_id"    =>  $channelId, 
                        "encryptedId"   =>  $encryptedId, 
                        'bitt'          =>  $bitt,
                        'mainGameUrl'   =>  $mainGameUrl,
                        'mainGameKey'   =>  $mainGame->key
                    ]
                );
    }

    //move to MM frontend url
    public function mMRulesScreen ($encryptedId=NULL){
        $bitt = 2;

        //Check meeting link is valid or not
        $status = $this->checkMeetingTokenValidOrNot($encryptedId);
        
        if( $status != SELF::$MEETING_RUNNING ) { 
            return redirect()->route('invalid')->with(['error'=>$this->getInvalidMeetingRequestErrorMsgs()[ $status ], 'error_title'=>$this->getInvalidMeetingRequestErrorMsgsTitle()[ $status ]]);
        }

        $event =$this->getEvent();
        $user = $this->getUser();
        $userteam = $user->userteam()->first();
        $teamId = Event::getTeamforEventAndUser($event->id, $user->id)->team_id;

        $eventJoinUserObj = EventJoin::where(["user_id"=>$user->id, "event_id"=>$event->id, "team_id"=>$teamId]);
        if( $eventJoinUserObj->count() == 0 ) { 
           $data = array("user_id"=>$user->id, "event_id"=>$event->id, "team_id"=>$teamId, "socket_id"=>""); 
           EventJoin::create($data);
           $eventJoinUserObj = EventJoin::where(["user_id"=>$user->id, "event_id"=>$event->id, "team_id"=>$teamId]);
        }

        EventTeam::where(['event_id' => $event->id, 'team_id' => $teamId])
            ->update([
                'ib_status' => 2
            ]);

        $title = 'Market Madness';
        
        $channelId = "event_".$event->id."".$teamId;
        /* User connected to socket */

        $totalUserCount = EventJoin::getJoinEventTeamUsersCount($event->id, $teamId); 
        
        $mainGame = Event::find( $event->id )->game;

        $mainGameUrl = Config::get("constants.mm_url") . '?enc=' . $encryptedId;
        
        if($mainGame->key == 'escape_room'){
            $mainGameUrl = route('crimeinvestigation.splash' , $encryptedId);
            $bitt = 3;
        }

        return view('front.eventstart', 
                        [
                            'title'         =>  $title, 
                            'user_id'       =>  $this->encodeId($user->id),
                            'team_id'       =>  $this->encodeId($teamId),
                            'event_id'      =>  $this->encodeId($event->id),
                            "channel_id"    =>  $channelId, 
                            "encryptedId"   =>  $encryptedId, 
                            'bitt'          =>  $bitt,
                            'mainGameUrl'   =>  $mainGameUrl,
                            'mainGameKey'   =>  $mainGame->key
                        ]);
    }

    public function awaitingScreen($encryptedId=NULL){ 

        //Check meeting link is valid or not
        $status = $this->checkMeetingTokenValidOrNot($encryptedId);
        
        if( $status != SELF::$MEETING_RUNNING ) { 
            return redirect()->route('invalid')->with(['error'=>$this->getInvalidMeetingRequestErrorMsgs()[ $status ], 'error_title'=>$this->getInvalidMeetingRequestErrorMsgsTitle()[ $status ]]);
        }

        $event = $this->getEvent();
        $user = $this->getUser();
        $userteam = $user->userteam()->first();
        $teamId = Event::getTeamforEventAndUser($event->id, $user->id)->team_id;
        $getCurrentTime = $cloneCurrentTime = $this->getServerTime($event->id);

        //check for ICE Breaker game status
        $this->moveToMainGame ($event->id, $teamId, $encryptedId, true);
        $mainGame = Event::find( $event->id )->game;

        $mainGameUrl = Config::get("constants.mm_url") . '?enc=' . $encryptedId;
        
        if($mainGame->key == 'escape_room'){
            $mainGameUrl = route('crimeinvestigation.splash' , $encryptedId);
        }
        /* 
         * Update Join Details if comes directly to awaiting screen
         * Update Current screen in db
         * Redirect if already passed from this screen
        //this code will fired when user comes directly to the awaiting screen [ */
        $eventJoinUserObj = EventJoin::where(["user_id"=>$user->id, "event_id"=>$event->id, "team_id"=>$teamId]);
        if( $eventJoinUserObj->count() == 0 ) { 
            $data = array("user_id"=>$user->id, "event_id"=>$event->id, "team_id"=>$teamId, "socket_id"=>""); 
            EventJoin::create($data);
            $eventJoinUserObj = EventJoin::where(["user_id"=>$user->id, "event_id"=>$event->id, "team_id"=>$teamId]);
        }

        $isStartedTime = GameIceBreakerScreenTime::where(["ibst_event_id"=> $event->id, "ibst_team_id"=> $teamId])->whereNotNull( 'ibst_awaiting_screen_time' )->pluck( 'ibst_awaiting_screen_time' )->first();
        
        if( !$isStartedTime ){ 
            
            $eventStartTime = GameIceBreakerScreenTime::where(["ibst_event_id"=> $event->id, "ibst_team_id"=> $teamId])->whereNotNull( 'ibst_event_start_time' )->pluck( 'ibst_event_start_time' )->first();
            if( !$eventStartTime ) { 
                $startTime = date('Y-m-d H:i:s', $event->start_time);
                $eventStartTimeForUser = $this->getDateAndTimeFromEventTimeZone( $startTime, $event->event_manager);
                $eventStartTime = strtotime( $eventStartTimeForUser );
            }

            $getCurrentTime = $isStartedTime;

            GameIceBreakerScreenTime::updateOrCreate( [ "ibst_event_id" => $event->id, "ibst_team_id" => $teamId ], [ "ibst_awaiting_screen_time" => $getCurrentTime ] );
        } else { 
            $getCurrentTime = $isStartedTime;
        }
        
        /* ] */  

        /*
        * Check current running screen time
        * Move to next screen if time ends
        * Remain here till minimum required user not connected
        * [ 
        */
            
        $runningTime = $this->getEventRunningTime( );
        $gameSettings = $this->getGameSettings( );
        $awaiting_screen_time = $gameSettings->awaiting_screen_time + 4;

        $ffst = $gameSettings->funfacts_screen_time > 0?$gameSettings->funfacts_screen_time:2;
        $ffwst = $gameSettings->funfacts_waiting_screen_time > 0?$gameSettings->funfacts_waiting_screen_time:1;
        $ibgst = $gameSettings->ib_game_screen_time > 0?$gameSettings->ib_game_screen_time:2;
        $ast = $gameSettings->awaiting_screen_time > 0?$gameSettings->awaiting_screen_time:5;

        $totalGameTime = $ffst + $ffwst + $ibgst + $ast;

        if( $runningTime[ 'minutesonly' ] > $totalGameTime - 1 ) { 
            return $this->updateStatusAndmoveToMainGame( $event->id, $teamId, $encryptedId, true );
        }

        $minutes = 00; $seconds = 01;
        $totalUserCount = EventJoin::getJoinEventTeamUsersCount($event->id, $teamId);
        $screenRunningTime = $this->getTimeDifference($getCurrentTime, $cloneCurrentTime);

        if( ( $screenRunningTime[ 'minutesonly' ] >= $awaiting_screen_time && $totalUserCount >= $gameSettings->min_team_size ) || $totalUserCount >= $gameSettings->min_team_size ) { 
            return redirect()->route('front.funfacts',['encryptedId'=>$user->enc_id."-".$event->meeting_token]);
        } elseif( $screenRunningTime[ 'minutesonly' ] < $awaiting_screen_time ) { 
            $minutes = $awaiting_screen_time - ( $screenRunningTime[ 'minutesonly' ] + 1 );
            $seconds = (59 - $screenRunningTime['seconds']);
        }
            //$minutes = 500; $seconds = 01;
        /* ] */
        
        $waitingMessage = "Waiting for other team members to join.";
        $arrNames = array("You");
        //joined user in DB
        $rec = EventJoin::where(["event_id"=>$event->id, "team_id"=>$teamId])->where("user_id","!=",$user->id)->get();
        if(!empty($rec)){
            $x=1;
            foreach ($rec as $value) {
               $usr = User::find($value->user_id);
               $arrNames[$x] = $usr->name;
               $x++;
            }
        }

        $channelId = "event_".$event->id."".$teamId;

        /* User connected to socket */
        $json = json_encode(array('totalUserCount' => $totalUserCount, 'redirectTo' => 'funfacts', "RedirectBit"=>1));

        $redis = LRedis::connection();
        $redis->publish($channelId, $json);

        $title = 'Awaiting Screen To Join Users';

        return view('front.awaitingscreen', 
                    [
                        'title'         =>  $title,
                        'minutes'       =>  $minutes,
                        'seconds'       =>  $seconds,
                        'waitingmessage'=>  $waitingMessage, 
                        'user_id'       =>  $this->encodeId($user->id),
                        'team_id'       =>  $this->encodeId($teamId),
                        'event_id'      =>  $this->encodeId($event->id),
                        "joinedUsers"   =>  $arrNames,
                        "channel_id"    =>  $channelId, 
                        "encryptedId"   =>  $encryptedId,
                        'mainGameUrl'   =>  $mainGameUrl
                    ]
                );

    }

    public function funFacts($encryptedId=NULL){

        $status = $this->checkMeetingTokenValidOrNot($encryptedId);
        
        if( $status != SELF::$MEETING_RUNNING ) { 
            return redirect()->route('invalid')->with(['error'=>$this->getInvalidMeetingRequestErrorMsgs()[ $status ], 'error_title'=>$this->getInvalidMeetingRequestErrorMsgsTitle()[ $status ]]);
        }

        $event = $this->getEvent();
        $user = $this->getUser();
        $userteam = Event::getTeamforEventAndUser($event->id, $user->id);
        $getCurrentTime = $cloneCurrentTime = $this->getServerTime($event->id);

        /*if( $redirect = $this->redirectToScreen( $event, $user, $userteam, 'funfacts' ) ) { 
            return $redirect;
        }*/

        //check for ICE Breaker game status
        $this->moveToMainGame ($event->id, $userteam->team_id, $encryptedId, true);

        /* 
         * Update Join Details if comes directly to FF screen
         * Update Current screen in db
         * Redirect if already passed from this screen [
         */

        $gameDetails = Game::find($event->intro_game);
        $mainGameDetails = Game::find($event->main_game);

        $mainGame = Event::find( $event->id )->game;
        $mainGameUrl = Config::get("constants.mm_url") . '?enc=' . $encryptedId;
        if($mainGame->key == 'escape_room'){
            $mainGameUrl = route('crimeinvestigation.splash' , $encryptedId);
        }

        $eventJoinUserObj = EventJoin::where(["user_id"=>$user->id, "event_id"=>$event->id, "team_id"=>$userteam->team_id]);
        if( $eventJoinUserObj->count() == 0 ) { 
           $data = array("user_id"=>$user->id, "event_id"=>$event->id, "team_id"=>$userteam->team_id, "socket_id"=>""); 
           EventJoin::create($data);
           $eventJoinUserObj = EventJoin::where(["user_id"=>$user->id, "event_id"=>$event->id, "team_id"=>$userteam->team_id]);
        }

        $isStartedTime = GameIceBreakerScreenTime::where(["ibst_event_id"=> $event->id, "ibst_team_id"=> $userteam->team_id])->whereNotNull( 'ibst_fun_facts_screen_time' )->pluck( 'ibst_fun_facts_screen_time' )->first();

        if( !$isStartedTime ){ 
            GameIceBreakerScreenTime::updateOrCreate( [ "ibst_event_id" => $event->id, "ibst_team_id" => $userteam->team_id ], [ "ibst_fun_facts_screen_time" => $getCurrentTime ] );
        } else { 
            $getCurrentTime = $isStartedTime;
        }
        /* ] */ 


        $runningTime = $this->getEventRunningTime( );
        $gameSettings = $this->getGameSettings( );

        $ffst = $gameSettings->funfacts_screen_time > 0?$gameSettings->funfacts_screen_time:2;
        $ffwst = $gameSettings->funfacts_waiting_screen_time > 0?$gameSettings->funfacts_waiting_screen_time:1;

        if($gameDetails->key == "ice_breaker_truth_lie"){
            $ffst = $gameSettings->statement_screen_time > 0?$gameSettings->statement_screen_time:2;
            $ffwst = $gameSettings->statement_waiting_screen_time > 0?$gameSettings->statement_waiting_screen_time:1;
        }

        $totalFFTime = $ffst + $ffwst;
        $totalFFTime = $totalFFTime > 0?$totalFFTime:3;

        $ibgst = $gameSettings->ib_game_screen_time > 0?$gameSettings->ib_game_screen_time:2;
        $ast = $gameSettings->awaiting_screen_time > 0?$gameSettings->awaiting_screen_time:5;

        $totalGameTime = $ffst + $ffwst + $ibgst + $ast;

        if( $runningTime[ 'minutesonly' ] > $totalGameTime - 1 ) { 
            return $this->updateStatusAndmoveToMainGame( $event->id, $userteam->team_id, $encryptedId, true );
        }

        /*$totalUserCount = EventJoin::getJoinEventTeamUsersCount($event->id, $userteam->team_id);

        if( !( ( $runningTime[ 'minutesonly' ] >= $gameSettings->awaiting_screen_time && $totalUserCount >= $gameSettings->min_team_size ) || $totalUserCount >= $gameSettings->min_team_size ) ) { 
            return redirect()->route('front.awaitingscreen',['encryptedId'=>$encryptedId]);
        }*/

        /*
        * Check current running screen time
        * Move to next screen if time ends
        * Remain here till minimum required user not connected
        * [ 
        */
            $totalUserCount = EventJoin::getJoinEventTeamUsersCount($event->id, $userteam->team_id);
            $screenRunningTime = $this->getTimeDifference($getCurrentTime, $cloneCurrentTime);

            if( $screenRunningTime[ 'minutesonly' ] >= $totalFFTime ){ 
                return $this->updateStatusAndmoveToMainGame( $event->id, $userteam->team_id, $encryptedId, true );
            }

            $minutes = 00; $seconds = 01;
            if( $screenRunningTime[ 'minutesonly' ] < $ffst ) { 
                $minutes = $ffst - 1 - $screenRunningTime[ 'minutesonly' ];
                $seconds = (59 - $screenRunningTime['seconds']);
                $runningMinutes = $ffst;
            } elseif( $screenRunningTime[ 'minutesonly' ] < $totalFFTime ) { 
                $minutes = $ffwst - 1;
                $seconds = ( 59 - $screenRunningTime['seconds'] );
                $runningMinutes = $ffwst;
            }
        /* ] */

        /**************************************************************/
        
        $title = 'Fun Facts';

        $savedFunFact = FunFacts::where(['event_id'=>$event->id, 'team_id'=>$userteam->team_id])->groupBy('user_id')->get();
        /* $myFunFacts = FunFacts::where(['event_id'=>$event->id, 'team_id'=>$userteam->team_id, 'user_id' => $user->id])->groupBy('user_id')->get(); */
        $myFunFacts = FunFacts::where(['event_id'=>$event->id, 'team_id'=>$userteam->team_id, 'user_id' => $user->id])->get();
       
       $rec = EventJoin::where(["event_id"=>$event->id, "team_id"=>$userteam->team_id])->where("user_id","!=",$user->id)->get();

        /* if(count($savedFunFact) > 2 && count($myFunFacts) == 1 && $screenRunningTime[ 'minutesonly' ] >= 3){ */
        if( ( count( $savedFunFact ) > 0 && $screenRunningTime[ 'minutesonly' ] >= $totalFFTime ) || ( $savedFunFact->count() == $rec->count() + 1 ) ) {
            return redirect()->route('front.gamescreen',['encryptedId'=>$encryptedId]); 
        }

        $arrNames = array("You");
        
        if(!empty($rec)){
            $x=1;
            foreach ($rec as $value) {
               $usr = User::find($value->user_id);
               $arrNames[$x] = $usr->name;
               $x++;
            }
        }

        $channelId = "event_".$event->id."".$userteam->team_id;
        /*$totalUserCount = EventJoin::getJoinEventTeamUsersCount($event->id, $userteam->team_id);*/

        /*$json = json_encode(array('totalUserCount' => "", 'redirectTo' => 'gamescreen', "RedirectBit"=>""));*/
        $json = json_encode(array('totalUserCount' => $totalUserCount, 'redirectTo' => 'funfacts', "RedirectBit"=>1));
        /* User connected to socket */
        $redis = LRedis::connection();
        $redis->publish($channelId, $json);

        $statement = "Tell us three fun facts about yourselves.";
        $title  =   "Fun Fact";

        if($gameDetails->key == "ice_breaker_truth_lie"){
            $statement = "Please write 3 statements about yourself, and select if each one is a Truth or a Lie.";
            $title  =   "Statement";
        }

       /*$minutes = "02"; $seconds = "00";*/  // For now it is static time
        return view('front.funfacts', [
            'title' => $title,
            'minutes' => $minutes,
            'seconds' => $seconds,
            'runningMinutes' => $runningMinutes,
            'funFactScrrenTime' => $ffst,
            'funFactWaitingScrrenTime' => $ffwst,
            "joinedUsers"=>$arrNames,
            'event_id' => $this->encodeId($event->id), 
            'user_id' => $this->encodeId($user->id),
            'team_id' => $this->encodeId($userteam->team_id),
            "channel_id"=>$channelId,
            "encryptedId"=>$encryptedId,
            'myFunFacts'=>$myFunFacts,
            'intro_game'    =>  $gameDetails->key,
            "statement" =>  $statement,
            "title" =>  $title,
            "introGameTitle" => $gameDetails->name,
            "introGame" =>  $gameDetails,
            "mainGame"  =>  $mainGameDetails,
            'mainGameUrl'   =>  $mainGameUrl
        ]);
    }

    public function saveFunFacts(Request $request){

        $userId = $this->decodeId($request->user_id); 
        $eventId = $this->decodeId($request->event_id);
        $teamId = $this->decodeId($request->team_id);
        $result = FunFacts::where(["user_id"=>$userId, "event_id"=>$eventId, "team_id"=> $teamId])->count();
        $statement1type = ($request->statement1type)? $request->statement1type : 1;
        $statement2type = ($request->statement2type)? $request->statement2type : 1;
        $statement3type = ($request->statement3type)? $request->statement3type : 1;
        if($result==0){
            $data = array(
                ["user_id"=>$userId, "event_id"=>$eventId, "fun_facts"=>$request->funfact1, "team_id"=>$teamId, 'statementtype' => $statement1type, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ["user_id"=>$userId, "event_id"=>$eventId, "fun_facts"=>$request->funfact2, "team_id"=>$teamId, 'statementtype' => $statement2type, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ["user_id"=>$userId, "event_id"=>$eventId, "fun_facts"=>$request->funfact3, "team_id"=>$teamId, 'statementtype' => $statement3type, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
            ); 
            FunFacts::insert($data);


            $channelId = "event_".$eventId."".$teamId;
            $totalUserCount = FunFacts::getFunFactsUsersCount($eventId, $teamId);

            $activeMembers = EventJoin::where(["event_id"=>$eventId, "team_id"=>$teamId])->count();

            $json = json_encode(array('totalUserCount' => $totalUserCount, 'redirectTo' => 'gamescreen', "RedirectBit"=> 2, 'activeMembers' => $activeMembers ) );

            /* User connected to socket */
            $redis = LRedis::connection();
            $redis->publish($channelId, $json);
            /* if($totalUserCount >=3 ){ */
            /*if($totalUserCount >=1 ){
                $event = Event::find($eventId);
                $user = User::find($userId); 
               return redirect()->route('front.gamescreen',['encryptedId'=>$user->enc_id."-".$event->meeting_token]); 
            }*/

            echo json_encode(['message'=>"Your ".(($request->statement1type)? "statement" : "fun facts")." details has been added successfully.", "code"=>200]);  
        }else{
           echo json_encode(['message'=>"You already added the ".(($request->statement1type)? "statement" : "fun facts").".", "code"=>505]);  
        }
    }


    public function gameScreen($encryptedId=NULL){
        
        $status = $this->checkMeetingTokenValidOrNot($encryptedId);
        
        if( $status != SELF::$MEETING_RUNNING ) { 
            return redirect()->route('invalid')->with(['error'=>$this->getInvalidMeetingRequestErrorMsgs()[ $status ], 'error_title'=>$this->getInvalidMeetingRequestErrorMsgsTitle()[ $status ]]);
        }

        $event = $this->getEvent();
        $user = $this->getUser();
        $userteam = Event::getTeamforEventAndUser($event->id, $user->id);
        $getCurrentTime = $cloneCurrentTime = $this->getServerTime($event->id);
        $gameDetails = Game::find($event->intro_game);
        /*if( $redirect = $this->redirectToScreen( $event, $user, $userteam, 'gamescreen' ) ) { 
            return $redirect;
        }*/

        //check for ICE Breaker game status
        $this->moveToMainGame ($event->id, $userteam->team_id, $encryptedId, true);

        /* 
         * Update Join Details if comes directly to FF screen
         * Update Current screen in db
         * Redirect if already passed from this screen [
         */
        $eventJoinUserObj = EventJoin::where(["user_id"=>$user->id, "event_id"=>$event->id, "team_id"=>$userteam->team_id]);
        if( $eventJoinUserObj->count() == 0 ) { 
           $data = array("user_id"=>$user->id, "event_id"=>$event->id, "team_id"=>$userteam->team_id, "socket_id"=>""); 
           EventJoin::create($data);
           $eventJoinUserObj = EventJoin::where(["user_id"=>$user->id, "event_id"=>$event->id, "team_id"=>$userteam->team_id]);
        }

        $isStartedTime = GameIceBreakerScreenTime::where(["ibst_event_id"=> $event->id, "ibst_team_id"=> $userteam->team_id])->whereNotNull( 'ibst_ice_breaker_game_screen_time' )->pluck( 'ibst_ice_breaker_game_screen_time' )->first();
        if( !$isStartedTime ){ 
            GameIceBreakerScreenTime::updateOrCreate( [ "ibst_event_id" => $event->id, "ibst_team_id" => $userteam->team_id ], [ "ibst_ice_breaker_game_screen_time" => $getCurrentTime ] );
        } else { 
            $getCurrentTime = $isStartedTime;
        }

        $gameSettings = $this->getGameSettings( );

        $ib_game_screen_time = $gameSettings->ib_game_screen_time;

        if($gameDetails->key == 'ice_breaker_truth_lie'){
            $ib_game_screen_time = $gameSettings->ib_tl_game_time;
        }

        $ibgst = $ib_game_screen_time > 0?$ib_game_screen_time:2;

        $totalUserCount = EventJoin::getJoinEventTeamUsersCount($event->id, $userteam->team_id);
        $screenRunningTime = $this->getTimeDifference($getCurrentTime, $cloneCurrentTime );

        if( $screenRunningTime[ 'minutesonly' ] >= $ibgst ){ 
            return $this->updateStatusAndmoveToMainGame( $event->id, $userteam->team_id, $encryptedId, true );
        }

        $minutes = 00; $seconds = 01;
        if( $screenRunningTime[ 'minutesonly' ] < $ibgst ) { 
            $minutes = $ibgst - 1 - $screenRunningTime[ 'minutesonly' ];
            $seconds = (59 - $screenRunningTime['seconds']);
        }

        $title = 'Game Screen';

        $question = FunFacts::getQuestions($event->id, $userteam->team_id);

        $options = EventJoin::getOptions($event->id, $userteam->team_id);

        $arrNames = array("You");
        $rec = EventJoin::where(["event_id"=>$event->id])->where("user_id","!=",$user->id)->get();
        if(!empty($rec)){
            $x=1;
            foreach ($rec as $value) {
               $usr = User::find($value->user_id);
               $arrNames[$x] = $usr->name;
               $x++;
            }
        }
        

        $channelId = "event_".$event->id."".$userteam->team_id;
        $totalUserCount = "";

        $json = json_encode(array('totalUserCount' => $totalUserCount, 'redirectTo' => 'gamescreen', "RedirectBit"=>""));
        /* User connected to socket */
        $redis = LRedis::connection();
        $redis->publish($channelId, $json);

        return view('front.gamescreen', [
            'title' => $title,
            'encId' => $encryptedId,
            'minutes' => $minutes,
            'seconds' => $seconds,
            "joinedUsers"=>$arrNames,
            'event_id' => $this->encodeId($event->id), 
            'user_id' => $this->encodeId($user->id), 
            'team_id' => $this->encodeId($userteam->team_id), 
            "channel_id"=>$channelId,
            "introGameTitle" => $gameDetails->name
        ]);
    }

    public function gamescreenajax($encryptedId=NULL)
    {
        //load game settings.
        $gameSettings = $this->getGameSettings();

        $explodeMeetingId = explode("-", $encryptedId);
        $event = Event::where(["meeting_token"=>$explodeMeetingId[1]])->first();
        $user = User::where(["enc_id"=>$explodeMeetingId[0], "status"=>1])->first();
        $userteam = Event::getTeamforEventAndUser($event->id, $user->id);
        
        /*
        * Get Random Question [ 
        */
        // $currentFFId = $event->current_fun_fact_id;
        $currentFF = EventTeam::where(['event_id' => $event->id, 'team_id'=> $userteam->team_id])->first();
        $currentFFId = $currentFF->current_fun_fact_id;

        $gameDetails = Game::find($event->intro_game);

        $single_question_time = $gameSettings->single_question_time;

        if($gameDetails->key == 'ice_breaker_truth_lie'){
            $single_question_time = $gameSettings->ib_tl_single_question_time;
        }

        $needNew = true;
        if( $currentFFId ) { 
            $currentFunFact = FunFacts::find( $currentFFId );
            if( $currentFunFact->status == 1 ) { 
                $needNew = false;
            }
        }

        $pendingCount = FunFacts::getPendingQuestionCount($event->id, $userteam->team_id);
        $pendingCount = ( $pendingCount )?$pendingCount[0]:array();
        if( $needNew === true ) { 
           $question = FunFacts::getRandomQuestion($event->id, $userteam->team_id);
           if($question){
                $question[0]->pending = ( $pendingCount )?$pendingCount->pending:0;
           }           
        } else { 
            $obj = new \stdClass;
            $obj->id = $currentFFId;
            $obj->user_id = $currentFunFact->user_id;
            $obj->fun_facts = $currentFunFact->fun_facts;
            $obj->pending = ( $pendingCount )?$pendingCount->pending:0;
            $question = [$obj];
        }

        $html = ''; $gameminutes = 'x';  $gameseconds = 'x';
        $funfactId = 0;
        if(!empty($question)){

            // remaining game time code
            $serverTime = $this->getUTCTime();
            $funfactDetails = EventTeam::where(['event_id' => $event->id, 'team_id' => $userteam->team_id])->first();
            if(empty($funfactDetails->event_start_game_time)){
                EventTeam::where(['event_id' => $event->id, 'team_id' => $userteam->team_id])
                    ->update([
                        'event_start_game_time' => $serverTime, 
                        'current_fun_fact_id' => $question[0]->id
                    ]);
            }else{
                if($currentFF->current_fun_fact_id!=$question[0]->id){
                    EventTeam::where(['event_id' => $event->id, 'team_id' => $userteam->team_id])
                    ->update([
                        'event_start_game_time' => $serverTime, 
                        'current_fun_fact_id' => $question[0]->id
                    ]);
                }
            }

            $event_game_time = EventTeam::where(['event_id' => $event->id, 'team_id' => $userteam->team_id])->first();
            $startTime = $event_game_time->event_start_game_time;
            $getFirst5MinutesSlot = $this->getTimeDifference($serverTime, $startTime);
            $eventEndTime = strtotime("+".$single_question_time." seconds", $startTime); //+5 minutes in event start time 
            $startEndTimeDiff = $this->getTimeDifference($startTime, $eventEndTime);
            $gameminutes = "00";  $gameseconds = ($startEndTimeDiff['seconds'] - $getFirst5MinutesSlot['seconds']);

            $totalquestions = FunFacts::getQuestionsCount($event->id, $userteam->team_id)[0]->total;
            /*$options = FunFacts::getOptions($user->id, $event->id, $userteam->team_id);*/
            $options = EventJoin::getOptions($event->id, $userteam->team_id);
            $curcount = ($totalquestions - $question[0]->pending) + 1;
            $funfact = $question[0]->fun_facts; $funfactId = $question[0]->id;

            $username = "";
            $tagline = "Guess the team member.";
            if($gameDetails->key != 'ice_breaker'){
                $tagline = "Guess if the statement is truth or a lie.";
                $userId = $question[0]->user_id;
                if($userId){
                    $username = User::find($userId)->name.": ";
                }
            }

            $words = [ 'toughie', 'brainteaser', 'stumper' ];
            $quesTitle = ( $curcount == 1 )?'Ready for some tough questions?':( ( $curcount == 2 )?'How about this mystery...':'How about this ' . $words[ array_rand( $words ) ] . '...' );
        
            $x = 'A';
            /*<!--h6 class="mb-2">Questions '.$curcount.'/'.$totalquestions.'</h6-->*/
            $html .= '<h5 class="mb-0">'.$tagline.'</h5>
                        <div class="ques_quiz mt-0 mb-4">
                            <h6>You can only select one option.</h6>
                         </diV>
                        <div class="ques_quiz">
                        <input type="hidden" name="funfactId" value="'.$this->encodeId($funfactId).'" />
                        <input type="hidden" name="team_id" value="'.$this->encodeId($userteam->team_id).'" />
                        
                          <h6 class="mb-2">'.$quesTitle.'</h6>
                          <h5 class="mb-4">'.$username.$funfact.'</h5>
                            <div class="row">';
                    if($gameDetails->key == 'ice_breaker'){
                        foreach ($options as $value) {
                            $html .= '<div class="col-md-6 form-group"> 
                                      <div class="select_ans">
                                         <input type="checkbox" class="user_options" name="selected_option_userids[]" id="'.$this->encodeId($value->id).'" value="'.$this->encodeId($value->id).'" />
                                         <label for="'.$this->encodeId($value->id).'">
                                           <span>'.$x.'</span>                                    
                                           '.$value->name.'
                                         </label>
                                      </div>
                                  </div>';
                                  $x++;
                        }
                    }else{
                        $html .= '<div class="col-md-6 form-group"> 
                                      <div class="select_ans tru_lie">
                                         <input type="checkbox" class="user_options" name="selected_option_userids[]" id="1" value="'.$this->encodeId('1').'" />
                                         <label for="1">                                   
                                          Truth
                                         </label>
                                      </div>
                                    </div>
                                    <div class="col-md-6 form-group"> 
                                      <div class="select_ans tru_lie">
                                         <input type="checkbox" class="user_options" name="selected_option_userids[]" id="2" value="'.$this->encodeId('2').'" />
                                         <label for="2">                                 
                                          Lie
                                         </label>
                                      </div>
                                    </div>';
                    }

            $html .='</div>';
        }
        echo json_encode( array( "html"=>$html,"gameminutes"=>$gameminutes,"gameseconds"=>$gameseconds, 'funfactId' => $this->encodeId($funfactId) ) );
    }

    public function gamescreensave(REQUEST $request)
    {
        $userId = $this->decodeId($request->user_id);
        $eventId = $this->decodeId($request->event_id);
        $teamId = $this->decodeId($request->team_id);
        $funfactId = $this->decodeId($request->funfactId);

        $event = Event::find($eventId);
        $gameDetails = Game::find($event->intro_game);
        if($request->selected_option_userids){
            $decodearr = array();
            foreach ($request->selected_option_userids as $value) {
                $decodearr[] = $this->decodeId($value);
            }
            
            $selected = implode(',', $decodearr);
            $qdata = FunFacts::where("id",$funfactId)->first();
            $correctAnswer = 0;

            if($gameDetails->key == 'ice_breaker_truth_lie'){
                if($decodearr[0] == $qdata->statementtype){
                    $correctAnswer = 1;
                }
            }else{
                if(in_array($qdata->user_id, $decodearr)) {
                    $correctAnswer = 1;
                } 
            }
            

            $data = array(
                        'fun_fact_id' => $funfactId,
                        'player_id' => $userId,
                        'event_id' => $eventId,
                        'selected_option_userids' => $selected,
                        'correct_answer' => $correctAnswer,
                        'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
                    );
            EventFunFactsAnswers::insert($data);

            // count of team members connected now.
            $totalusersconnected = EventJoin::getJoinEventTeamUsersCount($eventId, $teamId);
            // total answered received against this funfact
            /*$totalansweredmembers = EventFunFactsAnswers::getTotalAnswredCount ($funfactId, $eventId);*/
            $totalansweredmembers = EventFunFactsAnswers::where(["fun_fact_id" => $funfactId, "event_id"=>$eventId])->count();

            $channelId = "event_".$eventId."".$teamId;
            
            if($totalusersconnected == $totalansweredmembers){
                $json = json_encode(array('bit' => '1', 'msg' => 'fetch Answer data'));
                $redis = LRedis::connection();
                $redis->publish($channelId, $json);
            }

            // echo $this->getAnswerHTML($funfactId);
            exit();
        }else{
            echo "Invalid Request.";
        }
    }


    public function getanswerdata(REQUEST $request){

        $gameSettings = $this->getGameSettings();
        $ansTimerminutes = '00'; $ansTimerseconds = $gameSettings->answer_screen_time;

        $funfactId = $this->decodeId($request->funfactId);
        $funfactdata = FunFacts::find($funfactId);

        $event = Event::find($funfactdata->event_id);
        $gameDetails = Game::find($event->intro_game);

        if($gameDetails->key == 'ice_breaker_truth_lie'){
            $ansTimerseconds = $gameSettings->ib_tl_answer_screen_time;
        }
        $answerId = 0;
        if( $request->selection ){
            $answerId = $this->decodeId($request->selection);
        }

        //SET QUESTION AS APPEARED IN FUN FACTS TABLE.
        $this->updateFunFactStatus($funfactId, '2');
        //get correct answer html for fun fact Id
        $html = $this->getAnswerHTML($funfactId, $this->decodeId($request->user_id), $answerId );

        echo json_encode(array("html"=>$html,"ansminuts"=>$ansTimerminutes,"anssecounds"=>$ansTimerseconds, 'funfactId' => $this->encodeId($request->funfactId) ) );
    }


    public function getAnswerHTML ($funfactId, $playerId = 0, $optionId = 0)
    {
        $funfactdata = FunFacts::find($funfactId);
        
        $eventId = $funfactdata->event_id;
        $teamId = $funfactdata->team_id;
        $html = '';
        $event = Event::find($eventId);
        $gameDetails = Game::find($event->intro_game);

        $correct_answer_key = $funfactdata->statementtype;

        $user = User::find($funfactdata->user_id);
        $username = $user->name.": ";

        if($gameDetails->key == 'ice_breaker'){
            
            $options = EventJoin::getOptions($eventId, $teamId);
            $correct_answer_key = $user->id;
        }

        $answerData = EventFunFactsAnswers::where(['fun_fact_id' => $funfactId, 'player_id' => $playerId, 'event_id' => $eventId ])->get();
        // print_r($answerData); die;
        $words = [ 
            'Were you surprised???', 
            'Really???', 
            'OMG!!!', 
            "I can't believe it…", 
            'Very interesting…' 
        ];

        if( $answerData->count() > 0 && $answerData->first()->correct_answer == 1){
            $words = [ 
                'It was so obvious...',
                'Knew it all the time...',
                "It wasn't that difficult…",
                'I had a hunch for it…'
            ];
        }
        // <span>A</span> 
        $question = FunFacts::getQuestions($eventId, $teamId);
        $totalquestions = FunFacts::getQuestionsCount($eventId, $teamId)[0]->total;
        $lastq = 0;
        $curcount = $totalquestions;

        if($question){

            if($totalquestions == $question[0]->pending){
                $curcount = 1;
            }else{
                $curcount = ($totalquestions - $question[0]->pending);
            }

        }else{
            $lastq = 1;
        }
        
        $x = 'A';
        /*<h6 class="mb-2">Questions '.$curcount.'/'.$totalquestions.'</h6>*/
        $html .= '<h5 class="mb-0">Correct answer is:</h5>  
                    <div class="ques_quiz">
                    <h6 class="mb-2">' . $words[ array_rand( $words ) ] . '</h6>
                    <span> </span> 
                    <input type="hidden" name="funfactId" value="'.$this->encodeId($funfactId).'" />
                    <h5 class="mb-4">'.$username.$funfactdata->fun_facts.'</h5>
                    <div class="row">
                    <input type="hidden" id="lastq" name="lastq" value="'.$lastq.'">';
            if($gameDetails->key == 'ice_breaker'){
                foreach ($options as $value) {
                    $html .= '<div class="col-md-6 form-group">
                              <div class="select_ans '.( ($value->id == $correct_answer_key) ? 'correct_ans' : (( $value->id == $optionId ) ? 'wrong_ans' : '') ) .' selected">
                                 <input type="checkbox" class="user_options" name="selected_option_userids[]" id="'.$this->encodeId($value->id).'" value="'.$this->encodeId($value->id).'" disabled />
                                 <label for="'.$this->encodeId($value->id).'">
                                   <span>'.$x.'</span>                                    
                                   '.$value->name.'
                                 </label>
                              </div>
                          </div>';
                          $x++;
                }
            }else{
                $html .='<div class="col-md-6 form-group"> 
                          <div class="select_ans tru_lie '.( ("1" == $correct_answer_key) ? 'correct_ans' : (( "1" == $optionId ) ? 'wrong_ans' : '') ) .' selected">
                             <input type="checkbox" class="user_options" name="selected_option_userids[]" id="1" value="1" disabled />
                             <label for="1" class="wrong_ans">                                   
                              Truth
                             </label>
                          </div>
                        </div>
                        <div class="col-md-6 form-group"> 
                          <div class="select_ans tru_lie '.( ("2" == $correct_answer_key) ? 'correct_ans' : (( "2" == $optionId ) ? 'wrong_ans' : '') ) .' selected">
                             <input type="checkbox" class="user_options" name="selected_option_userids[]" id="2" value="2" disabled />
                             <label for="2">                                 
                              Lie
                             </label>
                          </div>
                        </div>';
                }
        
          $html .= '</div>';
        return $html;
        exit();
    }

    public function usersCountOfJoiny(Request $request){
        $userId = $this->decodeId($request->user_id);
        $teamId = $this->decodeId($request->team_id);
        $eventId = $this->decodeId($request->event_id);
       /* $countRes = EventJoin::where('user_id', '!=' , $userId)->where(["event_id"=> $eventId, "team_id"=> $teamId])->count();
        if($countRes >= 2){
            $eventToken = Event::find($eventId);$userToken = User::find($userId);
            echo json_encode(['encryptedId'=>$userToken->enc_id."-".$eventToken->meeting_token, "code"=>200]);     
        }else{
            echo json_encode(["code"=>0]);     
        }*/
        $eventToken = Event::find($eventId);$userToken = User::find($userId);
        echo json_encode(['encryptedId'=>$userToken->enc_id."-".$eventToken->meeting_token, "code"=>200]);
    }

    public function getJoinedUsers(Request $request)
    {
        $capsneeded = 0;
        $userId = $this->decodeId($request->user_id);$eventId = $this->decodeId($request->event_id);
        $team_id = Event::getTeamforEventAndUser($eventId, $userId)->team_id;
        $arrNames = array("You");
        $rec = EventJoin::where(["event_id"=>$eventId, "team_id" => $team_id])->where("user_id","!=",$userId)->get();
        
        $eventDetails = Event::find( $eventId )->game;
        if( $eventDetails->key == 'market_madness' ){
            $capsneeded = 1; 
        }
        //get all users with emailId under this event and team.
        /*$allMembers = EventTeam::getAllTeamMembers($eventId, $team_id, $userId);*/
        $allMembers = EventTeam::getAllTeamMembers( $eventId, $team_id, '0' );
        $userdetails = User::find($userId);

        $capObj = EventTeam::where( [ 'event_id' => $eventId, 'team_id' => $team_id ] )->select( 'team_members_cap' )->first( );
        if( !$capObj || ( $capObj->count() > 0 && $capObj->team_members_cap == '1' ) ) { 
            $capsArray = [ '1', '2', '3', '4', '5', '6' ];
            shuffle( $capsArray ); 
            EventTeam::where(['event_id' => $eventId, 'team_id' => $team_id])->update(['team_members_cap' => implode( ',', $capsArray )]);
        } else { 
            $capsArray = explode( ',', $capObj->team_members_cap );
        }

        $allUserCaps = [];
        foreach( $allMembers as $index => $currentUser ){
            $allUserCaps[ $currentUser->id ] = $capsArray[ $index ];
        }

        $returnJSON = [];
        $returnJSON[] = [
                        'id' => $this->encodeId( $userId ),
                        'avatar' => asset('assets/front/images/icons/avtar'.$userdetails->avatar.'.png'),
                        'disabled' => 'active',
                        'name' => 'You',
                        'cap' => (isset( $allUserCaps[ $userId ] )?$allUserCaps[ $userId ]:1),
                        'capsneeded'    =>  $capsneeded
                    ];
        /*'<li class="active" id="joinuser_' + id + '"><figure><div id="video_joinuser_' + id + '" class="hidden vd-wrap"><video id="red5pro-publisher" autoplay playsinline></video></div><div id="hide-image"><img id="dark-camera" src="' + avatar + '" border="0" style="display:inline-block;" /><img id="light-camera" src="' + avatar +'" border="0" style="display:none;"" /></div></figure><h6>' + name + '</h6></li>';*/

        if(!empty($allMembers)){
            foreach ($allMembers as $currentIndex => $record) {
                
                if( $record->id == $userId ) continue;

                $username = $record->email;
                $disabled = 'disabled';
                $avatar = 'avtar_non';
                if(!empty($rec)){
                    foreach ($rec as $value) {
                        if($value->user_id == $record->id){
                            $username = $record->name;
                            $disabled = 'active';
                            $avatar = 'avtar'.$record->avatar;
                        }
                    }
                }

                $returnJSON[] = [
                        'id' => $this->encodeId( $record->id ),
                        'avatar' => asset('assets/front/images/icons/'.$avatar.'.png'),
                        'disabled' => $disabled,
                        'name' => $username,
                        'cap' => (isset( $allUserCaps[ $record->id ] )?$allUserCaps[ $record->id ]:1),
                        'capsneeded'    =>  $capsneeded
                    ];
                /*'<li class="' + active +'" id="joinuser_' + id + '"><figure><div id="video_joinuser_' + id + '" class="hidden vd-wrap"></div><div class="hide-image"><img src="' + avatar + '" border="0" style="display:inline-block" /></div></figure><h6>' + name + '</h6></li>';*/
            }
        }
        
        return response()->json( $returnJSON );

    }

    public function saveSocketConnectedUser(Request $request){
        $userId = $this->decodeId($request->user_id); $eventId = $this->decodeId($request->event_id);$teamId = $this->decodeId($request->team_id);  
        $result = EventJoin::where(["user_id"=>$userId, "event_id"=>$eventId, "team_id"=>$teamId])->count();
        if($result==0){
           $data = array("user_id"=>$userId, "team_id"=> $teamId, "event_id"=>$eventId, "socket_id"=>$request->socket_id); 
           EventJoin::create($data);
        }else{
           EventJoin::where(["user_id"=>$userId, "team_id"=> $teamId, "event_id"=>$eventId])->update(['socket_id' => $request->socket_id]); 
        }
    }


    public function removeSocketUser($socketId){
        //echo $socketId ."  Munish Saini";
        $data = EventJoin::where('socket_id', $socketId)->first();
        EventJoin::where('socket_id', $socketId)->delete();
        echo json_encode(array("userId"=>$data['user_id']));
    }

    //set fun fact as apeared for the game..
    public function setquesapeared (REQUEST $request){
        $id = $request->id; $status = 2; $result = '0';
        if($id){
            $id = $this->decodeId($id);
            $result = $this->updateFunFactStatus($id, $status);
        }
        return $result;
    }

    public function updateFunFactStatus($funfactId, $status)
    {
        $funfactDetail = FunFacts::find($funfactId);
        if($funfactDetail){
            $funfactDetail->status = $status;
            $funfactDetail->save();
            return $result = '1';
        }
    }

    public function checkMyFunFactStatus (REQUEST $request){

        $eventId = $this->decodeId($request->eventId);
        $userId = $this->decodeId($request->user_id);
        $teamId = $this->decodeId($request->team_id);

        $getEventUserTimeZone = $this->getEventUserTimeZone($userId);
        $userCurrentTime = $this->getCurrentTimeofTimeZone($getEventUserTimeZone);

        $isStartedTime = GameIceBreakerScreenTime::where(["ibst_event_id"=> $eventId, "ibst_team_id"=> $teamId])->whereNotNull( 'ibst_fun_facts_screen_time' )->pluck( 'ibst_fun_facts_screen_time' )->first();

        $gameSettings = $this->getGameSettings( );

        $ffst = $gameSettings->funfacts_screen_time > 0?$gameSettings->funfacts_screen_time:2;
        $ffwst = $gameSettings->funfacts_waiting_screen_time > 0?$gameSettings->funfacts_waiting_screen_time:1;

        $totalFFTime = $ffst + $ffwst;
        $totalFFTime = $totalFFTime > 0?$totalFFTime:3;

        $minutes = 00; $seconds = 01;
        if( $isStartedTime ){ 
            $cloneCurrentTime = $this->getServerTime( $eventId );
            $screenRunningTime = $this->getTimeDifference($cloneCurrentTime, $isStartedTime);

            if( $screenRunningTime[ 'minutesonly' ] < $totalFFTime ) { 

                $minutes = $totalFFTime - 1 - $screenRunningTime[ 'minutesonly' ];
                $seconds = (59 - $screenRunningTime['seconds']);
                
            }
        }

        $count = FunFacts::where(['event_id' => $eventId, 'user_id'=>$userId, 'team_id' =>$teamId])->count();

        $savedFunFact = FunFacts::where(['event_id'=>$eventId, 'team_id'=>$teamId])->groupBy('user_id')->select(DB::raw('count(user_id) as addedd_user_ff'))->count();

        return response()->json([
                                'count' => $count,
                                'totalSubmittedFF' => $savedFunFact,
                                'm' => $minutes,
                                's' => $seconds,
                                'current_time' => $cloneCurrentTime,
                                'screen_time' => $isStartedTime/*,
                                'event_id' => $eventId,
                                'user_id' => $userId,
                                'team_id' => $teamId,*/
                            ]);
    }
    
    // Ice Breaker status update..
    public function updateIceBreakerStatus (REQUEST $request){
        $eventId = $request->event_id; 
        $teamId = $request->team_id;
        $encId = $request->encId;
        $ib_status = $request->status; 
        $result = '0';
        $url = route('crimeinvestigation.splash', $encId);

        if($eventId && $teamId){
            $eventId = $this->decodeId($eventId);
            $teamId = $this->decodeId($teamId);
            $eteams = EventTeam::where(['event_id' => $eventId, 'team_id' => $teamId])->update(['ib_status' => $ib_status]);
            $eventDetails = Event::find( $eventId )->game;
            if($eventDetails->key == 'market_madness'){
                $url = Config::get("constants.mm_url").'?enc='.$encId;
            }
            $result = 1;
        }
        return array( 'result' => $result, 'url' => $url );
    }

    public function getJoinedteamsForEvent (REQUEST $request){
        /*$return = 0;
        if(isset($request->eventId) && !empty($request->eventId)){
            $eventId = $this->decodeId($request->eventId);

            $return = EventJoin::getEventJoinedTeamsNmembers($eventId)->count();
        }
        return $return;*/


        $eventId = $this->decodeId($request->eventId);
        $teamId = $this->decodeId($request->teamId);
        $userId = $this->decodeId($request->userId);
        
        $eventToken = Event::find($eventId);
        $userToken = User::find($userId);

        $totalUserCount = EventJoin::getJoinEventTeamUsersCount( $eventId, $teamId );
        $gameSettings = $this->getGameSettings( );

        $minTeamForEvent = $gameSettings->min_teams_for_event;
        $minTeamSize = 2; //$gameSettings->min_team_size;

        $joinTeams = EventJoin::getEventJoinedTeamsWithMembers( $eventId, $minTeamSize );
        $totalJoinedTeams = $joinTeams->count();

        if( $totalJoinedTeams >= $minTeamForEvent && $totalUserCount >= $minTeamSize ) { 
            /* User connected to socket */
            $eventTeamsObj = EventJoin::getTeamsWhoJoinedEvents( $eventId );
            if( $eventTeamsObj->count( ) > 0 ) { 
                $eventTeams = $eventTeamsObj->toArray( );
                foreach( $eventTeams as $eventTeam ) { 
                    $channelId = "event_" . $eventId . "" . $eventTeam;

                    $redis = LRedis::connection();
                    $redis->publish( $channelId, json_encode( array( 'mm_redirect' => 1 ) ) );
                }
            }
        }

        return $totalJoinedTeams>0?$totalJoinedTeams:0;

    }

    //check if game ICE Breaker is played already
    public function moveToMainGame ($event_id, $team_id, $encryptedId, $redirectToMain = false){

        $eventDetails   =   Event::find($event_id);
        // $mainGameDetails =  Game::find($eventDetails->main_game);
        // if($mainGameDetails && isset($mainGameDetails->key)){
        $where = [
            'team_id'   =>  $team_id,
            'event_id'  =>  $event_id
        ];
        $eventTeamData = EventTeam::where($where)->first();
        //channel id
        $channelId = "event_" . $event_id . $team_id;
        $mainGmaeStarted = $redirectTo = NULL;

        if( $eventDetails->main_game == 3 ){
            //check Main game started for this event
            $mainGmaeStarted = MmRounds::where(['event_id' => $event_id])->count();
            $redirectTo = 'mmrulesscreen';
            $redirectUrl = Config::get("constants.mm_url").'?enc='.$encryptedId;
            $mainGameRoute = route('front.mmrulesscreen',['encryptedId'=>$encryptedId]);
        }elseif( $eventDetails->main_game == 4 ){
            $gameKey = Event::find( $event_id )->game->key;

            $where['game_key']  =  $gameKey;

            $mainGmaeStarted = MainGameStatus::where($where)->count();
            $redirectTo = 'crimeinvestigation';
            $mainGameRoute = $redirectUrl = route('crimeinvestigation.splash',$encryptedId);
        }

        // $redirectUrl = Config::get("constants.mm_url").'?enc='.$encryptedId;
        $mainGameRoute = route('front.mmrulesscreen',['encryptedId'=>$encryptedId]);
        
        //check Ice Breaker game already done!
        if( ( $eventTeamData && $eventTeamData->ib_status == 2 ) OR $mainGmaeStarted)
        {
            // echo $redirectUrl; die;
            $totalUserCount = EventJoin::getJoinEventTeamUsersCount( $event_id, $team_id );
            
            $json = json_encode(array('totalUserCount' => $totalUserCount, 'redirectTo' => $redirectTo, "RedirectBit"=> 2));
            /* User connected to socket */
            $redis = LRedis::connection();
            $redis->publish($channelId, $json);
            
            // if( $eventDetails->main_game == 3 ){
                return ( $redirectToMain )? redirect($redirectUrl ):redirect($mainGameRoute);
            // }
        }
    }

    //update ICE Breaker is played already and move to mm screen
    public function updateStatusAndmoveToMainGame ( $event_id, $team_id, $encryptedId, $redirectToMain = false )
    {
        EventTeam::where(['event_id' => $event_id, 'team_id' => $team_id])
            ->update([
                'ib_status' => 2
            ]);
        return $this->moveToMainGame( $event_id, $team_id, $encryptedId, $redirectToMain );
    }

    public function getIBstatus (REQUEST $request){
        $eventId = $this->decodeId($request->event_id);
        $teamId = $this->decodeId($request->team_id);
        
        $data = EventTeam::where(['event_id' => $eventId, 'team_id' => $teamId])->get()->first();
        $eventDetails = Event::find( $eventId )->game;
        return response()->json(['status' => $data->ib_status, 'game'   =>  $eventDetails->key ]);
    }

    public function getIntroGameResult (REQUEST $request){
        
        $eventId = $this->decodeId($request->event_id);
        $teamId = $this->decodeId($request->team_id);
        $ansData = FunFacts::getResultScreenData($eventId, $teamId);
        $totalquestions = FunFacts::where(["event_id" => $eventId])->count();
        //default or empty result case html
        $html = '<div class="no_ans_screen">
                    <h4><img src="'.asset('assets/front/images/sad-emoji.png').'" class="img-fluid" alt=""/> Oppss!! Game time over..</h4>
                </div>';

        if($ansData->count() > 1){
            $html = '<ul class="row align-items-center result_screen_ava">';
            if($ansData->count() > 2){
                    $html .= '<li class="col-sm-4">
                    <div class="result_avatars">
                    <span class="hash_tag">#2</span>
                    <div class="score_card row align-items-center">
                    <img src="'.asset('assets/front/images/icons/avtar'.$ansData[1]->avatar.'.png').'" alt="" width="300" class="img-fluid"/>
                    <div class="score_cardss row align-items-center">
                    <span class="score_lable">'.$ansData[1]->correct_ans.'</span>
                    <i class="position_medel"><img src="'.asset('assets/front/images/medel_2.png').'" alt="" width="50" class="img-fluid"/></i>
                    </div>

                    </div>
                    <label class="control-label">'.$ansData[1]->name.'</label>
                    </div>
                    </li>

                    <li class="col-sm-4">
                    <div class="result_avatars">
                    <span class="hash_tag">#1</span>
                    <div class="score_card row align-items-center">
                    <img src="'.asset('assets/front/images/icons/avtar'.$ansData[0]->avatar.'.png').'" alt="" width="300" class="img-fluid"/>
                    <div class="score_cardss row align-items-center">
                    <span class="score_lable">'.$ansData[0]->correct_ans.'</span>
                    <i class="position_medel"><img src="'.asset('assets/front/images/medel_1.png').'" alt="" width="50" class="img-fluid"/></i>
                    </div>

                    </div>
                    <label class="control-label">'.$ansData[0]->name.'</label>
                    </div>
                    </li>

                    <li class="col-sm-4">
                    <div class="result_avatars">
                    <span class="hash_tag">#3</span>
                    <div class="score_card row align-items-center">
                    <img src="'.asset('assets/front/images/icons/avtar'.$ansData[2]->avatar.'.png').'" alt="" width="300" class="img-fluid"/>
                    <div class="score_cardss row align-items-center">
                    <span class="score_lable">'.$ansData[2]->correct_ans.'</span>
                    <i class="position_medel"><img src="'.asset('assets/front/images/medel_3.png').'" alt="" width="50" class="img-fluid"/></i>
                    </div>

                    </div>
                    <label class="control-label">'.$ansData[2]->name.'</label>
                    </div>
                    </li>';
            }else{
                $i=1;
                
                foreach ($ansData as $records) {
                    if($i < 4){
                        $avatar = asset('assets/front/images/icons/avtar'.$records->avatar.'.png');
                        $html .= '<li class="col-sm-4">
                        <div class="result_avatars">
                        <span class="hash_tag">#'.$i.'</span>
                        <div class="score_card row align-items-center">
                        <img src="'.$avatar.'" alt="" width="300" class="img-fluid"/>
                        <div class="score_cardss row align-items-center">
                        <span class="score_lable">'.$records->correct_ans.'</span>
                        <i class="position_medel"><img src="'.asset('assets/front/images/medel_'.$i.'.png').'" alt="" width="50" class="img-fluid"/></i>
                        </div>

                        </div>
                        <label class="control-label">'.$records->name.'</label>
                        </div>
                        </li>';
                    }

                    $i++;
                }
            }
            
            $html .= '</ul>';

            $j = 1;
            if($ansData->count() > 3){
                
                $html .= '<div class="row align-items-center table-responsive mx-0 result_table">
                    <table class="table">
                    <thead>
                    <tr>
                    <th scope="col">Rank</th>
                    <th scope="col"></th>
                    <th scope="col">Name</th>
                    <th scope="col">Right Answer</th>
                    <th scope="col">Wrong Answer</th>
                    <th scope="col">Score</th>
                    </tr>
                    </thead>
                    <tbody>';

                    foreach ($ansData as $record) {
                        if($j > 3){
                            $avatar = asset('assets/front/images/icons/avtar'.$record->avatar.'.png');
                            $html .= '<td scope="row">'.$j.'.</td>
                                <td><i class="tab_ava"><img src="'.$avatar.'" alt="" width="40" class="img-fluid"/></i></td>
                                <td>'.$record->name.'</td>
                                <td class="right_ans">'.$record->correct_ans.'</td>
                                <td class="wrong_ans">'.($totalquestions - $record->correct_ans).'</td>
                                <td>'.$record->correct_ans.'</td>
                                </tr>';
                        }
                        $j++;
                    }
                $html .= '</tbody></table></div>';
            }
        }
        
        return $html;
    }

}//class ends..


/*$countCheck = EventJoin::where(["event_id"=> $eventId, "team_id"=> $teamId, "user_id"=> $userId])->count(); 
if($countCheck==0){
   EventJoin::create(["event_id"=> $eventId, "team_id"=> $teamId, "user_id"=> $userId]);  
}*/
