@extends('layouts.master')

@section('title', 'Password | Settings')

@section('content')

    @include('common.nav-section')

    <hr class="color-9 mt-0">
    <section class="font-1 py-4">
        <div class="container">
            <div class="row mb-4 justify-content-center">
                <div class="col-lg-6">
                    @if(session('success'))
                        @include('common.notifications')
                    @endif
                    <div class="row align-items-center mb-4 ml-0">
                        <div class="col-auto">
                            <h4>Create a new password</h4>
                            <small class="text-muted">If you create a password for your social account, you can login with both email and social account.In the time of login provide the email address corresponding to your social account email.</small>
                        </div>
                    </div>
                    <form method="POST" action="{{route('settings.password.update')}}">
                        {{ csrf_field() }}
                        <div class="form-group @if ($errors->has('new_password')) has-danger @endif">
                            <label for="newPassword">New Password</label>
                            <input class="form-control mb-3" type="password" id="newPassword" name="new_password">
                            @if ($errors->has('new_password'))

                                <div class="form-control-feedback text-left text-danger">  {{ $errors->first('new_password') }}</div>

                            @endif

                        </div>
                        <div class="form-group @if ($errors->has('new_password_confirmation')) has-danger @endif">
                            <label for="confirmNewPassword">Confirm New Password</label>
                            <input class="form-control mb-3" type="password" id="confirmNewPassword" name="new_password_confirmation">
                            @if ($errors->has('new_password_confirmation'))

                                <div class="form-control-feedback text-left text-danger">  {{ $errors->first('new_password_confirmation') }}</div>

                            @endif

                            <span id='message'></span>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-6 text-left">
                                <button class=" btn btn-primary btn-cursor-pointer" type="submit" id="apply">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $(' #confirmNewPassword').on('keyup', function () {
                if ($('#newPassword').val() == $('#confirmNewPassword').val()) {
                    $('#message').html('Matched').css('color', 'green');
                } else
                    $('#message').html('Not Matching').css('color', 'red');
            });
        });
    </script>
@endsection

