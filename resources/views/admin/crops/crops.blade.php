@extends('admin.layouts.admin')
@section('content')
	
	<main class="app-content">
      @include('admin.includes.adminbreadcrumb')
  
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

            <div class="row">
              <div class="col-md-2">
                  <input type="hidden" id="setActiveInactiveUrl" url="{{ route('admin.setactiveinactive') }}" />
                  <input type="hidden" id="data_model" value="crops" />
                  <select class="form-control" name="select_action" id="actionDropdown">
                    <option value="">Select Action</option>
                     <option value="1">Active</option>
                    <option value="0">Inactive</option> 
                    <!--<option value="2">Delete</option>-->
                  </select>       
              </div>
              <div class="col-md-1 text-left"><button class="btn btn-primary" id="goBtt">Go</button></div>
              <div class="col-md-9 text-right"><a class="btn btn-primary icon-btn" href="{{ route('admin.addcrop')}}"><i class="fa fa-plus"></i>Add Crop</a></div>
            </div>
            <div class="clear">&nbsp;</div>
               {{ csrf_field() }}
               <div class="table-responsive">
              <table class="table table-hover table-bordered" id="cropsTable">
                <thead>
                  <tr>
                    <th width="20px"><div class="animated-checkbox"><label style="margin-bottom:0px;"><input type="checkbox" id="checkAll" name="checkall" value="all" /><span class="label-text"></span></label></div></th>
                    <th>Name</th>
                    <th>Crop For Round</th>
                    <th>Cost(per lbs)</th>
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
 <!-- /.content-wrapper -->
@endsection
