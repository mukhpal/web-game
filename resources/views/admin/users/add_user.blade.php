@extends('layouts.admin')
@section('content')
	
	<main class="app-content">
      @include('includes.adminbreadcrumb')
      
      <div class="row">
        <div class="col-md-12">
          <form name="user_frm" id="add_user_frm" method="post" action="{{ route('admin.saveuser') }}">
           {{ csrf_field() }}
          <div class="tile">
            <!-- <h3 class="tile-title">Vertical Form</h3> -->
            <div class="tile-body">
              
                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Name <span class="required-fields">*</span></label>
                  <input class="form-control" type="text" value="{{ old('fullname') }}" placeholder="Enter full name" name="fullname" />
                  {!! $errors->first('fullname', '<p class="validation-errors">:message</p>') !!}
                </div>
                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Email <span class="required-fields">*</span></label>
                  <input class="form-control" type="text" value="{{ old('email') }}" placeholder="Enter email address" name="email" />
                  {!! $errors->first('email', '<p class="validation-errors">:message</p>') !!}
                </div>
                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Password <span class="required-fields">*</span></label>
                  <input class="form-control" type="password" placeholder="Enter password" name="password" />
                  {!! $errors->first('password', '<p class="validation-errors">:message</p>') !!}
                </div>                
                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Gender <span class="required-fields">*</span></label>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="form-check-input" type="radio" value="m" name="gender" <?php if(old('gender')== "m") { echo 'checked'; } ?> />Male
                    </label>
                  </div>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="form-check-input" type="radio" value="f" name="gender" <?php if(old('gender')== "f") { echo 'checked'; } ?>  />Female
                    </label>
                  </div>
                  {!! $errors->first('gender', '<p class="validation-errors">:message</p>') !!}
                </div>               
              
            </div>
            <div class="tile-footer">
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Add</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="{{ route('admin.userlist') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
            </div>
          </div>

          </form>

        </div>
        
        <div class="clearix"></div>
        
      </div>


    </main>
 <!-- /.content-wrapper -->
@endsection
