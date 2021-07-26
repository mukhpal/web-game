<?php

namespace App\Http\Controllers\Admin;


use Auth;
use App\Http\Controllers\Controller;
use App\Models\Emails;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Http\Middleware\RedirectIfAuthenticated;
use Session;
use Illuminate\Support\Facades\Redirect;
use Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Input;
use Config;
use xmlapi;
use Hash;
use Carbon\Carbon;
use App\Http\Controllers\Admin\CommonController;
use Illuminate\Support\Facades\URL;
use Vinkla\Hashids\Facades\Hashids;

class EmailsController extends Controller{

  public function __construct() {
    $this->middleware('guest');
  }

  /* get userlisting  */
  public function emailsListing(Request $request){
    $title = "Email Templates";
    return view('admin.emails.emails', ['title' => $title, "breadcrumbItem" => "Manage Email Templates" , "breadcrumbTitle"=>"Templates"]);
  }

 public function addEmail(){
    $title = "Add Email";
    return view('admin.emails.add_emails', ['title' => $title, "breadcrumbItem" => "Manage Email Templates" , "breadcrumbTitle"=> "Add New"]);
  }

   

  public function saveEmail(Request $request){

    $validatedData = $this->validate($request, [
        'subject' => 'required|regex:/^[a-zA-Z\s]+$/u',
        'email_template' => 'required'
    ]);

    $template_details = array(
      "subject" => $request->subject,
      "email_template" => $request->email_template
    );    
    $response = Emails::create($template_details); 
    if($response){
      return redirect()->route('admin.emailslist')->with(['success'=>'Template detail has been added successfully.']);
    }

  }
  


  public function editEmail($id){
    $title = "Edit Email Template";
    $decryptId = Hashids::decode($id);
    $template_detail = Emails::find($decryptId[0]);
    return view('admin.emails.edit_emails', ['title' => $title, "template_detail"=> $template_detail, "breadcrumbItem" => "Manage Email Templates" , "breadcrumbTitle"=> "Edit Template"]);
  }


  
  public function updateEmail(Request $request){

    $validatedData = $this->validate($request, [
        'subject' => 'required|regex:/^[a-zA-Z\s]+$/u',
        'email_template' => 'required'
    ]);

    $template = Emails::find($request->templateid);
    $template->subject = $request->subject;
    $template->email_template = $request->email_template;
    $template->updated_at = Carbon::now();
    $template->save();

    if($template){
      return redirect()->route('admin.emailslist')->with(['success'=>'Template detail has been updated successfully.']);
    }

  }


  public function ajaxDataLoad(Request $request){
    $draw = $_GET['draw'];
    $row = $_GET['start'];
    $rowperpage = $_GET['length']; // Rows display per page
    $columnIndex = $_GET['order'][0]['column']; // Column index
    $columnName = $_GET['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $_GET['order'][0]['dir']; // asc or desc
    $searchValue = $_GET['search']['value']; // Search value
    
    $columns = [
        0 => 'id',
        1 => 'subject',
        2 => 'created_at',
        3 => 'subject'
    ];
    $columnName = $columns[$columnIndex];

    ## Search 
    $searchQuery = " ";
    if($searchValue != ''){
       $searchQuery = whereRaw(" and (subject like '%".$searchValue."%' ) ");
    }
    
    ## Total number of records
    $totalRecords = Emails::whereRaw('status = 1')->count();

    ## Total number of record with filtering
    $totalRecordwithFilter = Emails::whereRaw( 'status = 1'. $searchQuery )->count();
    
    ## Fetch records
    $userlist = Emails::whereRaw( 'status = 1'. $searchQuery )->orderBy($columnName, $columnSortOrder)->skip($row)->take($rowperpage)->get();

    $data = array(); $action = "";
    if(!empty($userlist)){
        $x = 1;
        foreach($userlist as $users){
        $encryptId = Hashids::encode($users["id"]);  
        
        
          $action = '<a href="editemail/'.$encryptId.'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
           $data[] = array( 
              $x,
              $users['subject'],
              date("d M, Y", strtotime($users['created_at'])),
              $action
           );

          $x++; 
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
