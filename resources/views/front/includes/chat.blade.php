<html>
<head>
  	
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<link rel="stylesheet" type="text/css" href="{{ asset('assets/chat/style.css') }}">
</head>
<body>     
  <div class="chat_modal">
	<div class="chat">
		<div class="chat_header">
			<input type="hidden" id="enc_id" value="{{ $encryptedId }}">
			<input type="hidden" id="chat_url" value="{{ url('/') }}">
			<input type="hidden" id="csrf_token" value="{{ csrf_token() }}">
			<div class="chat_tab">
				<div class="tab active" data-room="1">
					<a href="#tab1" id="tab1_link">
						<ul class="group_chat">
							<li><i><img src="{{ asset('assets/front/images/icons') }}/avtar1.png" alt=""/></i></li>
							<li><i><img src="{{ asset('assets/front/images/icons') }}/avtar3.png" alt=""/></i></li>
							<li><i><img src="{{ asset('assets/front/images/icons') }}/avtar6.png" alt=""/></i></li>
							<li><i><img src="{{ asset('assets/front/images/icons') }}/avtar9.png" alt=""/></i></li>
							<li><i>+1</i></li>
						</ul>
						<span class="tab1_title">Team chat</span>
					</a>
				</div>
				<div class="tab" data-room="2">
					<a href="#tab2" id="tab2_link">
						<i><img src="{{ asset('assets/chat/') }}/img/event_chat_icon.png" alt=""/></i> 
						<span class="tab2_title">Event Chat</span>
					</a>
				</div>
			</div>
			 
		</div>
		<!--End Chat Header -->
 
		<!-- Start Chat Body -->      
		<div id="chat_fullscreen" class="chat_conversion chat_converse">
			<div class="tab-content" id="tab1"><!-- Team chat --></div>
			<!-- Start Chat 2 -->
			<div class="tab-content" id="tab2" style="display: none;"><!-- Event chat --></div>
			<!-- End Chat Message Box -->
						
		</div>
		<!-- <div class="note">Note - User can turn on video chat by clicking on their Avatars. <span class="close_note"><i class="fa fa-times" aria-hidden="true"></i></span></div> -->
			
			<!-- Chat Message Box -->	
			<div class="fab_field">
				<div class="comment-box">
				   <textarea id="chat_message" name="chat_message" placeholder="Send a message" class="chat_field chat_message" autofocus></textarea>
				   <div class="smile_block">
						<i class="emoji_icon"><img src="{{ asset('assets/chat/') }}/img/emoji.png" alt=""/></i>
						<i class="close"><img src="{{ asset('assets/chat/') }}/img/close_icon.svg" alt=""/></i>					
					</div>
				   <a id="fab_send"><i><img src="{{ asset('assets/chat/') }}/img/send_icon.png" alt=""/></i></a>
				</div>
				<div class="emojis">	
					<ul>
						<li>
							<span><a class="emj" data-ecode="128512;" href="#">&#128512; </a></span>
							<span><a class="emj" data-ecode="128514;" href="#">&#128514; </a></span>
						</li>
						<li>
							<span><a class="emj" data-ecode="128562;" href="#">&#128562;</a></span>
							<span><a class="emj" data-ecode="128565;" href="#">&#128565;</a></span>
						</li>
						<li>
							<span><a class="emj" data-ecode="128525;" href="#">&#128525;</a></span>
							<span><a class="emj" data-ecode="128532;" href="#">&#128532;</a></span>
						</li>
						<li>	
							<span><a class="emj" data-ecode="128540;" href="#">&#128540;</a></span>
							<span><a class="emj" data-ecode="128549;" href="#">&#128549;</a></span>
						</li>
						<li>
							<span><a class="emj" data-ecode="128522;" href="#">&#128522;</a></span>
							<span><a class="emj" data-ecode="128517;" href="#">&#128517;</a></span>
						</li>
						<li>
							<span><a class="emj" data-ecode="128555;" href="#">&#128555;</a></span>
							<span><a class="emj" data-ecode="128542;" href="#">&#128542;</a></span>
						</li>
						<li>
							<span><a class="emj" data-ecode="128539;" href="#">&#128539;</a></span>
							<span><a class="emj" data-ecode="128556;" href="#">&#128556;</a></span>
						</li>
						<li>
							<span><a class="emj" data-ecode="128562;" href="#">&#128562;</a></span>
							<span><a class="emj" data-ecode="128559;" href="#">&#128559;</a></span>
						</li>						
					</ul>
				</div>
			</div>
		
	</div>
  
	<a id="prime" class="fab"><i class="prime zmdi zmdi-comment-outline"></i>
		
	</a>

</div>
	<script src='https://code.jquery.com/jquery-1.11.3.min.js'></script>
    <script src="{{ asset('assets/chat/js/custom.js') }}"></script>
    <script src="https://twemoji.maxcdn.com/2/twemoji.min.js?11.2"></script>
	<script>window.onload = function () { twemoji.parse(document.body);}</script>
</body>
</html>