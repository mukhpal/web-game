@extends('eventmanager.layouts.admin')
@section('content')


	
	<main class="app-content">
      @include('eventmanager.includes.adminbreadcrumb')
      
       <div class="row">
        <div class="col-md-6 col-lg-4">
          <div class="widget-small warning coloured-icon"><i class="icon fa fa-users fa-3x"></i>
            <div class="info">
              <h4>Users</h4>
              <p><b>{{$userCount}}</b></p>
              <span style="float: right"><a href="{{route('eventmanager.userlist')}}">View</a></span>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-calendar-o fa-3x"></i>
            <div class="info">
              <h4>Events</h4>
              <p><b>{{$eventsCount}}</b></p>
              <span style="float: right"><a href="{{route('eventmanager.eventlist')}}">View</a></span>
              <!-- <span style="float: right"><a href="javascript:void(0);">View</a></span> -->
            </div>
          </div>
        </div>
         <div class="col-md-6 col-lg-4">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-users fa-3x"></i>
            <div class="info">
              <h4>Teams</h4>
              <p><b>{{$teamCount}}</b></p>
              <span style="float: right"><a href="{{route('eventmanager.teamlist')}}">View</a></span>
            </div>
          </div>
        </div>

      </div>
      <div id="calendar">
        <div class="row"></div>
      </div>
    </main>

 <!-- /.content-wrapper -->
@endsection
