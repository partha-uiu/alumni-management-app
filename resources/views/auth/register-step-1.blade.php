@extends('layouts.master-auth')

@section('title', 'Register | Step-1')

@section('content')
    <style>#frmCheckPassword {
            border-top: #F0F0F0 2px solid;
            background: #FAF8F8;
            padding: 10px;
        }

        .demoInputBox {
            padding: 7px;
            border: #F0F0F0 1px solid;
            border-radius: 4px;
        }

        #password-strength-status {
            padding: 5px 10px;
            color: #FFFFFF;
            border-radius: 4px;
            margin-top: 5px;
            font-size: smaller;
        }

        .medium-password {
            background-color: #E4DB11;
            border: #BBB418 1px solid;
        }

        .weak-password {
            background-color: #FF6600;
            border: #AA4502 1px solid;
        }

        .strong-password {
            background-color: #12CC1A;
            border: #0FA015 1px solid;
        }
    </style>
    <section class="font-1 py-6">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-8">
                    <h5>Hello @if(session('profile')->get('driver')){{', '.session('profile')->get('first_name')}} @endif</h5>
                    <form method="post" id="regForm" action="{{route('register.step-2')}}" enctype="multipart/form-data" files="true">
                        {{csrf_field()}}
                        <div class="row align-items-center text-center justify-content-center">

                            @if(session('profile')->get('driver'))
                                <div class="col-md-12 text-left mb-2">
                                    <img src="{{session('profile')->get('avatar') }}" alt="Facebook Avatar" height="64" width="64">
                                    <input type="hidden" name="social_avatar" value="{{session('profile')->get('avatar') }}">
                                </div>
                            @endif

                            <div class="col-md-6">
                                <div class="form-group @if ($errors->has('first_name')) has-danger @endif">
                                    <input class="form-control"
                                           type="text"
                                           name="first_name"
                                           placeholder="First name *"
                                           value="{{old('first_name',session('profile')->get('first_name'))}}" id="firstName">

                                    @if ($errors->has('first_name'))

                                        <div class="form-control-feedback text-left text-danger">  {{ $errors->first('first_name') }}</div>

                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group @if ($errors->has('last_name')) has-danger @endif">

                                    <input class="form-control"
                                           type="text" name="last_name"
                                           placeholder="Last name *"
                                           value="{{old('last_name',session('profile')->get('last_name'))}}">

                                    @if ($errors->has('last_name'))

                                        <div class="form-control-feedback text-left text-danger">  {{ $errors->first('last_name') }}</div>

                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group  @if ($errors->has('email')) has-danger @endif">
                                    <input class="form-control"
                                           type="text" name="email" id="regEmail"
                                           placeholder="Email *"
                                           value="{{old('email',session('profile')->get('email'))}}" onblur="checkEmail()">

                                    @if ($errors->has('email'))
                                        <div class="form-control-feedback text-left text-danger">  {{ $errors->first('email') }}</div>
                                    @endif
                                </div>
                                <div class="text-danger text-left" id="errorEmail"></div>
                            </div>

                            @if(!session('profile')->get('driver'))

                                <div class="col-md-6">
                                    <div class="form-group @if ($errors->has('password')) has-danger @endif">
                                        <input class="form-control"
                                               type="password"
                                               name="password"
                                               placeholder="Password *" id="pwd" onKeyUp="checkPasswordStrength();">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group @if ($errors->has('password')) has-danger @endif">
                                        <input class="form-control"
                                               type="password"
                                               name="password_confirmation"
                                               placeholder="Confirm Password *">
                                    </div>
                                </div>
                                @if ($errors->has('password'))
                                    <div class="form-control-feedback text-left text-danger">  {{ $errors->first('password') }}</div>

                                @endif
                                <div class="col-md-12 mb-2">
                                    <div id="password-strength-status"></div>
                                </div>

                            @else
                                @php
                                    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
                                    $randomPassword = substr( str_shuffle( $chars ), 0, 7 )."a3T";
                                @endphp
                                <input type="hidden" value="{{$randomPassword}}" name="password">
                                <input type="hidden" value="{{$randomPassword}}" name="password_confirmation">
                            @endif

                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="form-control"
                                              name="address"
                                              id="exampleFormControlTextarea1"
                                              rows="3"
                                              placeholder="Address" id="address">{{old('address',session('profile')->get('address')) }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group @if ($errors->has('dist_state')) has-danger @endif">
                                    <input class="form-control "
                                           type="text"
                                           name="dist_state"
                                           placeholder="Current State/District *"
                                           value="{{old('dist_state',session('profile')->get('dist_state'))}}">

                                    @if ($errors->has('dist_state'))
                                        <div class="form-control-feedback text-left text-danger">  {{ $errors->first('dist_state') }}</div>

                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group @if ($errors->has('country_id')) has-danger @endif">
                                    <select class="form-control hv-cursor-pointer" name="country_id">
                                        <option disabled selected>Select Current Country *</option>
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}"
                                                    @if((old('country_id')==$country->id ) ||(session('profile')->get('country_id')==$country->id))selected @endif>
                                                {{$country->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('country_id'))
                                        <div class="form-control-feedback text-left text-danger">  {{ $errors->first('country_id') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group @if ($errors->has('user_type_id')) has-danger @endif">
                                    <select class="form-control hv-cursor-pointer" name="user_type_id">
                                        <option disabled selected>Select Affiliation *</option>
                                        @foreach($userTypes as $userType)
                                            <option value="{{$userType->id}}"
                                                    @if ((old('user_type_id')==$userType->id)||(session('profile')->get('user_type_id')==$userType->id))selected @endif>
                                                {{ucfirst($userType->name)}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('user_type_id'))
                                        <div class="form-control-feedback text-left text-danger">  {{ $errors->first('user_type_id') }}</div>

                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-control hv-cursor-pointer" name="session_id">
                                        <option disabled selected>Select Session</option>
                                        @foreach($sessions as $session)
                                            <option value="{{$session->id}}"
                                                    @if ((old('session_id')==$session->id)||(session('profile')->get('session_id')==$session->id))selected @endif>
                                                {{$session->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-control hv-cursor-pointer" name="department_id" disabled>
                                        <option value=""
                                                @if (old('department_id')==$department->id)selected @endif selected>
                                            {{$department->name}}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-control hv-cursor-pointer" name="institution_id" disabled>
                                        <option value="" selected>{{$institution->name}}</option>
                                    </select>
                                </div>
                            </div>

                            @if(!session('profile')->get('driver'))

                                <div class="col-md-12 text-left">
                                    <div class="form-group"></div>
                                    <input class="inputfile"
                                           id="file-1"
                                           name="profile_photo_url"
                                           type="file"
                                           data-multiple-caption="{count} files selected"
                                           multiple="">
                                    <label class="btn btn-outline-primary btn-sm" for="file-1"><span>Choose Your Profile Photo</span></label>
                                </div>
                            @endif

                            <div class="col-md-12 text-right">
                                <span class="req-red small text-right">*</span>
                                <small> Required Fields</small>
                            </div>

                            <div id="app" class="col-md-12 text-left">
                                <div class="col-md-12 text-left">
                                    <div class="form-group"></div>
                                    <div class="zinput zcheckbox">
                                        <input id="cb6" name="cb6" type="checkbox" v-model="checked">
                                        <label for="cb6">I agree the terms of <a href="#">{{ config('app.name') }}</a> and policy of {{ config('app.name') }}.</label>
                                        <svg v-if="checked" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16" style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                                        </svg>
                                    </div>
                                </div>

                                <div class="col-12 text-left">
                                    <button class="btn btn-primary hv-cursor-pointer" type="submit" name="submit" :disabled="!checked">Sign me in</button>
                                </div>
                            </div>

                            <div class="zform-feedback mt-3"></div>
                        </div>
                    </form>
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </section>

@endsection

@section('scripts')

    <script>
        function checkPasswordStrength() {
            var number = /([0-9])/;
            var alphabets = /([a-zA-Z])/;
            var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
            if ($('#pwd').val().length < 8) {
                $('#password-strength-status').removeClass();
                $('#password-strength-status').addClass('weak-password');
                $('#password-strength-status').html("Weak (should be at least 8 digit ,contain uppercase, number and character.)");
            } else {
                if ($('#pwd').val().match(number) && $('#pwd').val().match(alphabets) && $('#pwd').val().match(special_characters)) {
                    $('#password-strength-status').removeClass();
                    $('#password-strength-status').addClass('strong-password');
                    $('#password-strength-status').html("Strong");
                } else {
                    $('#password-strength-status').removeClass();
                    $('#password-strength-status').addClass('medium-password');
                    $('#password-strength-status').html("Medium (should include alphabets, numbers and special characters.)");
                }
            }
        }
    </script>

    <script>
        function checkEmail() {
            var x = document.getElementById("regEmail").value;
            var atpos = x.indexOf("@");
            var dotpos = x.lastIndexOf(".");
            document.getElementById("errorEmail").innerHTML = "";

            if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {
                document.getElementById("errorEmail").innerHTML = "Please provide a valid email ";
                return false;
            }
        }
    </script>

    <script src="https://unpkg.com/vue@2.5.9/dist/vue.js"></script>

    <script>

        var app = new Vue({
            el: '#app',
            data: {
                checked: false
            }
        });
    </script>

@endsection