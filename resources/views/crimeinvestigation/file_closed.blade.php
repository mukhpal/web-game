@extends('crimeinvestigation.layouts.default')
@section('content')
	<div class="controller">
		<div class="strips_bg"></div>
		<div class="maginfy_strip"></div>
	</div>
	
	<div class="main_screen file_closed">
		<div class="container">
			 <div class="d-flex align-items-center flex-column flex-md-row position-relative file_closed">
				@include('crimeinvestigation.includes.menu')
				
				<aside class="file_note">					
					 <img src="{{ asset( 'assets/crime_investigation/images/slices/note_help.png' ) }}" alt="Help Note" class="img-fluid" />
				</aside>
				<aside class="file_case">
					<div class="sticky_note_top"><img src="{{ asset( 'assets/crime_investigation/images/slices/sticky_note.png' ) }}" alt="Help Note" class="img-fluid" /></div>				
					<img src="{{ asset( 'assets/crime_investigation/images/file_back.png' ) }}" alt="file" class="img-fluid" />
					<img src="{{ asset( 'assets/crime_investigation/images/book_page_rht.png' ) }}" alt="" class="img-fluid book_coverht">	
					<img src="{{ asset( 'assets/crime_investigation/images/file_close.png' ) }}" alt="file" class="img-fluid file_front" />
					
				</aside>
			 </div>
			 
		</div>		
	</div>
	<!-- End Main Screen -->
@stop
@push( 'after_scripts' )
<script>
var CIVars = {
		gameMinutes	:	{{ $gameMinutes }},
		gameSeconds	:	{{ $gameSeconds }},
		hintMinutes	:	{{ $hintMinutes }},
		hintSeconds	:	{{ $hintSeconds }},
		encId		:	"{{$encId}}"
	}
</script>
@endpush