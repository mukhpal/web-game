<?php

namespace App\Http\Controllers\Admin;


use Auth;
use App\Http\Controllers\Controller;
use App\Models\Admin;
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
    $this->middleware('guest:admin');
  }

  /* get data of admin */  
  public function adminprofile(){
    $title = "Profile"; $admin = session('user_id');
    $profile = Admin::find($admin);
    return view('admin.profile', ['title' => $title, "profile"=> $profile, "breadcrumbItem" => "Profile Settings" , "breadcrumbTitle"=> "Profile Settings" , "breadcrumbTitle2"=> ""]);
  }


  /* Admin profile information updated */
  public function profileupdate(Request $request){

    $adminId = session('user_id');
    $validatedData = $this->validate($request, [
        'fullname' => 'required|regex:/^[0-9a-zA-Z\s]+$/u',
        'email' => 'required|unique:admins,email,' . $adminId
    ]);
   
    $user = Admin::find($adminId);
    $user->name = $request->fullname;
    $user->email = $request->email;
    $user->updated_at = Carbon::now();
    $user->save();

    if($user){
      $request->session()->put('name', $request->fullname);
      return redirect()->route('admin.profile')->with(['success'=>'Profile has been updated successfully.']);
    }else{
      return redirect()->back()->with("error","Error occured while updating profile information.");
    }

  }


  /* Admin update password request handled */
  public function updatepassword(Request $request){

      $adminId = session('user_id');
      $obj_user = Admin::find($adminId);

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
