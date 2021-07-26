@extends('admin.layouts.default')
@section('content')
 <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1>Logo</h1>
      </div>
      	
        	
        
    @if ($message = Session::get('success'))
    	<div class="login-box" style="min-height:50px;max-height:50px;background:transparent;">
      	<div class="alert alert-success alert-block" style="padding: 7px;margin: 2px 2px;">
			<button type="button" class="close" data-dismiss="alert">×</button>	
		        <strong>Password updated successfully. Go to <a href="/admin/login">Login</a></strong>
		  </div></div>
		@endif

		@if ($message = Session::get('error'))
		  <div class="login-box" style="min-height:50px;max-height:50px;background:transparent;">
		  <div class="alert alert-danger alert-block" style="padding: 7px;margin: 2px 2px;">
			<button type="button" class="close" data-dismiss="alert">×</button>	
		        <strong>{{ $message }}</strong>
		  </div></div>
		@endif
		
		
      <div class="login-box">
      
        <form class="login-form" method="post" action="{{ route('admin.update_password') }}">
        	{{ csrf_field() }}
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>RESET PASSWORD</h3>
          <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
            <label class="control-label">PASSWORD</label>
            <input class="form-control" type="password" placeholder="Password" name="password" />
            {!! $errors->first('password', '<p class="validation-errors">:message</p>') !!}
          </div>
          <div class="form-group">
            <label class="control-label">PASSWORD AGAIN</label>
            <input class="form-control" type="password" name="cpassword" placeholder="Password Again" />
            {!! $errors->first('cpassword', '<p class="validation-errors">:message</p>') !!}
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>RESET PASSWORD</button>
          </div>
        </form>

      </div>
   </section>
@stop
