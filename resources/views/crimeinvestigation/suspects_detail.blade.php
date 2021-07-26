@extends('crimeinvestigation.layouts.default')
@section('content')

	<div class="controller">
		<div class="strips_bg"></div>
		<div class="maginfy_strip"></div>
	</div>
	
	<div class="main_screen suspect_detials">
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
				
				<div class="profile_detail">
					<div class="profile_pin">
						<img src="{{ asset( 'assets/crime_investigation/images/photos/pin.png' ) }}" alt="" class="img-fluid">
					</div>
					<aside class="profile_left">
						<div class="profile_det">
						    <div class="profile_hdr">
                                <div class="user_pic">
                                    <img src="{{ asset( 'assets/crime_investigation/images/profile_img/'.$suspect->image) }}" alt="" class="img-fluid" />
                                </div>
                                <ul class="user_info">
                                    <li>NAME: {{$suspect->name}}</li>
                                    <li>Age: {{$suspect->age}}</li>
                                    <li>Height: {{$suspect->height}}</li>
                                    <li>Weight: {{$suspect->weight}} lbs</li>
                                    <li>Eye color: {{$suspect->eye_color}}</li>
                                    <li>Hair color: {{$suspect->hair_color}}</li>								
                                </ul>
						    </div>
							<div class="profile_des">
								<h6 class="mt-0">Short Description:</h6>
								<p>{{$suspect->description}}</p>
							</div>
							
						</div>
						<div class="profile_finger_prints">
                            <div class="suspect">
                                <img src="{{ asset( 'assets/crime_investigation/images/photos/suspects.png' ) }}" alt="" class="img-fluid" />
                            </div>
								<div class="finger_prints">
									@if( $fingerprintsSeen )
										<h5 class="fingre_print_img"><img src="{{ asset('assets/crime_investigation/images/fingerprints/'.$imagePath)}}" alt="" class="img-fluid" /></h5>
									@else
									<h5><a href="javascript:void(0);" class="view_btn">take finger prints </a></h5>
									@endif
								</div>
						</div>
					</aside>
					<aside class="profile_right">
						<div class="take-interview">
							<div class="interview_head">
								<h6>Interview:</h6>
								<h6 class="interview_btn">
									@if( $interviewSeen)
									 <span class="interviewer_name">{{$suspect->name}}</span>
									@else
										<a href="javascript:void(0);" class="view_btn py-2">Take Interview</a>
									@endif
								</h6>
								<input type="hidden" name="s_id" class="s_id" value="{{$suspect_id}}" data-url="{{ route('crimeinvestigation.take_interview') }}">
								<input type="hidden" name="encId" class="encId" value="{{$encId}}" >
								<input type="hidden" name="sname" class="sname" value="{{$suspect->name}}" data-url="{{ route('crimeinvestigation.search_house') }}">
								<input name="event_id" value="{{$event_id}}" type="hidden">
								<input name="team_id" value="{{$team_id}}" type="hidden">
								<input name="user_id" value="{{$user_id}}" type="hidden">
								<input class="asset" value="{{ asset( 'assets/crime_investigation/images/photos/' ) }}" type="hidden">
								<input class="partyphotos" value="{{ route('crimeinvestigation.partyphotos', $encId) }}" type="hidden">
								<input class="f_url" type="hidden" data-url="{{ route('crimeinvestigation.get_fingerprints') }}">
								{{ csrf_field() }}
							</div>
							<p class="interview_detail {{ $interviewSeen ? '' : 'detail_default' }}">{{ $interview }}</p>
						</div>
						@if( $houseSearched == 1 )
						<!-- Disabled search house button -->
						<div class="gloves_suspect search_house_btn search_disable text-center">
							<div class="gloves">
								<a href="javascript:void(0);" class="view_btn">Search <br>house </a>
							</div>
						</div> 
						@elseif ($houseSearched == 2 )
						<!-- Active button of search house -->
						<div class="gloves_suspect search_house_btn search_enable text-center">
							<div class="gloves">
								<a href="javascript:void(0);" class="view_btn">Search <br>house </a>
							</div>
						</div> 
						@elseif ($houseSearched == 3 )
						<!-- Bad luck image after searching house -->
						<div class="gloves_suspect gloves_show_img text-center">
							<div class="gloves">
								<img src="{{ asset( 'assets/crime_investigation/images/photos/bad_luck.png' ) }}" alt="" class="img-fluid bad_luck" />
							</div>
						</div> 
						@elseif ( $houseSearched == 4 || $houseSearched == 7 )
						<!-- gloves with paint after searching house -->
						<div class="gloves_suspect gloves_show_img text-center">
							<div class="gloves">
								<img data-status="{{ $houseSearched }}" src="{{ asset( 'assets/crime_investigation/images/photos/'.$glove_img ) }}" alt="" class="img-fluid painted_gloves" />
							</div>
						</div>
						@elseif ($houseSearched == 5 )
						<div class="gloves_suspect search_house_btn gloves_show_img text-center">
							<div class="gloves">
								<a href="{{ route('crimeinvestigation.partyphotos', $encId) }}" class=""><img src="{{ asset( 'assets/crime_investigation/images/photos/'.$glove_img ) }}" alt="" class="img-fluid" /></a>
							</div>
						</div>
						@elseif ( $houseSearched == 6 || $houseSearched == 8 )
						<div class="gloves_suspect gloves_show_img text-center">
							<div class="gloves">
								<img data-status="{{ $houseSearched }}" src="{{ asset( 'assets/crime_investigation/images/photos/'.$glove_img ) }}" alt="" class="img-fluid painted_gloves" />
							</div>
							<a id="compare_gloves" data-url="{{ route('crimeinvestigation.compare_gloves') }}" href="javascript:void(0);" class="view_btn">compare Gloves</a>
						</div>
						@else
						<div class="gloves_suspect search_house_btn search_disable text-center">
							<div class="gloves">
								<a href="javascript:void(0);" class="view_btn">Search house </a>
							</div>
						</div>
						@endif
					</aside>
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