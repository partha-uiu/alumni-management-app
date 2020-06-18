@extends('layouts.master')

@section('title', 'Donation | '.$donation->title)

@section('content')

    @include('common.nav-section')

    <hr class="color-9 my-0">

    <section class="font-1 py-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 pb-4">
                    @include('feed.partials.alumni_feed_categories', ['active' => 'donation'])
                </div>
                <div class="col-lg-9 mb-4">
                    <h4 class="mb-2">{{$donation->title}}</h4>
                    <small class="color-5"><i class="fa fa-calendar"></i> {{$donation->created_at->format('d M Y h:i A') }}</small>

                    @if($donation->image_url)
                        <img class="mt-3" src="{{asset('storage').'/'.$donation->image_url}}" alt="{{$donation->title}}"/>
                    @endif

                    <div class="my-4">{!!$donation->description!!}</div>
                    @if($donation->payment_info)
                        <div class="my-4">
                            <h5>Payment Info:</h5>
                            <div>{!! $donation->payment_info !!}</div>
                        </div>
                    @endif

                    <table class="table my-4">
                        <tbody>
                            @if($donation->start_date)
                                <tr>
                                    <td>Start Date Time:</td>
                                    <td>
                                        {{Carbon\Carbon::createFromFormat('Y-m-d', $donation->start_date)->format('d M Y')}}
                                    </td>
                                </tr>
                            @endif
                            @if($donation->end_date)
                                <tr>
                                    <td>End Date Time:</td>
                                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d', $donation->end_date)->format('d M Y')  }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <a href="{{url()->previous()}}" class="btn btn-outline-dark my-2"><i class="fa fa-angle-left mr-2"></i> Go Back</a>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('styles')
    <link href="{{asset('css/right-scrollbar.css')}}" rel="stylesheet">
@endsection


