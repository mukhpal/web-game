<!--==========================
    Header
============================-->
  <header id="header">
		<div class="container">
			<div class="menu_main d-flex align-items-start">
				<div class="navbar-brand logo p-0">
					<a href="{{route( 'front.index' )}}">
            <span><img src="{{ asset( 'assets/front/images/main-logo.png' ) }}" alt="Office Campfire" /></span></a>
				</div>
				<div class="d-flex flex-row-reverse align-items-center">
				<a href="{{route( 'eventmanager.login' )}}" class="d-flex align-items-center text-capitalize login_menu btn-md btn-primary shadow_clr"> Login</a>
				<nav class="navbar main-nav justify-content-between">
					<ul class="text-capitalize">
					  <li class="{{ ( ( $currentPage == 'index' )?' active':'' ) }}"><a href="{{route( 'front.index' )}}">Home</a></li>
					  <li class="{{ ( ( $currentPage == 'about_us' )?' active':'' ) }}"><a href="{{route( 'front.about_us' )}}">About us</a></li>
					  <li class="{{ ( ( $currentPage == 'how_it_works' )?' active':'' ) }}"><a href="{{route( 'front.how_it_works' )}}">How it works</a></li>
					  <li class="{{ ( ( $currentPage == 'packages' )?' active':'' ) }}"><a href="{{route( 'front.packages' )}}">Packages</a></li>
					  <li class="{{ ( ( $currentPage == 'faqs' )?' active':'' ) }}"><a href="{{route( 'front.faqs' )}}">FAQ's</a></li>
					  <li class="{{ ( ( $currentPage == 'contact' )?' active':'' ) }}"><a href="{{route( 'front.contact' )}}">Contact us</a></li>
					</ul>
				</nav><!-- .main-nav -->
			</div>
			</div>
		</div>
	</header><!-- #header -->