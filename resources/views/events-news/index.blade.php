@extends('layouts.master')

@section('title', 'Event | News')

@section('content')

    @include('common.nav-section')
    <hr class="color-9 my-0">
    <section class="font-1 background-10" style="padding: 1.45rem 0;">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8">
                    <h5 class="text-center text-md-left">
                        News
                        @if (Auth::user()->hasAnyRole('super-admin|admin|editor|faculty-stuff'))
                            <a href="{{route('news.create')}}" class="btn btn-outline-dark btn-xs ml-2"><i class="fa fa-plus"></i> Add New</a>
                        @endif
                    </h5>
                </div>
                <div class="d-none d-md-block col-md-4">
                    <h5 class="text-center text-md-left">
                        Events
                        <a href="{{route('events.create')}}" class="btn btn-outline-dark btn-xs ml-2"><i class="fa fa-plus"></i> Add New</a>
                    </h5>
                </div>
            </div>
        </div>
    </section>

    <hr class="color-9 mt-0">
    <section class="font-1 py-2">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8">
                    @foreach($news as $newsVal)
                        <div class="row mb-4">
                            <div class="col-3 col-md-3">
                                <img class="img-thumbnail"
                                     @if($newsVal->image_url)
                                     src="{{asset('storage').'/'.$newsVal->image_url}}"
                                     @else
                                     src="{{asset('images/no-image-default.jpg')}}"
                                     @endif
                                     width="100%">
                            </div>
                            <div class="col-9 col-md-9">
                                <h6 class="mb-2">
                                    <a class="color-oxford" href="{{ route('news.show',['id'=>$newsVal->id]) }}">
                                    {{$newsVal->heading}}
                                    </a>
                                </h6>
                                <div class="small text-muted">
                                    <i class="fa fa-calendar"></i>
                                    {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $newsVal->created_at)->format('d M Y')}}
                                </div>
                                <p class="mt-3 d-none d-sm-block">{!! str_limit($newsVal->description, 200) !!}</p>
                            </div>
                        </div>
                    @endforeach

                    @if(!$news->count())
                        <p class="lead">No news published yet</p>
                    @else
                        <div class="d-flex justify-content-left my-5">
                            <a class="btn background-oxford color-white" href="{{route('news')}}">View All News <i class="fa fa-angle-right"></i></a>
                        </div>
                    @endif
                </div>

                <div class="col-12 d-md-none d-block background-10 mb-3" style="padding-top: 1.45rem; padding-bottom: 1.45rem;">
                    <h5 class="text-center">
                        Events
                        <a href="{{route('events.create')}}" class="btn btn-outline-dark btn-xs"><i class="fa fa-plus"></i> Add New</a>
                    </h5>
                </div>

                <div class="col-12 col-md-4">
                    @if (Auth::user()->hasAnyRole('super-admin|admin|editor|faculty-stuff'))

                        @foreach($events as $event)
                            <div class="row no-gutters mb-3">
                                <div class="col-4">
                                    <div class="background-facebook color-white p-2 text-center lh-1">
                                        <div class="fs-3"> {{Carbon\Carbon::createFromFormat('Y-m-d', $event->start_date)->format('d')}}</div>
                                        <div class="d-block"> {{Carbon\Carbon::createFromFormat('Y-m-d', $event->start_date)->format('M')}}</div>
                                    </div>
                                    <div class="background-oxford color-white p-2 text-center small">
                                        {{Carbon\Carbon::createFromFormat('H:i:s', $event->start_time)->format('h:i A')}}
                                    </div>
                                </div>

                                <div class="col-8 pl-3">
                                    <h6>
                                        <a class="color-oxford" href="{{route('events.show',['id'=>$event->id])}}" target="_blank">
                                            {{$event->title}}
                                        </a>
                                    </h6>
                                    <div class=>{{$event->location}}</div>
                                </div>
                            </div>
                        @endforeach

                        @if(!$events->count())
                            <p class="lead">No events published yet</p>
                        @else
                            <div class="d-flex justify-content-left my-5">
                                @if (Auth::user()->hasAnyRole('super-admin|admin|editor|faculty-stuff'))
                                    <a class="btn background-oxford color-white" href="{{route('events',['status'=>'pending'])}}">View All Events <i class="fa fa-angle-right"></i></a>
                                @elseif (Auth::user()->hasAnyRole('alumni|student'))
                                    <a class="btn background-oxford color-white" href="{{route('events')}}">View All Events <i class="fa fa-angle-right"></i></a>
                                @endif
                            </div>
                        @endif

                    @elseif (Auth::user()->hasRole('alumni|student'))
                        @foreach($approvedEvents as $approvedEvent)
                            <div class="row no-gutters mb-3">
                                <div class="col-4">
                                    <div class="background-facebook color-white p-2 text-center lh-1">
                                        <div class="fs-3"> {{Carbon\Carbon::createFromFormat('Y-m-d', $approvedEvent->start_date)->format('d')}}</div>
                                        <div class="d-block"> {{Carbon\Carbon::createFromFormat('Y-m-d', $approvedEvent->start_date)->format('M')}}</div>
                                    </div>
                                    <div class="background-oxford color-white p-2 text-center small">
                                        {{Carbon\Carbon::createFromFormat('H:i:s', $approvedEvent->start_time)->format('h:i A')}}
                                    </div>
                                </div>

                                <div class="col-8 pl-3">
                                    <h6>
                                        <a class="color-oxford" href="{{route('events.show',['id'=>$approvedEvent->id])}}" target="_blank">
                                            {{$approvedEvent->title}}
                                        </a>
                                    </h6>
                                    <div class=>{{$approvedEvent->location}}</div>
                                </div>
                            </div>
                        @endforeach

                        @if(!$approvedEvents->count())
                            <p class="lead">No events published yet</p>
                        @else
                            <div class="d-flex justify-content-left my-5">
                                @if (Auth::user()->hasAnyRole('super-admin|admin|editor|faculty-stuff'))
                                    <a class="btn background-oxford color-white" href="{{route('events',['status'=>'pending'])}}">View All Events <i class="fa fa-angle-right"></i></a>
                                @elseif (Auth::user()->hasAnyRole('alumni|student'))
                                    <a class="btn background-oxford color-white" href="{{route('events')}}">View All Events <i class="fa fa-angle-right"></i></a>
                                @endif
                            </div>
                        @endif
                </div>
                @endif


            </div>
        </div>
    </section>

@endsection

