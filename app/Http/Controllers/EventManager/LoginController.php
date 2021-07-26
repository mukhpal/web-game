<?php

namespace App\Http\Controllers\EventManager;

use Auth;
use App\Models\EventManagers;
use App\Models\Emails;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\States;
use Session;
use Illuminate\Support\Facades\Redirect;
use Config;
use Mail;
use Hash;

class LoginController extends Controller
{
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
        $this->middleware('guest:event_manager')->except(['loginForm','authenticate','signupForm','forgotPassword','resetPassword','updateForgotPassword']);
    }


    /**
     * Show the application normal login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function loginForm()
    {
        $user_id = session('user_id');$user_type = session('user_type');
        if(!empty($user_id) && $user_type=='event_manager'){
           return redirect()->route('eventmanager.dashboard'); 
        }

        $title = 'Login';
        return view('eventmanager.login', [
            'title' => $title
        ]);
    }


    /**
     * Login user in the application
     *
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request){
        $request_data = $request->all();

        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];
        
        //print_r($request_data);exit;
        $customMessages = $rules = [];

        if(env('GOOGLE_RECAPTCHA_KEY')){ 
          $rules[ 'g-recaptcha-response' ] = 'required|recaptcha';
          $customMessages[ 'g-recaptcha-response.recaptcha' ] = 'Something went wrong with captcha selection, please recheck and submit again.';
          $customMessages[ 'g-recaptcha-response.required' ] = 'Capctha field is required.';
        }
        
        $validatedData = $this->validate($request, $rules, $customMessages);

        if(Auth::guard('event_manager')->attempt(['email' => $request->email, 'password' => $request->password, 'approved'=> 0])) {
            Auth::guard('event_manager')->logout();
            $request->session()->flush(); // this method should be called after we ensure that there is no logged in guards left
            $request->session()->regenerate();
            return redirect()->route('eventmanager.login')->with('error','Your account has not been approved by the admin yet. You will be notified, once it is approved.');
        }elseif(Auth::guard('event_manager')->attempt(['email' => $request->email, 'password' => $request->password, 'status'=> 0])) {
            Auth::guard('event_manager')->logout();
            $request->session()->flush(); // this method should be called after we ensure that there is no logged in guards left
            $request->session()->regenerate();
            return redirect()->route('eventmanager.login')->with('error','Your account is not approved yet.');
        }else{
            /** $user */
            $user = Auth::guard('event_manager')->attempt(['email' => $request->email, 'password' => $request->password, 'status'=> 1]);
            if($user) {
                $user = EventManagers::where(['email' => $request->email])->first();
                
                $request->session()->put('manager_id', $user->id);
                $request->session()->put('user_type', 'event_manager');
                $request->session()->put('managername', $user->name);
                $request->session()->put('companyname', $user->company_name);
                $request->session()->put('manager_timezone', States::getTimezone(session('manager_id'), 'manager')->timezone);

                return redirect()->route('eventmanager.dashboard');
            }else {
                return redirect()->route('eventmanager.login')->with('error','Invalid username or password.')->withInput();
            } 
        }
    }


    public function forgotPassword(Request $request){
        $user = EventManagers::where(['email' => $request->forgot_email])->first();
        $forgot_email_template = Emails::where(['email_slug' => 'forgot_password'])->first(); // We are using slugs to get data of a paricular email content.

        if($user){
            $forgotToken = str_random(20);
            $userUpdate = EventManagers::where('email', $request->forgot_email)->update(['forgotToken' => $forgotToken, 'updated_at' => Carbon::now()]);
           
            $emailTemplateDecode = html_entity_decode($forgot_email_template['email_template']);
            $email_body = str_replace("##name##", $user['name'], $emailTemplateDecode);

            $email_body = str_replace("##verification_code##", url('/event_manager/resetPassword/').'/'.$forgotToken, $email_body);

            $email_body = str_replace("##logopath##", url('/').'/assets/front/images/email/logo.png', $email_body);

            $to = $request->forgot_email; $subject = $forgot_email_template['subject'];
            Mail::send([], [], function($message) use($to, $subject, $email_body) {
                $message->setBody($email_body, 'text/html');
                $message->from('frimusfb@gmail.com', 'Office-Campfire');
                $message->to($to);
                $message->subject($subject);
            });

            return redirect()->route('eventmanager.login')->with(['flipped_class'=>'flipped','forgot_success'=>'Reset password link sent.']);
        }else{
            return redirect()->route('eventmanager.login')->with(['flipped_class'=>'flipped','forgot_error'=>'Email id does not exist.']);
        }
    }


    //Hash::make($data['password'])
    /*
     * function to show reset password view
     */
    public function resetPassword(Request $request, $token)
    {
        $request->session()->put('token', $token);
        $title = 'Reset Password';
        return view('eventmanager.resetPassword', [
            'title' => $title
        ]);
    }



    /*
     * function to reset password
     * parameters : new_password , token
     */
    public function updateForgotPassword(Request $request)
    {
        $token = $request->session()->get('token');

        $validatedData = $this->validate($request, [
            'password' => 'required|min:6|required_with:cpassword|same:cpassword',
            'cpassword' => 'min:6'
        ]);


        $chkUser = EventManagers::where('forgotToken', $token)->first();
        //dd($chkUser);

        if($chkUser) {
            $passwordUpdate = EventManagers::where('id', $chkUser->id)->update(['password' => Hash::make($request->password), 'forgotToken' => '', 'updated_at' => Carbon::now()]);
            if ($passwordUpdate) {
                // Redirect admin to dashboard page after successfully update password
                $user = Auth::guard('event_manager')->attempt(['email' => $chkUser->email, 'password' => $request->password]); 
                $request->session()->put('manager_id', $chkUser->id);$request->session()->put('user_type', 'event_manager');
                $request->session()->put('managername', $chkUser->name);$request->session()->put('companyname', $chkUser->company_name);
                return redirect()->route('eventmanager.dashboard');

               //return redirect()->route('eventmanager.resetpassword',[$token])->with(['success'=>'Success']);
            } else {
                return redirect()->route('eventmanager.resetpassword',[$token])->with(['error'=>'Error occured while updating password.']);
            }
        } else {
            return redirect()->route('eventmanager.resetpassword',[$token])->with(['error'=>'Update password link has been expired.']);
        }

    }



    public function logout(Request $request){
        Auth::guard('event_manager')->logout();
        $request->session()->forget('manager_id');$request->session()->forget('user_type');
        $request->session()->forget('managername');$request->session()->forget('companyname');
        /*$request->session()->flush(); // this method should be called after we ensure that there is no logged in guards left
        $request->session()->regenerate(); //same */
        return Redirect::route('eventmanager.login');
    }



}
