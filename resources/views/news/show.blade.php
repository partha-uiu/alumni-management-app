@extends('layouts.master')

@section('title', 'News | '.$news->heading)

@section('content')

    @include('common.nav-section')
    <hr class="color-9 my-0">

    <section class="font-1 py-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 pb-4">
                    @include('feed.partials.alumni_feed_categories', ['active' => 'news'])
                </div>
                <div class="col-lg-9 mb-4">
                    <h4 class="mb-2">{{$news->heading}}</h4>
                    <small class="color-5"><i class="fa fa-calendar"></i> {{$news->created_at->format('d M Y h:i A') }}</small>

                    @if($news->image_url)
                        <div class="pull-left pr-4 pb-2 pull-md-right">
                            <img width="200" class="img-thumbnail" @if($news->image_url) src="{{asset('storage').'/'.$news->image_url}}" @else src="{{asset('images/no-image-default.jpg')}}" @endif />
                        </div>
                    @endif
                    <div class="my-4">{!! $news->description !!}</div>
                    @if($news->link)
                        <div class="mb-3">
                            <strong>Link: </strong> <a href="{{$news->link}}">{{$news->link}}</a>
                        </div>
                    @endif
                    <a href="{{url()->previous()}}" class="btn btn-outline-dark my-2"><i class="fa fa-angle-left mr-2"></i> Go Back</a>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('styles')

    <link href="{{asset('css/right-scrollbar.css')}}" rel="stylesheet">

@endsection




