@extends('layouts.master')

@section('title', 'Profile | Edit')

@section('content')

    @include('common.nav-section')
    <hr class="color-9 mt-0">

    <section class="font-1 py-3">
        <div class="container">
            <div class="text-center">
                @include('common.notifications')
            </div>

            <div class="row justify-content-center" id="app">
                <div class="col-lg-3 mb-2">
                    <div class="background-10 text-center pb-3">
                        <a href="#" data-lightbox="profile-pic">
                            <img class="img-thumbnail radius-primary mt-3" src="{{$profile->profile->profile_picture}}" width="200px">
                        </a>
                        <div class="text-center">
                            <form class="mt-3"
                                  ref="form"
                                  method="post"
                                  action="{{route('profile.edit',['id'=>$profile->id])}}"
                                  enctype="multipart/form-data"
                                  files="true">
                                {{csrf_field()}}
                                <input class="inputfile"
                                       id="file-1"
                                       name="profile_photo_url"
                                       type="file" name="file-1[]"
                                       @change="submit"
                                       data-multiple-caption="{count} files selected"
                                       multiple="">
                                <label class="btn btn-outline-primary" for="file-1"><span>Update Photo</span></label>
                            </form>
                        </div>
                        <p class="mb-0 mt-3 fs-0">{{$profile->first_name.' '.$profile->last_name}}</p>

                        <p class="mb-0 text-muted small mb-2">@if(isset($profile->profile->session->name)){{$profile->profile->session->name}} @endif</p>

                        @if( isset($profile->profile->position))  <p class="mb-0 small">{{$profile->profile->position}}</p>
                        <p class="mb-0 small mb-2"> {{$profile->profile->company_institute}} </p>@endif

                        <p class="mb-0 small">Lives in <strong>{{$profile->profile->dist_state.', '.$profile->profile->country->name}}</strong></p>
                        <hr class="color-9">
                        @if(!$profile->socialAccounts->count())
                            <div class="fs--1 fw-600">
                                <a class="btn btn-outline-primary" href="{{route('settings.password')}}">Change Password</a>
                            </div>
                            @else
                            <div class="fs--1 fw-600">
                                <a class="d-block mb-2" href="{{route('settings.password-create')}}">Update password for social account </a>
                                <small class="text-muted">If you create a password for your social account, you can login with both email and social account.In the time of login provide the email address  corresponding to your social account email.</small>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="col-md-9">
                    <h4 class="color-black mb-4 mt-4 mt-md-0">Update Profile</h4>

                    <div class="tabs edit-profile">
                        <div class="nav-bar alert-success p-2">
                            <div class="nav-bar-item  @if(session('basicInfo')) active @elseif( (!session('personalInfo')) && (!session('basicInfo')) && (!session('wHelp')) ) active @endif">Basic Info</div>
                            <div class="nav-bar-item @if(session('personalInfo'))  active @endif">Personal & Professional Info</div>
                            @if($profile->userType->name !="student")
                                <div class="nav-bar-item @if(session('wHelp'))  active @endif">Willing to help</div>
                            @endif
                            <a class="btn btn-outline-dark btn-xs ml-auto lh-7" href="{{route('profile',['id'=>$profile->id])}}">Back to profile</a>
                        </div>
                        <div class="tab-contents">
                            <div class="tab-content @if(session('basicInfo')) active @elseif( (!session('personalInfo')) && (!session('basicInfo')) && (!session('wHelp')) ) active @endif">
                                <form class="" method="post" action="{{route('profile.edit',['id'=>$profile->id])}}" enctype="multipart/form-data" files="true">
                                    {{csrf_field()}}
                                    <input type="hidden" name="basic_info" value="">
                                    <div class="row align-items-center  justify-content-center">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="first_name">First Name</label>
                                                <input class="form-control"
                                                       id="first_name"
                                                       type="text"
                                                       name="first_name"
                                                       placeholder="First name"
                                                       value="{{$profile->first_name}}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="last_name">Last Name</label>
                                                <input class="form-control"
                                                       id="last_name"
                                                       type="text" name="last_name"
                                                       placeholder="Last name"
                                                       value="{{$profile->last_name}}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input class="form-control"
                                                       id="email"
                                                       type="email"
                                                       name="email"
                                                       placeholder="Email"
                                                       value="{{$profile->email}}" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="address">Address</label>
                                                <textarea class="form-control"
                                                          id="address"
                                                          name="address"
                                                          rows="3"
                                                          placeholder="Address">{{$profile->profile->address or ''}}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="state_dist">State/District</label>
                                                <input class="form-control"
                                                       id="state_dist"
                                                       type=""
                                                       name="dist_state"
                                                       value="{{$profile->profile->dist_state}}"
                                                       placeholder="State/Dist" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="country">Country</label>
                                                <select id="country" class="form-control btn-cursor-pointer" name="country_id">
                                                    <option disabled selected>Select Country</option>
                                                    @foreach($countries as $country)
                                                        <option value="{{$country->id}}"
                                                                @if($profile->profile->country_id==$country->id)
                                                                selected @endif> {{$country->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="affiliation">Affiliation</label>
                                                <select id="affiliation" class="form-control btn-cursor-pointer" name="user_type_id">
                                                    <option disabled selected>Select Affiliation</option>
                                                    @foreach($userTypes as $userType)
                                                        <option value="{{$userType->id}}"
                                                                @if($profile->user_type_id==$userType->id) selected @endif>
                                                            {{ucfirst($userType->name)}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="session">Session</label>
                                                <select id="session" class="form-control btn-cursor-pointer" name="session_id">
                                                    <option disabled selected>Select Session</option>
                                                    @foreach($sessions as $session)
                                                        <option value="{{$session->id or ''}}"
                                                                @if($profile->profile->session_id==$session->id) selected @endif>
                                                            {{$session->name or ''}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="summary">Summary</label>
                                                <textarea class="form-control"
                                                          name="summary"
                                                          id="summary"
                                                          rows="3">{{$profile->profile->summary}}</textarea>
                                            </div>
                                        </div>

                                    </div>
                                    <button type="submit" class="mt-2 btn btn-outline-primary">Save changes</button>
                                </form>
                            </div>

                            <div class="tab-content @if(session('personalInfo'))  active @endif">
                                <form method="post" action="{{route('profile.edit',['id'=>$profile->id])}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="personal_info">
                                    <div class="background-11 p-3">
                                        <div class="row" v-for="(row,index) in rows">
                                            <div class="col-md-12 small text-left mt-2 mb-2 font-weight-bold">Educational Backgrounds</div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input class="form-control background-white"
                                                           type="text"
                                                           name="field_of_study[]"
                                                           v-model="row.field_of_study"
                                                           placeholder="Field of study">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <select class="form-control btn-cursor-pointer  background-white"
                                                            v-model="row.degree_id" name="degree_id[]">
                                                        <option value="" disabled selected>Select Degree</option>

                                                        @foreach($degrees as $degree)
                                                            <option value="{{$degree->id}}">
                                                                {{$degree->name}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input class="form-control  background-white"
                                                           type="text" name="passing_year[]"
                                                           v-model="row.passing_year"
                                                           placeholder="Passing Year">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input class="form-control  background-white"
                                                           type="text" name="institution[]"
                                                           v-model="row.institution"
                                                           placeholder="Institution">
                                                </div>
                                            </div>

                                            <div class="col-md-12 text-right" v-if="index >0">
                                                <div class="form-group">
                                                    <button class="btn btn-danger btn-xs hv-cursor-pointer"
                                                            type="button"
                                                            @click="removeRow(row)"> Remove
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 text-right background-11">
                                                <div class="form-group">
                                                    <button class="btn btn-primary btn-xs hv-cursor-pointer"
                                                            type="button"
                                                            @click="addRow"> Add More
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="background-11 p-3 mt-3">

                                        <div class="row">
                                            <div class="col-md-12 small text-left mb-2 font-weight-bold">Professional Details</div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input class="form-control background-white"
                                                           type="text"
                                                           value="{{$profile->profile->company_institute}}"
                                                           name="company_institution"
                                                           placeholder="Company/Institution">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input class="form-control background-white"
                                                           type="text"
                                                           name="position"
                                                           placeholder="Position"
                                                           value="{{$profile->profile->position}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" v-for="(row,index) in works">
                                            <div class="col-md-12 small text-left mb-2 font-weight-bold">Work Experience</div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input class="form-control background-white"
                                                           type="text"
                                                           value=""
                                                           name="company_name[]"
                                                           v-model="row.company_name"
                                                           placeholder="Company">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input class="form-control background-white"
                                                           type="text"
                                                           name="job_title[]"
                                                           v-model="row.job_title"
                                                           placeholder="Position"
                                                           value="">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input class="form-control background-white"
                                                           type="text"
                                                           name="duration[]"
                                                           v-model="row.duration"
                                                           placeholder="Timeline"
                                                           value="">
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-right" v-if="index >0">
                                                <div class="form-group">
                                                    <button class="btn btn-danger btn-xs hv-cursor-pointer"
                                                            type="button"
                                                            @click="removeRowWork(row)"> Remove
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-right background-11">
                                                <div class="form-group">
                                                    <button class="btn btn-primary btn-xs hv-cursor-pointer"
                                                            type="button"
                                                            @click="addRowWork"> Add More
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="background-11 p-3 mt-3">
                                        <div class="row">
                                            <div class="col-md-12 small text-left mb-2  font-weight-bold">Personal Details</div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <select class="form-control btn-cursor-pointer  background-white" name="blood_group">
                                                        <option value="" disabled selected>Select Blood Group</option>

                                                        @foreach(['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $bloodGroup)
                                                            <option @if($profile->profile->blood_group==$bloodGroup) selected @endif
                                                            value="{{$bloodGroup}}">{{$bloodGroup}}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input class="form-control  background-white"
                                                           id="dob"
                                                           type="text"
                                                           name="dob"
                                                           value="@if(isset($profile->profile->dob)) {{Carbon\Carbon::createFromFormat('Y-m-d', $profile->profile->dob)->format('d-m-Y')}} @endif"
                                                           placeholder="Date of Birth">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input class="form-control  background-white"
                                                           type="text"
                                                           name="contact_no"
                                                           value="{{$profile->profile->contact_no}}"
                                                           placeholder="Contact Number">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input class="form-control  background-white"
                                                           type="text"
                                                           name="registration_number"
                                                           value="{{$profile->profile->registration_number}}"
                                                           placeholder="Registration/Unique ID">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 text-left">
                                                <input class="btn btn-outline-primary"
                                                       type="submit"
                                                       name="submit"
                                                       value="Save Changes">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="zform-feedback mt-3"></div>
                                </form>
                            </div>
                            
                            <div class="tab-content  @if(session('wHelp'))  active @endif">
                                <form class="text-left" method="post" action="{{route('profile.edit',['id'=>$profile->id])}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="user_meta">

                                    <div class="col-12 zinput zcheckbox">
                                        <input id="cb6"
                                               name="willing_to_help[]"
                                               value="introduce_other_my_connections"
                                               @if(in_array('introduce_other_my_connections',$userMetas)) checked @endif
                                               type="checkbox">
                                        <label for="cb6">Willing to introduce others to my connections</label>
                                        <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16" style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                                            <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16" style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                                        </svg>
                                        <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"></svg>
                                    </div>

                                    <div class="col-12 zinput zcheckbox">
                                        <input id="cb7" name="willing_to_help[]"
                                               value="open_my_workplace"
                                               @if(in_array('open_my_workplace',$userMetas)) checked @endif
                                               type="checkbox">
                                        <label for="cb7">Willing to open doors at my workplace</label>
                                        <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16" style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                                        </svg>
                                        <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"></svg>
                                    </div>

                                    <div class="col-12 zinput zcheckbox">
                                        <input id="cb8"
                                               name="willing_to_help[]"
                                               value="ans_industry_specific_questions"
                                               @if(in_array('ans_industry_specific_questions',$userMetas))checked @endif
                                               type="checkbox">
                                        <label for="cb8">Willing to answer industry specific questions</label>
                                        <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16" style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                                            <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16" style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                                        </svg>
                                        <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"></svg>
                                    </div>

                                    <div class="col-12 zinput zcheckbox">
                                        <input id="cb9"
                                               name="willing_to_help[]"
                                               value="willing_to_be_mentor"
                                               type="checkbox"
                                               v-model="checked">
                                        <label for="cb9">Willing to be a mentor</label>
                                        <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16" style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                                            <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16" style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                                        </svg>
                                        <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"></svg>
                                    </div>


                                    <div class="row">
                                        <div class="col-10 ml-auto" v-if="checked">
                                            <div class="">
                                                <small>Please select the topics:</small>

                                                @foreach($mentorshipTopics as $mentorshipTopic)
                                                    <div class="col-12 zinput zcheckbox">
                                                        <input id="{{$mentorshipTopic->id}}"
                                                               name="mentorship_topic[]"
                                                               type="checkbox"
                                                               value="{{$mentorshipTopic->id}}"
                                                               @if(in_array($mentorshipTopic->id,$selectedMentorshipTopics))checked
                                                                @endif>
                                                        <label for="{{$mentorshipTopic->id}}">{{$mentorshipTopic->title}}</label>
                                                        <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16" style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                                                            <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16" style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                                                        </svg>
                                                        <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"></svg>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>

                                        <div class="col-12 text-left mt-4">
                                            <input class="btn btn-outline-primary" type="submit" value="Save Changes">
                                        </div>
                                    </div>
                                    <div class="zform-feedback mt-3"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </section>

@endsection


@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.min.css"/>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>

    <script src="https://unpkg.com/vue@2.5.9/dist/vue.js"></script>

    <script>
        let app = new Vue({
            el: '#app',
            data: {
                rows: [],
                checked: {{ in_array('willing_to_be_mentor', $userMetas) ? 'true' : 'false' }},
                works: []
            },
            methods: {
                addRow: function () {
                    this.rows.push({field_of_study: "", degree_id: "", passing_year: "", institution: ""});
                },
                addRowWork: function () {
                    this.works.push({company_name: "", job_title: "", duration: ""});
                },
                submit: function () {
                    this.$refs.form.submit()
                },

                removeRow: function (row) {
                    let index = this.rows.indexOf(row)
                    this.rows.splice(index, 1);
                },
                removeRowWork: function (row) {
                    let index = this.works.indexOf(row)
                    this.works.splice(index, 1);
                }
            }

        });

        var educationalDetails = @json($educationalDetails->toArray());
        if (educationalDetails.length) {
            for (var i = 0; i < educationalDetails.length; i++) {
                var newRow = {
                    field_of_study: educationalDetails[i].field_of_study,
                    degree_id: educationalDetails[i].degree_id,
                    passing_year: educationalDetails[i].passing_year,
                    institution: educationalDetails[i].institution
                };
                app.rows.push(newRow);
            }
        }

        var defaultRow = {
            field_of_study: "", degree_id: "", passing_year: "", institution: ""
        };
        app.rows.push(defaultRow);

        var workDetails = @json($workDetails->toArray());
        if (workDetails.length) {
            for (var i = 0; i < workDetails.length; i++) {
                var newRowWork = {
                    company_name: workDetails[i].company_name,
                    job_title: workDetails[i].job_title,
                    duration: workDetails[i].duration,
                };
                app.works.push(newRowWork);
            }
        }

        var defaultRowWork = {
            company_name: "", job_title: "", duration: ""
        };
        app.works.push(defaultRowWork);

    </script>

    <script>

        $('#dob').datepicker({
            format: 'dd-mm-yyyy',
            startView: 2,
            todayHighlight: true
        })
        
    </script>

@endsection