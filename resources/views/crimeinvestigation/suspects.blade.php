@extends('crimeinvestigation.layouts.default')
@section('content')
<div class="controller">
		<div class="strips_bg"></div>
		<div class="maginfy_strip"></div>
	</div>
	
	<div class="main_screen suspects">
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
				
				<div class="profile_gallery">
						
					<?php echo $htm; ?>

				</div>
			</div>
		</div>		
	</div>

@stop
@push( 'after_scripts' )
<script src="{{ asset( 'assets/crime_investigation/js/pages/suspects.js' ) }}"></script>
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