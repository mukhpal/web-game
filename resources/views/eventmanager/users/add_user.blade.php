@extends('eventmanager.layouts.admin')
@section('content')
	
	<main class="app-content">
      @include('eventmanager.includes.adminbreadcrumb')
      
      <div class="row">
        <div class="col-md-12">
          <form name="user_frm" id="add_user_frm" method="post" action="{{ route('eventmanager.saveuser') }}">            
           {{ csrf_field() }}
          <div class="tile">
            <!-- <h3 class="tile-title">Vertical Form</h3> -->
            <div class="tile-body">
                
                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Email <span class="required-fields">*</span></label>
                  <input class="form-control" type="text" value="{{ old('email') }}" placeholder="e.g. john@abc.com" name="email" id="user_email" />
                  {!! $errors->first('email', '<p class="validation-errors">:message</p>') !!}
                </div>
                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Name </label>
                  <input class="form-control" type="text" value="{{ old('fullname') }}" placeholder="e.g. John Doe" name="fullname" />
                  {!! $errors->first('fullname', '<p class="validation-errors">:message</p>') !!}
                </div>

                <div class="form-group {{ $errors->has('country') ? 'has-error' : ''}}">
                  <label class="control-label">Select Country <span class="required-fields">*</span></label>
                  <select name="country" class="form-control" onchange="fetchstates(this.value)" required="required">
                    <option value="">Select Country</option>
                    @foreach($countries as $country)
                      <option value="{{ Hashids::encode($country->id) }}">{{ $country->name }}</option>
                    @endforeach
                  </select>
                  {!! $errors->first('country', '<p class="validation-errors">:message</p>') !!}
                </div>

                <div class="form-group {{ $errors->has('state') ? 'has-error' : ''}}">
                  <label class="control-label">Select State <span class="required-fields">*</span></label>
                  <select name="state" class="form-control" id="state_tab" required="required">
                    <option value="">Select State</option>
                  </select>
                  {!! $errors->first('state', '<p class="validation-errors">:message</p>') !!}
                </div>

            </div>
            <div class="tile-footer">
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Add</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="{{ route('eventmanager.userlist') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
            </div>
          </div>

          </form>

        </div>
        
        <div class="clearix"></div>
        
      </div>


    </main>
 <!-- /.content-wrapper -->
@endsection
