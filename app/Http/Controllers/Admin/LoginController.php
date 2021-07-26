<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\Admin;
use App\Models\Emails;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
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
        $this->middleware('guest:admin')->except(['loginForm','authenticate','admin_forgot_password','showResetPassword','updatePassword' ]);
    }


    /**
     * Show the application normal login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function loginForm()
    {
        $user_id = session('user_id');$user_type = session('user_type');
        if(!empty($user_id) && $user_type=='admin'){
           return redirect('/admin/dashboard'); 
        }

        $title = 'Login';
        return view('admin.login', [
            'title' => $title
        ]);
    }


    /**
     * Login user in the application
     *
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $request_data = $request->all();

        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];

        $customMessages = $rules = [];

        if(env('GOOGLE_RECAPTCHA_KEY')){ 
          $rules[ 'g-recaptcha-response' ] = 'required|recaptcha';
          $customMessages[ 'g-recaptcha-response.recaptcha' ] = 'Something went wrong with captcha selection, please recheck and submit again.';
          $customMessages[ 'g-recaptcha-response.required' ] = 'Capctha field is required.';
        }
        
        $validatedData = $this->validate($request, $rules, $customMessages);

        //print_r($request_data);exit;

        // $validatedData = $this->validate($request, [
        //     'email' => 'required|email',
        //     'password' => 'required|min:6',
        // ]);

        /** $user */
        $user = Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password]);  

        if ($user) {
            $user = Admin::where(['email' => $request->email])->first();
            $request->session()->put('user_id', $user->id);$request->session()->put('user_type', 'admin');
            $request->session()->put('name', $user->name);
            return redirect()->route('admin.dashboard');
        }else {
            return redirect()->route('admin.login')->with('error','Invalid username or password.')->withInput();
        } 
    }


    public function admin_forgot_password(Request $request)
    {
        $user = Admin::where(['email' => $request->forgot_email])->first();
        $forgot_email_template = Emails::where(['email_slug' => 'forgot_password'])->first();

        if($user){
            $forgotToken = str_random(20);
            $userUpdate = Admin::where('email', $request->forgot_email)->update(['forgotToken' => $forgotToken, 'updated_at' => Carbon::now()]);
           
            $emailTemplateDecode = html_entity_decode($forgot_email_template['email_template']);
            $email_body = str_replace("##name##", $user['name'], $emailTemplateDecode);
            $email_body = str_replace("##verification_code##", $forgotToken, $email_body);
            $email_body = str_replace("##module##", "admin", $email_body);
            

            /*echo $email_body;
            exit;*/

            $to = $request->forgot_email; $subject = $forgot_email_template['subject'];
            Mail::send([], [], function($message) use($to, $subject, $email_body) {
                $message->setBody($email_body, 'text/html');
                $message->from('frimusfb@gmail.com', 'Office-Campfire');
                $message->to($to);
                $message->subject($subject);
            });

            return redirect()->route('admin.login')->with(['flipped_class'=>'flipped','forgot_success'=>'Reset password link sent.']);
        }else{
            return redirect()->route('admin.login')->with(['flipped_class'=>'flipped','forgot_error'=>'Email id does not exist.']);
        }


    }


    //Hash::make($data['password'])
    /*
     * function to show reset password view
     */
    public function showResetPassword(Request $request, $token)
    {
        $request->session()->put('token', $token);
        $title = 'Reset Password';
        return view('admin.resetPassword', [
            'title' => $title
        ]);
    }



    /*
     * function to reset password
     * parameters : new_password , token
     */
    public function updatePassword(Request $request)
    {
        $token = $request->session()->get('token');

        $validatedData = $this->validate($request, [
            'password' => 'required|min:6|required_with:cpassword|same:cpassword',
            'cpassword' => 'min:6'
        ]);


        $chkUser = Admin::where('forgotToken', $token)->first();
        //dd($chkUser);

        if($chkUser) {
            $passwordUpdate = Admin::where('id', $chkUser->id)->update(['password' => Hash::make($request->password), 'forgotToken' => '', 'updated_at' => Carbon::now()]);
            if($passwordUpdate) {
                // Redirect admin to dashboard page after successfully update password
                $user = Auth::guard('admin')->attempt(['email' => $chkUser->email, 'password' => $request->password]); 
                $request->session()->put('user_id', $chkUser->id);$request->session()->put('user_type', 'admin');
                $request->session()->put('name', $chkUser->name);
                return redirect()->route('admin.dashboard');

            } else {
               return redirect()->route('admin.resetpassword',[$token])->with(['error'=>'Error occured while updating password.']);
            }
        } else {
            return redirect()->route('admin.resetpassword',[$token])->with(['error'=>'Update password link has been expired.']);
        }

    }



    public function logout(Request $request){
        Auth::guard('admin')->logout();
        //$request->session()->flush(); // this method should be called after we ensure that there is no logged in guards left
        //$request->session()->regenerate(); //same 
        $request->session()->forget('manager_id'); $request->session()->forget('user_type');
        $request->session()->forget('name');
        return Redirect::route('admin.login');
    }



}
