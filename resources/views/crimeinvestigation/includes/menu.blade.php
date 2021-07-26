@php 
  $currentRoute = Route::currentRouteName( );
  $evidence = ['crimeinvestigation.evidence', 'crimeinvestigation.newspapper', 'crimeinvestigation.partyphotos'];
@endphp
					
<div class="menu_navigation">
		<span class="header-icon">
			<em></em>	
			<em></em>
			<em></em>
		</span>
	<ul class="main_menu">
		<li class="overview @if( $currentRoute == 'crimeinvestigation.overview' ) active @endif"><a href="{{ route('crimeinvestigation.overview',$encId) }}" class="notification">Overview</a></li>
		<li class="mansion @if( $currentRoute == 'crimeinvestigation.mansion' ) active @endif"><a href="{{ route('crimeinvestigation.mansion',$encId) }}" class="notification">Mansion <br/>Layout</a></li>
		<li class="dmv @if( $currentRoute == 'crimeinvestigation.dmv' ) active @endif"><a href="{{ route('crimeinvestigation.dmv',$encId) }}" class="notification">DMV</a></li>
		<li class="suspects @if( $currentRoute == 'crimeinvestigation.suspects' ) active @endif"><a href="{{ route('crimeinvestigation.suspects',$encId) }}" class="notification">Suspects</a></li>
		<li class="evidence @if( in_array($currentRoute, $evidence) ) active @endif"><a href="{{ route('crimeinvestigation.evidence',$encId) }}" class="notification"><span>Evidence</span></a></li>
	</ul>	
</div>
