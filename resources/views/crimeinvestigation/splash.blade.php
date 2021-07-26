@extends('crimeinvestigation.layouts.default')
@section('content')

	<div class="controller">
		<div class="strips_bg"></div>
		<div class="maginfy_strip"></div>
	</div>
	
	<div class="py-2 main_screen splash">
		<div class="container-fluid">
			<div class="splash_screen">
				<div class="logo_splash text-center">
					<img src="{{ asset( 'assets/crime_investigation/images/criminal-logo.png' ) }}" alt="Criminal Investigate" width="100%" class="img-fluid" />
				</div>		
			</div>		
		</div>		
	</div>
	<!-- <a id="nextPage" href="{{ route('crimeinvestigation.file_closed', $encId) }}"></a> -->

	<!-- Modal for game Clue3-->
    <div class="modal fade" id="preloader" tabindex="-1" aria-labelledby="clue_block" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content finger_print_zoom">        
          <div class="modal-body border-bottom-0 clue_block">              
              <div class="js_title text-center text-white">
			  	<div id="loader">
				  	<i>
						<svg version="1.1" id="L4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
						<circle fill="#fff" stroke="none" cx="6" cy="50" r="6">
						<animate
						attributeName="opacity"
						dur="1s"
						values="0;1;0"
						repeatCount="indefinite"
						begin="0.1"/>
						</circle>
						<circle fill="#fff" stroke="none" cx="26" cy="50" r="6">
						<animate
						attributeName="opacity"
						dur="1s"
						values="0;1;0"
						repeatCount="indefinite"
						begin="0.2"/>
						</circle>
						<circle fill="#fff" stroke="none" cx="46" cy="50" r="6">
						<animate
						attributeName="opacity"
						dur="1s"
						values="0;1;0"
						repeatCount="indefinite"
						begin="0.3"/>
						</circle>
						</svg>
					</i>
				<span>Waiting for other teams to join.....</span>
				</div>
              </div>			
            </aside>
          </div>
        </div>
      </div>
    </div>
	<!-- end of model content -->
	
@stop
@push( 'after_scripts' )
<script src="{{ asset( 'assets/crime_investigation/js/pages/splash.js' ) }}"></script>
<script>
	// window.parent.document.getElementByClass( 'cap_video' ).classList.remove("cap_video");
var CIVars = {
		gameMinutes	:	{{ $gameMinutes }},
		gameSeconds	:	{{ $gameSeconds }},
		hintMinutes	:	{{ $hintMinutes }},
		hintSeconds	:	{{ $hintSeconds }},
		encId		:	"{{$encId}}",
		waitingOn	:	"1"

	};

	if( {{ $redirectTogame}} == 1 ){
		window.location.href =  "{{ route('crimeinvestigation.overview', $encId) }}";
	}

	if( {{ $enbleCIGame}} == 1 ){
		window.location.href =  "{{ route('crimeinvestigation.file_closed', $encId) }}";
	}
	
	$('#preloader').modal('show');
	
</script>
@endpush