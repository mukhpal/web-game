<?php 
namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Traits\CommonMethods;
use App\Models\MmRounds;
use Carbon\Carbon;

use App\Models\Pages;
use App\Models\PageContent;
use App\Models\Faqs;
use App\Models\Emails;
use App\Models\User;
use App\Models\Event;
use App\Models\ContentConfigurations;
use App\Models\Packages;

class PagesController extends Controller
{
    use CommonMethods;

    protected $title = '';
    protected $contentConfs = [];

    public function __construct(){
        $this->contentConfs = ContentConfigurations::getAll( );
        view()->share( 'worldMapCountries', \Config::get('constants.world_map_countries') );
        view()->share( 'basicContent', $this->contentConfs );
    }

    private function getTitle( $title = '', $includeFronName = true ){
        if( $includeFronName ) $this->title = ' | ' . config( 'constants.from_name' );
        return $title . $this->title;
    }

    private function getPageData( $pageKey = '' ) { 
        if( !$pageKey ) return [];

        $page = Pages::with( [ 'pageContent' => function( $q ){
            $q->orderBy( 'created_at', 'ASC' );
        } ] )->find( $pageKey );

        $pageData = $page->toArray();
        $pageContentData = $pageData[ 'page_content' ];
        unset( $pageData[ 'page_content' ] );

        $returnData = [ 'data' => $pageData ];
        foreach( $pageContentData as $pageContent ) { 
            $returnData[ $pageContent[ 'pc_section_id' ] ][ 'title' ] = $pageContent[ 'pc_title' ];
            $returnData[ $pageContent[ 'pc_section_id' ] ][ 'desc' ] = $pageContent[ 'pc_description' ];
            $returnData[ $pageContent[ 'pc_section_id' ] ][ 'image' ] = url( '/public/upload/pages' ) . '/' . $pageContent[ 'pc_image' ];
        }

        return $returnData;
    }

    public function index(){
        $title = $this->getTitle( 'Welcome To Office Campfire', false );

        $totalUsers = User::where( 'status', 1 )->count();
        $totalUsers = $totalUsers - ( $totalUsers%10 );
        $totalEvents = Event::where( 'status', 1 )->count();
        $totalEvents = $totalEvents - ( $totalEvents%10 );

        $packages = Packages::where( 'status', 1 )->where( 'deleted', 0 )->orderBy( 'order', 'ASC' )->take( 4 )->get( );

        return view('pages.index', [
            'title' => $title,
            'currentPage' => 'index',
            'pageData' => $this->getPageData( 'HOME' ),
            'totalUsers' => ( $totalUsers > 0?$totalUsers:1 ),
            'totalEvents' => ( $totalEvents > 0?$totalEvents:1 ),
            'packages' => $packages
        ]);
    }
    
    public function aboutUs(){
        $title = $this->getTitle( 'About Us' );
        return view('pages.about_us', [
            'title' => $title,
            'currentPage' => 'about_us',
            'pageData' => $this->getPageData( 'ABOUT_US' )
        ]);
    }
    
    public function contact(){
        $title = $this->getTitle( 'Contact Us' );
        return view('pages.contact', [
            'title' => $title,
            'currentPage' => 'contact',
            'pageData' => $this->getPageData( 'CONTACT_US' )
        ]);
    }
    
    public function faqs(){
        $title = $this->getTitle( 'Frequently Asked Questions' );

        $faqs = Faqs::orderBy( 'order', 'ASC' )->get( );

        return view('pages.faqs', [
            'title' => $title,
            'currentPage' => 'faqs',
            'faqs' => $faqs,
            'pageData' => $this->getPageData( 'FAQS' )
        ]);
    }
    
    public function howItWorks(){
        $title = $this->getTitle( 'How It Works' );
        return view('pages.how_it_works', [
            'title' => $title,
            'currentPage' => 'how_it_works',
            'pageData' => $this->getPageData( 'HOW_IT_WORKS' )
        ]);
    }
    
    public function packages(){
        $title = $this->getTitle( 'Packages' );
        
        $packages = Packages::where( 'status', 1 )->where( 'deleted', 0 )->orderBy( 'order', 'ASC' )->take( 4 )->get( );

        $durations = \Config::get( 'constants.packags_duration' );

        return view('pages.packages', [
            'title' => $title,
            'currentPage' => 'packages',
            'pageData' => $this->getPageData( 'PACKAGES' ),
            'packages' => $packages,
            'durations' => $durations
        ]);
    }

    public function contactSendRequest( Request $request ) { 
        $sendTo = array_filter( explode( ',', $this->contentConfs[ 'CONF_CONTACT_REQUEST_SEND_TO_EMAILS' ] ) );

        if( !$sendTo )  {
            return redirect()->back()->with(['success'=>'Request has been sent successfully.']);
        }

        $sendTo = array_map( 'trim', $sendTo );
        
        $customMessages = $rules = []; 

        if(env('GOOGLE_RECAPTCHA_KEY')){ 
          $rules[ 'g-recaptcha-response' ] = 'required|recaptcha';
          $customMessages[ 'g-recaptcha-response.recaptcha' ] = 'Something went wrong with captcha selection, please recheck and submit again.';
          $customMessages[ 'g-recaptcha-response.required' ] = 'Capctha field is required.';
        }

        $validatedData = $this->validate($request, $rules, $customMessages);

        $postedData = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email',
            'comment' => 'required'
        ]);

        $signup_email = Emails::where(['email_slug' => 'contact_request'])->first();

        $emailTemplateDecode = html_entity_decode($signup_email['email_template']);
        $email_body = str_replace("##name##", $request->name, $emailTemplateDecode);
        $email_body = str_replace("##email##", $request->email, $email_body);
        $email_body = str_replace("##message##", $request->comment, $email_body);
        $email_body = str_replace("##logopath##", url('/').'/assets/front/images/email/logo.png', $email_body);
        
        $emailParams = array( "to" => $sendTo, "subject"=>$signup_email['subject'], "content"=>$email_body);

        $this->sendEmail($emailParams);
  
        return redirect()->back()->with(['success'=>'Request has been sent successfully.']);
    }
}