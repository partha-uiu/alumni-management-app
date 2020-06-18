@extends('layouts.master-auth')

@section('title', 'Event | Add')

@section('content')

    @include('common.nav-section')

    <hr class="color-9 my-0">

    <section class="font-1 py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-12" id="app">
                    
                    
                    @if(session('success'))
                        @include('common.notifications')
                    @endif

                    <h5 class="mb-3">Create New Event</h5>
                    <div class="background-10 p-4">
                        <form method="post" action="{{route('events.store')}}">
                            {{csrf_field()}}
                            <input type="hidden" name="department_id" value="{{$department->id}}">
                            <input type="hidden" name="institution_id" value="{{$institution->id}}">
                            <div class="form-group row ">
                                <label for="visibility_status" class="col-sm-2 col-form-label col-form-label-sm">Event Type:<span class="req-red">*</span></label>
                                <div class="col-md-5 @if ($errors->has('event_type')) has-danger @endif">
                                    <select class="form-control hv-cursor-pointer" name="event_type" v-model="e_type">
                                        <option  selected value="">Select Event Type</option>

                                        <option value="0" >
                                            Public
                                        </option>
                                        <option value="1">
                                            Private
                                        </option>
                                    </select>
                                    @if ($errors->has('event_type'))
                                        <div class="form-control-feedback">{{ $errors->first('event_type') }}</div>
                                    @endif
                                </div>
                               
                            </div>

                            <div v-if="e_type === '1'">
                                <div class="form-group row">
                                    <label for="visibility_status" class="col-sm-2 col-form-label col-form-label-sm">Select Event Criteria:</label>
                                    <div class="col-md-5">
                                        <select class="form-control hv-cursor-pointer" name="visibility" v-model="private">
                                            <option disabled selected value="">Select Event Criteria</option>

                                            <option value="0" >
                                                Open for all
                                            </option>
                                            <option value="1">
                                                Invited only
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>    

                            <div v-if="private === '1'">
                                <div class="form-group row">
                                    <label class="typo__label col-sm-2 col-form-label col-form-label-sm">Session</label>
                                    <div class="col">
                                        <multiselect
                                            class="hv-cursor-pointer"
                                            v-model="selectedSession"
                                            :options="sessions"
                                            :multiple="true"
                                            :custom-label="customSession"
                                            track-by="id"
                                            label="id"
                                            @select="dispatchActionSession"
                                            :close-on-select="false"

                                        >
                                        </multiselect>
                                    </div>
                                    <div v-for="sessionId in selectedSession">
                                        <input type="hidden" name="eventSessions[]" :value='sessionId.id'>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="typo__label col-sm-2 col-form-label col-form-label-sm">Degree</label>
                                    <div class="col">
                                        <multiselect
                                            class="hv-cursor-pointer"
                                            v-model="selectedDegree"
                                            :options="degrees"
                                            :multiple="true"
                                            :custom-label="customDegree"
                                            track-by="id"
                                            label="id"
                                            @select="dispatchActionDegree"
                                            :close-on-select="false"

                                        >
                                        </multiselect>

                                    </div>
                                    <div v-for="degreeId in selectedDegree">
                                        <input type="hidden" name="eventDegrees[]" :value='degreeId.id'>
                                    </div>
                                </div>
                            </div>


                            @if (Auth::user()->hasAnyRole('alumni|student'))

                                <div class="form-group row">
                                    <label for="session_id" class="col-sm-2 col-form-label col-form-label-sm">Session:</label>
                                    <div class="col-md-5">
                                        <select class="form-control hv-cursor-pointer" name="session_id">
                                            <option disabled selected>Select Session</option>
                                            <option value="all">
                                                All
                                            </option>

                                            <option value="{{Auth::user()->profile->session_id}}">
                                                {{Auth::user()->profile->session->name}}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                            @elseif(Auth::user()->hasAnyRole('super-admin|admin'))
                                <div class="form-group row">
                                    <label for="session_id" class="col-sm-2 col-form-label col-form-label-sm">Session:</label>
                                    <div class="col-md-5">
                                        <select class="form-control hv-cursor-pointer" name="session_id">
                                            <option disabled selected>Select Session</option>
                                            @foreach($sessions as $session)
                                                <option value="{{$session->id}}">
                                                    {{$session->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group  row">
                                <label for="event_title" class="col-sm-2 col-form-label col-form-label-sm">Title: <span class="req-red">*</span></label>
                                <div class="col-md-10">
                                    <div class="form-group @if ($errors->has('title')) has-danger @endif">
                                        <input class="form-control"
                                               id="event_title"
                                               type="text"
                                               name="title"
                                               value="{{old('title')}}">
                                        @if ($errors->has('title'))
                                            <div class="form-control-feedback">{{ $errors->first('title') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="form-group  row">
                                <label for="description" class="col-md-2 col-form-label col-form-label-sm"> Description: <span class="req-red">*</span></label>
                                <div class="col-md-10">
                                    <div class="form-group  @if ($errors->has('description')) has-danger @endif">
                                        <textarea class="form-control"
                                                  name="description"
                                                  id="description"
                                                  rows="4">{{old('description') }}</textarea>
                                        @if ($errors->has('description'))
                                            <div class="form-control-feedback">{{ $errors->first('description') }}</div>
                                        @endif

                                    </div>
                                </div>
                            </div>


                            <div class="form-group  row">
                                <label for="start_date" class="col-sm-2 col-form-label col-form-label-sm">Start Date:<span class="req-red">*</span></label>
                                <div class="col-md-3">
                                    <div class="form-group date @if ($errors->has('start_date')) has-danger @endif">
                                        <input class="form-control"
                                               id="start_date"
                                               type="text"
                                               name="start_date"
                                               value="{{old('start_date')}}">
                                        @if ($errors->has('start_date'))
                                            <div class="form-control-feedback">{{ $errors->first('start_date') }}</div>
                                        @endif
                                    </div>
                                </div>


                                <label for="start_time" class="col-sm-2 col-form-label col-form-label-sm">Start Time: <span class="req-red">*</span></label>
                                <div class="col-md-3 @if ($errors->has('start_time')) has-danger @endif">
                                    <div class="input-group bootstrap-timepicker timepicker @if ($errors->has('start_time')) has-danger @endif">
                                        <input class="form-control"
                                               id="start_time"
                                               type="text"
                                               name="start_time"
                                               value="{{old('start_time')}}">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                    @if ($errors->has('start_time'))
                                        <div class="form-control-feedback">{{ $errors->first('start_time') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label for="end_date" class="col-sm-2 col-form-label col-form-label-sm">End Date: <span class="req-red">*</span></label>
                                <div class="col-md-3">
                                    <div class="form-group date @if ($errors->has('end_date')) has-danger @endif">
                                        <input class="form-control"
                                               id="end_date"
                                               type="text"
                                               name="end_date"
                                               value="{{old('end_date')}}">
                                        @if ($errors->has('end_date'))
                                            <div class="form-control-feedback">{{ $errors->first('end_date') }}</div>
                                        @endif
                                    </div>
                                </div>


                                <label for="end_time" class="col-sm-2 col-form-label col-form-label-sm">End Time: <span class="req-red">*</span></label>
                                <div class="col-md-3 @if ($errors->has('end_time')) has-danger @endif">
                                    <div class="input-group">
                                        <input class="form-control "
                                               id="end_time"
                                               type="text"
                                               name="end_time"
                                               value="{{old('end_time')}}">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>

                                    </div>
                                    @if ($errors->has('end_time'))
                                        <div class="form-control-feedback">{{ $errors->first('end_time') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label for="location" class="col-sm-2 col-form-label col-form-label-sm">Location:</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input class="form-control"
                                               id="location"
                                               type="text"
                                               name="location"
                                               value="{{old('location')}}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label for="link" class="col-sm-2 col-form-label col-form-label-sm">External Link:</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input class="form-control"
                                               id="link"
                                               type="text"
                                               name="link"
                                               value="{{old('link')}}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="need_registration" class="col-sm-2 col-form-label col-form-label-sm">Registration required:</label>
                                <div class="col-md-5">
                                    <select class="form-control hv-cursor-pointer" name="need_registration">
                                        <option disabled>Select</option>

                                        <option value="1">
                                            Yes
                                        </option>
                                        <option value="0" selected>
                                            No
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="is_featured" class="col-sm-2 col-form-label col-form-label-sm">Featured event:</label>
                                <div class="col-md-5">
                                    <select class="form-control hv-cursor-pointer" name="is_featured">
                                        <option disabled selected>Select</option>

                                        <option value="1">
                                            Yes
                                        </option>
                                        <option value="0" selected>
                                            No
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="row my-4">
                                <div class="col-12 col-md-3 offset-md-2">
                                    <button type="submit" class="btn btn-primary btn-block hv-cursor-pointer ">Save</button>
                                </div>
                                <div class="col-12 col-md-7 text-right pt-2">
                                    <span class="req-red small text-right">*</span>
                                    <small> Required Fields</small>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="zform-feedback mt-3"></div>
                </div>

                @include('events.partials.latestEvents',array('latestEvents'=>$latestEvents))

            </div>
        </div>
        <!--/.row-->
        <!--/.container-->
    </section>

@endsection

@section('styles')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.min.css"/>
    <link href="{{asset('css/wickedpicker.css')}}" rel="stylesheet">
    <link href="{{asset('css/right-scrollbar.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">

@endsection

@section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <script src="{{asset('js/wickedpicker.js')}}"></script>
    <script src="{{asset('unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
    <script src="https://unpkg.com/vue@2.5.9/dist/vue.js"></script>
    <script src="https://unpkg.com/vue-multiselect@2.1.0"></script>

    <script>

        $(document).ready(function () {
            CKEDITOR.replace('description');
            $('#start_date').datepicker({
                format: 'dd-mm-yyyy',
                todayHighlight: true
            })

            $('#end_date').datepicker({
                format: 'dd-mm-yyyy',
                todayHighlight: true
            })

            $('#start_time').wickedpicker();

            $('#end_time').wickedpicker();
        })

    </script>

    <script>
        var app = new Vue({
            components: {
                Multiselect: window.VueMultiselect.default
            },
            data() {
                return {
                    sessions: [],
                    degrees: [],
                    selectedSession: [],
                    selectedDegree: [],
                    private: '',
                    e_type :''
                }
            },
            methods: {
                customSession(session) {
                    return `${session.name}`
                },
                customDegree(degree) {
                    return `${degree.name}`
                },
                dispatchActionSession(actionName) {
                    console.log(actionName.name);
                    console.log(actionName.id);
                    if (actionName.name == "All") {
                        app.selectedSession.splice(0, app.selectedSession.length);
                      
                    }
                    else {
                        for(var i=0; i<app.selectedSession.length; i++){
                           if(app.selectedSession[i].name =="All") {
                                app.selectedSession.splice(i, 1);
                           }
                        } 
                    }
                    console.log(app.selectedSession);

                },
                 dispatchActionDegree(actionName) {
                    console.log(actionName.name);

                    if (actionName.name == "All") {
                        app.selectedDegree.splice(0, app.selectedDegree.length);
                      
                    }
                    else {
                        for(var i=0; i<app.selectedDegree.length; i++){
                            if(app.selectedDegree[i].name =="All") {
                                app.selectedDegree.splice(i, 1);
                            }
                        } 
                    }

                }
            }
        }).$mount('#app');

        var sessions = @json($sessions->toArray());
        console.log(sessions);
        if (sessions.length) {
            for (var i = 0; i < sessions.length; i++) {

                var newRow = {
                    id: sessions[i].id,
                    name: sessions[i].name,
                };
                app.sessions.push(newRow);
            }

        }

        var defaultRow = {
            id: "All", name: "All"
        };
        app.sessions.push(defaultRow);


        var degrees = @json($degrees->toArray());

        if (degrees.length) {
            for (var i = 0; i < degrees.length; i++) {

                var newRow = {
                    id: degrees[i].id,
                    name: degrees[i].name,
                };
                app.degrees.push(newRow);
            }
        }

        var defaultRow = {
            id: "All", name: "All"
        };

        app.degrees.push(defaultRow);

    </script>

    <style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

@endsection