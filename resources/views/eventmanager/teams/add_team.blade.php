@extends('eventmanager.layouts.admin')
@section('content')
	
	<main class="app-content">
      @include('eventmanager.includes.adminbreadcrumb')
      
      <div class="row">
        <div class="col-md-12">
          <form name="team_frm" id="add_team_frm" method="post" action="{{ route('eventmanager.saveteam') }}">
          <input type="hidden" id="userExistUrl" url="{{ route('eventmanager.userexistinanyteam') }}" />

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
              
                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Team Name <span class="required-fields">*</span></label>
                  <input class="form-control" type="text" value="{{ old('teamname') }}" placeholder="e.g. Super 30" name="teamname" />
                  {!! $errors->first('teamname', '<p class="validation-errors">:message</p>') !!}
                </div>
                

                <div class="row">
                    <div class="col-md-5">
                        <label for="items">Users</label>
                        <select multiple class="form-control crossover-box" id="items">
                          @foreach($unassigned_teamusers as $users)
                          <option>{{$users->email}}</option>
                          @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary crossover-btn" id="crossover-btn-add">Add</button>
                        <button type="button" class="btn btn-primary crossover-btn" id="crossover-btn-remove">Remove</button>
                    </div>

                    <div class="col-md-5">
                        <label for="selected">Selected Users</label>
                        <select class="form-control crossover-box" id="selected" name="selectedusers[]" multiple="multiple" size="10"></select>
                        <input type="hidden" name="selected_users" id="selected_users" value="" />
                    </div>
                </div>



            </div>
            <div class="tile-footer">
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Create</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="{{ route('eventmanager.teamlist') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
            </div>
          </div>

          </form>

        </div>
        
        <div class="clearix"></div>
        
      </div>


    </main>
    <script type="text/javascript">
      var teamSize = "{{$teamSize}}";
      var min_team_size = "{{$minteamSize}}";
    </script>
 <!-- /.content-wrapper -->
@endsection
