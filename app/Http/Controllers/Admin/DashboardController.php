<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Http\Controllers\Controller;
use App\Models\EventManagers;
use App\Models\Team;
use App\Models\Event;
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
    $this->middleware('guest:admin');
  }

  

  /* get userlisting  */
  public function dashboard(Request $request){

	$title = "Admin Dashboard";
    $managersCount = EventManagers::count();$teamCount = Team::count();$eventCount = Event::count();
    return view('admin.dashboard.dashboard', ['title' => $title, 'managersCount' => $managersCount,'teamCount'=>$teamCount, 'eventCount' =>$eventCount ,"breadcrumbItem"=>"Dashboard" , "breadcrumbTitle"=>"Dashboard", "breadcrumbTitle2"=>""]);
  }

}
