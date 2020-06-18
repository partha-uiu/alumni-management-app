@extends('layouts.master')

@section('title', 'Approval')

@section('styles')
    <link href="{{asset('lib/owl.carousel/dist/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('lib/owl.carousel/dist/assets/owl.theme.default.min.css')}}" rel="stylesheet">
@endsection

<!-- Main stylesheet and color file-->

@section('content')

    @include('common.not-approved')

    <hr class="color-9 mt-0">
    <section class="font-1 py-4">
        <div class="container">
            @include('common.notifications')

            <div class="row">

                <div class="col-lg-12 justify-content-center h-200">

                    <div class="alert alert-info" role="alert">
                        <i class="fa fa-info-circle" aria-hidden="true"></i> Sorry, Your account is not approved yet ! please wait for the confirmation
                    </div>

                </div>

            </div>
            <div class="py-4"></div>
        </div>
        <!--/.container-->
    </section>
@endsection

<!--  -->
<!--    JavaScripts-->
<!--    =============================================-->
@section('scripts')

    <script src="https://unpkg.com/vue@2.5.9/dist/vue.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>

    <script src="assets/lib/owl.carousel/dist/owl.carousel.min.js"></script>

@endsection