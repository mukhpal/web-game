@extends('eventmanager.layouts.admin')
@section('content')
	
	<main class="app-content">
      @include('eventmanager.includes.adminbreadcrumb')
      
      <div class="row">
        <div class="col-md-12">
          <form name="event_frm" id="add_event_frm" method="post" action="{{ route('eventmanager.saveevent') }}">

           {{ csrf_field() }}
          <div class="tile">
            <!-- <h3 class="tile-title">Vertical Form</h3> -->
            <div class="tile-body">
              
                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Name <span class="required-fields">*</span></label>
                  <input class="form-control" type="text" value="{{ old('eventname') }}" placeholder="Enter event name" name="eventname" />
                  {!! $errors->first('eventname', '<p class="validation-errors">:message</p>') !!}
                </div>
                
                <div class="row">
                    <div class="col-md-5 form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                        <label for="items">Teams <span class="required-fields">*</span></label>
                        <select multiple class="form-control" size="10" name="teams[]" id="teams">
                          @foreach($teams as $team)
                          <option>{{$team['name']}}</option>
                          @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                        <label for="items">Start Date <span class="required-fields">*</span></label>
                        <input class="form-control" type="text" value="{{ old('startdate') }}" id="eventStartDate" placeholder="Select start date" name="startdate" />
                        {!! $errors->first('startdate', '<p class="validation-errors">:message</p>') !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                        <label for="items">Start Time <span class="required-fields">*</span></label>
                        <input class="form-control" type="text" value="{{ old('starttime') }}" id="eventStartTime" placeholder="Select start time" name="starttime" />
                        {!! $errors->first('starttime', '<p class="validation-errors">:message</p>') !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                        <label for="items">End Time <span class="required-fields">*</span></label>
                        <input class="form-control" type="text" value="{{ old('endtime') }}" id="eventEndTime" placeholder="Select end time" name="endtime" />
                        {!! $errors->first('endtime', '<p class="validation-errors">:message</p>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Description </label>
                  <textarea placeholder="Enter description" class="form-control" rows="5" name="description" >{{ old('description') }}</textarea>
                  {!! $errors->first('description', '<p class="validation-errors">:message</p>') !!}
                </div>

            </div>
            <div class="tile-footer">
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Add</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="{{ route('eventmanager.eventlist') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
            </div>
          </div>

          </form>

        </div>
        
        <div class="clearix"></div>
        
      </div>


    </main>


 <!-- /.content-wrapper -->
@endsection
