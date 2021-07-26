@extends('front.layouts.default')
@section('content')

<script src="https://kemar.github.io/jquery.countdown/jquery.countdown.js"></script>
<!-- CSS added for insta slider -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
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

						<div class="play-icon-wrap">         
								<a href="#" class="play-icon paused" title="Click to play audio"><i class="play-music"><img src="{{ asset('assets/front/images/icons/music_icon.png') }}" /></i></a>         
									<label class="switch-label"><span class="switch-btn"></span></label>
						</div>

						<div class="container-fluid">
									<div class="fill_facts">

										<div class="row align-items-center">
												<div class="col-md-5">
																	<div class="cf_header">
																		<div class="cf_logo"><a href="#"><img src="{{ asset('assets/front/images/ofc_wht_logo.png') }}" alt="" width="300"/></a></div>
																</div>

																<form class="funfact-form" id="gameform" method="post" action="">

																		<input type="hidden" name="event_id" value="{{$event_id}}" />
																		<input type="hidden" name="user_id" value="{{$user_id}}" />

																		{{ csrf_field() }}
																				<div class="about_fun_facts"> 
																								<div class="timer_mem" id="quiz_timing">
																										<span class="timer_label">Answer in</span>
																												<svg width="160" height="160" xmlns="http://www.w3.org/2000/svg">
																														<g id="g_id">
																																<title>Layer 1</title>
																																<circle id="circle" class="circle_animation" r="54" cy="68" cx="68" stroke-width="7" fill="none"/>
																														</g>
																												</svg> 
																									<div>
																													<span id="timer">00:00</span>  
																														<!-- <label>Time Left</label> -->
																										</div> 
																						</div>  
																								<div id="getData">
																								</div>
																								<div class="form-group btn-container">
																										<button id="submitForm" class="btn btn-primary-pink btn-block btn-primary-black btn-radius" value="1" type="button">Submit </button>
																								</div>
																				</div> 
																		</form>
														</div>
														
																		<figure> <img src="{{ asset('assets/front/images/Guitarman_fire.gif') }}" class="img-fluid" alt=""/>                    
																		</figure>
														
												</div><!-- End Row -->
										</div>
										
										<!-- <div class="timer_mem text-center">
														<svg width="160" height="160" xmlns="http://www.w3.org/2000/svg">
																<g>
																		<title>Layer 1</title>
																		<circle id="circle" class="circle_animation" r="58" cy="62" cx="63" stroke-width="7" fill="none"/>
																</g>
														</svg> 
														<div id="qustime">
																<span id="countdowntimer"></span>
																<span class="time-remaining timer2">Question Time</span> 
														</div>
										</div>  -->

										<span id="countdowntimer" style="display:none;"></span>

							</div> <!-- End Containerfluid --> 
		</div>  
		<!-- End Fun Facts Screen -->
	
		<div class="modal fade commencing_modal" id="myModal1" role="dialog">
								<div class="modal-dialog">    
								<!-- Modal content-->
												<div class="modal-content">
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
																																				<div class="connect_icebreaker text-center">
																																								<h6>Now commencing with <strong>{{$introGameTitle}}</strong>.</h6>
																																								<p>How well do you know <br/>your teammates?</p>
																																				</div>
																																</div>  

																																<div class="col-md-7">
																																				<figure><img src="{{ asset('assets/front/images/Guitarman_fire.gif') }}" class="img-fluid" alt=""/></figure>
																																</div>

																												</div><!-- End Row -->
																												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																											<div class="ocf_bottom_right"></div>  
																				</div>      
														</div>
												</div>
								</div>
				</div>
		</div>
	
		<div class="modal fade commencing_modal" id="modal-thankyou" role="dialog">
			<div class="modal-dialog">    
				<!-- Modal content-->
				<div class="modal-content">
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
									<div class="connect_icebreaker text-center">
										<h6>Thank you for playing the <strong>{{$introGameTitle}}</strong>.</h6>
										<p>We hope you enjoyed and learned <br/>something new about your team.</p>
									</div>
								</div>  

								<div class="col-md-7">
									<figure><img src="{{ asset('assets/front/images/Guitarman_fire.gif') }}" class="img-fluid" alt=""/></figure>
								</div>

							</div><!-- End Row -->
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<div class="ocf_bottom_right"></div>  
						</div>      
					</div>
				</div>
			</div>
		</div>
</div>

<!-- Result screen model starts here -->
<div class="modal fade result_model" id="modal-result" role="dialog" style="padding:10px;"> 
	<div class="modal-dialog modal-xl modal-dialog-centered" >
		
	<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
			<h4 class="modal-title w-100 text-center text-uppercase"> Results</h4>
			<button type="button" class="close btn btn-lg result_done btn-primary-green" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">Done</span>
			</button>
		</div>
			<div class="result_screen">
				<div class="container">
					<div class="fill_facts" id="result_screen_model">
						<!-- Data to be pushed here -->
						<div class="no_ans_screen">
							<h4><img src="{{ asset('assets/front/images/sad-emoji.png') }}" class="img-fluid" alt=""/> oopss!! Game time over..</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Result screen model ends here -->
		@push( 'after_scripts' )
		<script>
				
				window.parent.document.getElementById( 'myIframe' ).classList.add( 'game-screen' );

				var gameVars = {
						gameMinuts  : "<?php echo $minutes; ?>",
						gameSeconds : "<?php echo $seconds; ?>",
						loadFunFacturl  : "<?php echo url('/').'/gamescreenajax/'.$encId?>",
						appurl : "<?php echo url('/'); ?>",
						csrf_token : "{{ csrf_token() }}",
						encId : "<?php echo $encId?>",
						event_id : "<?php echo $event_id?>",
						team_id : "<?php echo $team_id?>",
						mm_game_url : '{{ Config::get("constants.mm_url").'?enc='.$encId }}',
						ciurl  : '{{ route("crimeinvestigation.splash" , $encId ) }}',
				};

				var eventId = '{{$event_id}}';
				var team_id = '{{$team_id}}';
				var user_id = '{{$user_id}}';

				setCookie = function (cname, cvalue, exdays) {
						var d = new Date();
						d.setTime(d.getTime() + (exdays*24*60*60*1000));
						var expires = "expires="+ d.toUTCString();
						document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
				};

				getCookie = function (cname) {
						var name = cname + "=";
						var decodedCookie = decodeURIComponent(document.cookie);
						var ca = decodedCookie.split(';');
						for(var i = 0; i <ca.length; i++) {
								var c = ca[i];
								while (c.charAt(0) == ' ') {
										c = c.substring(1);
								}
								if (c.indexOf(name) == 0) {
										return c.substring(name.length, c.length);
								}
						}
						return "";
				};

				var isShown = getCookie( 'ibgs_' + eventId + '--' + team_id + '--' + user_id );
				if( !isShown ) { 

						$('#myModal1').modal('show');
								setTimeout(function() {
												setCookie(  'ibgs_' + eventId + '--' + team_id + '--' + user_id, true, 10 );
												$("button[data-dismiss]").click()
						}, 6500);

				};

				$( document ).ready(function(){ 
						$( document ).on( 'click', 'a.play-icon', function(){ 
								if( !$( this ).hasClass( 'playing' ) ) { 
										window.parent.document.getElementById( 'audio' ).play();
										$( this ).attr( 'title', 'Click here to pause audio' );
										$( this ).removeClass( 'paused' ).addClass( 'playing' );
										//$( this ).find( '.fa-play' ).removeClass( 'fa-play' ).addClass( 'fa-pause' );
								} else { 
										window.parent.document.getElementById( 'audio' ).pause();
										$( this ).attr( 'title', 'Click here to play audio' );
										$( this ).removeClass( 'playing' ).addClass( 'paused' );
									// $( this ).find( '.fa-pause' ).removeClass( 'fa-pause' ).addClass( 'fa-play' );
								}
								
								return false;
						});
				});
		</script>
		
		<script src="{{ asset('assets/front/js/gameTimerScript.js') }}"></script>
		@endpush

@stop
