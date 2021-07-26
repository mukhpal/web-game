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

          <div class="tile">
            <div class="tile-body">

            <div class="clear">&nbsp;</div>
            <div class="table-responsive">
              <table class="table table-hover table-bordered" id="surveyTable">
                <thead>
                  <tr>
                   <!--  <th width="20px"><div class="animated-checkbox"><label style="margin-bottom:0px;"><input type="checkbox" id="checkAll" name="checkall" value="all" /><span class="label-text"></span></label></div></th> -->
                    <th>User Name</th>
                    <th>Event Name</th>
                    <th>Event Date</th>
                    <th>Team Name</th>                    
                    <th>User Rating</th>
                    <th>Message</th>
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
    <script type="text/javascript">
      
    </script>
 <!-- /.content-wrapper -->
@endsection
