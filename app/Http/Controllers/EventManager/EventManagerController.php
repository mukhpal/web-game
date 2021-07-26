<?php

namespace App\Http\Controllers\EventManager;

use Auth;
use App\Models\EventManagers;
use App\Models\Countries;
use App\Models\States;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Redirect;
use Config;
use Mail;
use Hash;
use App\Http\Traits\CommonMethods;
use App\Models\Emails;

class EventManagerController extends Controller
{
    use CommonMethods;
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:event_manager')->except(['signupForm','register','verifyAccount','loadStates']);
    }



    /**
    Event manager signup form view
    **/
    public function signupForm(){
        $user_id = session('manager_id');$user_type = session('user_type');
        if(!empty($user_id) && $user_type=='event_manager'){
           return redirect()->route('eventmanager.dashboard'); 
        }

        $title = 'Event Manager Signup';
        $countries = Countries::all();
        return view('eventmanager.signup', [
            'title' => $title,
            'countries' => $countries,
        ]);
    }


    /**
    Registeration process of event manager
    **/
    public function register(Request $request){ 

        $rules = [
            'fullname' => 'required|regex:/^[0-9a-zA-Z\s]+$/u',
            'companyname' => 'required|regex:/^[0-9a-zA-Z\s]+$/u',
            'email' => 'required|unique:event_managers,email',
            'password' => 'required|min:6',
            'country' => 'required',
            'state' => 'required'
        ];

        $customMessages = [];

        if(env('GOOGLE_RECAPTCHA_KEY')){ 
          $rules[ 'g-recaptcha-response' ] = 'required|recaptcha';
          $customMessages[ 'g-recaptcha-response.recaptcha' ] = 'Something went wrong with captcha selection, please recheck and submit again.';
          $customMessages[ 'g-recaptcha-response.required' ] = 'Capctha field is required.';
        }


        $validatedData = $this->validate($request, $rules, $customMessages);

        $verifyToken = str_random(20);
        $details = array(
          "name" => $request->fullname,
          "company_name" => $request->companyname,
          "email" => $request->email,
          "password" => Hash::make($request->password),
          "verify_token" => $verifyToken,
          "country_id" => $this->decodeId($request->country),
          "state_id" => $this->decodeId($request->state)
        );

        $user = EventManagers::create($details); 
        if($user){

            /*** Email content here ****/
            $signup_email = Emails::where(['email_slug' => 'verify_email'])->first();

            $emailTemplateDecode = html_entity_decode($signup_email['email_template']);
            $email_body = str_replace("##name##", $request->fullname, $emailTemplateDecode);
            $email_body = str_replace("##verification_code##", url('/event_manager/accountVerify/').'/'.$verifyToken, $email_body);
            $email_body = str_replace("##logopath##", url('/').'/assets/front/images/email/logo.png', $email_body);

            $emailParams = array("to"=>$request->email, "subject"=>$signup_email['subject'], "content"=>$email_body);
            //Method to send email
            $this->sendEmail($emailParams);

          /*Auth::guard('event_manager')->login($user);
          $request->session()->put('manager_id', $user->id);$request->session()->put('user_type', 'event_manager');
          $request->session()->put('name', $user->name);*/
          return redirect()->route('eventmanager.login')->with(['forgot_success'=>'Verification link has been sent to your email id.']);
        }else{
          return redirect()->route('eventmanager.signup')->with(['error'=>'Error occured while register event manager.']);
        }
    }



    public function verifyAccount($verifyToken=NULL){
      $data = EventManagers::where(["verify_token" => $verifyToken])->first(); 
      if($data['status']==0){
          
            EventManagers::where(["verify_token" => $verifyToken])->update(["status"=>1]); 
          
          /*Email to event manager and admin for sign up infor*/

            $new_manager_signup = Emails::where(['email_slug' => 'new_manager_signup'])->first();

            $m_emailTemplateDecode = html_entity_decode($new_manager_signup['email_template']);
            $m_email_body = str_replace("##manager_name##", $data->name, $m_emailTemplateDecode);
            $m_email_body = str_replace("##manager_email##", $data->email, $m_email_body);
            $m_email_body = str_replace("##manager_company##", $data->company_name, $m_email_body);
            $m_email_body = str_replace("##logopath##", url('/').'/assets/front/images/email/logo.png', $m_email_body);

            $admin_email = 'varunj2905@gmail.com';
            $m_emailParams = array("to"=>$admin_email, "subject"=>$new_manager_signup['subject'], "content"=>$m_email_body);
            //send mail to admin

            $this->sendEmail($m_emailParams);

            // $account_approval = Emails::where(['email_slug' => 'account_approval'])->first(); 
            // $a_email_body = html_entity_decode($account_approval['email_template']);
            // $a_email_body = str_replace("##manager##", $data->name, $a_email_body);
            // $a_emailParams = array("to"=>$data->email, "subject"=>$account_approval['subject'], "content"=>$a_email_body);
            // $a_emailParams = str_replace("##logopath##", url('/').'/assets/front/images/email/logo.png', $a_emailParams);
            //Method to send email
            //send mail to manager
            // $this->sendEmail($a_emailParams);
          /*end here*/

          return redirect()->route('eventmanager.login')->with(['forgot_success'=>'Your account is verified successfully. Please login.']);
      }else{
          return redirect()->route('eventmanager.login')->with(['error'=>'Link has been expired.']);
      }

    }

    public function loadStates ($countryId, $stateId){

      $countryId = $this->decodeId($countryId);

      if($stateId){
        $stateId = $this->decodeId($stateId);
      }

      $data = States::where( ["country_id" => $countryId] )->get();

      $option = "";
      if($data){
        foreach ($data as $state) {
          $option .= '<option '.(($stateId == $state['id'])? 'selected':'').' value="'.$this->encodeId($state['id']).'">'.$state['name'].'</option>';
        }
      }
      return $option;
    }


}
