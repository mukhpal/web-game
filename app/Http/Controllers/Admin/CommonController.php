<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;


class CommonController extends Controller
{

  private static $instance;

  public function __construct() {
    
  }

  public static function getInstance() {
      if (!isset(self::$instance)) {
          self::$instance = new static();
      }
      return self::$instance;
  }

  
  /* Delete the single row of a model  */
  public function deleteRow(Request $request){
    $rowid = Hashids::decode($request->rowid); $model = $request->affected_data_model;
    if(isset($rowid) && isset($model)){
      $delete = DB::table($model)->where(["id"=>$rowid[0]])->delete();

      try {
        if($delete){
          echo json_encode(array("code"=>200, "message"=>"Row deleted successfully."));
        }else{
          echo json_encode(array("code"=>203, "message"=>"Error occured while deleting user."));
        }
      
      }catch (Exception $e) {
           echo json_encode(array("code"=>500, "message"=>$e->getMessage()));
      }
      
    }else{
      echo json_encode(array("code"=>500, "message"=>"Some information is missing!"));
    }
  }

  /* Delete bulk rows of a model  */
  public function updateBulkRows(Request $request){
    $idsArr = array();
    foreach ($request->rowids as $value) {
      $rowids = Hashids::decode($value); 
      $idsArr[] = $rowids[0];
    }   
    $actiontype = $request->actiontype; $model = $request->affected_data_model; $alertText = "updated";
    if(isset($actiontype) && isset($model)){
      if($actiontype==2){
        $alertText = "deleted";
        $delete = DB::table($model)->whereIn('id', $idsArr)->delete();
      }else{
        $delete = DB::table($model)->whereIn('id', $idsArr)->update(["status"=>$actiontype]);
      }
      try {
        if($delete){
          echo json_encode(array("code"=>200, "message"=>"Rows ".$alertText." successfully."));
        }else{
          echo json_encode(array("code"=>203, "message"=>"Error occured while updating data."));
        }
      }catch(Exception $e){
          echo json_encode(array("code"=>500, "message"=>$e->getMessage()));
      }

    }else{
        echo json_encode(array("code"=>500, "message"=>"Some information is missing!"));
    }

  }



  /* Delete the single row of a model  */
  public function setActiveInactive(Request $request){
    $rowid = Hashids::decode($request->affected_id); $model = $request->affected_data_model; $status = $request->status;
    if(isset($rowid) && isset($model)){
      $update = DB::table($model)->where(["id"=>$rowid[0]])->update(['status' => $status]);
      
      try {
        if($update){
          echo json_encode(array("code"=>200, "message"=>"Status updated successfully."));
        }else{
          echo json_encode(array("code"=>203, "message"=>"Error occured while updating user."));
        }
      
      }catch (Exception $e) {
           echo json_encode(array("code"=>500, "message"=>$e->getMessage()));
      }
      
    }else{
      echo json_encode(array("code"=>500, "message"=>"Some information is missing!"));
    }
  }



}
