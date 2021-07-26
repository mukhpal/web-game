@extends('eventmanager.layouts.admin')
@section('content')
@inject('CommonMethods', 'App\Http\Controllers\EventManager\EventsController')	
	<main class="app-content">
      @include('eventmanager.includes.adminbreadcrumb')
      
      
      <div class="row">
        <div class="col-md-12">
          <form name="event_frm" id="edit_event_frm" method="post" action="{{route('eventmanager.updateevent')}}">
            
           {{ csrf_field() }}

           @if ($message = Session::get('error'))
          <div class="alert alert-danger alert-block" style="padding: 7px;margin-bottom: 10px;">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $message }}</strong>
          </div>
          @endif
          
          <div class="tile">
            <!-- <h3 class="tile-title">Vertical Form</h3> -->
            <div class="tile-body">
                <input type="hidden" name="eventid" id="event_id" value="{{$event['id']}}" />
                
                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Name <span class="required-fields">*</span></label>
                  <input class="form-control" type="text" value="{{ old('eventname')!='' ? old('eventname') : $event['name'] }}" placeholder="Enter event name" name="eventname" />
                  {!! $errors->first('eventname', '<p class="validation-errors">:message</p>') !!}
                </div>
                
                <div class="row">
                    <div class="col-md-5 form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                        <label for="items">Teams <span class="required-fields">*</span></label>
                        <?php // if(!empty(old('teams'))){ $teamsArr = old('teams'); } ?>
                        <select multiple class="form-control" size="10" name="teams[]" id="teams">
                          @foreach($teams as $team)
                          <?php if(in_array($team['id'], $assignTeamArr)){
                            echo "<option value='".$team['id']."' selected>".$team['name']."</option>";
                          }else{
                            echo "<option value='".$team['id']."'>".$team['name']."</option>";
                          } ?>
                          @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                        <label for="items">Start Date <span class="required-fields">*</span></label>
                        <input autocomplete="off" class="form-control" type="text" value="{{ old('startdate')!='' ? old('startdate') : $event['start_date'] }}" id="eventStartDate" placeholder="Select start date" name="startdate" />
                        {!! $errors->first('startdate', '<p class="validation-errors">:message</p>') !!}
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                      <i>(Note: Time zone for this event is <b>{{$timezone}}</b> )</i>
                  </div>
                </div>
                <div class="row">
                  
                    <div class="col-md-2 form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                        <label for="items">Start Time <span class="required-fields">*</span></label>
                        <input class="form-control" type="text" value="{{ old('starttime')!='' ? old('starttime') : $CommonMethods->getTimeFromTimestamp($event['start_time'])}}" id="eventStartTime" placeholder="Select start time" name="starttime" data-time-format="H:i" data-step="5" data-min-time="00:00" data-max-time="23:55" data-show-2400="true" />
                        {!! $errors->first('starttime', '<p class="validation-errors">:message</p>') !!}
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-md-2 form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                        <label for="items">End Time <span class="required-fields">*</span></label>
                        <input class="form-control" type="text" value="{{ old('endtime')!='' ? old('endtime') : $CommonMethods->getTimeFromTimestamp($event['end_time'])}}" id="eventEndTime" placeholder="Select end time" name="endtime" data-time-format="H:i" data-step="5" data-min-time="00:00" data-max-time="23:55" data-show-2400="true" />
                        {!! $errors->first('endtime', '<p class="validation-errors">:message</p>') !!}
                    </div>
                </div> -->

                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Description </label>
                  <textarea placeholder="Enter description" class="form-control" rows="5" name="description" >{{ old('description')!='' ? old('description') : $event['description'] }}</textarea>
                  {!! $errors->first('description', '<p class="validation-errors">:message</p>') !!}
                </div>


            </div>
            <div class="tile-footer">
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="{{ route('eventmanager.eventlist') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
            </div>
          </div>

          </form>

        </div>
        
        <div class="clearix"></div>
        
      </div>
    </main>
  
    <!-- <script src="{{asset('assets/event_manager/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script type="text/javascript">
      $('#eventStartTimeEdit,#eventEndTimeEdit').datetimepicker({format: 'hh:ii',startView: 1});
      var startTime = "<?php echo date($CommonMethods->getTimeFromTimestamp($event['start_time'])."") ?>";
      var endTime = "<?php echo date($CommonMethods->getTimeFromTimestamp($event['end_time'])."") ?>";
      $('#eventStartTimeEdit').datetimepicker('setDate', new Date(startTime));
      $('#eventEndTimeEdit').datetimepicker('setDate', new Date(endTime));
    </script> -->
 <!-- /.content-wrapper -->
    <script type="text/javascript">
      var minTeamsForEvent = "<?php echo $minTeamsForEvent ?>";
    </script>
@endsection