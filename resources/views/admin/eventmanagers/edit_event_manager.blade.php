@extends('admin.layouts.admin')
@section('content')
	
	<main class="app-content">
      @include('admin.includes.adminbreadcrumb')
      
      <div class="row">
        <div class="col-md-12">
          <form name="eventmanager_frm" id="edit_eventmanager_frm" method="post" action="{{ route('admin.updateeventmanager') }}">
           {{ csrf_field() }}
          <div class="tile">
            <!-- <h3 class="tile-title">Vertical Form</h3> -->
            <div class="tile-body">
                <input type="hidden" name="id" id="eventmanager_id" value="{{$data['id']}}" />
                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Company Name <span class="required-fields">*</span></label>
                  <input class="form-control" type="text" value="{{ old('companyname')!='' ? old('companyname') : $data['company_name'] }}" placeholder="e.g. Quanby Ltd" name="companyname" />
                  {!! $errors->first('companyname', '<p class="validation-errors">:message</p>') !!}
                </div>
                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Full Name <span class="required-fields">*</span></label>
                  <input class="form-control" type="text" value="{{ old('fullname')!='' ? old('fullname') : $data['name'] }}" placeholder="e.g. John Doe" name="fullname" />
                  {!! $errors->first('fullname', '<p class="validation-errors">:message</p>') !!}
                </div>
                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Email <span class="required-fields">*</span></label>
                  <input class="form-control" type="email" value="{{ old('email')!='' ? old('email') : $data['email'] }}" placeholder="e.g. john@abc.com" name="email" />
                  {!! $errors->first('email', '<p class="validation-errors">:message</p>') !!}
                </div>
               <!-- <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Password <span class="required-fields">*</span></label>
                  <input class="form-control" type="password" placeholder="Enter password" name="password" />
                  {!! $errors->first('password', '<p class="validation-errors">:message</p>') !!}
                </div>                
                 <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Gender <span class="required-fields">*</span></label>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="form-check-input" type="radio" value="m" name="gender" <?php if($data['gender'] == "m") { echo 'checked'; } ?> />Male
                    </label>
                  </div>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="form-check-input" type="radio" value="f" name="gender" <?php if($data['gender'] == "f") { echo 'checked'; } ?> />Female
                    </label>
                  </div>
                  {!! $errors->first('gender', '<p class="validation-errors">:message</p>') !!}
                </div> -->

                <div class="form-group {{ $errors->has('country') ? 'has-error' : ''}}">
                  <label class="control-label">Select Country <span class="required-fields">*</span></label>
                  <select name="country" class="form-control" onchange="fetchstates(this.value)" required="required">
                    <option value="">Select Country</option>
                    @foreach($countries as $country)
                      <option {{ $country->id == $data["country_id"] ? 'selected' : '' }} value="{{ Hashids::encode($country->id) }}">{{ $country->name }}</option>
                    @endforeach
                  </select>
                  {!! $errors->first('country', '<p class="validation-errors">:message</p>') !!}
                </div>

                <div class="form-group {{ $errors->has('state') ? 'has-error' : ''}}">
                  <label class="control-label">Select State <span class="required-fields">*</span></label>
                  <select name="state" class="form-control" id="state_tab" required="required">
                    <option value="">Select State</option>
                    @foreach($states as $state)
                      <option {{ $state->id == $data["state_id"] ? 'selected' : '' }} value="{{ Hashids::encode($state->id) }}">{{ $state->name }}</option>
                    @endforeach
                  </select>
                  {!! $errors->first('state', '<p class="validation-errors">:message</p>') !!}
                </div>
               
            </div>
            <div class="tile-footer">
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="{{ route('admin.eventmanagerlist') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
            </div>
          </div>

          </form>

        </div>
        
        <div class="clearix"></div>
        
      </div>


    </main>
 <!-- /.content-wrapper -->
@endsection