@extends('crimeinvestigation.layouts.default')
@section('content')
	<div class="controller">
		<div class="strips_bg"></div>
		<div class="maginfy_strip"></div>
	</div>
	
	<div class="main_screen security_photos">
		<div class="container">
			<div class="d-flex flex-column flex-md-row position-relative book_cover">
				@include('crimeinvestigation.includes.menu')
				<aside class="book_lft">
					<div class="cover_lft"><img src="{{ asset( 'assets/crime_investigation/images/book_page_lft.png' ) }}" alt="book_page_lft" class="img-fluid"/></div>
					<div class="sticky_note_bottom"><img src="{{ asset( 'assets/crime_investigation/images/slices/sticky_note.png' ) }}" alt="Help Note" class="img-fluid" /></div>					
				</aside>
				<aside class="book_rht">
					<div class="sticky_note_top"><img src="{{ asset( 'assets/crime_investigation/images/slices/sticky_note.png' ) }}" alt="Help Note" class="img-fluid" /></div>
					<div class="cover_rht"><img src="{{ asset( 'assets/crime_investigation/images/book_page_rht.png' ) }}" alt="book_page_rht" class="img-fluid" /></div>					
				</aside>
				
				<div class="security_gallery">
					<a class="security-items" onclick="lightbox(0)">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/cars/entry_IFE_9451_thumb.jpg' ) }}" alt="IFE_9451"/>		
					</a>
					<a class="security-items" onclick="lightbox(1)">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/cars/entry_OFK_4643_thumb.jpg' ) }}" alt="OFK_4643"/>	
					</a>
					<a class="security-items" onclick="lightbox(2)">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/cars/entry_NHB_5010_thumb.jpg' ) }}" alt="NHB_5010"/>	
					</a>
					<a class="security-items" onclick="lightbox(3)">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/cars/entry_OIF_9444_thumb.jpg' ) }}" alt="OIF_9444"/>	
					</a>					
					<a class="security-items" onclick="lightbox(4)">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/cars/entry_IWJ_3202_thumbnail.jpg' ) }}" alt="IWJ_3202"/>	
					</a>					
					<a class="security-items" onclick="lightbox(5)">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/cars/entry_JAT_3834_thumb.jpg' ) }}" alt="JAT_3834"/>	
					</a>
					<a class="security-items" onclick="lightbox(6)">						
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/cars/entry_IKT_1487_thumb.jpg' ) }}" alt="IKT_1487"/>			
					</a>					
					<a class="security-items" onclick="lightbox(7)">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/cars/entry_ABP_5280_thumb.jpg' ) }}" alt="ABP_5280"/>										
					</a>					
					<a class="security-items" onclick="lightbox(8)">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/cars/entry_STF_9051_thumb.jpg' ) }}" alt="STF_9051"/>	
					</a>
					 <a class="security-items" onclick="lightbox(9)">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/cars/entry_GQB_1465_thumb.jpg' ) }}" alt="GQB_1465"/>				
					</a>
					<a class="security-items" onclick="lightbox(10)">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/cars/entry_MRU_3170_thumb.jpg' ) }}" alt="MRU_3170"/>	
					</a>		
					<a class="security-items" onclick="lightbox(11)">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/cars/exit_OFK_4643_thumb.jpg' ) }}" alt="OFK_4643"/>	
					</a>
					<a class="security-items" onclick="lightbox(12)">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/cars/exit_NHB_5010_thumb.jpg' ) }}" alt="NHB_5010"/>	
					</a>
					<a class="security-items" onclick="lightbox(13)">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/cars/exit_OIF_9444_thumb.jpg' ) }}" alt="OIF_9444"/>	
					</a>
					<a class="security-items" onclick="lightbox(14)">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/cars/entry_POLICE_thumb.jpg' ) }}" alt="POLICE"/>	
					</a>			
					<a class="security-items" onclick="lightbox(15)">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/cars/exit_STF_9051_thumb.jpg' ) }}" alt="STF_9051"/>	
					</a>		
					<a class="security-items" onclick="lightbox(16)">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/cars/exit_ABP_5280_thumb.jpg' ) }}" alt="ABP_5280"/>	
					</a>
					<a class="security-items" onclick="lightbox(17)">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/cars/exit_MRU_3170_thumb.jpg' ) }}" alt="MRU_3170"/>	
					</a>
					<a class="security-items" onclick="lightbox(18)">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/cars/exit_GQB_1465_thumb.jpg' ) }}" alt="GQB_1465"/>	
					</a>
					<a class="security-items" onclick="lightbox(19)">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/cars/exit_IKT_1487_thumb.jpg' ) }}" alt="IKT_1487"/>	
					</a>
					<a class="security-items" onclick="lightbox(20)">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/cars/exit_JAT_3834_thumb.jpg' ) }}" alt="JAT_3834"/>	
					</a>
					<a class="security-items" onclick="lightbox(21)">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/cars/exit_IFE_9451_thumb.jpg' ) }}" alt="IFE_9451"/>	
					</a>					
					<a class="security-items" onclick="lightbox(22)">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/cars/exit_IWJ_3202_thumb.jpg' ) }}" alt="IWJ_3202"/>	
					</a>		
					<a class="security-items" onclick="lightbox(23)">
						<img class="img-fluid" src="{{ asset( 'assets/crime_investigation/images/cars/exit_POLICE_thumb.jpg' ) }}" alt="exit_POLICE"/>	
					</a>
				
					
				</div>
				<div style="display:none;">
					<div id="ninja-slider">
						<div class="slider-inner">
							<ul>
								<li class="d-flex align-items-center justify-content-center">
									<div class="security_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/cars/entry_IFE_9451.jpg' ) }}" alt="ABP_5280" class="img-fluid"/>
									</div>
								</li>
								<li class="d-flex align-items-center justify-content-center">
									<div class="security_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/cars/entry_OFK_4643.jpg' ) }}" alt="GQB_1465" class="img-fluid"/>
									</div>
								</li>
								<li class="d-flex align-items-center justify-content-center">
									<div class="security_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/cars/entry_NHB_5010.jpg' ) }}" alt="IFE_9451" class="img-fluid"/>
									</div>
								</li>
								<li class="d-flex align-items-center justify-content-center">
									<div class="security_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/cars/entry_OIF_9444.jpg' ) }}" alt="IKT_1487" class="img-fluid"/>
									</div>
								</li>
								<li class="d-flex align-items-center justify-content-center">
									<div class="security_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/cars/entry_IWJ_3202.jpg' ) }}" alt="IWJ_3202" class="img-fluid"/>
									</div>
								</li>	
								<li class="d-flex align-items-center justify-content-center">
									<div class="security_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/cars/entry_JAT_3834.jpg' ) }}" alt="JAT_3834" class="img-fluid"/>
									</div>
								</li>	
								<li class="d-flex align-items-center justify-content-center">
									<div class="security_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/cars/entry_IKT_1487.jpg' ) }}" alt="MRU_3170" class="img-fluid"/>
									</div>
								</li>	
								<li class="d-flex align-items-center justify-content-center">
									<div class="security_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/cars/entry_ABP_5280.jpg' ) }}" alt="NHB_5010" class="img-fluid"/>
									</div>
								</li>	
								<li class="d-flex align-items-center justify-content-center">
									<div class="security_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/cars/entry_STF_9051.jpg' ) }}" alt="OFK_4643" class="img-fluid"/>
									</div>
								</li>	
								<li class="d-flex align-items-center justify-content-center">
									<div class="security_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/cars/entry_GQB_1465.jpg' ) }}" alt="OIF_9444" class="img-fluid"/>
									</div>
								</li>	
								<li class="d-flex align-items-center justify-content-center">
									<div class="security_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/cars/entry_MRU_3170.jpg' ) }}" alt="POLICE" class="img-fluid"/>
									</div>
								</li>	
								<li class="d-flex align-items-center justify-content-center">
									<div class="security_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/cars/exit_OFK_4643.jpg' ) }}" alt="STF_9051" class="img-fluid"/>
									</div>
								</li>	
								<li class="d-flex align-items-center justify-content-center">
									<div class="security_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/cars/exit_NHB_5010.jpg' ) }}" alt="ABP_5280" class="img-fluid"/>
									</div>
								</li>	
								<li class="d-flex align-items-center justify-content-center">
									<div class="security_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/cars/exit_OIF_9444.jpg' ) }}" alt="GQB_1465" class="img-fluid"/>
									</div>
								</li>
								<li class="d-flex align-items-center justify-content-center">
									<div class="security_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/cars/entry_POLICE.jpg' ) }}" alt="IFE_9451" class="img-fluid"/>
									</div>
								</li>	
								<li class="d-flex align-items-center justify-content-center">
									<div class="security_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/cars/exit_STF_9051.jpg' ) }}" alt="IKT_1487" class="img-fluid"/>
									</div>
								</li>	
								<li class="d-flex align-items-center justify-content-center">
									<div class="security_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/cars/exit_ABP_5280.jpg' ) }}" alt="IWJ_3202" class="img-fluid"/>
									</div>
								</li>	
								<li class="d-flex align-items-center justify-content-center">
									<div class="security_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/cars/exit_MRU_3170.jpg' ) }}" alt="JAT_3834" class="img-fluid"/>
									</div>
								</li>	
								<li class="d-flex align-items-center justify-content-center">
									<div class="security_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/cars/exit_GQB_1465.jpg' ) }}" alt="MRU_3170" class="img-fluid"/>
									</div>
								</li>	
								<li class="d-flex align-items-center justify-content-center">
									<div class="security_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/cars/exit_IKT_1487.jpg' ) }}" alt="NHB_5010" class="img-fluid"/>
									</div>
								</li>	
								<li class="d-flex align-items-center justify-content-center">
									<div class="security_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/cars/exit_JAT_3834.jpg' ) }}" alt="OFK_4643" class="img-fluid"/>
									</div>
								</li>	
								<li class="d-flex align-items-center justify-content-center">
									<div class="security_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/cars/exit_IFE_9451.jpg' ) }}" alt="OIF_9444" class="img-fluid"/>
									</div>
								</li>	
								<li class="d-flex align-items-center justify-content-center">
									<div class="security_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/cars/exit_IWJ_3202.jpg' ) }}" alt="POLICE" class="img-fluid"/>
									</div>
								</li>	
								<li class="d-flex align-items-center justify-content-center">
									<div class="security_popup">
										 <img src="{{ asset( 'assets/crime_investigation/images/cars/exit_POLICE.jpg' ) }}" alt="STF_9051" class="img-fluid"/>
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
<script src="{{ asset( 'assets/crime_investigation/js/pages/security_photos.js' ) }}"></script>
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