@extends('crimeinvestigation.layouts.default')
@section('content')
	<div class="controller">
		<div class="strips_bg"></div>
		<div class="maginfy_strip"></div>
	</div>
	
	<div class="main_screen evidence">		
		<div class="container">
			 <div class="d-flex flex-column flex-md-row position-relative book_cover evidence_sec">
				@include('crimeinvestigation.includes.menu')
				<aside class="book_lft">
					<div class="cover_lft"><img src="{{ asset( 'assets/crime_investigation/images/book_page_lft.png' ) }}" alt="" class="img-fluid"/></div>
					<div class="sticky_note_bottom"><img src="{{ asset( 'assets/crime_investigation/images/slices/sticky_note.png' ) }}" alt="Help Note" class="img-fluid" /></div>					
				</aside>
				<aside class="book_rht">
					<div class="sticky_note_top"><img src="{{ asset( 'assets/crime_investigation/images/slices/sticky_note.png' ) }}" alt="Help Note" class="img-fluid" /></div>
					<div class="cover_rht"><img src="{{ asset( 'assets/crime_investigation/images/book_page_rht.png' ) }}" alt="" class="img-fluid" /></div>					
				</aside>
				<div class="profile_pin_evediance">
						<img src="{{ asset( 'assets/crime_investigation/images/photos/pin.png' ) }}" alt="" class="img-fluid">
					</div>
				<div class="gallery_evidence">
					<div class="gallery-item">
						<a href="{{ route('crimeinvestigation.newspapper', $encId) }}"><img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/gallery/investigate_2.png' ) }}" alt=""/></a>
					</div>
					@if( $securityPhotosStatusSeen )
					<div class="gallery-item">
						<a href="{{ route('crimeinvestigation.security_photos', $encId) }}"><img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/gallery/investigate_1.png' ) }}" alt=""/></a>
					</div>
					@else
					<div class="gallery-item">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/gallery/evdience_blank.png' ) }}" alt=""/>
					</div>
					@endif
					@if( $partyPhotosSeen )
					<div class="gallery-item">
						<a href="{{ route('crimeinvestigation.partyphotos', $encId) }}"><img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/gallery/investigate_3.png' ) }}" alt=""/></a>
					</div>
					@else
					<div class="gallery-item">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/gallery/evdience_blank.png' ) }}" alt=""/>
					</div>
					@endif
					@if( $policeReportSeen )
					<div class="gallery-item">
						<a href="javascript:void(0);" onclick="lightbox(0)"><img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/gallery/investigate_4.png' ) }}" alt=""/></a>
					</div>
					@else
					<div class="gallery-item">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/gallery/evdience_blank.png' ) }}" alt=""/>
					</div>
					@endif
					<!-- <div class="gallery-item">
						<a href="javascript:void(0);" data-toggle="modal" data-target="#view_evidence"><img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/gallery/gloves.png' ) }}" alt="" width="130"/></a>
					</div> -->
					@if( $lampSeen )
					<div class="gallery-item lamps">
						<a href="javascript:void(0);" class="lamp"><img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/gallery/lamp.png' ) }}" alt="" width="130"/></a>
					</div> 
					@else
					<div class="gallery-item">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/gallery/evdience_blank.png' ) }}" alt=""/>
					</div>
					@endif

				</div>
			 </div>			 
		</div>	
				{{ csrf_field() }}
				<input name="event_id" value="{{$event_id}}" type="hidden">
				<input name="team_id" value="{{$team_id}}" type="hidden">
				<input name="user_id" value="{{$user_id}}" type="hidden">
				<input class="ts_url" type="hidden" data-url="{{ route('crimeinvestigation.catch_thief') }}">
				<input class="ms_url" type="hidden" data-url="{{ route('crimeinvestigation.search_mansion', $encId) }}">
				<input class="m_url" type="hidden" data-url="{{ route('crimeinvestigation.mansion', $encId) }}">
				
		<div style="display:none;">
			<div id="ninja-slider">
				<div class="slider-inner">
					<ul>
						<li class="d-flex align-items-center justify-content-center">
							<div class="news-article">
								<hgroup class="news_title">
									<h3>POLICE REPORT</span></h3>
								</hgroup>
									<ul class="police_detail">
										<li>Case No.</li>
										<li>Date : May 27, 2005</li>
										<li>Reporting officer</li>
										<li>Prepared by</li>
									</ul>
								<div class="text-left popup_content">
									<h5 class="mb-0">THE VANISHING SUSPECT?</h5><br/>
									<p>In one of the Great Britain’s most exclusive island retreat mansions, a suspect was detained in the Walnut Grove Mansion’s dining room until police could arrive on scene. The suspect, Blake Ashford, was caught attempting to steal a very expensive diamond within the mansion. It is unknown his connection to the mansion’s current owners, the Bromley family. The Bromley’s had come home from a day on their yacht when they found Mr. Ashford breaking open a safe. Gregory Bromley and one of his adult sons confronted Mr. Ashford whom attempted to escape. Mr. Bromley and his adult son detained Mr. Ashford in the dining room, the closest room nearby and locked the door from the outside and called police. When the police arrived and opened the locked door, they found Mr. Ashford had disappeared from the room. There were no windows in the dining room and no other rooms connecting to the dining room. Mr. Ashford is no stranger to crime. He has been charged with numerous burglaries. Police are asking the public for help apprehending him.</p>
								</div>
								<div class="police_data">
								</div>
								<div class="row align-items-center justify-content-between">
									@if( !$thiefSeen )
									<a class="catch_theif contact_btn" href="#" >
										Catch <br/> Old Thief
										<!-- <img src="{{ asset( 'assets/crime_investigation/images/photos/catch_old.png' ) }}" alt="" class="oldimg" /> -->
									</a>
									@else
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/bad_job.png' ) }}" alt="" class="img-fluid" />
									@endif
									@if( !$mansionSeen )
									<a class="search_mansion contact_btn" href="#" >
										search <br/>mansion
									</a>
									@else
									<a href="{{ route('crimeinvestigation.mansion', $encId) }}" class="contact_btn">View <br/>Details </a>
									@endif
								</div>
							</div>
						</li>
					</ul> 
					<div id="fsBtn" class="fs-icon" title="Expand/Close"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Main Screen -->
@stop
@push( 'after_scripts' )
<script src="{{ asset( 'assets/crime_investigation/js/pages/evidence.js' ) }}"></script>
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