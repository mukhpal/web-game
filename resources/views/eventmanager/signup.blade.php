@extends('eventmanager.layouts.default')
@section('content')
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <br/>
      <div class="admin_logo">
        <img src="{{ asset( 'assets/front/images/ofc_wht_logo.png' ) }}" alt="Office Campfire">
      </div>
      
        @if ($message = Session::get('error'))
        <div class="login-box" style="min-height:50px;max-height:50px;background:transparent;">
        <div class="alert alert-danger alert-block" style="padding: 7px;margin: 2px 2px;">
          <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{{ $message }}</strong>
        </div></div>
        @endif


        <div class="col-md-4 col-lg-4 col-xs-12">
          <div class="tile">
            <form name="eventmanager_frm" id="add_eventmanager_frm" method="post" action="{{ route('eventmanager.register') }}">
            {{ csrf_field() }}
            <h3 class="tile-title text-center">Sign Up</h3>
            <div class="tile-body">
                
                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Full Name <span class="required-fields">*</span></label>
                  <input class="form-control" type="text" value="{{ old('fullname') }}" placeholder="e.g. John Doe" name="fullname" />
                  {!! $errors->first('fullname', '<p class="validation-errors">:message</p>') !!}
                </div>
                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Company Name <span class="required-fields">*</span></label>
                  <input class="form-control" type="text" value="{{ old('companyname') }}" placeholder="e.g. Quanby Ltd" name="companyname" />
                  {!! $errors->first('companyname', '<p class="validation-errors">:message</p>') !!}
                </div>
                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Email <span class="required-fields">*</span></label>
                  <input class="form-control" type="text" value="{{ old('email') }}" placeholder="e.g. john@abc.com" name="email" />
                  {!! $errors->first('email', '<p class="validation-errors">:message</p>') !!}
                </div>
                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label class="control-label">Password <span class="required-fields">*</span></label>
                  <input class="form-control" type="password" placeholder="Enter password" name="password" />
                  {!! $errors->first('password', '<p class="validation-errors">:message</p>') !!}
                </div>   

                <div class="form-group {{ $errors->has('country') ? 'has-error' : ''}}">
                  <label class="control-label">Select Country <span class="required-fields">*</span></label>
                  <select name="country" class="form-control" onchange="fetchstates(this.value)" required="required">
                    <option value="">Select Country</option>
                    @if ($countries)
                    @foreach($countries as $country)
                      <option value="{{ Hashids::encode($country->id) }}">{{ $country->name }}</option>
                    @endforeach
                    @endif
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

                @if(env('GOOGLE_RECAPTCHA_KEY'))
                  <div class="form-group {{ $errors->has('g-recaptcha-response') ? 'has-error' : ''}}">
                    <label class="control-label">Captcha <span class="required-fields">*</span></label>
                       <div class="g-recaptcha"
                            data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}">
                       </div>
                    {!! $errors->first('g-recaptcha-response', '<p class="validation-errors">:message</p>') !!}
                 </div>
                @endif
                
            </div>
            <div class="tile-footer">
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Register</button>&nbsp;&nbsp;&nbsp;<a class="" href="{{ route('eventmanager.login') }}">Back To Login</a>
            </div>

            </form>
          </div>
        </div>

   </section>

   <script src='https://www.google.com/recaptcha/api.js'></script>
  
@stop
