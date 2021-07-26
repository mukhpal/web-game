@extends('crimeinvestigation.layouts.default')
@section('content')
        <div class="controller">
		<div class="strips_bg"></div>
		<div class="maginfy_strip"></div>
	</div>
    <div class="main_screen dmv">		
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
				<ul class="dmvnote_slices">
					<li><img src="{{ asset( 'assets/crime_investigation/images/slices/getty_image.png' ) }}" alt="" class="img-fluid"/></li>
					<li><img src="{{ asset( 'assets/crime_investigation/images/slices/dmvimg_4.png' ) }}" alt="" class="img-fluid"/></li>
					<li><img src="{{ asset( 'assets/crime_investigation/images/slices/dmvimg_2.png' ) }}" alt="" class="img-fluid"/></li>
					<li><img src="{{ asset( 'assets/crime_investigation/images/slices/dmvimg_3.png' ) }}" alt="" class="img-fluid"/></li>
				</ul>
				<div class="vehicle_login">
					<div class="vehicle_detail">
						<div class="col-md-6 mx-auto vehicle_form">
							<div class="batch_logo"><img src="{{ asset( 'assets/crime_investigation/images/slices/batch_logo.png' ) }}" alt="" class="img-fluid"/></div>
							<form class="dmv-form" method="post" action="{{ route('crimeinvestigation.dmv_detail',$encId) }}">
								{{ csrf_field() }}
								<div class="form-group position-relative">
									<label>Enter Vehicle Number</label>
									<input type="text" name="vehicle_number" class="form-control w-100 rounded-pill" placeholder="XYZ 2107" required>
								</div>
								<button class="btn text-white w-75" type="submit">Search</button>
							</form>
						</div>
					</div>
				</div>
			</div>		
		</div>
	</div>
@stop
@push( 'after_scripts' )
<script>
	@if ( session()->has('popup') )
	$(document).ready(function(){
	   $("#error_dmv").modal('toggle');
	}); 
	@endif

	var CIVars = {
		gameMinutes	:	{{ $gameMinutes }},
		gameSeconds	:	{{ $gameSeconds }},
		hintMinutes	:	{{ $hintMinutes }},
		hintSeconds	:	{{ $hintSeconds }},
		encId		:	"{{$encId}}"
	};
</script>
@endpush