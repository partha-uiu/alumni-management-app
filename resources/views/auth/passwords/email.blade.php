@extends('layouts.master-auth')

@section('content')
    <section class="font-1 py-0">
        <div class="container">
            <div class="row align-items-center text-center justify-content-center h-full-non-fixed-nav">
                <div class="col-10 col-sm-10 col-md-6 col-lg-5 col-xl-4">

                    <h3 class="fw-300 mb-5">Reset Password</h3>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email Address" required>
                            @if ($errors->has('email'))
                                <div class="form-control-feedback">{{ $errors->first('email') }}</div>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            Send Password Reset Link
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
