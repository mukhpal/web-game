<!-- Good Job Modal -->
    <div class="modal fade" id="good_job" tabindex="-1" aria-labelledby="good_job" aria-hidden="true">
      <div class="button_cross">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true"><img src="{{ asset( 'assets/crime_investigation/images/icons/close_icon.png' ) }}" alt="" class="img-fluid"/></span>
        </button>
      </div>  
        <div class="modal-dialog mx-auto modal-dialog-centered">    
        <div class="modal-content result_view">         
          <div class="modal-body">
            <div class="text-center">
              <figure><img src="{{ asset( 'assets/crime_investigation/images/gallery/Good_job.png' ) }}" alt="" width="130"/></figure>
              <div class="js_title pt-3">
                <h6><strong class="good_job_msg">The original painting has been <br/>found in a secret corridor</strong></h6>
              </div>
            </div>
          </div>
        </div>
        </div>
    </div>
    <!-- end of model content -->
    <!-- bad luck Modal -->
    <div class="modal fade" id="bad_luck" tabindex="-1" aria-labelledby="bad_luck" aria-hidden="true">
      <div class="button_cross">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true"><img src="{{ asset( 'assets/crime_investigation/images/icons/close_icon.png' ) }}" alt="" class="img-fluid"/></span>
        </button>
      </div>  
        <div class="modal-dialog mx-auto modal-dialog-centered">    
        <div class="modal-content result_view">         
          <div class="modal-body">
            <div class="text-center">
              <figure><img src="{{ asset( 'assets/crime_investigation/images/gallery/bad_job.png' ) }}" alt="" width="130"/></figure>
              <div class="js_title pt-3">
                <h6><strong class="bad_luck_msg">The old thief could not be located</strong></h6>
              </div>
            </div>              
          </div>            
        </div>
        </div>
    </div>
    <!-- end of model content -->
    <!-- Modal case solved-->
		<div class="modal fade" id="case_solved" tabindex="-1" aria-labelledby="view-result" aria-hidden="true">
     
		  	<div class="modal-dialog modal-lg modal-dialog-centered">			
			<div class="cover_full">
			<div class="trophy">
				<img src="{{ asset( 'assets/crime_investigation/images/result-screen/cup.png' ) }}" alt="" class="img-fluid">
			</div>
			<div class="single_star">
				<img src="{{ asset( 'assets/crime_investigation/images/result-screen/single_star.png' ) }}" alt="" class="img-fluid">
			</div>
			<div class="stars">
				<img src="{{ asset( 'assets/crime_investigation/images/result-screen/stars.png' ) }}" alt="" class="img-fluid">
			</div>
			<div class="modal-content result_detail">					
				  <div class="modal-header text-center">
					<h5 class="modal-title case_title" id="view-result">Congratulations!</h5>
				  </div>
				  <div class="modal-body">
						<aside class="result_screen">
							<div class="case_det text-center case_solved">
								<figure><img src="{{ asset( 'assets/crime_investigation/images/result-screen/case_solved.png' ) }}" alt="" /></figure>
							</div>
							<div class="player_list">
								<div class="player_title">
									<h3 class="case_solved_teamname">Team 1</h3>
								</div>
								<ul class="row align-items-center justify-content-center case_solved_team_members">
									<li class="col-3 col-md-2"><div class="player_img"><img src="{{ asset( 'assets/crime_investigation/images/profile_img/img_001.jpg' ) }}" alt="" class="img-fluid" /><h5 class="text-center">joe</h5></div></li>
									<li class="col-3 col-md-2"><div class="player_img"><img src="{{ asset( 'assets/crime_investigation/images/profile_img/img_002.jpg' ) }}" alt="" class="img-fluid" /><h5 class="text-center">joe</h5></div></li>
									<li class="col-3 col-md-2"><div class="player_img"><img src="{{ asset( 'assets/crime_investigation/images/profile_img/img_006.jpg' ) }}" alt=""  class="img-fluid" /><h5 class="text-center">joe</h5></div></li>
									<li class="col-3 col-md-2"><div class="player_img"><img src="{{ asset( 'assets/crime_investigation/images/profile_img/img_004.jpg' ) }}" alt="" class="img-fluid" /><h5 class="text-center">joe</h5></div></li>
									<li class="col-3 col-md-2"><div class="player_img"><img src="{{ asset( 'assets/crime_investigation/images/profile_img/img_005.jpg' ) }}" alt="" class="img-fluid" /><h5 class="text-center">joe</h5></div></li>
								</ul>
								
							</div>
						
						</aside>
				  </div>
					  <div class="modal-footer justify-content-center">
						<div class="view_result">
							<a href="#actually_happened" data-toggle="modal" data-dismiss="modal" class="btn contact_btn">
                View result
              </a>
						</div>
					  </div>
				  </div>
				</div>
		  	</div>
		</div>
			<!-- end of model content -->
    <!-- Modal CASE UNSOLVED-->
    <div class="modal fade" id="unsolved_case" tabindex="-1" aria-labelledby="view-result" aria-hidden="true">
      
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="cover_full">      
          <div class="modal-content result_detail">         
            <div class="modal-header text-center">
              <h5 class="modal-title case_title" id="view-result">BETTER LUCK NEXT TIME!</h5>
            </div>
            <div class="modal-body">
              <aside class="result_screen">
                <div class="case_det text-center case_solved">
                  <figure><img src="{{ asset( 'assets/crime_investigation/images/result-screen/case_unsolved.png' ) }}" alt="" /></figure>
                </div>
                <div class="player_list">
                  <div class="player_title">
                    <h3 class="case_unsolved_teamname">Team 1</h3>
                  </div>
                  <ul class="row align-items-center justify-content-center case_unsolved_team_members">
                    <li class="col-3 col-md-2"><div class="player_img"><img src="{{ asset( 'assets/crime_investigation/images/profile_img/img_001.jpg' ) }}" alt="" /><h5>joe</h5></div></li>
                    <li class="col-3 col-md-2"><div class="player_img"><img src="{{ asset( 'assets/crime_investigation/images/profile_img/img_002.jpg' ) }}" alt="" /><h5>joe</h5></div></li>
                    <li class="col-3 col-md-2"><div class="player_img"><img src="{{ asset( 'assets/crime_investigation/images/profile_img/img_006.jpg' ) }}" alt="" /><h5>joe</h5></div></li>
                    <li class="col-3 col-md-2"><div class="player_img"><img src="{{ asset( 'assets/crime_investigation/images/profile_img/img_004.jpg' ) }}" alt="" /><h5>joe</h5></div></li>
                    <li class="col-3 col-md-2"><div class="player_img"><img src="{{ asset( 'assets/crime_investigation/images/profile_img/img_005.jpg' ) }}" alt="" /><h5>joe</h5></div></li>
                  </ul>
                </div>
              </aside>
            </div>
            <div class="modal-footer justify-content-center">
              <a href="#actually_happened" data-toggle="modal" data-dismiss="modal">
              <a href="#actually_happened" data-toggle="modal" data-dismiss="modal" class="btn contact_btn">
                View result
              </a>
              </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <!-- end of model content -->
  <!-- choose Invalid number Modal -->
    <div class="modal fade getting_fingerprint" tabindex="-1" aria-labelledby="getting_fingerprint" aria-hidden="true">
      <div class="modal-dialog mx-auto modal-dialog-centered">    
        <div class="modal-content">         
          <div class="modal-body">
            <div class="text-center">
              <div class="js_title pb-0">
                <h6 class="error mb-0 timer_msg"></h6>
                <div class="number_count">
                  <span id="timer_val"></span>
                </div>
              </div>
            </div>              
          </div>        
        </div>
      </div>
    </div> 
    <!-- end of model content -->
    <!-- Model for what actually happened”-->
      <div class="modal fade" id="actually_happened" tabindex="-1" aria-labelledby="result-view" aria-hidden="true">
      <div class="button_cross">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true"><img src="{{ asset( 'assets/crime_investigation/images/icons/close_icon.png' ) }}" alt="" class="img-fluid"/></span>
        </button>
      </div>        
      <div class="modal-dialog mx-auto modal-dialog-centered modal-lg">   
        <div class="seceret_corridor modal-content actually_happened">
          <div class="modal-header pb-0 border-bottom-0 justify-content-center text-center">
            <h4>Here’s what actually happened</h4>
          </div>  
            <div class="modal-body pt-0">
              <div class="pt-2 commited_crime">
                <p>
                  Crime was committed by Professor Charles Ives and Mrs. Marcia Pembroke 
                  </p> <p>
                    Professor Ives is a crazy art thief. He is obsessed with famous paintings and believes only he understands and appreciates them, thus, only he deserves to control the work. He has sold a couple of famous paintings he created and used the money to help finance theft of missing paintings referenced in the newspaper articles. The Black Square was next on his list.
                  </p> <p>
                  Mrs. Pembroke is a very successful criminal attorney but wasn’t getting any new clients. She used her previous experiences and her knowledge of the mansion to concoct a plan with Professor Ives to hide the painting in the corridor and replace it with a fake one, to remove at a later time. She wanted to take the money and use it to start her own law firm to represent high profile entertainers.
                  </p>
                  <ol type="I">
                    <li>4:00 pm: Hostess enters the mansion first, with a fake painting (painted by Professor Ives)</li>
                    <li>4:10 pm: Hostess hides the fake painting in the attic above the dining room</li>
                    <li>4:30 pm: Home helpers come to the mansion</li>
                    <li>7:00 pm: Guests start coming to the mansion</li>
                    <li>9:05 pm: Professor faints</li>
                    <li>9:10 pm: People take him to the lounge and are around the professor</li>
                      <ol type="1">
                        <li>9:11 pm: While people are around the professor in the lounge, the hostess skips</li>
                        <li>9:12 pm: Locks the restroom from outside (she has the keys of the mansion)</li>
                        <li>9:13 pm: Goes to dining room, replaces the painting from the one in the attic</li>
                        <li>9:15 pm: Moves the original painting to the secret corridor, texts the professor “I am here” and waits there</li>
                      </ol>
                    <li>9:20 pm: People go back to the dining room, while professor is resting in the lounge</li>
                    <li>9:21 pm: Professor pulls the sconce in the lounge, which enables the corridor exit door but also unknowingly puts a wet paint mark on his gloves.</li>
                    <li>9:21 pm: Hostess exits from the corridor and enters the restroom</li>
                    <li>9:22 pm: Hostess comes out of the restroom and rejoins the party</li>
                  </ol>
                </p>
              </div>
            </div>
          </div>
        </div>
    </div>
    <!-- end of model content -->
      <!-- choose Invalid number Modal -->
  <div id="error_dmv" class="modal fade error_dmv" tabindex="-1" aria-labelledby="error-dmv" aria-hidden="true">
      <div class="modal-dialog mx-auto modal-dialog-centered">    
      <div class="modal-content">         
        <div class="modal-body">
          <div class="text-center">
            <div class="js_title pb-0">
              <h6 class="error mb-0"> Invalid number</h6>
            </div>
          </div>              
        </div>
        <div class="modal-footer justify-content-center border-top-0 pt-0">
          <div class="view_result">
            <a href="#" class="invalid_btn rounded-pill mr-0" data-dismiss="modal" aria-label="Close">ok</a>
          </div>
        </div> 
      </div>
      </div>
  </div> 
  <!-- end of model content -->
  <!-- How did the police find secret corridor -->
    <div class="modal fade" id="found_corridor" tabindex="-1" aria-labelledby="result-view" aria-hidden="true">
      <div class="button_cross">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true"><img src="{{ asset( 'assets/crime_investigation/images/icons/close_icon.png' ) }}" alt="" class="img-fluid"/></span>
        </button>
      </div>        
      <div class="modal-dialog mx-auto modal-dialog-centered modal-lg">   
        <div class="seceret_corridor modal-content found_corridor">
          <div class="modal-header pb-0 border-bottom-0 justify-content-center">
            <h4>How did the police find the secret corridor?</h4>
          </div>  
            <div class="modal-body pt-0">
              <div class="pt-2 commited_crime text-left">
                  <p>
                  On further searching the mansion, police discovered a secret corridor in the mansion, which had the missing Black Square painting.
                    </p> <p>
                  While police were searching the mansion’s dining room, an officer got tired and sat on the couch at the south end of the room. While resting, the officer found a hidden button under the armrest. When he pressed it, his couch moved to the hidden corridor and an empty couch swapped into the dining room.
                  </p> <p>
                  The other couch was an exact replica of the couch in the dining room.
                  </p> <p>
                  Seeing this, the other officers tried pressing the same hidden button, but it was not working anymore.
                  </p> <p>
                  The officer in the secret corridor then found the missing painting and an exit into the backside of the restroom.
                  </p> <p>
                  But the exit was disabled and the officer was trapped. The officer was in constant communication with the rest of the team via phone, but had no way out.
                  </p> <p>
                  A team of technicians was then called to the mansion who figured that a sconce in the lounge has to be pulled in-order to enable the exit door from the secret corridor to the restroom. This also re-enables the hidden button under the armrest of the couch in the dining room.
                  </p> <p>
                  The officer was then rescued along with the painting.
                  </p> <p>
                  This discovery also explains how in 2005, the thief “Blake Ashford” disappeared from the dining room when the mansion was owned by the Bromley family.
                  </p>
              </div>
            </div>
          </div>
        </div>
    </div>
    <!-- end of model content -->
    <!-- Modal for professors gloves found-->
    <div class="modal fade" id="found_gloves" tabindex="-1" aria-labelledby="view-evidence" aria-hidden="true">
      <div class="button_cross">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true"><img src="{{ asset( 'assets/crime_investigation/images/icons/close_icon.png' ) }}" alt="" class="img-fluid"/></span>
        </button>
      </div>  
        <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content evidence_detail">
            
          <div class="modal-header m-auto border-bottom-0">
            <h5 class="modal-title text-center new_evidence search_house_title" id="">Congratulations!</h5>
          </div>
          <div class="modal-body border-bottom-0">
              <aside class="result_screen">
                <div class="case_det text-center">
                  <figure><img class="gloves_img" src="{{ asset( 'assets/crime_investigation/images/gallery/gloves.png' ) }}" alt="" /></figure>
                </div>
                <div class="player_list">
                  <div class="player_title">
                    <h4 class="text-white search_house_msg">In seraching the Professors house you found glove with paint stains on it</h4>
                  </div>
                </div>              
              </aside>
          </div>          
        </div>
      </div>
    </div>
    <!-- end of model content -->
    <!-- Modal for zoomin fingerprint-->
    <div class="modal fade" id="prnt_fingr" tabindex="-1" aria-labelledby="prnt_fingr" aria-hidden="true">
      <div class="button_cross">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true"><img src="{{ asset( 'assets/crime_investigation/images/icons/close_icon.png' ) }}" alt="" class="img-fluid"/></span>
        </button>
      </div>        
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content finger_print_zoom">
          <div class="modal-body border-bottom-0">
              <div class="text-center">
                <figure><img src="{{ asset( 'assets/crime_investigation/images/fingerprints/1_full.jpg' ) }}" alt="" class="img-fluid fngr_img"/></figure>
              </div>
            </aside>
          </div>
        </div>
      </div>
    </div>
    <!-- end of model content -->
      <!-- Modal for incorrect_ans hearts-->
    <div class="modal fade" id="incorrect_ans" tabindex="-1" aria-labelledby="prnt_fingr" aria-hidden="true">
      <div class="button_cross">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true"><img src="{{ asset( 'assets/crime_investigation/images/icons/close_icon.png' ) }}" alt="" class="img-fluid"/></span>
        </button>
      </div>        
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content finger_print_zoom">
          <div class="modal-body border-bottom-0">
              <div class="popupLifes">
                <div class="remaining_lives d-flex align-items-center justify-content-center">
						    	<img src="{{ asset( 'assets/crime_investigation/images/gallery/heart_black.svg' ) }}" class="img-fluid 1 used_life">
                  <img src="{{ asset( 'assets/crime_investigation/images/gallery/heart.svg' ) }}" class="img-fluid 2 remaining_life">
                  <img src="{{ asset( 'assets/crime_investigation/images/gallery/heart.svg' ) }}" class="img-fluid 3 remaining_life">
                  <img src="{{ asset( 'assets/crime_investigation/images/gallery/heart.svg' ) }}" class="img-fluid 2 remaining_life">
                  <img src="{{ asset( 'assets/crime_investigation/images/gallery/heart.svg' ) }}" class="img-fluid 3 remaining_life">
                </div>
              </div>
              <div class="js_title pt-5 text-center">
                <h3 class="text-white">Incorrect Answer! <br/> Deducted one team life.</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end of model content -->
      <!-- Modal for game Clue1-->
      <div class="modal fade" id="clue_block1" tabindex="-1" aria-labelledby="clue_block" aria-hidden="true">
      <div class="button_cross">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true"><img src="{{ asset( 'assets/crime_investigation/images/icons/close_icon.png' ) }}" alt="" class="img-fluid"/></span>
        </button>
      </div>        
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content finger_print_zoom">        
          <div class="modal-body border-bottom-0 clue_block">              
              <div class="js_title pt-3 text-center text-white">
                <h2 class="text-uppercase">Clue</h2>
                <p>Reporters take pictures</p>
              </div>
            </aside>
          </div>
        </div>
      </div>
    </div>
    <!-- end of model content -->
     <!-- Modal for game Clue2-->
     <div class="modal fade" id="clue_block2" tabindex="-1" aria-labelledby="clue_block" aria-hidden="true">
      <div class="button_cross">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true"><img src="{{ asset( 'assets/crime_investigation/images/icons/close_icon.png' ) }}" alt="" class="img-fluid"/></span>
        </button>
      </div>        
      <div class="modal-dialog modal-lg modal-dialog-centered ">
        <div class="modal-content finger_print_zoom">        
          <div class="modal-body border-bottom-0 clue_block">              
              <div class="js_title pt-3 text-center text-white">
                <h2 class="text-uppercase">Clue</h2>
                <p>You need to be in the mansion to commit the crime.</p>
              </div>
            </aside>
          </div>
        </div>
      </div>
    </div>
    <!-- end of model content -->
    <!-- Modal for game Clue3-->
    <div class="modal fade" id="clue_block3" tabindex="-1" aria-labelledby="clue_block" aria-hidden="true">
      <div class="button_cross">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true"><img src="{{ asset( 'assets/crime_investigation/images/icons/close_icon.png' ) }}" alt="" class="img-fluid"/></span>
        </button>
      </div>        
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content finger_print_zoom">        
          <div class="modal-body border-bottom-0 clue_block">              
              <div class="js_title pt-3 text-center text-white">
                <h2 class="text-uppercase">Clue</h2>
                <p>Accomplice</p>
              </div>
            </aside>
          </div>
        </div>
      </div>
    </div>
    <!-- end of model content -->