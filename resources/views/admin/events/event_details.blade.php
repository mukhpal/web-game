@extends('admin.layouts.admin')
@section('content')
	
	<main class="app-content">
      @include('admin.includes.adminbreadcrumb')
      
      <div class="row">
        <div class="col-md-12">
            
           {{ csrf_field() }}
          <div class="tile">
            <!-- <h3 class="tile-title">Vertical Form</h3> -->
            <div class="tile-body">
                
                <div class="text-right">
                  <a class="btn btn-primary" href="{{ route('admin.eventlist') }}"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Back</a>
                </div>

                <div class="form-group border py-2 my-2">
                    <div class="row align-items-center">
                      <div class="d-flex col-md-6">
                     <div class="col-md-5">
                      <label class="control-label"><strong>Event Name:</strong> </label>
                     </div>
                     <div class="col-md-7">
                      {{ $event_detail['name'] }}
                     </div>
                    </div>
                     <div class="d-flex col-md-6">
                     <div class="col-md-5">
                      <label class="control-label"><strong>Creation Date:</strong> </label>
                     </div>
                     <div class="col-md-7">
                      {{ date("d M, Y", strtotime($event_detail['created_at'])) }}
                       
                     </div>
                   </div>
                  
                    </div>


                     <div class="row align-items-start">
                       <div class="d-flex col-md-6">
                       <div class="col-md-5">
                        <label class="control-label"><strong>Event Time:</strong> </label>
                       </div>
                         <div class="col-md-7">
                          {{ date("d M, Y", strtotime($event_detail['start_date'])) }}
                          <br/>{{ date("H:i", $event_detail['start_time']) }} to {{ date("H:i", $event_detail['end_time']) }} ({{$timezone}})
                         </div>
                   </div>
                   <div class="d-flex col-md-6">
                       <div class="col-md-5">
                      <label class="control-label"><strong>Teams :</strong> </label>
                     </div>
                     <div class="col-md-7">
                      <ol class="pl-3">
                      @foreach($teams as $team)
                        <li> {{ $team->name }}</li>
                      @endforeach
                      </ol>
                       </div>
                     </div>
                    </div>

                    <div class="row align-items-center">
                      <div class="d-flex col-md-6">
                     <div class="col-md-5">
                      <label class="control-label"><strong>Intro Game:</strong> </label>
                     </div>
                     <div class="col-md-7">
                      {{ $event_detail['introgame']->name }}
                     </div>
                    </div>
                     <div class="d-flex col-md-6">
                     <div class="col-md-5">
                      <label class="control-label"><strong>Main Game:</strong> </label>
                     </div>
                     <div class="col-md-7">
                      {{ $event_detail['maingame']->name }}
                       
                     </div>
                   </div>
                  
                    </div>
                    
                  <div class="row col-md-12">
                      <div class="col-md-2">
                      <label class="control-label"><strong>Description :</strong> </label>
                     </div>
                     <div class="col-md-10 text-justify">
                      {{ $event_detail['description'] }} 
                     </div>
                   </div>
                 </div>
                </div>

                 <input type="text" hidden="hidden" id="evtId" value="{{ $eventId }}">

                <div class="clear">&nbsp;</div>

              <table class="table table-hover table-bordered" id="eventMembers">
                <thead>
                  <tr>
                    <!-- <th width="20px"><div class="animated-checkbox"><label style="margin-bottom:0px;"><input type="checkbox" id="checkAll" name="checkall" value="all" /><span class="label-text"></span></label></div></th> -->
                    <th>Member Email</th>
                    <th width="100px">Team Name</th>                    
                    <th>Event Link</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>

            </div>
          </div>

        </div>
        
        <div class="clearix"></div>
        
      </div>


    </main>
    <style type="text/css">
      .row{padding-bottom: 8px;}
    </style>
 <!-- /.content-wrapper -->
@endsection