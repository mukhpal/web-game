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
        <section class="section how-it-work wow fadeIn">
        <div class="container">
            <div class="title text-center">
                @if( isset( $pageData[ 'SECTION_2' ][ 'title' ] ) && $pageData[ 'SECTION_2' ][ 'title' ] )
                <h3>{{$pageData[ 'SECTION_2' ][ 'title' ]}}</h3>
                @endif
            </div>
    <ul class="timeline">

        <!-- Item 1 -->
        <li class="row align-items-center justify-content-between">
            <div class="direction-r">
                <div class="flag-wrapper">
                    @if( isset( $pageData[ 'SECTION_3' ][ 'title' ] ) && $pageData[ 'SECTION_3' ][ 'title' ] )
                        <h2 class="flag">{{$pageData[ 'SECTION_3' ][ 'title' ]}}</h2>
                    @endif
                </div>
                @if( isset( $pageData[ 'SECTION_3' ][ 'desc' ] ) && $pageData[ 'SECTION_3' ][ 'desc' ] )
                    <div class="desc"><p>{!! nl2br( $pageData[ 'SECTION_3' ][ 'desc' ] ) !!}</p></div>
                @endif
            </div>
            @if( isset( $pageData[ 'SECTION_3' ][ 'image' ] ) && $pageData[ 'SECTION_3' ][ 'image' ] )
            <div class="direction-l">
                <figure>
                <img src="{{ $pageData[ 'SECTION_3' ][ 'image' ] }}" alt="" class="img-fluid"/>
                </figure>
            </div>
            @endif
        </li>

        <!-- Item 2 -->
        <li class="row align-items-center justify-content-between flex-md-row-reverse">
            
            <div class="direction-l">
                <div class="flag-wrapper">
                    @if( isset( $pageData[ 'SECTION_4' ][ 'title' ] ) && $pageData[ 'SECTION_4' ][ 'title' ] )
                        <h2 class="flag">{{$pageData[ 'SECTION_4' ][ 'title' ]}}</h2>
                    @endif
                </div>
                @if( isset( $pageData[ 'SECTION_4' ][ 'desc' ] ) && $pageData[ 'SECTION_4' ][ 'desc' ] )
                    <div class="desc"><p>{!! nl2br( $pageData[ 'SECTION_4' ][ 'desc' ] ) !!}</p></div>
                @endif
            </div>
        
            @if( isset( $pageData[ 'SECTION_4' ][ 'image' ] ) && $pageData[ 'SECTION_4' ][ 'image' ] )
            <div class="direction-r">
                <figure>
                <img src="{{ $pageData[ 'SECTION_4' ][ 'image' ] }}" alt="" class="img-fluid"/>
                </figure>
            </div>
            @endif
        </li>

        <!-- Item 3 -->
        <li class="row align-items-center justify-content-between">
            <div class="direction-r">
                <div class="flag-wrapper">
                    @if( isset( $pageData[ 'SECTION_5' ][ 'title' ] ) && $pageData[ 'SECTION_5' ][ 'title' ] )
                        <h2 class="flag">{{$pageData[ 'SECTION_5' ][ 'title' ]}}</h2>
                    @endif
                </div>
                @if( isset( $pageData[ 'SECTION_5' ][ 'desc' ] ) && $pageData[ 'SECTION_5' ][ 'desc' ] )
                    <div class="desc"><p>{!! nl2br( $pageData[ 'SECTION_5' ][ 'desc' ] ) !!}</p></div>
                @endif
            </div>
            @if( isset( $pageData[ 'SECTION_5' ][ 'image' ] ) && $pageData[ 'SECTION_5' ][ 'image' ] )
            <div class="direction-l">
                <figure>
                <img src="{{ $pageData[ 'SECTION_5' ][ 'image' ] }}" alt="" class="img-fluid"/>
                </figure>
            </div>
            @endif
        </li>
        <!-- Item 4 -->

        <li class="row align-items-center justify-content-between flex-md-row-reverse">
            
            <div class="direction-l">
                <div class="flag-wrapper">
                    @if( isset( $pageData[ 'SECTION_6' ][ 'title' ] ) && $pageData[ 'SECTION_6' ][ 'title' ] )
                        <h2 class="flag">{{$pageData[ 'SECTION_6' ][ 'title' ]}}</h2>
                    @endif
                </div>
                @if( isset( $pageData[ 'SECTION_6' ][ 'desc' ] ) && $pageData[ 'SECTION_6' ][ 'desc' ] )
                    <div class="desc"><p>{!! nl2br( $pageData[ 'SECTION_6' ][ 'desc' ] ) !!}</p></div>
                @endif
            </div>
            @if( isset( $pageData[ 'SECTION_6' ][ 'image' ] ) && $pageData[ 'SECTION_6' ][ 'image' ] )
            <div class="direction-r">
                <figure>
                <img src="{{ $pageData[ 'SECTION_6' ][ 'image' ] }}" alt="" class="img-fluid"/>
                </figure>
            </div>
            @endif
            
        </li>
    </ul>

    </div></section>

    <!---------->
    <div class="clearfix"></div>
    <!--------->

@stop
