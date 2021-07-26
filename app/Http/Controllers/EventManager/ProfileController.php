<?php

namespace App\Http\Controllers\EventManager;


use Auth;
use App\Http\Controllers\Controller;
use App\Models\EventManagers;
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

class ProfileController extends Controller{

  public function __construct() {
    $this->middleware('guest:event_manager');
  }

  /* Fetch profile of event manager */  
  public function profile(){
    $title = "Profile"; $eventmanagerid = session('manager_id');
    $profile = EventManagers::find($eventmanagerid);
    return view('eventmanager.profile', ['title' => $title, "profile"=> $profile, "breadcrumbItem" => "Profile Settings" , "breadcrumbTitle"=> ""]);
  }


  /* Event manager profile information updated */
  public function profileupdate(Request $request){

    $eventmanagerid = session('manager_id');
    $rules = [
        'fullname' => 'required|regex:/^[0-9a-zA-Z\s]+$/u',
        'email' => 'required|unique:event_managers,email,'. $eventmanagerid
    ];
    if(!empty($request->companyname)){
      $rules = ['companyname' => 'regex:/^[0-9a-zA-Z\s]+$/u'];
    }
    $validatedData = $this->validate($request, $rules);
   
    $user = EventManagers::find($eventmanagerid);
    $user->name = $request->fullname;
    $user->email = $request->email;
    $user->company_name = $request->companyname;
    $user->updated_at = Carbon::now();
    $user->save();

    if($user){
      $request->session()->put('managername', $request->fullname);
      $request->session()->put('companyname', $request->companyname);
      return redirect()->route('eventmanager.profile')->with(['success'=>'Profile has been updated successfully.']);
    }else{
      return redirect()->back()->with("error","Error occured while updating profile information.");
    }

  }


  /* Event manager update password request handled */
  public function updatepassword(Request $request){

      $eventmanagerid = session('manager_id');
      $obj_user = EventManagers::find($eventmanagerid);

      if (!(Hash::check($request->old_password, $obj_user->password))) {
          // The passwords matches
          return redirect()->back()->with("password_error","Current password is incorrect, please try again.");
      }else if(strcmp($request->old_password, $request->password) == 0){
          //Current password and new password are same
          return redirect()->back()->with("password_error","New Password cannot be same as your current password. Please choose a different password.");
      }else{
          $obj_user->password = \Hash::make($request->password);
          $obj_user->save();   
          return redirect()->back()->with("password_success","Password has been updated successfully.");
      }

  }





}
