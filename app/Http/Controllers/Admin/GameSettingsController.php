<?php

namespace App\Http\Controllers\Admin;


use Auth;
use App\Http\Controllers\Controller;
use App\Models\GameSettings;
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
use Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class GameSettingsController extends Controller{

  public function __construct() {
    $this->middleware('guest:admin');
  }

  /* get data of admin */  
  public function settings(){
    $title = "Game Settings"; 
    $settings = GameSettings::find('1'); // There is only one record in this table always with id 1
    return view('admin.settings', ['title' => $title, "settings"=> $settings, "breadcrumbItem" => "Game Settings" , "breadcrumbTitle"=> "Game Settings" , "breadcrumbTitle2"=> ""]);
  }


  /* Game settings add and updated */
  public function settingsUpdate(Request $request){

    $validatedData = $this->validate($request, [
        'gametime' => 'required|regex:/^[0-9\s]+$/u|min:10|numeric',
        
        'funfacts_screen_time' => 'required|regex:/^[0-9\s]+$/u|min:1|numeric',
        'funfacts_waiting_screen_time' => 'required|regex:/^[0-9\s]+$/u|min:1|numeric',

        'statement_screen_time' => 'required|regex:/^[0-9\s]+$/u|min:1|numeric',
        'statement_waiting_screen_time' => 'required|regex:/^[0-9\s]+$/u|min:1|numeric',

        'awaintingscreentime' => 'required|regex:/^[0-9\s]+$/u|min:2|numeric',
        'teamsize' => 'required|regex:/^[0-9\s]+$/u|min:3|numeric',
        'min_team_size' => 'required|regex:/^[0-9\s]+$/u|min:3|numeric',
        //Ice Breaker
        'ib_game_screen_time' => 'required|regex:/^[0-9\s]+$/u|min:1|numeric',
        'single_question_time' => 'required|regex:/^[0-9\s]+$/u|min:9|numeric',
        'answer_screen_time' => 'required|regex:/^[0-9\s]+$/u|min:3|numeric',
        //Ice Breaker Truth and lie
        'ib_tl_game_time' => 'required|regex:/^[0-9\s]+$/u|min:1|numeric',
        'ib_tl_single_question_time' => 'required|regex:/^[0-9\s]+$/u|min:9|numeric',
        'ib_tl_answer_screen_time' => 'required|regex:/^[0-9\s]+$/u|min:3|numeric',
        
        'min_teams_for_event' => 'required|regex:/^[0-9\s]+$/u|min:1|numeric',
        'team_cash' => 'required|regex:/^[0-9\s]+$/u|min:1|numeric',
        'round_team_cash' => 'required|regex:/^[0-9\s]+$/u|min:1|numeric',
        //added on 11-october-2019
        'forecasting_charge' => 'required|min:1|numeric',

        'max_loss_profit_limit' => 'required|regex:/^[0-9\s]+$/u|min:1|numeric',
        'market_demond' => 'required|regex:/^[0-9\s]+$/u|min:1|numeric',
        'market_cost' => 'required|regex:/^[0-9\s]+$/u|min:1|numeric',
        'foreign_production_amount' => 'required',
        //added on 15-October-2019
        'total_rounds' => 'required',
        /*'chance_in_round' => 'required',*/
        'chance_time' => 'required',
        /*'chance_result_time' => 'required',*/
        'round_results_time' => 'required',
    ]);
   
    $setting = GameSettings::find('1'); // We will add single entry in this table, so that the update query will execute always
    $setting->game_time = $request->gametime;
    
    $setting->funfacts_screen_time = $request->funfacts_screen_time;
    $setting->funfacts_waiting_screen_time = $request->funfacts_waiting_screen_time;

    $setting->statement_screen_time = $request->statement_screen_time;
    $setting->statement_waiting_screen_time = $request->statement_waiting_screen_time;

    $setting->awaiting_screen_time = $request->awaintingscreentime;
    $setting->team_size = $request->teamsize;
    $setting->min_team_size = $request->min_team_size;
    //Ice Breaker
    $setting->ib_game_screen_time = $request->ib_game_screen_time;
    $setting->single_question_time = $request->single_question_time;
    $setting->answer_screen_time = $request->answer_screen_time;
    //Ice Breaker Truth and lie
    $setting->ib_tl_game_time = $request->ib_tl_game_time;
    $setting->ib_tl_single_question_time = $request->ib_tl_single_question_time;
    $setting->ib_tl_answer_screen_time = $request->ib_tl_answer_screen_time;
    
    $setting->min_teams_for_event = $request->min_teams_for_event;
    $setting->team_cash = $request->team_cash;
    $setting->round_team_cash = $request->round_team_cash;
    //Added on 11-october-2019
    $setting->forecasting_charge = $request->forecasting_charge;
    $setting->max_loss_profit_limit = $request->max_loss_profit_limit;
    $setting->market_demond = $request->market_demond;
    $setting->market_cost = $request->market_cost;
    $setting->foreign_production_amount = $request->foreign_production_amount;
    //added on 15-October-2019
    $setting->total_rounds = $request->total_rounds;
    /*$setting->chance_in_round = $request->chance_in_round;*/
    $setting->chance_time = $request->chance_time;
    // $setting->chance_result_time = $request->chance_result_time;
    $setting->chance_result_time = $request->round_results_time;
    $setting->round_results_time = $request->round_results_time;
    
    $setting->updated_at = Carbon::now();
    $setting->save();

    if($setting){
      return redirect()->route('admin.settings')->with(['success'=>'Game settings has been updated successfully.']);
    }else{
      return redirect()->back()->with("error","Error occured while updating game settings.");
    }

  }


}
