@extends('layouts.master-auth')

@section('title', 'Register | Success')

@section ('content')

    <section class="font-1 mentor-wrapper py-6 h-full-non-fixed-nav">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col text-center">
                    @if(session('success_msg_email'))
                        <i class="pb-4 fa fa-graduation-cap fa-5x"></i>
                        <h2 class="color-oxford fs-3 fs-md-4">Welcome to {{ config('app.name') }}</h2>
                        <p class="fs-0 fs-md-1 mt-3">You have been successfully registered.</p>
                        <p>Please verify your email to continue.</p>
                    @elseif(session('success_msg_social'))
                        <i class="pb-4 fa fa-graduation-cap fa-5x"></i>
                        <h2 class="color-oxford fs-3 fs-md-4">You're almost done!</h2>
                        <p class="fs-0 fs-md-1 mt-3">Please wait for the admin approval.</p>
                        <p> We have a strict policy to add only the verified member in our portal. Thanks for your patience.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection


