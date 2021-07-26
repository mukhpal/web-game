<!-- Navbar-->
  <header class="app-header"><a class="app-header__logo" href="{{route('admin.dashboard')}}">Admin Panel</a>
    <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    <!-- Navbar Right Menu-->
    <ul class="app-nav">
      <!-- User Menu-->
      <li class="dropdown"><a class="app-nav__item" href="javascript:void(0);" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
        <ul class="dropdown-menu settings-menu dropdown-menu-right">
          <li><a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="fa fa-user fa-lg"></i> Profile</a></li>
          <!-- <li><a class="dropdown-item" href="{{ route('admin.settings') }}"><i class="fa fa-cog fa-lg"></i> Settings</a></li> -->
          <li><a class="dropdown-item" href="{{ route('admin.logout') }}"><i class="fa fa-sign-out fa-lg"></i> Sign out</a></li>
        </ul>
      </li>
    </ul>
  </header>



    <!-- Sidebar menu-->
  <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
  <aside class="app-sidebar">
    <div class="app-sidebar__user"><!-- <img class="app-sidebar__user-avatar" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg" alt="User Image"> -->&nbsp;&nbsp;<i class="app-sidebar__user-avatar app-menu__icon fa fa-user-circle fa-3x"></i>
      <div style="margin-left: 10px;">
        <p class="app-sidebar__user-name">{{session('name')}}</p>
        <p class="app-sidebar__user-designation">Administrator</p>
      </div>
    </div>
    @php 
      $currentRoute = Route::currentRouteName( );
    @endphp
    <ul class="app-menu">
      <li><a class="app-menu__item @if( $currentRoute == 'admin.dashboard' ) active @endif" href="{{ route('admin.dashboard') }}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>  
      
      <li><a class="app-menu__item @if( $currentRoute == 'admin.userlist' || $currentRoute == 'admin.userlist' ) active @endif" href="{{ route('admin.userlist') }}"><i class="app-menu__icon fa fa-users "></i><span class="app-menu__label">Users Management</span></a></li>

      <li><a class="app-menu__item @if( $currentRoute == 'admin.games' || $currentRoute == 'admin.edit_game' ) active @endif" href="{{ route('admin.games') }}"><i class="app-menu__icon fa fa-gamepad "></i><span class="app-menu__label">Games Management</span></a></li>

      <li><a class="app-menu__item @if( $currentRoute == 'admin.eventmanagerlist' || $currentRoute == 'admin.addeventmanager' || $currentRoute == 'admin.editeventmanager' ) active @endif" href="{{ route('admin.eventmanagerlist') }}"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Event Managers</span></a></li>
      
      <li><a class="app-menu__item @if( $currentRoute == 'admin.cropslist' || $currentRoute == 'admin.addcrop' || $currentRoute == 'admin.editcrop' ) active @endif" href="{{ route('admin.cropslist') }}"><i class="app-menu__icon fa fa-tree"></i><span class="app-menu__label">Manage Crops</span></a></li>

      <li><a class="app-menu__item @if( $currentRoute == 'admin.eventlist' || $currentRoute == 'admin.addevent' || $currentRoute == 'admin.eventdetails' ) active @endif" href="{{ route('admin.eventlist') }}"><i class="app-menu__icon fa fa-calendar-o"></i><span class="app-menu__label">Events</span></a></li>  
      
      <li><a class="app-menu__item @if( $currentRoute == 'admin.surveylist' ) active @endif"" href="{{ route('admin.surveylist') }}"><i class="app-menu__icon fa fa-comment"></i><span class="app-menu__label">Survey</span></a></li>  

      <li class="nav-dropdown @if( $currentRoute == 'admin.pages' || $currentRoute == 'admin.edit_page' ||  $currentRoute == 'admin.faqs' || $currentRoute == 'admin.create_faq' || $currentRoute == 'admin.edit_faq' || $currentRoute == 'admin.content_configurations' || $currentRoute == 'admin.edit_content_configuration' ) show @endif">
        <a class="app-menu__item show-submenu dropdown-toggle" href="javascript:void(0);"><i class="app-menu__icon fa fa-file"></i><span class="app-menu__label">CMS</span></a>
        <ul class="nav-dropdown-items" data-role="dropdown">
          <li><a class="app-menu__item @if( $currentRoute == 'admin.pages' || $currentRoute == 'admin.edit_page' ) active @endif" href="{{ route('admin.pages') }}">Pages</a></li>
          <li><a class="app-menu__item @if( $currentRoute == 'admin.faqs' || $currentRoute == 'admin.create_faq' || $currentRoute == 'admin.edit_faq' ) active @endif" href="{{ route('admin.faqs') }}">FAQ's</a></li>
          <li><a class="app-menu__item @if( 
            $currentRoute == 'admin.edit_content_configuration' ) active @endif" href="{{ route('admin.edit_content_configuration') }}">Configurations</a></li>
        </ul>
      </li>  
      
      <li><a class="app-menu__item @if( $currentRoute == 'admin.packages' ) active @endif"" href="{{ route('admin.packages') }}"><i class="app-menu__icon fa fa-cubes"></i><span class="app-menu__label">Packages</span></a></li>  
      
      <li><a class="app-menu__item @if( $currentRoute == 'admin.settings' ) active @endif" href="{{ route('admin.settings') }}"><i class="app-menu__icon fa fa-gear"></i><span class="app-menu__label">Game Settings</span></a></li>

      <li><a class="app-menu__item @if( $currentRoute == 'admin.others' || $currentRoute == 'admin.callouts') active @endif" href="{{ route('admin.others') }}"><i class="app-menu__icon fa fa-gear "></i><span class="app-menu__label">Others</span></a></li>
    </ul>
  </aside>
  <style>
  .nav-dropdown-items{display:none;}
  .show .nav-dropdown-items{display:block;}
  </style>
  <script type="text/javascript">
    $( document ).ready(function(){
      $( '.show-submenu' ).on('click', function(){
        $( this ).parent().toggleClass( 'show' );
      });
    });
  </script>