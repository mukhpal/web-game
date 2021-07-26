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

          <div class="tile">
            <div class="tile-body">
              <input type="hidden" id="data_model" value="events" />
              <input type="hidden" id="setActiveInactiveUrl" url="{{ route('eventmanager.setactiveinactive') }}" />
            <div class="row">
              <!-- <div class="col-md-2">                  
                  <select class="form-control" name="select_action" id="actionDropdown">
                    <option value="">Select Action</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                    <option value="2">Delete</option>
                  </select>       
              </div>
              <div class="col-md-1 text-left"><button class="btn btn-primary" id="goBtt">Go</button></div> -->
              <div class="col-md-12 text-right"><a class="btn btn-primary icon-btn" href="{{ route('eventmanager.addevent') }}"><i class="fa fa-plus"></i>Add Event</a></div>
            </div>
            <div class="clear">&nbsp;</div>
              {{ csrf_field() }}
              <div class="table-responsive">
              <table class="table table-hover table-bordered" id="eventTable">
                <thead>
                  <tr>
                    <th width="20px">Sr.</th>
                    <th>Name</th>
                    <th>Event Date</th>
                    <th>Players</th>
                    <th>Status</th>
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
 <!-- /.content-wrapper -->
@endsection
