@extends('pages.layouts.main', [ 'pageData' => $pageData ])
@section('content')

    <div class="main_banner">
        <div class="controller">
            <div class="over_banner"></div>
        </div>
        <div class="container">			
            <div class="row align-items-start single_banner">
                <div class="col-md-6 col-12">
                    <div class="summary_banner">
                        @if( isset( $pageData[ 'SECTION_1' ][ 'title' ] ) && $pageData[ 'SECTION_1' ][ 'title' ] )
                            <h1>{{$pageData[ 'SECTION_1' ][ 'title' ]}}</h1>
                        @endif
                        @if( isset( $pageData[ 'SECTION_1' ][ 'desc' ] ) && $pageData[ 'SECTION_1' ][ 'desc' ] )
                            <p>{!! nl2br( $pageData[ 'SECTION_1' ][ 'desc' ] ) !!}</p>
                        @endif
                    </div><!--summary_banner-->
                    
                </div>	
                <div class="col-md-6 col-12 text-center">
                    <div class="home_illustration"> 	
                        @if( isset( $pageData[ 'SECTION_1' ][ 'image' ] ) && $pageData[ 'SECTION_1' ][ 'image' ] )
                            <img src="{{$pageData[ 'SECTION_1' ][ 'image' ]}}" alt="" class="img-fluid"/>
                        @endif
                    </div>
                </div>					
            </div>			
        </div>
    </div>


    @if( $packages->count() > 0 )
    <!---------->
        <div class="clearfix"></div>
    <!--------->
        <section class="section package wow fadeIn">
            <div class="container">
                <div class="row justify-content-md-center row-eq-height mb-4">
                    
                    @foreach( $packages as $package )
                        @php
                            $desc = implode( "</li><li class=\"active\">", @array_filter( @array_map( 'trim', explode( "\r\n", $package->description ) ) ) );
                        @endphp
                        <div class="col-lg-5 col-md-12">
                            <div class="basic-plan shadow_bg bg-white">
                                <div class="package_clip text-center">
                                    <h3 class="plan-detail">{{ $package->name }}</h3>
                                    <div class="package_banner shadow_bg">
                                        @if($package->image)
                                            <i><img src="{{ url( 'public/upload/packages/' . $package->image ) }}" alt="{{ $package->name }}" /></i>
                                        @endif
                                        <p>${{$package->price}}<small>{{$durations[ $package->durations ]}}</small></p>
                                    </div>
                                </div>
                                @if( $desc )
                                    <ul class="services-list">
                                        {!! '<li class="active">' . $desc  . '</li>' !!}
                                    </ul>
                                @endif
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
        <!---------->
    @else
        <section class="section package wow fadeIn">
        </section>
    @endif

        <div class="clearfix"></div>
    <!--------->
@stop
