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
    <section class="section Faq wow fadeIn">
        <div class="container">
        <!--Accordion wrapper-->
            <div class="col-lg-10 col-md-12 accordion md-accordion accordion-4 m-auto" id="accordionEx2" role="tablist" aria-multiselectable="true">
                @foreach( $faqs as $index => $faq )
                <!-- Accordion card -->
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header z-depth-1 teal lighten-4" role="tab" id="heading{{$index}}">
                        <a data-toggle="collapse" data-parent="#accordionEx2" href="#collapse{{$index}}" aria-expanded="{{ $index == 0?'true':'false'}}"
                        aria-controls="collapse{{$index}}" class="{{ $index == 0?'':' collapsed'}}">
                        <h6 class="mb-0 black-text">{{$faq->question}}</h6>
                        </a>
                    </div>
                    <!-- Card body -->
                    <div id="collapse{{$index}}" class="collapse {{ $index == 0?' show':''}}" role="tabpanel" aria-labelledby="heading{{$index}}"
                        data-parent="#accordionEx2">
                        <div class="card-body rgba-teal-strong white-text">
                            <p>{!! @nl2br( $faq->answer ) !!}</p>
                        </div>
                    </div>
                </div>
                <!-- Accordion card -->
                @endforeach
            </div>
        <!--/.Accordion wrapper-->
        </div>
    </section>
    <!---------->
    <div class="clearfix"></div>
    <!--------->
@stop
