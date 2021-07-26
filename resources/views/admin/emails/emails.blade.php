@extends('layouts.admin')
@section('content')
	
	<main class="app-content">
      @include('includes.adminbreadcrumb')
  
      <div class="row">
  
        <div class="col-md-12">


          @if ($message = Session::get('success'))
          <div class="alert alert-success alert-block" style="padding: 7px;margin-bottom: 10px;">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $message }}</strong>
          </div>
          @endif

          <div class="tile">
            <div class="tile-body">

            <div class="row">
              <div class="col-md-2">
                  <input type="hidden" id="data_model" value="emailtemplates" />
                 <!--  <select class="form-control" name="select_action" id="actionDropdown">
                    <option value="">Select Action</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                    <option value="2">Delete</option>
                  </select>  -->      
              </div>
              <div class="col-md-1 text-left"><!-- <button class="btn btn-primary" id="goBtt">Go</button> --></div>
              <div class="col-md-9 text-right"><a class="btn btn-primary icon-btn" href="{{ route('admin.addemail')}}"><i class="fa fa-plus"></i>Add New</a></div>
            </div>
            <div class="clear">&nbsp;</div>

              <table class="table table-hover table-bordered" id="emailDataTables">
                <thead>
                  <tr>
                    <!-- <th width="20px"><div class="animated-checkbox"><label style="margin-bottom:0px;"><input type="checkbox" id="checkAll" name="checkall" value="all" /><span class="label-text"></span></label></div></th> -->
                    <th>S. No</th>
                    <th>Subject</th>
                    <th>Created date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
              
            </div>
          </div>
        </div>
      </div>
    </main>
 <!-- /.content-wrapper -->
@endsection
