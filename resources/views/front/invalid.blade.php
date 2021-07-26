@extends('front.layouts.default')
@section('content')

<div class="oc_bg_main ocf_top_left"></div>
<div class="oc_bg_main ocf_top_right"></div>

  <div class="cf_header">
      <div class="cf_logo"><a href="javascript:void(0);"><img src="{{ asset('assets/front/images/ofc_logo.png') }}" alt="" width="300"/></a></div>
  </div>

  <div class="container">
    
    <section class="login-content">
         
        <div class="login-box invalid_screen text-center">

          @if ($message = Session::get('error'))
              <p>{!! $message !!}</p>
          @endif          
         
      </div>
  </section>
</div>
@stop
