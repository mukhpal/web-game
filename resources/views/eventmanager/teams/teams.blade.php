@extends('eventmanager.layouts.admin')
@section('content')
	
	<main class="app-content">
      @include('eventmanager.includes.adminbreadcrumb')
  
      <div class="row">
  
        <div class="col-md-12">
        
          @if ($message = Session::get('success'))
          <div class="alert alert-success alert-block" style="padding: 7px;margin-bottom: 10px;">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $message }}</strong>
          </div>
          @endif

          @if ($message = Session::get('error'))
          <div class="alert alert-danger alert-block" style="padding: 7px;margin-bottom: 10px;">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $message }}</strong>
          </div>
          @endif

          <div class="tile">
            <div class="tile-body">
               {{ csrf_field() }}
              <input type="hidden" id="getTeamMembersUrl" url="{{ route('eventmanager.getteammembers') }}" />
              <input type="hidden" id="setActiveInactiveUrl" url="{{ route('eventmanager.setactiveinactive') }}" />
            <div class="row">
              <div class="col-md-2">
                  <input type="hidden" id="data_model" value="teams" />
                  <select class="form-control" name="select_action" id="actionDropdown">
                    <option value="">Select Action</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                    <!-- <option value="2">Delete</option> -->
                  </select>       
              </div>
              <div class="col-md-1 text-left"><button class="btn btn-primary" id="goBtt">Go</button></div>
              <div class="col-md-9 text-right"><a class="btn btn-primary icon-btn" href="{{ route('eventmanager.addteam')}}"><i class="fa fa-plus"></i>Create Team</a></div>
            </div>
            <div class="clear">&nbsp;</div>
              {{ csrf_field() }}
              <div class="table-responsive">
              <table class="table table-hover table-bordered" id="teamTable">
                <thead>
                  <tr>
                    <th width="20px"><div class="animated-checkbox"><label style="margin-bottom:0px;"><input type="checkbox" id="checkAll" name="checkall" value="all" /><span class="label-text"></span></label></div></th>
                    <th>Name</th>
                    <th>Status</th>
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
      </div>
    </main>



    <div id="teamMembersModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Team Members</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>            
          </div>
          <div class="modal-body">
          <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <thead>
                  <tr>
                    <th width="20px">S.No</th>
                    <th>Name</th>                    
                  </tr>
                </thead>
                <tbody id="teamMembers"></tbody>
              </table>


          </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>
 <!-- /.content-wrapper -->
@endsection
