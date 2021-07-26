@extends('admin.layouts.admin')
@section('content')

	<main class="app-content">
      @include('admin.includes.adminbreadcrumb')
      
       <div class="row">
        <div class="col-md-6 col-lg-4">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
            <div class="info">
              <h4>Managers</h4>
              <p><b>{{$managersCount}}</b></p>
              <span style="float: right"><a href="{{route('admin.eventmanagerlist')}}">View</a></span>
            </div>
          </div>
        </div>
         <div class="col-md-6 col-lg-4">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-calendar-o fa-3x"></i>
            <div class="info">
              <h4>Events</h4>
              <p><b>{{$eventCount}}</b></p>
              <span style="float: right"><a href="{{route('admin.eventlist')}}">View</a></span>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4">
          <div class="widget-small warning coloured-icon"><i class="icon fa fa-users fa-3x"></i>
            <div class="info">
              <h4>Teams</h4>
              <p><b>{{$teamCount}}</b></p>
              <span style="float: right"><a href="javascript:void(0);">View</a></span>
            </div>
          </div>
        </div>
       <!-- <div class="col-md-6 col-lg-3">
          <div class="widget-small danger coloured-icon"><i class="icon fa fa-star fa-3x"></i>
            <div class="info">
              <h4>Stars</h4>
              <p><b>500</b></p>
            </div>
          </div>
        </div> -->
      </div>
     <!--  <div class="row">
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">Monthly Sales</h3>
            <div class="embed-responsive embed-responsive-16by9">
              <canvas class="embed-responsive-item" id="lineChartDemo"></canvas>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">Support Requests</h3>
            <div class="embed-responsive embed-responsive-16by9">
              <canvas class="embed-responsive-item" id="pieChartDemo"></canvas>
            </div>
          </div>
        </div>
      </div> -->
     

    </main>

 <!-- /.content-wrapper -->
@endsection
