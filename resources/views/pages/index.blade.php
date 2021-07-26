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
                    <ul class="counter counters">
                        <li>
                            <div class="stats_box">
                                <i><img src="{{ asset('assets/front/images/icons/total_events.png' ) }}" alt="" class="img-fluid" /></i>
                                <h4 class="counter-value" data-toggle="counter-up">{{$totalEvents}}</h4><span>Total Events</span>
                            </div>
                        </li>
                        <li>
                            <div class="stats_box">
                                <i><img src="{{ asset('assets/front/images/icons/team.png' ) }}" alt="" class="img-fluid" /></i>
                                <h4 class="counter-value" data-toggle="counter-up">{{$totalUsers}}</h4><span>Total Users</span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 col-sm-12 text-center">
                    <div class="home_illustration home-img">
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

    @if( $packages->count() > 0 )
    <!--==========================
        Info Section
    ============================-->
    <section class="section info_about wow fadeIn">
        <div class="container">
            <div class="title text-center">
                @if( isset( $pageData[ 'SECTION_2' ][ 'title' ] ) && $pageData[ 'SECTION_2' ][ 'title' ] )
                    <h3>{{$pageData[ 'SECTION_2' ][ 'title' ]}}</h3>
                @endif
            </div>
        
            <ul class="row justify-content-center align-items-center text-center">
                @foreach( $packages as $package )
                    <li class=" col-lg-3 col-md-6 col-12">
                        <div class="intro-info shadow_clr ">
                            <figure>
                                <img src="{{ url( 'public/upload/packages/' . $package->image ) }}" alt="{{ \Illuminate\Support\Str::limit( $package->name, 50, $end = '...' ) }}" class="img-fluid" />
                            </figure>
                            <h4>{{ \Illuminate\Support\Str::limit( $package->name, 50, $end = '...' ) }}</h4>
                            <p>{{ \Illuminate\Support\Str::limit( $package->description, 62, $end = '...' ) }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        
    </section><!-- #intro -->
    <!---------->
        <div class="clearfix"></div>
    <!--------->
    @endif
    <!--==========================
        marketmadness Section
    ============================-->
    <section class="marketmadness-sec">  
        <div class="container">
            <div class="slider slider-nav">
                
                <div class="block-slick">
                    <div class="row align-items-center flex-lg-row flex-md-column flex-md-row-reverse">
                        @if( isset( $pageData[ 'SECTION_11' ][ 'image' ] ) && $pageData[ 'SECTION_11' ][ 'image' ] )
                        <div class="col-lg-6 col-md-12">
                            <figure class="about-img">
                                <img src="{{ $pageData[ 'SECTION_11' ][ 'image' ] }}" alt="{{ ( isset( $pageData[ 'SECTION_11' ][ 'title' ] ) && $pageData[ 'SECTION_11' ][ 'title' ] )?$pageData[ 'SECTION_11' ][ 'title' ]:'' }}" class="img-fluid" />
                            </figure>
                        </div>
                        @endif
                        <div class="col-lg-6 col-md-12">
                            <div class="market-content text-left">
                                <div class="title bar-left">
                                    <small>our Games</small>
                                    @if( isset( $pageData[ 'SECTION_11' ][ 'title' ] ) && $pageData[ 'SECTION_11' ][ 'title' ] )
                                        <h3>{{$pageData[ 'SECTION_11' ][ 'title' ]}}</h3>
                                    @endif
                                </div>

                                @if( isset( $pageData[ 'SECTION_11' ][ 'desc' ] ) && $pageData[ 'SECTION_11' ][ 'desc' ] )
                                    <p>{!! nl2br( $pageData[ 'SECTION_11' ][ 'desc' ] ) !!}</p>
                                @endif
                            </div>
                        </div>   
                    </div>
                </div>	

                <div class="block-slick">
                    <div class="row align-items-center flex-lg-row flex-md-column flex-md-row-reverse">
                        @if( isset( $pageData[ 'SECTION_12' ][ 'image' ] ) && $pageData[ 'SECTION_12' ][ 'image' ] )
                        <div class="col-lg-6 col-md-12">
                            <figure class="about-img">
                                <img src="{{ $pageData[ 'SECTION_12' ][ 'image' ] }}" alt="{{ ( isset( $pageData[ 'SECTION_12' ][ 'title' ] ) && $pageData[ 'SECTION_12' ][ 'title' ] )?$pageData[ 'SECTION_12' ][ 'title' ]:'' }}" class="img-fluid" />
                            </figure>
                        </div>
                        @endif
                        <div class="col-lg-6 col-md-12">
                            <div class="market-content text-left">
                                <div class="title bar-left">
                                    <small>our Games</small>
                                    @if( isset( $pageData[ 'SECTION_12' ][ 'title' ] ) && $pageData[ 'SECTION_12' ][ 'title' ] )
                                        <h3>{{$pageData[ 'SECTION_12' ][ 'title' ]}}</h3>
                                    @endif
                                </div>

                                @if( isset( $pageData[ 'SECTION_12' ][ 'desc' ] ) && $pageData[ 'SECTION_12' ][ 'desc' ] )
                                    <p>{!! nl2br( $pageData[ 'SECTION_12' ][ 'desc' ] ) !!}</p>
                                @endif
                            </div>
                        </div>   
                    </div>
                </div>

                <div class="block-slick">
                    <div class="row align-items-center flex-lg-row flex-md-column flex-md-row-reverse">
                        @if( isset( $pageData[ 'SECTION_3' ][ 'image' ] ) && $pageData[ 'SECTION_3' ][ 'image' ] )
                        <div class="col-lg-6 col-md-12">
                            <figure class="about-img">
                                <img src="{{ $pageData[ 'SECTION_3' ][ 'image' ] }}" alt="{{ ( isset( $pageData[ 'SECTION_3' ][ 'title' ] ) && $pageData[ 'SECTION_3' ][ 'title' ] )?$pageData[ 'SECTION_3' ][ 'title' ]:'' }}" class="img-fluid" />
                            </figure>
                        </div>
                        @endif
                        <div class="col-lg-6 col-md-12">
                            <div class="market-content text-left">
                                <div class="title bar-left">
                                    <small>our Games</small>
                                    @if( isset( $pageData[ 'SECTION_3' ][ 'title' ] ) && $pageData[ 'SECTION_3' ][ 'title' ] )
                                        <h3>{{$pageData[ 'SECTION_3' ][ 'title' ]}}</h3>
                                    @endif
                                </div>

                                @if( isset( $pageData[ 'SECTION_3' ][ 'desc' ] ) && $pageData[ 'SECTION_3' ][ 'desc' ] )
                                    <p>{!! nl2br( $pageData[ 'SECTION_3' ][ 'desc' ] ) !!}</p>
                                @endif
                            </div>
                        </div>     
                    </div>
                </div>		

                <div class="block-slick">
                    <div class="row align-items-center flex-lg-row flex-md-column flex-md-row-reverse">
                        @if( isset( $pageData[ 'SECTION_4' ][ 'image' ] ) && $pageData[ 'SECTION_4' ][ 'image' ] )
                        <div class="col-lg-6 col-md-12">
                            <figure class="about-img">
                                <img src="{{ $pageData[ 'SECTION_4' ][ 'image' ] }}" alt="{{ ( isset( $pageData[ 'SECTION_4' ][ 'title' ] ) && $pageData[ 'SECTION_4' ][ 'title' ] )?$pageData[ 'SECTION_4' ][ 'title' ]:'' }}" class="img-fluid" />
                            </figure>
                        </div>
                        @endif
                        <div class="col-lg-6 col-md-12">
                            <div class="market-content text-left">
                                <div class="title bar-left">
                                    <small>our Games</small>
                                    @if( isset( $pageData[ 'SECTION_4' ][ 'title' ] ) && $pageData[ 'SECTION_4' ][ 'title' ] )
                                        <h3>{{$pageData[ 'SECTION_4' ][ 'title' ]}}</h3>
                                    @endif
                                </div>

                                @if( isset( $pageData[ 'SECTION_4' ][ 'desc' ] ) && $pageData[ 'SECTION_4' ][ 'desc' ] )
                                    <p>{!! nl2br( $pageData[ 'SECTION_4' ][ 'desc' ] ) !!}</p>
                                @endif
                            </div>
                        </div>   
                    </div>
                </div>	
            </div>
        </div>
    </section>
    <!-- #marketmadness block -->     
        <!---------->
        <div class="clearfix"></div>
    <!--------->
        
    <!--==========================
        how-it-works
    ============================-->
    <section class="section info_about wow fadeIn">
        <div class="container">
            <div class="title text-center">
                @if( isset( $pageData[ 'SECTION_5' ][ 'title' ] ) && $pageData[ 'SECTION_5' ][ 'title' ] )
                    <h3>{{$pageData[ 'SECTION_5' ][ 'title' ]}}</h3>
                @endif
            </div>
        
            <ul class="row justify-content-center align-items-start text-center how-it-works">
            <li class="col-lg-3 col-md-6 col-12">
                <div class="intro-info shadow_clr ">
                    @if( isset( $pageData[ 'SECTION_6' ][ 'image' ] ) && $pageData[ 'SECTION_6' ][ 'image' ] )
                        <figure>
                            <img src="{{ $pageData[ 'SECTION_6' ][ 'image' ] }}" alt="{{ ( isset( $pageData[ 'SECTION_6' ][ 'title' ] ) && $pageData[ 'SECTION_6' ][ 'title' ] )?$pageData[ 'SECTION_6' ][ 'title' ]:'' }}" class="img-fluid" />
                        </figure>
                    @endif
                    @if( isset( $pageData[ 'SECTION_6' ][ 'title' ] ) && $pageData[ 'SECTION_6' ][ 'title' ] )
                        <h5>{{$pageData[ 'SECTION_6' ][ 'title' ]}}</h5>
                    @endif
                    @if( isset( $pageData[ 'SECTION_6' ][ 'desc' ] ) && $pageData[ 'SECTION_6' ][ 'desc' ] )
                        <p>{!! nl2br( $pageData[ 'SECTION_6' ][ 'desc' ] ) !!}</p>
                    @endif
                </div>
            </li>
            <li class="col-lg-3 col-md-6 col-12">
                <div class="intro-info shadow_clr ">
                    @if( isset( $pageData[ 'SECTION_7' ][ 'image' ] ) && $pageData[ 'SECTION_7' ][ 'image' ] )
                        <figure>
                            <img src="{{ $pageData[ 'SECTION_7' ][ 'image' ] }}" alt="{{ ( isset( $pageData[ 'SECTION_7' ][ 'title' ] ) && $pageData[ 'SECTION_7' ][ 'title' ] )?$pageData[ 'SECTION_7' ][ 'title' ]:'' }}" class="img-fluid" />
                        </figure>
                    @endif
                    @if( isset( $pageData[ 'SECTION_7' ][ 'title' ] ) && $pageData[ 'SECTION_7' ][ 'title' ] )
                        <h5>{{$pageData[ 'SECTION_7' ][ 'title' ]}}</h5>
                    @endif
                    @if( isset( $pageData[ 'SECTION_7' ][ 'desc' ] ) && $pageData[ 'SECTION_7' ][ 'desc' ] )
                        <p>{!! nl2br( $pageData[ 'SECTION_7' ][ 'desc' ] ) !!}</p>
                    @endif
                </div>
            </li>
            <li class="col-lg-3 col-md-6 col-12">
                <div class="intro-info shadow_clr ">
                    @if( isset( $pageData[ 'SECTION_8' ][ 'image' ] ) && $pageData[ 'SECTION_8' ][ 'image' ] )
                        <figure>
                            <img src="{{ $pageData[ 'SECTION_8' ][ 'image' ] }}" alt="{{ ( isset( $pageData[ 'SECTION_8' ][ 'title' ] ) && $pageData[ 'SECTION_8' ][ 'title' ] )?$pageData[ 'SECTION_8' ][ 'title' ]:'' }}" class="img-fluid" />
                        </figure>
                    @endif
                    @if( isset( $pageData[ 'SECTION_8' ][ 'title' ] ) && $pageData[ 'SECTION_8' ][ 'title' ] )
                        <h5>{{$pageData[ 'SECTION_8' ][ 'title' ]}}</h5>
                    @endif
                    @if( isset( $pageData[ 'SECTION_8' ][ 'desc' ] ) && $pageData[ 'SECTION_8' ][ 'desc' ] )
                        <p>{!! nl2br( $pageData[ 'SECTION_8' ][ 'desc' ] ) !!}</p>
                    @endif
                </div>
            </li>
            <li class="col-lg-3 col-md-6 col-12">
                <div class="intro-info shadow_clr ">
                    @if( isset( $pageData[ 'SECTION_9' ][ 'image' ] ) && $pageData[ 'SECTION_9' ][ 'image' ] )
                        <figure>
                            <img src="{{ $pageData[ 'SECTION_9' ][ 'image' ] }}" alt="{{ ( isset( $pageData[ 'SECTION_9' ][ 'title' ] ) && $pageData[ 'SECTION_9' ][ 'title' ] )?$pageData[ 'SECTION_9' ][ 'title' ]:'' }}" class="img-fluid" />
                        </figure>
                    @endif
                    @if( isset( $pageData[ 'SECTION_9' ][ 'title' ] ) && $pageData[ 'SECTION_9' ][ 'title' ] )
                        <h5>{{$pageData[ 'SECTION_9' ][ 'title' ]}}</h5>
                    @endif
                    @if( isset( $pageData[ 'SECTION_9' ][ 'desc' ] ) && $pageData[ 'SECTION_9' ][ 'desc' ] )
                        <p>{!! nl2br( $pageData[ 'SECTION_9' ][ 'desc' ] ) !!}</p>
                    @endif
                </div>
            </li>
            </ul>
        </div>
    </section>
    <!---------->
        <div class="clearfix"></div>
    <!--------->
    <!--==========================
        map section start
    ============================-->
    <section class="section map-area wow fadeIn pt-0">
        <div class="container">
            <div class="title text-center">
                @if( isset( $pageData[ 'SECTION_10' ][ 'title' ] ) && $pageData[ 'SECTION_10' ][ 'title' ] )
                    <h3>{{$pageData[ 'SECTION_10' ][ 'title' ]}}</h3>
                @endif
            </div>
            @if( isset( $pageData[ 'SECTION_10' ][ 'image' ] ) && $pageData[ 'SECTION_10' ][ 'image' ] && $basicContent['CONF_WORLD_MAP_COUNTRIES'] )
            <div class="custom_map">
				<figure>
				  <img src="{{ $pageData[ 'SECTION_10' ][ 'image' ] }}" alt="map-img" class="img-fluid"/>
				</figure>
                @php 
                    $worldMapData = array_intersect_key( $worldMapCountries, array_flip( $basicContent['CONF_WORLD_MAP_COUNTRIES'] ) );
                @endphp
				<ul class="world_map">
                    @foreach( $worldMapData as $short => $worldMapCountry )
                        <li class="pin_{{$short}}">
							<i><img src="{{ asset( 'assets/front/images/map-ping.png' ) }}" alt="{{$worldMapCountry}}"  class="" /></i>
							<span class="tooltiptext">{{$worldMapCountry}}</span>				
						</li>
                    @endforeach
				</ul>
			</div>
            @endif
        </div>
    </section>	
    <!--==========================
        map section end
    ============================-->
    <!---------->
        <div class="clearfix"></div>
    <!--------->
@stop
