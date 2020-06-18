@extends('layouts.master-auth')

@section('title', 'Alumni Connect')

@section('content')


    <section class="color-white py-0">
        <div class="background-holder" @if(isset($home->home_image_url)) style="background-image:url({{ asset('storage').'/'.$home->home_image_url}})" @else style="background-image:url({{ asset('images/education-video-header.jpg')}})" @endif>
        </div>
        <!--/.background-holder-->
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-xl-3 col-lg-4 col-md-5 col-sm-6 signup-bg py-10">
                    <a class="btn btn-block btn-icon facebook btn-icon-left" href="{{ route('social.auth', 'facebook') }}"><span class="fa fa-facebook"></span> Connect with Facebook</a>
                    <a class="btn btn-block btn-icon btn-linkedin btn-icon-left" href="{{ route('social.auth', 'linkedin') }}"><span class="fa fa-linkedin"></span> Connect with Linkedin</a>

                    <a class="btn color-white btn-block btn-icon btn-icon-left" href="{{route('register.step-1')}}" style="background: rgba(0, 33, 71, 0.9);">
                        <span class="fa fa-envelope-o"></span>
                        Connect with Email
                    </a>
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </section>

    <section class="background-11 py-0 text-center font-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 py-5 px-xl-4 px-2"><span class="d-block mb-3 fs-3 color-warning"><span class="fa fa-undo"></span></span>
                    @if(isset($home->box_title_1)&& isset($home->box_description_1))
                        <h5 class="fw-400">{{$home->box_title_1}}</h5>
                        <p class="color-5 mb-0 fs--1">{!!$home->box_description_1!!}</p>
                    @else
                        <h5 class="fw-400">Re-connect</h5>
                        <p class="color-5 mb-0 fs--1">Find and reminisce with fellow graduates, see what they have been up to and stay in touch.</p>
                    @endif
                </div>
                <div class="col-lg-3 col-md-6 py-5 px-xl-4 px-2"><span class="d-block mb-3 fs-3 color-warning"><span class="fa fa-heart-o"></span></span>

                    @if(isset($home->box_title_2)&& isset($home->box_description_2))
                        <h5 class="fw-400">{{$home->box_title_2}}</h5>
                        <p class="color-5 mb-0 fs--1">{!!$home->box_description_2!!}</p>
                    @else
                        <h5 class="fw-400">Give Back</h5>
                        <p class="color-5 mb-0 fs--1">Introduce, employ and offer to act as a mentor to our graduating students or take part in fundraising.</p>
                    @endif
                </div>
                <div class="col-lg-3 col-md-6 py-5 px-xl-4 px-2"><span class="d-block mb-3 fs-3 color-warning"><span class="fa fa-handshake-o"></span></span>

                    @if(isset($home->box_title_3)&& isset($home->box_description_3))
                        <h5 class="fw-400">{{$home->box_title_3}}</h5>
                        <p class="color-5 mb-0 fs--1">{!!$home->box_description_3!!}</p>
                    @else
                        <h5 class="fw-400">Expand</h5>
                        <p class="color-5 mb-0 fs--1">Leverage your professional network to get introduced to people you should know for career/job opportunity.</p>
                    @endif
                </div>
                <div class="col-lg-3 col-md-6 py-5 px-xl-4 px-2"><span class="d-block mb-3 fs-3 color-warning"><span class="fa fa-superpowers"></span></span>
                    @if(isset($home->box_title_4)&& isset($home->box_description_4))
                        <h5 class="fw-400">{{$home->box_title_4}}</h5>
                        <p class="color-5 mb-0 fs--1">{!!$home->box_description_4!!}</p>
                    @else
                        <h5 class="fw-400">Advance</h5>
                        <p class="color-5 mb-0 fs--1">Advance your career through inside connections working in top notch companies around the world.</p>
                    @endif
                </div>
                <div class="col-12"></div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </section>

    <section class="background-10 py-2 text-center font-1">
        <div class="container">
            <h5 class="pt-3 text-center">Recently Joined
                <hr class="short color-7 mt-2 center">
                <div class="row justify-content-center mt-4 text-center">

                    @if(count($alumni))
                        @foreach($alumni as $alumnus)
                            <div class="col-sm-2 col-md-2 col-lg-2 mb-4"><img class="radius-round" src="{{$alumnus->profile->profile_picture}}" alt="Member" width="120" height="120">
                                <h6 class="color-3 mt-3 mb-2">{{$alumnus->first_name.' '.$alumnus->last_name}}</h6>
                            </div>
                        @endforeach
                    @endif
                    <div class="w-100"></div>

                    <button class="btn btn-outline-info btn-capsule btn-sm my-4 hv-cursor-pointer" onclick="return checkFocus()">Sign In to Browse Alumni Directory</button>
                </div>
            </h5>
            <!--/.row-->
        </div>
        <!--/.container-->
    </section>

    <section class="py-4 background-0">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @if(isset($home->content_box_5_title)) <h5 class="mb-0 fw-400 color-2">  {{$home->content_box_5_title}}   </h5>
                    <hr class="short left my-3 color-8" align="left">@endif
                    <p class="color-5 font-1">@if(isset($home->content_box_5_description)) {!!$home->content_box_5_description!!}  @endif</p>
                </div>
                @if(isset($home->contact_heading))
                    <div class="col-md-4 pl-lg-5 pl-xl-6 mt-5 mt-md-0">
                        <h5 class="mb-0 fw-400 color-2"> {{$home->contact_heading}} </h5>
                        <hr class="short left my-3 color-8" align="left">
                        <div class="font-1">
                            {!! $home->contact_description !!}
                        </div>
                    </div>
                @endif
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </section>

@endsection

@section('scripts')
    <script>

        function checkFocus() {

            var signInBox = document.getElementById('signInBox');
            signInBox.style.opacity = 1;
            signInBox.style.pointerEvents = 'all';
            document.body.scrollTop = document.documentElement.scrollTop = 0;

        }

        

        var signInBox = document.getElementById('signInBox');
        signInBox.addEventListener("click", function (ev) {
            console.log('click');

            signInBox.style.opacity = 1;
            signInBox.style.pointerEvents = 'all';

            //this is important! If removed, you'll get both alerts
        }, false);


        //        document.body.addEventListener('click', check, true);

        document.getElementById("signInLink").addEventListener("mouseover", mouseOver);

        function mouseOver() {
            signInBox.style.opacity = 1;
            signInBox.style.pointerEvents = 'all';
        }

        document.getElementById("signInBox").addEventListener("mouseleave", mouseOut);

        function mouseOut() {
            signInBox.style.opacity = 0;
            signInBox.style.pointerEvents = 'none';
        }

    </script>
@endsection
