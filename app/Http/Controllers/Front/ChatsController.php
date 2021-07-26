<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserTeam;
use App\Models\Team;
use App\Models\Event;
use App\Models\EventJoin;
use App\Http\Controllers\Controller;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Traits\CommonMethods;
use Hash;
use LRedis;
use \Config;


class ChatsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Chat Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles users chat messages for the game.
    |
    */
    use CommonMethods;
    use AuthenticatesUsers;

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
    *   Save chat messages
    **/
    public function saveMessage (Request $request)
    {
    	$rules = [
            'enc_id'	=>	'required',
            'message'	=>	'required',
            'chat_box'	=>	'required'
        ];

        $status = $this->checkMeetingTokenValidOrNot($request->enc_id);
        
        if( $status != SELF::$MEETING_RUNNING ) { 
            return redirect()->route('invalid')->with(['error'=>$this->getInvalidMeetingRequestErrorMsgs()[ $status ], 'error_title'=>$this->getInvalidMeetingRequestErrorMsgsTitle()[ $status ]]);
        }

        $eventId =$this->getEvent()->id;
        $users = $this->getUser();
        $userId = $users->id;
        $userteam = $users->userteam()->first();
        $teamId = Event::getTeamforEventAndUser($eventId, $userId)->team_id;

        $customMessages = [];

        $validatedData = $this->validate($request, $rules, $customMessages);

        $details = array(
        	'user_id'	=>	$userId,
            'team_id'	=>	$teamId,
            'event_id'	=>	$eventId,
            'message'	=>	trim($request->message),
            'chat_box'	=>	$request->chat_box,
        );

        if( $details ){

        	$channelId = "event_".$eventId;

        	$user = User::find($userId);
            $username   = $user->name." ( ".Team::find($teamId)->name. " )";

        	if( $details['chat_box'] == 1) {
        		$channelId 	.= 	$teamId;
                $username = $user->name;
        	}

            /* Chat message JSON */
            $json = json_encode(
            			array(
            				'chatmessage'	=>	true,
            				'username' 		=>	$username,
                            'sender'        =>  $this->encodeId($user->id),
            				'message'		=>	$details['message'],
                            'chat_box'      =>  $details['chat_box'],
                            'avatar'        =>  asset('assets/front/images/icons/avtar'.$user->avatar.'.png')
            			)
            		);

            $this->publishData($json, $details['event_id'], $details['team_id'], $details['chat_box']);

            return $json;
        }
    }

    public function publishData ($data, $eventId, $teamId, $type = 1){
        //Socket connection
        $redis = LRedis::connection();
        //encode data in JSON
        if($type == 1){
            $channelId = "event_".$eventId.$teamId;
            $redis->publish( $channelId, $data );
        }else{
            $activeTeams = EventJoin::getActiveTeamsForChat($eventId);
            //publish data for all active teams
            foreach ($activeTeams as $teams) {
                //credit initial cash to teams
                $channelId = "event_".$eventId.$teams->team_id;
                $redis->publish( $channelId, $data );
            }
        }
        
    }
}
