@extends('crimeinvestigation.layouts.default')
@section('content')
	<div class="controller">
		<div class="strips_bg' ) }}"></div>
		<div class="maginfy_strip"></div>
	</div>
	
	<div class="main_screen old_police_report">
		<div class="container">
			 <div class="d-flex flex-column flex-md-row position-relative book_cover">
				@include('crimeinvestigation.includes.menu')
				<aside class="book_lft">
					<div class="cover_lft"><img src="{{ asset( 'assets/crime_investigation/images/book_page_lft.png' ) }}" alt="" class="img-fluid"/></div>
					<div class="sticky_note_bottom"><img src="{{ asset( 'assets/crime_investigation/images/slices/sticky_note.png' ) }}" alt="Help Note" class="img-fluid" /></div>					
				</aside>
				<aside class="book_rht">
					<div class="sticky_note_top"><img src="{{ asset( 'assets/crime_investigation/images/slices/sticky_note.png' ) }}" alt="Help Note" class="img-fluid" /></div>
					<div class="cover_rht"><img src="{{ asset( 'assets/crime_investigation/images/book_page_rht.png' ) }}" alt="" class="img-fluid" /></div>					
				</aside>
				<div class="recovery_note">
					<img src="{{ asset( 'assets/crime_investigation/images/photos/recovered_evidence.png' ) }}" alt="" class="img-fluid"/>
				</div>
				<div class="grand_note">
					<img src="{{ asset( 'assets/crime_investigation/images/photos/note_grandParty.png' ) }}" alt="" class="img-fluid"/>
				</div>
				<div class="photo_gallery">
					<div class="photo-items" onclick="lightbox(0)">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/photos/730pm.jpg' ) }}" alt="7:30PM"/>
						<span class="p-time">7:30pm</span>						 
					</div>					
					 <div class="photo-items" onclick="lightbox(1)">
						 <img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/photos/830pm.jpg' ) }}" alt=""/>
						<span class="p-time">8:30pm</span>						
					</div>
					
					<div class="photo-items" onclick="lightbox(2)">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/photos/9pm.jpg' ) }}" alt=""/>
						<span class="p-time">9:00pm</span>					 
					</div>
					<div class="photo-items" onclick="lightbox(4)">						 
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/photos/930pm.jpg' ) }}" alt=""/>
						<span class="p-time">9:30pm</span>					
					</div>
					<div class="photo-items" onclick="lightbox(5)">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/photos/1030pm.jpg' ) }}" alt=""/>
						<span class="p-time">10:30pm</span>
					</div>
				</div>
				
				<div style="display:none;">
					<div id="ninja-slider">
						<div class="slider-inner">
							<ul>
								<li class="d-flex align-items-center justify-content-center">
									<div class="party_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/photos/730pm.jpg' ) }}" alt="" class="img-fluid"/>
										 <h6>7:30pm</h6>
									</div>
								</li>
								<li class="d-flex align-items-center justify-content-center">
									<div class="party_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/photos/830pm.jpg' ) }}" alt="" class="img-fluid"/>
										 <h6>8:00pm</h6>
									</div>
								</li>
								<li class="d-flex align-items-center justify-content-center">
									<div class="party_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/photos/9pm.jpg' ) }}" alt="" class="img-fluid"/>
										 <h6>9:00pm</h6>
									</div>
								</li>
								<li class="d-flex align-items-center justify-content-center">
									<div class="party_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/photos/930pm.jpg' ) }}" alt="" class="img-fluid"/>
										 <h6>9:30pm</h6>
									</div>
								</li>
								<li class="d-flex align-items-center justify-content-center">
									<div class="party_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/photos/1030pm.jpg' ) }}" alt="" class="img-fluid"/>
										 <h6>10:30pm</h6>
									</div>
								</li>	
							</ul>
							<div id="fsBtn" class="fs-icon" title="Expand/Close"></div>
						</div>
					</div>
				</div>
				
			 </div>
			 
		</div>		
	</div>
@stop
@push( 'after_scripts' )
<script src="{{ asset( 'assets/crime_investigation/js/pages/old_police_report.js' ) }}"></script>
<script>
var CIVars = {
		gameMinutes	:	{{ $gameMinutes }},
		gameSeconds	:	{{ $gameSeconds }},
		hintMinutes	:	{{ $hintMinutes }},
		hintSeconds	:	{{ $hintSeconds }},
		encId		:	"{{$encId}}"
	};
</script>
@endpush