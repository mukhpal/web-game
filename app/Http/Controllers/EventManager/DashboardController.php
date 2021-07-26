<?php

namespace App\Http\Controllers\EventManager;

use Auth;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Team;
use App\Models\User;
use App\Models\UserParents;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Http\Middleware\RedirectIfAuthenticated;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Input;
use Config;
use xmlapi;


class DashboardController extends Controller{

  public function __construct() {
    $this->middleware('guest:event_manager');
  }

  
  /* get userlisting  */
  public function dashboard(Request $request){
    $title = "Event Manager Dashboard";
    $events = Event::where(["event_manager" => session('manager_id')])->get();
    $eventCount = $events->count();

    $teams = Team::where(["event_manager" => session('manager_id')])->get();
    $teamCount = $teams->count();

    $users = UserParents::where(["event_manager" => session('manager_id')])->get();
    $userCount = $users->count();

    return view('eventmanager.dashboard.dashboard', ['title' => $title, 'eventsCount' => $eventCount, "teamCount" => $teamCount, "userCount" => $userCount,"breadcrumbItem"=>"Dashboard" , "breadcrumbTitle"=>""]);
  }

  public function eventsListing ()
  {
    $curtime = date('Y-m-d');
    $eventmanager = session('manager_id');
    $events = Event::where(["event_manager" => session('manager_id')])->whereRaw('start_date >= CURDATE()')->get();

    $data = array();
    if($events){
      foreach ($events as $row) {
        $data[] = array(
          'id'   => $row["id"],
          'title'   => $row["name"],
          'start'   => date('Y-m-d H:i:s', $row['start_time']),
          'end'   => date('Y-m-d H:i:s', $row['end_time']),
         );
      }
    }

    echo json_encode($data);
  }

}
