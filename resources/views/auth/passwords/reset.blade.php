@extends('layouts.master-auth')

@section('content')
    <section class="font-1 py-0">
        <div class="container">
            <div class="row align-items-center text-center justify-content-center h-full-non-fixed-nav">
                <div class="col-10 col-sm-10 col-md-6 col-lg-5 col-xl-4">

                    <h3 class="fw-300 mb-5">Reset Password</h3>

                    <form method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" placeholder="Email address" required autofocus>
                            @if ($errors->has('email'))
                                <div class="form-control-feedback">{{ $errors->first('email') }}</div>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input id="password" type="password" class="form-control" name="password" placeholder="New Password" required>
                            @if ($errors->has('password'))
                                <div class="form-control-feedback">{{ $errors->first('password') }}</div>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm New Password" required>
                            @if ($errors->has('password_confirmation'))
                                <div class="form-control-feedback">{{ $errors->first('password_confirmation') }}</div>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
