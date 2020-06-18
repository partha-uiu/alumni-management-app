@extends('layouts.master')

@section('title', 'Dashboard')

@section('styles')
    <link href="{{asset('lib/owl.carousel/dist/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('lib/owl.carousel/dist/assets/owl.theme.default.min.css')}}" rel="stylesheet">
@endsection

<!-- Main stylesheet and color file-->

@section('content')

    @include('common.nav-section')

    <hr class="color-9 mt-0">
    <section class="font-1 pt-2 pb-4">
        <div class="container">

            <div class="row pb-4">
                <div class="col-lg-4 py-0">
                    <div class="background-oxford color-white p-3">
                        <p class="mb-0">Upcoming Events</p>
                    </div>
                    <div class="background-11 py-3 px-3">

                        @foreach($approvedEvents as $approvedEvent)
                            <a class="color-oxford" href="{{route('events.show', ['id'=>$approvedEvent->id])}}" target="_blank">
                                <h6>{{$approvedEvent->title}}</h6>
                                <p class="fs--1">{{Carbon\Carbon::createFromFormat('Y-m-d',$approvedEvent->start_date)->format('D M Y')}}</p></a>
                            <hr class="color-9">
                        @endforeach

                        <a class="btn btn-link pl-0" href="{{route('events')}}">See All Events &xrarr;</a>
                    </div>
                </div>


                <div class="col-lg-4 py-0">
                    <div class="background-oxford color-white p-3">
                        <p class="mb-0">Latest Job Posts</p>
                    </div>
                    <div class="background-11 py-3 px-3">

                        @foreach($approvedJobs as $approvedJob)
                            <a class="color-oxford" href="{{route('jobs.show', ['id'=>$approvedJob->id])}}" target="_blank">
                                <h6>{{$approvedJob->job_title}}</h6>
                                <p class="fs--1">{{$approvedJob->company_name}}</p></a>
                            <hr class="color-9">
                        @endforeach

                        <a class="btn btn-link pl-0" href="{{route('jobs')}}">See All Jobs &xrarr;</a>
                    </div>
                </div>

                <div class="col-lg-4 py-0">
                    <div class="background-oxford color-white p-3">
                        <p class="mb-0">Donate Today</p>
                    </div>

                    <div class="background-11 py-3 px-3">

                        @foreach($approvedDonations as $approvedDonation)
                            <a class="color-oxford" href="{{route('donations.show', ['id'=>$approvedDonation->id])}}" target="_blank">
                                <h6>{{$approvedDonation->title}}</h6>
                                <p class="fs--1">@if($approvedDonation->start_date){{Carbon\Carbon::createFromFormat('Y-m-d',$approvedDonation->start_date)->format('D M Y')}}@else {{'No date found !'}}@endif</p>
                            </a>
                            <hr class="color-9">
                        @endforeach

                        <a class="btn btn-link pl-0" href="{{route('donations')}}">See All Donations &xrarr;</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="background-oxford color-white p-3 mb-3">
                        <p class="mb-0 d-inline-block">Memory Lane</p><a class="pull-right color-white" href="#">Share your photos &xrarr;</a>
                    </div>
                    <div class="owl-carousel owl-theme owl-theme-danger text-center owl-dots-inner owl-dot-round" data-dots="true" data-nav="true"
                         data-items='{"0":{"items":1},"600":{"items":1},"1000":{"items":1}}' data-autoplay="true" data-margin="100" data-loop="true">
                        <a class="item color-white" href="#">
                            <div class="hoverbox"><img src="assets/images/shop/shop-women-slider-3.jpg">
                                <div class="hoverbox-content h-100">
                                    <div class="row h-100">
                                        <div class="col-12 align-self-end">
                                            <div class="py-3 my-6 mx-3" style="background-color: rgba(255, 59, 48, 0.8);">
                                                <h3>Petro Wear</h3>
                                                <hr class="my-0">
                                                <h6 class="mt-2">Get up to 60% off SheIn's summer collection</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a class="item color-white" href="#">
                            <div class="hoverbox"><img src="assets/images/shop/shop-women-slider-2.jpg">
                                <div class="hoverbox-content h-100">
                                    <div class="row h-100">
                                        <div class="col-12 align-self-end">
                                            <div class="py-3 my-6 mx-3" style="background-color: rgba(255, 59, 48, 0.8);">
                                                <h3>Must-have Dress</h3>
                                                <hr class="my-0">
                                                <h6 class="mt-2">Get up to 60% off SheIn's summer collection</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a class="item color-white" href="#">
                            <div class="hoverbox"><img src="assets/images/shop/shop-women-slider-1.jpg">
                                <div class="hoverbox-content h-100">
                                    <div class="row h-100">
                                        <div class="col-12 align-self-end">
                                            <div class="py-3 my-6 mx-3" style="background-color: rgba(255, 59, 48, 0.8);">
                                                <h3>Summer Lovin'</h3>
                                                <hr class="my-0">
                                                <h6 class="mt-2">Get up to 60% off SheIn's summer collection</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a class="item color-white" href="#">
                            <div class="hoverbox"><img src="assets/images/shop/shop-women-slider-3.jpg">
                                <div class="hoverbox-content h-100">
                                    <div class="row h-100">
                                        <div class="col-12 align-self-end">
                                            <div class="py-3 my-6 mx-3" style="background-color: rgba(255, 59, 48, 0.8);">
                                                <h3>Petro Wear</h3>
                                                <hr class="my-0">
                                                <h6 class="mt-2">Get up to 60% off SheIn's summer collection</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a class="item color-white" href="#">
                            <div class="hoverbox"><img src="assets/images/shop/shop-women-slider-2.jpg">
                                <div class="hoverbox-content h-100">
                                    <div class="row h-100">
                                        <div class="col-12 align-self-end">
                                            <div class="py-3 my-6 mx-3" style="background-color: rgba(255, 59, 48, 0.8);">
                                                <h3>Must-have Dress</h3>
                                                <hr class="my-0">
                                                <h6 class="mt-2">Get up to 60% off SheIn's summer collection</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a class="item color-white" href="#">
                            <div class="hoverbox"><img src="assets/images/shop/shop-women-slider-1.jpg">
                                <div class="hoverbox-content h-100">
                                    <div class="row h-100">
                                        <div class="col-12 align-self-end">
                                            <div class="py-3 my-6 mx-3" style="background-color: rgba(255, 59, 48, 0.8);">
                                                <h3>Summer Lovin'</h3>
                                                <hr class="my-0">
                                                <h6 class="mt-2">Get up to 60% off SheIn's summer collection</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="background-oxford color-white p-3">
                        <p class="mb-0">Recently Joined</p>
                    </div>

                    <div class="row justify-content-around mt-4">
                        @foreach($alumni->take(8) as $alumnus)

                            <div class="col-4 col-lg-3 mb-4">
                                <a href="{{route('alumni-directory.show',['id'=>$alumnus->id])}}" target="_blank">
                                    <img class="radius-round" src="{{$alumnus->profile->profile_picture}}" alt="Member" width="120">
                                    <h6 class="color-3 mt-3 mb-2">{{$alumnus->first_name.' '.$alumnus->last_name}}</h6>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <a class="btn btn-outline-dark btn-capsule btn-sm my-4" href="{{route('alumni-directory')}}">Browse Alumni Directory</a>
                    <a class="w-100 d-block background-oxford color-white p-3 mt-2" href="{{route('profile.edit',['id'=>Auth::id()])}}">Update your profile &xrarr;</a>
                    <a class="w-100 d-block background-oxford color-white p-3 mt-2" href="{{route('alumni-directory')}}">Total Members {{$alumni->count()}}</a>
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </section>

@endsection

<!--  -->
<!--    JavaScripts-->
<!--    =============================================-->
@section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
            crossorigin="anonymous"></script>

    <script src="assets/lib/owl.carousel/dist/owl.carousel.min.js"></script>

@endsection