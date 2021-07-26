@extends('admin.layouts.admin')
@section('content')
	
	<main class="app-content">
      @include('admin.includes.adminbreadcrumb')
      
      <div class="row">
        <div class="col-md-12">
          <form name="settings_frm" id="game_settings" method="post" action="{{ route('admin.settingsupdate') }}">
           {{ csrf_field() }}
          

          @if ($message = Session::get('success'))
          <div class="alert alert-success alert-block" style="padding: 7px;margin-bottom: 10px;">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $message }}</strong>
          </div>
          @endif
          @if ($message = Session::get('error'))
          <div class="alert alert-danger alert-block" style="padding: 7px;margin-bottom: 10px;">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $message }}</strong>
          </div>
          @endif
          <div class="tile">
            <!-- <h3 class="tile-title">Vertical Form</h3> -->
            <div class="tile-body">
                <h3 class="tile-title">Settings</h3>

                <fieldset>
				    <legend>General</legend>

					<div class="row">
						<div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Max Team Size
							  	<span class="required-fields">*</span> 
							  </label>
							  <input class="form-control" type="text" value="{{ old('teamsize')!='' ? old('teamsize') : $settings['team_size'] }}" placeholder="e.g. 30" name="teamsize"  autocomplete="off" />
							  <span class="label_info">( Max number of users in a team.)</span>
								{!! $errors->first('teamsize', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Min Team Size <span class="required-fields">*</span> 
							  	</label>
								
							  	
							  <input class="form-control" type="text" value="{{ old('min_team_size')!='' ? old('min_team_size') : $settings['min_team_size'] }}" placeholder="e.g. 30" name="min_team_size"  autocomplete="off" />
							<span class="label_info">( Min number of users in a team.)</span>
							  {!! $errors->first('min_team_size', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Min Teams For an Event<span class="required-fields">*</span> </label>
							  <input class="form-control" type="text" value="{{ old('min_teams_for_event')!='' ? old('min_teams_for_event') : $settings['min_teams_for_event'] }}" placeholder="e.g. 30" name="min_teams_for_event"  autocomplete="off" />
							  <span class="label_info">( Min Number of teams for an Event.)</span>
							  {!! $errors->first('min_teams_for_event', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div>


						<div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Game Time <span class="required-fields">*</span>  </label>
							  <input class="form-control" type="text" value="{{ old('gametime')!='' ? old('gametime') : $settings['game_time'] }}" placeholder="e.g. 5" name="gametime" autocomplete="off" /> 
							  <span class="label_info">(In minutes)</span>
							  {!! $errors->first('gametime', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div>
						
					</div>
				</fieldset>	

				<fieldset>
				    <legend>Intro Game Settings</legend>
				    	<div class="row">
				    	<div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Awaiting Screen Time <span class="required-fields">*</span></label>
							  <input class="form-control" type="text" value="{{ old('awaintingscreentime')!='' ? old('awaintingscreentime') : $settings['awaiting_screen_time'] }}" placeholder="e.g. 30" name="awaintingscreentime"  autocomplete="off" />
							   <span class="label_info">(In minutes)</span>
							  {!! $errors->first('awaintingscreentime', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div>
					</div>
				</fieldset>
				<fieldset>
				    <legend>Ice Breaker</legend>

				     <div class="row">

				     	<div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Fun Fact Screen Time <span class="required-fields">*</span></label>
							  <input class="form-control" type="text" value="{{ old('funfacts_screen_time')!='' ? old('funfacts_screen_time') : $settings['funfacts_screen_time'] }}" placeholder="e.g. 30" name="funfacts_screen_time"  autocomplete="off" />
							   <span class="label_info">(In minutes)</span>
							  {!! $errors->first('funfacts_screen_time', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Fun Fact Screen Extra Time <span class="required-fields">*</span></label>
							  <input class="form-control" type="text" value="{{ old('funfacts_waiting_screen_time')!='' ? old('funfacts_waiting_screen_time') : $settings['funfacts_waiting_screen_time'] }}" placeholder="e.g. 30" name="funfacts_waiting_screen_time"  autocomplete="off" />
							   <span class="label_info">(In minutes)</span>
							  {!! $errors->first('funfacts_waiting_screen_time', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Quiz Time <span class="required-fields">*</span></label>
							  <input class="form-control" type="text" value="{{ old('ib_game_screen_time')!='' ? old('ib_game_screen_time') : $settings['ib_game_screen_time'] }}" placeholder="e.g. 30" name="ib_game_screen_time"  autocomplete="off" />
							   <span class="label_info">(In minutes)</span>
							  {!! $errors->first('ib_game_screen_time', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Single Question Time<span class="required-fields">*</span> </label>
							  <input class="form-control" type="text" value="{{ old('single_question_time')!='' ? old('single_question_time') : $settings['single_question_time'] }}" placeholder="e.g. 30" name="single_question_time"  autocomplete="off" />
							  <span class="label_info">(In seconds)</span>
							  {!! $errors->first('single_question_time', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Answer Screen Time   <span class="required-fields">*</span> </label>
							  <input class="form-control" type="text" value="{{ old('answer_screen_time')!='' ? old('answer_screen_time') : $settings['answer_screen_time'] }}" placeholder="e.g. 30" name="answer_screen_time"  autocomplete="off" />
							<span class="label_info">( In Seconds )</span>
							  {!! $errors->first('answer_screen_time', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div>

					</div>
				</fieldset>	

				<fieldset>
				     <legend>Ice Breaker (Truth & Lie)</legend>

				     <div class="row">

				     	<div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Statement Screen Time <span class="required-fields">*</span></label>
							  <input class="form-control" type="text" value="{{ old('statement_screen_time')!='' ? old('statement_screen_time') : $settings['statement_screen_time'] }}" placeholder="e.g. 30" name="statement_screen_time"  autocomplete="off" />
							   <span class="label_info">(In minutes)</span>
							  {!! $errors->first('statement_screen_time', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Statement Screen Extra Time <span class="required-fields">*</span></label>
							  <input class="form-control" type="text" value="{{ old('statement_waiting_screen_time')!='' ? old('statement_waiting_screen_time') : $settings['statement_waiting_screen_time'] }}" placeholder="e.g. 30" name="statement_waiting_screen_time"  autocomplete="off" />
							   <span class="label_info">(In minutes)</span>
							  {!! $errors->first('statement_waiting_screen_time', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Quiz Time <span class="required-fields">*</span></label>
							  <input class="form-control" type="text" value="{{ old('ib_tl_game_time')!='' ? old('ib_tl_game_time') : $settings['ib_tl_game_time'] }}" placeholder="e.g. 30" name="ib_tl_game_time"  autocomplete="off" />
							   <span class="label_info">(In minutes)</span>
							  {!! $errors->first('ib_tl_game_time', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div>

					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Single Question Time<span class="required-fields">*</span> </label>
							  <input class="form-control" type="text" value="{{ old('ib_tl_single_question_time')!='' ? old('ib_tl_single_question_time') : $settings['ib_tl_single_question_time'] }}" placeholder="e.g. 30" name="ib_tl_single_question_time"  autocomplete="off" />
							  <span class="label_info">(In seconds)</span>
							  {!! $errors->first('ib_tl_single_question_time', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Answer Screen Time   <span class="required-fields">*</span> </label>
							  <input class="form-control" type="text" value="{{ old('ib_tl_answer_screen_time')!='' ? old('ib_tl_answer_screen_time') : $settings['ib_tl_answer_screen_time'] }}" placeholder="e.g. 30" name="ib_tl_answer_screen_time"  autocomplete="off" />
							<span class="label_info">( In Seconds )</span>
							  {!! $errors->first('ib_tl_answer_screen_time', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div>

					</div>
				</fieldset>	
				
				 <fieldset>
				     <legend>Market Madness</legend>
					

					<div class="row">

						<div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Initial Team Cash<span class="required-fields">*</span> </label>
							  <input class="form-control" type="text" value="{{ old('team_cash')!='' ? old('team_cash') : $settings['team_cash'] }}" placeholder="e.g. 30" name="team_cash"  autocomplete="off" />
							  <span class="label_info">( Initial Team cash amount distribution for each team.)</span>
							  {!! $errors->first('team_cash', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Team Cash for each Round<span class="required-fields">*</span> </label>
							  <input class="form-control" type="text" value="{{ old('round_team_cash')!='' ? old('round_team_cash') : $settings['round_team_cash'] }}" placeholder="e.g. 30" name="round_team_cash"  autocomplete="off" />
							  <span class="label_info">( Amount distribution after each round.)</span>
							  {!! $errors->first('round_team_cash', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div>
					
						<div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Forcasting Charge<span class="required-fields">*</span> </label>
							  <input class="form-control" type="text" value="{{ old('forecasting_charge')!='' ? old('forecasting_charge') : $settings['forecasting_charge'] }}" placeholder="e.g. 30" name="forecasting_charge"  autocomplete="off" />
							  <span class="label_info">(Amount for players on forcasting)</span>
							  {!! $errors->first('forecasting_charge', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div>	 
						<!-- Market madness settings Forcasting Fields ends here.. -->

						
					</div>
	                <!-- Market madness settings Max Min Profit and loss ends here.. -->

	                <!-- Market madness settings Market Demond -->
					<div class="row">

						<!-- Market madness settings Max Min Profit and loss starts here.. -->				 
						<div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Profit/Loss Percentage<span class="required-fields">*</span> </label>
							  <input class="form-control" type="text" value="{{ old('max_loss_profit_limit')!='' ? old('max_loss_profit_limit') : $settings['max_loss_profit_limit'] }}" placeholder="e.g. 30" name="max_loss_profit_limit"  autocomplete="off" />
							  <span class="label_info">(Max or Min loss cause of forcasting in percentage)</span>
							  {!! $errors->first('max_loss_profit_limit', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Market Demand<span class="required-fields">*</span> </label>
							  <input class="form-control" type="text" value="{{ old('market_demond')!='' ? old('market_demond') : $settings['market_demond'] }}" placeholder="e.g. 30" name="market_demond"  autocomplete="off" />
							  <span class="label_info">(In lbs for each round)</span>
							  {!! $errors->first('market_demond', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Market Money<span class="required-fields">*</span></label>
							  <input class="form-control" type="text" value="{{ old('market_cost')!='' ? old('market_cost') : $settings['market_cost'] }}" placeholder="e.g. 30" name="market_cost"  autocomplete="off" />
							   <span class="label_info">(Market cost against Market Demand)</span>
							  {!! $errors->first('market_cost', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div>
					
							
					</div>				
						<!-- Market madness settings Foreign productions -->
					<div class="row">
						<div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Foreign Producer Amounts<span class="required-fields">*</span></label>
							  <input class="form-control" type="text" value="{{ old('foreign_production_amount')!='' ? old('foreign_production_amount') : $settings['foreign_production_amount'] }}" placeholder="e.g. 30" name="foreign_production_amount"  autocomplete="off" />
							   <span class="label_info">(Options that foreign producer can produce in lbs, separate)</span>
							  {!! $errors->first('foreign_production_amount', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div>	
						<!-- MM round /chance fields starts here-->					 
						<div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Total Rounds<span class="required-fields">*</span> </label>
							  <input class="form-control" type="text" value="{{ old('total_rounds')!='' ? old('total_rounds') : $settings['total_rounds'] }}" placeholder="e.g. 30" name="total_rounds"  autocomplete="off" />
							  <span class="label_info">(Number of rounds in Market Madness game)</span>
							  {!! $errors->first('total_rounds', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Time for a Round<span class="required-fields">*</span> </label>
							  <input class="form-control" type="text" value="{{ old('chance_time')!='' ? old('chance_time') : $settings['chance_time'] }}" placeholder="e.g. 30" name="chance_time"  autocomplete="off" />
							  <span class="label_info">(In seconds only)</span>
							  {!! $errors->first('chance_time', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div>
						<!-- <div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Total Chance<span class="required-fields">*</span> </label>
							  <input class="form-control" type="text" value="{{ old('chance_in_round')!='' ? old('chance_in_round') : $settings['chance_in_round'] }}" placeholder="e.g. 30" name="chance_in_round"  autocomplete="off" />
							  <span class="label_info">(Number of chances in single round)</span>
							  {!! $errors->first('chance_in_round', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div> -->

						
					</div>
					
					<div class="row">
						<!-- <div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Time for a chance<span class="required-fields">*</span> </label>
							  <input class="form-control" type="text" value="{{ old('chance_time')!='' ? old('chance_time') : $settings['chance_time'] }}" placeholder="e.g. 30" name="chance_time"  autocomplete="off" />
							  <span class="label_info">(In seconds only)</span>
							  {!! $errors->first('chance_time', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Chance Result Time<span class="required-fields">*</span></label>
							  <input class="form-control" type="text" value="{{ old('chance_result_time')!='' ? old('chance_result_time') : $settings['chance_result_time'] }}" placeholder="e.g. 30" name="chance_result_time"  autocomplete="off" />
							   <span class="label_info">(Timer for chance result in seconds)</span>
							  {!! $errors->first('chance_result_time', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div> -->

						<div class="col-md-4">
							<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
							  <label class="control-label">Round Result Time<span class="required-fields">*</span> </label>
							  <input class="form-control" type="text" value="{{ old('round_results_time')!='' ? old('round_results_time') : $settings['round_results_time'] }}" placeholder="e.g. 30" name="round_results_time"  autocomplete="off" />
							  <span class="label_info">(Timer for round result in seconds)</span>
							  {!! $errors->first('round_results_time', '<p class="validation-errors">:message</p>') !!}
							</div>
						</div>
					</div>
                
                </fieldset><!-- MM round /chance fields ends here-->
            </div>
            <div class="tile-footer">
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="{{ route('admin.dashboard') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
            </div>
          </div>

          </form>

        </div>
        
        <div class="clearix"></div>        
      </div>

    </main>
 <!-- /.content-wrapper -->
@endsection