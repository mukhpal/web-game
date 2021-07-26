@extends('admin.layouts.default')
@section('content')
 <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="admin_logo">
          <img src="{{ asset( 'assets/front/images/ofc_wht_logo.png' ) }}" alt="Office Campfire">
      </div>
      	<?php
      	$flipped_class = "";
      	if(Session::get('flipped_class')){ $flipped_class = "flipped"; } ?>

        @if ($message = Session::get('error'))
        <div class="login-box login-box-error">
        <div class="alert alert-danger alert-block" style="padding: 7px;margin: 2px 2px;">
          <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{{ $message }}</strong>
        </div></div>
        @endif

        @if ($message = Session::get('forgot_error'))
        <div class="login-box login-box-error">
        <div class="alert alert-danger alert-block" style="padding: 7px;margin: 2px 2px;">
          <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{{ $message }}</strong>
        </div></div>
        @endif

        @if ($message = Session::get('forgot_success'))
        <div class="login-box login-box-error">
        <div class="alert alert-success alert-block" style="padding: 7px;margin: 2px 2px;">
          <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{{ $message }}</strong>
        </div></div>
        @endif

        @if ($message = Session::get('success'))
        <div class="login-box login-box-error">
        <div class="alert alert-success alert-block" style="padding: 7px;margin: 2px 2px;">
          <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{{ $message }}</strong>
        </div></div>
        @endif


        <div class="login-box {{ $flipped_class }}">

        <form class="login-form" id="login_frm" method="post" action="{{ route('admin.authenticate') }}">
        	{{ csrf_field() }}
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>
          <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
            <label class="control-label">EMAIL</label>
            <input class="form-control" type="text" placeholder="e.g. john@abc.com" name="email" value="{{ old('email') }}" autocomplete="off" />
            {!! $errors->first('email', '<p class="validation-errors">:message</p>') !!}
          </div>
          <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
            <label class="control-label">PASSWORD</label>
            <input class="form-control" type="password" name="password" placeholder="Password" />
            {!! $errors->first('password', '<p class="validation-errors">:message</p>') !!}
          </div>

          @if(env('GOOGLE_RECAPTCHA_KEY'))
            <div class="form-group {{ $errors->has('g-recaptcha-response') ? 'has-error' : ''}}">
              <label class="control-label">Captcha <span class="required-fields">*</span></label>
                  <div class="g-recaptcha"
                      data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}">
                  </div>
              {!! $errors->first('g-recaptcha-response', '<p class="validation-errors">:message</p>') !!}
            </div>
          @endif

          <div class="form-group">
            <div class="utility">
              <div class="animated-checkbox">
                <!-- <label>
                  <input type="checkbox"><span class="label-text">Stay Signed in</span>
                </label> -->
              </div>
              <p class="semibold-text mb-2"><a href="#" data-toggle="flip">Forgot Password ?</a></p>
            </div>
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
          </div>
        </form>

        <form class="forget-form" method="post" action="{{route('admin.forgot_password') }}">
        	{{ csrf_field() }}
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Forgot Password ?</h3>
          <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
            <label class="control-label">EMAIL</label>
            <input class="form-control" type="text" name="forgot_email" value="" placeholder="e.g. john@abc.com" />
            {!! $errors->first('email', '<p class="validation-errors">:message</p>') !!}
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-unlock fa-lg fa-fw"></i>RESET</button>
          </div>
          <div class="form-group mt-3">
            <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Back to Login</a></p>
          </div>
        </form>

      </div>
   </section>
   <script type="text/javascript">
        function noBack() { window.history.forward(); }
        noBack();
        window.onload = noBack;
        window.onpageshow = function (evt) { if (evt.persisted) noBack(); }
        window.onunload = function () { void (0); }
    </script>

  <script src='https://www.google.com/recaptcha/api.js'></script>
@stop
