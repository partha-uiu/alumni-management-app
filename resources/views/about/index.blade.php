@extends('layouts.master')

@section('title', 'About')

@section('content')
    @include('common.nav-section')
    <hr class="color-9 my-0">

    <section class="font-1 py-6">
        <div class="container">
            @if(!$about)
                <div class="row text-center h-full-non-fixed-nav">
                    <div class="col">
                        <div class="alert alert-info">About page is not set up yet.</div>
                    </div>
                </div>
            @else
                <div class="row" style="min-height: 470px;">
                    <div class="col-lg-2 hidden-md-down">
                        <div class="perpendicular">
                            <h2 class="color-9 fs-6 text-uppercase lh-0" style="transform: translateY(36px);">{{$about->alumni_title ? str_replace(' ', '&nbsp;', $about->alumni_title) : ''}} </h2>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        @if(($about->department_slogan_title)&&($about->department_slogan_elaboration))
                            <h5 class="mb-4">&#8212; {{$about->department_slogan_title}}</h5>
                            <p class="lead mb-5 color-5">{!!$about->department_slogan_elaboration !!}</p>
                        @endif
                        @if(($about->mission_vision_title)&&($about->mission_vision_description) )
                            <h5 class="mb-4">&#8212; {{$about->mission_vision_title}}</h5>
                            <p class="color-5 mb-lg-0 mb-5">{!!$about->mission_vision_description!!} </p>
                        @endif
                    </div>
                    <div class="col-lg-4 pl-lg-5">
                        @if($about->foundation_date)
                            <h5 class="mb-0">&#8212; Founded in</h5>
                            <div class="fs-5 fw-100 mb-5">{{$about->foundation_date}}</div>
                        @endif
                        @if($about->total_alumni)
                            <h5 class="mb-3">&#8212; Alumni</h5>
                            <p class="fs-3 color-7 lh-1 mb-5 fw-300">{{$about->total_alumni}}</p>
                        @endif
                        @if($about->current_students)
                            <h5 class="mb-3">&#8212; Students</h5>
                            <h5 class="fs-3 fw-100 mb-5">{{$about->current_students}}</h5>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection