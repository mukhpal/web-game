<!--==========================
	  Footer
	============================-->
	<footer id="footer" class="footer-main bg-blue">
		<div class="container">	  
			<div class="row align-items-start">
				<div class="col-md-4 footer_logo">
					<figure><img src="{{ asset( 'assets/front/images/logo_white.png' ) }}" alt="Office Campfire" class="img-fluid" /></figure>
					@if( $basicContent['CONF_FOOTER_DESC'] )
						<p>{!!@nl2br( $basicContent['CONF_FOOTER_DESC'] )!!}</p>
					@endif
				</div>

			  <div class="col-md-4 text-white pl-md-5">
				<h4>Useful Links</h4>
					<ul class="footer-menu">
						<li><a href="{{route( 'front.index' )}}">Home</a></li>
					  <li><a href="{{route( 'front.about_us' )}}">About us</a></li>
					  <li><a href="{{route( 'front.how_it_works' )}}">How it works</a></li>          
					  <li><a href="{{route( 'front.packages' )}}">packages</a></li>            
					  <li><a href="{{route( 'front.faqs' )}}">FAQ's</a></li>            
					  <li><a href="{{route( 'front.contact' )}}">Contact us</a></li>            
					</ul>	
			
			  </div>
			  
			  <div class="col-md-4">
			  	@if( $basicContent['CONF_FOOTER_CONTACT_HEADING'] )
					<h4>{{$basicContent['CONF_FOOTER_CONTACT_HEADING']}}</h4>
				@endif
				@if( $basicContent['CONF_CONTACT_ADDRESS'] )
				<address class="space-top mb-0">{{$basicContent['CONF_CONTACT_ADDRESS']}}</address>
				@endif
				<ul class="space-top">
					@if( $basicContent['CONF_CONTACT_EMAIL'] )
						<li>Email: <a href="mailto:{{$basicContent['CONF_CONTACT_EMAIL']}}">{{$basicContent['CONF_CONTACT_EMAIL']}}</a></li>
					@endif
					<!--li>Phone: <a href="tell:91 1231231234">+91 1231231234</a></li-->
				</ul>
				<ul class="social_link space-top">
					@if( $basicContent['CONF_SOCIAL_INSTA'] )
						<li><a href="{{$basicContent['CONF_SOCIAL_INSTA']}}" target="_blank"><img src="{{ asset( 'assets/front/images/icons/instagram.png' ) }}" alt="Instagram" /></a></li>
					@endif
					@if( $basicContent['CONF_SOCIAL_TWITTER'] )
						<li><a href="{{$basicContent['CONF_SOCIAL_TWITTER']}}" target="_blank"><img src="{{ asset( 'assets/front/images/icons/twitter.png' ) }}" alt="Twitter" /></a></li>
					@endif
					@if( $basicContent['CONF_SOCIAL_YOUTUBE'] )
						<li><a href="{{$basicContent['CONF_SOCIAL_YOUTUBE']}}" target="_blank"><img src="{{ asset( 'assets/front/images/icons/youtube.png' ) }}" alt="Youtube"  /></a></li>
					@endif
					@if( $basicContent['CONF_SOCIAL_FACEBOOK'] )
						<li><a href="{{$basicContent['CONF_SOCIAL_FACEBOOK']}}" target="_blank"><img src="{{ asset( 'assets/front/images/icons/facebook.png' ) }}" alt="Facebook" /></a></li>
					@endif
				</ul>
			  </div>
			</div>
			
		</div>
	
		@if( $basicContent['CONF_FOOTER_COPYRIGHT'] )
			<!-- Start Copyright -->
			<div class="copyright mt-4 text-center">{{$basicContent['CONF_FOOTER_COPYRIGHT']}}</div>
			<!-- End Copyright -->
		@endif
    
	</footer><!-- #footer -->

	<a href="#" class="back-to-top"><i><img src="{{ asset( 'assets/front/images/icons/up-arrow.svg' ) }}" alt=""/></i></a>