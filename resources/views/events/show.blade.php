@extends('layouts.master')

@section('title', 'Event | '.$event->title)

@section('content')

@include('common.nav-section')

<hr class="color-9 my-0">
@include('common.notifications')
<section class="font-1 py-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 pb-4">
                @include('feed.partials.alumni_feed_categories', ['active' => 'event'])
            </div>
            <div class="col-lg-9 mb-4" id="app">


                <div class="tabs events-tab">
                    <div class="nav-bar alert-success py-2">
                        <div class="nav-bar-item active">Event Details</div>
                       
                        @if($checkEventStatus && $checkEventStatus->need_registration==1)
                            @if (Auth::user()->hasAnyRole('admin|super-admin') && ($checkInvitees))
                                <div class="nav-bar-item">Participants</div>
                            @elseif (Auth::user()->hasAnyRole('alumni|student') && ($alreadyRegistered) && ($checkInvitees))
                                <div class="nav-bar-item">Participants</div>
                            @endif
                       
                            @if (Auth::user()->hasAnyRole('admin|super-admin') && (count($allInvitees)))
                                <div class="nav-bar-item">Requested Participants</div>
                            @endif
                        @endif
                    </div>
                    <div class="tab-contents">
                        
                        <div class="tab-content active">
                            <h4 class="mb-2">{{$event->title}}</h4>
                            <small class="color-5"><i class="fa fa-calendar"></i> {{$event->created_at->format('d M Y h:i A') }}</small>
                            <div class="my-4">{!! $event->description !!}</div>
                            <table class="table my-4">
                                <tbody>
                                    <tr>
                                        <td>Start Date Time:</td>
                                        <td>{{Carbon\Carbon::createFromFormat('Y-m-d', $event->start_date)->format('d M Y')}} {{Carbon\Carbon::createFromFormat('H:i:s', $event->start_time)->format('h:i A')}}</td>
                                    </tr>
                                    <tr>
                                        <td>End Date Time:</td>
                                        <td>{{Carbon\Carbon::createFromFormat('Y-m-d', $event->end_date)->format('d M Y')}} {{Carbon\Carbon::createFromFormat('H:i:s', $event->end_time)->format('h:i A')}}</td>
                                    </tr>
                                    <tr>
                                        <td>Location:</td>
                                        <td>{{$event->location or 'N/A'}}</td>
                                    </tr>
                                    <tr>
                                        <td>Link:</td>
                                        <td>
                                            @if($event->link)
                                                <a href="{{$event->link}}">{{$event->link}}</a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="my-3">
                                <a href="{{url()->previous()}}" class="btn btn-outline-dark"><i class="fa fa-angle-left"></i> Go Back</a>

                                @if (!(Auth::user()->hasAnyRole('admin|super-admin') ) && !($alreadyRegistered) && ($needRegistration))
                                    <a href="{{route('event.register',['id'=>$event->id])}}" class="btn btn-outline-primary"> Register for this event</a>
                                @else
                                    @if (Auth::user()->hasAnyRole('alumni|student') && ($alreadyRegistered))
                                        @if($alreadyRegistered->status==0)
                                           <p class="d-inline-flex color-primary ml-3"> You request is pending.</p>
                                        @else
                                            <p class="d-inline-flex color-primary ml-3">You are already registered !</p>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>


                        @if((Auth::user()->hasAnyRole('alumni|student') && ($alreadyRegistered) && ($checkInvitees)||(Auth::user()->hasAnyRole('admin|super-admin') && ($checkInvitees)))&&($checkEventStatus && $checkEventStatus->need_registration==1))
                            <div class="tab-content">
                                <div class="row">
                                    @foreach( $inviteesUsers as  $inviteesUser)
                                        <div class="col-6 col-md-3">
                                            <div class="card">
                                                <img class="card-img-top" src="{{$inviteesUser->user->profile->profile_picture}}" alt="{{$inviteesUser->user->first_name. ' '.$inviteesUser->user->last_name}}">
                                                <div class="card-block p-2">
                                                    <h6 class="card-title text-center lh-4">{{$inviteesUser->user->first_name. ' '.$inviteesUser->user->last_name}}</h6>
                                                    <p class="card-text text-center">{{$inviteesUser->user->profile->session->name or 'N/A'}}</p>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach
                                </div>
                            </div>
                        @endif


                        <div class="tab-content">
                            <div class="background-11">
                                <div class="row py-2 mb-3 align-items-center">
                                    <div class="col">
                                        <div class="form-check form-check-inline ml-3">
                                            <input
                                                class="mx-2 form-check-input"
                                               id="checkAll"
                                               type="checkbox"
                                               @click="selectAll"
                                               v-model="allSelected">
                                            <label class="form-check-label ml-2"> Select All</label>
                                        </div>
                                    </div>
                                    <div class="col text-right">
                                        <select class="ui dropdown" v-model="approval">
                                            <option value="">Action</option>
                                            <option value="approve">Approve</option>
                                            <option value="disapprove">Disapprove</option>
                                        </select>
                                        <button class="btn btn-outline-primary btx-xs" type="button" @click="batchAction">Go</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Select</th>
                                            <th>Name</th>
                                            <th>Session</th>
                                            <th>Degree</th>
                                            <th>Approve</th>
                                        </tr>
                                    </thead>
                                    @foreach($allInvitees as $invitee)
                                        <tr>
                                            <td>
                                                <label class="form-check-label">
                                                    <input class="form-check-input" id="checkSingle" @click="select" type="checkbox" v-model="eventIds" value="{{$invitee->id}}">
                                                </label>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img class="rounded-circle" width="30" height="30" src="{{$invitee->user->profile->profile_picture}}"/>
                                                    <div class="ml-2 text-nowrap">{{$invitee->user->first_name. ' '.$invitee->user->last_name}}</div>
                                                </div>
                                            </td>
                                            <td class="text-nowrap">{{$invitee->user->profile->session->name or 'N/A'}}</td>
                                            <td class="text-nowrap">{{'N/A'}}</td>
                                            <td>
                                                <button @click="approve({{$invitee->id}})" class="btn btn-xs btn-outline-dark hv-cursor-pointer">
                                                    <i class="fa fa-check"></i> Approve
                                                </button>
                                            </td>

                                        </tr>
                                    @endforeach
                                </table>            
                            </div>        
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@section('styles')
    <link href="{{asset('css/right-scrollbar.css')}}" rel="stylesheet">
    <link href="{{asset('lib/semantic-ui-accordion/accordion.css')}}" rel="stylesheet">
    <link href="{{asset('lib/semantic-ui-dropdown/dropdown.css')}}" rel="stylesheet">
    <link href="{{asset('lib/semantic-ui-transition/transition.css')}}" rel="stylesheet">

    <style>
        .table td {
            padding: 0.8rem 1.5rem;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/vue@2.5.9/dist/vue.js"></script>

    <script>
        let app = new Vue({
            el: '#app',
            data: {
                rows: [],
                checked: [],
                works: [],
                eventIds: [],
                allSelected:false,
                allEventIds:{{$allInvitees->pluck('id')}},
                approval: '',
               
            },
            methods: {
                    approve: function (id) {
                        //return confirm("Are you sure?");
                        axios.post('/approve-registered-event', {
                            data: id
                        })
                            .then(function (response) {
                               alert('Invitee has been approved');
                               window.location.reload();
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                },
                    deleteInvitee: function (id) {
                        axios.post('/delete-registered-event', {
                            data: id
                        })
                            .then(function (response) {
                                alert('Invitee has benn deleted');
                                window.location.reload();
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                },
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
                      

                        window.location = "{{route('re.batch-action')}}?action=" + action + "&ids=" + ids.join();
                },
            }
        });

      


    </script>
    <script src="{{asset('lib/semantic-ui-accordion/accordion.js')}}"></script>
    <script src="{{asset('lib/semantic-ui-dropdown/dropdown.js')}}"></script>
    <script src="{{asset('lib/semantic-ui-transition/transition.js')}}"></script>


@endsection

