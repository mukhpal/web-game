<!-- Navbar-->
  <header class="app-header"><a class="app-header__logo" href="javascript:void(0);">Manager Panel</a>
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
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg" alt="User Image">
      <div>
        <p class="app-sidebar__user-name">{{session('name')}}</p>
        <!-- <p class="app-sidebar__user-designation">Administrator</p> -->
      </div>
    </div>
    <ul class="app-menu">
      <li><a class="app-menu__item" href="{{ route('eventmanager.dashboard') }}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>   
      <li><a class="app-menu__item" href="{{ route('eventmanager.userlist') }}"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Manage Users</span></a></li>     
      <li><a class="app-menu__item" href="{{ route('eventmanager.teamlist') }}"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Manage Teams</span></a></li>  
      <li><a class="app-menu__item" href="{{ route('eventmanager.eventlist') }}"><i class="app-menu__icon fa fa-calendar-o"></i><span class="app-menu__label">Manage Events</span></a></li>    
    </ul>
  </aside>