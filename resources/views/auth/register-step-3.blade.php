@extends('layouts.master-auth')

@section('title', 'Register | Step-3')

@section ('content')

    <section class="font-1 mentor-wrapper py-6">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-8" id="app">
                    <h5>Hello, @if(isset(session('profile')['first_name'])) {{ ucfirst(session('profile')['first_name'])}} @endif</h5>
                    <h5>How you are willing to help?</h5>
                    <form class="text-left" method="post" action="{{route('register')}}">
                        {{csrf_field()}}
                        <div class="col-12 zinput zcheckbox">
                            <input id="cb6" name="willing_to_help[]" value="introduce_other_my_connections" type="checkbox">
                            <label for="cb6">Willing to introduce others to my connections</label>
                            <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16" style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                                <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16" style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                            </svg>
                            <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"></svg>
                        </div>

                        <div class="col-12 zinput zcheckbox">
                            <input id="cb7" name="willing_to_help[]" value="open_my_workplace" type="checkbox">
                            <label for="cb7">Willing to open doors at my workplace</label>
                            <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16" style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                            </svg>
                            <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"></svg>
                        </div>

                        <div class="col-12 zinput zcheckbox">
                            <input id="cb8" name="willing_to_help[]" value="ans_industry_specific_questions" type="checkbox">
                            <label for="cb8">Willing to answer industry specific questions</label>
                            <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16" style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                                <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16" style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                            </svg>
                            <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"></svg>
                        </div>

                        <div class="col-12 zinput zcheckbox" >
                            <input id="cb9" name="willing_to_help[]" value="willing_to_be_mentor" type="checkbox"  v-model="checked">
                            <label for="cb9">Willing to be a mentor</label>
                            <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16" style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                                <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16" style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                            </svg>
                            <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"></svg>
                        </div>


                        <div class="row">
                            <div class="col-10 ml-auto" v-if="checked">

                                <div class="row">
                                    <small>Please select the topics:</small>

                                    @foreach($mentorshipTopics as $mentorshipTopic)
                                        <div class="col-12 zinput zcheckbox">
                                            <input id="{{$mentorshipTopic->id}}" name="mentorship_topic[]" type="checkbox" value="{{$mentorshipTopic->id}}">
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
                                <input class="btn btn-primary" type="submit" value="Get Started">
                            </div>
                        </div>

                        <div class="zform-feedback mt-3"></div>
                    </form>
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </section>

@endsection

@section('scripts')

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