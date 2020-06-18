@extends('layouts.master')

@section('title', 'Invite')

@section('styles')
    <link href="{{asset('lib/semantic-ui-accordion/accordion.css')}}" rel="stylesheet">
    <link href="{{asset('lib/semantic-ui-dropdown/dropdown.css')}}" rel="stylesheet">
    <link href="{{asset('lib/semantic-ui-transition/transition.css')}}" rel="stylesheet">
@endsection

@section('content')
    <script>
        window.fbAsyncInit = function () {
            FB.init({
                appId: '503063713401675',
                autoLogAppEvents: true,
                xfbml: true,
                version: 'v2.11'
            });
        };

        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    @include('common.nav-section')

   <hr class="color-9 my-0">
    <section class="font-1 background-10" style="padding: 1.45rem 0;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5>Invite</h5>
                </div>
            </div>
        </div>
    </section>

    <section class="font-1 py-4">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-8 px-0 py-2">

                            <div class="background-oxford color-white p-3">
                                <p class="mb-0">

                                    <i class="icon-Bird-DeliveringLetter mr-2"></i>Invite People</p>
                            </div>

                            <div class="mt-5 w-100" id="fb-root"></div>
                            <a href='#' onclick="FacebookInviteFriends();">
                                <i class="fa fa-facebook-square" aria-hidden="true"></i>
                                Invite with Facebook
                            </a>

                            <a class="ml-2" href='https://mail.google.com/mail/u/0/?view=cm&fs=1&tf=1' target="_blank">
                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                Invite with Gmail
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3"><i style="font-size: 120px;" class="icon-Business-ManWoman"></i>  </div>

                <div class="col-lg-3 "> <i style="font-size: 120px;" class="icon-Paper-Plane"></i> </div>
                <div class="w-100 h-200"></div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </section>

@endsection

@section('scripts')

    <script src="{{asset('lib/semantic-ui-accordion/accordion.js')}}"></script>
    <script src="{{asset('lib/semantic-ui-dropdown/dropdown.js')}}"></script>
    <script src="{{asset('lib/semantic-ui-transition/transition.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>

    <script>

        function FacebookInviteFriends() {
            FB.ui({
                method: 'send',
                link: 'http://alumniconnect.technext.it',
            });
        }
    </script>
@endsection