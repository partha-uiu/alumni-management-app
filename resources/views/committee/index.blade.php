@extends('layouts.master-auth')

@section('title', 'Committee')

@section('content')

    @if(Auth::check())
        @if (Auth::user()->hasAnyRole('super-admin|admin|editor|faculty-stuff'))
            @include('common.top-nav-admin')

        @elseif (Auth::user()->hasRole('alumni'))
            @include('common.top-nav-alumni')

        @endif
    @endif
    <hr class="color-9 my-0">

    <section class="text-center  font-1 py-6">
        <div class="container">
            @if($committee)

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <h3 class="color-1 mb-4">@if($committee->title) {{$committee->title}}@endif</h3>
                        <p class="color-4 lead">@if(($committee->title)&&(($committee->description))){!!$committee->description!!}@endif</p>
                        <hr class="short mb-8 color-8 mt-4">
                    </div>
                </div>

                <div class="row">
                    @if(count($committeeMembers))
                        @foreach($committeeMembers as $committeeMember)

                            <div class="col-sm-6 col-md-4 col-lg-3 p-4">
                                <img class="radius-round px-5"  @if($committeeMember->member_image)
                                src="{{asset('storage').'/'.$committeeMember->member_image}}"
                                     @else src="{{asset('images/sample.png')}}"
                                     @endif
                                     alt="Member">
                                <h5 class="fs-0 mt-3 mb-1"><a class="color-1" href="#">{{$committeeMember->member_name}}</a></h5>
                                <div class="fs--1 text-uppercase color-6">{{$committeeMember->member_title}}</div>
                            </div>
                        @endforeach
                    @endif
                </div>

            @else
                <div class="row text-center h-full">
                    <div class="col">
                        <div class="alert alert-info">Committee page is not set up yet !</div>
                    </div>
                </div>
        @endif
        <!--/.row-->
        </div>
        <!--/.container-->
    </section>

@endsection
