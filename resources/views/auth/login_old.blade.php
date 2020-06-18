@extends('layouts.master')

@section('content')

    <section class="py-0 font-1">
        <div class="container-fluid">
            <div class="row align-items-center text-center justify-content-center h-full">
                <div class="col-sm-6 col-md-5 col-lg-4 col-xl-3">

                    @include('common.notifications')

                    <h3 class="fw-300 mb-5">Log in</h3>

                    <a class="btn btn-icon btn-block facebook btn-icon-left mr-2" href="{{ route('social.auth', 'facebook') }}"><span class="fa fa-facebook"></span> Log in with facebook</a>
                    <a class="btn btn-icon btn-block btn-linkedin btn-icon-left" href="{{ route('social.auth', 'linkedin') }}"><span class="fa fa-linkedin"></span> Log in with Linkedin</a>
                    <p class="lead my-3">or</p>
                    <form  method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <input id="email" type="email" class="form-control mb-3" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
                        <input id="password" type="password" class="form-control mb-3" name="password" placeholder="Password" required>

                        <div class="row align-items-center">
                            <div class="col text-left">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="col text-right">
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="col text-left">
                                <div class="fs--1 d-inline-block"><a href="{{ route('password.request') }}">Forgot your password?</a></div>
                            </div>
                            <div class="col text-right">
                                <button class="btn-block btn btn-primary" type="submit">Log in</button>
                            </div>
                        </div>

                    </form>
                    
                    <hr class="color-9 mt-6">
                    <div class="fs--1 mt-4">Need an account? <a href="{{route('register.index')}}">Sign up.</a></div>
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </section>

@endsection
