@extends('crimeinvestigation.layouts.default')
@section('content')

<div class="controller">
		<div class="strips_bg"></div>
		<div class="maginfy_strip"></div>
	</div>
    <div class="main_screen dmv_details">		
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
				<div class="vehicle_detail">
					<div class="vehicle_hdr">
						<div class="arror_left"><a href="{{ route('crimeinvestigation.dmv', $encId) }}"> <img src="{{ asset( 'assets/crime_investigation/images/icons/arrow_left.png' ) }}" alt="" class="img-fluid"/></a></div>
						<div class="batch_logo"><img src="{{ asset( 'assets/crime_investigation/images/slices/batch_logo.png' ) }}" alt="" class="img-fluid"/></div>
					</div>				
					<aside class="vehicle_det">
						<div class="vehicle_summ">
							<div class="vehicle_shortsumm">
								<div class="vehicle_user_pic">
								<img src="{{ asset( 'assets/crime_investigation/images/profile_img/'.$guest->image ) }}" alt="" class="img-fluid" />
								</div>
									<ul class="vehicle_info">
									<li>Address_______________</li>
									<li>CONTACT INFO ______________</li>
									</ul>
							</div>
							<ul class="vehicle_info vehicle_data">
								<li>Owner  :<span> {{$guest->name}}</span></li>
								<li>vehicle number  : <span class="color_green">{{$guest->vehicle_no}}</span></li>
								<li>Car Model : ______________</li>
								<li>Vehicle color : ______________</li>
								<li>Vehicle REGISTRATION : ______________</li>
								<li>VALID UPTO : ______________</li>								
								<li>ENGINE TYPE : ______________</li>								
								<li>Vehicle INSURANCE : ______________</li>								
							</ul>
						</div>
						</div>
					</aside>
				</div>
			 </div>
			 
	</div>

@stop
@push( 'after_scripts' )
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