@extends('layouts.master')

@section('title', 'Admin | Settings')

@section('content')

    @include('common.nav-section')

    <hr class="color-9 mt-0">
    <section class="font-1 py-4">
        <div class="container">
            <div class="row mb-4 justify-content-center" id="app">
                <div class="col-md-9 pl-lg-5">
                    <div class="row mb-2">
                        @if(session('success'))
                            @include('common.notifications')
                        @endif
                    </div>

                    <h4 class="mt-4">Admin Settings</h4>
                    <div class="w-100"></div>

                    <div class="tabs overflow-hidden">
                        <div class="nav-bar">
                            <div class="nav-bar-item @if(session('generalTab')) active @elseif((!session('generalTab')) && (!session('mentoringTab')) && (!session('degreesTab')) && (!session('sessionsTab')) ) active @endif">General</div>
                            <div class="nav-bar-item @if(session('mentoringTab')) active @endif">Mentoring</div>
                            <div class="nav-bar-item @if(session('degreesTab')) active @endif">Degrees</div>
                            <div class="nav-bar-item @if(session('sessionsTab')) active @endif">Sessions</div>
                        </div>

                        <div class="tab-contents" >
                            
                            <div class="tab-content @if(session('generalTab')) active @elseif((!session('generalTab')) && (!session('mentoringTab')) && (!session('degreesTab')) && (!session('sessionsTab')) ) active @endif">
                                <form method="POST" action="{{route('settings.user-update',['id'=>Auth::id()])}}">
                                    {{ csrf_field() }}

                                    <div class="form-group @if ($errors->has('first_name')) has-danger @endif">
                                        <label for="first_name">First Name</label>
                                        <input class="form-control mb-3" type="text" id="first_name" name="first_name" value="{{$adminInfo->first_name}}">

                                        @if ($errors->has('first_name'))
                                            <div class="form-control-feedback">{{ $errors->first('title') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group @if ($errors->has('last_name')) has-danger @endif">

                                        <label for="last_name">Last Name</label>
                                        <input class="form-control mb-3" type="text" id="last_name" name="last_name"
                                               value="{{$adminInfo->last_name}}">
                                        @if ($errors->has('last_name'))
                                            <div class="form-control-feedback">{{ $errors->first('last_name') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group @if ($errors->has('email')) has-danger @endif">
                                        <label for="email">Email</label>
                                        <input class="form-control mb-3" type="text" id="email" name="email" value="{{$adminInfo->email}}">

                                        @if ($errors->has('email'))
                                            <div class="form-control-feedback">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group @if ($errors->has('old_password')) has-danger @endif">

                                        <label for="oldPassword">Password</label>
                                        <input class="form-control mb-3" type="password" id="oldPassword" name="old_password">
                                        @if ($errors->has('old_password'))
                                            <div class="form-control-feedback">{{ $errors->first('old_password') }}</div>
                                        @endif

                                    </div>

                                    <div class="form-group @if ($errors->has('new_password')) has-danger @endif">

                                        <label for="newPassword">New Password</label>
                                        <input class="form-control mb-3" type="password" id="newPassword" name="new_password">

                                        @if ($errors->has('new_password'))
                                            <div class="form-control-feedback">{{ $errors->first('new_password') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group @if ($errors->has('new_password_confirmation')) has-danger @endif">

                                        <label for="confirmNewPassword">Confirm New Password</label>
                                        <input class="form-control mb-3" type="password" id="confirmNewPassword" name="new_password_confirmation">
                                        @if ($errors->has('new_password_confirmation'))
                                            <div class="form-control-feedback">{{ $errors->first('new_password_confirmation') }}</div>
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

                            <div class="tab-content @if(session('mentoringTab')) active @endif">
                                <form method="POST" action="{{route('mentorship-topic.store')}}">
                                    {{ csrf_field() }}
                                    <div class="form-group @if ($errors->has('title')) has-danger @endif">
                                        <label for="mentorship_topics">Mentorship Topic</label>
                                        <input class="form-control" type="text" name="title" id="mentorship_topics">
                                        @if ($errors->has('title'))
                                            <div class="form-control-feedback">{{ $errors->first('title') }}</div>
                                        @endif
                                        <button class="btn btn-outline-primary btn-xs mt-2" type="submit">Add</button>
                                    </div>
                                </form>

                                <table class="table mt-2 ">
                                    <tr>
                                        <th>Title</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                    @foreach($mentorshipTopics as $mentorshipTopic)
                                        <tr>
                                            <td>{{$mentorshipTopic->title}}</td>
                                            <td><a href="{{route('mentorship-topic.edit',['id'=>$mentorshipTopic->id])}}"><i class="fa fa-pencil"></i></a></td>
                                            <td><a href="{{route('mentorship-topic.destroy',['id'=>$mentorshipTopic->id])}}" onclick="return chkDelete();"><i class="fa fa-trash"></i></a></td>
                                        </tr>
                                    @endforeach
                                </table>

                            </div>

                            <div class="tab-content @if(session('degreesTab')) active @endif">
                                <form method="POST" action="{{route('degree.store')}}">
                                    {{ csrf_field() }}
                                    <div class="form-group @if ($errors->has('name.*')) has-danger @endif">
                                        <label for="degree_name">Degree Name</label>
                                        
                                        <div v-for="(degree,index) in degrees">
                                            <input class="form-control mb-2" type="text" name="name[]" id="degree_name">
                                            @if ($errors->has('name.*'))
                                                <div class="form-control-feedback">{{ $errors->first('name.*') }}</div>
                                            @endif

                                            <div class="col-md-12 text-right" v-if="index >0">
                                                <div class="form-group">
                                                    <button class="btn btn-danger btn-xs hv-cursor-pointer"
                                                            type="button"
                                                            @click="removeDegree(degree)"> Remove
                                                    </button>
                                                </div>
                                               
                                            </div>

                                        </div>

                                        <div class="col-md-12 text-right ">
                                            <div class="form-group">
                                                <button class="btn btn-primary btn-xs hv-cursor-pointer"
                                                        type="button"
                                                        @click="addDegree"> Add More
                                                </button>
                                            </div>
                                        </div>

                                        <div class="col-6 ">
                                        </div>

                                        <div class="col-4 ">
                                            <button class="btn btn-outline-primary btn-xs btn-block mt-2 hv-cursor-pointer" type="submit">Save</button>
                                        </div>
                                    </div>
                                </form>

                                <table class="table mt-2 ">
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                    @foreach($degrees as $degree)
                                        <tr>
                                            <td>{{$degree->id}}</td>
                                            <td>{{$degree->name}}</td>
                                            <td><a href="{{route('degree.edit',['id'=>$degree->id])}}"><i class="fa fa-pencil"></i></a></td>
                                            <td><a href="{{route('degree.destroy',['id'=>$degree->id])}}" onclick="return chkDelete();"><i class="fa fa-trash"></i></a></td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>

                            <div class="tab-content @if(session('sessionsTab')) active @endif">
                                <form method="POST" action="{{route('session.store')}}">
                                    {{ csrf_field() }}
                                    <div class="form-group @if ($errors->has('session_name.*')) has-danger @endif">
                                        <label for="session_name">Session Name</label>
                                        <div v-for="(row,index) in sessions">
                                            <input class="form-control mb-2"  type="text" name="session_name[]"  id="session_name">
                                            @if ($errors->has('session_name.*'))
                                                <div class="form-control-feedback">{{ $errors->first('session_name.*') }}</div>
                                            @endif
                                            <div class="col-md-12 text-right" v-if="index >0">
                                                <div class="form-group">
                                                    <button class="btn btn-danger btn-xs hv-cursor-pointer"
                                                            type="button"
                                                            @click="removeSession(row)"> Remove
                                                    </button>
                                                </div>    
                                            </div>
                                        </div>

                                        <div class="col-md-12 text-right">
                                            <div class="form-group">
                                                <button class="btn btn-primary btn-xs hv-cursor-pointer"
                                                        type="button"
                                                        @click="addSession">Add More
                                                </button>
                                            </div>
                                        </div>

                                        <div class="col-6 "></div>
                                        <div class="col-4 ">
                                            <button class="btn btn-outline-primary btn-xs btn-block mt-2 hv-cursor-pointer" type="submit">Save</button>
                                        </div>
                                    </div>
                                </form>

                                <table class="table mt-2" >
                                    <tr>
                                        <th>Sl</th>
                                        <th>Name</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                    @foreach($sessions as $session)
                                        <tr>
                                            <td>{{$session->id}}</td>
                                            <td>{{$session->name}}</td>
                                            <td><a href="{{route('session.edit',['id'=>$session->id])}}"><i class="fa fa-pencil"></i></a></td>
                                            <td><a href="{{route('session.destroy',['id'=>$session->id])}}" onclick="return chkDelete();"><i class="fa fa-trash"></i></a></td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
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

        function chkDelete() {
            return confirm('Are you sure you want to delete this  ?');
        }
    </script>

    <script src="https://unpkg.com/vue@2.5.9/dist/vue.js"></script>

    <script>
        let app = new Vue({
            el: '#app',
            data: {
                sessions: [{session_name: ""}],
                degrees: [{name: ""}],
                sessionData:[]
            },
            methods: {
                addSession: function () {
                    this.sessions.push({session_name: ""});
                },
                addDegree: function () {
                    this.degrees.push({name: ""});
                },
                submit: function () {
                    this.$refs.form.submit()
                },
                removeSession: function (row) {
                    let index = this.sessions.indexOf(row)
                    this.sessions.splice(index, 1);
                },
                removeDegree: function (degree) {
                    let index = this.degrees.indexOf(degree)
                    this.degrees.splice(index, 1);
                }
            }
        });

    </script>
@endsection

