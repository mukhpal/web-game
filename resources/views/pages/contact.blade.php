@extends('pages.layouts.main', [ 'pageData' => $pageData ])
@section('content')

    <div class="main_banner">
        <div class="controller">
            <div class="over_banner"></div>
        </div>
        <div class="container">			
            <div class="row align-items-start single_banner">
                <div class="col-md-6 col-sm-12">
                    <div class="summary_banner">
                        @if( isset( $pageData[ 'SECTION_1' ][ 'title' ] ) && $pageData[ 'SECTION_1' ][ 'title' ] )
                            <h1>{{$pageData[ 'SECTION_1' ][ 'title' ]}}</h1>
                        @endif
                        @if( isset( $pageData[ 'SECTION_1' ][ 'desc' ] ) && $pageData[ 'SECTION_1' ][ 'desc' ] )
                            <p>{!! nl2br( $pageData[ 'SECTION_1' ][ 'desc' ] ) !!}</p>
                        @endif
                    </div><!--summary_banner-->
                    
                </div>	
                <div class="col-md-6 col-sm-12 text-center">
                    <div class="home_illustration"> 	
                        @if( isset( $pageData[ 'SECTION_1' ][ 'image' ] ) && $pageData[ 'SECTION_1' ][ 'image' ] )
                            <img src="{{$pageData[ 'SECTION_1' ][ 'image' ]}}" alt="" class="img-fluid"/>
                        @endif
                    </div>
                </div>					
            </div>			
        </div>
    </div>
    <!---------->
    <div class="clearfix"></div>
    <!--------->
    <section class="contact wow fadeInUp">
        <div class="container">
                <div class="contact-info shadow_bg">
                <div class="row align-items-center justify-content-between">
                <div class="col-lg-5 col-md-6">
                        <div class="right shadow_bg">
                            @if( isset( $pageData[ 'SECTION_2' ][ 'title' ] ) && $pageData[ 'SECTION_2' ][ 'title' ] )
                                <h3>{{$pageData[ 'SECTION_2' ][ 'title' ]}}</h3>
                            @endif

                            @if( $basicContent['CONF_CONTACT_PHONE'] )
                                <div class="info d-flex align-items-center">
                                    <i><img src="{{ asset('assets/front/images/contact/phone.png' ) }}" alt="" /> </i>
                                    <span>Phone: {{$basicContent['CONF_CONTACT_PHONE']}}</span>
                                </div>
                            @endif

                            @if( $basicContent['CONF_CONTACT_EMAIL'] )
                                <div class="info d-flex align-items-center">
                                    <i><img src="{{ asset('assets/front/images/contact/mail.png' ) }}" alt="" /> </i>
                                    <span>Email: {{$basicContent['CONF_CONTACT_EMAIL']}}</span>
                                </div>
                                <script type="text/javascript">
                                    var moveToAlert = true;
                                </script>
                            @endif

                            @if( $basicContent['CONF_CONTACT_SKYPE'] )
                                <div class="info d-flex align-items-center">
                                    <i><img src="{{ asset('assets/front/images/contact/skype.png' ) }}" alt="" /> </i>
                                    <span>{{$basicContent['CONF_CONTACT_SKYPE']}}</span>
                                </div>
                                <script type="text/javascript">
                                    var moveToAlert = true;
                                </script>
                            @endif

                            <ul class="info social_link d-flex align-items-center justify-content-center">
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
                    <div class="col-lg-7 col-md-6 left">
                        <div class="title bar-left">
                            @if( isset( $pageData[ 'SECTION_3' ][ 'title' ] ) && $pageData[ 'SECTION_3' ][ 'title' ] )
                                <h3>{{$pageData[ 'SECTION_3' ][ 'title' ]}}</h3>
                            @endif
                            @if( isset( $pageData[ 'SECTION_3' ][ 'desc' ] ) && $pageData[ 'SECTION_3' ][ 'desc' ] )
                                <small>{{$pageData[ 'SECTION_3' ][ 'desc' ]}}</small>
                            @endif
                        </div>

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block" style="padding: 7px;margin-bottom: 10px;">
                                <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        @if ($message = Session::get('custom_errors'))
                            <div class="alert alert-danger alert-block" style="padding: 7px;margin-bottom: 10px;">
                                <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif

                        <form name="send_request" id="send_request" method="post" action="{{ route( 'front.contact_send_request' ) }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Name<span class="required">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter name" id="name" name="name" value="{{old( 'name' )}}" />
                                {!! $errors->first(  'name', '<label id="name-error" class="error" for="name">:message</label>') !!}
                            </div>
                            <div class="form-group">
                                <label>Email<span class="required">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter email" id="email" name="email" value="{{old( 'email' )}}" />
                                {!! $errors->first(  'email', '<label id="email-error" class="error" for="email">:message</label>') !!}
                            </div>
                            <div class="form-group">
                                <label>Message<span class="required">*</span></label>
                                <textarea class="form-control" rows="5" placeholder="Enter message here.." id="comment" name="comment">{{old( 'comment' )}}</textarea>
                                {!! $errors->first(  'comment', '<label id="comment-error" class="error" for="comment">:message</label>') !!}
                            </div>

                            @if(env('GOOGLE_RECAPTCHA_KEY'))
                              <div class="form-group {{ $errors->has('g-recaptcha-response') ? 'has-error' : ''}}">
                                <label class="control-label">Captcha <span class="required-fields">*</span></label>
                                   <div class="g-recaptcha"
                                        data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}">
                                   </div>
                                {!! $errors->first('g-recaptcha-response', '<p class="validation-errors">:message</p>') !!}
                             </div>
                            @endif
                            <button class="text-capitalize btn btn-lg btn-primary" type="submit">Send</button>
                        </form>
                    </div>
                    <!-- Left -->
                    
                </div>
            </div>
        </div>
    </section>

    <!---------->
    <div class="clearfix"></div>
    <!--------->
@stop
@push( 'after_styles' )
<style>
.contact-info label.error { font-size: 12px; color: red; }
</style>
@endpush

@push( 'after_scripts' )
<script src="{{ asset( 'assets/front/js/pages/contact.js' ) }}"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
@endpush
