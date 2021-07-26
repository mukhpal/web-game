@extends('front.layouts.default')
@section('content')


<style>
  body {   
  background: #400cae; /* Old browsers */
  background: -moz-linear-gradient(left,  #400cae 0%, #250a57 100%); /* FF3.6-15 */
  background: -webkit-linear-gradient(left,  #400cae 0%,#250a57 100%); /* Chrome10-25,Safari5.1-6 */
  background: linear-gradient(to right,  #400cae 0%,#250a57 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#400cae', endColorstr='#250a57',GradientType=1 ); /* IE6-9 */
 }
 .cf_header {position:static;}
</style>

  <div class="oc_bg_main ocf_top_left"></div>
  <div class="oc_bg_main ocf_top_right"></div>

    <div class="fun_facts_screen">

        <div class="container-fluid">
             <div class="fill_facts">
                <div class="row align-items-center">
                    <div class="col-md-5">                                
                        <div class="cf_header">
                            <div class="cf_logo"><a href="#"><img src="{{ asset('assets/front/images/ofc_wht_logo.png') }}" alt="" width="300"/></a></div>
                        </div>
                        
                        <div class="welcome_txt text-center pt-5 mt-5">
                            <h4 class="pt-5 mt-5">Welcome to  <span>Office Campfire</span></h4> 
                            <p>Lets play the game</p>
                        </div>
                   </div>
                </div>

                <div class="col-md-7">
                    <figure><img src="{{ asset('assets/front/images/Guitarman_fire.gif') }}" class="img-fluid" alt=""/></figure>
                </div>
            </div>
         </div>
    </div>   


@stop
