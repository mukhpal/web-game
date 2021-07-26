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
        <section class="aboutus wow fadeInUp">
            <div class="container">
                <!-- <div class="about-block">
                    <div class="title text-center">
                        @if( isset( $pageData[ 'SECTION_1' ][ 'title' ] ) && $pageData[ 'SECTION_1' ][ 'title' ] )
                            <h3>{{$pageData[ 'SECTION_1' ][ 'title' ]}}</h3>
                        @endif
                    </div>
                    @if( isset( $pageData[ 'SECTION_2' ][ 'desc' ] ) && $pageData[ 'SECTION_2' ][ 'desc' ] )
                        <p>{!! nl2br( $pageData[ 'SECTION_2' ][ 'desc' ] ) !!}</p>
                    @endif
                </div> -->
                <div class="row align-items-center about-detail py-md-5">
                    <div class="col-md-12 col-lg-6 col-12 direction">
                        <div class="flag-wrapper">
                            @if( isset( $pageData[ 'SECTION_3' ][ 'title' ] ) && $pageData[ 'SECTION_3' ][ 'title' ] )
                            <h2 class="flag">{{$pageData[ 'SECTION_3' ][ 'title' ]}}</h2>
                            @endif
                        </div>
                        @if( isset( $pageData[ 'SECTION_3' ][ 'desc' ] ) && $pageData[ 'SECTION_3' ][ 'desc' ] )
                            <p>{!! nl2br( $pageData[ 'SECTION_3' ][ 'desc' ] ) !!}</p>
                        @endif
                    </div>
                    @if( isset( $pageData[ 'SECTION_3' ][ 'image' ] ) && $pageData[ 'SECTION_3' ][ 'image' ] )
                    <div class="col-md-12 col-lg-6 col-12 direction">
                        <figure>
                            <img src="{{ $pageData[ 'SECTION_3' ][ 'image' ] }}" alt="" class="img-fluid"/>
                        </figure>
                    </div>
                    @endif
                </div>
                <div class="row align-items-center about-detail py-md-5 flex-lg-row-reverse">
                    <div class="col-md-12 col-lg-6 col-12 direction">
                    <div class="flag-wrapper">
                        @if( isset( $pageData[ 'SECTION_4' ][ 'title' ] ) && $pageData[ 'SECTION_4' ][ 'title' ] )
                            <h2 class="flag">{{$pageData[ 'SECTION_4' ][ 'title' ]}}</h2>
                            @endif
                        </div>
                        @if( isset( $pageData[ 'SECTION_4' ][ 'desc' ] ) && $pageData[ 'SECTION_4' ][ 'desc' ] )
                            <p>{!! nl2br( $pageData[ 'SECTION_4' ][ 'desc' ] ) !!}</p>
                        @endif
                    </div>
                    @if( isset( $pageData[ 'SECTION_4' ][ 'image' ] ) && $pageData[ 'SECTION_4' ][ 'image' ] )
                    <div class="col-md-12 col-lg-6 col-12 direction">
                        <figure>
                            <img src="{{ $pageData[ 'SECTION_4' ][ 'image' ] }}" alt="" class="img-fluid"/>
                        </figure>
                    </div>
                    @endif
                </div>
            </div>
        </section>

        <!---------->
        <div class="clearfix"></div>
    <!--------->
@stop
