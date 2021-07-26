@extends('crimeinvestigation.layouts.default')
@section('content')

	<div class="controller">
		<div class="strips_bg"></div>
		<div class="maginfy_strip"></div>
	</div>
	
	<div class="main_screen overview">		
		<div class="container">
			 <div class="d-flex flex-column flex-md-row position-relative book_cover ">
				@include('crimeinvestigation.includes.menu')
				<aside class="book_lft">
					<div class="cover_lft"><img src="{{ asset( 'assets/crime_investigation/images/book_page_lft.png' ) }}" alt="" class="img-fluid"/></div>
					<div class="sticky_note_bottom"><img src="{{ asset( 'assets/crime_investigation/images/slices/sticky_note.png' ) }}" alt="Help Note" class="img-fluid" /></div>
					<div class="lft_sidebar lft_rotate">
						<h4 class="title_h5 text-center">The Missing Black Square,<br> Crime Scene:</h4>
						<p>Mr. and Mrs. Pembroke are wealthy and esteemed members of the community. On January 15th, 2020, they held a dinner party at their Walnut Grove Mansion, London. The mansion is primarily used only for holding such events, and no one lives there permanently. They invited the following guests, which included some family members and close friends. </p>
						<div class="number_list">
							<h6>Guest list:</h6>
							<ul>
								@foreach( $guests as $guest )
									<li>({{$guest->role}}) {{$guest->name}}</li>
								@endforeach
							</ul>
						</div>
						<div class="number_list">
							<h6>Home helpers:</h6>
							<ul>
								@foreach( $helpers as $helper )
									<li>({{$helper->role}}) {{$helper->name}}</li>
								@endforeach
							</ul>
						</div>
						<p>During the party, it was discovered that an enormously expensive painting &quot;The Black Square&quot; has been replaced from the dining room with a fake version.  All the guests and the 3 home helpers are in the suspect list. The original painting is still not found, and the police is not sure who, and how the crime has been committed.</p>
						<p>Once the crime was reported, police arrived at 11 pm, took the required information to file the case and let everyone leave the mansion, making sure their cars didn’t have the painting.</p>
					</div>
				</aside>
				<aside class="book_rht">
					<div class="sticky_note_top"><img src="{{ asset( 'assets/crime_investigation/images/slices/sticky_note.png' ) }}" alt="Help Note" class="img-fluid" /></div>
					<div class="cover_rht"><img src="{{ asset( 'assets/crime_investigation/images/book_page_rht.png' ) }}" alt="" class="img-fluid" /></div>
					<div class="rht_sidebar rht_rotate">
						<div class="d-flex align-items-end flex-column justify-content-end mb-3">
							<div class="remaining_team mb-2">
								<p class="mb-0">Remaining Team Lives ({{$teamname}}):</p>
							</div>
							<div class="life_screen text-right" data-src="{{asset( 'assets/crime_investigation/images/gallery' ) }}">						
							<div class="remaining_lives">
								@if($lifes == 5)
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart.svg' ) }}" class="img-fluid 1 remaining_life" width="18px">
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart.svg' ) }}" class="img-fluid 2 remaining_life" width="18px">
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart.svg' ) }}" class="img-fluid 3 remaining_life" width="18px">
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart.svg' ) }}" class="img-fluid 1 remaining_life" width="18px">
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart.svg' ) }}" class="img-fluid 2 remaining_life" width="18px">
								@elseif($lifes == 4)
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart_black.svg' ) }}" class="img-fluid 1 used_life" width="18px">
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart.svg' ) }}" class="img-fluid 3 remaining_life" width="18px">
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart.svg' ) }}" class="img-fluid 1 remaining_life" width="18px">
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart.svg' ) }}" class="img-fluid 2 remaining_life" width="18px">
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart.svg' ) }}" class="img-fluid 3 remaining_life" width="18px">
								@elseif($lifes == 3)
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart_black.svg' ) }}" class="img-fluid 1 used_life" width="18px">
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart_black.svg' ) }}" class="img-fluid 1 used_life" width="18px">
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart.svg' ) }}" class="img-fluid 1 remaining_life" width="18px">
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart.svg' ) }}" class="img-fluid 2 remaining_life" width="18px">
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart.svg' ) }}" class="img-fluid 3 remaining_life" width="18px">
								@elseif($lifes == 2)
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart_black.svg' ) }}" class="img-fluid 1 used_life" width="18px">
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart_black.svg' ) }}" class="img-fluid 1 used_life" width="18px">
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart_black.svg' ) }}" class="img-fluid 1 used_life" width="18px">
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart.svg' ) }}" class="img-fluid 2 remaining_life" width="18px">
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart.svg' ) }}" class="img-fluid 3 remaining_life" width="18px">  
								@elseif($lifes == 1)
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart_black.svg' ) }}" class="img-fluid 1 used_life" width="18px">
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart_black.svg' ) }}" class="img-fluid 1 used_life" width="18px">
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart_black.svg' ) }}" class="img-fluid 1 used_life" width="18px">
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart_black.svg' ) }}" class="img-fluid 2 used_life" width="18px">
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart.svg' ) }}" class="img-fluid 3 remaining_life" width="18px">
								@else
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart_black.svg' ) }}" class="img-fluid 1 used_life" width="18px">
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart_black.svg' ) }}" class="img-fluid 1 used_life" width="18px">
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart_black.svg' ) }}" class="img-fluid 1 used_life" width="18px">
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart_black.svg' ) }}" class="img-fluid 2 used_life" width="18px">
									<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart_black.svg' ) }}" class="img-fluid 3 used_life" width="18px">
								@endif
							</div>
						</div>
					</div>
						
						<div class="qus_ans_sec">
							<div class="title_h4">
								<h4>Questions</h4>
							</div>
							<form name="crimeinvestigation" id="crimeinvestigation" data-url="{{ route('crimeinvestigation.ci_submit') }}">
							<div id="question1" class="qus_items">
								<h6>{{ $question[1] }}</h6>
								<div class="form-group d-flex align-items-center">
									{{ csrf_field() }}
									<input name="event_id" value="{{$event_id }}" type="hidden">
									<input name="team_id" value="{{$team_id}}" type="hidden">
									<input name="user_id" value="{{$user_id}}" type="hidden">
									<input name="unlock" value="{{$unlock}}" id="unlock" type="hidden">

									<select name="ans1" class="form-controls ans1" {{ $ans1 ? 'disabled' : '' }}  required>
										<option value="0">Select time</option>
										<option value="7" {{ $ans1 == '7' ? 'selected' : '' }}>7.00 to 7.30 PM</option>
										<option value="7.3" {{ $ans1 == '7.3' ? 'selected' : '' }}>7.30 to 8.00 PM</option>
										<option value="8" {{ $ans1 == '8' ? 'selected' : '' }}>8.00 to 8.30 PM</option>
										<option value="8.3" {{ $ans1 == '8.3' ? 'selected' : '' }}>8.30 to 9.00 PM</option>
										<option value="9" {{ $ans1 == '9' ? 'selected' : '' }}>9.00 to 9.30 PM</option>
										<option value="9.5" {{ $ans1 == '9.5' ? 'selected' : '' }}>9.30 to 10.00 PM</option>
										<option value="10" {{ $ans1 == '10' ? 'selected' : '' }}>10.00 to 10.30 PM</option>
										<option value="10.3" {{ $ans1 == '10.3' ? 'selected' : '' }}>10.30 to 11.00 PM</option>
										<option value="11" {{ $ans1 == '11' ? 'selected' : '' }}>11.00 to 11.30 PM</option>
										<option value="11.3" {{ $ans1 == '11.3' ? 'selected' : '' }}>11.30 to 11.59 PM</option>
									</select>
									<div class="hint1">
										@if( in_array( 11, $hintarr) )
										<div class="hint_view">
												<a href="javascript:void(0)" class="contact_btn" data-target="#clue_block1" data-toggle="modal">!</a>
										</div>
										@endif
									</div>
								</div>
							</div>

							<div id="question2" class="qus_items">
								<h6>{{ $question[2] }}</h6>
								<div class="form-group d-flex align-items-center">
									<select  name="ans2[]" id="ans2" multiple class="selectpicker form-controls ans2" {{ $ans2 ? 'disabled' : '' }} required>
										@foreach( $guests as $guest )
											<option value="{{$guest->id}}" {{ (in_array($guest->id, explode(',',$ans2)) )? 'selected' : '' }}>({{$guest->role}}) {{$guest->name}}</option>
										@endforeach
										@foreach( $helpers as $helper )
											<option value="{{$helper->id}}" {{ (in_array($helper->id, explode(',',$ans2)) )? 'selected' : '' }}>({{$helper->role}}) {{$helper->name}}</option>
										@endforeach
									</select>
									<div class="hint2">
										@if( in_array( 12, $hintarr) )
										<div class="hint_view">
												<a href="javascript:void(0)" class="contact_btn" data-target="#clue_block2" data-toggle="modal">!</a>
										</div>
										@endif
									</div>
								</div>
							</div>
							<div id="question3" class="qus_items">
								<h6>{{ $question[3] }}</h6>
								<div class="form-group d-flex align-items-center">
									<select name="ans3[]" multiple class="selectpicker form-controls ans3" {{ $ans3 ? 'disabled' : '' }} required>
										@foreach( $guests as $guest )
											<option value="{{$guest->id}}" {{ (in_array($guest->id, explode(',',$ans3)) )? 'selected' : '' }}>({{$guest->role}}) {{$guest->name}}</option>
										@endforeach
									</select>
									<div class="hint3">
										@if( in_array( 13, $hintarr) )
										<div class="hint_view">
												<a href="javascript:void(0)" class="contact_btn" data-target="#clue_block3" data-toggle="modal">!</a>
										</div>
										@endif
									</div>
								</div>
							</div>
							<div class="qus_items">
								<div class="form-group text-right">
									<a href="javascript:void(0);" class="btn shadow submit_btn contact_btn">Submit </a>
								</div>
							</div>
							</form>
						</div>
					</div>
				</aside>
			 </div>
		</div>
	</div>
	<!-- End Main Screen -->

@stop
@push( 'after_scripts' )
<script src="{{ asset( 'assets/crime_investigation/js/pages/overview.js' ) }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>   
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