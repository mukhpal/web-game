<?php

namespace App\Http\Controllers\EventManager;

use Auth;
use App\Http\Controllers\Controller;
use App\Models\Survey;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Middleware\RedirectIfAuthenticated;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Config;
use xmlapi;
use Hash;
use Carbon\Carbon;
use App\Http\Controllers\EventManager\CommonController;
use Illuminate\Support\Facades\URL;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller{

  public function __construct() {
    $this->middleware('guest:event_manager');
  }

  /* get Survey listing  */
    
  public function surveyListing(Request $request){

    $title = "Survey Listing";
    return view('eventmanager.survey', ['title' => $title, "breadcrumbItem" => "Survey Listing" , "breadcrumbTitle"=>"Survey Listing", "breadcrumbLink" => "", "breadcrumbTitle2"=>""]);
  }

    /** Fetch users data of logged in event manager **/
  public function ajaxDataLoad(Request $request){
    // print_r($_GET); die;
    $eventmanager = session('manager_id');

    $draw = $_GET['draw'];
    $row = $_GET['start'];
    $rowperpage = $_GET['length']; // Rows display per page
    $columnIndex = $_GET['order'][0]['column']; // Column index
    $columnName = $_GET['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $_GET['order'][0]['dir']; // asc or desc
    $searchValue = $_GET['search']['value']; // Search value

    $columns = [
        0 => 'u.name',
        1 => 'e.name',
        2 => 'e.start_date',
        3 => 't.name',
        4 => 's.rating',
        5 => 's.survey'
    ];
    $columnName = $columns[$columnIndex];

    ## Search 
    $searchQuery = " 1=1 ";
    if($searchValue != ''){
       $searchQuery .= " and (u.name like '%".$searchValue."%' or t.name like '%".$searchValue."%' or s.survey like '%".$searchValue."%' or e.name like '%".$searchValue."%') ";
    }
    $totalRecords = DB::table('survey as s')
            ->select(DB::raw('s.id,u.name as user_name,t.name as team_name,s.rating,s.survey'))
            ->join('users as u', 'u.id', '=', 's.user_id')
            ->join('teams as t', 't.id', '=', 's.team_id')
            ->join('events as e', 'e.id', '=', 's.event_id')
            ->where('e.event_manager', $eventmanager)
            ->count();

    $totalRecordwithFilter = DB::table('survey as s')
            ->select(DB::raw('s.id,u.name as user_name,t.name as team_name,s.rating,s.survey'))
            ->join('users as u', 'u.id', '=', 's.user_id')
            ->join('teams as t', 't.id', '=', 's.team_id')
            ->join('events as e', 'e.id', '=', 's.event_id')
            ->where('e.event_manager', $eventmanager)
            ->whereRaw($searchQuery)
            ->count();

    $survetList = DB::table('survey as s')
            ->select(DB::raw('s.id,u.name as user_name,t.name as team_name,s.rating,s.survey,e.name as event_name,e.start_date'))
            ->join('users as u', 'u.id', '=', 's.user_id')
            ->join('teams as t', 't.id', '=', 's.team_id')
            ->join('events as e', 'e.id', '=', 's.event_id')
            ->where('e.event_manager', $eventmanager)
            ->whereRaw($searchQuery)
            ->orderBy($columnName, $columnSortOrder)->skip($row)->take($rowperpage)
            ->get();


    $checkbox = ""; $data = array(); $action = "";
    if(!empty($survetList)){
        foreach($survetList as $survey){
           $data[] = array( 
              $survey->user_name,
              $survey->event_name,
              date("d M, Y", strtotime($survey->start_date)),
              $survey->team_name,
              $survey->rating,
              $survey->survey
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
