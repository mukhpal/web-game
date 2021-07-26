<!-- Navbar-->
  <header class="app-header"><a class="app-header__logo" href="{{route( 'eventmanager.dashboard' )}}">Event Manager</a>
    <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    <!-- Navbar Right Menu-->
    <ul class="app-nav">
      <!-- User Menu-->
      <li class="dropdown"><a class="app-nav__item" href="javascript:void(0);" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
        <ul class="dropdown-menu settings-menu dropdown-menu-right">
          <li><a class="dropdown-item" href="{{ route('eventmanager.profile') }}"><i class="fa fa-user fa-lg"></i> Profile</a></li>
          <li><a class="dropdown-item" href="{{ route('eventmanager.logout') }}"><i class="fa fa-sign-out fa-lg"></i> Sign out</a></li>
        </ul>
      </li>
    </ul>
  </header>



    <!-- Sidebar menu-->
  <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
  <aside class="app-sidebar">
    <div class="app-sidebar__user"><!-- <img class="app-sidebar__user-avatar" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg" alt="User Image"> -->&nbsp;&nbsp;<i class="app-sidebar__user-avatar app-menu__icon fa fa-user-circle fa-3x"></i>
      <div style="margin-left: 10px;">
        <p class="app-sidebar__user-name">{{session('managername')}}</p>
        <p class="app-sidebar__user-designation">{{session('companyname')}}</p> 
        <p class="app-sidebar__user-designation">{{session('manager_timezone')}}</p> 
      </div>
    </div>
    
    @php 
      $currentRoute = Route::currentRouteName( );
    @endphp

    <ul class="app-menu">
      <li><a class="app-menu__item @if( $currentRoute == 'eventmanager.dashboard' ) active @endif" href="{{ route('eventmanager.dashboard') }}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>   
      <li><a class="app-menu__item @if( $currentRoute == 'eventmanager.userlist' || $currentRoute == 'eventmanager.adduser' || $currentRoute == 'eventmanager.edituser' ) active @endif" href="{{ route('eventmanager.userlist') }}"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Manage Users</span></a></li>     
      <li><a class="app-menu__item @if( $currentRoute == 'eventmanager.teamlist' || $currentRoute == 'eventmanager.addteam' || $currentRoute == 'eventmanager.editteam' ) active @endif" href="{{ route('eventmanager.teamlist') }}"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Manage Teams</span></a></li>  
      <li><a class="app-menu__item @if( $currentRoute == 'eventmanager.eventlist' || $currentRoute == 'eventmanager.addevent' || $currentRoute == 'eventmanager.editevent' ) active @endif" href="{{ route('eventmanager.eventlist') }}"><i class="app-menu__icon fa fa-calendar-o"></i><span class="app-menu__label">Manage Events</span></a></li>
      <li><a class="app-menu__item @if( $currentRoute == 'eventmanager.surveylist' ) active @endif" href="{{ route('eventmanager.surveylist') }}"><i class="app-menu__icon fa fa-comment"></i><span class="app-menu__label">Survey</span></a></li>  
    </ul>
  </aside>