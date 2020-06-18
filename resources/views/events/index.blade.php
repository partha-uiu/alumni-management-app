@extends('layouts.master')

@section('title', 'Events')

@section('styles')

    <link href="{{asset('lib/semantic-ui-accordion/accordion.css')}}" rel="stylesheet">
    <link href="{{asset('lib/semantic-ui-dropdown/dropdown.css')}}" rel="stylesheet">
    <link href="{{asset('lib/semantic-ui-transition/transition.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.min.css"/>

@endsection

@section('content')

    @include('common.nav-section')

    <hr class="color-9 my-0">
    <section class="font-1 background-10" style="padding: 1.45rem 0;">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8">
                    <h5 class="text-center text-md-left">
                        All Events
                    </h5>
                </div>
                <div class="d-none d-md-block col-md-4">

                </div>
            </div>
        </div>
    </section>
    <hr class="color-9 my-0">

    <section class="font-1 py-2">
        <div class="container">
            <div class="row">
                <div class="col-8" id="app">
                    @if (Auth::user()->hasAnyRole('super-admin|admin|editor|faculty-stuff'))
                        <form class="background-11 py-2 px-2 mb-3" ref="form" action="{{route('events')}}" method="get">
                        <div class="form-group mb-0">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input"
                                               id="inlineRadio1"
                                               type="radio"
                                               name="status"
                                               value="all"
                                               @change="statusUpdate"
                                               v-model="selectedStatus"> All
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input"
                                               id="inlineRadio1"
                                               type="radio"
                                               name="status"
                                               value="pending"
                                               @change="statusUpdate"
                                               v-model="selectedStatus"> Pending
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input"
                                               id="inlineRadio2"
                                               type="radio"
                                               name="status"
                                               value="approved"
                                               @change="statusUpdate"
                                               @if(request('status')=='approved') checked @endif> Approved
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <label class="form-check-label d-inline">Select All
                                        <input class="mx-2 form-check-input"
                                               id="checkAll"
                                               type="checkbox"
                                               @click="selectAll"
                                               v-model="allSelected">
                                    </label>
                                    <select class="ui dropdown" v-model="approval">
                                        <option value="">Action</option>
                                        <option value="approve">Approve</option>
                                        <option value="disapprove">Disapprove</option>
                                        <option value="delete">Delete</option>
                                    </select>
                                    <span class="input-group-btn d-inline pl-2">
                                        <button class="btn btn-primary btn-sm hv-cursor-pointer" type="button" @click="batchAction">Go</button>
                                    </span>
                                </div>
                            </div>
                        </form>

                        @foreach($allEvents as $allEvent)
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="col p-0 mb-2 d-flex align-items-center">
                                        <div class="background-oxford color-white p-2  text-center fs-1 radius-primary lh-1">
                                            <div class="fs-1"> {{Carbon\Carbon::createFromFormat('Y-m-d', $allEvent->start_date)->format('d')}}</div>
                                            <div class="d-block"> {{Carbon\Carbon::createFromFormat('Y-m-d', $allEvent->start_date)->format('M')}}</div>

                                        </div>
                                        <h5 class="color-oxford d-inline ml-3">{{$allEvent->title}}</h5>

                                    </div>

                                    <p class="color-5 fs--1"> {{$allEvent->location}}</p>
                                    <div class="d-inline-block font-1 color-6">
                                        {{   Carbon\Carbon::createFromFormat('Y-m-d', $allEvent->start_date)->format('d M Y')}}
                                        {{   Carbon\Carbon::createFromFormat('H:i:s', $allEvent->start_time)->format('h:i a')}}
                                    </div>
                                </div>
                                <div class="col-4 mt-3 mt-md-0 align-self-center text-center">
                                    <a href="{{route('events.approve',['id'=>$allEvent->id])}}" onclick="return chkConfirm();"><span class="fa fa-check-circle mx-3"></span></a>
                                    <a href="{{route('events.destroy',['id'=>$allEvent->id])}}" onclick="return chkDelete();"><span class="fa fa-times-circle mx-3"></span></a>
                                    <a class="ml-3" href="{{route('events.edit',['id'=>$allEvent->id])}}"><i class="fa fa-pencil"></i></a>

                                    <label class="form-check-label d-inline pl-5">
                                        <input class="form-check-input" id="checkAll" @click="select" type="checkbox" v-model="eventIds" value="{{$allEvent->id}}">
                                    </label>
                                </div>
                                <div class="col-2 text-center">
                                    <a class="btn btn-outline-primary btn-xs" href="{{route('events.show',['id'=>$allEvent->id])}}" target="_blank"> View Details</a>
                                </div>
                                <div class="col-12">
                                    <hr class="color-9">
                                </div>
                            </div>
                        @endforeach

                        {{ $allEvents->appends(request()->input())->links() }}

                    @elseif (Auth::user()->hasRole('alumni|student'))

                        @foreach($approvedEvents as $approvedEvent)

                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="col p-0 mb-2 d-flex align-items-center">
                                        <div class="background-oxford color-white p-2  text-center font-1 radius-primary lh-1">
                                            <div class="fs-2"> {{Carbon\Carbon::createFromFormat('Y-m-d', $approvedEvent->start_date)->format('d')}}</div>
                                            <div class="d-block"> {{Carbon\Carbon::createFromFormat('Y-m-d', $approvedEvent->start_date)->format('M')}}</div>
                                        </div>
                                        <h5 class="color-oxford d-inline ml-3">{{$approvedEvent->title}}</h5>
                                    </div>
                                    <p class="color-5 fs--1"> {{$approvedEvent->location}}</p>
                                    <div class="d-inline-block font-1 color-6">
                                        {{   Carbon\Carbon::createFromFormat('Y-m-d', $approvedEvent->start_date)->format('d M Y')}}
                                        {{   Carbon\Carbon::createFromFormat('H:i:s', $approvedEvent->start_time)->format('h:i a')}}
                                    </div>

                                </div>
                                <div class="col-lg-4 text-center">
                                    <a class="btn btn-outline-primary btn-xs" href="{{route('events.show',['id'=>$approvedEvent->id])}}" target="_blank"> View Details</a>
                                </div>

                                <div class="col-12">
                                    <hr class="color-9">
                                </div>
                            </div>
                        @endforeach
                        {{ $approvedEvents->appends(request()->input())->links() }}
                    @endif
                </div>

                <div class="col-lg-4 mt-0">
                    <div class="row">
                        <div class="col-lg-12 px-0 mb-2">
                            <div class="background-oxford color-white p-3">
                                <p class="mb-0"><i class="fa fa-search mr-2" aria-hidden="true"></i>Search Events</p>
                            </div>
                            <form class="background-11 py-3 px-3" method="get" action="{{route('events')}}">
                                <div class="form-group mt-2">
                                    <input class="form-control background-white"
                                           type="text"
                                           name="q"
                                           placeholder="Search by keyword"
                                           value="@if(request('q')){{(request('q'))}}@endif">

                                    <input class="form-control background-white mt-2"
                                           type="text"
                                           id="eventDate"
                                           name="event_date"
                                           placeholder="Search by start date"
                                           value="@if(request('event_date')){{(request('event_date'))}}@endif">
                                </div>
                                <div class="text-right">
                                    <button class="btn btn-xs btn-outline-primary hv-cursor-pointer" type="submit">Search</button>
                                </div>
                            </form>
                            <div class="mx-3 mx-sm-0 mt-3">
                                <a class="btn btn-block btn-primary" href="{{route('events.create')}}">
                                    <i class="fa fa-plus-circle mr-2"></i>Create an event
                                </a>
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

@section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>

    <script>

        $(document).ready(function () {

            $('#eventDate').datepicker({
                format: 'dd-mm-yyyy',
                todayHighlight: true,
                orientation: 'bottom'
            })

        })
    </script>

    <script src="{{asset('lib/semantic-ui-accordion/accordion.js')}}"></script>
    <script src="{{asset('lib/semantic-ui-dropdown/dropdown.js')}}"></script>
    <script src="{{asset('lib/semantic-ui-transition/transition.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/vue@2.5.9/dist/vue.js"></script>

    <script>

        let app = new Vue({
            el: '#app',
            data: {
                selected: [],
                allSelected: false,
                eventIds: [],
                allEventIds:{{$allEvents->pluck('id')}},
                approval: '',
                selectedStatus: '<?php if (request('status') == 'pending') {
                    echo 'pending';
                } elseif (request('status') == 'approved') {
                    echo 'approved';
                } elseif (request('status') == 'all') {
                    echo 'all';
                } else {
                    echo 'all';
                }

                    ?>'
                ,
            },
            methods: {
                selectAll: function (e) {

                    this.eventIds = [];
                    if (e.target.checked) {
                        this.eventIds = this.allEventIds;
                    }
                    else {
                        this.eventIds = [];
                    }
                },
                select: function () {
                    this.allSelected = false;
                },
                batchAction: function () {

                    let ids = this.eventIds;
                    let action = this.approval;
                    let test = this.test;

                    window.location = "{{route('events.batch-action')}}?action=" + action + "&ids=" + ids.join();
                },
                statusUpdate: function () {

                    this.$refs.form.submit();

                },
                submitStatus: function () {

                }
            }
        });

        function chkDelete() {
            return confirm('Are you sure you want to delete this event ?');
        }

        function chkConfirm() {
            return confirm('Are you sure you want to approve this event ?');
        }
    </script>
@endsection

