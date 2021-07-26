@extends('front.layouts.default')
@section('content')

<style>
  html, body {height:100%;}
  body {   
  background: #400cae; /* Old browsers */
  background: -moz-linear-gradient(left,  #400cae 0%, #250a57 100%); /* FF3.6-15 */
  background: -webkit-linear-gradient(left,  #400cae 0%,#250a57 100%); /* Chrome10-25,Safari5.1-6 */
  background: linear-gradient(to right,  #400cae 0%,#250a57 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#400cae', endColorstr='#250a57',GradientType=1 ); /* IE6-9 */
}
.fun_facts_screen {display:flex; align-items:center; height:100%;}
.thanku_screen { margin: 80px 0;}
</style>

  <div class="oc_bg_main ocf_top_left"></div>
  <div class="oc_bg_main ocf_top_right"></div>
 
    <div class="fun_facts_screen" id="thankyou-screen">

        <div class="container-fluid">
             <div class="fill_facts">
                <div class="row align-items-center">
                    <div class="col-md-5">                                
                        <div class="cf_header">
                            <div class="cf_logo"><a href="#"><img src="{{ asset('assets/front/images/ofc_wht_logo.png') }}" alt="" width="300"/></a></div>
                        </div>
                        <div class="thanku_screen text-center pt-5">
                            <h2 class="pt-5">We hope you enjoyed the event <br/> and wish you a great rest of the day!</h2>
                            <p>We hope to see you again soon. </p>
                            <h6>Thank You!!</h6>
                        </div>
                   </div>
                   <div class="col-md-7">
                        <figure><img src="{{ asset('assets/front/images/Guitarman_fire.gif') }}" class="img-fluid" alt=""/></figure>
                    </div>
                </div>                    
            </div>
         </div>
    </div>

@stop