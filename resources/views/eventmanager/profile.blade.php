@extends('eventmanager.layouts.admin')
@section('content')
	
	<main class="app-content">
      @include('eventmanager.includes.adminbreadcrumb')
      
      <div class="row">
        <div class="col-md-12">
          <form name="profile_frm" id="profile_update_frm" method="post" action="{{ route('eventmanager.profileupdate') }}">
           {{ csrf_field() }}
          

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
            <!-- <h3 class="tile-title">Vertical Form</h3> -->
            <div class="tile-body">
                <h3 class="tile-title">Profile Information</h3>

               <!--  <div class="form-group">
                  <label class="control-label">Email</label><br />
                  {{$profile['email']}}
                </div> -->

                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Email <span class="required-fields">*</span></label>
                  <input class="form-control" type="text" value="{{ old('email')!='' ? old('email') : $profile['email'] }}" placeholder="E.g. john@abc.com" name="email" />
                  {!! $errors->first('email', '<p class="validation-errors">:message</p>') !!}
                </div>

                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Full Name <span class="required-fields">*</span></label>
                  <input class="form-control" type="text" value="{{ old('fullname')!='' ? old('fullname') : $profile['name'] }}" placeholder="e.g. John Doe" name="fullname" />
                  {!! $errors->first('fullname', '<p class="validation-errors">:message</p>') !!}
                </div>

                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Company Name </label>
                  <input class="form-control" type="text" value="{{ old('companyname')!='' ? old('companyname') : $profile['company_name'] }}" placeholder="e.g. Quanby Ltd" name="companyname" />
                  {!! $errors->first('companyname', '<p class="validation-errors">:message</p>') !!}
                </div>
                
               
            </div>
            <div class="tile-footer">
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="{{ route('eventmanager.dashboard') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
            </div>
          </div>

          </form>

        </div>
        
        <div class="clearix"></div>        
      </div>



      <div class="row">
        <div class="col-md-12">
          <form name="password_frm" id="update_password_frm" method="post" action="{{ route('eventmanager.updatepassword') }}">
           {{ csrf_field() }}

          @if ($message = Session::get('password_error'))
          <div class="alert alert-danger alert-block" style="padding: 7px;margin-bottom: 10px;">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $message }}</strong>
          </div>
          @endif
          @if ($message = Session::get('password_success'))
          <div class="alert alert-success alert-block" style="padding: 7px;margin-bottom: 10px;">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $message }}</strong>
          </div>
          @endif

          <div class="tile">
            <!-- <h3 class="tile-title">Vertical Form</h3> -->
            <div class="tile-body">

                <h3 class="tile-title">Change Password</h3>

                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Current Password <span class="required-fields">*</span></label>
                  <input class="form-control" type="password" placeholder="Enter password" name="old_password" />
                  {!! $errors->first('password', '<p class="validation-errors">:message</p>') !!}
                </div>    


                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">New Password <span class="required-fields">*</span></label>
                  <input class="form-control" type="password" placeholder="Enter password" name="password" id="password" />
                  {!! $errors->first('password', '<p class="validation-errors">:message</p>') !!}
                </div> 

                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Confirm Password <span class="required-fields">*</span></label>
                  <input class="form-control" type="password" placeholder="Enter password" name="cpassword" />
                  {!! $errors->first('password', '<p class="validation-errors">:message</p>') !!}
                </div> 

               
            </div>
            <div class="tile-footer">
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Change Password</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="{{ route('eventmanager.dashboard') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
            </div>
          </div>

          </form>

        </div>
        
        <div class="clearix"></div>        
      </div>


    </main>
 <!-- /.content-wrapper -->
@endsection